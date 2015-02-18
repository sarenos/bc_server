<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';

class Friends extends EntityWithDB
{
    private $_user_to, $_user_from;
    private $_key_fields = array('user_to', 'user_from');
    /////////////////////////////////////////////////////////////////////////////
    
    public function &get_all_fields_instances()
    {
        $result['user_to']          = new FieldString();
        $result['user_from']        = new FieldString();
        $result['status']           = new FieldInt();
        $result['dt_create']        = new FieldDateTime();
        $result['dt_status']        = new FieldDateTime();
        
        $result['user_to']->set_max_length(30);
        $result['user_from']->set_max_length(30);
        
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

    public function set_user_to($user_to)
    {
        $this->_user_to = $user_to;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function set_user_from($user_from)
    {
        $this->_user_from = $user_from;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function add_invite()
    {
        if ($this->_is_friends($this->_user_to, $this->_user_from)
            || $this->_is_friends($this->_user_from, $this->_user_to))
        {
            return $this->_return_err('They had already sent query!');
        }
        $this->Fields['user_to']->set($this->_user_to);
        $this->Fields['user_from']->set($this->_user_from);
        $this->Fields['status']->set(-1);
        $this->Fields['dt_create']->now();
        $this->DBHandler->insert();
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _is_friends($user_to, $user_from)
    {
        $this->Fields['user_to']->set($user_to);
        $this->Fields['user_from']->set($user_from);
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
        if (!$this->_is_friends($this->_user_from, $this->_user_to))
        {
            return $this->_return_err("They didn't send queries!");
        }
        if ($this->_get_status() != -1)
        {
            return $this->_return_err('User '.$this->_user_from." doesn't have status invite!");
        }
        $this->DBHandler->delete_by_fields_list($this->_key_fields);
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function set_new_status_friends($new_status)
    {
        if (!$this->_is_friends($this->_user_from, $this->_user_to))
        {
            return $this->_return_err("They didn't send queries!");
        }
        if ($this->_get_status() != -1)
        {
            return $this->_return_err('User '.$this->_user_from." doesn't have status invite!");
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
                    $this->_load_by_user('user_to', 'user_from'),
                    $this->_load_by_user('user_from', 'user_to')
                );
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _load_by_user($field_query, $field_res)
    {
        $this->DBHandler->db->exec_query(
                "SELECT * FROM `bc_friends` WHERE `$field_query` = '".$this->_user_from."'"
        );
        $res_rec = array();
        foreach ($this->DBHandler->db->get_all_data() as $record)
        {
            $res_rec[] = array(
                            'user_id'   => $record[$field_res],
                            'status'    => $record['status']
                        );
        }
        return $res_rec;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function delete()
    {
        if ((!$this->_is_friends($this->_user_to, $this->_user_from)
            && !$this->_is_friends($this->_user_from, $this->_user_to))
            || ($this->_get_status() != 1))
        {
            return $this->_return_err('They are not friends!');
        }
        $this->DBHandler->delete_by_fields_list($this->_key_fields);
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function status_friend()
    {
        if ($this->_is_friends($this->_user_to, $this->_user_from)
            || $this->_is_friends($this->_user_from, $this->_user_to))
        {
            return $this->_get_msg_status_friend($this->_get_status());
        }
        return $this->_get_msg_status_friend(-2);
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _get_msg_status_friend($status)
    {
        return array(
                'status' => $status
        );
    }
    /////////////////////////////////////////////////////////////////////////////
}