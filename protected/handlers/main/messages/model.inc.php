<?php

require_once LAYERS_DIR . '/Messages/messages.php';
require_once LAYERS_DIR . '/User/connections.php';
require_once LAYERS_DIR . '/User/user.php';

class MainMessagesModel extends MainModel
{
    private $_Messages;
    private $_Connections;
    private $_User;

    public function __construct()
    {
        parent::__construct();
        $this->_Messages = new Messages();
        $this->_Connections = new Connections();
        $this->_User = new User();
    }

    public function action_send()
    {
        $this->_Connections->set_users((float)@$_POST['user_from'], (float)@$_POST['user_to']);
        $this->_User->inc_count_messages((float)@$_POST['user_to']);
        $this->Result = 
                    $this->_Messages
                                ->set_data($_POST)
                                ->send($this->_Connections->get_id_by_users());
    }

    public function action_read()
    {
        $Message_data = $this->_Messages->get_data_by_message_id((float)@$_POST['id']);
        if ($Message_data['status'] < 0)
        {
            $users = $this->_Connections->get_users_by_connection_id(
                        $Message_data['connection_id']
                    );
            if ($Message_data['status'] == 1)
            {
                $user_id = $users[1];
            }
            else
            {
                $user_id = $users[0];
            }
            $this->_User->dec_count_messages($user_id);
        }
        $this->Result = $this->_Messages->read((float)@$_POST['id']);
    }

    public function action_one_friend()
    {
        $this->_Messages->set_page_num((int)@$_GET['page']);
        $this->_Connections->set_users((float)@$_GET['user'], (float)@$_GET['friend'], 1);
        $this->_Messages->set_data($_GET);
        $this->Result = array('data' =>
                            $this->_Messages
                                    ->get_list_with_one_friend(
                                            $this->_Connections->get_id_by_users()
                        ));
    }
    
    public function action_list_users()
    {
        $this->_Connections->set_page_num((int)@$_GET['page']);
        $this->_Connections->set_one_user((float)@$_GET['user']);
        /*$Res_data = array();
        foreach ($this->_Connections->get_list_by_one_user() as $Message_data)
        {
            if (!$this->_User->is_exist_by_user_id($Message_data['id']))
            {
                continue;
            }
            $Res_data[] = 
                array_merge(
                    $Message_data,
                    $this->_User->get_user_data_by_id($Message_data['id']));
        }*/
        $this->Result = array('data' => $this->_Connections->get_list_by_one_user());
    }
    
    /*public function action_new_messages()
    {
        $this->_set_users_post();
        $this->Result = $this->_Friends->delete();
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