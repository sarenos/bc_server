<?php

require_once LAYERS_DIR . '/Entity/entity_with_db.inc.php';

class User extends EntityWithDB
{
    private $_user_account = '';
    private $_Data = null;
    /////////////////////////////////////////////////////////////////////////////
    
    public function &get_all_fields_instances()
    {
        $result['user_id']          = new FieldInt();
        $result['user_account']     = new FieldString();
        $result['nick']             = new FieldString();
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
        $result['nick']->set_max_length(20);
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
    
    public function set_data($Data)
    {
        $this->_Data = $Data;
        return $this;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_data_field($field)
    {
        if (isset($this->_Data[$field]))
        {
            return trim(html_entity_decode((string)$this->_Data[$field]));
        }
        return '';
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_nick_by_id($user_id)
    {
        $this->Fields['user_id']->set($user_id);
        $this->load_by_field('user_id');
        return $this->Fields['nick']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function get_nick_by_account($user_account)
    {
        $this->Fields['user_account']->set($user_account);
        $this->load_by_field('user_account');
        return $this->Fields['nick']->get();
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
        $res = $this->_validate_account();
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
    
    public function get_user_id_for_auth()
    {
        $user_id = $this->_get_user_id_by_account();
        if (!$user_id)
        {
            throw new ExceptionProcessing(1);
        }
        return array('user_id' => $user_id);
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_user_id_by_account()
    {
        $this->Fields['user_account']->set($this->_user_account);
        $this->load_by_field('user_account');
        return $this->Fields['user_id']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _is_exist()
    {
        return 0 != $this->_get_user_id_by_account();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_user_account_by_nick($nick)
    {
        $this->Fields['nick']->set($nick);
        $this->load_by_field('nick');
        return $this->Fields['user_account']->get();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _add()
    {
        $this->Fields['user_account']->set($this->_user_account);
        $this->Fields['filter']->set($this->_get_default_filter());
        $this->Fields['dt_create']->now();
        $this->DBHandler->insert();
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _get_default_filter()
    {
        return json_encode(
                array(
                    'sex'   => FILTER_SEX,
                    'minAge'=> FILTER_MINAGE,
                    'maxAge'=> FILTER_MAXAGE,
                    'radius'=> FILTER_RADIUS
                ));
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function create()
    {
        $this->set_user_account((string)@$this->_Data['user_account']);
        $this->_validate_data();
        $this->_add();
        $this->update_data();
        return array('id' => (int)@$this->Fields['user_id']->get());
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _validate_data()
    {
        $this->_validate_account();
        $this->_validate_nick();
        $this->_validate_age($this->_get_data_field('age'));
        $this->_validate_sex($this->_get_data_field('sex'));
        $this->_validate_android_account($this->_get_data_field('android_account'));
        $this->_validate_city($this->_get_data_field('city'));
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _validate_account()
    {
        if (!$this->_is_valid_email($this->_user_account))
        {
            throw new ExceptionProcessing(2);
        }
        if ($this->_is_exist())
        {
            throw new ExceptionProcessing(3);
        }
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _is_valid_email($email)
    {
        if (!preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $email))
        {
            return false;
        }
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    private function _validate_nick()
    {
        $user_account_by_nick = $this->_get_user_account_by_nick($this->_get_data_field('nick'));
        if ($user_account_by_nick != '' && $user_account_by_nick != $this->_get_data_field('user_account'))
        {
            throw new ExceptionProcessing(4);
        }
        if (!preg_match("/^[A-Za-z0-9_\.-]+$/", $this->_get_data_field('nick')))
        {
            throw new ExceptionProcessing(5);
        }
        if (!preg_match("/^.{4,20}$/", $this->_get_data_field('nick')))
        {
            throw new ExceptionProcessing(6);
        }
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    protected function _validate_age($age)
    {
        if (!is_numeric($age) || ((int)$age < 14 || (int)$age > 99))
        {
            throw new ExceptionProcessing(7);
        }
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    protected function _validate_sex($sex)
    {
        if ($sex == 'm' || $sex == 'f')
        {
            return true;
        }
        throw new ExceptionProcessing(8);
    }
    /////////////////////////////////////////////////////////////////////////////
    
    protected function _validate_android_account($android_account)
    {
        if (!$this->_is_valid_email($android_account))
        {
            throw new ExceptionProcessing(9);
        }
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    protected function _validate_city($city)
    {
        if (!preg_match("/^[А-Яа-яЁёA-Za-z\s-,]{2,100}$/", $city))
        {
            throw new ExceptionProcessing(10);
        }
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////
    
    public function update_data()
    {
        $this->Fields['user_account']->set($this->_get_data_field('user_account'));
        $this->Fields['nick']->set($this->_get_data_field('nick'));
        $this->Fields['age']->set($this->_get_data_field('age'));
        $this->Fields['sex']->set($this->_get_data_field('sex'));
        $this->Fields['android_account']->set($this->_get_data_field('android_account'));
        //$this->Fields['phone']->set(trim((string)@$data['phone']));
        //$this->Fields['vk_id']->set(trim((string)@$data['vk_id']));
        //$this->Fields['birth_date']->set(trim((string)@$data['birth_date']));
        $this->Fields['city']->set($this->_get_data_field('city'));
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
                    'status'    => 4,
                    'statusMsg' => 'Пользователя с таким аккаунтом нет в системе!');
        }
        $this->DBHandler->delete_by_field('user_account');
        return true;
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
        $this->DBHandler->db->exec_query("SELECT bc_users_info.user_id, bc_users_info.nick, bc_users_info.age, bc_users_info.sex, bc_users_info.photo, t_users_in_radius.lat, t_users_in_radius.lng"
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