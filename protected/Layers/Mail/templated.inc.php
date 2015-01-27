<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : MailTemplated
* Version  : 1.0
* Date     : 2012.01.11
* Modified : $Id: templated.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/factory.inc.php';

class MailTemplated
{

var $to;
var $from;
var $subject;
var $data;
var $template;
var $is_error = false;
/////////////////////////////////////////////////////////////////////////////

function MailTemplated()
{
     $this-> tpl = produce_tpl();
     $this-> set_content_type('text/plain');
     $this-> set_encoding("UTF-8");
}
/////////////////////////////////////////////////////////////////////////////

function set_content_type($content_type)
{
     $this-> content_type = $content_type;
}
/////////////////////////////////////////////////////////////////////////////

function set_encoding($encoding)
{
     $this-> encoding = $encoding;
}
////////////////////////////////////////////////////////////////////////////

function set_to($to)
{
     $this-> to = $to;
}
////////////////////////////////////////////////////////////////////////////

function set_from($from)
{
     $this-> from = $from;
}
////////////////////////////////////////////////////////////////////////////

function set_subject($subject)
{
     $this-> subject = $subject;
}
////////////////////////////////////////////////////////////////////////////

function set_data($data)
{
     $this-> data = $data;
     $this-> tpl-> clearAllAssign();
}
////////////////////////////////////////////////////////////////////////////

function set_template($template)
{
     $this-> template = $template;
}
////////////////////////////////////////////////////////////////////////////

function get_body()
{
     foreach ($this-> data as $key=>$val)
     {
          $this-> tpl-> assign($key, $val);
     }
     
     $body = $this-> tpl-> fetch($this-> template);
     return $body;
}
/////////////////////////////////////////////////////////////////////////////

function has_error()
{
     return $this-> is_error;
}
/////////////////////////////////////////////////////////////////////////////

function get_transfer_headers()
{
     return "MIME-Version: 1.0\r\nContent-Type: ; charset=\r\nContent-Transfer-Encoding: base64\r\n";
}
////////////////////////////////////////////////////////////////////////////

function run()
{
     if(strtoupper($this->encoding)=='UTF-8')
     {
          $this-> subject = "=?UTF-8?B?" . base64_encode($this-> subject) . "?=";
     }
     
     $body = base64_encode($this->get_body());
     $this-> is_error = !mail($this-> to, $this-> subject, $body, $this-> get_transfer_headers()."From: ".$this-> from."\r\nReply-To: ".$this-> from."\r\nReturn-Path: ".$this-> from."\r\n", "-f".$this-> from);
}
/////////////////////////////////////////////////////////////////////////////
}//class ends here
?>