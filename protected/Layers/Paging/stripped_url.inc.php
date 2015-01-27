<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : StrippedUrl
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: stripped_url.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class StrippedUrl
{
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
     $result = $this-> get_page_stripped_url();
     $result = str_replace('&', '&amp;', $result);
     return $result;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>