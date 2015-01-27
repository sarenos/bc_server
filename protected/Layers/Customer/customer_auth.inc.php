<?php
/***********************************************************
* Project  :
* Name     : MemberAuth
* Modified : $Id$
* Author   : forjest@gmail.com
************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/customer.inc.php';
require_once LAYERS_DIR.'/UserSession/auth.inc.php';

class CustomerAuth extends UserSessionAuth
{

function create_child_objects()
{
     $this-> set_info_key('customer');
}
////////////////////////////////////////////////////////////////////////////

function get_entity_instance()
{
     return new DCCustomer();
}
////////////////////////////////////////////////////////////////////////////
}//class ends here
?>
