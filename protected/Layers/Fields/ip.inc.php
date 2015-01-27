<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldIP
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: ip.inc.php,v adcd9368ea2f 2012/01/31 00:33:46 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/string.inc.php';
define('FIELD_IP_FORMAT_PREG', '~^(\d{1,3})\.(\d{1,3}).(\d{1,3}).(\d{1,3})$~');

class FieldIP extends FieldString
{
/////////////////////////////////////////////////////////////////////////////

function is_valid_format()
{
     if (!preg_match(FIELD_IP_FORMAT_PREG, $this-> value, $M))
     {
          return false;
     }
     unset($M[0]);
     foreach ($M as $period)
     {
          if ($period < 0 || $period > 255)
          {
               return false;
          }
     }
     return true;
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>