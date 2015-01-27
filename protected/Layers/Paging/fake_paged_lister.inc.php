<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FakePagedLister
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: fake_paged_lister.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/Paging/paged_lister.inc.php';

class FakePagedLister extends PagedLister
{
var $results_count = 50;
/////////////////////////////////////////////////////////////////////////////

function create_db()
{
     
}
///////////////////////////////////////////////////////////////////////////

function get_row($id)
{
}
///////////////////////////////////////////////////////////////////////////

function get_list()
{
     $result = array();
     $offset = $this-> SQLPager-> get_from() + 1;
     for($i = 0, $cnt = $this-> SQLPager-> get_count(); $i < $cnt; $i++)
     {
          if ($i + $offset > $this-> get_results_count())
          {
               break;
          }
          $result[] = $this-> get_row($i+$offset);
     } 
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function set_results_count($results_count)
{
     $this-> results_count = $results_count;
     if (empty($this-> results_count))
     {
          //$this-> results_count = 50;
     }
}
//////////////////////////////////////////////////////////////////////////

function utf8($str)
{
     return iconv("CP1251", "UTF-8", $str);
}
///////////////////////////////////////////////////////////////////////////

function get_results_count()
{
     return $this-> results_count;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>