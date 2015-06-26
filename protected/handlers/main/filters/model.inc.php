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

    public function action_radius()
    {
        $radius_km = $this->_Users->get_user_s_radius(@$_GET['user_account']);
        $radius_grad = $this->_round_up($radius_km / 111.111, 2);
        $coordinates = $this->_Location->get_last_coordinates_by_user(@$_GET['user_account']);
        $this->Result = array(
                'users'
                    => $this->_Location->get_users_by_radius($coordinates, $radius_grad, $radius_km, @$_GET['user_account'])
            );
    }

    private function _round_up($value, $precision = 2)
    {
        if ($precision < 0)
        {
            $precision = 0;
        }
        $mult = pow(10, $precision);
        return ceil($value * $mult) / $mult;
    }

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