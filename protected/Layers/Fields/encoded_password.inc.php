<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldEncodedPassword
* Version  : 1.0
* Date     : 2007.08.13
* Modified : $Id: encoded_password.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/generic.inc.php';

class FieldEncodedPassword extends FieldGeneric
{
/////////////////////////////////////////////////////////////////////////////

function set_salt($Salt)
{
     $this-> Salt = $Salt;
}
//////////////////////////////////////////////////////////////////////////

function set_password($Password)
{
     $this-> Password = $Password;
}
//////////////////////////////////////////////////////////////////////////

function encode()
{
     $this-> set_value(md5($this-> Salt-> get().$this-> Password-> get().$this-> Salt-> get()));
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>