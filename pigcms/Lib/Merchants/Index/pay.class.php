<?php
bpBase::loadAppClass('base', '', 0);
class pay_controller extends base_controller{
	public $is_wexin_browser = false;

	public function __construct()
	{
		parent::__construct();
		$session_storage = getSessionStorageType();
		bpBase::loadSysClass($session_storage);

		if (strpos($_SERVER['HTTP_USER_AGENT'], 'icroMessenger') !== false) {
			$this->is_wexin_browser = true;
		}
	}

	public function alipayPay($data)
	{
		$payConfig = M('cashier_payconfig')->get_one(array('mid' => 1), 'id,isOpen,configData');

		if ($payConfig['configData']) {
			$payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData']));
		}

		if ($payConfig['configData']['alipay']['isOpen'] == 0) {
			$this->errorTip('商家未开启支付宝支付', $_SERVER['HTTP_REFERER']);
			exit();
		}

		if (empty($data['out_trade_no']) || (trim($data['out_trade_no']) == '')) {
			$this->errorTip('您的误操作把订单号都给搞没了', $_SERVER['HTTP_REFERER']);
			exit();
		}

		define('app_id', $payConfig['configData']['alipay']['appid']);
		define('gatewayUrl', 'https://openapi.alipay.com/gateway.do');
		define('charset', 'GBK');
		define('alipay_public_key_file', './pay/alipay/key/alipay_rsa_public_key.pem');
		define('merchant_private_key_file', './pay/alipay/key/rsa_private_key.pem');
		define('merchant_public_key_file', './pay/alipay/key/rsa_public_key.pem');
		define('log_path', './pay/alipay/barpay/logs/' . date('Y-m-d') . '.log');
		$time_expire = date('Y-m-d H:i:s', time() + (60 * 60));
		$biz_content = '{"out_trade_no":"' . $data['out_trade_no'] . '",';
		$biz_content .= '"scene":"bar_code",';
		$biz_content .= '"auth_code":"' . $data['auth_code'] . '",';
		$biz_content .= '"total_amount":"' . $data['total_amount'] . '","discountable_amount":"0.00",';
		$biz_content .= '"subject":"' . $data['subject'] . '","body":"test",';
		$biz_content .= '"goods_detail":[{"goods_id":"apple-01","goods_name":"ipad","goods_category":"7788230","price":"88.00","quantity":"1"},{"goods_id":"apple-02","goods_name":"iphone","goods_category":"7788231","price":"88.00","quantity":"1"}],';
		$biz_content .= '"operator_id":"op001","store_id":"pudong001","terminal_id":"t_001",';
		$biz_content .= '"time_expire":"' . $time_expire . '"}';
		bpBase::loadOrg('AliPay/Alipay.TradePayRequest');
		bpBase::loadOrg('Alipay/Alipay.function');
		$request = new AlipayTradePayRequest();
		$request->setBizContent($biz_content);
		$response = aopclient_request_execute($request);
		print_r($response);
	}

	public function printf_info($data)
	{
		foreach ($data as $key => $value) {
			echo '<font color=\'#00ff55;\'>' . $key . '</font> : ' . $value . ' <br/>';
		}
	}

	public function autopay()
	{
		$mid = intval(trim($_GET['mid']));

		if (!(0 < $mid)) {
			$this->errorTips('参数出错，没有商家ID！');
			exit();
		}

		bpBase::loadOrg('wxCardPack');
		$wx_user = M('cashier_payconfig')->getwxuserConf($mid);
		if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $mid)) {
			$wxCardPack = new wxCardPack($wx_user['submchinfo'], $mid);
		}
		else {
			$wxCardPack = new wxCardPack($wx_user, $mid);
		}

		if ($this->is_wexin_browser && empty($GLOBALS['_SESSION']['openid'])) {
			$redirecturl = $this->SiteUrl . '/' . $_SERVER['REQUEST_URI'];
			$retrunarr = $wxCardPack->authorize_openid($redirecturl);
		}

		$ordid = trim($_GET['oid']);

		if (!empty($ordid)) {
			$orderInfo = M('cashier_order')->getOneOrder(array('id' => $ordid, 'mid' => $mid));
		}
		else {
			$orderInfo = array();
		}

		$wxuserinfo = array();
		if ($this->is_wexin_browser && !empty($GLOBALS['_SESSION']['openid'])) {
			$access_token = $wxCardPack->getToken();
			$wxuserinfo = $wxCardPack->GetwxUserInfoByOpenid($access_token, $GLOBALS['_SESSION']['openid']);
			$this->fanSave($wxuserinfo, $mid);
		}

		include $this->showTpl();
	}

	public function errorTips($msg = '')
	{
		$msg = $msg;
		include $this->showTpl('errorTips');
	}

	public function foreverpay()
	{
		$orderid = trim($_GET['ordid']);
		$ordertmp = array('mid' => 0);

		if (!empty($orderid)) {
			$ordertmp = json_decode(base64_decode($orderid), true);
		}

		bpBase::loadOrg('wxCardPack');
		$wx_user = M('cashier_payconfig')->getwxuserConf($ordertmp['mid']);
		if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $ordertmp['mid'])) {
			$wxCardPack = new wxCardPack($wx_user['submchinfo'], $ordertmp['mid']);
		}
		else {
			$wxCardPack = new wxCardPack($wx_user, $ordertmp['mid']);
		}

		if ($this->is_wexin_browser && empty($GLOBALS['_SESSION']['openid'])) {
			$redirecturl = $this->SiteUrl . '/' . $_SERVER['REQUEST_URI'];
			$retrunarr = $wxCardPack->authorize_openid($redirecturl);
		}

		$wxuserinfo = array();
		if ($this->is_wexin_browser && !empty($GLOBALS['_SESSION']['openid'])) {
			$access_token = $wxCardPack->getToken();
			$wxuserinfo = $wxCardPack->GetwxUserInfoByOpenid($access_token, $GLOBALS['_SESSION']['openid']);
			$this->fanSave($wxuserinfo, $ordertmp['mid']);
		}

		include $this->showTpl();
	}

	public function foreverpaying()
	{
		$_POST['goods_price'] = trim($_POST['goods_price']);
		$_POST['mid'] = intval(trim($_POST['mid']));
		$paytype = trim($_POST['paytype']);
		$paytype = (!empty($paytype) ? $paytype : '');
		$tmpl = 'weixin_pay';
		if (empty($_POST['goods_price']) || !is_numeric($_POST['goods_price'])) {
			$this->errorTips('请填写正确的付款金额！');
			exit();
		}

		if ($_POST['goods_price'] && is_numeric($_POST['goods_price']) && (0 < $_POST['mid'])) {
			switch ($paytype) {
			case 'weixin':
				$wx_user = M('cashier_payconfig')->getwxuserConf($_POST['mid']);
				$pmid = (isset($wx_user['p_mid']) ? $wx_user['p_mid'] : 0);
				$orderinfo = $this->add_order($_POST, $pmid);

				if ($orderinfo) {
					bpBase::loadAppClass('weixinPay', 'Index', 0);
					$weixinPay = new weixinPay();
					$result = $weixinPay->mobilepay($wx_user, $orderinfo);

					if (!$result['error']) {
						$redirctUrl = $this->SiteUrl . '/merchants.php?m=Index&c=pay&a=success_tips&ordid=' . $orderinfo['orderid'];
						$pay_money = $orderinfo['goods_price'];
						$weixin_param = json_decode($result['weixin_param'], true);
						$tmpl = 'weixin_pay';
					}
					else {
						$this->errorTips($result['msg']);
						exit();
					}
				}

				break;

			case 'alipay':
				break;

			default:
				break;
			}

			include $this->showTpl($tmpl);
		}
		else {
			$this->errorTips('付款信息错误！');
			exit();
		}
	}

	public function success_tips()
	{
		$ordid = trim($_GET['ordid']);
		$orderDb = M('cashier_order');
		$orderInfo = $orderDb->get_one(array('id' => $ordid), '*');
		include $this->showTpl();
	}

	private function fanSave($fdata = array(), $mid = 0)
	{
		$fansData = array();
		if (isset($fdata['nickname']) && isset($fdata['headimgurl'])) {
			$fansData['nickname'] = $fdata['nickname'];
			$fansData['sex'] = $fdata['sex'];
			$fansData['province'] = $fdata['province'];
			$fansData['city'] = $fdata['city'];
			$fansData['country'] = $fdata['country'];
			$fansData['headimgurl'] = $fdata['headimgurl'];
			$fansData['groupid'] = $fdata['groupid'];
			$fansData['is_subscribe'] = 1;
		}

		$fansDb = M('cashier_fans');
		$tmpfans = $fansDb->get_one(array('openid' => $GLOBALS['_SESSION']['openid'], 'mid' => $mid), '*');
		if (!empty($tmpfans) && is_array($tmpfans)) {
			$fansDb->update($fansData, array('id' => $tmpfans['id']));
		}
		else {
			$fansData['mid'] = $mid;
			$fansData['openid'] = $GLOBALS['_SESSION']['openid'];
			$fansDb->insert($fansData, true);
		}

		return true;
	}

	public function add_order($datas, $pmid = 0)
	{
		$data['mid'] = $datas['mid'];
		$data['pmid'] = $pmid;
		$data['goods_id'] = 1;
		$data['pay_way'] = trim($datas['paytype']);
		$data['pay_type'] = 'wxJSAPI';
		$data['order_id'] = time() . mt_rand(11111111, 99999999) . date('YmdHis');
		$data['goods_type'] = 'unlimit';
		$data['goods_name'] = htmlspecialchars(trim($datas['goods_name']), ENT_QUOTES);
		$data['goods_describe'] = '收银台生成二维码扫码前台确认支付';
		$data['goods_price'] = $datas['goods_price'];
		$data['openid'] = !empty($GLOBALS['_SESSION']['openid']) ? $GLOBALS['_SESSION']['openid'] : '';
		$data['add_time'] = time();
		$data['truename'] = isset($datas['tname']) ? htmlspecialchars(trim($datas['tname']), ENT_QUOTES) : '';
		$orderid = M('cashier_order')->insert($data, true);

		if ($orderid) {
			$data['orderid'] = $orderid;
			return $data;
		}

		return false;
	}
}

?>
