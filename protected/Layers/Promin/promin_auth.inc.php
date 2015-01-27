<?php

require_once LAYERS_DIR . '/Promin/promin.inc.php';
require_once LAYERS_DIR . '/Api/api.inc.php';

abstract class ProminAuthLayer extends ApiLayer
{
    private $ProminLayer;
    ////////////////////////////////////////////////////////////////////////////
    
    public function __construct($url)
    {
        parent::__construct($url);
        $this->ProminLayer = new ProminLayer();
    }
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * get promin session string(hash code)
     * @return string
     */
    public function get_sid()
    {
        return $this->ProminLayer->get_response();
    }
    ////////////////////////////////////////////////////////////////////////////
}
