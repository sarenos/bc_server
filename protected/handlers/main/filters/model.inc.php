<?php

require_once LAYERS_DIR . '/Friends/friends.php';
require_once LAYERS_DIR . '/User/user.php';

class MainFiltersModel extends MainModel
{
    private $_Users;

    public function __construct()
    {
        parent::__construct();
        $this->_Users = new User();
    }

    public function action_get_filter()
    {
        $this->Result = array('filter' => $this->_Users->get_user_filter(@$_GET['user_id']));
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