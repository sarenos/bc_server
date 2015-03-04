<?php

require_once LAYERS_DIR . '/User/user.php';

class MainUserModel extends MainModel
{
    private $_User;
    private $_DBHandler;
    
    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
        $this->_DBHandler = produce_db();
    }

    public function action_get_info()
    {
        $this->_User->set_user_account((string)@$_GET['user_account']);
        $this->Result = $this->_User->get_info();
    }
    
    public function action_create()
    {
        $this->Result = $this->_User->create($_POST);
    }
    
    public function action_update()
    {
        $this->Result = $this->_User->update_data($_POST);
    }
    
    public function action_delete()
    {
        $this->_User->set_user_account((string)@$_POST['user_account']);
        $this->Result = $this->_User->delete();
    }
    
    public function action_default()
    {
    }
    
    public function run()
    {
        parent::run();
        $this->determine_action();
    }
}