<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : UserSessionMechanics
* Version  : 1.0
* Date     : 2007.05.26
* Modified : $Id: mechanics.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class UserSessionMechanics
{
/////////////////////////////////////////////////////////////////////////////

function UserSessionMechanics()
{ 
}
/////////////////////////////////////////////////////////////////////////////

function is_started()
{
     return (bool)session_id();
}
///////////////////////////////////////////////////////////////////////////

function is_valid_user()
{
     return (string)@$_SESSION['_sy_identify'] == $this-> get_identify_hash();
}
///////////////////////////////////////////////////////////////////////////

function get_identify_hash()
{
//     $vars = array('HTTP_USER_AGENT', 'REMOTE_ADDR', 'HTTP_ACCEPT_CHARSET', 'HTTP_FROM', 'HTTP_X_FORWARDED_FOR');
	$vars = array('to', 'do', 'this');
     $result = '';
     foreach($vars as $name)
     {
          $result .= (string)@$_SERVER[$name];
     }
     return md5($result);
}
///////////////////////////////////////////////////////////////////////////

function has_identify()
{
     return !empty($_SESSION['_sy_identify']);
}
///////////////////////////////////////////////////////////////////////////

function store_identify()
{
     $_SESSION['_sy_identify'] = $this-> get_identify_hash();
}
///////////////////////////////////////////////////////////////////////////

function start()
{
     session_name(SESSION_NAME);
     @session_start();
     if (!$this-> has_identify())
     {
          $this-> store_identify();
     }
}
///////////////////////////////////////////////////////////////////////////

function destroy()
{
     if ($this-> is_started())
     {
          $_SESSION = array();
          session_destroy();
     }
}
///////////////////////////////////////////////////////////////////////////

function close()
{
     session_write_close();
}
///////////////////////////////////////////////////////////////////////////

function restart()
{
     session_write_close();
     session_id(md5(uniqid(rand(), true)));
     session_start();
     $this-> store_identify();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>