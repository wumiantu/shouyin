<?php
	class NativeNotifyCBK{
		public $wxinfo;
		public $openid;
		public function __construct(){
			//$this->wxinfo=$wxinfo;
			bpBase::loadOrg('WxPay/WxPay.Api');
			bpBase::loadOrg('WxPay/WxPay.Log');
			bpBase::loadOrg('WxPay/WxPay.Notify');
			//$logHandler= new CLogFileHandler("./barpay/logs/".date('Y-m-d').'.log');
			//$log = Log::Init($logHandler, 15);
			$this->NativeNotifyCallBack();
		}

		function NativeNotifyCallBack(){
		//获取通知的数据
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		/*$xml ="<xml><appid><![CDATA[wx2aa5a19cb84855cc]]></appid>
		<openid><![CDATA[oZrMms12QuDmt_mCJOam85yNF0DI]]></openid>
		<mch_id><![CDATA[1259323701]]></mch_id>
		<is_subscribe><![CDATA[N]]></is_subscribe>
		<nonce_str><![CDATA[FJxH6D34gfIp8qJC]]></nonce_str>
		<product_id><![CDATA[1_59]]></product_id>
		<sign><![CDATA[0ECAE41FAD0526FD2C9AE50EE0EA4404]]></sign>
		</xml>";
		  $logpath = './barpay/logs/xxxxx.log';
          file_put_contents($logpath,  $xml. "\r\n", FILE_APPEND); */
		$msg ='OK';
		$wxpayHandle=new WxPayNotify();
		//如果返回成功则验证签名
		$data = WxPayResults::Init($xml);
		if(!array_key_exists("openid", $data) ||
			!array_key_exists("product_id", $data))
		{
			$msg = "回调数据异常";

			$wxpayHandle->SetReturn_code("FAIL");
			$wxpayHandle->SetReturn_msg($msg);
			$wxpayHandle->ReplyNotify(false);
			return;
			
		}else{
		   $_SEESION['open_id']=$this->openid=$data['openid'];
		   $product_idarr=explode('_',$data['product_id']);
		   $orderDb=M('cashier_order');
		   $this->wxinfo = M('cashier_payconfig')->getwxuserConf($product_idarr['0']);
		   $ordertmp=$orderDb->get_one(array('id'=>$product_idarr['1'],'mid'=>$product_idarr['0']),'*');
			//统一下单
			$neworder_id = time() . mt_rand(11111111, 99999999) . date("YmdHis");
			$orderDb->update(array('order_id' =>$neworder_id,'pay_way'=>'weixin','pay_type'=>'wxsaoma2pay'), array('id'=>$ordertmp['id'],'mid'=>$ordertmp['mid']));

			$notify_url= SITEURL;
			if(defined('ABS_UPLOAD_PATH')) $notify_url=SITEURL.ABS_UPLOAD_PATH;
			$notify_url=$notify_url.'/pay/wxpay/wxasyn_notice.php?merid=' . $ordertmp['mid'] . '&ordid=' . $ordertmp['id'];

			$input = new WxPayUnifiedOrder();
			$input->SetBody($ordertmp['goods_name']);
			$input->SetAttach('weixin');
			$input->SetOut_trade_no($neworder_id);
			$input->SetTotal_fee(floatval($ordertmp['goods_price'] * 100));
			//$input->SetTime_start(date("YmdHis"));
			//$input->SetTime_expire(date("YmdHis", time() + 600));
			//$input->SetGoods_tag("test");
			$input->SetNotify_url($notify_url);
			$input->SetTrade_type("NATIVE");
			$input->SetOpenid($this->openid);
			$input->SetProduct_id($ordertmp['mid'].'_'.$ordertmp['id']);

			$result = WxPayApi::unifiedOrder($input);
			if(!array_key_exists("appid", $result) ||!array_key_exists("mch_id", $result) ||!array_key_exists("prepay_id", $result))
			{
		 		$msg ="统一下单失败了";
				if(isset($result['err_code'])){
				  $msg ="统一下单失败了\n错误代码：".$result['err_code']."\n错误描述：".$result['err_code_des'];
				}
		 		$wxpayHandle->SetReturn_code("FAIL");
				$wxpayHandle->SetReturn_msg($msg);
				$wxpayHandle->ReplyNotify(false);
				return;
			}else{
				$wxpayHandle->SetData("appid", $result["appid"]);
				$wxpayHandle->SetData("mch_id", $result["mch_id"]);
				$wxpayHandle->SetData("nonce_str", WxPayApi::getNonceStr());
				$wxpayHandle->SetData("prepay_id", $result["prepay_id"]);
				$wxpayHandle->SetData("result_code", "SUCCESS");
				$wxpayHandle->SetData("err_code_des", "OK");
			   	$wxpayHandle->SetReturn_code("SUCCESS");
				$wxpayHandle->SetReturn_msg('OK');
				$wxpayHandle->ReplyNotify(true); 
			}
		}
		}
        
	}
?>