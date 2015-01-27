<?php
/**************************************************************
* Project  : 
* Name     : ValidateDBUniqe
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/validate_field.inc.php';

class ValidateDBUnique extends ValidateField
{
/////////////////////////////////////////////////////////////////////////////

function ValidateDBUnique($error_code = 'no_value')
{
     $this-> set_error_code($error_code);
}
///////////////////////////////////////////////////////////////////////////

function set_error_code($error_code)
{
     $this-> error_code = $error_code;
}
//////////////////////////////////////////////////////////////////////////

function is_unique()
{
     $Gamer = new Gamer();
     $Gamer-> set_email($this-> parent);
     $Gamer-> load_by_email();
     return !$Gamer-> is_exists();
}
//////////////////////////////////////////////////////////////////////////

function validate()
{
     $this-> parent-> reset_error();
     if (!$this-> is_unique())
     {
          $this-> raise_error($this-> error_code);
     }
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>