<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldUrl
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: url.inc.php,v adcd9368ea2f 2012/01/31 00:33:46 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/string.inc.php';
define('FIELD_ULR_VALID_PREG', "~^(file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&%\$\-]+)*@){0,1}((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|localhost|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]{2,5}[^:]){0,1}(\/(\s+|$|[a-zA-Z0-9\.\,\?\'\\\+&%\$#\=\~_\-]+)){0,1}~");
class FieldUrl extends FieldString
{
/////////////////////////////////////////////////////////////////////////////

function __construct($value=null)
{
     $this-> auto_protocol = true;
     parent::__construct($value);
}
///////////////////////////////////////////////////////////////////////////

function set_auto_protocol_off()
{
     $this-> auto_protocol = false;
}
///////////////////////////////////////////////////////////////////////////

function filter_pre()
{
     $this-> string_filter_pre();
     if ($this-> auto_protocol && !preg_match("~^[a-z]{3,5}://~", $this-> value) && !$this-> is_empty())
     {
          $this-> set_value('http://'.$this-> value);
     }
}
///////////////////////////////////////////////////////////////////////////

function is_valid_format()
{
     return preg_match(FIELD_ULR_VALID_PREG, $this-> value);
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>