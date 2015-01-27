<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : MessageTemplates
* Version  : 1.0
* Date     : 2012-02-08
* Modified : $Id: message_templates.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
class MessageTemplates
{
var $templates = array();
/////////////////////////////////////////////////////////////////////////////

function MessageTemplates()
{
     $this-> setup();
}
/////////////////////////////////////////////////////////////////////////////

function setup()
{
     $this-> templates = array(
          'email_format'   => 'Ivalid email format',
          'empty_required' => 'This field is required',
     );
}
/////////////////////////////////////////////////////////////////////////////

function register($code, $template)
{
     $this-> templates[$code] = $template;
}
/////////////////////////////////////////////////////////////////////////////

function get($code)
{
     if (empty($this-> templates[$code]))
     {
          return 'No message_template for code: '.$code;
     }
     return $this-> templates[$code];
}
/////////////////////////////////////////////////////////////////////////////

}//class ends here
?>