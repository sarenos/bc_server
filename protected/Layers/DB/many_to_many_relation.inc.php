<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : ManyToManyRelation
* Version  : 1.0
* Date     : 2007.05.25
* Modified : $Id: many_to_many_relation.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class ManyToManyRelation
{
var $related_ids = array();
/////////////////////////////////////////////////////////////////////////////

function ManyToManyRelation($table_name = 'prg', $main_field_name = 'id_m', $related_field_name = 'id_rel')
{
     $this-> create_objects();
     $this-> set_attrs($table_name, $main_field_name, $related_field_name);
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

function create_objects()
{
     $this-> db = produce_db();
}
///////////////////////////////////////////////////////////////////////////

function set_main_ids($ids)
{
     $this-> ids = array_unique($ids);
}
///////////////////////////////////////////////////////////////////////////

function get_related_ids()
{
     return $this-> related_ids;
}
//////////////////////////////////////////////////////////////////////////

function set_related_ids($related_ids)
{
     $this-> related_ids = array_filter($related_ids);
}
//////////////////////////////////////////////////////////////////////////

function get_ids_list()
{
     return implode(', ', $this-> ids);
}
///////////////////////////////////////////////////////////////////////////

function load()
{
     $this-> related_ids = array();
     $this-> db-> exec_query(
     "SELECT `".$this-> related_field_name."`, `".$this-> main_field_name."` FROM `".$this-> table_name."` WHERE `".$this-> main_field_name."` IN (".$this-> get_ids_list().")");
     while ($row = $this-> db-> get_data())
     {
          $this-> related_ids[$row[$this-> main_field_name]][] = $row[$this-> related_field_name];
     }
}
///////////////////////////////////////////////////////////////////////////

function delete()
{
     $this-> db-> exec_query(
     "DELETE FROM `".$this-> table_name."` WHERE `".$this-> main_field_name."` IN (".$this-> get_ids_list().')');
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>