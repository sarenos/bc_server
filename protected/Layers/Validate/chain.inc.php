<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ValidateChain
* Version  : 1.0
* Date     : 2007.05.24
* Modified : $Id: chain.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/validate_field.inc.php';

class ValidaterChain extends ValidateField
{
/////////////////////////////////////////////////////////////////////////////

function ValidaterChain()
{
     $this-> chain = func_get_args();
}
/////////////////////////////////////////////////////////////////////////////

function set_parent(&$parent)
{
     foreach (array_keys($this-> chain) as $key)
     {
          $this-> chain[$key]-> set_parent($parent);
     }
     $this-> parent = &$parent;
}
////////////////////////////////////////////////////////////////////////////

function validate()
{
     foreach (array_keys($this-> chain) as $key)
     {
          $this-> chain[$key]-> validate();
          if ($this-> parent-> has_error())
          {
               return;
          }
     }
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>