<?php

require_once LAYERS_DIR . '/User/user.php';
require_once LAYERS_DIR . '/Location/location.php';

class MainTopModel extends MainModel
{
    private $_User, $_Location;
    private $_DBHandler;

    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
        $this->_Location = new Location();
        $this->_DBHandler = produce_db();
    }

    public function action_invite()
    {
        $user1 = $_POST["user_from"];
        $user2 = $_POST["user_to"];
        $this->_DBHandler->exec_query("INSERT INTO bc_top(user1, user2)
										   VALUES ($user1, $user2)");
        $this->Result = array("data" => "ok");
    }

    public function action_get_top_list()
    {
        $user = $_POST["user"];
        $this->_DBHandler->exec_query("SELECT * FROM bc_top WHERE user1 = $user");
        $this->Result = array("data" => $this->_DBHandler->get_all_data());
    }

    public function action_delete()
    {
        $user1 = $_POST["user_from"];
        $user2 = $_POST["user_to"];
        $this->_DBHandler->exec_query("DELETE FROM bc_top WHERE user1 = $user1 and user2 = $user2");
        $this->Result = array("data" => "ok");
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