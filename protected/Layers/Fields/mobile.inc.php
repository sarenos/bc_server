<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldMobile
* Version  : 1.0
* Date     : 2010.08.18
* Modified : $Id: mobile.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/string.inc.php';
class FieldMobile extends FieldString
{
protected $prefix = '';
/////////////////////////////////////////////////////////////////////////////

function set_prefix($prefix)
{
     $this-> prefix = $prefix;
}
//////////////////////////////////////////////////////////////////////////

function get_no_prefix($value)
{
     if (empty($value))
     {
          return '';
     }
     $result = $value;
     for ($i=0, $cnt = strlen($this-> prefix); $i < $cnt; $i++)
     {
          if ($result[0] == $this-> prefix)
          {
               $result= substr($result, 1);
          }
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $value = preg_replace("~[^\d]+~", '', $this-> value);
     if (empty($value))
     {
          $this-> set_default();
          return;
     }
     $value = $this-> get_no_prefix($value);
     if (empty($value))
     {
          $this-> set_default();
          return;
     }
     $this-> set_value($this-> prefix.$value);
}
///////////////////////////////////////////////////////////////////////////

function get_number_dashed($number)
{
     $result = '';
     while (strlen($number) > 3)
     {
          $result = substr($number, -2).'-'.$result;
          $number = substr($number, 0, -2);
     }
     if (!empty($number))
     {
          $result = $number.'-'.$result;
     }
     return trim($result, '-');
}
///////////////////////////////////////////////////////////////////////////

function get_canonic()
{
     $number = $this-> get_no_prefix($this-> value);
     if (empty($number))
     {
          return '';
     }
     $result  = $this-> prefix.' ('.substr($number, 0, 3).') ';
     $result .= $this-> get_number_dashed(substr($number, 3));
     return trim($result);
}
///////////////////////////////////////////////////////////////////////////

function get_form_context()
{
     return trim($this-> get_no_prefix($this-> get_canonic()));
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>