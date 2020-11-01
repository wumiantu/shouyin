<?php

class wxSaoMaPay {

    public function __construct() {
        bpBase::loadOrg('WxPay/WxPay.Api');
        bpBase::loadOrg('WxPay/WxPay.Log');
        //$logHandler= new CLogFileHandler("./pay/wxpay/barpay/logs/".date('Y-m-d').'.log');
        //$log = Log::Init($logHandler, 15);
    }

    /*     * *
     * *$productId为唯一的标示符可以是商品id 或者订单号
     * *
     * */

    public function GetPrePayUrl($productId) {
        $biz = new WxPayBizPayUrl();
        $biz->SetProduct_id($productId);
        $values = WxpayApi::bizpayurl($biz);
        $url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
        return $url;
    }

    /**
     * 
     * 参数数组转换为url参数
     * @param array $urlObj
     */
    private function ToUrlParams($urlObj) {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param UnifiedOrderInput $input
     */
    public function GetPayUrl($input) {
        if ($input->GetTrade_type() == "NATIVE") {
            $result = WxPayApi::unifiedOrder($input);
            return $result;
        }
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

    /**
     * 退款处理
     */
    public function wxRefund($ordid, $wx_user, $mid,$type='') {
        $orderDb = M('cashier_order');
		if($type=='micropay'){
		   $ordertmp = $orderDb->get_one(array('order_id' => $ordid, 'mid' => $mid, 'pay_way' => 'weixin'), '*');
		}else{
           $ordertmp = $orderDb->get_one(array('id' => $ordid, 'mid' => $mid, 'pay_way' => 'weixin'), '*');
		}
        if (!empty($ordertmp)) {
            $orderDb->update(array('refund' => 1), array('id' => $ordertmp['id']));
            $transaction_id = $_REQUEST["transaction_id"];
            $total_fee = $_REQUEST["total_fee"];
            $refund_fee = $_REQUEST["refund_fee"];
            $input = new WxPayRefund();
            if (!empty($ordertmp['transaction_id'])) {
                $input->SetTransaction_id($ordertmp['transaction_id']);
            } else {
                $input->SetOut_trade_no($ordertmp['order_id']);
            }
            $input->SetTotal_fee($ordertmp['goods_price'] * 100);
            $input->SetRefund_fee($ordertmp['goods_price'] * 100);
            $input->SetOut_refund_no($ordertmp['pay_type'] . '_' . $ordertmp['id'] . '_' . $ordertmp['mid'] . '_' . date("YmdHis"));
            $input->SetOp_user_id(WxPay_MCHID);
            $response = WxPayApi::refund($input);
            /* $logpath = './pay/wxpay/barpay/logs/wxRefund.log';
              file_put_contents($logpath,  $response. "\r\n", FILE_APPEND); */
            if (!empty($response)) {
                $response['refund_time'] = time();
                if ($response['return_code'] == 'SUCCESS') {
                    $out_refund_no = explode('_', $response['out_refund_no']);
                    $wx_pay_type = $out_refund_no['0'];
                    $orderid = $out_refund_no['1'];
                    $mid = $out_refund_no['2'];
                    if (empty($ordertmp)) {
                        $ordertmp = $orderDb->get_one(array('id' => $orderid, 'mid' => $mid, 'pay_way' => 'weixin'), '*');
                    }
                    $updatedata = array('refund' => 2, 'refundtext' => serialize($response));
                    if ($response['result_code'] != 'SUCCESS') {
                        $updatedata['refund'] = 3;
                        $orderDb->update($updatedata, array('id' => $ordertmp['id']));
                        return array('error' => 1, 'msg' => "错误码：" . $response['err_code'] . "\n错误描述：" . $response['err_code_des']);
                    } else {
                        $orderDb->update($updatedata, array('id' => $ordertmp['id']));
						$fansDb = M('cashier_fans');
						$tmpfans = $fansDb->get_one(array('openid' => $ordertmp['openid'], 'mid' => $ordertmp['mid']), '*');
						if(!empty($tmpfans)){
						   $refundPrice = $response['refund_fee']+$tmpfans['refund'];
						   $fansDb->update(array('refund'=>$refundPrice), array('id' => $tmpfans['id']));
						}
                        return array('error' => 0, 'msg' => '退款成功！');
                    }
                } else {
                    $orderDb->update(array('refund' => 3, 'refundtext' => serialize($response)), array('id' => $ordertmp['id']));
                    return array('error' => 1, 'msg' => $response['return_msg']);
                }
            }
            $orderDb->update(array('refund' => 3), array('id' => $ordertmp['id']));
            return array('error' => 1, 'msg' => '退款失败！');
        }
        return array('error' => 1, 'msg' => '订单不存在');
    }

}

?>