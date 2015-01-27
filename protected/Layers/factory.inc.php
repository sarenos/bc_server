<?php
/**************************************************************
* Project  : 
* Name     : Factory
* Version  : 1.0
* Date     : 2005.09.22
* Modified : $Id: factory.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
**************************************************************
* 
* Easy way to produce objects
* 
* 
*/

function produce_tpl()
{
     require_once SMARTY_DIR.'Smarty.class.php';
     $tpl = new Smarty();

     $tpl-> template_dir = ABS_PATH.'/templates/';
     $tpl-> compile_dir  = ABS_PATH.'/data/smarty_compile/';
     $tpl-> config_dir   = ABS_PATH.'/data/smarty_config/';
     $tpl-> cache_dir    = SMARTY_DIR.'/data/smarty_cache/';
     
     $tpl-> error_reporting = E_ALL^E_NOTICE;
     
     $tpl-> assign('HTTP_ABS_PATH', HTTP_ABS_PATH);
     $tpl-> assign('HTTP_STATIC_PATH', HTTP_STATIC_PATH);
     $tpl-> assign('ABS_STATIC_PATH', ABS_STATIC_PATH);
     $tpl-> assign('VERSION', VERSION);
     $tpl-> assign('TIME', time());
     return $tpl;
}

?>