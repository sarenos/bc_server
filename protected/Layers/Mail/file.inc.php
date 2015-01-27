<?php 
/************************************************************** 
* Project  :  
* Name     : EmailFile 
* Version  : 1.0 
* Date     : 2011.08.24 
* Modified : $Id$ 
* Author   : forjest@gmail.com 
*************************************************************** 
* 
* 
* 
*/ 
require_once LAYERS_DIR.'/Entity/entity_with_db.inc.php'; 
class EmailFile extends EntityWithDB 
{ 
///////////////////////////////////////////////////////////////////////////// 

function &get_all_fields_instances() 
{ 
     $result['filename'] = new FieldString(); 
     $result['filename']-> set_max_length(50); 
     $result['dt_last_modified'] = new FieldDateTime(); 
     $result['title'] = new FieldString(); 
     $result['title']-> set_max_length(255); 
     $result['condition'] = new FieldString(); 
     $result['condition']-> set_max_length(50); 
     return $result; 
} 
///////////////////////////////////////////////////////////////////////////// 

function get_condition() 
{ 
     return $this-> get_field('condition'); 
} 
function set_condition($Condition) 
{ 
     $this-> Fields['condition']-> copy($Condition); 
} 
///////////////////////////////////////////////////////////////////////////// 

function get_condition_value() 
{ 
     return $this-> r_condition; 
} 
function set_condition_value($condition) 
{ 
     $this-> Fields['condition']-> set($condition); 
} 
//////////////////////////////////////////////////////////////////////////// 

function create_child_objects() 
{ 
     $this-> create_standart_db_handler('crm_email_file'); 
     $this-> create_tuple(); 
     $this-> DBHandler-> set_primary_key('condition'); 
     $this-> DBHandler-> no_auto_increment_primary(); 
} 
///////////////////////////////////////////////////////////////////////////// 

function makedefault_if_title_empty()
{
     if (!$this-> Fields['title']-> is_empty())
     {
          return;
     }
     $this-> Fields['title']-> set($this-> r_condition.sprintf(' (%dKb)', round(filesize(ABS_PATH.'/../static/files/'.$this-> r_filename)/1024)));
}
////////////////////////////////////////////////////////////////////////////

function add() 
{ 
     $this-> Fields['dt_last_modified']-> now();
     $this-> Fields['title']-> set('');
     $this-> makedefault_if_title_empty();
     $this-> DBHandler-> insert(); 
} 
//////////////////////////////////////////////////////////////////////////// 

function update()
{
     $this-> Fields['dt_last_modified']-> now();
     parent::update();
}
////////////////////////////////////////////////////////////////////////////

}//class ends here 
?>