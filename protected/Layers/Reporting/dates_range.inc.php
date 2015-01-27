<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : DatesRange
* Version  : 1.0
* Date     : 2012.01.11
* Modified : $Id: dates_range.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/Fields/date.inc.php';
class DatesRange
{
var $field_name = '';
/////////////////////////////////////////////////////////////////////////////

function DatesRange()
{
     $this-> create_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> From = new FieldDate();
     $this-> To = new FieldDate();
}
///////////////////////////////////////////////////////////////////////////

function set_field_name($field_name)
{
     $this-> field_name = $field_name;
}
//////////////////////////////////////////////////////////////////////////

function set_from($from)
{
     $this-> From-> set($from);
}
//////////////////////////////////////////////////////////////////////////

function set_to($to)
{
     $this-> To-> set($to);
}
//////////////////////////////////////////////////////////////////////////

function set_array($range)
{
     $this-> set_from(@$range['from']);
     $this-> set_to(@$range['to']);
}
///////////////////////////////////////////////////////////////////////////

function has_interval()
{
     return !($this-> From-> is_empty() && $this-> To-> is_empty());
}
////////////////////////////////////////////////////////////////////////////

function get_sql_condition()
{
     if (!$this-> has_interval())
     {
          return '1';
     }
     if ($this-> From-> is_empty())
     {
          return $this-> field_name." <= ".$this-> To-> get_db_context();
     }
     if ($this-> To-> is_empty())
     {
          return $this-> field_name." >= ".$this-> From-> get_db_context();
     }
     return $this-> field_name." BETWEEN ".$this-> From-> get_db_context() .' AND '.$this-> To-> get_db_context();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>