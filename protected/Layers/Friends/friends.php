<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';

class Friends extends EntityWithDB
{
    private $_user1, $_user2;
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
    
    public function set_users($user1, $user2)
    {
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
        $this->_user1 = $user1;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function add_invite()
    {
        if ($this->_is_friends())
        {
            return $this->_return_err('They had already sent query!');
        }
        $this->Fields['user1']->set($this->_user1);
        $this->Fields['user2']->set($this->_user2);
        $this->Fields['status']->set(-1 * $this->_get_positive_status());
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

    private function _return_err($message)
    {
        return array(
                'statusCode'    => 2,
                'statusMessage' => $message,
                'status'        => $this->_get_status()
        );
    }
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
        if (!$this->_is_friends())
        {
            return $this->_return_err("They didn't send queries!");
        }
        if ($this->_get_status() * -1 != $this->_get_positive_status())
        {
            return $this->_return_err("User doesn't have status invite!");
        }
        $this->DBHandler->delete_by_fields_list($this->_key_fields);
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function set_new_status_friends($new_status)
    {
        if (!$this->_is_friends())
        {
            return $this->_return_err("They didn't send queries!");
        }
        if ($this->_get_status() * -1 != $this->_get_positive_status())
        {
            return $this->_return_err("User doesn't have status invite!");
        }
        $this->Fields['status']->set($new_status);
        $this->Fields['dt_status']->now();
        $this->DBHandler->update_by_fields_list($this->_key_fields);
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function get_list()
    {
        return array_merge(
                    $this->_load_by_user('user1', 'user2'),
                    $this->_load_by_user('user2', 'user1')
                );
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _load_by_user($field_query, $field_res)
    {
        $this->DBHandler->db->exec_query(
                "SELECT * FROM `bc_friends` WHERE `$field_query` = '".$this->_user1."'"
        );
        $res_rec = array();
        foreach ($this->DBHandler->db->get_all_data() as $record)
        {
            if (($record['status'] != -2 && $field_query != 'user1')
                    || ($record['status'] != -1 && $field_query != 'user2')
                    || $record['status'] >= 0)
            {
                $res_rec[] = array(
                                'user_id'   => $record[$field_res],
                                'friend'    => $this->_is_friend($record['status'])
                            );
            }
        }
        return $res_rec;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _is_friend($status)
    {
        // true - friend; false - request to friend
        return $status >= 0;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function delete()
    {
        if (!$this->_is_friends() || $this->_get_status() != 1)
        {
            return $this->_return_err('They are not friends!');
        }
        $this->DBHandler->delete_by_fields_list($this->_key_fields);
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function status_friend()
    {
        if ($this->_is_friends()
                && ($this->_get_status() >= 0
                    || ($this->_get_status() < 0 && $this->_get_status() * -1 == $this->_get_positive_status())
                ))
        {
            return $this->_get_msg_status_friend($this->_get_status());
        }
        return $this->_get_msg_status_friend(0);
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _get_msg_status_friend($status)
    {
        return array(
                'friend' => $status
        );
    }
    /////////////////////////////////////////////////////////////////////////////
}