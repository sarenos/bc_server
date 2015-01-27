<?php
/**************************************************************
* Project  : 
* Name     : Starter
* Version  : 1.0
* Date     : 2011.05.01
* Modified : $Id: starter.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once HANDLERS_DIR.'/default_controller.inc.php';

class Starter
{
static $controller_class = 'DefaultController';
/////////////////////////////////////////////////////////////////////////////

static function set_controller_class($controller_class)
{
     self::$controller_class = $controller_class;
}
//////////////////////////////////////////////////////////////////////////

static function standart_run($handler_path, $name, $is_default_controller = true)
{
     $path = rtrim(HANDLERS_DIR.'/'.$handler_path, '/');
     if (!$is_default_controller)
     {
          require_once $path.'/controller.inc.php';
          self::set_controller_class($name.'Controller');
     }
     $Controller = new self::$controller_class($name, $path);
     $Controller-> run();
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>