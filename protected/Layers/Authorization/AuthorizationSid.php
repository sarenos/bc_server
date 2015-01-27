<?php
class AuthorizationSid
{
    private $_sidUrl;
    private $_login;
    private $_password;
    private $_sidXml;

     public function __construct()
    {
        $this->_sidUrl = 'https://10.1.246.11:9097/ChameleonServer/UA/sessions/open?lang=ua';
        $this->_login = 'deposilka';
        $this->_password = '8m6mdvfc2u781g9xf2ocse2wnqyw8y4319b3dda';
        $this->_sidXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><session>
        <user auth="EXCL" login="'.$this->_login.'" password="'.$this->_password.'"/>
        </session>';
    }
    
    
    public function getSid()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_sidUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml', 'charset=UTF-8'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_sidXml);
        $content = curl_exec($ch);
        curl_close($ch);
        $result = @simplexml_load_string($content);
        if($result instanceof SimpleXMLElement){
            if(isset($result['value']))
            {
                return strval($result['value']);
            }
        }
        return '';
    }
}
?>
