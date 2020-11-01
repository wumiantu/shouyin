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
			$wx_user['mid']=$payConfig['configData']['mid']=$payConfig['mid'];
			$wx_user['proxymid']=$payConfig['configData']['proxymid']=$payConfig['proxymid'];
			$wx_user['sub_mch_id']=$payConfig['configData']['sub_mch_id']=$payConfig['wxsubmchid'];
            setCache('configData_'.$mid, $payConfig['configData']);
        }else{
		   $wx_user =$configData['weixin'];
		   $wx_user['mid']=$configData['mid'];
		   $wx_user['proxymid']=$configData['proxymid'];
		   $wx_user['sub_mch_id']=$configData['sub_mch_id'];
		}
		$is_define=true;
		/*if(!($configData['isOpen']>1)){
		  !defined('WxPay_CfgTips') && define('WxPay_CfgTips', '商家关闭了所有支付配置，支付将不能正常使用！');
		  unset($wx_user['mchid'],$wx_user['key']);
		  $is_define=false;
		}*/
		$tipsPrefix=$tipsSuffix='';
		$proxymid=$wx_user['proxymid'];
		if($proxymid > 0 ){
		   
		   $pconfigData = getCache('configData_'.$proxymid);
		   if(empty($pconfigData) || !isset($pconfigData['weixin'])){
			  $pconfigData = $this->get_one(array('mid' => $proxymid), '*');
			     if ($pconfigData['configData']){
                  $pconfigData['configData'] = unserialize(htmlspecialchars_decode($pconfigData['configData'],ENT_QUOTES));
				} 
				 $subwx_user=$wx_user;
				 $wx_user =$pconfigData['configData']['weixin'];
				 $wx_user['mid']=$pconfigData['configData']['mid']=$pconfigData['mid'];
				 $wx_user['proxymid']=$pconfigData['configData']['proxymid']=$pconfigData['proxymid'];
				 $wx_user['sub_appid']=$subwx_user['appid'];
				 $wx_user['sub_mch_id']=$subwx_user['sub_mch_id'];
				 $wx_user['p_mid']=$proxymid;
				 $wx_user['submchinfo']=$subwx_user;
				 unset($subwx_user);
				 $pconfigData['configData']['mid']=$pconfigData['mid'];
				 $tipsPrefix='特约服务商';
				 $tipsSuffix='请联系系统管理员处理';
				 setCache('configData_'.$proxymid, $pconfigData['configData']);
		   }else{
			    $subwx_user=$wx_user;
				$wx_user =$pconfigData['weixin'];
				$wx_user['mid']=$pconfigData['mid'];
				$wx_user['proxymid']=$pconfigData['proxymid'];
				$wx_user['sub_appid']=$subwx_user['appid'];
				$wx_user['sub_mch_id']=$subwx_user['sub_mch_id'];
				$wx_user['p_mid']=$proxymid;
				$wx_user['submchinfo']=$subwx_user;
				unset($subwx_user);
				$tipsPrefix='特约服务商';
				$tipsSuffix='请联系系统管理员处理';
		   }
		
		}

		if(empty($wx_user) || !isset($wx_user['mchid'])){
		  !defined('WxPay_CfgTips') && define('WxPay_CfgTips', $tipsPrefix.'商家没有配置微信支付，支付和卡券将不能正常使用！'.$tipsSuffix);
		    if ($wx_user['isOpen'] == 0) {
				!defined('WxPay_CfgTips') && define('WxPay_CfgTips', $tipsPrefix.'商家关闭了微信支付配置'.$tipsSuffix);
            }
			if($proxymid>0){
			   $wx_user['sub_mch_id'] >0 && !defined('WxPay_CfgTips') && define('WxPay_CfgTips', $tipsPrefix.'商家没有配置特约子商户号'.$tipsSuffix);
			}
		  unset($wx_user['mchid'],$wx_user['key']);
		  $is_define=false; 
		}

		if($is_define){
			$tips='';
			if(!isset($wx_user['rootca']) || empty($wx_user['rootca'])) $tips='CA证书文件没上传配置，微信退款功能可能会不能正常使用';
			if(!isset($wx_user['apiclient_key']) || empty($wx_user['apiclient_key'])) $tips='apiclient_key 公钥文件没上传配置，微信退款功能不能正常使用';
			if(!isset($wx_user['apiclient_cert']) || empty($wx_user['apiclient_cert'])) $tips='apiclient_cert 私钥文件没上传配置，微信退款功能不能正常使用';
			if(!isset($wx_user['key']) || empty($wx_user['key'])) $tips='API 密钥没配置，微信支付不能正常使用';
			if(!isset($wx_user['mchid']) || empty($wx_user['mchid'])) $tips='微支付商户号没配置，微信支付不能正常使用';
			if(!isset($wx_user['appSecret']) || empty($wx_user['appSecret'])) $tips='appSecret 没配置，微信支付不能正常使用';
			if(!isset($wx_user['appid']) || empty($wx_user['appid'])) $tips='appid 没配置，微信支付不能正常使用';

			!defined('WxPay_CfgTips') && define('WxPay_CfgTips', !empty($tips) ? $tipsPrefix.$tips.$tipsSuffix:'');
			!defined('WxPay_APPID') && define('WxPay_APPID', $wx_user['appid']);
			!defined('WxPay_MCHID') && define('WxPay_MCHID', $wx_user['mchid']);
			isset($wx_user['sub_appid']) && !defined('WxPay_SUBAPPID') && define('WxPay_SUBAPPID', $wx_user['sub_appid']);
			isset($wx_user['sub_mch_id']) && !defined('WxPay_SUBMCHID') && define('WxPay_SUBMCHID', $wx_user['sub_mch_id']);
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