<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : PagedModel
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: paged_model.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/paged_wrapper.inc.php';

class PagedModel extends PagedWrapper
{
protected $per_page_options = array(10, 15, 25, 50, 100);
protected $need_redirect = false;

private $NonPagedSub = null;
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
     parent::__construct();
     $this-> setup_lister();
     $this-> setup_paging();
}
/////////////////////////////////////////////////////////////////////////////

function get_lister_instance()
{
     $result = null;
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function setup_lister()
{
     $this-> set_lister($this-> get_lister_instance());
}
/////////////////////////////////////////////////////////////////////////////

function escape_amps($url)
{
     return str_replace('&', '&amp;', $url);
}
///////////////////////////////////////////////////////////////////////////

function get_page_stripped_url()
{
     $result = trim(preg_replace("~[&\?]page=\d+~", '', $_SERVER['REQUEST_URI']), '&');
     if ($result !== "/")
     {
          $result = rtrim($result, '?');
     }
     if (FALSE == strpos($result, '?'))
     {
          $result .= '?';
     }
     else
     {
          $result .= '&';
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_stripped_parts_list($list)
{
     $result = $this-> get_page_stripped_url();
     foreach($list as $part)
     {
          $result = preg_replace(array('~'.preg_quote(urlencode($part)).'=[^&]*&?~', '~'.preg_quote($part).'=[^&]*&?~'), '', $result);
     }
     return $this-> escape_amps($result);
}
///////////////////////////////////////////////////////////////////////////

function get_stripped_part($part)
{
     return $this-> get_stripped_parts_list(array($part));
}
///////////////////////////////////////////////////////////////////////////

function get_default_url_format()
{
     $result = $this-> get_page_stripped_url().'page=%d';
     $result = str_replace('&', '&amp;', $result);
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function default_paging_setup()
{
     $this-> set_per_page($this-> get_per_page());
     $this-> set_url_format($this-> get_default_url_format());
     $this-> set_page_num(@$_GET['page']);
}
///////////////////////////////////////////////////////////////////////////

function setup_paging()
{
     $this-> default_paging_setup();
}
/////////////////////////////////////////////////////////////////////////////

function get_list()
{
     return $this-> Lister-> get_list();
}
/////////////////////////////////////////////////////////////////////////////

function get_per_page()
{
     $result = (int)@$_GET['per_page'];
     if (!empty($result))
     {
          if (!in_array($result, $this-> per_page_options))
          {
               $result = PER_PAGE_DEFAULT;
          }
          setcookie('client_per_page', $result, strtotime('+10 year'));
          return $result;
     }
     if (!empty($_COOKIE['client_per_page']))
     {
          return $_COOKIE['client_per_page'];
     }
     return PER_PAGE_DEFAULT;
}
///////////////////////////////////////////////////////////////////////////

function get_per_page_options()
{
     $result = array();
     foreach ($this-> per_page_options as $option)
     {
          $result[$option] = array('per_page'=> $option, 'is_current'=> false);
     }
     $result[$this-> get_per_page()]['is_current'] = true;
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_per_page_url_format()
{
     return $this-> get_stripped_part('per_page').'per_page=<per_page>';
}
///////////////////////////////////////////////////////////////////////////

function get_per_page_data()
{
     return array(
      'options'=> $this-> get_per_page_options(),
      'url_format'=> $this-> get_per_page_url_format(),
      'per_page'=> $this-> get_per_page(),
      'min_per_page' => min($this-> per_page_options),
     );
}
///////////////////////////////////////////////////////////////////////////

function get_sort_data()
{
     return $this-> Lister-> get_sort_context();
}
///////////////////////////////////////////////////////////////////////////

function get_headers_list()
{
     $result        = array();
     $Sortable      = $this-> Lister-> get_sortable_fields();
     $SortContext   = $this-> Lister-> get_sort_context();

     foreach ($this-> get_header_captions() as $key => $caption)
     {
          $row = array(
             'caption'=> $caption,
             'is_sortable'=> isset($Sortable[$key]),
             'is_current'=> $SortContext['by'] == $key,
             'is_desc'=> $SortContext['is_desc'],
          );
          $row['order'] = !$row['is_current']?$SortContext['order']:$SortContext['anti-order'];
          $result[$key] = $row;
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>