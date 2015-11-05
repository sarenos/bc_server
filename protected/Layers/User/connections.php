<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';
require_once LAYERS_DIR . '/User/user.php';

class Connections extends EntityWithDB
{
    private $_user1, $_user2;
    private $_key_users = array('user1', 'user2');
    private $_User;
    /////////////////////////////////////////////////////////////////////////////
    
    public function &get_all_fields_instances()
    {
        $result['id']       = new FieldInt();
        $result['user1']    = new FieldInt();
        $result['user2']    = new FieldInt();
        
        return $result;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function create_child_objects()
    {
        $this-> create_standart_db_handler('bc_connections');
        $this-> create_tuple();
        $this-> DBHandler-> set_primary_key('id');
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
        $this->set_per_page(PER_PAGE_MESSAGES);
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function set_users($user1, $user2, $message_with_friend = 0)
    {
        if (!$message_with_friend)
        {
            $this->_User->check_user_id_isset($user1, 1);
            $this->_User->check_user_id_isset($user2, 2);
        }
        else
        {
            $this->_User->check_user_id_isset($user1, 3);
            $this->_User->check_user_id_isset($user2, 4);
        }
        $this->_user1 = $this->_get_user1($user1, $user2);
        $this->_user2 = $this->_get_user2($user1, $user2);
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function set_one_user($user)
    {
        $this->_User->check_user_id_isset($user, 0);
        $this->_user1 = $user;
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
    
    public function get_id_by_users()
    {
        if (!$this->_is_exist_by_users())
        {
            $this->_add();
        }
        return $this->Fields['id']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_list_by_one_user()
    {
        return array_merge(
                $this->_get_list_by_every_user(1, 2),
                $this->_get_list_by_every_user(2, 1));
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_list_by_every_user($num_user_main, $num_user_find)
    {
        $this->DBHandler->db->exec_query(
                "SELECT `bc_users_info`.user_id AS id, " . User::SQL_USER_DATA . ", "
                . $this->_User->SQL_FILTER_ONLINE
                . " FROM `bc_locations` AS loc,"
                . " `bc_users_info`"
                . " JOIN ("
                . "     SELECT con.user$num_user_find AS user FROM `bc_connections` AS con WHERE con.user$num_user_main = '".$this->_user1."'"
                . " ) AS con_usr ON con_usr.user = `bc_users_info`.user_id"
                . " WHERE `bc_users_info`.user_id = loc.user_id"
                . $this->get_limit_part()
        );
        $res = array();
        foreach ($this->DBHandler->db->get_all_data() as $user)
        {
            $res[] = $user;
        }
        return $res;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _set_users_values()
    {
        $this->Fields['user1']->set($this->_user1);
        $this->Fields['user2']->set($this->_user2);
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _is_exist_by_users()
    {
        $this->_set_users_values();
        $this->load_by_fields_list($this->_key_users);
        return 0 != $this->Fields['id']->get();
    }
    /////////////////////////////////////////////////////////////////////////////

    public function get_users_by_connection_id($connection_id)
    {
        $this->Fields['id']->set($connection_id);
        $this->load_by_field('id');
        return array(
                    $this->Fields['user1']->get(),
                    $this->Fields['user2']->get());
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _add()
    {
        $this->_set_users_values();
        $this->DBHandler->insert();
    }
    /////////////////////////////////////////////////////////////////////////////
}