<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : WalkerSetArray
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: set_array.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/walker.inc.php';
class WalkerSetArray extends Walker
{
var $store = array();
/////////////////////////////////////////////////////////////////////////////

function set($store)
{
     $this-> store = $store;
}
/////////////////////////////////////////////////////////////////////////////

function walk()
{
     foreach (array_keys($this-> store) as $key)
     {
          if (isset($this-> Targets[$key]))
          {
               $this-> Targets[$key]-> set($this-> store[$key]);
          }
     }
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>