<?php
bpBase::loadAppClass('common', 'User', 0);
class pay_controller extends common_controller
{
	private $payConfigDb;

	public function __construct()
	{
		parent::__construct();
		$this->authorityControl(array('pem_upload'));
		$this->payConfigDb = M('cashier_payconfig');
	}

	public function config()
	{
		$payConfig = $this->payConfigDb->get_one(array('mid' => $this->mid), '*');

		if ($payConfig) {
			if ($payConfig['configData']) {
				$payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData']));
			}
			else {
				$payConfig['configData'] = array();
			}
		}

		if (IS_POST) {
			$data = $this->clear_html($_POST['data']);

			if ($payConfig) {
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
				$payConfig = array('mid' => $this->mid, 'isOpen' => 1, 'configData' => serialize($data));
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

			delCacheByMid($this->mid);
			echo json_encode($return);
			exit();
		}

		include $this->showTpl();
	}

	public function getApiData()
	{
		$datas = array('wxtoken' => $this->merchant['wxtoken'], 'aeskey' => $this->merchant['aeskey'], 'encodetype' => $this->merchant['encodetype'], 'mid' => $this->mid);
		if (empty($datas['wxtoken']) || empty($datas['aeskey'])) {
			$datas['wxtoken'] = randStr(30, true);
			$datas['aeskey'] = randStr(43, true);
			M('cashier_merchants')->update(array('wxtoken' => $datas['wxtoken'], 'aeskey' => $datas['aeskey']), array('mid' => $this->mid));
		}

		$this->dexit($datas);
	}

	public function pem_upload()
	{
		if (IS_POST) {
			if (!empty($_FILES)) {
				$return = $this->oldUploadFile('pem', $this->mid);

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

			if ($payConfig = $this->payConfigDb->get_one(array('mid' => $this->mid), 'id')) {
				$data['id'] = $payConfig['id'];
			}
			else {
				$data['mid'] = $this->mid;
			}

			$return = $this->_setField($this->payConfigDb, $data);
			delCacheByMid($this->mid);
			echo json_encode($return);
			exit();
		}
	}
}

?>
