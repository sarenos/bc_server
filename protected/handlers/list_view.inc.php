<?php
/**************************************************************
* Project  :
* Name     : ListView
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once HANDLERS_DIR.'/view_templated.inc.php';
class ListView extends ViewTemplated
{
////////////////////////////////////////////////////////////////////////////

function fill_list_variables()
{
     $this-> assign('List', $this-> Model-> get_list()); 
     $this-> assign('NavyPages', $this-> Model-> get_navy_pages());
     $this-> assign('PerPageData', $this-> Model-> get_per_page_data());
}
///////////////////////////////////////////////////////////////////////////

function fill()
{
     parent::fill();
     $this-> fill_list_variables();
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>