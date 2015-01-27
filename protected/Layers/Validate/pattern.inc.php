<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ValidatePattern
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: pattern.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/validate_field.inc.php';

class ValidatePattern extends ValidateField
{
/////////////////////////////////////////////////////////////////////////////

function ValidatePattern($error_code = 'invalid_pattern', $pattern = '~^.+$~')
{
     $this-> set_error_code($error_code);
     $this-> set_pattern($pattern);
}
///////////////////////////////////////////////////////////////////////////

function set_error_code($error_code)
{
     $this-> error_code = $error_code;
}
//////////////////////////////////////////////////////////////////////////

function set_pattern($pattern)
{
     $this-> pattern = $pattern;
}
//////////////////////////////////////////////////////////////////////////

function validate()
{
     $this-> parent-> reset_error();
     if (!preg_match($this-> pattern, $this-> parent-> get()))
     {
          $this-> raise_error($this-> error_code);
     }
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>