<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldRemoteAddr
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: remote_addr.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/generic.inc.php';
class FieldRemoteAddr extends FieldGeneric
{
/////////////////////////////////////////////////////////////////////////////

function fill()
{
     $this-> set(@$_SERVER['REMOTE_ADDR']);
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>