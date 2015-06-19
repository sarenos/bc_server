<?php

require_once LAYERS_DIR . '/Friends/friends.php';
require_once LAYERS_DIR . '/User/user.php';
require_once LAYERS_DIR . '/Location/location.php';

class MainFiltersModel extends MainModel
{
    private $_Users;
    private $_Location;

    public function __construct()
    {
        parent::__construct();
        $this->_Users = new User();
        $this->_Location = new Location();
    }

    /*public function action_radius()
    {
        $radius = $this->_Users->get_user_s_radius(@$_GET['user_account']);
        $coordinates = $this->_Location->get_last_coordinates_by_user(@$_GET['user_account']);
        $users = $this->_Location->get_users_by_radius($coordinates, $radius);
        //die();
        var_dump($users);
        die();
    }*/

    public function action_get_filter()
    {
        $this->Result = array('filter' => $this->_Users->get_user_filter(@$_GET['user_account']));
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