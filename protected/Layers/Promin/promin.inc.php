<?php

require_once LAYERS_DIR . '/Api/api.inc.php';

class ProminLayer extends ApiLayer
{
    public function __construct()
    {
        parent::__construct('https://10.1.246.11:9097/ChameleonServer/UA/sessions/open?lang=ua');
    }
    ////////////////////////////////////////////////////////////////////////////
    
    public function get_request()
    {
        #$login = 'UTSM';
        $login = 'deposilka';
        #$password = 'GFhJUKIghFgh';
        $password = '8m6mdvfc2u781g9xf2ocse2wnqyw8y4319b3dda';

        $result = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
            <session>
                <user auth="EXCL" login="' . $login . '" password="' . $password . '"/>
            </session>';
        return $result;
    }
    ////////////////////////////////////////////////////////////////////////////
    
    public function parse()
    {
        return strval($this->request()->attributes()->value);
    }
    ////////////////////////////////////////////////////////////////////////////
    
    public function determine_errors(SimpleXMLElement $response)
    {
        if (!empty($response->attributes()->code))
        {
            throw new Exception('API URL : ' . $this->get_api_url() . ', code: '
                    . strval($response->attributes()->code)
                    . ', message: '
                    . strval($response->attributes()->text)
                    );
        }
    }
    ////////////////////////////////////////////////////////////////////////////
};
