<?php

if (file_exists(dirname(__FILE__).'/config.local.inc.php'))
{
     if (require_once dirname(__FILE__).'/config.local.inc.php')
     {
          return;
     }
}

define('VERSION', trim(strstr('$Revision$', ' '), ' $'));

ini_set('display_errors', true);
ini_set('html_errors', true);
error_reporting(E_ALL);

ob_start();

define('DEV_MODE', false);

date_default_timezone_set('Europe/Kiev');
define('DOMAIN_ROOT', 'charity.privatbank.ua');
define('SESSION_NAME', 'curex_rand');

define('ABS_PATH', rtrim(str_replace('\\', '/',dirname(__FILE__))),  '/');
define('ABS_STATIC_PATH', rtrim(realpath(ABS_PATH.'/../static/'), '/'));

define('SMARTY_DIR', ABS_PATH.'/Lib/Smarty/');
define('LAYERS_DIR', ABS_PATH.'/Layers');
define('HANDLERS_DIR', ABS_PATH.'/handlers');
define('LIB_DIR', ABS_PATH.'/Lib');

define('HTTP_ABS_PATH', 'http://'.DOMAIN_ROOT.'');
define('HTTP_STATIC_PATH', HTTP_ABS_PATH.'/static');
define('CSV_FILES_PATH', ABS_PATH.'/CSV');
define('CSV_FILE_NAME', '/blagotvor.csv');

////////////////////////////////////////////////////////////////////////////

$Config['db_name'] = 'bambicity_db';
$Config['db_host'] = 'node26063-env-8112542.unicloud.pl';
$Config['db_user'] = 'root';
$Config['db_pass'] = 'AMPoyv98957';

//$Config['db_name'] = 'u863877686_bambi';
//$Config['db_host'] = 'mysql.hostinger.com.ua';
//$Config['db_user'] = 'u863877686_test';
//$Config['db_pass'] = '37pxo9OZV3Ko8ITajQ';

//$Config['db_name'] = 'bambi_city_db';
//$Config['db_host'] = 'localhost';
//$Config['db_user'] = 'root';
//$Config['db_pass'] = '';

$Config['db_persistent'] = false;
$Config['db_debug_mode'] = false;
define('PER_PAGE_DEFAULT', 13);
define('PER_PAGE_MESSAGES', 100000000);
define('PER_PAGE_FRIENDS', 100000000);
define('PER_PAGE_USERS', 100000000);

/* filter default values */
define('FILTER_SEX', 'all');
define('FILTER_MINAGE', 14);
define('FILTER_MAXAGE', 99);
define('FILTER_RADIUS', 5);

/* status online */
define('STATUS_ONLINE_MINUTES_FRIEND', 10);

return true;