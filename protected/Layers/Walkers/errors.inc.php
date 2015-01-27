<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : WalkerErrors
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: errors.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/Lang/message_templates.inc.php';

require_once dirname(__FILE__).'/walker.inc.php';

class WalkerErrors extends Walker
{
var $is_error = false;
var $error_messages = array();
/////////////////////////////////////////////////////////////////////////////

function create_child_objects()
{
     $this-> MessageTemplates = new MessageTemplates();
}
///////////////////////////////////////////////////////////////////////////

function set_message_templates($MessageTemplates)
{
     $this-> MessageTemplates = $MessageTemplates;
}
///////////////////////////////////////////////////////////////////////////

function get_error_messages()
{
     return $this-> error_messages;
}
/////////////////////////////////////////////////////////////////////////////

function has_errors()
{
     return $this-> is_error;
}
/////////////////////////////////////////////////////////////////////////////

function reset_errors()
{
     $this-> error_messages = array();
     $this-> is_error = false;
}
/////////////////////////////////////////////////////////////////////////////

function get_message($Target)
{
     if ($Target-> is_custom_message())
     {
          return $Target-> get_error_message($this-> MessageTemplates);
     }
     return sprintf($this-> MessageTemplates-> get($Target-> get_error_code()), $Target-> get_form_context());
}
///////////////////////////////////////////////////////////////////////////

function grab_error_messages()
{
     foreach (array_keys($this-> Targets) as $key)
     {
          $Target= &$this-> Targets[$key];
          if ($Target-> has_error())
          {
               $this-> error_messages[$key] = $this-> get_message($Target);
               $this-> is_error = true;
          }
     }
}
/////////////////////////////////////////////////////////////////////////////

function walk()
{
     $this-> reset_errors();
     $this-> grab_error_messages();
}
/////////////////////////////////////////////////////////////////////////////
}
?>