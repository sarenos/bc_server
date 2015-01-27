<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : NavyPagesSelects
* Version  : 1.0
* Date     : 2007.07.26
* Modified : $Id: navy_pages_selects.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com, dizzy.mc@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/navy_pages.inc.php';

class NavyPagesSelects extends NavyPages
{
protected $per_page = 0;
/////////////////////////////////////////////////////////////////////////////

function get_first()
{
     if ($this-> has_links() && $this-> is_first_page())
     {
          return $this-> get_one_link(1);
     }
     return array();
}
///////////////////////////////////////////////////////////////////////////

function get_last()
{
     if ($this-> has_links() && $this-> is_last_page())
     {
          return $this-> get_one_link($this-> links_count);
     }
     return array();
}
///////////////////////////////////////////////////////////////////////////

function set_per_page($per_page)
{
	$this-> per_page = $per_page;
}
//////////////////////////////////////////////////////////////////////////

function get_one_link($num)
{
	$result = parent::get_one_link($num);
	$result['page_num'] = $num;
	$result['text'] = (($num-1)*$this-> per_page + 1).'-'.min(($num)*$this-> per_page, $this-> total);
	return $result;
}
///////////////////////////////////////////////////////////////////////////

function to_array()
{
     $result = parent::to_array();
	$result['first'] = $this-> get_first();
	$result['last']  = $this-> get_last();
	$result['url_format'] = $this-> url_format;
	return $result;
}
////////////////////////////////////////////////////////////////////////////
}//class ends here
?>