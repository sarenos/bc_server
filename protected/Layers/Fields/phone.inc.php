<?php
/***********************************************************
* Project  :
* Name     : FieldPhone
* Modified : $Id: phone.inc.php,v b2a03d8252b1 2012/01/19 20:34:42 ForJest $
* Author   : forjest@gmail.com
************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/string.inc.php';

class FieldPhone extends FieldString
{
///////////////////////////////////////////////////////////////////////////////

function __construct()
{
     parent::__construct();
}
///////////////////////////////////////////////////////////////////////////////

function get_number_dashed()
{
     $result = '';
     $digits = preg_replace("~[^\d]~", '', $this-> value);
     
     if (strlen($digits) < 6)
     {
          return '';
     }
     $number = substr($digits, -7);
     while (strlen($number) > 3)
     {
          $result = substr($number, -2).'-'.$result;
          $number = substr($number, 0, -2);
     }

     $result = $number.'-'.trim($result, '-');
     $code = substr($digits, -10, 3);
     if (strlen($digits) > 7)
     {
          $result = "($code) ".$result;
     }
     return $result;
}
////////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     parent::filter_pre();
     $this-> set_value($this-> get_number_dashed());
}
/////////////////////////////////////////////////////////////////////////////

}//class ends here
?>