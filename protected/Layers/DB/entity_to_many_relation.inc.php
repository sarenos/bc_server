<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : EntityToManyRelation
* Version  : 1.0
* Date     : 2007.05.25
* Modified : $Id: entity_to_many_relation.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class EntityToManyRelation
{
var $related_ids = array();
/////////////////////////////////////////////////////////////////////////////

function EntityToManyRelation($table_name = 'prg', $main_field_name = 'id_m', $related_field_name = 'id_rel')
{
     $this-> create_objects();
     $this-> set_attrs($table_name, $main_field_name, $related_field_name);
     $this-> set_default_on_empty(array());
}
/////////////////////////////////////////////////////////////////////////////

function set_table_name($table_name)
{
     $this-> table_name = $table_name;
}
//////////////////////////////////////////////////////////////////////////

function set_main_field_name($main_field_name)
{
     $this-> main_field_name = $main_field_name;
}
//////////////////////////////////////////////////////////////////////////

function set_related_field_name($related_field_name)
{
     $this-> related_field_name = $related_field_name;
}
//////////////////////////////////////////////////////////////////////////

function set_attrs($table_name, $main_field_name, $related_field_name)
{
     $this-> set_table_name($table_name);
     $this-> set_main_field_name($main_field_name);
     $this-> set_related_field_name($related_field_name);
}
//////////////////////////////////////////////////////////////////////////

function set_default_on_empty($default_on_empty)
{
     $this-> default_on_empty = $default_on_empty;
}
//////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> db = produce_db();
}
///////////////////////////////////////////////////////////////////////////

function set_entity($Entity)
{
     $this-> Entity = $Entity;
}
///////////////////////////////////////////////////////////////////////////

function set_id($Id)
{
     $this-> entity_id = $Id;
}
///////////////////////////////////////////////////////////////////////////

function set_id_value($id)
{
     $this-> id = $id;
}
///////////////////////////////////////////////////////////////////////////

function get_related_ids()
{
     if (!empty($this-> related_ids))
     {
          return $this-> related_ids;
     }
     return $this-> default_on_empty;
}
//////////////////////////////////////////////////////////////////////////

function set_related_ids($related_ids)
{
     $this-> related_ids = array_filter($related_ids);
}
//////////////////////////////////////////////////////////////////////////

function update_id()
{
     if (!empty($this-> Entity))
     {
          $this-> set_id_value($this-> Entity-> get_id_value());
          return;
     }
     if (!empty($this-> entity_id))
     {
          $this-> set_id_value($this-> entity_id-> get());
          return;
     }
}
///////////////////////////////////////////////////////////////////////////

function load()
{
     $this-> update_id();
     $this-> related_ids = array();
     if (empty($this-> id))
     {
          return;
     }
     $this-> db-> exec_query(
     "SELECT `".$this-> related_field_name."` FROM `".$this-> table_name."` WHERE `".$this-> main_field_name."`= ".$this-> id);
     while ($row = $this-> db-> get_data())
     {
          $this-> related_ids[] = reset($row);
     }
}
///////////////////////////////////////////////////////////////////////////

function delete()
{
     $this-> update_id();
     $this-> db-> exec_query(
     "DELETE FROM `".$this-> table_name."` WHERE `".$this-> main_field_name."`= ".$this-> id);
}
///////////////////////////////////////////////////////////////////////////

function add()
{
     $this-> update_id(); 
     if (empty($this-> related_ids))
     {
          return;
     }
     $sql = "INSERT INTO `".$this-> table_name."` (`".$this-> main_field_name."`, `".$this-> related_field_name."`)
     VALUES ";
     foreach ($this-> related_ids as $id_related)
     {
          $sql .= "(".$this-> id.", ".$id_related."), ";
     }
     $sql = trim($sql, ' ,');
     $this-> db-> exec_query($sql);
}
///////////////////////////////////////////////////////////////////////////

function update()
{
     $this-> update_id();
     $this-> delete();
     $this-> add();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>