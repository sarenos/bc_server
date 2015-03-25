<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';

class Messages extends EntityWithDB
{
    private $_Data;
    /////////////////////////////////////////////////////////////////////////////
    
    public function &get_all_fields_instances()
    {
        $result['id']               = new FieldInt();
        $result['connection_id']    = new FieldInt();
        $result['status']           = new FieldInt();
        $result['message']          = new FieldString();
        $result['dt_create']        = new FieldDateTime();
        
        $result['message']->set_max_length(5000);
        
        return $result;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function create_child_objects()
    {
        $this-> create_standart_db_handler('bc_messages');
        $this-> create_tuple();
        $this-> DBHandler-> set_primary_key('id');
    }
    /////////////////////////////////////////////////////////////////////////////

    public function set_data($Data)
    {
        $this->_Data = $Data;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function send($connection_id)
    {
        $this->Fields['connection_id']->set($connection_id);
        $this->Fields['status']->set($this->_get_status_new());
        $this->Fields['message']->set($this->_Data['message']);
        $this->Fields['dt_create']->now();
        $this->DBHandler->insert();
        return $this->Fields['id']->get();
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _get_status_new()
    {
        if ((float)@$this->_Data['user_from'] < (float)@$this->_Data['user_to'])
        {
            return -1;
        }
        return -2;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function read($message_id)
    {
        $this->Fields['id']->set($message_id);
        $this->load_by_field('id');
        $status_old = $this->Fields['status']->get();
        if ($status_old < 0)
        {
            $this->Fields['status']->set(-1 * $status_old);
            $this->update();
        }
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function get_list_with_one_friend($connection_id)
    {
        $this->DBHandler->db->exec_query(
                "SELECT * FROM `bc_messages` WHERE `connection_id` = '$connection_id' ORDER BY `dt_create`"
        );
        $user_msg_status = $this->_get_user_message_status();
        $all_messages = array();
        $id = 1;
        foreach ($this->DBHandler->db->get_all_data() as $mes_data)
        {
            $message = array();
            $message['id'] = $id;
            $message['user'] = $this->_is_user_message($user_msg_status, $mes_data['status']);
            $message['read'] = $this->_was_message_read($mes_data['status']);
            $message['message'] = $mes_data['message'];
            $message['date'] = $mes_data['dt_create'];
            $all_messages[] = $message;
            ++$id;
        }
        return $all_messages;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _get_user_message_status()
    {
        if ((float)@$this->_Data['user'] < (float)@$this->_Data['friend'])
        {
            return 1;
        }
        return 2;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _is_user_message($user_msg_status, $status)
    {
        if (!$this->_was_message_read($status))
        {
            $status = -1 * $status;
        }
        if ($user_msg_status == $status)
        {
            return true;
        }
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _was_message_read($status)
    {
        if ($status > 0)
        {
            return true;
        }
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function get_data_by_message_id($message_id)
    {
        $this->Fields['id']->set($message_id);
        $this->load_by_field('id');
        return array(
            'connection_id' => $this->Fields['connection_id']->get(),
            'status'        => $this->Fields['status']->get()
        );
    }
    /////////////////////////////////////////////////////////////////////////////
}