<?php
	define('ABS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
	define('PIGCMS_CORE_PATH','./pigcms/');
	define('PIGCMS_TPL_PATH','./pigcms_tpl/');
	define('PIGCMS_STATIC_PATH','./pigcms_static/');
	define('APP_NAME','Merchants');
	define('DEBUG',true);
	define('GZIP',true);
	include ABS_PATH.'config'.DIRECTORY_SEPARATOR.'config.inc.php';
	include ABS_PATH.PIGCMS_CORE_PATH.'base.php';
	bpBase::creatApp();
?>