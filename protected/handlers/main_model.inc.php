<?php

require_once LAYERS_DIR . '/Customer/customer_auth.inc.php';
require_once LAYERS_DIR . '/HTTP/browser.inc.php';
require_once dirname(__FILE__) .'/data_model.inc.php';
require_once LAYERS_DIR.'/Exception/exception_process.inc.php';
                       
class MainModel extends DataModel
{
protected $Result   = array();
protected $is_ajax  = false;
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
	$this-> Browser = new HTTPBrowser();
	$this-> Browser-> no_cookies();

	$this-> CustomerAuth  = new CustomerAuth();
	$this-> Customer      = $this-> CustomerAuth-> get_sessioned();
	
	parent::__construct();
}
///////////////////////////////////////////////////////////////////////////

function get_result()
{
	return $this-> Result;
}
////////////////////////////////////////////////////////////////////////////

function is_ajax()
{
	return $this-> is_ajax;
}
////////////////////////////////////////////////////////////////////////////

function redirect_to_main()
{
     $this-> redirect_url  = HTTP_ABS_PATH . '/index.php';
     $this-> need_redirect = true;
}
////////////////////////////////////////////////////////////////////////////

function redirect_self()
{
     $this-> redirect_url  = $_SERVER['REQUEST_URI'];
     $this-> need_redirect = true;
}
////////////////////////////////////////////////////////////////////////////

function get_heap_data()
{
     $result = parent:: get_heap_data();
     return $result;
}
////////////////////////////////////////////////////////////////////////////

function redirect($redirectUrl)
{
	$this-> redirect_url = $redirectUrl;
	$this-> need_redirect = true;
}
////////////////////////////////////////////////////////////////////////////

function explode_and_replace_char($str, $char)
{
	$result = '';
	foreach(explode($char, $str) as $part)
	{
		$result .= '_' . strtolower($part);
	}

	return $result;
}
////////////////////////////////////////////////////////////////////////////

function replace_spaces($str)
{
	return $this-> explode_and_replace_char($str, ' ');
}
////////////////////////////////////////////////////////////////////////////

function replace_minuses($str)
{
	return $this-> explode_and_replace_char($str, '-');
}
////////////////////////////////////////////////////////////////////////////

function compile_actions_method_name($action_name)
{
     $Action_name_parts_list = explode('-', $action_name);
     $result = 'action';
     foreach($Action_name_parts_list as $action_name_part)
     {
          $result .= '_' . strtolower($action_name_part);
     }
     
     return $result;
}
////////////////////////////////////////////////////////////////////////////

private function get_action_name()
{
     if (isset ($_POST['action']))
     {
          return $_POST['action'];
     }
     
     if (isset($_GET['action']))
     {
          return $_GET['action'];
     }
     return 'default';
}
////////////////////////////////////////////////////////////////////////////

private function call_actions_method($method_name)
{
     if (method_exists($this, $method_name))
     {
          $this-> $method_name();
     }
}
////////////////////////////////////////////////////////////////////////////

function determine_action()
{
     $this-> call_actions_method(
             $this-> compile_actions_method_name(
                     $this-> get_action_name()));
}
////////////////////////////////////////////////////////////////////////////

function format_date($original='', $format="%m/%d/%Y")
{
	if (empty($original))
	{
		return '';
	}
	if ($format == 'date' || $format == 'mysql-date')
	{
		return strftime("%Y-%m-%d", strtotime($original));
	}
	if ($format == 'datetime' || $format == 'mysql-datetime')
	{
		return strftime("%Y-%m-%d %H:%M:%S", strtotime($original));
	}

	return strftime($format, strtotime($original));
}
////////////////////////////////////////////////////////////////////////////

function get_current_time()
{
	return date('Y-m-d H:i:s');
}
////////////////////////////////////////////////////////////////////////////

function get_contents($url)
{
	$this-> Browser-> set_url($url);
	if (!$this-> Browser-> request())
     {
     	var_dump("error no: " . $this-> get_error_no());
		var_dump("error msg: " . $this-> get_error_message());
          return '';
     }
	return $this-> Browser-> get_page();
}
///////////////////////////////////////////////////////////////////////////

function run()
{
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>