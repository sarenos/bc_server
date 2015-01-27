<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : DatesRange
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: datetimes_range.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/Fields/datetime.inc.php';
class DateTimesRange
{
var $field_name = '';
/////////////////////////////////////////////////////////////////////////////

function DateTimesRange()
{
     $this-> create_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> From = new FieldDateTime();
     $this-> From-> now();
     $this-> From-> set_input_data($this-> From-> get_date().' 00:00:00');
     $this-> To = new FieldDateTime();
     $this-> To-> now();
     $this-> To-> set_input_data($this-> To-> get_date().' 23:59:59');
}
///////////////////////////////////////////////////////////////////////////

function set_from($from)
{
     if (empty($from))
     {
          $from = '2006-06-06';
     }
     if (strlen($from) == 10)
     {
          $from .= ' 00:00:00';
     }
     $this-> From-> set_input_data($from);
}
//////////////////////////////////////////////////////////////////////////

function set_to($to)
{
     if (empty($to))
     {
          return;
     }
     if (strlen($to) == 10)
     {
          $to .= ' 23:59:59';
     }
     $this-> To-> set_input_data($to);
}
//////////////////////////////////////////////////////////////////////////

function set_one($date)
{
     $this-> set_from($date);
     $this-> set_to($date);
}
///////////////////////////////////////////////////////////////////////////

function get_array()
{
     return array('from'=> $this-> From-> get_form_context(), 'to'=> $this-> To-> get_form_context());
}
///////////////////////////////////////////////////////////////////////////

function set_array($range)
{
     $this-> set_from(trim(@$range['from']));
     $this-> set_to(trim(@$range['to']));
}
///////////////////////////////////////////////////////////////////////////

function set_field_name($field_name)
{
     $this-> field_name = $field_name;
}
//////////////////////////////////////////////////////////////////////////

function get_field_name()
{
     return $this-> field_name;
}
//////////////////////////////////////////////////////////////////////////

function get_sql_condition()
{
     return $this-> field_name." BETWEEN ".$this-> From-> get_db_context() .' AND '.$this-> To-> get_db_context();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>