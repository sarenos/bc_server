<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';
require_once LAYERS_DIR . '/User/user.php';

class Friends extends EntityWithDB
{
    private $_User, $_user1, $_user2;
    private $_key_fields = array('user1', 'user2');
    private $_is_from_user1;
    /////////////////////////////////////////////////////////////////////////////
    
    public function &get_all_fields_instances()
    {
        $result['user1']            = new FieldInt();
        $result['user2']            = new FieldInt();
        $result['status']           = new FieldInt();
        $result['dt_create']        = new FieldDateTime();
        $result['dt_status']        = new FieldDateTime();
        
        $this->DBHandler->no_auto_increment_primary();
        
        return $result;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function create_child_objects()
    {
        $this-> create_standart_db_handler('bc_friends');
        $this-> create_tuple();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
        $this->set_per_page(PER_PAGE_FRIENDS);
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function set_users($user1, $user2)
    {
        $this->_User->check_user_id_isset($user1, 1);
        $this->_User->check_user_id_isset($user2, 2);
        $this->_user1 = $this->_get_user1($user1, $user2);
        $this->_user2 = $this->_get_user2($user1, $user2);
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_user1($user1, $user2)
    {
        if ($user1 < $user2)
        {
            return $user1;
        }
        return $user2;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_user2($user1, $user2)
    {
        if ($user1 < $user2)
        {
            return $user2;
        }
        return $user1;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function check_users_identical()
    {
        if ($this->_user1 == $this->_user2)
        {
            throw new ExceptionProcessing(36);
        }
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function set_is_from_user1($is_from_user1)
    {
        $this->_is_from_user1 = $is_from_user1;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_positive_status()
    {
        if ($this->_is_from_user1)
        {
            return 1;
        }
        return 2;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function set_user1($user1)
    {
        $this->_User->check_user_id_isset($user1, 0);
        $this->_user1 = $user1;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function check_is_friends()
    {
        if ($this->_is_friends())
        {
            throw new ExceptionProcessing(32);
            //return $this->_return_err('They had already sent query!');
        }
    }
    /////////////////////////////////////////////////////////////////////////////

    public function add_invite()
    {
        $this->Fields['user1']->set($this->_user1);
        $this->Fields['user2']->set($this->_user2);
        $this->Fields['status']->set(1); //* $this->_get_positive_status());
        $this->Fields['dt_create']->now();
        $this->DBHandler->insert();
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _is_friends()
    {
        $this->Fields['user1']->set($this->_user1);
        $this->Fields['user2']->set($this->_user2);
        $this->load_by_fields_list($this->_key_fields);
        return null != $this->Fields['dt_create']->get();
    }
    /////////////////////////////////////////////////////////////////////////////

    /*private function _return_err($message)
    {
        return array(
                'status'        => 2,
                'statusMsg'     => $message,
                'status'        => $this->_get_status()
        );
    }*/
    /////////////////////////////////////////////////////////////////////////////

    private function _get_status()
    {
        return (int)@$this->Fields['status']->get();
    }
    /////////////////////////////////////////////////////////////////////////////

    public function confirm()
    {
        return $this->set_new_status_friends(1);
    }
    /////////////////////////////////////////////////////////////////////////////

    public function reject()
    {
        $this->DBHandler->delete_by_fields_list($this->_key_fields);
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function check_users_for_confirm_reject()
    {
        if (!$this->_is_friends())
        {
            throw new ExceptionProcessing(33);
            //return $this->_return_err("They didn't send queries!");
        }
        if ($this->_get_status() * -1 != $this->_get_positive_status())
        {
            throw new ExceptionProcessing(34);
            //return $this->_return_err("User doesn't have status invite!");
        }
    }
    /////////////////////////////////////////////////////////////////////////////

    private function set_new_status_friends($new_status)
    {
        $this->Fields['status']->set($new_status);
        $this->Fields['dt_status']->now();
        $this->DBHandler->update_by_fields_list($this->_key_fields);
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function get_list()
    {
        return array_merge(
                    $this->_load_by_user(1, 2)
                );
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _load_by_user($num_user1, $num_user2)
    {
        $this->DBHandler->db->exec_query(
                "SELECT fr.user$num_user1 AS user_id, " . User::SQL_USER_DATA
                . ", loc.latitude AS lat, loc.longitude AS lng,"
                . "fr.status, " . $this->_User->SQL_FILTER_ONLINE
                . " FROM `bc_locations` AS loc, `bc_users_info`"
                . " JOIN (SELECT * FROM `bc_friends` WHERE user$num_user2 = '".$this->_user1."') AS fr"
                . " ON `bc_users_info`.user_id = fr.user$num_user1 "
                . "WHERE `bc_users_info`.user_id = loc.user_id"
                . $this->get_limit_part()
        );
        $res_rec = array();
        foreach ($this->DBHandler->db->get_all_data() as $record)
        {
            if (($record['status'] == -2 && $num_user2 == 1)
                    || ($record['status'] == -1 && $num_user2 == 2)
                    || $record['status'] > 0)
            {
                $record['isOnline'] = $record['isOnline'] ? true : false;
                $res_rec[] = array_merge(
                                $record,
                                array(
                                    'friend'    => $this->_is_friend($record['status'])
                                ));
            }
        }
        return $res_rec;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _is_friend($status)
    {
        // true - friend; false - request to friend, delete
        return ($status == 1) ? 1 : 0;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function delete()
    {
        if (!$this->_is_friends() || $this->_get_status() != 1)
        {
            throw new ExceptionProcessing(35);
            //return $this->_return_err('They are not friends!');
        }
        //$this->DBHandler->delete_by_fields_list($this->_key_fields);
        $this->set_new_status_friends(2 + $this->_get_positive_status());
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function get_users_status($user, $user_get_status)
    {
        $this->set_users($user, $user_get_status);
        $this->set_is_from_user1($user > $user_get_status);
        return $this->status_friend();
    }
    /////////////////////////////////////////////////////////////////////////////

    public function status_friend()
    {
        if ($this->_is_friends()
                && ($this->_get_status() >= 0
                    || ($this->_get_status() < 0 && $this->_get_status() * -1 == $this->_get_positive_status())
                ))
        {
            return $this->_get_msg_status_friend($this->_get_status() >= 0 ? 1 : 0);
        }
        return $this->_get_msg_status_friend(-1);
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _get_msg_status_friend($status)
    {
        return array(
                'friend' => $status
        );
    }
    /////////////////////////////////////////////////////////////////////////////

    public function was_invitation()
    {
        return array('result' =>
                        ($this->_is_friends()
                            && ($this->_get_status() < 0 && $this->_get_status() * -1 == $this->_get_positive_status())));
    }
    /////////////////////////////////////////////////////////////////////////////

    public function get_friends_info($user_id, $show_offline)
    {
        $this->DBHandler->db->exec_query(
            "SELECT user_id, nick, age, sex, photo, lat, lng, isOnline, 1 AS friend
            FROM (
                SELECT us_info.*, latitude AS lat, longitude AS lng,
                    " . $this->_User->SQL_FILTER_ONLINE . "
                FROM `bc_locations` AS loc,
                        (SELECT `user2` AS `friends`
                        FROM `bc_top`
                        WHERE `user1` = '$user_id')
                 `tmp_friends`
                JOIN `bc_users_info` AS us_info
                    ON us_info.user_id = friends
                WHERE us_info.user_id = loc.user_id
            ) tmp_not_online
            WHERE " . $this->_User->get_sql_for_filter_show_offline($show_offline)
        );
        return $this->DBHandler->db->get_all_data();
    }
    /////////////////////////////////////////////////////////////////////////////

    /* TODO: remove */
    public function is_user_online($user_id)
    {
        $filter_res = false;
        $this->DBHandler->db->exec_query(
                "SELECT " . $this->_User->SQL_FILTER_ONLINE . " FROM `bc_locations` AS loc WHERE user_id='$user_id'"
        );
        foreach ($this->DBHandler->db->get_all_data() as $filter) {
            $filter_res = $filter['isOnline'] ? true : false;
        }
        return $filter_res;
    }
    /////////////////////////////////////////////////////////////////////////////
}