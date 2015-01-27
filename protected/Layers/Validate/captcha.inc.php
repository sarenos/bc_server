<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ValidateCaptha
* Version  : 1.0
* Date     : 2010.01.15
* Modified : $Id: captcha.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/validate_field.inc.php';

class ValidateCaptha extends ValidateField
{
/////////////////////////////////////////////////////////////////////////////

function ValidateCaptha($error_empty = 'captcha_empty', $error_invalid = 'captcha_invalid')
{
     $this-> error_empty = $error_empty;
     $this-> error_invalid = $error_invalid;
}
/////////////////////////////////////////////////////////////////////////////

function validate()
{
     if ($this-> parent-> is_empty())
     {
          $this-> raise_error($this-> error_empty);
          return;
     } 
     if ($_SESSION['captcha_keystring'] != $this-> parent-> get())
     {
          $this-> raise_error($this-> error_invalid);
          return;
     }
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>