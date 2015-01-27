<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : DateTimedTotals
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: datetimed_totals.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/datetimes_range.inc.php';

class DateTimedTotals
{
/////////////////////////////////////////////////////////////////////////////

function DateTimedTotals($table_name = '', $dt_field_name = '')
{
     $this-> create_objects();
     $this-> create_child_objects();
     $this-> set_table_name($table_name);
     $this-> set_dt_field_name($dt_field_name);
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> Dates = new DateTimesRange();
     $this-> db = produce_db();
}
///////////////////////////////////////////////////////////////////////////

function create_child_objects()
{
     
}
///////////////////////////////////////////////////////////////////////////

function set_table_name($table_name)
{
     $this-> table_name = $table_name;
}
//////////////////////////////////////////////////////////////////////////

function get_table_name()
{
     return $this-> table_name;
}
///////////////////////////////////////////////////////////////////////////

function set_dt_field_name($dt_field_name)
{
     $this-> dt_field_name = $dt_field_name;
     $this-> Dates-> set_field_name($this-> dt_field_name);
}
//////////////////////////////////////////////////////////////////////////

function get_dt_field_name()
{
     return $this-> dt_field_name;
}
///////////////////////////////////////////////////////////////////////////

function set_critery($Critery)
{
     $this-> set_dates_array($Critery['Dates']);
}
///////////////////////////////////////////////////////////////////////////

function set_dates_array($range)
{
     $this-> Dates-> set_array($range);
}
///////////////////////////////////////////////////////////////////////////

function get_dates_array()
{
     return $this-> Dates-> get_array();
}
///////////////////////////////////////////////////////////////////////////

function get_where_part()
{
     return " WHERE ".$this-> Dates-> get_sql_condition();
}
///////////////////////////////////////////////////////////////////////////

function get_count()
{
     $this-> db-> exec_query("
     SELECT COUNT(*) AS cnt
     FROM `".$this-> get_table_name()."`
     ".$this-> get_where_part());

     $result = $this-> db-> get_one();
     if (empty($result))
     {
          return null;
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>