<?php
/**************************************************************
* Project  :
* Name     : ViewTemplated
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/factory.inc.php';
class ViewTemplated
{
var $tpl;
var $Model;

/////////////////////////////////////////////////////////////////////////////

function ViewTemplated()
{
     $this-> create_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> set_tpl(produce_tpl());
}
///////////////////////////////////////////////////////////////////////////

function set_template($template_filename)
{
     if (empty($template_filename))
     {
          return;
     }
     $this-> template = $template_filename;
}
////////////////////////////////////////////////////////////////////////////

function setup_template()
{
     if (defined('SID'))
     {
          $this-> SID = preg_replace('~[^a-z\d=]~', '', SID);
          $this-> tpl-> assign('SID', $this-> SID);
          $this-> tpl-> assign('SHIDDEN', '<input type="hidden" name="'.session_name().'" value="'.session_id().'">');
     }
}
///////////////////////////////////////////////////////////////////////////

function set_tpl($tpl)
{
     $this-> tpl = $tpl;
     $this-> setup_template();
}
////////////////////////////////////////////////////////////////////////////

function set_model($Model)
{
     $this-> Model = $Model;
}
////////////////////////////////////////////////////////////////////////////

function assign($var_name, $value)
{
     $this-> tpl-> assign($var_name, $value);
}
/////////////////////////////////////////////////////////////////////////////

function fill()
{
     //must be implemented;
}
////////////////////////////////////////////////////////////////////////////

function show_page()
{
     $this-> tpl-> display($this-> template);
}
///////////////////////////////////////////////////////////////////////////

function fetch_page()
{
     return $this-> tpl-> fetch($this-> template);
}
////////////////////////////////////////////////////////////////////////////

function fill_heap_data()
{
     if (!method_exists($this-> Model, 'get_heap_data'))
     {
         return;
     }
     $tmp = $this-> Model-> get_heap_data();
     foreach ($tmp as $name=>$data)
     {
          $this-> assign($name, $data);
     }
}
///////////////////////////////////////////////////////////////////////////

function display()
{
     $this-> fill_heap_data();
     $this-> fill();
     
     $this-> assign('DEBUG_OUTPUT', str_replace('&', '&amp;', ob_get_clean()));
     $this-> show_page();
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>