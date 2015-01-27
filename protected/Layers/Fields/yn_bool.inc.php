<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldYNBool
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: yn_bool.inc.php,v c4acc1159494 2012/02/06 12:32:10 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/enum.inc.php';
class FieldYNBool extends FieldGeneric
{
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
     parent::__construct();
     $this-> value = 'N';
}
///////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $this-> value = (string)@$this-> value;
     if ($this-> value == 'N')
     {
          return;
     }
     if (!empty($this-> value))
     {
          $this-> value = 'Y';
          return;
     }
     $this-> value = 'N';
}
///////////////////////////////////////////////////////////////////////////

function set_bool($is_set)
{
     if (!$is_set)
     {
          $this-> set_value('N');
     }
     else
     {
          $this-> set_value('Y');
     }
}
///////////////////////////////////////////////////////////////////////////

function is_set()
{
     return $this-> value == 'Y';
}
/////////////////////////////////////////////////////////////////////////////

function on()
{
     $this-> set_value('Y');
}
///////////////////////////////////////////////////////////////////////////

function off()
{
     $this-> set_value('N');
}
///////////////////////////////////////////////////////////////////////////

function yes()
{
     $this-> on();
}
///////////////////////////////////////////////////////////////////////////

function no()
{
     $this-> off();
}
///////////////////////////////////////////////////////////////////////////

function is_empty()
{
     return !$this-> is_set();
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>