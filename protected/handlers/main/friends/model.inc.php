<?php

require_once LAYERS_DIR . '/Friends/friends.php';
require_once LAYERS_DIR . '/User/user.php';

class MainFriendsModel extends MainModel
{
    private $_Friends;

    public function __construct()
    {
        parent::__construct();
        $this->_Friends = new Friends();
        $this->_User = new User();
    }

    public function action_invite()
    {
        $this->_set_users_post();
        $this->Result = $this->_Friends->add_invite();
    }

    public function action_confirm()
    {
        $this->_set_users_post();
        $this->Result = $this->_Friends->confirm();
    }

    public function action_reject()
    {
        $this->_set_users_post();
        $this->Result = $this->_Friends->reject();
    }
    
    public function action_get_list()
    {
        $this->_set_user_get();
        $Res_data = array();
        foreach ($this->_Friends->get_list() as $Friend_data)
        {
            $Friend_data['name'] = $this->_User->get_name_by_account($Friend_data['user_id']);
            $Friend_data['photo'] = $this->_User->get_photo_by_account($Friend_data['user_id']);
            $Res_data[] = $Friend_data;
        }
        $this->Result = array('data' => $Res_data);
    }
    
    public function action_delete()
    {
        $this->_set_users_post();
        $this->Result = $this->_Friends->delete();
    }
    
    public function action_status_friend()
    {
        $this->_set_users_post();
        $this->Result = $this->_Friends->status_friend();
    }
    
    public function action_was_invitation()
    {
        $this->_set_users_post();
        $this->Result = $this->_Friends->was_invitation();
    }

    private function _set_users_post()
    {
        $this->_Friends
                ->set_user_to((string)@$_POST['user_to'])
                ->set_user_from((string)@$_POST['user_from']);
    }

    private function _set_user_get()
    {
        $this->_Friends
                ->set_user_from((string)@$_GET['user']);
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