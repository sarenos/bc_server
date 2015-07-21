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
        $this->_DBHandler->exec_query(" SELECT bcui.user_id, bcui.name, bcl.latitude, bcl.user_account, bcl.longitude, bcui.sex, bcui.age ,bcl.date_crt, bcui.photo FROM bc_locations  as bcl, bc_users_info as bcui WHERE bcl.user_account NOT LIKE '".$user_account."'  AND bcl.user_account LIKE bcui.user_account");
        $this->Result = array("data" =>$this->_DBHandler->get_all_data());
    }

    public function run()
    {
        parent::run();
        $this->determine_action();
    }
}