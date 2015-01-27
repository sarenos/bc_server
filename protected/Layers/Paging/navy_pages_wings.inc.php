<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : NavyPagesWings
* Version  : 1.0
* Date     : 2005.05.07
* Modified : $Id: navy_pages_wings.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/navy_pages.inc.php';
class NavyPagesWings extends NavyPages
{
var $wings_size = 0;
////////////////////////////////////////////////////////////////////////////

function set_wings_size($wings_size)
{
     $this-> wings_size = (int)$wings_size;
}
////////////////////////////////////////////////////////////////////////////

function get_one_link($num)
{
     return array(
          'text' => preg_replace("~%d~", $num, $this-> text_format),
          'url'  => preg_replace("~%d~", $num, $this-> url_format),
          'is_current'=> $num == $this-> current
     );
}
////////////////////////////////////////////////////////////////////////////

function get_one_row($num, $show)
{
     $result = $this-> get_one_link($num);
     $result['is_wing_chars'] = !$show;
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function get_wings_from()
{
     $result = ($this-> current - $this-> wings_size);
     if ($result <=1)
     {
          $result = 2;
     }
     if ($result >= $this-> links_count)
     {
          $result = $this-> links_count+1;
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function has_left_wing()
{
     return ($this-> current - $this-> wings_size) > 1;
}
/////////////////////////////////////////////////////////////////////////////

function has_right_wing()
{
     return ($this-> current + $this-> wings_size) < $this-> links_count;
}
/////////////////////////////////////////////////////////////////////////////

function get_wings_to()
{
     $result = ($this-> current + $this-> wings_size);
     if ($result >= $this-> links_count)
     {
          $result = $this-> links_count-1;
     }
     if ($result <=1)
     {
          $result = -1;
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function get_links()
{
     $result = array();
     if (empty($this-> links_count))
     {
          return $result;
     }

     $result[] = $this-> get_one_row(1, true);

     if ($this-> links_count < 2)
     {
          return $result;
     }

     if ($this-> has_left_wing())
     {
          $result[] = $this-> get_one_row($this-> get_wings_from() - 1, false);
     }

     for ($i = $this-> get_wings_from(), $bound = $this-> get_wings_to(); $i <= $bound; $i++)
     {
          $result[] = $this-> get_one_row($i, true);
     }

     if ($this-> has_right_wing())
     {
          $result[] = $this-> get_one_row($this-> get_wings_to() + 1, false);
     }

     $result[] = $this-> get_one_row($this-> links_count, true);
     return $result;
}
/////////////////////////////////////////////////////////////////////////////
}//class ends her&$dbe
?>