<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : UserSessionAuth
* Version  : 1.0
* Date     : 2007.05.26
* Modified : $Id: auth.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/mechanics.inc.php';

class UserSessionAuth
{
var $info_key = '_sy_default';
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
     $this-> create_objects();
     $this-> create_child_objects();
     $this-> start();
}
///////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> Mechanics = new UserSessionMechanics();
}
///////////////////////////////////////////////////////////////////////////

function create_child_objects()
{
}
///////////////////////////////////////////////////////////////////////////

function set_info_key($key)
{
     $this-> info_key = $key;
}
///////////////////////////////////////////////////////////////////////////

function get_info_key()
{
     return $this-> info_key;
}
//////////////////////////////////////////////////////////////////////////

function is_logged()
{
     return !empty($_SESSION[$this-> info_key]['is_logged']) &&
     ($_SESSION[$this-> info_key]['is_logged'] == true);
}
/////////////////////////////////////////////////////////////////////////////

function set_info($Info)
{
     $_SESSION[$this-> info_key] = $Info; 
}
function get_info()
{
     return (array)@$_SESSION[$this-> info_key];
}
///////////////////////////////////////////////////////////////////////////

function set_id_session($Id)
{
     $_SESSION[$this-> info_key]['id_session'] = $Id-> get();
}
///////////////////////////////////////////////////////////////////////////

function get_id_session()
{
     return new FieldId((int)@$_SESSION[$this-> info_key]['id_session']);
}
///////////////////////////////////////////////////////////////////////////

function set_expiration_minutes($expiration_minutes)
{
     $this-> expiration_minutes = $expiration_minutes;
}
//////////////////////////////////////////////////////////////////////////

function get_entity_instance()
{
     return new Entity();
}
///////////////////////////////////////////////////////////////////////////

function get_sessioned()
{ 
     $result = $this-> get_entity_instance();
     if (!$this-> is_logged())
     {
          return $result;
     }
     $result-> set_array($this-> get_info());
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function update_sessioned($Account)
{
     $this-> set_info(array_merge($this-> get_info(), $Account-> get_array()));
}
///////////////////////////////////////////////////////////////////////////

function is_expired()
{
     if (empty($this-> expiration_minutes) || 
         empty($_SESSION[$this-> info_key]['last_action']) ||
         !$this-> is_logged())
     {
          return false;
     }
     return ($_SESSION[$this-> info_key]['last_action'] + $this-> expiration_minutes*60) < time();
}
///////////////////////////////////////////////////////////////////////////

function start()
{
     $this-> Mechanics-> start();
     if (!$this-> Mechanics-> is_valid_user())
     {
          $this-> Mechanics-> restart();
     }
     if ($this-> is_expired())
     {
          $this-> Mechanics-> restart();
     }
     $_SESSION[$this-> info_key]['last_action'] = time();
}
///////////////////////////////////////////////////////////////////////////

function finish()
{
     $this-> Mechanics-> close();
}
///////////////////////////////////////////////////////////////////////////

function login()
{
     $_SESSION[$this-> info_key]['is_logged'] = true;
}
/////////////////////////////////////////////////////////////////////////////

function logout()
{
     $_SESSION[$this-> info_key] = array('is_logged' => false);
     $_SESSION[$this-> info_key] = array();
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>