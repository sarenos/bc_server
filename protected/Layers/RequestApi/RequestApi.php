<?php
require_once LAYERS_DIR . '/Authorization/AuthorizationSid.php';
class RequestApi
{    
    private $_paymentParams;
    private $_sid;
    private $_resultPaymetnUrl;
    private $_resultPaymetnJson;
    private $_requestDate;
    public function __construct($paymentParams, $resultPaymetnUrl)
    {
        $_authorizationSid = new AuthorizationSid();
        $this->_sid = $_authorizationSid->getSid();
        $this->_paymentParams = $paymentParams;
        $this->_resultPaymetnUrl = $resultPaymetnUrl;
        $this->_resultPaymetnJson = $this->_getRequestJson();
        $this->_requestDate = date("Y-m-d H:i:s");

    }
    
    public function run ()
    {
        return $this->_sendRequest();
    }
    
    public function getRequest()
    {
        return $this->_resultPaymetnJson;
    }
    
    public function getRequestDate()
    {
        return $this->_requestDate;
    }

        private function _sendRequest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_resultPaymetnUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'charset=UTF-8', 'Authorization:Basic ZGVwb3NpbGthOjVFdDhyZE41NXNERg==',
            'wfsid:'.$this->_sid, 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_resultPaymetnJson);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    private function _getRequestJson()
    {   
        $jsonArr = array();
        foreach ($this->_paymentParams as $key=>$row){
            $jsonArr [$key] = $row;
        } 
        $result = array
        (
            REQUEST_OBJECT_NAME => $jsonArr
        );
        return json_encode($result);       
    }
    
}
