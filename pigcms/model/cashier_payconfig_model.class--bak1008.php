<?php

bpBase::loadSysClass('model', '', 0);

class cashier_payconfig_model extends model {

    public function __construct() {
        $this->table_name = 'cashier_payconfig';
        parent::__construct();
    }

    public function getwxuserConf($mid=1,$type="wx") {
        $configData = getCache('configData_'.$mid);
		$wx_user='';
        if (empty($configData) || !isset($configData['weixin'])) {
            $payConfig = $this->get_one(array('mid' => $mid), '*');
            if ($payConfig['configData']){
                $payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData'],ENT_QUOTES));
			}
            $wx_user =$payConfig['configData']['weixin'];
			$payConfig['configData']['id']=$payConfig['id'];
            setCache('configData_'.$mid, $payConfig['configData']);
        }else{
		   $wx_user =$configData['weixin'];
		
		}
		$is_define=true;
		/*if(!($configData['isOpen']>1)){
		  !defined('WxPay_CfgTips') && define('WxPay_CfgTips', '商家关闭了所有支付配置，支付将不能正常使用！');
		  unset($wx_user['mchid'],$wx_user['key']);
		  $is_define=false;
		}*/
		if(empty($wx_user) || !isset($wx_user['mchid'])){
		  !defined('WxPay_CfgTips') && define('WxPay_CfgTips', '商家没有配置微信支付，支付和卡券将不能正常使用！');
		    if ($wx_user['isOpen'] == 0) {
				!defined('WxPay_CfgTips') && define('WxPay_CfgTips', '商家关闭了微信支付配置');
            }
		  unset($wx_user['mchid'],$wx_user['key']);
		  $is_define=false; 
		}
		/*if($wx_user['proxymid'] >0 ){
		   $proxymid=$wx_user['proxymid'];
		   $pconfigData = getCache('configData_'.$proxymid);
		   if(empty($pconfigData) || !isset($pconfigData['weixin'])){
			  $pconfigData = $this->get_one(array('mid' => $proxymid), '*');
			     if ($pconfigData['configData']){
                  $pconfigData['configData'] = unserialize(htmlspecialchars_decode($pconfigData['configData'],ENT_QUOTES));
				} 
				 $wx_user =$pconfigData['configData']['weixin'];
				 $pconfigData['configData']['id']=$pconfigData['id'];
				 setCache('configData_'.$proxymid, $pconfigData['configData']);
		   }
		
		}*/
		if($is_define){
			$tips='';
			if(!isset($wx_user['rootca']) || empty($wx_user['rootca'])) $tips='CA证书文件没上传配置，微信退款功能可能会不能正常使用';
			if(!isset($wx_user['apiclient_key']) || empty($wx_user['apiclient_key'])) $tips='apiclient_key 公钥文件没上传配置，微信退款功能不能正常使用';
			if(!isset($wx_user['apiclient_cert']) || empty($wx_user['apiclient_cert'])) $tips='apiclient_cert 私钥文件没上传配置，微信退款功能不能正常使用';
			if(!isset($wx_user['key']) || empty($wx_user['key'])) $tips='API 密钥没配置，微信支付不能正常使用';
			if(!isset($wx_user['mchid']) || empty($wx_user['mchid'])) $tips='微支付商户号没配置，微信支付不能正常使用';
			if(!isset($wx_user['appSecret']) || empty($wx_user['appSecret'])) $tips='appSecret 没配置，微信支付不能正常使用';
			if(!isset($wx_user['appid']) || empty($wx_user['appid'])) $tips='appid 没配置，微信支付不能正常使用';

			!defined('WxPay_CfgTips') && define('WxPay_CfgTips', $tips);
			!defined('WxPay_APPID') && define('WxPay_APPID', $wx_user['appid']);
			!defined('WxPay_MCHID') && define('WxPay_MCHID', $wx_user['mchid']);
			!defined('WxPay_KEY') && define('WxPay_KEY', $wx_user['key']);
			!defined('WxPay_SSLCERT_PATH') && define('WxPay_SSLCERT_PATH', urldecode($wx_user['apiclient_cert']));
			!defined('WxPay_SSLKEY_PATH') && define('WxPay_SSLKEY_PATH', urldecode($wx_user['apiclient_key']));
			!defined('WxPay_SSLCA_PATH') && define('WxPay_SSLCA_PATH', urldecode($wx_user['rootca']));
			!defined('WxPay_CURL_PROXY_HOST') && define('WxPay_CURL_PROXY_HOST', '0.0.0.0');
			!defined('WxPay_CURL_PROXY_PORT') && define('WxPay_CURL_PROXY_PORT', 0);
			!defined('WxPay_REPORT_LEVENL') && define('WxPay_REPORT_LEVENL', 1);
		}
		if($type=='wx'){
			return $wx_user;
		}
    }

}

?>