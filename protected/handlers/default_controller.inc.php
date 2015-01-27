<?php
/**************************************************************
* Project  : 
* Name     : DefaultController
* Version  : 1.0
* Date     : 2010.02.14
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once HANDLERS_DIR.'/main_model.inc.php';
require_once HANDLERS_DIR.'/simple_controller.inc.php';
require_once HANDLERS_DIR.'/view_ajax.inc.php';

class DefaultController extends SimpleController
{
/////////////////////////////////////////////////////////////////////////////

function __construct($class_prefix, $path)
{
     parent:: __construct();
     $this-> set_class_prefix($class_prefix);
     $this-> set_path($path);
}
///////////////////////////////////////////////////////////////////////////

function set_class_prefix($class_prefix)
{
     $this-> class_prefix = $class_prefix;
}
//////////////////////////////////////////////////////////////////////////

function set_path($path)
{
     $this-> path = $path;
}
//////////////////////////////////////////////////////////////////////////

function get_model()
{
     require_once $this-> path.'/model.inc.php';
     $class_name = $this-> class_prefix.'Model';
     return new $class_name;
}
///////////////////////////////////////////////////////////////////////////

function get_view()
{
     if ($this-> Model-> is_ajax())
     {
          return new ViewAjax();
     }
     
     if (file_exists($this-> path.'/view.inc.php'))
     {
          require_once $this-> path.'/view.inc.php';
          $class_name = $this-> class_prefix.'View';
          return new $class_name;
     }
     
     return null;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>