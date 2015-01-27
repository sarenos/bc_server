<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ValidateLength
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: length.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/validate_field.inc.php';

class ValidateLength extends ValidateField
{
/////////////////////////////////////////////////////////////////////////////

function ValidateLength($error_code = 'no_value', $min = 0, $max = 65535)
{
     $this-> set_error_code($error_code);
     $this-> min = $min;
     $this-> max = $max;
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
          return;
     }
     $len = $this-> parent-> get_length();
     if(!(($this-> min <= $len) && ($len <= $this-> max)))
     {
          $this-> raise_error($this-> error_code);
     }
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>