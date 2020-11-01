<?php
bpBase::loadAppClass('common', 'User', 0);
class wxCoupon_controller extends common_controller
{
	private $wxCardPack;
	private $access_token;
	private $card_type;

	public function __construct()
	{
		parent::__construct();
		$this->authorityControl(array('cardetail', 'wxCardQrCodeTicket', 'qrcode', 'uploadImg', 'ArrayToJsonstr', 'FiltrationData', 'updateMname'));
		bpBase::loadOrg('wxCardPack');
		$wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
		$this->wxCardPack = new wxCardPack($wx_user, $this->mid);
		$this->access_token = $this->wxCardPack->getToken();
		$this->card_type = array(
	array('enname' => 'GENERAL_COUPON', 'zhname' => '优惠券'),
	array('enname' => 'GROUPON', 'zhname' => '团购券'),
	array('enname' => 'DISCOUNT', 'zhname' => '折扣券'),
	array('enname' => 'GIFT', 'zhname' => '礼品券'),
	array('enname' => 'CASH', 'zhname' => '代金券'),
	array('enname' => 'MEMBER_CARD', 'zhname' => '会员卡')
	);
	}

	public function index()
	{
		bpBase::loadOrg('common_page');
		$wxcouponDb = M('cashier_wxcoupon');
		$where = ' mid=' . $this->mid . ' AND isdel=0 AND card_type<5';
		$_count = $wxcouponDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$wxcoupons = $wxcouponDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');

		foreach ($wxcoupons as $kk => $vv) {
			unset($wxcoupons[$kk]['kqcontent']);
			unset($wxcoupons[$kk]['kqexpand']);

			if ($vv['status'] == 0) {
				$wxcoupons[$kk]['statusstr'] = '<font>审核中</font>';
			}
			else if ($vv['status'] == 1) {
				$wxcoupons[$kk]['statusstr'] = '<font color=\'green\'>已审核</font>';
			}
			else if ($vv['status'] == 2) {
				$wxcoupons[$kk]['statusstr'] = '<font color=\'red\'>未通过</font>';
			}
			else {
				$wxcoupons[$kk]['statusstr'] = '待定';
			}
		}

		include $this->showTpl();
	}

	public function wxReceiveList()
	{
		bpBase::loadOrg('common_page');
		$wxcouponReceiveDb = M('cashier_wxcoupon_receive');
		$_count = $wxcouponReceiveDb->count('outerid=' . $this->mid . ' AND cardtype<5');
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$db_config = loadConfig('db');
		$tablepre = $db_config['default']['tablepre'];
		$sqlStr = 'SELECT DISTINCT wxr.id,wxr.*,cf.nickname FROM ' . $tablepre . 'cashier_wxcoupon_receive as wxr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON wxr.openid=cf.openid where wxr.outerid=' . $this->mid . ' AND wxr.cardtype < 5 ORDER BY id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		$sqlObj = new model();
		$wxReceiveUser = $sqlObj->selectBySql($sqlStr);
		include $this->showTpl();
	}

	public function createKq()
	{
		$datestart = date('Y-m-d');
		$dateend = date('Y-m-d', strtotime('+1 month'));
		$typeid = intval($_GET['typeid']);
		$wxcouponSet = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');
		$shoplist = unserialize($GLOBALS['_SESSION']['wxshoplist']);
		if (!is_array($shoplist) || empty($shoplist)) {
			$wxShoplist = $this->wxCardPack->wxGetPoiList($this->access_token);
			$shoplist = array();
			if (isset($wxShoplist['business_list']) && !empty($wxShoplist['business_list'])) {
				foreach ($wxShoplist['business_list'] as $kk => $vv) {
					$shoplist[$vv['base_info']['poi_id']] = array('sid' => $vv['base_info']['sid'], 'business_name' => $vv['base_info']['business_name'], 'branch_name' => $vv['base_info']['branch_name'], 'poi_id' => $vv['base_info']['poi_id'], 'address' => $vv['base_info']['address']);
				}
			}

			if (!empty($wxShoplist)) {
				$GLOBALS['_SESSION']['wxshoplist'] = serialize($shoplist);
			}
		}

		$wxCardColor = $this->wxCardPack->wxCardColor($this->access_token);
		include $this->showTpl();
	}

	public function docreateKq()
	{
		$localArr = array();
		$card_type = array('GENERAL_COUPON', 'GROUPON', 'DISCOUNT', 'GIFT', 'CASH', 'MEMBER_CARD');
		$datas = $this->clear_html($_POST);
		$type = intval($_POST['ctype']);
		$card_typestr = $card_type[$type];
		$keycard_type = strtolower($card_typestr);
		$wxJsonstr['card'] = array(
	'card_type'   => $card_typestr,
	$keycard_type => array()
	);
		$base_info = $datas['base_info'];
		unset($datas['base_info']);
		$base_info['code_type'] = 'CODE_TYPE_QRCODE';
		$base_info['get_limit'] = intval($base_info['get_limit']);
		!(0 < $base_info['get_limit']) && $base_info['get_limit'] = 50;
		$begin_timestamp = (empty($datas['datestart']) ? strtotime(date('Y-m-d')) : strtotime($datas['datestart']));
		$end_timestamp = (empty($datas['dateend']) ? strtotime(date('Y-m-d')) + (30 * 24 * 3600) : strtotime($datas['dateend']));
		$base_info['date_info'] = array('type' => 'DATE_TYPE_FIX_TIME_RANGE', 'begin_timestamp' => $begin_timestamp, 'end_timestamp' => $end_timestamp);
		$localArr = array('mid' => $this->mid, 'card_type' => $type, 'card_title' => $base_info['title'], 'begin_timestamp' => $begin_timestamp, 'end_timestamp' => $end_timestamp);
		$base_info['sku'] = array('quantity' => intval($datas['quantity']));
		$base_info['use_custom_code'] = false;
		$base_info['bind_openid'] = false;
		$base_info['can_share'] = false;
		$base_info['can_give_friend'] = true;
		$base_info['location_id_list'] = !empty($datas['inputpoiid']) ? 'Jsarray[' . implode(',', $datas['inputpoiid']) . ']' : 'Jsarray[0]';
		$base_info['source'] = '小猪科技';
		$this->FiltrationData($base_info);
		if (!empty($base_info['custom_url']) && (strpos($base_info['custom_url'], 'http:') === false) && (strpos($base_info['custom_url'], 'https:') === false)) {
			$base_info['custom_url'] = 'http://' . $base_info['custom_url'];
		}

		if (!empty($base_info['promotion_url']) && (strpos($base_info['promotion_url'], 'http:') === false) && (strpos($base_info['promotion_url'], 'https:') === false)) {
			$base_info['promotion_url'] = 'http://' . $base_info['promotion_url'];
		}

		$postwxJsonstr = '';

		switch ($type) {
		case '0':
			if (empty($datas['default_detail'])) {
				$this->dexit(array('error' => 1, 'msg' => '优惠详情须填写'));
			}

			$localArr['quantity'] = $base_info['sku']['quantity'];
			$localArr['get_limit'] = $base_info['get_limit'];
			$localArr['kqcontent'] = serialize($base_info);
			$localArr['kqexpand'] = serialize(array('content' => $datas['default_detail']));
			$wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
			$wxJsonstr['card'][$keycard_type]['default_detail'] = $datas['default_detail'];
			$postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
			break;

		case '1':
			if (empty($datas['deal_detail'])) {
				$this->dexit(array('error' => 1, 'msg' => '优惠详情须填写'));
			}

			$localArr['quantity'] = $base_info['sku']['quantity'];
			$localArr['get_limit'] = $base_info['get_limit'];
			$localArr['kqcontent'] = serialize($base_info);
			$localArr['kqexpand'] = serialize(array('content' => $datas['deal_detail']));
			$wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
			$wxJsonstr['card'][$keycard_type]['deal_detail'] = $datas['deal_detail'];
			$postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
			break;

		case '2':
			if (empty($datas['discount']) || ($datas['discount'] < 1) || (10 <= $datas['discount'])) {
				$this->dexit(array('error' => 1, 'msg' => '折扣额度只能是大于1且小于10的数字'));
			}

			$localArr['quantity'] = $base_info['sku']['quantity'];
			$localArr['get_limit'] = $base_info['get_limit'];
			$localArr['kqcontent'] = serialize($base_info);
			$localArr['kqexpand'] = serialize(array('discount' => $datas['discount']));
			$wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
			$wxJsonstr['card'][$keycard_type]['discount'] = 100 - ($datas['discount'] * 10);
			$postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
			break;
		}

		switch ($type) {
		case '3':
			if (empty($datas['gift'])) {
				$this->dexit(array('error' => 1, 'msg' => '优惠详情须填写'));
			}

			$localArr['quantity'] = $base_info['sku']['quantity'];
			$localArr['get_limit'] = $base_info['get_limit'];
			$localArr['kqcontent'] = serialize($base_info);
			$localArr['kqexpand'] = serialize(array('content' => $datas['gift']));
			$wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
			$wxJsonstr['card'][$keycard_type]['gift'] = $datas['gift'];
			$postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
			break;

		case '4':
			if (empty($datas['reduce_cost']) || !(0.01 < $datas['reduce_cost'])) {
				$this->dexit(array('error' => 1, 'msg' => '减免金额必须填写一个大于0.01的数字'));
			}

			$wxJsonstr['card'][$keycard_type]['reduce_cost'] = intval($datas['reduce_cost'] * 100);
			if (empty($datas['least_cost']) || !(0.01 < $datas['least_cost'])) {
				$wxJsonstr['card'][$keycard_type]['least_cost'] = 0;
				$datas['least_cost'] = 0;
			}
			else {
				$wxJsonstr['card'][$keycard_type]['least_cost'] = intval($datas['least_cost'] * 100);
			}

			$localArr['quantity'] = $base_info['sku']['quantity'];
			$localArr['get_limit'] = $base_info['get_limit'];
			$localArr['kqcontent'] = serialize($base_info);
			$localArr['kqexpand'] = serialize(array('reduce_cost' => $datas['reduce_cost'], 'least_cost' => $datas['least_cost']));
			$wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
			$postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
			break;
		}

		switch ($type) {
		case '5':
			if (empty($datas['prerogative'])) {
				$this->dexit(array('error' => 1, 'msg' => '特权说明须填写'));
			}

			$discount = intval($datas['discount']);
			if (($discount < 0) || (100 < $discount)) {
				$this->dexit(array('error' => 1, 'msg' => '折扣应该在0~100之间的整数'));
			}

			$discount && $wxJsonstr['card'][$keycard_type]['discount'] = $discount;

			if ($datas['date_type'] == 'DATE_TYPE_PERMANENT') {
				$base_info['date_info'] = array('type' => 'DATE_TYPE_PERMANENT');
				$localArr['begin_timestamp'] = $localArr['end_timestamp'] = 0;
			}

			$wxJsonstr['card'][$keycard_type]['prerogative'] = $datas['prerogative'];
			$localArr['activate'] = $datas['activate'];

			if ($datas['activate'] == 0) {
				$wxJsonstr['card'][$keycard_type]['auto_activate'] = true;
			}
			else if ($datas['activate'] == 1) {
				$wxJsonstr['card'][$keycard_type]['wx_activate'] = true;
			}
			else {
				$wxJsonstr['card'][$keycard_type]['auto_activate'] = true;
			}

			$wxJsonstr['card'][$keycard_type]['supply_balance'] = false;

			if ($datas['supply_balance']) {
				if (!empty($datas['balance_url']) && (strpos($datas['balance_url'], 'http:') === false) && (strpos($datas['balance_url'], 'https:') === false)) {
					$datas['balance_url'] = 'http://' . $datas['balance_url'];
				}

				$wxJsonstr['card'][$keycard_type]['supply_balance'] = true;
				$wxJsonstr['card'][$keycard_type]['balance_url'] = $datas['balance_url'];
				$wxJsonstr['card'][$keycard_type]['balance_rules'] = $datas['balance_rules'];
			}

			$wxJsonstr['card'][$keycard_type]['supply_bonus'] = false;

			if ($datas['supply_bonus']) {
				if (!empty($datas['bonus_url']) && (strpos($datas['bonus_url'], 'http:') === false) && (strpos($datas['bonus_url'], 'https:') === false)) {
					$datas['bonus_url'] = 'http://' . $datas['bonus_url'];
				}

				$wxJsonstr['card'][$keycard_type]['supply_bonus'] = true;
				$wxJsonstr['card'][$keycard_type]['bonus_url'] = $datas['bonus_url'];
				$wxJsonstr['card'][$keycard_type]['bonus_rules'] = $datas['bonus_rules'];
				$wxJsonstr['card'][$keycard_type]['bonus_cleared'] = $datas['bonus_cleared'];
				if (empty($datas['bonus_rule']['cost_money_unit']) || ($datas['bonus_rule']['cost_money_unit'] < 1)) {
					$this->dexit(array('error' => 1, 'msg' => '消费金额必须大于等于1的整数'));
				}

				if (empty($datas['bonus_rule']['increase_bonus']) || ($datas['bonus_rule']['increase_bonus'] < 1)) {
					$this->dexit(array('error' => 1, 'msg' => '增加的积分必须大于等于1的整数'));
				}

				if (empty($datas['bonus_rule']['max_increase_bonus']) || ($datas['bonus_rule']['max_increase_bonus'] < 1)) {
					$this->dexit(array('error' => 1, 'msg' => '积分上限必须大于等于1的整数'));
				}

				if (empty($datas['bonus_rule']['init_increase_bonus']) || ($datas['bonus_rule']['init_increase_bonus'] < 0)) {
					$this->dexit(array('error' => 1, 'msg' => '初始积分必须大于等于0的整数'));
				}

				$wxJsonstr['card'][$keycard_type]['bonus_rule'] = array('cost_money_unit' => intval($datas['bonus_rule']['cost_money_unit']), 'increase_bonus' => intval($datas['bonus_rule']['increase_bonus']), 'max_increase_bonus' => intval($datas['bonus_rule']['max_increase_bonus']), 'init_increase_bonus' => intval($datas['bonus_rule']['init_increase_bonus']));
			}

			if (!empty($datas['custom_cell1']['url']) && (strpos($datas['custom_cell1']['url'], 'http:') === false) && (strpos($datas['custom_cell1']['url'], 'https:') === false)) {
				$datas['custom_cell1']['url'] = 'http://' . $datas['custom_cell1']['url'];
			}

			$wxJsonstr['card'][$keycard_type]['custom_cell1'] = $datas['custom_cell1'];
			$localArr['quantity'] = $base_info['sku']['quantity'];
			$localArr['get_limit'] = $base_info['get_limit'];
			$localArr['kqcontent'] = serialize($base_info);
			$localArr['kqexpand'] = serialize($wxJsonstr['card'][$keycard_type]);
			$wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
			$postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
			break;

		default:
			break;
		}

		$rets = $this->wxCardPack->wxCardCreated($this->access_token, $postwxJsonstr);
		if (isset($rets['card_id']) && !empty($rets['card_id'])) {
			$localArr['card_id'] = trim($rets['card_id']);
			$localArr['addtime'] = time();
			$wxcoupon_id = M('cashier_wxcoupon')->insert($localArr, true);
			$this->updateMname($base_info['brand_name'], $base_info['logo_url']);
			$this->dexit(array('error' => 0, 'msg' => 'OK'));
		}
		else {
			$tmpmsg = (isset($rets['errcode']) ? $rets['errcode'] : '');
			isset($rets['errmsg']) && ($tmpmsg = $tmpmsg . '：' . $rets['errmsg']);

			if (!empty($tmpmsg)) {
				$this->dexit(array('error' => 1, 'msg' => $tmpmsg));
			}
		}

		$this->dexit(array('error' => 1, 'msg' => '数据保存失败！'));
	}

	public function cardetail()
	{
		$id = intval(trim($_GET['id']));
		$cardinfo = M('cashier_wxcoupon')->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (empty($cardinfo)) {
			$this->errorTip('您所查看的卡券不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}

		$kqcontent = unserialize($cardinfo['kqcontent']);
		unset($cardinfo['kqcontent']);
		!empty($cardinfo['kqexpand']) && $cardinfo['kqexpand'] = unserialize($cardinfo['kqexpand']);
		$mset = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');
		$kqcontent['location_id_list'] = str_replace('Jsarray[', '', str_replace(']', '', $kqcontent['location_id_list']));
		if (empty($kqcontent['location_id_list']) || ($kqcontent['location_id_list'] == '0')) {
			$kqcontent['shop_id_count'] = 0;
		}
		else {
			$kqcontent['location_id_list'] = explode(',', $kqcontent['location_id_list']);
			$kqcontent['shop_id_count'] = count($kqcontent['location_id_list']);
		}

		$wxCardColor = $this->wxCardPack->wxCardColor($this->access_token);

		foreach ($wxCardColor as $cvv) {
			if ($kqcontent['color'] == $cvv['name']) {
				$kqcontent['colorV'] = $cvv['value'];
				break;
			}
		}

		if (!is_array($shoplist) || empty($shoplist)) {
			$wxShoplist = $this->wxCardPack->wxGetPoiList($this->access_token);
			$shoplist = array();
			if (isset($wxShoplist['business_list']) && !empty($wxShoplist['business_list'])) {
				foreach ($wxShoplist['business_list'] as $kk => $vv) {
					$shoplist[$vv['base_info']['poi_id']] = array('sid' => $vv['base_info']['sid'], 'business_name' => $vv['base_info']['business_name'], 'branch_name' => $vv['base_info']['branch_name'], 'poi_id' => $vv['base_info']['poi_id'], 'address' => $vv['base_info']['address']);
				}
			}

			if (!empty($wxShoplist)) {
				$GLOBALS['_SESSION']['wxshoplist'] = serialize($shoplist);
			}
		}

		include $this->showTpl();
	}

	public function delCardByid()
	{
		$id = intval(trim($_POST['cdid']));
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');
		if (!empty($cardinfo) && !empty($cardinfo['card_id'])) {
			$rets = $this->wxCardPack->wxCardDelete($this->access_token, '{"card_id":"' . $cardinfo['card_id'] . '"}');
			if (isset($rets['errcode']) && ($rets['errcode'] == 0)) {
				$wxcouponDb->update(array('isdel' => 1), array('id' => $id, 'mid' => $this->mid));
				$this->dexit(array('error' => 0, 'msg' => '卡券删除成功！'));
			}
			else {
				$tmpmsg = (isset($rets['errcode']) ? $rets['errcode'] : '');
				isset($rets['errmsg']) && ($tmpmsg = $tmpmsg . '：' . $rets['errmsg']);

				if (!empty($tmpmsg)) {
					$this->dexit(array('error' => 1, 'msg' => $tmpmsg));
				}

				$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
			}
		}

		$this->dexit(array('error' => 1, 'msg' => '卡券不存在，不可删除！'));
	}

	public function membercardinfo()
	{
		$id = (isset($_POST['id']) ? intval($_POST['id']) : 0);

		if ($id) {
			$card = M('cashier_wxcoupon_receive')->get_one(array('outerid' => $this->mid, 'id' => $id, 'cardtype' => 5), '*');
		}

		if (empty($card)) {
			$this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡信息'));
		}

		$res = $this->wxCardPack->MemberCardUserInfo($this->access_token, json_encode(array('card_id' => $card['cardid'], 'code' => $card['cardcode'])));

		if ($res['errcode']) {
			$this->dexit($res);
		}

		$key_val['USER_FORM_INFO_FLAG_MOBILE'] = '手机号';
		$key_val['USER_FORM_INFO_FLAG_NAME'] = '姓名';
		$key_val['USER_FORM_INFO_FLAG_BIRTHDAY'] = '生日';
		$key_val['USER_FORM_INFO_FLAG_IDCARD'] = '身份证';
		$key_val['USER_FORM_INFO_FLAG_EMAIL'] = '邮箱';
		$key_val['USER_FORM_INFO_FLAG_DETAIL_LOCATION'] = '详细地址';
		$key_val['USER_FORM_INFO_FLAG_EDUCATION_BACKGROUND'] = '教育背景';
		$key_val['USER_FORM_INFO_FLAG_CAREER'] = '职业';
		$key_val['USER_FORM_INFO_FLAG_INDUSTRY'] = '行业';
		$key_val['USER_FORM_INFO_FLAG_INCOME'] = '收入';
		$key_val['USER_FORM_INFO_FLAG_HABIT'] = '兴趣爱好';
		$data = array();
		$data[] = array('title' => '昵称', 'value' => $res['nickname']);
		$data[] = array('title' => '卡号', 'value' => $res['membership_number']);
		$data[] = array('title' => '积分', 'value' => $res['bonus']);
		$data[] = array('title' => '性别', 'value' => $res['sex'] == 'MALE' ? '男' : '女');
		if (isset($res['user_info']['common_field_list']) && $res['user_info']['common_field_list']) {
			foreach ($res['user_info']['common_field_list'] as $row) {
				$data[] = array('title' => $key_val[$row['name']], 'value' => $row['value']);
			}
		}

		if (isset($res['user_info']['custom_field_list']) && $res['user_info']['custom_field_list']) {
			foreach ($res['user_info']['custom_field_list'] as $row) {
				$data[] = array('title' => $row['name'], 'value' => $row['value']);
			}
		}

		$status = array('NORMAL' => '正常', 'EXPIRE' => '已过期', 'GIFTING' => '转赠中', 'GIFT_SUCC' => '转赠成功', 'GIFT_TIMEOUT' => '转赠超时', 'DELETE' => '已删除', 'UNAVAILABLE' => '已失效');
		$data[] = array('title' => '状态', 'value' => $status[$res['user_card_status']]);
		$this->dexit(array('errcode' => 0, 'data' => $data));
	}

	public function cardindex()
	{
		bpBase::loadOrg('common_page');
		$wxcouponDb = M('cashier_wxcoupon');
		$where = array('mid' => $this->mid, 'isdel' => '0', 'card_type' => '5');
		$_count = $wxcouponDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$wxcoupons = $wxcouponDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');

		foreach ($wxcoupons as $kk => $vv) {
			unset($wxcoupons[$kk]['kqcontent']);
			unset($wxcoupons[$kk]['kqexpand']);

			if ($vv['status'] == 0) {
				$wxcoupons[$kk]['statusstr'] = '<font>审核中</font>';
			}
			else if ($vv['status'] == 1) {
				$wxcoupons[$kk]['statusstr'] = '<font color=\'green\'>已审核</font>';
			}
			else if ($vv['status'] == 2) {
				$wxcoupons[$kk]['statusstr'] = '<font color=\'red\'>未通过</font>';
			}
			else {
				$wxcoupons[$kk]['statusstr'] = '待定';
			}
		}

		include $this->showTpl();
	}

	public function card()
	{
		$datestart = date('Y-m-d');
		$dateend = date('Y-m-d', strtotime('+1 month'));
		$typeid = 5;
		$wxcouponSet = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');
		$shoplist = unserialize($GLOBALS['_SESSION']['wxshoplist']);
		if (!is_array($shoplist) || empty($shoplist)) {
			$wxShoplist = $this->wxCardPack->wxGetPoiList($this->access_token);
			$shoplist = array();
			if (isset($wxShoplist['business_list']) && !empty($wxShoplist['business_list'])) {
				foreach ($wxShoplist['business_list'] as $kk => $vv) {
					$shoplist[$vv['base_info']['poi_id']] = array('sid' => $vv['base_info']['sid'], 'business_name' => $vv['base_info']['business_name'], 'branch_name' => $vv['base_info']['branch_name'], 'poi_id' => $vv['base_info']['poi_id'], 'address' => $vv['base_info']['address']);
				}
			}

			if (!empty($wxShoplist)) {
				$GLOBALS['_SESSION']['wxshoplist'] = serialize($shoplist);
			}
		}

		$wxCardColor = $this->wxCardPack->wxCardColor($this->access_token);
		include $this->showTpl();
	}

	public function wxCardList()
	{
		bpBase::loadOrg('common_page');
		$cardid = (isset($_GET['id']) ? intval($_GET['id']) : 0);
		$card = NULL;

		if ($cardid) {
			$card = M('cashier_wxcoupon')->get_one(array('mid' => $this->mid, 'id' => $cardid, 'card_type' => 5), '*');
		}

		$where = 'outerid=' . $this->mid . ' AND cardtype=5';
		$where_sql = 'wxr.outerid=' . $this->mid . ' AND wxr.cardtype=5';

		if ($card) {
			$where = 'outerid=' . $this->mid . ' AND cardtype=5 AND cardid=\'' . $card['card_id'] . '\'';
			$where_sql = 'wxr.outerid=' . $this->mid . ' AND wxr.cardtype=5 AND wxr.cardid=\'' . $card['card_id'] . '\'';
		}

		$wxcouponReceiveDb = M('cashier_wxcoupon_receive');
		$_count = $wxcouponReceiveDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$db_config = loadConfig('db');
		$tablepre = $db_config['default']['tablepre'];
		$sqlStr = 'SELECT DISTINCT wxr.id, wxr.*, cf.nickname, cf.headimgurl FROM ' . $tablepre . 'cashier_wxcoupon_receive as wxr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON wxr.openid=cf.openid AND cf.mid=wxr.outerid where ' . $where_sql . ' ORDER BY id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		$sqlObj = new model();
		$wxReceiveUser = $sqlObj->selectBySql($sqlStr);
		include $this->showTpl();
	}

	public function setPayCell()
	{
		$id = intval(trim($_POST['id']));
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (empty($cardinfo)) {
			$this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡'));
		}

		$is_open = ($cardinfo['is_open_cell'] ? false : true);
		$data = array('is_open' => $is_open, 'card_id' => $cardinfo['card_id']);
		$wxCardColor = $this->wxCardPack->PayCell($this->access_token, json_encode($data));

		if (empty($wxCardColor['errcode'])) {
			$wxcouponDb->update(array('is_open_cell' => $is_open ? 1 : 0), array('id' => $id, 'mid' => $this->mid));
		}

		$this->dexit($wxCardColor);
	}

	public function cardactive()
	{
		$key_val = array();
		$key_val['USER_FORM_INFO_FLAG_MOBILE'] = '手机号';
		$key_val['USER_FORM_INFO_FLAG_NAME'] = '姓名';
		$key_val['USER_FORM_INFO_FLAG_BIRTHDAY'] = '生日';
		$key_val['USER_FORM_INFO_FLAG_IDCARD'] = '身份证';
		$key_val['USER_FORM_INFO_FLAG_EMAIL'] = '邮箱';
		$key_val['USER_FORM_INFO_FLAG_DETAIL_LOCATION'] = '详细地址';
		$key_val['USER_FORM_INFO_FLAG_EDUCATION_BACKGROUND'] = '教育背景';
		$key_val['USER_FORM_INFO_FLAG_CAREER'] = '职业';
		$key_val['USER_FORM_INFO_FLAG_INDUSTRY'] = '行业';
		$key_val['USER_FORM_INFO_FLAG_INCOME'] = '收入';
		$key_val['USER_FORM_INFO_FLAG_HABIT'] = '兴趣爱好';
		$id = intval(trim($_GET['id']));
		$cardinfo = M('cashier_wxcoupon')->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (empty($cardinfo)) {
			$this->errorTip('您所查看的卡券不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}

		$activate_user_form = unserialize($cardinfo['activate_user_form']);
		$required_form_id_list = (isset($activate_user_form['required_form']['common_field_id_list']) && $activate_user_form['required_form']['common_field_id_list'] ? $activate_user_form['required_form']['common_field_id_list'] : array());
		$optional_form_id_list = (isset($activate_user_form['optional_form']['common_field_id_list']) && $activate_user_form['optional_form']['common_field_id_list'] ? $activate_user_form['optional_form']['common_field_id_list'] : array());
		$required_form_custom_field_list = (isset($activate_user_form['required_form']['custom_field_list']) && $activate_user_form['required_form']['custom_field_list'] ? implode(',', $activate_user_form['required_form']['custom_field_list']) : '');
		$optional_form_custom_field_list = (isset($activate_user_form['optional_form']['custom_field_list']) && $activate_user_form['optional_form']['custom_field_list'] ? implode(',', $activate_user_form['optional_form']['custom_field_list']) : '');
		include $this->showTpl();
	}

	public function setActivateUserForm()
	{
		$id = intval(trim($_POST['id']));
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (empty($cardinfo)) {
			$this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡'));
		}

		$data = array('card_id' => $cardinfo['card_id']);

		if ($_POST['field_list']) {
			$data['required_form']['common_field_id_list'] = $_POST['field_list'];
		}

		if ($_POST['custom']) {
			$custom_field_list = str_replace('，', ',', $_POST['custom']);
			$custom_field_list = explode(',', $custom_field_list);
			$data['required_form']['custom_field_list'] = $custom_field_list;
		}

		if ($_POST['sel_field_list']) {
			$data['optional_form']['common_field_id_list'] = $_POST['sel_field_list'];
		}

		if ($_POST['custom_sel']) {
			$custom_field_list = str_replace('，', ',', $_POST['custom_sel']);
			$custom_field_list = explode(',', $custom_field_list);
			$data['optional_form']['custom_field_list'] = $custom_field_list;
		}

		$jsondata = '{"card_id":"' . $data['card_id'] . '"';

		if (isset($data['required_form'])) {
			$jsondata .= ', "required_form":{';
			$required_form_common_field_id_list = false;

			if (isset($data['required_form']['common_field_id_list'])) {
				$required_form_common_field_id_list = true;
				$jsondata .= '"common_field_id_list":[';
				$pre = '';

				foreach ($data['required_form']['common_field_id_list'] as $v) {
					$jsondata .= $pre . '"' . $v . '"';
					$pre = ',';
				}

				$jsondata .= ']';
			}

			if (isset($data['required_form']['custom_field_list'])) {
				if ($required_form_common_field_id_list) {
					$jsondata .= ', "custom_field_list":[';
				}
				else {
					$jsondata .= '"custom_field_list":[';
				}

				$pre = '';

				foreach ($data['required_form']['custom_field_list'] as $v) {
					$jsondata .= $pre . '"' . $v . '"';
					$pre = ',';
				}

				$jsondata .= ']';
			}

			$jsondata .= '}';
		}

		if (isset($data['optional_form'])) {
			$jsondata .= ', "optional_form":{';
			$optional_form_common_field_id_list = false;

			if (isset($data['optional_form']['common_field_id_list'])) {
				$optional_form_common_field_id_list = true;
				$jsondata .= '"common_field_id_list":[';
				$pre = '';

				foreach ($data['optional_form']['common_field_id_list'] as $v) {
					$jsondata .= $pre . '"' . $v . '"';
					$pre = ',';
				}

				$jsondata .= ']';
			}

			if (isset($data['optional_form']['custom_field_list'])) {
				if ($optional_form_common_field_id_list) {
					$jsondata .= ', "custom_field_list":[';
				}
				else {
					$jsondata .= '"custom_field_list":[';
				}

				$pre = '';

				foreach ($data['optional_form']['custom_field_list'] as $v) {
					$jsondata .= $pre . '"' . $v . '"';
					$pre = ',';
				}

				$jsondata .= ']';
			}

			$jsondata .= '}';
		}

		$jsondata .= '}';
		$wxCardColor = $this->wxCardPack->ActivateUserForm($this->access_token, $jsondata);

		if (empty($wxCardColor['errcode'])) {
			$wxcouponDb->update(array('activate_user_form' => serialize($data)), array('id' => $id, 'mid' => $this->mid));
		}

		$this->dexit($wxCardColor);
	}

	public function ModifyStock()
	{
		$cdid = trim($_POST['cdid']);
		$id = intval(trim($_POST['id']));
		$qtype = intval(trim($_POST['qtype']));
		$qmun = intval(trim($_POST['qmun']));
		$opt = '+';
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (isset($cardinfo['quantity'])) {
			if ($qtype == 1) {
				$postwxJsonstr = '{"card_id":"' . $cdid . '","increase_stock_value":' . $qmun . '}';
				$newquantity = $cardinfo['quantity'] + $qmun;
			}
			else {
				if ($cardinfo['quantity'] < $qmun) {
					$this->dexit(array('error' => 1, 'msg' => '减少库存的值不能大于现在的库存值'));
				}

				$postwxJsonstr = '{"card_id":"' . $cdid . '","reduce_stock_value":' . $qmun . '}';
				$opt = '-';
				$newquantity = $cardinfo['quantity'] - $qmun;
			}

			$rets = $this->wxCardPack->wxCardModifyStock($this->access_token, $postwxJsonstr);

			if (isset($rets['errcode'])) {
				if ($rets['errcode'] == 0) {
					$wxcouponDb->update(array('quantity' => $opt . '=' . $qmun), array('id' => $id, 'mid' => $this->mid));
					$this->dexit(array('error' => 0, 'msg' => $newquantity));
				}
				else {
					$this->dexit(array('error' => 1, 'msg' => $rets['errcode'] . '：' . $rets['errmsg']));
				}
			}
		}

		$this->dexit(array('error' => 1, 'msg' => '更改库存失败！'));
	}

	public function consumeCard()
	{
		if (IS_POST) {
			$vcode = trim($_POST['auth_code']);

			if (!empty($vcode)) {
				$vcode = str_replace('-', '', $vcode);
				$rets = $this->wxCardPack->wxCardQueryCode($this->access_token, '{"code":"' . $vcode . '"}');

				if (isset($rets['card'])) {
					$wxcoupon_receiveDb = M('cashier_wxcoupon_receive');
					$card_id = trim($rets['card']['card_id']);
					$begin_time = trim($rets['card']['begin_time']);
					$end_time = trim($rets['card']['end_time']);
					$receiveinfo = $wxcoupon_receiveDb->get_one(array('openid' => $rets['openid'], 'cardcode' => $vcode, 'cardid' => $card_id), '*');
					if (($rets['can_consume'] == 1) && ($receiveinfo['status'] == 0) && ($receiveinfo['isdel'] == 0)) {
						$vrets = $this->wxCardPack->wxCardConsume($this->access_token, '{"code":"' . $vcode . '","card_id":"' . $card_id . '"}');
						if (!empty($vrets) && isset($vrets['card']) && ($vrets['errcode'] == 0)) {
							$wxcoupon_receiveDb->update(array('status' => 1, 'outerid' => $this->mid, 'consumetime' => time()), array('id' => $receiveinfo['id'], 'cardcode' => $vcode));
							$this->dexit(array('error' => 0, 'msg' => '核销成功！'));
						}
						else {
							if (isset($vrets['errmsg'])) {
								$this->dexit(array('error' => 1, 'msg' => $vrets['errcode'] . '：' . $vrets['errmsg']));
							}
						}
					}
					else {
						$this->dexit(array('error' => 1, 'msg' => '此核销码不可以再核销！'));
					}
				}
				else {
					if (0 < $rets['errcode']) {
						$this->dexit(array('error' => 1, 'msg' => $rets['errcode'] . '：' . $rets['errmsg']));
					}
				}
			}
		}
		else {
			$signdata = $this->wxCardPack->getSgin($this->access_token);
			include $this->showTpl();
		}
	}

	public function wxCardQrCodeTicket()
	{
		$id = intval(trim($_POST['cdid']));
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');
		if (!empty($cardinfo) && !empty($cardinfo['cardurl'])) {
			$this->dexit(array('error' => 0, 'msg' => $id));
		}
		else {
			if (!empty($cardinfo)) {
				$postwxJsonstr = '{"action_name":"QR_CARD","action_info":{"card": {"card_id":"' . $cardinfo['card_id'] . '","is_unique_code": false ,"outer_id" : ' . $this->mid . '}}}';
				$rets = $this->wxCardPack->wxCardQrCodeTicket($this->access_token, $postwxJsonstr);
				if (isset($rets['errcode']) && ($rets['errcode'] == 0)) {
					$wxcouponDb->update(array('cardticket' => $rets['ticket'], 'cardurl' => $rets['url']), array('id' => $cardinfo['id'], 'mid' => $this->mid));
					$this->dexit(array('error' => 0, 'msg' => $id));
				}
				else {
					$tmpmsg = (isset($rets['errcode']) ? $rets['errcode'] : '');
					isset($rets['errmsg']) && ($tmpmsg = $tmpmsg . '：' . $rets['errmsg']);

					if (!empty($tmpmsg)) {
						$this->dexit(array('error' => 1, 'msg' => $tmpmsg));
					}

					$this->dexit(array('error' => 1, 'msg' => '二维码生成失败！'));
				}
			}
		}

		$this->dexit(array('error' => 1, 'msg' => '卡券不存在，不可删除！'));
	}

	private function updateMname($brand_name, $logo_url)
	{
		$wxcouponCDb = M('cashier_wxcoupon_common');
		$mset = $wxcouponCDb->get_one(array('mid' => $this->mid), '*');
		$inserData = array('mname' => $brand_name);

		if (!empty($mset)) {
			if (empty($mset['mname']) || ($mset['mname'] != $brand_name)) {
				$wxcouponCDb->update($inserData, array('id' => $mset['id']));
			}
		}
		else {
			$inserData['mid'] = $this->mid;
			$inserData['wxlogurl'] = $logo_url;
			$wxcouponCDb->insert($inserData, true);
		}
	}

	private function FiltrationData($array)
	{
		if (empty($array['logo_url'])) {
			$this->dexit(array('error' => 1, 'msg' => 'LOGO图片必须上传'));
		}

		if (empty($array['brand_name'])) {
			$this->dexit(array('error' => 1, 'msg' => '商户名称必须填写'));
		}

		if (empty($array['title'])) {
			$this->dexit(array('error' => 1, 'msg' => '卡券标题必须填写'));
		}

		if (empty($array['color'])) {
			$this->dexit(array('error' => 1, 'msg' => '卡券颜色必须填写'));
		}

		if (empty($array['notice'])) {
			$this->dexit(array('error' => 1, 'msg' => '卡券操作提示必须填写'));
		}

		if (empty($array['description'])) {
			$this->dexit(array('error' => 1, 'msg' => '卡券详情使用须知必须填写'));
		}

		if (!(0 < $array['sku']['quantity'])) {
			$this->dexit(array('error' => 1, 'msg' => '卡券库存必须填写一个大于0的正数'));
		}

		if (!(0 < $array['date_info']['begin_timestamp'])) {
			$this->dexit(array('error' => 1, 'msg' => '卡券有效期开始时间没有填写'));
		}

		if (!(0 < $array['date_info']['end_timestamp'])) {
			$this->dexit(array('error' => 1, 'msg' => '卡券有效期结束时间没有填写'));
		}

		return true;
	}

	private function ArrayToJsonstr($array)
	{
		$tmpJosnStr = '{';

		foreach ($array as $key => $val) {
			$tmpJosnStr .= '"' . $key . '":';

			if (is_array($val)) {
				$tmpJosnStr .= $this->ArrayToJsonstr($val) . ',';
			}
			else if (is_numeric($val)) {
				$tmpJosnStr .= $val . ',';
			}
			else if (is_bool($val)) {
				$tmpJosnStr .= ($val ? 'true,' : 'false,');
			}
			else if (empty($val)) {
				$tmpJosnStr .= '"",';
			}
			else if (stripos($val, 'sarray[')) {
				$tmpJosnStr .= str_replace('Jsarray', '', $val) . ',';
			}
			else {
				$tmpJosnStr .= '"' . $val . '",';
			}
		}

		$tmpJosnStr = rtrim($tmpJosnStr, ',');
		$tmpJosnStr .= '}';
		return $tmpJosnStr;
	}

	public function uploadImg()
	{
		if (!empty($_FILES)) {
			$return = $this->oldUploadFile('wxcoupon', $this->mid);
			if (isset($return['data']) && !empty($return['data'])) {
				$imgpath = $return['data'][0]['savepath'] . $return['data'][0]['savename'];
				$trimstr = DIRECTORY_SEPARATOR . 'Cashier' . DIRECTORY_SEPARATOR;
				$wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($imgpath, '.');
				$wxlogimg = $this->wxCardPack->wxCardUpdateImg($this->access_token, $wximgpath);
				if (isset($wxlogimg['url']) && !empty($wxlogimg['url'])) {
					$wxcouponCDb = M('cashier_wxcoupon_common');
					$mset = $wxcouponCDb->get_one(array('mid' => $this->mid), '*');
					$inserData = array('logurl' => $imgpath, 'wxlogurl' => $wxlogimg['url']);

					if (!empty($mset)) {
						$wxcouponCDb->update($inserData, array('id' => $mset['id']));
					}
					else {
						$inserData['mid'] = $this->mid;
						$wxcouponCDb->insert($inserData, true);
					}

					$this->dexit(array('error' => 0, 'wxlogurl' => $wxlogimg['url'], 'localimg' => $imgpath));
				}
				else {
					$tmpmsg = (isset($wxlogimg['errcode']) ? $wxlogimg['errcode'] : '');
					isset($wxlogimg['errmsg']) && ($tmpmsg = $tmpmsg . ':' . $wxlogimg['errmsg']);

					if (!empty($tmpmsg)) {
						$this->dexit(array('error' => 1, 'msg' => $tmpmsg));
					}
				}
			}
		}

		$this->dexit(array('error' => 1, 'msg' => ''));
	}

	public function qrcode()
	{
		$id = intval(trim($_GET['cdid']));
		$isdwd = (isset($_GET['dwd']) ? intval(trim($_GET['dwd'])) : 0);
		$tmpdata = M('cashier_wxcoupon')->get_one(array('id' => $id, 'mid' => $this->mid), 'cardurl,cardticket');
		bpBase::loadOrg('phpqrcode');
		new QRimage(350, 350);
		$url = urldecode($tmpdata['cardurl']);

		if (0 < $isdwd) {
			$fname = 'Your-Card-code-image-' . $this->mid . '.png';
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Type:application/force-download');
			header('Content-type: image/png');
			header('Content-Type:application/download');
			header('Content-Disposition: attachment; filename=' . $fname);
			header('Content-Transfer-Encoding: binary');
			QRcode::png($url, false, 'H', 10, 1);
		}
		else {
			Header('Content-type: image/jpeg');
			QRcode::png($url);
		}
	}
}

?>
