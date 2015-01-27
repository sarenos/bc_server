<?php

class MainUserModel extends MainModel
{

    private $_DBHandler;


    public function __construct()
    {
        parent::__construct();
        $this->_DBHandler = produce_db();
    }


    public function run()
    {
        parent::run();
        $this->determine_action();
    }


    public function action_add()
    {
        $this->is_ajax = true;

        $user_account = (String)@$_GET['user_account'];

        $result = $this->_checkEmail($user_account);

        if (empty($result)) {

            $result['status'] = 1;
            $result['message'] = 'ok';

            $this->_DBHandler->exec_query("SELECT * FROM bc_users_info WHERE user_id LIKE '$user_account'");

            $selectResult = $this->_DBHandler->get_all_data();

            if (empty($selectResult)) {
                $date = date('Y-m-d H:i:s');
                $query = "INSERT INTO bc_users_info(user_id, user_date_create) VALUES ('$user_account', '$date')";

                if (!$this->_DBHandler->exec_query($query)) {

                    $result['message'] = 'Произошла ошибка при сохранении данных.';
                    $result['code'] = '0004';
                }
            }

        }

        $this->Result = $result;
    }


    public function action_read()
    {
        $this->is_ajax = true;

        $user_account = (String)@$_POST['user_account'];

        $result = $this->_checkEmail($user_account);

        if (empty($result)) {

            $result['status'] = 1;
            $result['message'] = 'ok';

            $this->_DBHandler->exec_query("SELECT * FROM bc_users_info WHERE user_id LIKE '$user_account'");

            $selectResult = $this->_DBHandler->get_all_data();

            if (!empty($selectResult)) {

                $result['status'] = 1;
                $result['message'] = 'ok';
                $result['data'] = $selectResult;
            } else {

                $result['message'] = 'Пользователь с аккаунтом ' . $user_account . 'не найден.';
                $result['code'] = '0004';
            }

        }

        $this->Result = $result;
    }


    public function action_update()
    {
        $this->is_ajax = true;

        $result = array();
        $result['status'] = 0;

        $params = array(
            'user_account'   => trim((String)@$_POST['user_account']),
            'birth_date'     => (String)@$_POST['birth_date'],
            'city'           => trim((String)@$_POST['city']),
            'user_name'      => trim((String)@$_POST['user_name']),
            'user_age'       => intval(@$_POST['user_age']),
            'user_sex'       => trim((String)@$_POST['user_sex']),
            'user_phone'     => trim((String)@$_POST['user_phone']),
            'user_vk_id'     => trim((String)@$_POST['user_vk_id']),
            'photo'          => trim((String)@$_POST['photo'])
        );

        $check_result = $this->_checkData($params);

        if (!$check_result['error']) {

            $query = "SELECT * FROM bc_users_info WHERE user_id LIKE '" . $params['user_account'] . "'";
            $this->_DBHandler->exec_query($query);

            $selectResult = $this->_DBHandler->get_all_data();

            if (!empty($selectResult)) {
                $query = "UPDATE bc_users_info "
                    . "SET user_name='" . $params['user_name'] . "', user_age='" . $params['user_age']. "', "
                    . "user_sex='" . $params['user_sex'] . "', user_phone='" . $params['user_phone'] . "', "
                    . "user_vk_id='" . $params['user_vk_id'] . "', photo='" . $params['photo']
                    . "', birth_date='" . strtotime($params['birth_date']) . "', city='" . $params['city'] . "' "
                    . "WHERE user_id='" . $params['user_account'] . "'";

                if ($this->_DBHandler->exec_query($query)) {
                    $result['status'] = 1;
                    $result['message'] = 'ok';
                } else {
                    $result['message'] = 'Произошла ошибка при сохранении данных.';
                    $result['code'] = '0003';
                }

            } else {
                $result['message'] = 'Пользователя с таким аккаунтом нет в системе.';
                $result['code'] = '0002';
            }
        } else {
            $result['message'] = 'Проверьте правильность введенных данных.';
            $result['code'] = '0001';
            $result['data'] = $check_result['data'];
        }

        $this->Result = $result;
    }


    public function action_delete()
    {
        $user_account   = (String)@$_POST['user_account'];

        $result = $this->_checkEmail($user_account);

        if (empty($result)) {

            $query = "DELETE FROM bc_users_info WHERE user_id LIKE '$user_account'";
            $this->_DBHandler->exec_query($query);

            if ($this->_DBHandler->exec_query($query)) {

                $result['status'] = 1;
                $result['message'] = 'ok';
            } else {

                $result['message'] = 'Произошла ошибка при удалении данных.';
                $result['code'] = '0006';
            }
        }

        $this->Result = $result;
    }


    protected function _checkSqlWords($txt_sql)
    {
        $key_words =
            "/(INFORMATION_SCHEMA|select|alter|table|update|CONCAT|from|where|schema|delete|insert|GROUP BY|UNION)/i";

        preg_match_all($key_words, $txt_sql, $sqlin);

        if (isset($sqlin[0]) and count($sqlin[0]) != 0) {

            return false;
        }

        return true;
    }


    protected function _checkData($data)
    {
        $result = array('error' => false);

        foreach ($data as $key=>$value) {

            if (!$this->_checkSqlWords($value)) {

                $result['data'][$key] = true;
            }
        }

        /*if (isset($this->_checkEmail($data['user_account'])['code']))*/ {
            $result['data']['user_account'] = true;
        }

        if (($timestamp = strtotime($data['birth_date'])) === false) {
            $result['data']['birth_date'] = true;
        }

        if (isset($result['data'])) {
            $result['error'] = true;
        }

        return $result;
    }


    protected function _checkEmail($email)
    {
        $result = array();

        
        if (!preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $email))
        /*if (count(preg_match("/.+@gmail.com/i", $email)) < 1)*/
        {

            $result['statusMessage'] = 'Проверьте правильность введенных данных.';
            $result['statusCode'] = '0005';
            //$result['status'] = 0;
            //$result['data']['user_account'] = true;
        }

        return $result;
    }
}