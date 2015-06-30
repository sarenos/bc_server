<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';

class User extends EntityWithDB
{
    private $_user_account = '';
    /////////////////////////////////////////////////////////////////////////////
    
    public function &get_all_fields_instances()
    {
        $result['user_id']          = new FieldInt();
        $result['user_account']     = new FieldString();
        $result['name']             = new FieldString();
        $result['age']              = new FieldInt();
        $result['sex']              = new FieldString();
        $result['android_account']  = new FieldString();
        $result['phone']            = new FieldString();
        $result['vk_id']            = new FieldString();
        $result['dt_create']        = new FieldDateTime();
        $result['birth_date']       = new FieldDate();
        $result['city']             = new FieldString();
        $result['photo']            = new FieldString();
        $result['new_friends']      = new FieldInt();
        $result['new_messages']     = new FieldInt();
        $result['radius']           = new FieldFloat();
        $result['filter']           = new FieldString();
        
        $result['user_account']->set_max_length(50);
        $result['name']->set_max_length(20);
        $result['sex']->set_max_length(1);
        $result['android_account']->set_max_length(255);
        $result['phone']->set_max_length(15);
        $result['vk_id']->set_max_length(255);
        $result['city']->set_max_length(100);
        $result['photo']->set_max_length(255);
        $result['filter']->set_max_length(255);
        
        return $result;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function create_child_objects()
    {
        $this-> create_standart_db_handler('bc_users_info');
        $this-> create_tuple();
        $this-> DBHandler-> set_primary_key('user_id');
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function set_user_account($user_account)
    {
        $this->_user_account = $user_account;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_name_by_id($user_id)
    {
        $this->Fields['user_id']->set($user_id);
        $this->load_by_field('user_id');
        return $this->Fields['name']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_name_by_account($user_account)
    {
        $this->Fields['user_account']->set($user_account);
        $this->load_by_field('user_account');
        return $this->Fields['name']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_photo_by_id($user_id)
    {
        $this->Fields['user_id']->set($user_id);
        $this->load_by_field('user_id');
        return $this->Fields['photo']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_photo_by_account($user_account)
    {
        $this->Fields['user_account']->set($user_account);
        $this->load_by_field('user_account');
        return $this->Fields['photo']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_age_by_id($user_id)
    {
        $this->Fields['user_id']->set($user_id);
        $this->load_by_field('user_id');
        return $this->Fields['age']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_age_by_account($user_account)
    {
        $this->Fields['user_account']->set($user_account);
        $this->load_by_field('user_account');
        return $this->Fields['age']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_info()
    {
        $res = $this->_checkEmail();
        if (empty($res))
        {
            if (!$this->_is_exist())
            {
                //$this->_add();
                return array('data' => null);
            }
            
            $this->DBHandler->db->exec_query("SELECT * FROM bc_users_info WHERE user_account LIKE '".$this->_user_account."'");
            return array('data' => $this->DBHandler->db->get_all_data());
        }
        return $res;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _is_exist()
    {
        $this->Fields['user_account']->set($this->_user_account);
        $this->load_by_field('user_account');
        return 0 != $this->Fields['user_id']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _add()
    {
        $this->Fields['user_account']->set($this->_user_account);
        $this->Fields['dt_create']->now();
        $this->DBHandler->insert();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function create($Data)
    {
        $this->set_user_account((string)@$Data['user_account']);
        $this->_add();
        $this->update_data($Data);
        return array('id' => (int)@$this->Fields['user_id']->get());
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function update_data($data)
    {
        $this->_user_account = $data['user_account'];
        if (!$this->_is_exist())
        {
            return array(
                    'statusCode'    => 4,
                    'statusMessage' => 'Пользователя с таким аккаунтом нет в системе!');
        }
        $this->Fields['name']->set(trim((string)@$data['name']));
        $this->Fields['age']->set(trim((string)@$data['age']));
        $this->Fields['sex']->set(trim((string)@$data['sex']));
        $this->Fields['android_account']->set(trim((string)@$data['android_account']));
        $this->Fields['phone']->set(trim((string)@$data['phone']));
        $this->Fields['vk_id']->set(trim((string)@$data['vk_id']));
        $this->Fields['birth_date']->set(trim((string)@$data['birth_date']));
        $this->Fields['city']->set(trim((string)@$data['city']));
        $this->Fields['dt_create']->now();
        $this->DBHandler->update();
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function delete()
    {
        if (!$this->_is_exist())
        {
            return array(
                    'statusCode'    => 4,
                    'statusMessage' => 'Пользователя с таким аккаунтом нет в системе!');
        }
        $this->DBHandler->delete_by_field('user_account');
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    protected function _checkEmail()
    {
        $result = array();

        if (!preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $this->_user_account))
        {
            return array(
                    'statusCode'    => 5,
                    'statusMessage' => 'Проверьте правильность email адреса!');
        }
        return $result;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function inc_count_friends($user_id)
    {
        $count_friends = $this->_get_count_new_friends($user_id);
        $this->Fields['new_friends']->set(++$count_friends);
        $this->DBHandler->update();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function dec_count_friends($user_id)
    {
        $count_friends = $this->_get_count_new_friends($user_id);
        if ($count_friends > 0)
        {
            $this->Fields['new_friends']->set(--$count_friends);
            $this->DBHandler->update();
        }
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_count_new_friends($user_id)
    {
        $this->Fields['user_id']->set($user_id);
        $this->load_by_field('user_id');
        return $this->Fields['new_friends']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function inc_count_messages($user_id)
    {
        $count_messages = $this->_get_count_new_messages($user_id);
        $this->Fields['new_messages']->set(++$count_messages);
        $this->DBHandler->update();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function dec_count_messages($user_id)
    {
        $count_messages = $this->_get_count_new_messages($user_id);
        if ($count_messages > 0)
        {
            $this->Fields['new_messages']->set(--$count_messages);
            $this->DBHandler->update();
        }
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_count_new_messages($user_id)
    {
        $this->Fields['user_id']->set($user_id);
        $this->load_by_field('user_id');
        return $this->Fields['new_messages']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_users_by_filters($Data, $sql_filter)
    {
        $filter = $this->_get_filter_for_age(@$Data['minAge'], @$Data['maxAge']);
        if (isset($Data['sex']))
        {
            if (!empty($filter))
            {
                $filter .= ' AND ';
            }
            $filter .= "sex = '".@$Data['sex']."'";
        }
        if (!empty($filter))
        {
            $filter .= ' AND ';
        }
        $filter .= "bc_users_info.user_account NOT LIKE '" . @$Data['user_account'] . "'";
        $this->DBHandler->db->exec_query("SELECT bc_users_info.user_id, bc_users_info.name, bc_users_info.age, bc_users_info.sex, bc_users_info.photo, t_users_in_radius.lat, t_users_in_radius.lng"
                . " FROM bc_users_info JOIN $sql_filter"
                . " ON bc_users_info.user_account = t_users_in_radius.user_account WHERE $filter");
        return array('data' => $this->DBHandler->db->get_all_data());
    }
    /////////////////////////////////////////////////////////////////////////////
    
    /*private function _get_user_s_radius($user_account)
    {
        $this->Fields['user_account']->set($user_account);
        $this->load_by_field('user_account');
        return (float)@$this->Fields['radius']->get();
    }*/
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_filter_for_age($minAge, $maxAge)
    {
        if (!empty($minAge) && !empty($maxAge))
        {
            return 'age >= ' . $minAge . ' AND age <= ' . $maxAge;
        }
        return '';
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _set_user_by_account($user_account)
    {
        $this->Fields['user_account']->set($user_account);
        $this->load_by_field('user_account');
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function save_filter($Data)
    {
        $this->_set_user_by_account((string)@$Data['user_account']);
        $this->_set_filter_value($this->_remove_excess_from_data($Data));
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_user_filter($user_account)
    {
        $this->_set_user_by_account($user_account);
        return $this->_get_filter_value();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_filter_value()
    {
        return json_decode($this->Fields['filter']->get());
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _remove_excess_from_data($Data)
    {
        unset($Data['user_account']);
        unset($Data['action']);
        return json_encode($Data);
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _set_filter_value($Filter_value)
    {
        $this->Fields['filter']->set($Filter_value);
        $this->DBHandler->update();
    }
    /////////////////////////////////////////////////////////////////////////////
}