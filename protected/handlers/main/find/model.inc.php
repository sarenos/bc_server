<?php

require_once LAYERS_DIR . '/User/user.php';

class MainFindModel extends MainModel
{
    private $_User;

    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
    }

    public function action_find()
    {
        $this->_User->set_page_num((int)@$_GET['page']);
        $this->Result = array('data' => $this->_User->find_by_nick(
                                                (string)@$_GET["find_nick"],
                                                (string)@$_GET["user_id"])
                        );
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