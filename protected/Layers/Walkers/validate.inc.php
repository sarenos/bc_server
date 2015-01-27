<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : WalkerValidate
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: validate.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/walker.inc.php';
class WalkerValidate extends Walker
{
////////////////////////////////////////////////////////////////////////////

function walk()
{
     foreach (array_keys($this-> Targets) as $key)
     {
          $this-> Targets[$key]-> validate();
     }
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>