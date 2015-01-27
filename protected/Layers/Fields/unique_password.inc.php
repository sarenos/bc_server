<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : FieldUniquePassword
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: unique_password.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once dirname(__FILE__).'/string.inc.php';
class FieldUniquePassword extends FieldString
{
     var $letters = array();
     var $digits = array();
     var $dictonary = array();
/////////////////////////////////////////////////////////////////////////////

function __construct($value=null)
{
     $this-> letters = range('A', 'Z');
     $this-> digits = range(1, 9);
     parent::__construct($value);
}
///////////////////////////////////////////////////////////////////////////

function init_time()
{
     srand((float)microtime() * 1000000);
}
///////////////////////////////////////////////////////////////////////////

function init_dictonary()
{
     shuffle($this-> letters);
     shuffle($this-> digits);
     $this-> dictonary = array_merge($this-> letters, $this-> digits);
     shuffle($this-> dictonary);
}
///////////////////////////////////////////////////////////////////////////

function fill()
{
     $this-> make_empty();
     
     $this-> init_time();
     $this-> init_dictonary();
     
     $rand_keys = array_rand($this-> dictonary, $this-> get_max_length());
     for($i=0, $len = sizeof($rand_keys); $i<$len; $i++)
     {
          $this-> value .= $this-> dictonary[$rand_keys[$i]];
     }
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>