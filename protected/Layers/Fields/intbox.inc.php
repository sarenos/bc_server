<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldIntBox
* Version  : 1.0
* Date     : 2007.07.17
* Modified : $Id: intbox.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/int.inc.php';
class FieldIntBox extends FieldInt
{
/////////////////////////////////////////////////////////////////////////////

function get_form_context()
{
     if (empty($this-> value))
     {
          return '';
     }
     return $this-> value;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>