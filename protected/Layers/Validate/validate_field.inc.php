<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ValidateField
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: validate_field.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class ValidateField
{
var $parent;
/////////////////////////////////////////////////////////////////////////////

function set_parent(&$parent)
{
     $this-> parent = &$parent;
}
////////////////////////////////////////////////////////////////////////////

function raise_error($code)
{
     $this-> parent-> raise_error($code);
}
///////////////////////////////////////////////////////////////////////////

function validate()
{
     //implementation
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>