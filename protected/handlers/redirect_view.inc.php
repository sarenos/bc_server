<?php
/**************************************************************
* Project  :
* Name     : RedirectView
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once HANDLERS_DIR.'/view_templated.inc.php';
class RedirectView extends ViewTemplated
{
////////////////////////////////////////////////////////////////////////////

function has_params()
{
     return FALSE !== strpos($this-> url, '?');
}
///////////////////////////////////////////////////////////////////////////

function get_redirect_template()
{
     return 'redirect.tpl.htm';
}
///////////////////////////////////////////////////////////////////////////

function add_session_to_url()
{
     if (empty($this-> SID))
     {
          return;
     }
     if (!$this-> has_params())
     {
          $this-> url .= '?'.$this-> SID;
     }
     else
     {
          $this-> url .= '&amp;'.$this-> SID;
     }

}
///////////////////////////////////////////////////////////////////////////

function fill()
{
     $this-> set_template($this-> get_redirect_template());
     $this-> url = $this-> Model-> get_redirect_url();
     $this-> add_session_to_url();
     $this-> tpl-> assign('RedirectUrl', $this-> url);
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>