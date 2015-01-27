<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : Sheduler
* Version  : 1.0
* Date     : 2011.01.11
* Modified : $Id: sheduler.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
define('SHEDULER_LOKER_FILES_DIR', ABS_PATH.'/data/sheduler');
require_once LAYERS_DIR.'/DB/mysql.inc.php';

class Sheduler
{
var $uniqe_name = 'default';
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
}
/////////////////////////////////////////////////////////////////////////////

function set_uniqe_name($uniqe_name)
{
     $this-> uniqe_name = $uniqe_name;
}
////////////////////////////////////////////////////////////////////////////

function get_uniqe_name()
{
     return $this-> uniqe_name;
}
////////////////////////////////////////////////////////////////////////////

function set_target(&$Target)
{
     $this-> Target = &$Target;
}
/////////////////////////////////////////////////////////////////////////////

function has_instance()
{
     if (!($this-> fd_lock = fopen(SHEDULER_LOKER_FILES_DIR.'/'.$this-> uniqe_name, "w+")))
     {
          return true;
     }
     if (!fwrite($this-> fd_lock, 'let\'s try to write!'))
     {
          return true;
     }
     if ($res = flock($this-> fd_lock, LOCK_EX|LOCK_NB))
     {
          chmod(SHEDULER_LOKER_FILES_DIR.'/'.$this-> uniqe_name, 0666);
          fwrite($this-> fd_lock,  "\n".getmypid());
          return false;
     }
     fclose($this-> fd_lock);
     return true;
}
/////////////////////////////////////////////////////////////////////////////

function release()
{
     flock($this-> fd_lock, LOCK_UN);
     fclose($this-> fd_lock);
}
///////////////////////////////////////////////////////////////////////////

function run()
{
     umask(0);
     if ($this-> has_instance())
     {
          return;
     }
     if (!empty($this-> Target))
     {
          $this-> Target-> run();
     }
     $this-> release();
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>