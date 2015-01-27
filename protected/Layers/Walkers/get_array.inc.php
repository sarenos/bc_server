<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : WalkerGetArray
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: get_array.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/walker.inc.php';
class WalkerGetArray extends Walker
{
var $store = array();
/////////////////////////////////////////////////////////////////////////////

function get()
{
     return $this-> store;
}
/////////////////////////////////////////////////////////////////////////////

function walk()
{
     $this-> store = array();
     foreach (array_keys($this-> Targets) as $key)
     {
          $this-> store[$key] = $this-> Targets[$key]-> get();
     }
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>