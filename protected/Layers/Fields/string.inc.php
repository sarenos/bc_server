<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldGeneric
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: string.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
mb_internal_encoding('UTF-8');
define('FIELD_STRING_DEFAULT_MAX_LENGTH', 65535);
require_once dirname(__FILE__).'/generic.inc.php';

class FieldString extends FieldGeneric
{
////////////////////////////////////////////////////////////////////////////

function __call($name, $args)
{
     if (FALSE !== strpos($name, 'set_') || FALSE !== strpos($name, 'get_'))
     {
          throw new Exception("Unexpected method called: '".$name."'");
     }
     return call_user_func_array($name, $this-> value);
}
/////////////////////////////////////////////////////////////////////////////

function get_default_value()
{
     return "''";
}
///////////////////////////////////////////////////////////////////////////

function set_max_length($max_length)
{
     $this-> max_length = (int)$max_length;
}
//////////////////////////////////////////////////////////////////////////

function get_max_length()
{
     if (empty($this-> max_length))
     {
          return FIELD_STRING_DEFAULT_MAX_LENGTH;
     }
     return $this-> max_length;
}
///////////////////////////////////////////////////////////////////////////

function filter_max_length()
{
     $this-> set_value($this-> substr($this-> value, 0, $this-> get_max_length()));
}
///////////////////////////////////////////////////////////////////////////

function substr($string, $from, $to)
{
     if (function_exists('mb_substr'))
     {
          return mb_substr($string, $from, $to);
     }
     
     return substr($string, $from, $to);
}
///////////////////////////////////////////////////////////////////////////

function string_filter_pre()
{
     $this-> filter_trim();
     $this-> filter_max_length();
}
///////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $this-> string_filter_pre();
}
/////////////////////////////////////////////////////////////////////////////

function get_length()
{
     return strlen($this-> value);
}
///////////////////////////////////////////////////////////////////////////

function set_list($list)
{
     $this-> set_value(implode(',', $list));
}
///////////////////////////////////////////////////////////////////////////

function get_list()
{
     return array($this-> value);
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>