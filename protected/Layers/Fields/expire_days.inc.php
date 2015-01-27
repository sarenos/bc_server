<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldExpireDays
* Version  : 1.0
* Date     : 2010.02.09
* Modified : $Id: expire_days.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/generic.inc.php';
class FieldExpireDays extends FieldDate
{
/////////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $days = $this-> value;
     $this-> now();
     $this-> interval("+".$days." days");
}
///////////////////////////////////////////////////////////////////////////

function get_form_context()
{
     $result = (int)ceil(($this-> get_stamp() - time())/86400);
     if ($result < 0)
     {
          $result = 0;
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>