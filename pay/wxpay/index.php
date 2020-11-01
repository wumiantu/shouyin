<?php
    header("Content-type: text/html; charset=utf-8");
	define('ABS_PATH',   dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);
	define('PIGCMS_CORE_PATH','../../pigcms/');
	define('OPIGCMS_CORE_PATH','./pigcms/');
	define('PIGCMS_TPL_PATH','../../pigcms_tpl/');
	define('OPIGCMS_TPL_PATH','./pigcms_tpl/');
	define('PIGCMS_STATIC_PATH','../../pigcms_static/');
	define('ABS_UPLOAD_PATH','/Cashier');/**独立作为站时不要配置此项或者配置成空''**/
	define('APP_NAME','Merchants');
	define('DEBUG',true);
	define('GZIP',true);
	$_GET['m'] = 'Index';
	$_GET['c'] = 'pay';
	$_GET['a'] = 'foreverpaying';
	include ABS_PATH.'config'.DIRECTORY_SEPARATOR.'config.inc.php';
	include ABS_PATH.'pigcms/base.php';
	
	bpBase::creatApp();
?>