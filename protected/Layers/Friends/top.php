<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';
require_once LAYERS_DIR . '/User/user.php';

class Top extends EntityWithDB
{
    private $_User, $_user1, $_user2;
    private $_key_fields = array('user1', 'user2');
    /////////////////////////////////////////////////////////////////////////////
    
    public function &get_all_fields_instances()
    {
        $result['user1']            = new FieldInt();
        $result['user2']            = new FieldInt();
        $result['dt_create']        = new FieldDateTime();
        
        $this->DBHandler->no_auto_increment_primary();
        
        return $result;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function create_child_objects()
    {
        $this-> create_standart_db_handler('bc_top');
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
        $this->_user1 = $user1;
        $this->_user2 = $user2;
        return $this;
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
    
    public function set_user1($user1)
    {
        $this->_User->check_user_id_isset($user1, 0);
        $this->_user1 = $user1;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function check_is_in_top()
    {
        if ($this->_is_in_top())
        {
            throw new ExceptionProcessing(50);
        }
    }
    /////////////////////////////////////////////////////////////////////////////

    public function add_in_top()
    {
        $this->Fields['user1']->set($this->_user1);
        $this->Fields['user2']->set($this->_user2);
        $this->Fields['dt_create']->now();
        $this->DBHandler->insert();
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _is_in_top()
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
        return $this->_load_by_user();
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _load_by_user()
    {
        $this->DBHandler->db->exec_query(
                "SELECT top.user2 AS user_id, " . User::SQL_USER_DATA
                . ", loc.latitude AS lat, loc.longitude AS lng,"
                . $this->_User->SQL_FILTER_ONLINE . ", 1 AS top
                FROM `bc_locations` AS loc, `bc_users_info`
                JOIN (
                    SELECT * FROM `bc_top` WHERE user1 = '".$this->_user1."'
                ) AS top
                ON `bc_users_info`.user_id = top.user2
                WHERE `bc_users_info`.user_id = loc.user_id"
                . $this->get_limit_part()
        );
        $res_rec = array();
        foreach ($this->DBHandler->db->get_all_data() as $record)
        {
            $record['isOnline'] = $record['isOnline'] ? true : false;
            $res_rec[] = $record;
        }
        return $res_rec;
    }
    /////////////////////////////////////////////////////////////////////////////

    /*private function _is_friend($status)
    {
        // true - friend; false - request to friend, delete
        return ($status == 1) ? 1 : 0;
    }*/
    /////////////////////////////////////////////////////////////////////////////

    public function delete()
    {
        if (!$this->_is_in_top())
        {
            throw new ExceptionProcessing(51);
        }
        $this->DBHandler->delete_by_fields_list($this->_key_fields);
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function get_users_status($user, $user_get_status)
    {
        $this->set_users($user, $user_get_status);
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

    public function get_top_info($user_id, $show_offline)
    {
        $this->DBHandler->db->exec_query(
            "SELECT user_id, nick, age, sex, photo, lat, lng, isOnline, 1 AS top
            FROM (
                SELECT us_info.*, latitude AS lat, longitude AS lng,
                    " . $this->_User->SQL_FILTER_ONLINE . "
                FROM `bc_locations` AS loc,
                    (SELECT `user2` AS user_top
                    FROM `bc_top`
                    WHERE `bc_top`.user1 = '$user_id'
                    ) `tmp_top`
                JOIN `bc_users_info` AS us_info
                    ON us_info.user_id = user_top
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