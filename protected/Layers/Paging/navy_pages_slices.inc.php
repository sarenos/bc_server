<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : NavyPagesSelects
* Version  : 1.0
* Date     : 2010.03.08
* Modified : $Id: navy_pages_slices.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/navy_pages_wings.inc.php';

class NavyPagesSlices extends NavyPagesWings
{
protected $per_page = 0;
/////////////////////////////////////////////////////////////////////////////

function set_slice_size($size)
{
     $this-> slice_size = (int)$size;
     $this-> set_wings_size(ceil($this-> slice_size/2.0));
}
////////////////////////////////////////////////////////////////////////////

function is_first_slice()
{
     return $this-> get_wings_from() == 1;
}
///////////////////////////////////////////////////////////////////////////

function get_first()
{
     if ($this-> is_first_slice())
     {
          return;
     }
     return parent::get_first();
}
///////////////////////////////////////////////////////////////////////////

function is_last_slice()
{
     return $this-> get_wings_to() == $this-> links_count;
}
///////////////////////////////////////////////////////////////////////////

function get_last()
{
     if ($this-> is_last_slice())
     {
          return;
     }
     return parent::get_last();
}
///////////////////////////////////////////////////////////////////////////

function get_wings_from()
{
     $result = ($this-> current - $this-> wings_size);
     if ($result <=1)
     {
          $result = 1;
     }
     if ($result >= $this-> links_count)
     {
          $result = $this-> links_count+1;
     }
     if ($result >= ($this-> links_count - $this-> slice_size))
     {
          $result = max($this-> links_count - $this-> slice_size, 1);
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function get_wings_to()
{
     $result = ($this-> current + $this-> wings_size);
     if ($result > $this-> links_count)
     {
          $result = $this-> links_count;
     }
     if ($result <=1)
     {
          return -1;
     }
     if ($result < $this-> slice_size)
     {
          $result = min($this-> slice_size, $this-> links_count);
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

     if ($this-> links_count < 2)
     {
          return array($this-> get_one_row(1, true));
     }

     for ($i = $this-> get_wings_from(), $bound = $this-> get_wings_to(); $i <= $bound; $i++)
     {
          $result[] = $this-> get_one_row($i, true);
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

}//class ends here
?>