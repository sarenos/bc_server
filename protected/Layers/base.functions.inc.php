<?php
/**************************************************************
* Project  : 
* Name     : Here placed small functions need project
* Version  : 1.0
* Date     : 2009.07.19
* Modified : $Id: base.functions.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
**************************************************************
* 
* This file will be included in each script in project
* 
* 
*/
function add_recursive(&$Target, $data, $cnt)
{
     if (is_array($Target) && is_scalar($data))
     {
          $Target[] = $data*$cnt;
          return;
     }
     if (is_array($data))
     {
          foreach ($data as $key=> $val)
          {
               add_recursive($Target[$key], $val, $cnt);
          }
          return;
     }
     $Target += $data*$cnt;
}
///////////////////////////////////////////////////////////////////////////
?>