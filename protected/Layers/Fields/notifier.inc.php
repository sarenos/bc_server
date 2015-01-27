<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldNotifier
* Version  : 1.0
* Date     : 2010.03.24
* Modified : $Id: notifier.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/generic.inc.php';

class FieldNotifier extends FieldGeneric
{
/////////////////////////////////////////////////////////////////////////////

function __construct($Owner)
{
     $this-> set_owner($Owner);
}
///////////////////////////////////////////////////////////////////////////

function set_owner($Owner)
{
     $this-> Owner = $Owner;
}
///////////////////////////////////////////////////////////////////////////

function direct_set($value)
{
     parent::set_value($value);
}
///////////////////////////////////////////////////////////////////////////

function set_value($value)
{
     parent::set_value($value);
     if (!empty($this-> Owner))
     {
          $this-> Owner-> notify_changed();
     }
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>