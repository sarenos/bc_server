<?php
/**************************************************************
* Project  :
* Name     : JustViewController
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

require_once HANDLERS_DIR.'/simple_controller.inc.php';
require_once HANDLERS_DIR.'/view_templated.inc.php';

class JustViewController extends SimpleController
{
/////////////////////////////////////////////////////////////////////////////

function JustViewController($template = '')
{
     $this-> set_template($template);
     $this-> create_objects();
     $this-> create_child_objects();
}
///////////////////////////////////////////////////////////////////////////

function set_template($template)
{
     $this-> template = $template;
}
//////////////////////////////////////////////////////////////////////////

function get_view()
{
     $result = new ViewTemplated();
     $result-> set_template($this-> template);
     return $result;
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>