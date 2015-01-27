<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : DownloadHttpHandler
* Version  : 1.0
* Date     : 2007.06.02
* Modified : $Id: http_handler.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/HTTP/browser.inc.php';

class DownloadHttpHandler extends HttpBrowser
{
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
     parent::__construct();
     $this-> create_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> no_cookies();
     $this-> no_ssl_verify();
}
///////////////////////////////////////////////////////////////////////////

function get_base_url()
{
     $result = parse_url($this-> get_url());
     return 'http://'.@$result['host'];
}
//////////////////////////////////////////////////////////////////////////

function set_proxy_object($Proxy)
{
     $this-> set_proxy($Proxy-> get_curl_proxy());
}
//////////////////////////////////////////////////////////////////////////

function is_valid()
{
     return !$this-> has_error() && $this-> get_status_code() == 200;
}
///////////////////////////////////////////////////////////////////////////

function download()
{
     return $this-> request();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>