<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : PagedLister
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: paged_lister.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/sql_pager.inc.php';
require_once LAYERS_DIR.'/DB/mysql.inc.php';
class PagedLister
{
protected $Critery = array();
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
     $this-> create_db();
     $this-> set_sql_pager(new SQLPager());
}
///////////////////////////////////////////////////////////////////////////

function create_db()
{
     $this-> db = produce_db();
}
/////////////////////////////////////////////////////////////////////////////

function set_sql_pager(&$SQLPager)
{
     $this-> SQLPager = &$SQLPager;
}
////////////////////////////////////////////////////////////////////////////

function set_per_page($per_page)
{
     //for testing purposes
     $this-> SQLPager-> set_per_page($per_page);
}
////////////////////////////////////////////////////////////////////////////

function set_page_num($page_num)
{
     //for testing purposes
     $this-> SQLPager-> set_page_num($page_num);
}
////////////////////////////////////////////////////////////////////////////

function get_limit_part()
{
     return $this-> SQLPager-> get_limit_part();
}
////////////////////////////////////////////////////////////////////////////

function get_results_count()
{
     //implementation
}
/////////////////////////////////////////////////////////////////////////////

function reset_critery()
{
     $this-> set_critery(array());
}
///////////////////////////////////////////////////////////////////////////

function set_critery($Critery)
{
     $this-> Critery = &$Critery;
     $this-> adjust_critery();
}
///////////////////////////////////////////////////////////////////////////

function adjust_critery()
{
     
}
///////////////////////////////////////////////////////////////////////////

function get_critery()
{
     return $this-> Critery;
}
///////////////////////////////////////////////////////////////////////////

function get_conditions()
{
     $result = array();
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_conditions_list()
{
     return implode (' AND ', $this-> get_conditions());
}
///////////////////////////////////////////////////////////////////////////

function get_where_part()
{
     $result = $this-> get_conditions_list();
     if (!empty($result))
     {
          $result = ' WHERE '.$result.' ';
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function sort_fill_default()
{
     
}
///////////////////////////////////////////////////////////////////////////

function ajust_sort_context()
{
     $Fields = ($this-> get_sortable_fields());
     if (!isset($Fields[$this-> SortContext['by']]))
     {
          $this-> SortContext['by'] = reset($Fields);
          $this-> SortContext['order'] = 'asc';
          $this-> sort_fill_default();
          return;
     }
     if (!in_array(strtolower($this-> SortContext['order']), array('asc', 'desc')))
     {
          $this-> SortContext['order'] = 'asc';
     }
     $this-> SortContext['is_desc'] = $this-> SortContext['order'] == 'desc';
     $this-> SortContext['anti-order'] = $this-> SortContext['is_desc']?'asc':'desc';
}
///////////////////////////////////////////////////////////////////////////

function set_sort_context($SortContext)
{
     $this-> SortContext = (array)@$SortContext;
     $this-> SortContext['by'] = (string)@$this-> SortContext['by'];
     $this-> SortContext['order'] = (string)@$this-> SortContext['order'];
     $this-> ajust_sort_context();
}
///////////////////////////////////////////////////////////////////////////

function get_sort_context()
{
     return $this-> SortContext;
}
///////////////////////////////////////////////////////////////////////////

function get_order_by_part()
{
     if (empty($this-> SortContext) || empty($this-> SortContext['by']))
     {
          return '';
     }
     $Fields = $this-> get_sortable_fields();
     return ' ORDER BY '.$Fields[$this-> SortContext['by']].' '.$this-> SortContext['order'].' ';
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>