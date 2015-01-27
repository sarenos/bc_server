<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldSerialized
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: serialized.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/generic.inc.php';
class FieldSerialized extends FieldGeneric
{
/////////////////////////////////////////////////////////////////////////////

function get_db_context()
{
     return $this-> get_mysql_string_context(serialize($this-> get()));
}
///////////////////////////////////////////////////////////////////////////

function set_db_context($db_value)
{
     if (empty($db_value))
     {
          $this-> set_value(null);
     }
     $this-> set_value(unserialize($db_value));
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>