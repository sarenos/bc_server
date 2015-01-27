<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : DBLocker
* Version  : 1.0
* Date     : 2007.09.18
* Modified : $Id: locker.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
define('DBLOCKER_INFINITE', 84600);
class DBLocker
{
protected $timeout = DBLOCKER_INFINITE;
protected $token = '';
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
     $this-> db = produce_db();
}
///////////////////////////////////////////////////////////////////////////

function set_token($token)
{
     $this-> token = $token;
}
//////////////////////////////////////////////////////////////////////////

function set_timeout($timeout)
{
     $this-> timeout = $timeout;
}
//////////////////////////////////////////////////////////////////////////

function lock()
{
     $this-> db-> exec_query(
     "SELECT GET_LOCK('".$this-> db-> escape_str($this-> token)."', ".$this-> timeout.")");
     return $this-> db-> get_one();
}
///////////////////////////////////////////////////////////////////////////

function unlock()
{
     $this-> db-> exec_query(
     "SELECT RELEASE_LOCK('".$this-> db-> escape_str($this-> token)."')");
     return $this-> db-> get_one();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>