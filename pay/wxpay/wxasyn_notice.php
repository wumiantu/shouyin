<?php
    header("Content-type: text/html; charset=utf-8");
	define('ABS_PATH',   dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);
	define('PIGCMS_CORE_PATH','../../pigcms/');
	define('OPIGCMS_CORE_PATH','./pigcms/');
	define('PIGCMS_TPL_PATH','../../pigcms_tpl/');
	define('PIGCMS_STATIC_PATH','../../pigcms_static/');
	define('APP_NAME','Merchants');
	define('DEBUG',true);
	define('GZIP',true);
	$_GET['m'] = 'Pay';
	$_GET['c'] = 'payreturn';
	$_GET['a'] = 'return_url';
	$_GET['paytype'] = 'weixin';
	include ABS_PATH.'config'.DIRECTORY_SEPARATOR.'config.inc.php';
	include ABS_PATH.'pigcms/base.php';
	
	bpBase::creatApp();
?>