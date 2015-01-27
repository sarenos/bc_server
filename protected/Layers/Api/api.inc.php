<?php

abstract class ApiLayer
{
    /**
     * 
     * @var string 
     */
    private $url;
    
    /**
     *
     * @var Memcached 
     */
    private $cache;
    ////////////////////////////////////////////////////////////////////////////
    
    public function __construct($url)
    {
        $this->url = $url;
        //$this->cache = new Memcached();
        //$this->cache->addserver('127.0.0.1', 11211);
    }
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * get_api_url
     * @return string
     */
    public function get_api_url()
    {
        return $this->url;
    }
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * 
     * @return SimpleXMLElement
     */
    protected function request()
    {
	$ch = curl_init();
	$ssl = false;
	$url_components = parse_url($this->get_api_url());
	$ssl = $url_components['scheme'] == 'https';

	curl_setopt($ch, CURLOPT_URL, $this->get_api_url());
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml', 'charset=UTF-8'));
	curl_setopt($ch, CURLOPT_POST, true);
	if ($ssl)
	{
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	}
	curl_setopt($ch, CURLOPT_POSTFIELDS, $this->get_request());
	$content = curl_exec($ch);
	curl_close($ch);
        $result = @simplexml_load_string($content);
        $this->determine_errors($result);
        return $result;
    }
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * get unique cache prefix key
     * @return string
     */
    private function get_cache_key()
    {
        return md5($this->get_api_url());
    }
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * get api response
     * @return array
     */
    public function get_response()
    {
        $result = @$this->cache->get($this->get_cache_key());
       // if (empty($result))
        {
            $this->cache->set($this->get_cache_key(), $this->parse(), 60 * 5);
            var_dump($this->cache->get($this->get_cache_key()));
            return $this->cache->get($this->get_cache_key());
        }
        
        return $result;
    }
    ////////////////////////////////////////////////////////////////////////////
    
    abstract public function get_request();
    abstract public function parse();
    
    ////////////////////////////////////////////////////////////////////////////
}