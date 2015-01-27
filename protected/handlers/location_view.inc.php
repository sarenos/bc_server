<?php
/**************************************************************
* Project  :
* Name     : MainPriceView
* Version  : 1.0
* Date     : 2010.03.09
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class LocationView extends ViewTemplated
{
////////////////////////////////////////////////////////////////////////////

function has_params()
{
     return FALSE !== strpos($this-> url, '?');
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
          $this-> url .= '&'.$this-> SID;
     }
}
///////////////////////////////////////////////////////////////////////////

function display()
{
     $this-> url = $this-> Model-> get_redirect_url();
     $this-> add_session_to_url();
     header('Location: '.$this-> url);
     die();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>