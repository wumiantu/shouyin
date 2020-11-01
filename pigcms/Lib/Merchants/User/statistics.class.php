<?php
bpBase::loadAppClass('common', 'User', 0);
class statistics_controller extends common_controller
{
	private $merchantsDb;

	public function __construct()
	{
		parent::__construct();
		$this->authorityControl(array('getchart', 'GetwxUserInfoFromSys'));
	}

	public function index()
	{
		$today = date('Y-m-d');
		$aweekago = date('Y-m-d', strtotime('-1 week'));
		$todaym = date('Y-m');
		$aYearagom = date('Y-m', strtotime('-6 month'));
		include $this->showTpl();
	}

	public function fans()
	{
		bpBase::loadOrg('common_page');
		$fansDb = M('cashier_fans');
		$where = array('mid' => $this->mid);
		$_count = $fansDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$fansarr = $fansDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'totalfee DESC,id DESC');
		$getwxuser = array(
			'user_list' => array()
			);
		$tmpdata = array();

		foreach ($fansarr as $kk => $vv) {
			$tmpdata[$vv['openid']] = $vv;
			if (empty($vv['nickname']) || empty($vv['headimgurl'])) {
				$getwxuser['user_list'][$kk] = array('openid' => $vv['openid'], 'lang' => 'zh-CN');
			}
		}

		$fansarr = $tmpdata;
		unset($tmpdata);
		$nowxinfoOpenid = array();

		if (!empty($getwxuser['user_list'])) {
			bpBase::loadOrg('wxCardPack');
			$wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
			$wxCardPack = new wxCardPack($wx_user, $this->mid);
			$access_token = $wxCardPack->getToken();
			$UserInfoList = $wxCardPack->GetwxUserInfoList($access_token, json_encode($getwxuser));

			if (isset($UserInfoList['user_info_list'])) {
				$fansDb = M('cashier_fans');

				foreach ($UserInfoList['user_info_list'] as $uvv) {
					if ($uvv['subscribe'] == 1) {
						$wxuserinfo = array('is_subscribe' => $uvv['subscribe'], 'nickname' => $uvv['nickname'], 'sex' => $uvv['sex'], 'province' => $uvv['province'], 'city' => $uvv['city'], 'country' => $uvv['country'], 'headimgurl' => $uvv['headimgurl'], 'groupid' => $uvv['groupid']);
						$fansDb->update($wxuserinfo, array('openid' => $uvv['openid'], 'mid' => $this->mid));
						$fansarr[$uvv['openid']] = array_merge($fansarr[$uvv['openid']], $wxuserinfo);
					}
					else {
						$nowxinfoOpenid[] = $uvv['openid'];
					}
				}
			}

			if (!empty($nowxinfoOpenid)) {
			}
		}

		include $this->showTpl();
	}

	public function getchart()
	{
		$nowtime = time();
		$typ = trim($_POST['typ']);
		$dstart = trim($_POST['dstart']);
		$dend = trim($_POST['dend']);
		$orderDb = M('cashier_order');
		$totalmoney = $refund = $income = 0;
		$output = array();

		switch ($typ) {
		case 'date':
			$startime = $nowtime - (7 * 24 * 3600);
			$starttime = strtotime($dstart);
			!(0 < $starttime) && ($starttime = $startime);
			$endtime = strtotime($dend);

			if (!(0 < $endtime)) {
				$endtime = $nowtime;
			}
			else {
				$endtime = $endtime + (23 * 3600) + (59 * 60) + 30;
			}

			$xkey1 = $xkey2 = array();
			$s = $starttime;

			while ($s <= $endtime) {
				$datekey = date('m-d', $s);
				$xkey1[$datekey] = 0;
				$s = $s + (23 * 3600) + (59 * 60) + 29;
			}

			$xkey2 = $xkey1;
			$wherestr = 'mid=' . $this->mid . ' AND  paytime >' . $starttime . ' AND paytime <=' . $endtime . ' AND  ispay=1';
			$fieldstr = 'sum(goods_price) as price,paytime,FROM_UNIXTIME(paytime,"%m-%d") as perdate';
			$tmpdatas = $orderDb->select($wherestr, $fieldstr, '', 'paytime ASC', 'perdate');

			foreach ($tmpdatas as $tvv) {
				$xkey1[$tvv['perdate']] = $tvv['price'];
				$totalmoney += $tvv['price'];
			}

			$output['idx1'] = array_values($xkey1);
			$wherestr = 'mid=' . $this->mid . ' AND  paytime >' . $starttime . ' AND paytime <=' . $endtime . ' AND  ispay=1 AND refund=2';
			$fieldstr = 'sum(goods_price) as price,paytime,FROM_UNIXTIME(paytime,"%m-%d") as perdate';
			$tmprefund = $orderDb->select($wherestr, $fieldstr, '', 'paytime ASC', 'perdate');

			foreach ($tmprefund as $fvv) {
				$xkey2[$fvv['perdate']] = $fvv['price'];
				$refund += $fvv['price'];
			}

			$output['idx2'] = array_values($xkey2);
			$xkey3 = array();

			foreach ($xkey1 as $kk => $vv) {
				$xkey3[$kk] = $vv - $xkey2[$kk];
				$income += $xkey3[$kk];
			}

			$output['idx3'] = array_values($xkey3);
			$expand = array('tt' => $totalmoney, 'rf' => $refund, 'ic' => $income);
			break;

		case 'month':
			$todaym = date('Y-m') . '-01';
			$aYearagom = date('Y-m', strtotime('-6 month'));
			$starttime = strtotime($dstart . '-01');

			if (!(0 < $starttime)) {
				$starttime = strtotime($todaym);
			}

			$t = date('t', $dend);
			$endtime = strtotime($dend);

			if (!(0 < $endtime)) {
				$endtime = $nowtime;
			}
			else {
				$endtime = strtotime($dend . '-' . $t . ' 23:59:59');
			}

			$xkey1 = $xkey2 = array();
			$s = $starttime;

			while ($s <= $endtime) {
				$datekey = date('Y-m', $s);
				$xkey1[$datekey] = 0;
				$s = $s + (31 * 24 * 3600) + 3600;
			}

			$xkey2 = $xkey1;
			$wherestr = 'mid=' . $this->mid . ' AND  paytime >' . $starttime . ' AND paytime <=' . $endtime . ' AND  ispay=1';
			$fieldstr = 'sum(goods_price) as price,paytime,FROM_UNIXTIME(paytime,"%Y-%m") as perdate';
			$tmpdatas = $orderDb->select($wherestr, $fieldstr, '', 'paytime ASC', 'perdate');

			foreach ($tmpdatas as $tvv) {
				$xkey1[$tvv['perdate']] = $tvv['price'];
				$totalmoney += $tvv['price'];
			}

			$output['idx1'] = array_values($xkey1);
			$wherestr = 'mid=' . $this->mid . ' AND  paytime >' . $starttime . ' AND paytime <=' . $endtime . ' AND  ispay=1 AND refund=2';
			$fieldstr = 'sum(goods_price) as price,paytime,FROM_UNIXTIME(paytime,"%Y-%m") as perdate';
			$tmprefund = $orderDb->select($wherestr, $fieldstr, '', 'paytime ASC', 'perdate');

			foreach ($tmprefund as $fvv) {
				$xkey2[$fvv['perdate']] = $fvv['price'];
				$refund += $fvv['price'];
			}

			$output['idx2'] = array_values($xkey2);
			$xkey3 = array();

			foreach ($xkey1 as $kk => $vv) {
				$xkey3[$kk] = $vv - $xkey2[$kk];
				$income += $xkey3[$kk];
			}

			$output['idx3'] = array_values($xkey3);
			$expand = array('tt' => $totalmoney, 'rf' => $refund, 'ic' => $income);
			break;

		case 'smcount':
			$startime = $nowtime - (7 * 24 * 3600);
			$starttime = strtotime($dstart);
			!(0 < $starttime) && ($starttime = $startime);
			$endtime = strtotime($dend);

			if (!(0 < $endtime)) {
				$endtime = $nowtime;
			}
			else {
				$endtime = $endtime + (23 * 3600) + (59 * 60) + 30;
			}

			$xkey1 = $xkey2 = array();
			$s = $starttime;

			while ($s <= $endtime) {
				$datekey = date('m-d', $s);
				$xkey1[$datekey] = 0;
				$s = $s + (23 * 3600) + (59 * 60) + 29;
			}

			$xkey2 = $xkey1;
			$wherestr1 = 'mid=' . $this->mid . ' AND  add_time >' . $starttime . ' AND add_time <=' . $endtime . ' AND pay_type="micropay" ';
			$wherestr2 = 'mid=' . $this->mid . ' AND  add_time >' . $starttime . ' AND add_time <=' . $endtime . ' AND pay_type!="micropay" ';
			$fieldstr = 'count(id) as perC,add_time,FROM_UNIXTIME(add_time,"%m-%d") as perdate';
			$tmpdatas1 = $orderDb->select($wherestr1, $fieldstr, '', 'add_time ASC', 'perdate');

			foreach ($tmpdatas1 as $cvv) {
				(0 < $cvv['perC']) && $xkey1[$cvv['perdate']] = $cvv['perC'];
				$micropay += $cvv['perC'];
			}

			$output['idx1'] = array_values($xkey1);
			$tmpdatas2 = $orderDb->select($wherestr2, $fieldstr, '', 'add_time ASC', 'perdate');

			foreach ($tmpdatas2 as $cvv) {
				(0 < $cvv['perC']) && $xkey2[$cvv['perdate']] = $cvv['perC'];
				$no_micropay += $cvv['perC'];
			}

			$output['idx2'] = array_values($xkey2);
			!(0 < $micropay) && ($micropay = 0);
			!(0 < $no_micropay) && ($no_micropay = 0);
			$expand = array('microC' => $micropay, 'nomicroC' => $no_micropay);
			print_r($tmpdatas);
			break;

		default:
			break;
		}

		$this->dexit(array('ydata' => $output, 'xdata' => array_keys($xkey1), 'expand' => $expand));
	}

	public function otherpie()
	{
		$today = date('Y-m-d');
		$aweekago = date('Y-m-d', strtotime('-1 week'));
		$orderDb = M('cashier_order');
		$wherestr = 'mid=' . $this->mid . ' AND pay_type="micropay" AND comefrom="0"';
		$mt_count = $orderDb->count($wherestr);
		$wherestr = $wherestr . ' AND ispay=1';
		$wherestr = 'mid=' . $this->mid . ' AND pay_type !="micropay" AND comefrom="0"';
		$wt_count = $orderDb->count($wherestr);
		$entirearr = array('local' => 0, 'other' => 0, 'refund' => 0);
		$wherestr = 'mid=' . $this->mid . ' AND ispay=1 AND comefrom="0"';
		$tmpprice = $orderDb->get_one($wherestr, 'sum(goods_price) as tprice');
		(0 < $tmpprice['tprice']) && $entirearr['local'] = $tmpprice['tprice'];
		$wherestr = 'mid=' . $this->mid . ' AND ispay=1 AND comefrom !="0"';
		$tmpprice = $orderDb->get_one($wherestr, 'sum(goods_price) as tprice');
		(0 < $tmpprice['tprice']) && $entirearr['other'] = $tmpprice['tprice'];
		include $this->showTpl();
	}

	public function GetwxUserInfoFromSys($jsonData)
	{
		$url = 'http://test.me.cc/cgi-bin/user/info/batchget?access_token=' . $wxAccessToken . '&lang=zh_CN';
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}
}

?>
