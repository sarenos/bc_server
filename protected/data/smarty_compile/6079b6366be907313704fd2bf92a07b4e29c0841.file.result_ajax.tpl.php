<?php /* Smarty version Smarty-3.0.7, created on 2015-01-26 16:02:24
         compiled from "/var/www/b_city/protected/templates/result_ajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:209947822354c648f032d8f9-17029791%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6079b6366be907313704fd2bf92a07b4e29c0841' => 
    array (
      0 => '/var/www/b_city/protected/templates/result_ajax.tpl',
      1 => 1421653194,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209947822354c648f032d8f9-17029791',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo json_encode($_smarty_tpl->getVariable('Result')->value);?>
