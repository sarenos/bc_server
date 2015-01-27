<?php
class RequestAccount
{    
    private $_casherAccountParams;
    private $_casherAccountUrl;

    public function __construct($casherAccountParams, $casherAccountUrl)
    {
        $this->_casherAccountParams = $casherAccountParams;
        $this->_casherAccountUrl = $casherAccountUrl;
    }
    
    public function run ()
    {
        return  $this->_sendRequest();
    }
    
    private function _sendRequest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_casherAccountUrl . '?' . $this->_get_request());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }   
    
    private function _get_request()
    {
        $array = array();
        foreach($this->_casherAccountParams as $key=>$row)
        {
            $array[$key] = $row;
        }
        return http_build_query($array);
    }
}
