<?php

require_once LAYERS_DIR . '/Friends/top.php';
require_once LAYERS_DIR . '/User/user.php';

class MainTopModel extends MainModel
{
    private $_Top, $_User;

    public function __construct()
    {
        parent::__construct();
        $this->_Top = new Top();
        $this->_User = new User();
    }

    public function action_add()
    {
        $this->_set_users_post();
        $this->_Top->check_is_in_top();
        $this->Result = $this->_Top->add_in_top();
    }

    public function action_get_list()
    {
        $this->_set_user_get();
        $this->_Top->set_page_num((int)@$_GET['page']);
        $this->Result = array('data' => $this->_Top->get_list());
    }
    
    public function action_delete()
    {
        $this->_set_users_post();
        $this->Result = $this->_Top->delete();
    }
    
    /*public function action_status_friend()
    {
        $this->Result = $this->_Friends->get_users_status(
                                            (float)@$_GET['user_from'],
                                            (float)@$_GET['user_to']
                                        );
    }
    
    public function action_was_invitation()
    {
        $this->_Friends->set_users(
                            (float)@$_GET['user_from'],
                            (float)@$_GET['user_to']);
        //$this->_Top->set_is_from_user1((float)@$_GET['user_from'] > (float)@$_GET['user_to']);
        $this->Result = $this->_Friends->was_invitation();
    }*/

    private function _set_users_post()
    {
        $this->_Top->set_users(
                            (float)@$_POST['user1'],
                            (float)@$_POST['user2']);
        $this->_Top->check_users_identical();
    }

    private function _set_user_get()
    {
        $this->_Top->set_user1((string)@$_GET['user']);
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