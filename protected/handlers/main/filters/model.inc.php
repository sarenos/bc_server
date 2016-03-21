<?php

require_once LAYERS_DIR . '/User/user.php';
require_once LAYERS_DIR . '/Location/location.php';
require_once LAYERS_DIR . '/Friends/top.php';

class MainFiltersModel extends MainModel
{
    private $_User, $_Location, $_Top;

    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
        $this->_Location = new Location();
        $this->_Top = new Top();
    }

    public function action_get_filter()
    {
        $this->Result = array('filter' => $this->_User->get_user_filter(@$_GET['user_id']));
    }

    public function action_set_filter()
    {
        $this->Result = $this->_User->set_user_filter($_POST);
    }

    public function action_get_users()
    {
        $user_id = @$_GET['user_id'];
        $this->_User->check_exist_by_user_id($user_id);
        $this->_Location->check_time_last_send_coordinates($user_id);
        $Filter = (array)$this->_User->get_user_filter($user_id);
        $Filter['user_id'] = $user_id;
        $show_offline = $this->_User->get_filter_offline($user_id);
        $sql_filter = $this->_Location->get_sql_for_filter_radius((float)@$Filter['radius'], $user_id, $show_offline);
        
        $this->_User->set_page_num((int)@$_GET['page']);
        $Data_res = array_merge(
                        $this->_User->get_users_by_filters($Filter, $sql_filter),
                        $this->_Top->get_top_info($user_id, $show_offline));
        
        foreach ($Data_res as &$user_data)
        {
            $user_data['isOnline'] = $user_data['isOnline'] ? true : false;
        }
        $this->Result = array('data' => $Data_res);
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