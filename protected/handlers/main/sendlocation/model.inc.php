<?php

require_once LAYERS_DIR . '/User/user.php';

class MainSendLocationModel extends MainModel
{
    private $_DBHandler;
    private $_User;

    public function __construct()
    {
        parent::__construct();
        $this->_DBHandler = produce_db();
        $this->_User = new User();
    }

    public function action_send_location()
    {
        $this->_validate_data($_POST);
        $latitude = (double)@$_POST['latitude'];
        $longitude = (double)@$_POST['longitude'];
        $user_id = (int)@$_POST['user_id'];
        $date = date('Y-m-d H:i:s');
        $this->_DBHandler->exec_query("INSERT INTO bc_locations(user_id, latitude, longitude, date_crt) 
        VALUES ('$user_id', $latitude, $longitude, '$date')
        on duplicate key update latitude=$latitude, longitude=$longitude, date_crt='$date'");

 $this->_DBHandler->exec_query("INSERT INTO bc_user_loc_archive (user_id, latitude, longitude, date_crt) VALUES ('$user_id', $latitude, $longitude, '$date')");

          $this->_DBHandler->exec_query("SELECT new_messages, new_friends  FROM bc_users_info WHERE user_id LIKE '$user_id'");
          $selectResult = $this->_DBHandler->get_all_data();

        $this->Result =  array('data' =>  $selectResult);
    }

    public function run()
    {
        parent::run();
        $this->determine_action();
    }
    
    private function _validate_data($Data)
    {
        $this->_User->check_exist_by_user_id((string)@$Data['user_id']);
        $this->_check_latitude(@$Data['latitude']);
        $this->_check_longitude(@$Data['longitude']);
    }

    private function _check_latitude($lat)
    {
        if (!is_numeric($lat) || $lat < -90 || $lat > 90)
        {
            throw new ExceptionProcessing(20);
        }
        return true;
    }
    
    private function _check_longitude($long)
    {
        if (!is_numeric($long) || $long < -180 || $long > 180)
        {
            throw new ExceptionProcessing(21);
        }
        return true;
    }
}