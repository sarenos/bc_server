<?php

require_once LAYERS_DIR . '/User/user.php';
require_once LAYERS_DIR . '/Location/location.php';

class MainFindModel extends MainModel
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

    public function action_find()
    {
        return array_merge(
            $this->_load_by_find()
        );
    }

    private function _load_by_find()
    {
        $user1 = (string)@$_GET["find_nick"];		
        $this->_DBHandler->exec_query(
            "SELECT ". User::SQL_USER_DATA
            . ", loc.latitude AS lat, loc.longitude AS lng,"
            . "find.status, " . $this->_User->SQL_FILTER_ONLINE
            . " FROM `bc_locations` AS loc, `bc_users_info`"
            . "WHERE `bc_users_info`.user_id = loc.user_id and bc_users_info.nick like '".$user1."%'" 
        );
        $res_rec = array();
        foreach ($this->_DBHandler->get_all_data() as $record)
        {
                $record['isOnline'] = $record['isOnline'] ? true : false;
            $res_rec[] = array_merge(
                $record,
                array(
                    'friend'    => 0
                ));        }
        return $res_rec;
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