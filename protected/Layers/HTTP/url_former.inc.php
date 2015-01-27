<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : HTTPUrlFormer
* Version  : 1.0
* Date     : 2007.07.01
* Modified : $Id: url_former.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class HTTPUrlFormer
{
/////////////////////////////////////////////////////////////////////////////

function HTTPUrlFormer($pattern = '')
{
     $this-> set_pattern($pattern);
}
/////////////////////////////////////////////////////////////////////////////

function set_pattern($pattern)
{
     $this-> pattern = $pattern;
}
//////////////////////////////////////////////////////////////////////////

function get_rowed($row)
{
     $result = $this-> pattern;
     foreach ($row as $key => $val)
     {
          if (is_array($val))
          {
               continue;
          }
          $result = str_replace('<'.$key.'>', rawurlencode(str_replace(array('/', ' '), array('---', '-'), $val)), $result);
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>