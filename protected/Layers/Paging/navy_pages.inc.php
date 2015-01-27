<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : NavyPages
* Version  : 1.0
* Date     : 2005.05.07
* Modified : $Id: navy_pages.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
class NavyPages
{

var $links_count;
var $text_format;
var $url_format;
var $current;
/////////////////////////////////////////////////////////////////////////////

function NavyPages()
{
     $this-> set_text_format('%d');
     $this-> set_url_format('?url=%d');
     $this-> set_current(1);
     $this-> set_total(0);
}
/////////////////////////////////////////////////////////////////////////////

function set_per_page($per_page)
{
     $this-> per_page = $per_page;
}
//////////////////////////////////////////////////////////////////////////

function set_links_count($links_count)
{
     $this-> links_count = $links_count;
}
////////////////////////////////////////////////////////////////////////////

function set_text_format($text_format)
{
     $this-> text_format = $text_format;
}
////////////////////////////////////////////////////////////////////////////

function set_url_format($url_format)
{
     $this-> url_format = $url_format;
}
function get_url_format()
{
     //for testing purposes
     return $this-> url_format;
}
////////////////////////////////////////////////////////////////////////////

function set_current($current)
{
     $this-> current = $current;
}
////////////////////////////////////////////////////////////////////////////

function set_total($total)
{
     $this-> total = $total;
}
function get_total()
{
     return $this-> total;
}
//////////////////////////////////////////////////////////////////////////

function get_one_link($num)
{
     return array(
          'text' => preg_replace("~%d~", $num, $this-> text_format),
          'url'  => preg_replace("~%d~", $num, $this-> url_format),
          'is_current'=> $num == $this-> current
     );
}
////////////////////////////////////////////////////////////////////////////

function has_links()
{
     return $this-> links_count > 0;
}
///////////////////////////////////////////////////////////////////////////

function is_first_page()
{
     return $this-> current > 1;
}
///////////////////////////////////////////////////////////////////////////

function is_last_page()
{
     return $this-> current < $this-> links_count;
}
///////////////////////////////////////////////////////////////////////////

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

function get_links()
{
     $result = array();
     if (!$this-> has_links())
     {
          return array();
     }
     for ($i=0; $i< $this-> links_count; $i++)
     {
          $result[] = $this-> get_one_link($i+1);
     }
     return $result;
}
////////////////////////////////////////////////////////////////////////////

function get_prev()
{
     if ($this-> has_links() && $this-> is_first_page() )
     {
          if ($this-> current >= $this-> links_count)
          {
               return $this-> get_one_link($this-> links_count - 1);
          }
          else
          {
               return $this-> get_one_link($this-> current - 1);
          }
     }
     return array();
}
////////////////////////////////////////////////////////////////////////////

function get_next()
{
     if ($this-> has_links() && $this-> is_last_page())
     {
          return $this-> get_one_link($this-> current + 1);
     }
     return array();
}
////////////////////////////////////////////////////////////////////////////

function to_array()
{
     return array(
          'links'=> $this-> get_links(),
          'prev' => $this-> get_prev(),
          'next' => $this-> get_next(),
          'first'=> $this-> get_first(),
          'last' => $this-> get_last(),
          'total'=> $this-> get_total(),
          'links_count'=> $this-> links_count,
          'page_num'=> $this-> current,
          'from_item'=> ($this-> current - 1) * $this-> per_page +1,
     );
}
////////////////////////////////////////////////////////////////////////////
}//class ends her&$dbe
?>