<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : DBBasicActions
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: basic_actions.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/mysql.inc.php';
require_once LAYERS_DIR.'/Walkers/set_db_context.inc.php';
class DBBasicActions
{
var $is_exists = false;
/////////////////////////////////////////////////////////////////////////////

function DBBasicActions()
{
     $this-> table_name = '';
     $this-> set_modify_usual();
     $this-> create_objects();
     $this-> create_child_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> set_db(produce_db());
     $this-> WalkerSet = new WalkerSetDbContext();
     $this-> set_primary_key('id');
     $this-> with_auto_increment_primary();
}
/////////////////////////////////////////////////////////////////////////////

function create_child_objects()
{

}
///////////////////////////////////////////////////////////////////////////

function set_db($db)
{
     $this-> db = $db;
}
////////////////////////////////////////////////////////////////////////////

function set_id_value($id)
{
     $this-> set_primary_value($id);
}
////////////////////////////////////////////////////////////////////////////

function get_id_value()
{
     return $this-> Fields['id']-> get();
}
////////////////////////////////////////////////////////////////////////////

function set_primary_value($value)
{
     $this-> Fields[$this-> get_primary_key()]-> set($value);
}
///////////////////////////////////////////////////////////////////////////

function get_primary_value()
{
     return $this-> Fields[$this-> get_primary_key()]-> get();
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
/////////////////////////////////////////////////////////////////////////////

function set_fields(&$array)
{
     $this-> Fields = &$array;
     $this-> WalkerSet-> set_targets($this-> Fields);
}
////////////////////////////////////////////////////////////////////////////

function &get_fields()
{
     $result = &$this-> Fields;
     return $result;
}
////////////////////////////////////////////////////////////////////////////

function get_escaped($name)
{
     if (!empty($this-> Fields[$name]->value))
     {
          return $this-> Fields[$name]-> get_db_context();
     }
     return $this-> Fields[$name]->get_default_value();
     //return '';
}
/////////////////////////////////////////////////////////////////////////////

function get_data_keys()
{
     $result = array_keys($this-> Fields);
     if ($this-> is_auto_increment_primary())
     {
          $result = array_diff($result, array($this-> get_primary_key()));
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function set_primary_key($primary_key)
{
     $this-> primary_key = $primary_key;
}
///////////////////////////////////////////////////////////////////////////

function get_primary_key()
{
     return $this-> primary_key;
}
///////////////////////////////////////////////////////////////////////////

function get_field_where($field)
{
     return " WHERE `".$field."` = ".$this-> get_escaped($field);
}
///////////////////////////////////////////////////////////////////////////

function get_primary_where()
{
     return $this-> get_field_where($this-> get_primary_key());
}
///////////////////////////////////////////////////////////////////////////

function get_fields_list_where($fields_list)
{
     $result = $this-> get_field_where(reset($fields_list));
    $result .= " AND `".$fields_list[0]."` = ".$this-> get_escaped($fields_list[1]);
//     while ($field = next($fields_list))
//     {
//          $result .= " AND `".$field."` = ".$this-> get_escaped($field);
//     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_fields_for_empty()
{
     $result = array_keys($this-> Fields);
     return array_diff($result, array($this-> get_primary_key()));
}
///////////////////////////////////////////////////////////////////////////

function no_auto_increment_primary()
{
     $this-> auto_increment_primary = false;
}
///////////////////////////////////////////////////////////////////////////

function with_auto_increment_primary()
{
     $this-> auto_increment_primary = true;
}
///////////////////////////////////////////////////////////////////////////

function is_auto_increment_primary()
{
     return $this-> auto_increment_primary;
}
///////////////////////////////////////////////////////////////////////////

function set_modify_ignore()
{
     $this-> is_modify_ignore = true;
}
///////////////////////////////////////////////////////////////////////////

function set_modify_usual()
{
     $this-> is_modify_ignore = false;
}
///////////////////////////////////////////////////////////////////////////

function get_ignore_part()
{
     return !empty($this-> is_modify_ignore)?' IGNORE ':'';
}
///////////////////////////////////////////////////////////////////////////

function set_low_priority()
{
     $this-> is_low_priority = true;
}
///////////////////////////////////////////////////////////////////////////

function set_usual_priority()
{
     $this-> is_low_priority = false;
}
///////////////////////////////////////////////////////////////////////////

function get_priority_part()
{
     return !empty($this-> is_low_priority)?' LOW_PRIORITY ':'';
}
///////////////////////////////////////////////////////////////////////////

function get_insert_sql()
{
     $sql = "INSERT ".$this-> get_priority_part().$this-> get_ignore_part()."INTO `".$this-> get_table_name()."`
     (`".implode("`, `", $this-> get_data_keys())."`) VALUES (";
     foreach ($this-> get_data_keys() as $key)
     {
          $sql .= $this-> get_escaped($key).', ';
     }
     $sql = substr($sql, 0, -2).")";
     return $sql;
}
///////////////////////////////////////////////////////////////////////////

function insert()
{ 
     $this-> db-> exec_query($this-> get_insert_sql());

     if ($this-> is_auto_increment_primary())
     {
          $this-> set_primary_value($this-> db-> id_last);
     }
     $this-> is_exists = true;
}
///////////////////////////////////////////////////////////////////////////

function replace()
{ 
     $sql = "REPLACE  ".$this-> get_priority_part().$this-> get_ignore_part()."INTO `".$this-> get_table_name()."`
     (`".implode("`, `", $this-> get_data_keys())."`) VALUES (";
     foreach ($this-> get_data_keys() as $key)
     {
          $sql .= $this-> get_escaped($key).', ';
     }
     $sql = substr($sql, 0, -2).")";
     $this-> db-> exec_query($sql);
     if ($this-> is_auto_increment_primary())
     {
          $this-> set_primary_value($this-> db-> id_last);
     }
     $this-> is_exists = true;
}
/////////////////////////////////////////////////////////////////////////////

function get_update_start_template()
{
     return "UPDATE ".$this-> get_priority_part().$this-> get_ignore_part()."`".$this-> get_table_name()."` SET \n";
}
////////////////////////////////////////////////////////////////////////////

function is_updated()
{
     return $this-> db-> affected_rows;
}
///////////////////////////////////////////////////////////////////////////

function get_update_data_part()
{
     $result = $this-> get_update_start_template();
     foreach ($this-> get_data_keys() as $key)
     {
          $result .= "`$key` = ".$this-> get_escaped($key).",\n";
     }
     $result = substr($result, 0, -2);
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_update_fields_list($fields_list)
{
     $result = $this-> get_update_start_template();
     foreach ($fields_list as $key)
     {
          $result .= "`$key` = ".$this-> get_escaped($key).",\n";
     }
     $result = substr($result, 0, -2);
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function update()
{
     $sql = $this-> get_update_data_part().$this-> get_primary_where();
     $this-> db-> exec_query($sql);
}
/////////////////////////////////////////////////////////////////////////////

function update_by_fields_list($fields_list)
{
     $sql = $this-> get_update_data_part().$this-> get_fields_list_where($fields_list);
     $this-> db-> exec_query($sql);
}
/////////////////////////////////////////////////////////////////////////////

function update_only_fields_list($fields_list)
{
     $sql = $this-> get_update_fields_list($fields_list).$this-> get_primary_where();
     var_dump($sql);
     $this-> db-> exec_query($sql);
}
///////////////////////////////////////////////////////////////////////////

function empty_fields()
{
     foreach ($this-> get_fields_for_empty() as $key)
     {
          $this-> Fields[$key]-> make_empty();
     }
}
///////////////////////////////////////////////////////////////////////////

function set_fields_from_db($array)
{
     if (empty($array))
     {
          $this-> empty_fields();
          return;
     }

     $this-> WalkerSet-> set($array);
     $this-> WalkerSet-> walk();
     $this-> is_exists = true;
}
/////////////////////////////////////////////////////////////////////////////

function is_exists()
{
     return $this-> is_exists;
}
/////////////////////////////////////////////////////////////////////////////

function load_by_field($field)
{
     $this-> is_exists = false;
     $this-> db-> exec_query(
     "SELECT * FROM `".$this-> get_table_name()."`".$this-> get_field_where($field));
     $this-> set_fields_from_db($this-> db-> get_data());
}
///////////////////////////////////////////////////////////////////////////

function load_by_fields_list($fields_list)
{
     $this-> is_exists = false;
     $sql = 
     "SELECT * FROM `".$this-> get_table_name()."`".$this-> get_fields_list_where($fields_list);
     $this-> db-> exec_query($sql);
     $this-> set_fields_from_db($this-> db-> get_data());
}
///////////////////////////////////////////////////////////////////////////

function load_by_primary()
{
     if ($this-> Fields[$this-> get_primary_key()]-> is_empty())
     {
          $this-> is_exists = false;
          return;
     }
     $this-> load_by_field($this-> get_primary_key());
}
///////////////////////////////////////////////////////////////////////////

function load_by_id()
{
     $this-> load_by_primary();
}
/////////////////////////////////////////////////////////////////////////////

function delete_by_primary()
{
     $this-> delete_by_field($this-> get_primary_key());
}
///////////////////////////////////////////////////////////////////////////

function delete_by_id()
{
     $this-> delete_by_primary();
}
///////////////////////////////////////////////////////////////////////////

function delete_by_field($field)
{
     $this-> is_exists = false;
     $this-> db-> exec_query(
     "DELETE ".$this-> get_priority_part()." FROM `".$this-> get_table_name()."`".$this-> get_field_where($field));
}
///////////////////////////////////////////////////////////////////////////

function delete_by_fields_list($fields_list)
{
     $this-> is_exists = false;
     $this-> db-> exec_query(
     "DELETE ".$this-> get_priority_part()." FROM `".$this-> get_table_name()."`".$this-> get_fields_list_where($fields_list));
}
///////////////////////////////////////////////////////////////////////////

function close_connection()
{
     kill_db();
}
///////////////////////////////////////////////////////////////////////////

function restore_connection()
{
     $this-> set_db(produce_db());
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>