<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldFilePassword
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: date.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

require_once dirname(__FILE__).'/generic.inc.php';
class FieldDate extends FieldGeneric
{
protected static $now_preset = false;
protected $need_reconvert_from_mm_dd_yy = false;
/////////////////////////////////////////////////////////////////////////////

function set_stamp($stamp)
{
     $this-> set(strftime('%Y-%m-%d', $stamp));
}
///////////////////////////////////////////////////////////////////////////

function get_stamp()
{
     return strtotime($this-> get());
}
///////////////////////////////////////////////////////////////////////////

function get_day()
{
	return strftime('%d', $this-> get_stamp());
}
/////////////////////////////////////////////////////////////////////////////

function get_default_value()
{
     return "'0000-00-00'";
}
///////////////////////////////////////////////////////////////////////////

function reconvert_from_mm_dd_yy_on()
{
     $this-> need_reconvert_from_mm_dd_yy = true;
}
////////////////////////////////////////////////////////////////////////////

function reconvert_from_mm_dd_yy()
{
     $this-> set_value(preg_replace('~(\d+)-(\d+)-(\d+)~', '\\3-\\1-\\2', $this-> value));
}
////////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     if ($this-> need_reconvert_from_mm_dd_yy)
     {
          $this-> reconvert_from_mm_dd_yy();
     }
     if (empty($this-> value) || strtotime($this-> value) < 0)
     {
          $this-> now();
     }
     $this-> set_value(strftime('%Y-%m-%d', strtotime($this-> value)));
}
///////////////////////////////////////////////////////////////////////////

static function now_preset($now_preset)
{
     self::$now_preset = $now_preset;
}
///////////////////////////////////////////////////////////////////////////

static function now_usual()
{
     self::$now_preset = false;
}
///////////////////////////////////////////////////////////////////////////

function now()
{
     if (!self::$now_preset)
     {
          $this-> set(strftime('%Y-%m-%d'));
          $this-> is_now = true;
     }
     else
     {
          $this-> set(self::$now_preset);
          $this-> is_now = false;
     }
}
/////////////////////////////////////////////////////////////////////////////

function interval($interval_str)
{
//     $this-> set_stamp(strtotime($interval_str.' '.$this-> get()));
	$this-> set_stamp(strtotime($interval_str));
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>