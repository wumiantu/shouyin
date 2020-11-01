<?php
bpBase::loadAppClass('common', 'User', 0);
class cashier_controller extends common_controller{
	public $wx_user;
	public $tablepre;

	public function __construct(){
		parent::__construct();
		$this->authorityControl(array('getajaxOrder', 'getEwm', 'add_order', 'qrcode', 'weixinPay', 'sm_order', 'getSgin', 'pay'));
		$this->wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
		$db_config = loadConfig('db');
		$this->tablepre = $db_config['default']['tablepre'];
		unset($db_config);
	}

	public function index(){
		$SiteUrl = $this->SiteUrl;
		$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . ' AND cf.mid=' . $this->mid . ' AND ordr.ispay="1" ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT 0,20';
		$sqlObj = new model();
		$neworder = $sqlObj->selectBySql($sqlStr);
		include $this->showTpl();
	}

	public function odetail(){
		$orid = intval(trim($_GET['orid']));
		$orid = (0 < $orid ? $orid : 0);
		$orderInfo = M('cashier_order')->getOneOrder(array('id' => $orid, 'mid' => $this->mid));

		if (!empty($orderInfo['refundtext'])) {
			$orderInfo['refundtext'] = unserialize($orderInfo['refundtext']);
		}

		ob_start();
		ob_implicit_flush(0);
		include $this->showTpl();
		$content = ob_get_clean();
		echo $content;
	}

	public function getajaxOrder(){
		$cf = trim($_GET['cf']);

		switch ($cf) {
		case 'index':
			$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid . '  AND cf.mid=' . $this->mid . '  AND ordr.ispay="1" ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT 0,20';
			$sqlObj = new model();
			$neworder = $sqlObj->selectBySql($sqlStr);

			if (!empty($neworder)) {
				$tmpdata = array();

				foreach ($neworder as $okk => $ovv) {
					$tmpdata[$okk]['id'] = $ovv['id'];
					$tmpdata[$okk]['mid'] = $ovv['mid'];

					if (!empty($ovv['nickname'])) {
						$tmpdata[$okk]['truename'] = $ovv['nickname'];
					}else if (!empty($ovv['truename'])) {
						$tmpdata[$okk]['truename'] = htmlspecialchars_decode($ovv['truename'], ENT_QUOTES);
					}else if (!empty($ovv['openid'])) {
						$tmpdata[$okk]['truename'] = $ovv['openid'];
					}else {
						$tmpdata[$okk]['truename'] = '未知客户';
					}

					$paytime = (0 < $ovv['paytime'] ? $ovv['paytime'] : $ovv['add_time']);
					$tmpdata[$okk]['paytimestr'] = date('Y-m-d H:i:s', $paytime);
					$tmpdata[$okk]['goods_name'] = htmlspecialchars_decode($ovv['goods_name'], ENT_QUOTES);
					$tmpdata[$okk]['goods_price'] = $ovv['goods_price'];

					if ($ovv['refund'] == 1) {
						$tmpdata[$okk]['refundstr'] = '退款中...';
					}else if ($ovv['refund'] == 2) {
						$tmpdata[$okk]['refundstr'] = '已退款';
					}else if ($ovv['refund'] == 3) {
						$tmpdata[$okk]['refundstr'] = '退款失败';
					}else {
						$tmpdata[$okk]['refundstr'] = '已支付';
					}

					$tmpdata[$okk]['refund'] = $ovv['refund'];
					$tmpdata[$okk]['comefrom'] = $ovv['comefrom'];
				}

				$this->dexit(array('error' => 0, 'datas' => $tmpdata));
			}else {
				$this->dexit(array('error' => 1));
			}

			break;

		default:
			break;
		}

		$this->dexit(array('error' => 1));
	}

	public function payRecord(){
		bpBase::loadOrg('common_page');
		$orderDb = M('cashier_order');
		$where = array('ispay' => 1, 'mid' => $this->mid);
		$_count = $orderDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid . ' AND ordr.ispay="1" ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		$sqlObj = new model();
		$neworder = $sqlObj->selectBySql($sqlStr);
		include $this->showTpl();
	}

	public function ewmRecord(){
		bpBase::loadOrg('common_page');
		$orderDb = M('cashier_order');
		$where = array('mid' => $this->mid);
		$_count = $orderDb->count($where);
		$p = new Page($_count, 15);
		$pagebar = $p->show(2);
		$neworder = $orderDb->getOrders($p->firstRow . ',' . $p->listRows, 'id DESC', $where);
		bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
		$wxSaoMaPay = new wxSaoMaPay();

		foreach ($neworder as $kk => $vv) {
			if ($vv['ispay'] == 1) {
				$neworder[$kk]['ewmurl'] = $this->SiteUrl . '/merchants.php?m=Index&c=pay&a=autopay&mid=' . $vv['mid'] . '&oid=' . $vv['id'];
			}else {
				$product_id = $vv['mid'] . '_' . $vv['id'];
				$neworder[$kk]['ewmurl'] = $wxSaoMaPay->GetPrePayUrl($product_id);
			}
		}

		include $this->showTpl();
	}

	public function delOrderByid(){
		$ordid = intval($_POST['ordid']);
		$mid = intval($_POST['mid']);
		$return = $this->_del(M('cashier_order'), $ordid, 'mid=' . $this->mid);
		$this->dexit($return);
	}

	public function wxRefund(){
		$ordid = intval($_POST['ordid']);
		$mid = intval($_POST['mid']);
		bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
		$wxSaoMaPay = new wxSaoMaPay();
		$ret = $wxSaoMaPay->wxRefund($ordid, $this->wx_user, $this->mid);
		$this->dexit($ret);
	}

	public function getEwm(){
		$datas = $this->clear_html($_POST);
		$paytype = (isset($datas['paytype']) ? $datas['paytype'] : '');

		switch ($paytype) {
		case 'wxpay':
			$orderinfo = $this->add_order($datas);

			if ($orderinfo) {
				bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
				$wxSaoMaPay = new wxSaoMaPay();
				$product_id = $orderinfo['mid'] . '_' . $orderinfo['orderid'];
				$ewmurl2 = $wxSaoMaPay->GetPrePayUrl($product_id);
				$erweimainfo = array('price' => $orderinfo['goods_price'], 'title' => $orderinfo['goods_name'], 'mid' => $orderinfo['mid']);
				$this->dexit(array('error' => 0, 'qrcode' => $ewmurl2, 'ewminfo' => base64_encode(json_encode($erweimainfo))));
			}else {
				$this->dexit(array('error' => 0, 'msg' => '二维码生成失败'));
			}

			break;

		case 'alipay':
			break;

		default:
			break;
		}
	}

	public function add_order($datas){
		$data['mid'] = $this->mid;
		isset($this->wx_user['p_mid']) && $data['pmid'] = $this->wx_user['p_mid'];
		$data['goods_id'] = 1;
		$data['pay_way'] = 'weixin';
		$data['pay_type'] = 'wxsaoma2pay';
		$data['order_id'] = time() . mt_rand(11111111, 99999999) . date('YmdHis');
		$data['goods_type'] = 'unlimit';
		$data['goods_name'] = $datas['tname'];
		$data['goods_describe'] = '收银台生成二维码扫码支付';
		$data['goods_price'] = $datas['tprice'];
		$data['add_time'] = time();
		$orderid = M('cashier_order')->insert($data, true);

		if ($orderid) {
			$data['orderid'] = $orderid;
			return $data;
		}

		return false;
	}

	public function web_sm1pay($datas){
		bpBase::loadOrg('WxSaoMaPay/WxPayPubHelper');
		$jsApi = new JsApi_pub($this->wx_user['appid'], $this->wx_user['mchid'], $this->wx_user['key'], $this->wx_user['appsecret']);
		$unifiedOrder = new UnifiedOrder_pub($this->wx_user['appid'], $this->wx_user['mchid'], $this->wx_user['key'], $this->wx_user['appsecret']);
		$unifiedOrder->setParameter('body', $datas['tname']);
		$unifiedOrder->setParameter('out_trade_no', 'wxpay_' . time());
		$unifiedOrder->setParameter('total_fee', floatval($datas['tprice'] * 100));
		$unifiedOrder->setParameter('notify_url', SITEURL . '/pay/wxpay/wxasyn_notice.php');
		$unifiedOrder->setParameter('trade_type', 'NATIVE');
		$unifiedOrder->setParameter('attach', 'weixin');
		$prepay_result = $unifiedOrder->getPrepayId();

		if ($prepay_result['return_code'] == 'FAIL') {
			$this->dexit(array('error' => 1, 'msg' => "没有获取微信支付的预支付ID，请重新发起支付！\n 微信支付错误返回：" . $prepay_result['return_msg']));
		}

		if ($prepay_result['err_code']) {
			$this->dexit(array('error' => 1, 'msg' => "没有获取微信支付的预支付ID，请重新发起支付！\n 微信支付错误返回：" . $prepay_result['err_code_des']));
		}

		$jsApi->setPrepayId($prepay_result['prepay_id']);
		$this->dexit(array('error' => 0, 'qrcode' => $prepay_result['code_url']));
	}

	public function qrcode(){
		bpBase::loadOrg('phpqrcode');
		$type = trim($_GET['typ']);
		$isdwd = (isset($_GET['dwd']) ? intval(trim($_GET['dwd'])) : 0);
		$url = urldecode($this->SiteUrl . '/merchants.php?m=Index&c=pay&a=autopay&mid=' . $this->mid);

		if (0 < $isdwd) {
			new QRimage(400, 400);
			$fname = 'Your-autopay-code-image-' . $this->mid . '.png';
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Type:application/force-download');
			header('Content-type: image/png');
			header('Content-Type:application/download');
			header('Content-Disposition: attachment; filename=' . $fname);
			header('Content-Transfer-Encoding: binary');
			QRcode::png($url, false, 'H', 10, 4);
		}else {
			Header('Content-type: image/jpeg');
			QRcode::png($url);
		}
	}

	public function payment(){
		bpBase::loadOrg('wxCardPack');
		$wxCardPack = new wxCardPack($this->wx_user, $this->mid);
		$access_token = $wxCardPack->getToken();
		$signdata = $wxCardPack->getSgin($access_token);
		$type = (isset($_GET['type']) ? intval($_GET['type']) : 1);
		$type = ($type == 2 ? $type : 1);
		include $this->showTpl();
	}

	public function wxSmRefund(){
		$orderid = $this->clear_html($_POST['auth_code']);
		bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
		$wxSaoMaPay = new wxSaoMaPay();
		$ret = $wxSaoMaPay->wxRefund($orderid, $this->wx_user, $this->mid, 'micropay');
		$this->dexit($ret);
	}

	public function sm_order($datas){
		$data['mid'] = $this->mid;
		isset($this->wx_user['p_mid']) && $data['pmid'] = $this->wx_user['p_mid'];
		$data['goods_id'] = 1;
		$data['pay_way'] = 'weixin';
		$data['pay_type'] = 'micropay';
		$data['order_id'] = time() . mt_rand(11111111, 99999999) . date('YmdHis');
		$data['goods_type'] = 'ordinary';
		$data['goods_name'] = htmlspecialchars($datas['goods_name'], ENT_QUOTES);
		$data['goods_describe'] = '前端刷卡支付';
		$data['goods_price'] = trim($datas['goods_price']);
		$data['add_time'] = time();
		$insertid = M('cashier_order')->insert($data, true);

		if (0 < $insertid) {
			$data['id'] = $insertid;
			return array_merge($datas, $data);
		}

		$this->dexit(array('error' => 1, 'msg' => '订单生成失败'));
	}

	public function pay(){
		if (IS_POST) {
			$data = $this->clear_html($_POST);
			empty($data['goods_price']) && $this->dexit(array('error' => 1, 'msg' => '支付金额必须填写！'));
			empty($data['auth_code']) && $this->dexit(array('error' => 1, 'msg' => '支付auth_code为空'));
			$this->weixinPay($data);
			$this->dexit(array('error' => 0, 'msg' => '支付成功！'));
		}
	}

	public function weixinPay($data){
		if (IS_POST) {
			if ($this->wx_user['isOpen'] == 0) {
				$this->dexit(array('error' => 1, 'msg' => '商家未开启微信支付'));
			}

			$data = $this->sm_order($data);
			bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
			$wxSaoMaPay = new wxSaoMaPay();
			$response = $wxSaoMaPay->micropay($data);

			if (!empty($response)) {
				if ($response['return_code'] == 'SUCCESS') {
					if ($response['result_code'] == 'SUCCESS') {
						$order_id = trim($response['out_trade_no']);
						$appid = trim($response['appid']);
						$sub_appid = (isset($response['sub_appid']) ? $response['sub_appid'] : '');
						$sub_mch_id = (isset($response['sub_mch_id']) ? $response['sub_mch_id'] : '');
						$total_fee = trim($response['total_fee']);
						$openid = trim($response['openid']);
						$sub_openid = (isset($response['sub_openid']) ? $response['sub_openid'] : '');
						$transaction_id = trim($response['transaction_id']);
						$trade_type = trim($response['trade_type']);
						$is_subscribe = (strtoupper(trim($response['is_subscribe'])) == 'Y' ? 1 : 0);
						$orderDb = M('cashier_order');
						$wherearr = array('order_id' => $order_id, 'pay_way' => 'weixin');
						if (!empty($data) && isset($data['id'])) {
							$wherearr['id'] = $data['id'];
						}

						$tmpopenid = (!empty($sub_mch_id) ? $sub_openid : $openid);
						$p_openid = (!empty($sub_mch_id) ? $openid : '');
						$tmpappid = (!empty($sub_mch_id) ? $sub_appid : $appid);
						$data = $orderDb->get_one($wherearr, '*');
						$wxuserinfo = array();
						bpBase::loadOrg('wxCardPack');
						if (!empty($sub_mch_id) && isset($this->wx_user['submchinfo']) && ($this->mid == $this->wx_user['submchinfo']['mid'])) {
							$wxCardPack = new wxCardPack($this->wx_user['submchinfo'], $this->mid);
						}else {
							$wxCardPack = new wxCardPack($this->wx_user, $this->mid);
						}

						$access_token = $wxCardPack->getToken();
						$wxuserinfo = $wxCardPack->GetwxUserInfoByOpenid($access_token, $tmpopenid);

						if (!(0 < $data['ispay'])) {
							$updatedata = array('openid' => $tmpopenid, 'transaction_id' => $transaction_id, 'state' => 1, 'ispay' => 1, 'p_openid' => $p_openid, 'paytime' => time());
							isset($wxuserinfo['nickname']) && $updatedata['truename'] = $wxuserinfo['nickname'];
							$orderDb->update($updatedata, array('id' => $data['id']));
							$fansDb = M('cashier_fans');

							if (!empty($tmpopenid)) {
								$tmpfans = $fansDb->get_one(array('openid' => $tmpopenid, 'mid' => $this->mid), '*');
								$fansData = array('appid' => $tmpappid, 'totalfee' => $total_fee, 'is_subscribe' => 0);

								if (isset($wxuserinfo['nickname'])) {
									$fansData['nickname'] = $wxuserinfo['nickname'];
									$fansData['sex'] = $wxuserinfo['sex'];
									$fansData['province'] = $wxuserinfo['province'];
									$fansData['city'] = $wxuserinfo['city'];
									$fansData['country'] = $wxuserinfo['country'];
									$fansData['headimgurl'] = $wxuserinfo['headimgurl'];
									$fansData['groupid'] = $wxuserinfo['groupid'];
									$fansData['is_subscribe'] = 1;
								}

								if (!empty($tmpfans) && is_array($tmpfans)) {
									$fansData['totalfee'] = $fansData['totalfee'] + $tmpfans['totalfee'];
									$fansDb->update($fansData, array('id' => $tmpfans['id']));
								}else {
									$fansData['mid'] = $this->mid;
									$fansData['openid'] = $tmpopenid;
									$fansDb->insert($fansData, true);
								}

								unset($fansData);
							}

							if (!empty($p_openid) && isset($this->wx_user['p_mid']) && isset($this->wx_user['submchinfo'])) {
								$pwxCardPack = new wxCardPack($this->wx_user, $this->wx_user['p_mid']);
								$paccess_token = $pwxCardPack->getToken();
								$pwxuserinfo = $pwxCardPack->GetwxUserInfoByOpenid($paccess_token, $p_openid);
								$ptmpfans = $fansDb->get_one(array('openid' => $p_openid, 'mid' => $this->wx_user['p_mid']), '*');
								$fansData = array('appid' => $this->wx_user['appid'], 'totalfee' => $total_fee, 'is_subscribe' => 0);

								if (isset($pwxuserinfo['nickname'])) {
									$fansData['nickname'] = $pwxuserinfo['nickname'];
									$fansData['sex'] = $pwxuserinfo['sex'];
									$fansData['province'] = $pwxuserinfo['province'];
									$fansData['city'] = $pwxuserinfo['city'];
									$fansData['country'] = $pwxuserinfo['country'];
									$fansData['headimgurl'] = $pwxuserinfo['headimgurl'];
									$fansData['groupid'] = $pwxuserinfo['groupid'];
									$fansData['is_subscribe'] = 1;
								}

								if (!empty($ptmpfans) && is_array($ptmpfans)) {
									$fansData['totalfee'] = $fansData['totalfee'] + $ptmpfans['totalfee'];
									$fansDb->update($fansData, array('id' => $ptmpfans['id']));
								}else {
									$fansData['mid'] = $this->wx_user['p_mid'];
									$fansData['openid'] = $p_openid;
									$fansDb->insert($fansData, true);
								}
							}
						}

						$this->dexit(array('error' => 0, 'msg' => 'OK'));
					}

					$this->dexit(array('error' => 1, 'msg' => '错误码：' . $response['err_code'] . '<br/>错误描述：' . $response['err_code_des']));
				}

				$this->dexit(array('error' => 1, 'msg' => '错误描述：' . $response['return_msg']));
			}
		}
	}
}

?>
