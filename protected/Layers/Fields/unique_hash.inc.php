<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldUniqueHash
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: unique_hash.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
define('UNIQUE_HASH_DEFAULT_LENGTH', 48);
require_once dirname(__FILE__).'/generic.inc.php';
class FieldUniqueHash extends FieldGeneric
{
/////////////////////////////////////////////////////////////////////////////

function __construct($value=null)
{
     $this-> set_length(UNIQUE_HASH_DEFAULT_LENGTH);
     parent::__construct($value);
}
///////////////////////////////////////////////////////////////////////////

function set_length($length)
{
     $this-> length = $length;
}
//////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $this-> set_value(substr($this-> value, 0, $this-> length));
}
///////////////////////////////////////////////////////////////////////////

function fill()
{
     $this-> set(substr(time().md5(uniqid(rand(), true)), 0, $this-> length));
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>