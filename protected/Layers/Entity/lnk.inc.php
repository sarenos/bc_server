<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : EntityLnk
* Version  : 1.0
* Date     : 2010.01.10
* Modified : $Id: lnk.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/entity_with_db.inc.php';

class EntityLnk extends EntityWithDB
{
/////////////////////////////////////////////////////////////////////////////

function create_standart_db_handler($table_name)
{
     parent::create_standart_db_handler($table_name);
     $this-> DBHandler-> no_auto_increment_primary();
}
///////////////////////////////////////////////////////////////////////////

function fill_from_obj()
{
}
///////////////////////////////////////////////////////////////////////////

function load()
{
     $this-> fill_from_obj();
     $this-> DBHandler-> load_by_fields_list($this-> Tuple-> get_all_keys());
}
///////////////////////////////////////////////////////////////////////////

function add()
{
     $this-> fill_from_obj();
     $this-> DBHandler-> insert();
}
///////////////////////////////////////////////////////////////////////////

function delete()
{
     $this-> fill_from_obj();
     $this-> DBHandler-> delete_by_fields_list($this-> Tuple-> get_all_keys());
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>