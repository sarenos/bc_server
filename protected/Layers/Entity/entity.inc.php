<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : Entity
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: entity.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/Walkers/get_array.inc.php';
require_once LAYERS_DIR.'/Walkers/set_array.inc.php';
require_once LAYERS_DIR.'/Walkers/make_empty.inc.php';
require_once LAYERS_DIR.'/Tuples/tuple.inc.php';

require_once LAYERS_DIR.'/Fields/string.inc.php';
require_once LAYERS_DIR.'/Fields/enum.inc.php';
require_once LAYERS_DIR.'/Fields/serialized.inc.php';
require_once LAYERS_DIR.'/Fields/datetime.inc.php';
require_once LAYERS_DIR.'/Fields/date.inc.php';
require_once LAYERS_DIR.'/Fields/id.inc.php';
require_once LAYERS_DIR.'/Fields/float.inc.php';
require_once LAYERS_DIR.'/Fields/yn_bool.inc.php';
require_once LAYERS_DIR.'/Fields/remote_addr.inc.php';
require_once LAYERS_DIR.'/Fields/unique_hash.inc.php';
require_once LAYERS_DIR.'/Fields/unique_password.inc.php';
require_once LAYERS_DIR.'/Fields/email.inc.php';
require_once LAYERS_DIR.'/Fields/phone.inc.php';
require_once LAYERS_DIR.'/Fields/amount.inc.php';
require_once LAYERS_DIR.'/Fields/ip.inc.php';
require_once LAYERS_DIR.'/Fields/ip_int.inc.php';
require_once LAYERS_DIR.'/Fields/currency.inc.php';

require_once LAYERS_DIR.'/Paging/paged_lister.inc.php';

class Entity extends PagedLister
{
var $Fields = array();
var $Keys   = array();
var $rKeys   = array();
/////////////////////////////////////////////////////////////////////////////

function Entity()
{
     $this-> create_objects();
     $this-> create_child_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     parent::__construct();
     $this-> Setter  = new WalkerSetArray();
     $this-> Emptier = new WalkerMakeEmpty();
}
///////////////////////////////////////////////////////////////////////////

function &get_all_fields_instances()
{
     $result = array();
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_tuple_instance()
{
     $result = new Tuple($this);
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function create_tuple()
{
     $this-> set_tuple($this-> get_tuple_instance());
}
///////////////////////////////////////////////////////////////////////////

function set_tuple($Tuple)
{
     $this-> Tuple = $Tuple;
     $this-> create_fields();
}
/////////////////////////////////////////////////////////////////////////////

function &get_tuple()
{
     return $this-> Tuple;
}
/////////////////////////////////////////////////////////////////////////////

function &get_field($name)
{
     return $this-> Tuple-> get($name);
}
///////////////////////////////////////////////////////////////////////////

function set_field_value($name, $value)
{
     return $this-> Tuple-> set_value($name, $value);
}
///////////////////////////////////////////////////////////////////////////

function get_field_value($name)
{
     return $this-> Tuple-> get_value($name);
}
///////////////////////////////////////////////////////////////////////////

function on_create_fields()
{
     
}
///////////////////////////////////////////////////////////////////////////

function is_exists()
{
     
}
/////////////////////////////////////////////////////////////////////////////

function create_fields()
{
     $this-> Fields = &$this-> Tuple-> get_entity_fields();
     $this-> Keys = array_keys($this-> Fields);
     $this-> rKeys = array();
     foreach ($this-> Keys as $key)
     {
          $field_name = 'r_'.$key;
          $this-> $field_name = &$this-> Fields[$key]-> value;
          $this-> rKeys[$key] = $field_name;
     }
     $this-> on_create_fields();
     $this-> Setter->  set_targets($this-> Fields);
     $this-> Emptier-> set_targets($this-> Fields);
}
////////////////////////////////////////////////////////////////////////////

function &get_fields()
{
     return $this-> Fields;
}
/////////////////////////////////////////////////////////////////////////////

function get_array($prefix = '')
{
     $result = array();
     foreach ($this-> rKeys as $key=>$rkey)
     {
          $result[$prefix.$key] = $this-> $rkey;
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function get_values_for($name)
{
     return $this-> Fields[$name]-> get_possible_values();
}
///////////////////////////////////////////////////////////////////////////

function after_set_array()
{
     
}
///////////////////////////////////////////////////////////////////////////

function set_array($array)
{
     $this-> Setter-> set($array);
     $this-> Setter-> walk(); 
     $this-> after_set_array();
}
////////////////////////////////////////////////////////////////////////////

function copy($Entity)
{
     $this-> set_array($Entity-> get_array());
}
///////////////////////////////////////////////////////////////////////////

function make_empty()
{
     $this-> Emptier-> walk();
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>