<?php

require_once LAYERS_DIR . '/Friends/friends.php';
require_once LAYERS_DIR . '/User/user.php';
require_once LAYERS_DIR . '/Location/location.php';

class MainFiltersModel extends MainModel
{
    private $_User, $_Location, $_Friends;

    public function __construct()
    {
        parent::__construct();
        $this->_User = new User();
        $this->_Location = new Location();
        $this->_Friends = new Friends();
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
        $sql_filter = $this->_Location->get_sql_for_filter_radius((float)@$Filter['radius'], $user_id);
        
        $Data_res = array();
        $this->_User->set_page_num((int)@$_GET['page']);
        $friends = $this->_Friends->get_friends_id($user_id);
        $is_filter_offline = $this->_User->get_filter_offline($user_id);
        foreach ($this->_User->get_users_by_filters($Filter, $sql_filter)
                    as $user_data)
        {
            if (!in_array($user_data['user_id'], $friends)) {
                $is_online = $this->_Friends->is_user_online($user_data['user_id']);
                if ((!$is_filter_offline && $is_online) || $is_filter_offline)
                {
                    $Data_res[] = array_merge($user_data,
                                    $this->_Friends->get_users_status($user_id, $user_data['user_id']),
                                    array('isOnline' => $is_online));
                }
            }
        }
        foreach ($friends as $one_friend) {
            $is_online = $this->_Friends->is_user_online($one_friend);
            if ((!$is_filter_offline && $is_online) || $is_filter_offline)
            {
                $Data_res[] = array_merge(
                                array('user_id' => $one_friend),
                                $this->_User->get_user_data_by_id($one_friend),
                                $this->_Location->get_user_coordinates($one_friend),
                                $this->_Friends->get_users_status($user_id, $one_friend),
                                array('isOnline' => $is_online));
            }
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