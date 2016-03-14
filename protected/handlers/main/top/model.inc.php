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
        $user1 = $_POST["userFrom"];
        $user2 = $_POST["userTo"];
        $this->_DBHandler->exec_query("INSERT INTO bc_top(user1, user2)
										   VALUES ($user1, $user2)");
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