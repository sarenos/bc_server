<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldFilePassword
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: datetime.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

require_once dirname(__FILE__).'/generic.inc.php';
class FieldDateTime extends FieldGeneric
{
protected static $now_preset = false;
/////////////////////////////////////////////////////////////////////////////

function __construct($value=null)
{
     $this-> is_now = false;
     parent::__construct($value);
}
/////////////////////////////////////////////////////////////////////////////

function set_value($value)
{
     $this-> value = $value;
     $this-> is_now = false;
}
/////////////////////////////////////////////////////////////////////////////

function get_default_value()
{
     return "'0000-00-00 00:00:00'";
}
///////////////////////////////////////////////////////////////////////////

function set_stamp($stamp)
{
     $this-> set(strftime('%Y-%m-%d %H:%M:%S', $stamp));
}
///////////////////////////////////////////////////////////////////////////

function get_stamp()
{
     return strtotime($this-> get());
}
///////////////////////////////////////////////////////////////////////////

function get_date()
{
     return substr($this-> value, 0, 10);
}
///////////////////////////////////////////////////////////////////////////

function get_db_context()
{
     if ($this-> is_now)
     {
          return 'NOW()';
     }
     return $this-> get_mysql_string_context($this-> get());
}
///////////////////////////////////////////////////////////////////////////

function get_form_context()
{
     return substr($this-> value, 0, -3);
}
///////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $this-> is_now = false;
     if (empty($this-> value) || strtotime($this-> value) < 0)
     {
          $this-> now();
          return;
     }
     $this-> set_value(strftime('%Y-%m-%d %H:%M:%S', strtotime($this-> value)));
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
          $this-> set_value(strftime('%Y-%m-%d %H:%M:%S'));
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
     $this-> set_stamp(strtotime($interval_str.' '.$this-> get()));
}
///////////////////////////////////////////////////////////////////////////

function less($Right)
{
     return $this-> value < $Right-> get();
}
///////////////////////////////////////////////////////////////////////////

function greater($Right)
{
     return $this-> value > $Right-> get();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>