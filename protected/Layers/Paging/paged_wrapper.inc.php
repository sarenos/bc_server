<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : PagedWrapper
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: paged_wrapper.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

require_once dirname(__FILE__).'/navy_pages.inc.php';
require_once dirname(__FILE__).'/navy_pages_selects.inc.php';
require_once dirname(__FILE__).'/sql_pager.inc.php';

class PagedWrapper
{
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
     $this-> set_navy_pages(new NavyPagesSelects());
     $this-> set_sql_pager(new SQLPager());
     //$this-> set_slice_size(DEFAULT_PAGING_SLICE);
}
/////////////////////////////////////////////////////////////////////////////

function set_navy_pages($NavyPages)
{
     $this-> NavyPages = $NavyPages;
}
function set_url_format($url_format)
{
     $this-> NavyPages-> set_url_format($url_format);
}
function get_url_format()
{
     //for testing purposes
     return $this-> NavyPages-> get_url_format();
}
function set_text_format($text_format)
{
     $this-> NavyPages-> set_text_format($text_format);
}
/*function set_slice_size($size)
{
     $this-> NavyPages-> set_slice_size($size);
}*/
/////////////////////////////////////////////////////////////////////////////

function set_sql_pager($SQLPager)
{
     $this-> SQLPager = $SQLPager;
}
function set_page_num($page_num)
{
     $this-> SQLPager-> set_page_num($page_num);
}
function get_page_num()
{
     return $this-> SQLPager-> get_page_num();
}
function set_per_page($per_page)
{
     $this-> SQLPager-> set_per_page($per_page);
}
function get_per_page()
{
     //for testing purposes
     return $this-> SQLPager-> get_per_page();
}
////////////////////////////////////////////////////////////////////////////

function set_lister($Lister)
{
     if (empty($Lister))
     {
          return;
     }
     $this-> Lister = $Lister;
     $this-> Lister-> set_sql_pager($this-> SQLPager);
}
/////////////////////////////////////////////////////////////////////////////

function get_results_count()
{
     if (!isset($this-> results_count))
     {
          $this-> results_count = $this-> Lister-> get_results_count();
     }
     return $this-> results_count;
}
///////////////////////////////////////////////////////////////////////////

function get_pages_count()
{
     return ceil($this-> get_results_count()*1.0/$this-> SQLPager-> get_per_page());
}
/////////////////////////////////////////////////////////////////////////////

function get_navy_pages()
{
     $this-> NavyPages-> set_links_count($this-> get_pages_count());
     $this-> NavyPages-> set_current($this-> get_page_num());
     $this-> NavyPages-> set_total($this-> get_results_count());
     $this-> NavyPages-> set_per_page($this-> get_per_page());
     $result = $this-> NavyPages-> to_array();
     $result['per_page'] = $this-> get_per_page();
     return $result;
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>