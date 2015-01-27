<?php 
/************************************************************** 
* Project  :  
* Name     : EmailTemplate 
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
class EmailTemplate extends EntityWithDB 
{ 
///////////////////////////////////////////////////////////////////////////// 

function &get_all_fields_instances() 
{ 
     $result['id'] = new FieldString(); 
     $result['id']-> set_max_length(25); 
     $result['email_template'] = new FieldString(); 
     $result['email_template']-> set_max_length(255); 
     $result['purpose'] = new FieldString(); 
     $result['purpose']-> set_max_length(255); 
     $result['subject'] = new FieldString(); 
     $result['subject']-> set_max_length(255); 
     $result['body_template'] = new FieldString(); 
     $result['body_template']-> set_max_length(65535); 

     $result['dt_last_modified'] = new FieldDateTime();
     return $result; 
} 
///////////////////////////////////////////////////////////////////////////// 

function create_child_objects() 
{ 
     $this-> create_standart_db_handler('crm_email_template'); 
     $this-> create_tuple(); 
     $this-> DBHandler-> no_auto_increment_primary();
} 
///////////////////////////////////////////////////////////////////////////// 


function update()
{
     $this-> Fields['dt_last_modified']-> now();
     parent::update();

}
////////////////////////////////////////////////////////////////////////////

}//class ends here 
?>