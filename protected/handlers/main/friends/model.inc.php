<?php

require_once LAYERS_DIR . '/Friends/friends.php';
require_once LAYERS_DIR . '/User/user.php';
require_once LAYERS_DIR . '/Location/location.php';

class MainFriendsModel extends MainModel
{
    private $_Friends, $_User, $_Location;

    public function __construct()
    {
        parent::__construct();
        $this->_Friends = new Friends();
        $this->_User = new User();
        $this->_Location = new Location();
    }

    public function action_invite()
    {
        $this->_set_users_post();
        //$this->_set_is_from_user1_for_invite_delete();
        $this->_Friends->check_is_friends();
        //$this->_User->inc_count_friends((float)@$_POST['user_to']);
        $this->Result = $this->_Friends->add_invite();
    }

    public function action_confirm()
    {
        $this->_set_users_post();
        $this->_set_is_from_user1_for_confirm();
        $this->_Friends->check_users_for_confirm_reject();
        $this->_User->dec_count_friends((float)@$_POST['user_from']);
        $this->Result = $this->_Friends->confirm();
    }

    public function action_reject()
    {
        $this->_set_users_post();
        $this->_set_is_from_user1_for_confirm();
        $this->_Friends->check_users_for_confirm_reject();
        $this->_User->dec_count_friends((float)@$_POST['user_from']);
        $this->Result = $this->_Friends->reject();
    }
    
    public function action_get_list()
    {
        $this->_set_user_get();
        $this->_Friends->set_page_num((int)@$_GET['page']);
        /*$Res_data = array();
        foreach ($this->_Friends->get_list() as $Friend_data)
        {
            if (!$this->_User->is_exist_by_user_id($Friend_data['user_id']))
            {
                continue;
            }
            $Res_data[] = $Friend_data;
        }*/
        $this->Result = array('data' => $this->_Friends->get_list());
    }
    
    public function action_delete()
    {
        $this->_set_users_post();
        $this->_set_is_from_user1_for_invite_delete();
        $this->Result = $this->_Friends->delete();
    }
    
    public function action_status_friend()
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
        $this->_Friends->set_is_from_user1((float)@$_GET['user_from'] > (float)@$_GET['user_to']);
        $this->Result = $this->_Friends->was_invitation();
    }

    private function _set_users_post()
    {
        $this->_Friends->set_users(
                            (float)@$_POST['user_from'],
                            (float)@$_POST['user_to']);
        $this->_Friends->check_users_identical();
    }

    private function _set_is_from_user1_for_invite_delete()
    {
        $this->_Friends->set_is_from_user1((float)@$_POST['user_from'] < (float)@$_POST['user_to']);
    }

    private function _set_is_from_user1_for_confirm()
    {
        $this->_Friends->set_is_from_user1((float)@$_POST['user_from'] > (float)@$_POST['user_to']);
    }
    
    private function _set_user_get()
    {
        $this->_Friends->set_user1((string)@$_GET['user']);
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