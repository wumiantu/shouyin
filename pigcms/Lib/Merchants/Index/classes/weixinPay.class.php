<?php

class weixinPay {

    public function __construct() {
        bpBase::loadOrg('WxPay/WxPay.Api');
        bpBase::loadOrg('WxPay/WxPay.Log');
        //$logHandler = new CLogFileHandler("./pay/wxpay/barpay/logs/" . date('Y-m-d') . '.log');
        //$log = Log::Init($logHandler, 15);
    }

    public function micropay($data) {
        bpBase::loadOrg('WxPay/WxPay.MicroPay');
        $input = new WxPayMicroPay();
        $input->SetAuth_code($data["auth_code"]);
        $input->SetBody($data['goods_name']);
        $input->SetTotal_fee($data['goods_price'] * 100);
        $input->SetOut_trade_no($data['order_id']);
        $microPay = new MicroPay();
        return $microPay->pay($input);
    }

    public function mobilepay($wx_user, $datas) {
		$notify_url= SITEURL;
		if(defined('ABS_UPLOAD_PATH')) $notify_url=SITEURL.ABS_UPLOAD_PATH;
		$notify_url=$notify_url.'/pay/wxpay/wxasyn_notice.php?merid=' . $datas['mid'] . '&ordid=' . $datas['orderid'];
        bpBase::loadOrg('WxSaoMaPay/WxPayPubHelper');
        //使用jsapi接口
        $jsApi = new JsApi_pub($wx_user['appid'], $wx_user['mchid'], $wx_user['key'], $wx_user['appSecret']);
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub($wx_user['appid'], $wx_user['mchid'], $wx_user['key'], $wx_user['appSecret']);

		
		if(defined('WxPay_SUBAPPID') && isset($wx_user['submchinfo'])){ $unifiedOrder->setParameter("sub_appid", WxPay_SUBAPPID); } //子公众账号ID
		if(defined('WxPay_SUBMCHID') && isset($wx_user['submchinfo'])){ $unifiedOrder->setParameter("sub_mch_id", WxPay_SUBMCHID); } //子商户号

        //$unifiedOrder->setParameter("openid", $_SESSION['openid']); //用户微信唯一标识
		if(defined('WxPay_SUBAPPID') && isset($wx_user['submchinfo'])){
		    $unifiedOrder->setParameter("sub_openid", $_SESSION['openid']);
		}else{
			$unifiedOrder->setParameter("openid", $_SESSION['openid']);
		}
        $unifiedOrder->setParameter("body", $datas['goods_name']); //商品描述
        //自定义订单号，此处仅作举例
        $unifiedOrder->setParameter("out_trade_no", $datas['order_id']); //商户订单号 
        $unifiedOrder->setParameter("total_fee", floatval($datas['goods_price'] * 100)); //总金额
		
        $unifiedOrder->setParameter("notify_url", $notify_url); //通知地址 
        $unifiedOrder->setParameter("trade_type", "JSAPI"); //交易类型
        $unifiedOrder->setParameter("attach", 'weixin'); //附加数据
        $prepay_result = $unifiedOrder->getPrepayId();
        if ($prepay_result['return_code'] == 'FAIL') {
            return array('error' => 1, 'msg' => '没有获取微信支付的预支付ID，请重新发起支付！微信支付错误返回：' . $prepay_result['return_msg']);
        }
        if ($prepay_result['err_code']) {
            return array('error' => 1, 'msg' => '没有获取微信支付的预支付ID，请重新发起支付！<br/><br/>微信支付错误返回：' . $prepay_result['err_code_des']);
        }
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_result['prepay_id']);

        return array('error' => 0, 'weixin_param' => $jsApi->getParameters());
    }

}

?>