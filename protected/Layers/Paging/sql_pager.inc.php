<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : SQLPager
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: sql_pager.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
class SQLPager
{
var $per_page;
var $page_num;
var $correction_from;
var $correction_count;
/////////////////////////////////////////////////////////////////////////////

function SQLPager()
{
     $this-> set_page_num(1);
     $this-> set_per_page(10000);
     $this-> set_corrections(0,0);
}
/////////////////////////////////////////////////////////////////////////////

function set_per_page($per_page)
{
     $this-> per_page = $per_page;
}
////////////////////////////////////////////////////////////////////////////

function get_per_page()
{
     return $this-> per_page;
}
////////////////////////////////////////////////////////////////////////////

function set_page_num($page_num)
{
     $this-> page_num = (int)$page_num;
     if ($this-> page_num <= 0)
     {
          $this-> page_num = 1;
     }
}
////////////////////////////////////////////////////////////////////////////

function get_page_num()
{
     return $this-> page_num;
}
////////////////////////////////////////////////////////////////////////////

function get_from()
{
     $result = ($this-> page_num - 1)*$this-> per_page + $this-> correction_from;
     if ($result < 0)
     {
          return 0;
     }
     return $result;
}
////////////////////////////////////////////////////////////////////////////

function set_correction_from($correction_from)
{
     $this-> correction_from = $correction_from;
}
////////////////////////////////////////////////////////////////////////////

function set_correction_count($correction_count)
{
     $this-> correction_count = $correction_count;
}
////////////////////////////////////////////////////////////////////////////

function set_corrections($from, $count)
{
     $this-> set_correction_from($from);
     $this-> set_correction_count($count);
}
/////////////////////////////////////////////////////////////////////////////

function get_count()
{
     return $this-> per_page - $this-> correction_from + $this-> correction_count;
}
/////////////////////////////////////////////////////////////////////////////

function get_limit_part()
{
     return ' LIMIT '.$this-> get_from(). ', '.$this-> get_count();
}
////////////////////////////////////////////////////////////////////////////
}//class ends here
?>