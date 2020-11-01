<?php

bpBase::loadAppClass('base', '', 0);

class payreturn_controller extends base_controller {
    public function __construct() {
		parent::__construct();
        $session_storage = getSessionStorageType();
        bpBase::loadSysClass($session_storage);
    }

    public function return_url() {
        $logpath = './barpay/logs/return_url.log';
        file_put_contents($logpath,  $GLOBALS['HTTP_RAW_POST_DATA']. "\r\n", FILE_APPEND);
        bpBase::loadOrg('WxSaoMaPay/WxPayPubHelper');
                //使用通用通知接口
                //$notify = new Notify_pub($wx_user['appid'], $wx_user['mchid'], $wx_user['key'], $wx_user['appSecret']);
                //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if ($array_data['return_code'] == 'SUCCESS' && $array_data['result_code'] == 'SUCCESS') {
            $notifyData['appid'] = $array_data['appid'];
			$notifyData['mch_id'] = $array_data['mch_id'];
			$notifyData['sub_appid'] = isset($array_data['sub_appid']) ? $array_data['sub_appid'] :'';
			$notifyData['sub_mch_id'] = isset($array_data['sub_mch_id']) ? $array_data['sub_mch_id'] :'';
			
            $notifyData['total_fee'] = $array_data['total_fee'];
            $notifyData['trade_type'] = $array_data['trade_type'];
            $notifyData['transaction_id'] = $array_data['transaction_id'];
            $notifyData['order_id'] = $array_data['out_trade_no'];
            $notifyData['openid'] = isset($array_data['openid']) ? $array_data['openid'] :'';
			$notifyData['sub_openid'] = isset($array_data['sub_openid']) ? $array_data['sub_openid'] :'';
            $notifyData['ordid'] = isset($array_data['ordid']) ? $array_data['ordid'] : 0; //订单表自增id
            $notifyData['mid'] = isset($array_data['merid']) ? $array_data['merid'] : 0; //商户表id
            $notifyData['is_subscribe'] = strtoupper(trim($array_data['is_subscribe'])) == 'Y' ? 1 : 0; //是否关注了
            if ($notifyData['mid'] > 0) {
				$orderDb=M('cashier_order');
                $notifyData['ordid'] > 0 && $where['id'] = $notifyData['ordid'];
                $where['mid'] = $notifyData['mid'];
                $where['order_id'] = $notifyData['order_id'];
				
				$orderTmp=$orderDb->get_one($where, '*');
				if($orderTmp['ispay']==1) {
					echo "<xml><return_code><![CDATA[SUCCESS]]></return_code></xml>";
					exit();
					
				}
				$tmpopenid=!empty($notifyData['sub_mch_id']) ? $notifyData['sub_openid'] : $notifyData['openid'];
				$p_openid=!empty($notifyData['sub_mch_id']) ? $notifyData['openid'] :'';
				$tmpappid=!empty($notifyData['sub_mch_id']) ? $notifyData['sub_appid'] : $notifyData['appid'];
				$wxuserinfo=array();

					bpBase::loadOrg('wxCardPack');
					$wx_user = M('cashier_payconfig')->getwxuserConf($notifyData['mid']);
					if(!empty($notifyData['sub_mch_id']) && isset($wx_user['submchinfo']) && ($notifyData['mid']==$wx_user['submchinfo']['mid'])){
					  $wxCardPack = new wxCardPack($wx_user['submchinfo'],$notifyData['mid']);
					}else{
					  $wxCardPack = new wxCardPack($wx_user,$notifyData['mid']);
					}
					$access_token = $wxCardPack->getToken();
					$wxuserinfo=$wxCardPack->GetwxUserInfoByOpenid($access_token,$tmpopenid);
				
				$updateData=array('ispay' => 1, 'state' => 1, 'openid' => $tmpopenid,'p_openid'=>$p_openid,'paytime'=>time(),'transaction_id'=>$notifyData['transaction_id']);
				isset($wxuserinfo['nickname']) && $updateData['truename']=$wxuserinfo['nickname'];

                $orderDb->update($updateData, $where);
				$fansDb = M('cashier_fans');

				if(!empty($tmpopenid)){
                $tmpfans = $fansDb->get_one(array('openid' => $tmpopenid, 'mid' => $notifyData['mid']), '*');
                $fansData = array('appid' => $tmpappid, 'totalfee' => $notifyData['total_fee'], 'is_subscribe' =>0);

				if(isset($wxuserinfo['nickname'])){
					 $fansData['nickname']=$wxuserinfo['nickname'];
					 $fansData['sex']=$wxuserinfo['sex'];
					 $fansData['province']=$wxuserinfo['province'];
					 $fansData['city']=$wxuserinfo['city'];
					 $fansData['country']=$wxuserinfo['country'];
					 $fansData['headimgurl']=$wxuserinfo['headimgurl'];
					 $fansData['groupid']=$wxuserinfo['groupid'];
					 $fansData['is_subscribe']=1;
				}

                if (!empty($tmpfans) && is_array($tmpfans)) {
                    $fansData['totalfee'] = $fansData['totalfee'] + $tmpfans['totalfee'];
                    $fansDb->update($fansData, array('id' => $tmpfans['id']));
                } else {
                    $fansData['mid'] = $notifyData['mid'];
                    $fansData['openid'] = $tmpopenid;
                    $fansDb->insert($fansData, True);
                }
				unset($fansData);
				}
				if(!empty($p_openid) && isset($wx_user['p_mid']) && isset($wx_user['submchinfo'])){
				    $pwxCardPack = new wxCardPack($wx_user,$wx_user['p_mid']);
					$paccess_token = $pwxCardPack->getToken();
					$pwxuserinfo=$pwxCardPack->GetwxUserInfoByOpenid($paccess_token,$p_openid);
					$ptmpfans = $fansDb->get_one(array('openid' => $p_openid, 'mid' => $wx_user['p_mid']), '*');
					$fansData = array('appid' => $wx_user['appid'], 'totalfee' => $notifyData['total_fee'], 'is_subscribe' => 0);

					if(isset($pwxuserinfo['nickname'])){
						 $fansData['nickname']=$pwxuserinfo['nickname'];
						 $fansData['sex']=$pwxuserinfo['sex'];
						 $fansData['province']=$pwxuserinfo['province'];
						 $fansData['city']=$pwxuserinfo['city'];
						 $fansData['country']=$pwxuserinfo['country'];
						 $fansData['headimgurl']=$pwxuserinfo['headimgurl'];
						 $fansData['groupid']=$pwxuserinfo['groupid'];
						 $fansData['is_subscribe']=1;
					}

					if (!empty($ptmpfans) && is_array($ptmpfans)) {
						$fansData['totalfee'] = $fansData['totalfee'] + $ptmpfans['totalfee'];
						$fansDb->update($fansData, array('id' => $ptmpfans['id']));
					} else {
						$fansData['mid'] = $wx_user['p_mid'];
						$fansData['openid'] = $p_openid;
						$fansDb->insert($fansData, True);
					}

				}
            }
           	echo "<xml><return_code><![CDATA[SUCCESS]]></return_code></xml>";
			exit();
        } 	
		    echo "<xml><return_code><![CDATA[SUCCESS]]></return_code></xml>";
			exit();
    }

}

?>