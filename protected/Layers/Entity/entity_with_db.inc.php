<?php
/**************************************************************
* Project  : 
* Name     : EntityWithDB
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: entity_with_db.inc.php,v adcd9368ea2f 2012/01/31 00:33:46 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/entity.inc.php';
require_once LAYERS_DIR.'/Walkers/set_db_context.inc.php';
require_once LAYERS_DIR.'/DB/basic_actions.inc.php';
require_once LAYERS_DIR.'/DB/locker.inc.php';

class EntityWithDB extends Entity
{
protected $Locker = null;
////////////////////////////////////////////////////////////////////////////

function &get_all_fields_instances()
{
     $result = array();
     $result['id'] = new FieldId();
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> Locker = new DBLocker();
     parent::create_objects();
}
///////////////////////////////////////////////////////////////////////////

function create_child_objects()
{
     $this-> create_standart_db_handler('no_table');
     $this-> create_tuple();
}
///////////////////////////////////////////////////////////////////////////

function create_standart_db_handler($table_name)
{
     $this-> DBHandler = new DBBasicActions();
     $this-> DBHandler-> set_table_name($table_name);
}
///////////////////////////////////////////////////////////////////////////

function create_db_fields()
{
     $this-> DBHandler-> set_fields($this-> Tuple-> get_db_fields());
}
///////////////////////////////////////////////////////////////////////////

function on_create_fields()
{
     $this-> create_db_fields();
}
////////////////////////////////////////////////////////////////////////////

function get_table_name()
{
     return $this-> DBHandler-> get_table_name();
}
///////////////////////////////////////////////////////////////////////////

function set_id($Id)
{
     $this-> Fields['id']-> copy($Id);
}
///////////////////////////////////////////////////////////////////////////

function set_id_value($id)
{
     $this-> Fields['id']-> set($id);
}
///////////////////////////////////////////////////////////////////////////

function get()
{
     return $this-> get_id()-> get();
}
///////////////////////////////////////////////////////////////////////////

function &get_id()
{
     return $this-> Fields['id'];
}
///////////////////////////////////////////////////////////////////////////

function get_id_value()
{
     return $this-> r_id;
}
///////////////////////////////////////////////////////////////////////////

function set_db_array($array)
{
     $this-> DBHandler-> is_exists = false;
     $this-> DBHandler-> set_fields_from_db($array);
     $this-> after_load();
}
///////////////////////////////////////////////////////////////////////////

function is_exists()
{
     return $this-> DBHandler-> is_exists();
}
/////////////////////////////////////////////////////////////////////////////

function copy($Entity)
{
     $this-> set_array($Entity-> get_array());
     $this-> DBHandler-> is_exists = $Entity-> DBHandler-> is_exists;
}
///////////////////////////////////////////////////////////////////////////

function after_load()
{
}
///////////////////////////////////////////////////////////////////////////

function load()
{
     $this-> DBHandler-> load_by_primary();
     $this-> after_load();
}
///////////////////////////////////////////////////////////////////////////

function load_by_field($Field)
{
     $this-> DBHandler-> load_by_field($Field);
     $this-> after_load();
}
///////////////////////////////////////////////////////////////////////////

function load_by_fields_list($list)
{
     $this-> DBHandler-> load_by_fields_list($list);
}
////////////////////////////////////////////////////////////////////////////

function update()
{
     $this-> DBHandler-> update();
}
///////////////////////////////////////////////////////////////////////////

function delete()
{
     $this-> DBHandler-> delete_by_primary();
}
///////////////////////////////////////////////////////////////////////////

function token_tuning()
{
     $this-> Locker-> set_token(time().rand());
}
///////////////////////////////////////////////////////////////////////////

function lock()
{
     $this-> token_tuning();
     $this-> Locker-> lock();
}
///////////////////////////////////////////////////////////////////////////

function unlock()
{
     $this-> token_tuning();
     $this-> Locker-> unlock();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>