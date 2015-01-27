<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ValidateUrl
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: url.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/validate_field.inc.php';

class ValidateUrl extends ValidateField
{
/////////////////////////////////////////////////////////////////////////////

function ValidateUrl($error_code_empty = 'no_value', $error_code_invalid_format = 'no_value')
{
     $this-> set_error_code_empty($error_code_empty);
     $this-> set_error_code_invalid_format($error_code_invalid_format);
}
///////////////////////////////////////////////////////////////////////////

function set_error_code_empty($error_code_empty)
{
     $this-> error_code_empty = $error_code_empty;
}
//////////////////////////////////////////////////////////////////////////

function set_error_code_invalid_format($error_code_invalid_format)
{
     $this-> error_code_invalid_format = $error_code_invalid_format;
}
//////////////////////////////////////////////////////////////////////////

function validate()
{
     $this-> parent-> reset_error();
     if ($this-> parent-> is_empty())
     {
          $this-> raise_error($this-> error_code_empty);
          return;
     }
     if (!$this-> parent-> is_valid_format())
     {
          $this-> raise_error($this-> error_code_invalid_format);
          return;
     }
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>