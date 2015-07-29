<?php

require_once LAYERS_DIR . '/User/user.php';

class MainAuthorizationModel extends MainModel
{
    private $_User;
    private $_DBHandler;
    
    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
        $this->_DBHandler = produce_db();
    }

    public function action_authorization()
    {
        $this->_User->set_user_account((string)@$_POST['user_account']);
        $this->Result = $this->_User->get_user_id_for_auth();
        
        /*$user_account = (String)@$_GET['user_account'];
        $this->_DBHandler->exec_query("SELECT * FROM bc_users_info WHERE user_account LIKE '$user_account'");
        $selectResult = $this->_DBHandler->get_all_data();
        if(empty($selectResult))
        {
            $date = date('Y-m-d H:i:s');
            $this->_DBHandler->exec_query("INSERT INTO bc_users_info(user_account, dt_create)
										   VALUES ('$user_account', '$date')");


            $this->_DBHandler->exec_query("SELECT * FROM bc_users_info WHERE user_id LIKE '$user_account'");
            $selectResult = $this->_DBHandler->get_all_data();
        }

        $my_account = (String)@$_GET['my_account'];
        if(!empty($my_account))
        {
            $this->_DBHandler->exec_query("SELECT status FROM bc_friends WHERE user_to LIKE '$user_account' and user_from
LIKE  '$my_account'");
            $result = $this->_DBHandler->get_all_data();
            if(!empty($result))
            {
if($result[0]['status'] == "-1")  {
                $selectResult = array_merge($selectResult[0], 		    array("status"=>"3"));
}else {
                $selectResult = array_merge($selectResult[0],$result[0]);
}


            } else {

                $this->_DBHandler->exec_query("SELECT status FROM bc_friends WHERE user_to LIKE '$my_account' and 	user_from LIKE  '$user_account'");
                $result = $this->_DBHandler->get_all_data();
                if(empty($result)){
                    $selectResult = array_merge($selectResult[0],array( "status" => "0"));
                }else{
                    $selectResult = array_merge($selectResult[0],$result[0]);}

            }
        }

        $this->Result = array("data" => $selectResult);*/
    }


    public function action_update()
    {
        $account = (String)@$_POST['user_account'];

	if(isset($_POST['photo'])){
        $photoB64 =  $_POST['photo'];

        $url = "static/img/".$account.".jpeg";
        $ifp = fopen($url, "wb");

        //$data = explode($photoB64);

        fwrite($ifp, base64_decode($photoB64 ));
        fclose($ifp);
        }

        $city= (String)@$_POST['city'];
//$account = (String)@$_POST['user_account'];
        $sex = (String)@$_POST['sex'];
        $siteUrl = (String)@$_POST['siteUrl'];
        $birthdayDate = (String)@$_POST['birthdayDate'];

        $this->_DBHandler->exec_query("UPDATE bc_users_info SET city = '".$city."', sex = '".$sex."', birth_date = '".$birthdayDate."',photo = '".$url."', vk_id = '".$siteUrl."'  WHERE user_account LIKE '".$account."'");

        $this->Result = array("data" => "ok");
    }


    public function run()
    {
        parent::run();
        $this->determine_action();
    }
}