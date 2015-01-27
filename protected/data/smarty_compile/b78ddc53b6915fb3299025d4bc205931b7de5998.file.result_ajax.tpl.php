<?php /* Smarty version Smarty-3.0.7, created on 2014-02-26 18:05:05
         compiled from "D:/wamp/www/bambi_city/protected/templates/result_ajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24380530e10b1b37136-85520636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b78ddc53b6915fb3299025d4bc205931b7de5998' => 
    array (
      0 => 'D:/wamp/www/bambi_city/protected/templates/result_ajax.tpl',
      1 => 1393235230,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24380530e10b1b37136-85520636',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo json_encode($_smarty_tpl->getVariable('Result')->value);?>
