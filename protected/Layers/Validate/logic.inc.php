<?php
/**************************************************************
* Project  :
* Name     : ValidateLogic
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/Walkers/errors.inc.php';

class ValidateLogic
{

/////////////////////////////////////////////////////////////////////////////

function ValidateLogic()
{
     $this-> create_objects();
     $this-> create_child_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> WalkerErrors = new WalkerErrors();
}
/////////////////////////////////////////////////////////////////////////////

function create_child_objects()
{
     
}
///////////////////////////////////////////////////////////////////////////

function set_fields(&$Fields)
{
     $this-> Fields = &$Fields;
     $this-> map_walkers();
}
/////////////////////////////////////////////////////////////////////////////

function map_walkers()
{
     $this-> WalkerErrors-> set_targets($this-> Fields);
}
/////////////////////////////////////////////////////////////////////////////

function get_error_messages()
{
     return $this-> WalkerErrors-> get_error_messages();
}
/////////////////////////////////////////////////////////////////////////////

function has_errors()
{
     return $this-> WalkerErrors-> has_errors();
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>