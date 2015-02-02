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
        
        $result['user_account']->set_max_length(50);
        $result['name']->set_max_length(20);
        $result['sex']->set_max_length(1);
        $result['android_account']->set_max_length(255);
        $result['phone']->set_max_length(15);
        $result['vk_id']->set_max_length(255);
        $result['city']->set_max_length(100);
        $result['photo']->set_max_length(255);
        
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
    
    public function get_info()
    {
        $res = $this->_checkEmail();
        if (empty($res))
        {
            if (!$this->_is_exist())
            {
                $this->_add();
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
}