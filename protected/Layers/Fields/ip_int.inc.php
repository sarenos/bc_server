<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldIPInt
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: ip_int.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/generic.inc.php';

class FieldIPInt extends FieldGeneric
{
/////////////////////////////////////////////////////////////////////////////

function set_from_str($str)
{
     $this-> set(sprintf("%u", ip2long($str)));
}
///////////////////////////////////////////////////////////////////////////

function get_str()
{
     return long2ip($this-> value);
}
///////////////////////////////////////////////////////////////////////////

function copy_from_str($Obj)
{
     $this-> set_from_str($Obj-> get());
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>