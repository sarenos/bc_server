<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldInt
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: int.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/generic.inc.php';
class FieldInt extends FieldGeneric
{
protected $positive_only;
/////////////////////////////////////////////////////////////////////////////

function get_default_value()
{
     return 0;
}
///////////////////////////////////////////////////////////////////////////

function positive_only()
{
     $this-> positive_only = true;
}
////////////////////////////////////////////////////////////////////////////

function not_positive_only()
{
     $this-> positive_only = false;
}
////////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $this-> set_value((int)$this-> value);
     if (!empty($this-> positive_only))
     {
          $this-> set_value(max($this-> value, 0));
     }
}
/////////////////////////////////////////////////////////////////////////////

function inc($value=1)
{
     $this-> set($this-> get() + $value);
}
/////////////////////////////////////////////////////////////////////////////

function dec($value=1)
{
     $this-> set($this-> get() - $value);
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>