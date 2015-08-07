<?php

require_once LAYERS_DIR . '/User/user.php';
require_once LAYERS_DIR . '/Location/location.php';

class MainUserModel extends MainModel
{
    private $_User;
    private $_Location;
    private $_DBHandler;
    
    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
        $this->_Location = new Location();
        $this->_DBHandler = produce_db();
    }

    public function action_get_info()
    {
        $this->_User->set_user_account((string)@$_GET['user_account']);
        $this->Result = $this->_User->get_info();
    }
    
    public function action_create()
    {
        $this->_User->set_data($_POST);
        $this->Result = $this->_User->create();
    }
    
    public function action_update()
    {
        $this->_User->set_data($_POST);
        $this->Result = $this->_User->update_data($_POST);
    }
    
    public function action_delete()
    {
        $this->_User->set_user_account((string)@$_POST['user_account']);
        $this->Result = $this->_User->delete();
    }
    
    /*public function action_filter()
    {
        //$this->_User->save_filter($_GET);
        $user_id = @$_GET['user_id'];
        $this->_User->check_exist_by_user_id($user_id);
        $this->_Location->check_time_last_send_coordinates($user_id);
        $Filter = (array)$this->_User->get_user_filter($user_id);
        $Filter['user_id'] = $user_id;
        $sql_filter = $this->_Location->get_sql_for_filter_radius((float)@$Filter['radius'], $user_id);
        /*if (!empty($_GET['radius']))
        {
            $sql_filter = $this->_Location->get_sql_for_filter_radius((float)@$_GET['radius'], @$_GET['user_account']);
        }
        else
        {
            $sql_filter = $this->_Location->get_sql_for_users_last_coords() . " AS `t_users_in_radius`";
        }*/
        /*$this->Result = $this->_User->get_users_by_filters($Filter, $sql_filter);
    }*/
    
    public function action_default()
    {
    }
    
    public function run()
    {
        parent::run();
        $this->determine_action();
    }
}