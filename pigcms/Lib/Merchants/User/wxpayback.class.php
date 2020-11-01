<?php

bpBase::loadAppClass('base', '', 0);

class wxpayback_controller extends base_controller {

    public $wx_user;

    public function __construct() {
        $session_storage = getSessionStorageType();
        bpBase::loadSysClass($session_storage);
        //$wx_user = M('cashier_payconfig')->getwxuserConf(1);
			$site_info = loadConfig('info');
			if (!empty($site_info['SITE_URL'])) {
				$SiteUrl = rtrim($site_info['SITE_URL'], '/');
			} else {
				$SiteUrl = $_SERVER['HTTP_HOST'];
				$SiteUrl = strtolower($SiteUrl);
				if (strpos($SiteUrl, "http:") === false && strpos($SiteUrl, "https:") === false)
					$SiteUrl = 'http://' . $SiteUrl;
				$SiteUrl = rtrim($SiteUrl, '/');
			}
			if(!defined('SITEURL')) define('SITEURL',$SiteUrl);
    }

    public function SaoMa2pay() {
        bpBase::loadAppClass('NativeNotifyCBK', 'User', 0);
        $NativeNotifyCBK = new NativeNotifyCBK();
        /* * *open_id在*NativeNotifyCBK中赋值** */
        if (isset($_SEESION['open_id']) && isset($_SEESION['theordertmp'])) {
            
        }
    }

}

?>