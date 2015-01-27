<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ValidateNotEmpty
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: not_empty.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/validate_field.inc.php';

class ValidateNotEmpty extends ValidateField
{
/////////////////////////////////////////////////////////////////////////////

function ValidateNotEmpty($error_code = 'no_value')
{
     $this-> set_error_code($error_code);
}
///////////////////////////////////////////////////////////////////////////

function set_error_code($error_code)
{
     $this-> error_code = $error_code;
}
//////////////////////////////////////////////////////////////////////////

function validate()
{
     $this-> parent-> reset_error();
     if ($this-> parent-> is_empty())
     {
          $this-> raise_error($this-> error_code);
     }
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>