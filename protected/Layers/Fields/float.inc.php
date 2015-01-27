<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldInt
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: float.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/generic.inc.php';
class FieldFloat extends FieldGeneric
{
var $form_context_digits_format = '%.2f';
/////////////////////////////////////////////////////////////////////////////

function get_default_value()
{
     return 0.0;
}
///////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $this-> set_value((float)str_replace(',', '.', $this-> value));
}
/////////////////////////////////////////////////////////////////////////////

function set_form_context_digits_format($form_context_digits_format)
{
     $this-> form_context_digits_format = $form_context_digits_format;
}
//////////////////////////////////////////////////////////////////////////

function get_form_context()
{
     return sprintf($this-> form_context_digits_format, $this-> value);
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>