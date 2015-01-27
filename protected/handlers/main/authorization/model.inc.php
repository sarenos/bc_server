<?php

class MainAuthorizationModel extends MainModel
{
    private $_DBHandler;

    public function __construct()
    {
        parent::__construct();
        $this->_DBHandler = produce_db();
    }

    public function action_default()
    { 
          $user_account = (String)@$_GET['user_account'];
          $this->_DBHandler->exec_query("SELECT * FROM bc_users_info WHERE user_id LIKE '$user_account'");
          $selectResult = $this->_DBHandler->get_all_data();
		if(empty($selectResult))
                {
			$date = date('Y-m-d H:i:s');
			$this->_DBHandler->exec_query("INSERT INTO bc_users_info(user_id, user_date_create) 
										   VALUES ('$user_account', '$date')");
			$selectResult = null;
                }
        $this->Result = $selectResult;
    }

    public function run()
    {
        parent::run();
        $this->determine_action();
    }
}