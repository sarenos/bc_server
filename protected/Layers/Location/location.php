<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';

class Location extends EntityWithDB
{
    private $_DBHandler;
    /////////////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        parent::__construct();
        $this->_DBHandler = produce_db();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function &get_all_fields_instances()
    {
        $result['user_id']      = new FieldInt();
        $result['latitude']     = new FieldFloat();
        $result['longitude']    = new FieldFloat();
        $result['date_crt']     = new FieldDateTime();
        
        return $result;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function create_child_objects()
    {
        $this-> create_standart_db_handler('bc_locations');
        $this-> create_tuple();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_last_coordinates_by_user($user_id)
    {
        $this->_DBHandler->exec_query("SELECT latitude AS lat, longitude AS lng FROM `bc_locations` WHERE `user_id` LIKE '$user_id' ORDER BY `date_crt` DESC LIMIT 1");
        return $this->_DBHandler->get_data();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    /*public function get_users_near_this_user($coordinates, $radius)
    {
        $this->_DBHandler->exec_query("SELECT user_account FROM `bc_locations` "
                    . "WHERE `latitude` >= " . ($coordinates['latitude'] - 0.1) . " AND `latitude` <= " . ($coordinates['latitude'] + 0.1)
                    . " AND `longitude` >= " . ($coordinates['longitude'] - 0.1) . " AND `longitude` <= " . ($coordinates['longitude'] + 0.1));
        return $this->_DBHandler->get_data();
    }*/
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_sql_for_filter_radius($radius_km, $user_id)
    {
        $coordinates = $this->_get_last_coordinates_by_user($user_id);
        $radius_grad = $this->_round_up($radius_km / 111.111, 2);
        
        $lat = (float)@$coordinates['lat'];
        $lng = (float)@$coordinates['lng'];
        
        return "
            (SELECT * FROM (SELECT
              *, (
                6371 * acos (
                  cos ( radians($lat) )
                  * cos( radians( lat ) )
                  * cos( radians( lng ) - radians($lng) )
                  + sin( radians($lat) )
                  * sin( radians( lat ) )
                )
              ) AS distance
            FROM ("
                . $this->get_sql_for_users_last_coords()
                //(SELECT * FROM " . $this->get_sql_for_users_last_coords() . " t_users_last_coords
                . " WHERE `latitude` >= " . ($lat - $radius_grad) . " AND `latitude` <= " . ($lat + $radius_grad) . " AND `longitude` >= " . ($lng - $radius_grad) . " AND `longitude` <= " . ($lng + $radius_grad)
                    . ") `t_users_in_round`) `t_users_close_with_distance`
            WHERE distance < $radius_km
            ORDER BY distance) `t_users_in_radius`";
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_sql_for_users_last_coords()
    {
        /*return "(SELECT user_id, lat, lng FROM (
                    SELECT user_id, date_crt, latitude AS lat, longitude AS lng
                    FROM `bc_locations`
                    ORDER BY date_crt DESC
                    ) t_sort_dt GROUP BY user_id)";*/
        return "SELECT user_id, latitude AS lat, longitude AS lng FROM `bc_locations`";
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _round_up($value, $precision = 2)
    {
        if ($precision < 0)
        {
            $precision = 0;
        }
        $mult = pow(10, $precision);
        return ceil($value * $mult) / $mult;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function check_time_last_send_coordinates($user_id)
    {
        $time_last_send = strtotime($this->_get_last_date_send($user_id)['last_dt_send']);
        if (time() - $time_last_send > (20 * 60))
        {
            throw new ExceptionProcessing(22);
        }
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////

    private function _get_last_date_send($user_id)
    {
        $this->_DBHandler->exec_query("SELECT MAX(date_crt) AS last_dt_send FROM `bc_locations` WHERE user_id=$user_id");
        return $this->_DBHandler->get_data();
    }
    /////////////////////////////////////////////////////////////////////////////

    /*public function save_coordinates($Data)
    {
        if (!$this->_is_user_exist((int)@$Data['user']))
        {
            $this->_insert_record($Data);
        }
        $this->_update_record($Data);
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _is_user_exist($user)
    {
        $this->Fields['user_id']->set($user);
        $this->load_by_field('user_id');
        return 0 != $this->Fields['id']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _insert_record($Data)
    {
        $this->Fields['latitude']->set((float)@$Data['latitude']);
        $this->Fields['longitude']->set((float)@$Data['user']);
        $this->Fields['date_crt']->now();
        $this->Fields['user_id']->set((int)@$Data['user']);
        $this->DBHandler->insert();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _update_record($Data)
    {
        
    }*/
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_user_coordinates($user_id)
    {
        $this->Fields['user_id']->set($user_id);
        $this->load_by_field('user_id');
        return array(
            'lat' => $this->Fields['latitude']->get(),
            'lng' => $this->Fields['longitude']->get()
        );
    }
    /////////////////////////////////////////////////////////////////////////////
}