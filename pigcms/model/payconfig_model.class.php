<?php

bpBase::loadSysClass('model', '', 0);

class payconfig_model extends model {

    public function __construct() {
        $this->table_name = 'payconfig';
        parent::__construct();
    }

    public function getwxuserConf($mid=1) {
        //$wx_user = getCache('wxuser');
        if (empty($wx_user) || !isset($wx_user['mchid'])) {
            $payConfig = $this->get_one(array('mid' => $mid), 'id,isOpen,configData');
            if ($payConfig['configData'])
                $payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData'],ENT_QUOTES));
            if ($payConfig['configData']['weixin']['isOpen'] == 0) {
                return false;
            }
            $wx_user =$payConfig['configData']['weixin'];
            setCache('wxuser', $wx_user);
        }
        !defined('WxPay_APPID') && define('WxPay_APPID', $wx_user['appid']);
        !defined('WxPay_MCHID') && define('WxPay_MCHID', $wx_user['mchid']);
        !defined('WxPay_KEY') && define('WxPay_KEY', $wx_user['key']);
        !defined('WxPay_SSLCERT_PATH') && define('WxPay_SSLCERT_PATH', urldecode($wx_user['apiclient_cert']));
        !defined('WxPay_SSLKEY_PATH') && define('WxPay_SSLKEY_PATH', urldecode($wx_user['apiclient_key']));
        !defined('WxPay_CURL_PROXY_HOST') && define('WxPay_CURL_PROXY_HOST', '0.0.0.0');
        !defined('WxPay_CURL_PROXY_PORT') && define('WxPay_CURL_PROXY_PORT', 0);
        !defined('WxPay_REPORT_LEVENL') && define('WxPay_REPORT_LEVENL', 1);
        return $wx_user;
    }

}

?>