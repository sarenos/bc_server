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
        $result['id']           = new FieldInt();
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
    
    private function _get_last_coordinates_by_user($user_account)
    {
        $this->_DBHandler->exec_query("SELECT latitude AS lat, longitude AS lng FROM `bc_locations` WHERE `user_account` LIKE '$user_account' ORDER BY `date_crt` DESC LIMIT 1");
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
    
    public function get_sql_for_filter_radius($radius_km, $user_account)
    {
        $coordinates = $this->_get_last_coordinates_by_user($user_account);
        $radius_grad = $this->_round_up($radius_km / 111.111, 2);
        
        $lat = (float)@$coordinates['lat'];
        $lng = (float)@$coordinates['lng'];
        
        return "
            (SELECT
              *, (
                6371 * acos (
                  cos ( radians($lat) )
                  * cos( radians( lat ) )
                  * cos( radians( lng ) - radians($lng) )
                  + sin( radians($lat) )
                  * sin( radians( lat ) )
                )
              ) AS distance
            FROM 
                (SELECT * FROM " . $this->get_sql_for_users_last_coords() . " t_users_last_coords
                WHERE `lat` >= " . ($lat - $radius_grad) . " AND `lat` <= " . ($lat + $radius_grad) . " AND `lng` >= " . ($lng - $radius_grad) . " AND `lng` <= " . ($lng + $radius_grad)
                    . ") `t_users_close`
            HAVING distance < $radius_km
            ORDER BY distance) `t_users_in_radius`";
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_sql_for_users_last_coords()
    {
        return "(SELECT user_account, lat, lng FROM (
                    SELECT user_account, date_crt, latitude AS lat, longitude AS lng
                    FROM `bc_locations`
                    ORDER BY date_crt DESC
                    ) t_sort_dt GROUP BY user_account)";
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
}