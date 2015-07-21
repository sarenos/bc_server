<?php

class MainSendLocationModel extends MainModel
{
    private $_DBHandler;

    public function __construct()
    {
        parent::__construct();
        $this->_DBHandler = produce_db();
    }

    public function action_default()
    {
        $latitude = (double)@$_POST['latitude'];
        $longitude = (double)@$_POST['longitude'];
        $user_account = (String)@$_POST['user_account'];
        $date = date('Y-m-d H:i:s');
        $this->_DBHandler->exec_query("INSERT INTO bc_locations(user_account, latitude, longitude, date_crt) 
        VALUES ('$user_account', $latitude, $longitude, '$date')
        on duplicate key update latitude=$latitude, longitude=$longitude, date_crt='$date'");

 $this->_DBHandler->exec_query("INSERT INTO bc_user_loc_archive (user_account, latitude, longitude, date_crt) VALUES ('$user_account', $latitude, $longitude, '$date')");

          $this->_DBHandler->exec_query("SELECT new_messages  FROM bc_users_info WHERE user_account LIKE '$user_account'");
          $selectResult = $this->_DBHandler->get_all_data();

        $this->Result =  array('data' =>  $selectResult);
    }

    public function run()
    {
        parent::run();
        $this->determine_action();
    }
}