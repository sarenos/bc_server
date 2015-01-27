<?php /* Smarty version Smarty-3.0.7, created on 2015-01-19 18:08:17
         compiled from "/var/www/bambi_city/protected/templates/result_ajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:79479854bd2bf13d2054-97295844%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4d6efaa8f2e9074b9fa636f724d469e529552ae' => 
    array (
      0 => '/var/www/bambi_city/protected/templates/result_ajax.tpl',
      1 => 1421653194,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '79479854bd2bf13d2054-97295844',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo json_encode($_smarty_tpl->getVariable('Result')->value);?>
