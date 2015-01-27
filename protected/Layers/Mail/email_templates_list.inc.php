<?php
/***********************************************************
* Project  :
* Name     : EmailTemplatesList
* Modified : $Id$
* Author   : forjest@gmail.com
************************************************************
*
*
*
*/
class EmailTemplatesList 
{

function __construct()
{
     $this-> db = produce_db();
}
///////////////////////////////////////////////////////////////////////////////

function get_list()
{
     $this-> db-> exec_query("SELECT * FROM crm_email_template");
     return $this-> db-> get_all_data_indexed('id');
}
////////////////////////////////////////////////////////////////////////////

}//class ends here
?>
