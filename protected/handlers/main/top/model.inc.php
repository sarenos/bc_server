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
        $user1 = (string)@$_POST["user_from"];
        $user2 = (string)@$_POST["user_to"];
        $this->_DBHandler->exec_query("INSERT INTO bc_top(user1, user2)
										   VALUES ($user1, $user2)");
        $this->Result = array("data" => "ok");
    }

    public function action_get_top_list()
    {
        //$this->_DBHandler->exec_query("SELECT user2 FROM bc_top WHERE user1 = $user1");
        $this->Result = array("data" => $this->get_list());
    }

    public function get_list()
    {
        return array_merge(
            $this->_load_by_user()
        );
    }

    private function _load_by_user()
    {
        $user1 = (string)@$_GET["user"];
        var_dump("SELECT fr.user1 AS user_id, " . User::SQL_USER_DATA
            . ", loc.latitude AS lat, loc.longitude AS lng,"
            . "fr.status, " . $this->_User->SQL_FILTER_ONLINE
            . " FROM `bc_locations` AS loc, `bc_users_info`"
            . " JOIN (SELECT * FROM `bc_top` WHERE user1 = '".$user1."') AS fr"
            . " ON `bc_users_info`.user_id = fr.user1 "
            . "WHERE `bc_users_info`.user_id = loc.user_id");
        die();
        $this->_DBHandler->exec_query(
            "SELECT fr.user1 AS user_id, " . User::SQL_USER_DATA
            . ", loc.latitude AS lat, loc.longitude AS lng,"
            . "fr.status, " . $this->_User->SQL_FILTER_ONLINE
            . " FROM `bc_locations` AS loc, `bc_users_info`"
            . " JOIN (SELECT * FROM `bc_top` WHERE user1 = '".$user1."') AS fr"
            . " ON `bc_users_info`.user_id = fr.user1 "
            . "WHERE `bc_users_info`.user_id = loc.user_id"
        );
        $res_rec = array();
        foreach ($this->_DBHandler->get_all_data() as $record)
        {
            if (($record['status'] == -2 && $num_user2 == 1)
                || ($record['status'] == -1 && $num_user2 == 2)
                || $record['status'] > 0)
            {
                $record['isOnline'] = $record['isOnline'] ? true : false;
                $res_rec[] = array_merge(
                    $record,
                    array(
                        'friend'    => $this->_is_friend($record['status'])
                    ));
            }
        }
        return $res_rec;
    }

    public function action_delete()
    {
        $user1 = (string)@$_POST["user_from"];
        $user2 = (string)@$_POST["user_to"];
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