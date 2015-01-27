<?php

class MainLocationsModel extends MainModel
{
    private $_DBHandler;

    public function __construct()
    {
        parent::__construct();
        $this->_DBHandler = produce_db();
    }

    public function action_default()
    {
        $user_account= (String)@$_POST['user_account'];
        $this->_DBHandler->exec_query(" SELECT id, latitude, user_account, longitude, date_crt FROM bc_locations WHERE user_account NOT LIKE '".$user_account."' and date_crt > date_sub(now(), INTERVAL 100 HOUR)");
        $this->Result = $this->_DBHandler->get_all_data();
    }

    public function run()
    {
        parent::run();
        $this->determine_action();
    }
}