<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : Tuple
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: tuple.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
class Tuple
{
var $AllFields = array();
/////////////////////////////////////////////////////////////////////////////

function Tuple($FieldsProvider = null)
{
     $this-> FieldsProvider = $FieldsProvider;
     $this-> create_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> create_child_objects();
     $this-> AllFields = &$this-> get_all_fields_instances();
}
///////////////////////////////////////////////////////////////////////////

function create_child_objects()
{
     
}
///////////////////////////////////////////////////////////////////////////

function &get_all_fields_instances()
{
     $result = array();
     if (!empty($this-> FieldsProvider))
     {
          $result = &$this-> FieldsProvider-> get_all_fields_instances();
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function set_all_fields(&$AllFields)
{
     $this-> AllFields = &$AllFields;
}
//////////////////////////////////////////////////////////////////////////

function &get_all_fields()
{
     return $this-> AllFields;
}
/////////////////////////////////////////////////////////////////////////////

function register($key, &$Field)
{
     $this-> AllFields[$key] = &$Field;
}
/////////////////////////////////////////////////////////////////////////////

function &get_fields_by_keys($keys)
{
     $result = array();
     foreach ($keys as $key)
     {
          if (!empty($this-> AllFields[$key]))
          {
               $result[$key] = &$this-> AllFields[$key];
          }
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function get_all_keys()
{
     return array_keys($this-> AllFields);
}
///////////////////////////////////////////////////////////////////////////

function &get($key)
{
     return $this-> AllFields[$key];
}
/////////////////////////////////////////////////////////////////////////////

function set_value($key, $value)
{
     if (isset($this-> AllFields[$key]))
     {
          $this-> AllFields[$key]-> set($value);
     }
}
/////////////////////////////////////////////////////////////////////////////

function get_value($key)
{
     if (isset($this-> AllFields[$key]))
     {
          return $this-> AllFields[$key]-> get();
     }
     return null;
}
/////////////////////////////////////////////////////////////////////////////

function &get_db_fields()
{
     $result = &$this-> get_all_fields();
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function &get_entity_fields()
{
     $result = &$this-> get_all_fields();
     return $result;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>