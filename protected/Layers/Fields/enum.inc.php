<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldEnum
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: enum.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
define('FIELD_ENUM_EMPTY_CAPTION', '_<sys_enum_empty_caption>_');

require_once dirname(__FILE__).'/generic.inc.php';

class FieldEnum extends FieldGeneric
{
protected $possible_values = array();
protected $idx = 0;
protected $Captions = array();
/////////////////////////////////////////////////////////////////////////////

function __construct($possible_values = array())
{
      $this-> possible_values = $possible_values;
      $this-> set_default();
      $this-> set_captions_list(array());
}
///////////////////////////////////////////////////////////////////////////

function get_default_value()
{
     return reset($this-> get_possible_values());
}
///////////////////////////////////////////////////////////////////////////

function set_value($value)
{
     $this-> value = $value;
     $this-> idx = array_search($value, $this-> possible_values);
}
//////////////////////////////////////////////////////////////////////////

function set_possible_values($possible_values)
{
     $this-> possible_values = $possible_values;
     $this-> set_default();
     $this-> set_captions_list(array());
}
//////////////////////////////////////////////////////////////////////////

function get_values_list()
{
     return $this-> get_possible_values();
}
////////////////////////////////////////////////////////////////////////////

function get_possible_values()
{
     return $this-> possible_values;
}
///////////////////////////////////////////////////////////////////////////

function set_captions_list($Captions)
{
     $this-> Captions = array();
     foreach ($this-> possible_values as $key => $value)
     {
          if (isset($Captions[$key]))
          {
               $this-> Captions[$value] = $Captions[$key];
          }
          if (isset($Captions[$value]))
          {
               $this-> Captions[$value] = $Captions[$value];
          }
          if (empty($this-> Captions[$value]))
          {
               $this-> Captions[$value] = $value;
          }
          if (FIELD_ENUM_EMPTY_CAPTION == $this-> Captions[$value])
          {
               $this-> Captions[$value] = '';
          }
     }
}
///////////////////////////////////////////////////////////////////////////

function get_captions_list()
{
     return $this-> Captions;
}
///////////////////////////////////////////////////////////////////////////

function get_caption()
{
     if (!$this-> is_valid_value())
     {
          return '';
     }
     return $this-> Captions[$this-> value];
}
///////////////////////////////////////////////////////////////////////////

function set_values_and_captions($ValuesAndCaptions)
{
     $this-> set_possible_values(array_keys($ValuesAndCaptions));
     $this-> set_captions_list(array_values($ValuesAndCaptions));
}
function get_values_and_captions()
{
     return array_combine($this-> possible_values, $this-> Captions);
}
///////////////////////////////////////////////////////////////////////////

function get_db_context()
{
     if ($this-> is_empty())
     {
          return $this-> get_mysql_string_context($this-> get_default_value());
     }
     else
     {
          return parent::get_db_context();
     }
}
/////////////////////////////////////////////////////////////////////////////

function is_valid_value()
{
     if (!count($this-> get_possible_values()))
     {
          return true;
     }
     return in_array($this-> value, $this-> get_possible_values());
}
///////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $this-> filter_trim();
     if (!$this-> is_valid_value())
     {
          $this-> set_default();
          return;
     }
     $this-> idx = array_search($this-> value, $this-> get_possible_values());
}
/////////////////////////////////////////////////////////////////////////////

function get_max_idx()
{
     return count($this-> possible_values) - 1;
}
///////////////////////////////////////////////////////////////////////////

function get_idx()
{
     return $this-> idx;
}
///////////////////////////////////////////////////////////////////////////

function set_idx($idx)
{
     $this-> idx = $idx;
     if ($this-> idx > $this-> get_max_idx())
     {
          $this-> set_idx($this-> get_max_idx());
          return;
     }
     if ($this-> idx < 0)
     {
          $this-> set_default();
          return;
     }
     $this-> set_value($this-> possible_values[$this-> idx]);
}
///////////////////////////////////////////////////////////////////////////

function is($value)
{
     return $this-> value == $value;
}
///////////////////////////////////////////////////////////////////////////

function inc($step=1)
{
     $this-> set_idx($this-> idx + $step);
}
///////////////////////////////////////////////////////////////////////////

function dec($step=1)
{
     $this-> set_idx($this-> idx - $step);
}
///////////////////////////////////////////////////////////////////////////

function random_value()
{
     $this-> set_idx(rand(0, $this-> get_max_idx()));
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>