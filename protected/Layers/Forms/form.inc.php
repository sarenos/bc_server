<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : Form
* Version  : 1.0
* Date     : 2005.03.xx
* Modified : $Id: form.inc.php,v c4acc1159494 2012/02/06 12:32:10 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/Walkers/errors.inc.php';
require_once LAYERS_DIR.'/Walkers/validate.inc.php';
require_once LAYERS_DIR.'/Walkers/set_input_data.inc.php';
require_once LAYERS_DIR.'/Walkers/set_array.inc.php';
require_once LAYERS_DIR.'/Walkers/get_array.inc.php';
require_once LAYERS_DIR.'/Walkers/make_empty.inc.php';

require_once LAYERS_DIR.'/Validate/not_empty.inc.php';
require_once LAYERS_DIR.'/Validate/chain.inc.php';
require_once LAYERS_DIR.'/Validate/url.inc.php';
require_once LAYERS_DIR.'/Validate/pattern.inc.php';
require_once LAYERS_DIR.'/Validate/length.inc.php';
require_once LAYERS_DIR.'/Validate/email_format.inc.php';
require_once LAYERS_DIR.'/Validate/format.inc.php';

class Form
{
protected $input_data;
protected $Fields = array();
/////////////////////////////////////////////////////////////////////////////

function Form()
{
     $this-> create_objects();
     $this-> create_child_objects();
}
/////////////////////////////////////////////////////////////////////////////

function create_objects()
{
     $this-> WalkerErrors               = new WalkerErrors();
     $this-> WalkerValidate             = new WalkerValidate();
     $this-> WalkerSet                  = new WalkerSetInputData();
     $this-> WalkerEraser               = new WalkerMakeEmpty();
}
/////////////////////////////////////////////////////////////////////////////

function create_child_objects()
{
     
}
/////////////////////////////////////////////////////////////////////////////

function set_tuple($Tuple)
{
     $this-> Tuple = $Tuple;
     $this-> create_fields();
     $this-> map_walkers();
}
/////////////////////////////////////////////////////////////////////////////

function set_entity($Entity)
{
     $this-> set_tuple($Entity-> get_tuple());
}
////////////////////////////////////////////////////////////////////////////

function &get_fields()
{
     return $this-> Fields;
}
///////////////////////////////////////////////////////////////////////////

function &get_field($name)
{
     return $this-> Fields[$name];
}
///////////////////////////////////////////////////////////////////////////

function get_field_value($name)
{
     return $this-> get_field($name)-> get();
}
///////////////////////////////////////////////////////////////////////////

protected function map_walkers()
{
     $this-> WalkerErrors-> set_targets($this-> Fields);
     $this-> WalkerValidate-> set_targets($this-> Fields);
     $this-> WalkerSet-> set_targets($this-> Fields);
     $this-> WalkerEraser-> set_targets($this-> Fields);
}
/////////////////////////////////////////////////////////////////////////////

protected function fill_data_by_keys()
{
     $this-> WalkerSet-> set($this-> input_data);
     $this-> WalkerSet-> walk();
}
/////////////////////////////////////////////////////////////////////////////

function set_input_data($input_data)
{
     $this-> input_data = $input_data;
     $this-> input_data['go'] = (string)@$this-> input_data['go'];
     if (!$this-> is_submited())
     {
          return;
     }
     $this-> fill_data_by_keys(); 
}
////////////////////////////////////////////////////////////////////////////

function get_context_keys()
{
     return array_keys($this-> Fields);
}
/////////////////////////////////////////////////////////////////////////////

function get_fields_context()
{
     $result = array();
     foreach ($this-> get_context_keys() as $key)
     {
          $Field = &$this-> Fields[$key];
          $result[$key] = $Field-> get_form_context();
     }
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function reset_context()
{
     foreach ($this-> get_context_keys() as $key)
     {
          $this-> Fields[$key]-> set_default();
     }
}
///////////////////////////////////////////////////////////////////////////

function get_context()
{
     $result = $this-> get_fields_context();
     $result['_Flags']['has_errors'] = $this-> has_errors();
     $result['_Flags']['is_done']    = $this-> is_done();
     return $result;
}
/////////////////////////////////////////////////////////////////////////////

protected function reset_errors()
{
     $this-> error_messages = array();
     $this-> is_error = false;
}
/////////////////////////////////////////////////////////////////////////////

protected function validate_fields()
{
     $this-> WalkerValidate-> walk();
}
/////////////////////////////////////////////////////////////////////////////

protected function validate_dependencies()
{
     
}
/////////////////////////////////////////////////////////////////////////////

protected function grab_error_messages()
{
     $this-> WalkerErrors-> walk();
}
/////////////////////////////////////////////////////////////////////////////

protected function get_submit_keystring()
{
     return '';
}
///////////////////////////////////////////////////////////////////////////

function is_posted()
{
     return $this-> is_submited();
}
/////////////////////////////////////////////////////////////////////////////

function is_submited()
{
     if (empty($this-> input_data['go']))
     {
          return false;
     }
     
     if ($this-> get_submit_keystring())
     {
          return $this-> get_submit_keystring() == (string)@$this-> input_data['go'];
     }
     return true;
}
///////////////////////////////////////////////////////////////////////////

function validate()
{
     $this-> reset_errors();
     if (!$this-> is_submited())
     {
          return false;
     }
     $this-> validate_fields();
     $this-> validate_dependencies();
     $this-> grab_error_messages();
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

function is_done()
{
     return $this-> is_posted() && !$this-> has_errors();
}
/////////////////////////////////////////////////////////////////////////////

function make_empty()
{
     $this-> WalkerEraser-> walk();
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>