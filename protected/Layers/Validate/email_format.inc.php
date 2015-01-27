<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ValidateEmailFormat
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: email_format.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/validate_field.inc.php';
class ValidateEmailFormat extends ValidateField
{
////////////////////////////////////////////////////////////////////////////

function ValidateEmailFormat($error_code = 'email_format')
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
     if ($this-> parent-> is_empty())
     {
          return;
     }
     if (!$this-> parent-> is_valid_format())
     {
          $this-> raise_error($this-> error_code);
          return;
     }
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>