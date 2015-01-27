<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : WalkerSetInputData
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: set_input_data.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/walker.inc.php';
class WalkerSetInputData extends Walker
{
var $store = array();
/////////////////////////////////////////////////////////////////////////////

function set($store)
{
     $this-> store = $store;
}
/////////////////////////////////////////////////////////////////////////////

function is_passed($key)
{
     foreach ($this-> PassedObjects as $ref)
     {
          if ($this-> Targets[$key] === $ref)
          {
               return true;
          }
     }
     return false;
}
///////////////////////////////////////////////////////////////////////////

function walk()
{
     $passed_keys = array();
     $this-> PassedObjects = array();
     foreach (array_keys($this-> store) as $key)
     {
          if (!isset($this-> Targets[$key]))
          {
               continue;
          } 
          $this-> Targets[$key]-> set_input_data($this-> store[$key]);
          $passed_keys[] = $key;
          $this-> PassedObjects[] = &$this-> Targets[$key];
     }
     foreach (array_diff(array_keys($this-> Targets), $passed_keys) as $key)
     {
          if ($this-> is_passed($key))
          {
               continue;
          }   
          $this-> Targets[$key]-> set_input_data('');
     }
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>