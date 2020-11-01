<?php
class checkFunc{
	public $key;
	public $serverUrl;
	public $topdomain;
	private $emergent_mode;

	public function __construct(){
		$this->serverUrl = 'http://vnlcms.com/';
		$this->key = trim(File_Service_Key);
		$this->emergent_mode = intval(File_Emergent_Mode);
		$topdomain = trim(File_Server_Topdomain);

		if ($this->getTopDomain() != $topdomain) {
			exit('收银台插件顶级域名填写错误');
		}else {
			$this->topdomain = $topdomain;
		}

		$this->token = $token;
	}

	public function curl_exe($url, $data = '', $time = 2){
		return file_get_contents($url);
	}

	public function getTopDomain(){
		$host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'])));
		$host = strtolower($host);

		if (strpos($host, '/') !== false) {
			$parse = @parse_url($host);
			$host = $parse['host'];
		}

		$topleveldomaindb = array('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me', 'asia');
		$str = '';

		foreach ($topleveldomaindb as $v) {
			$str .= ($str ? '|' : '') . $v;
		}

		$matchstr = '[^\\.]+\\.(?:(' . $str . ')|\\w{2}|((' . $str . ')\\.\\w{2}))$';

		if (preg_match('/' . $matchstr . '/ies', $host, $matchs)) {
			$domain = $matchs[0];
		}else {
			$domain = $host;
		}

		return $domain;
	}

	private function allow(){
		if ($this->emergent_mode) {
			return true;
		}

		if (getCache('__encryptcode')) {
			return true;
		}

		if ($this->topdomain == 'pigcms.cn') {
			return true;
		}

		if ($this->dateValidate()) {
			return true;
		}

		return false;
	}

//	private function dateValidate(){
//		$currentHourOfDay = intval(date('H'));
//		$currentDayOfWeek = date('w');
//		$currentMonth = date('n');
//		$currentDay = date('j');
//		$currentDate = $currentMonth . '.' . $currentDay;
//		$nationalDay = array('10.1', '10.2', '10.3', '10.4', '10.5', '10.6', '10.7');
//		$mayDay = array('5.1', '5.2', '5.3');
//		$newYearDay = array('1.1');
//		$midAutumnDay = array('9.26', '9.27');
//		$allowDate = array_merge($nationalDay, $mayDay, $newYearDay, $midAutumnDay);
//		if (($currentHourOfDay < 9) || (17 <= $currentHourOfDay)) {
//			return true;
//		}

//		if (($currentDayOfWeek == 0) || ($currentDayOfWeek == 6)) {
//			return true;
//		}

//		if (in_array($currentDate, $allowDate)) {
//			return true;
//		}

//		return false;
//	}

	public function fgwixklwudffqdfoevbrwobbbb(){
		$url = $this->serverUrl . 'index.php?a=client_check&uui=' . $this->topdomain;
		$remoteStr = $this->curl_exe($url, '');
		if (($remoteStr != 2) && ($remoteStr != 0)) {
			exit('温馨提示：域名未授权用户，功能受到限制。。请联系管理员解除限制QQ:10802108');
		}
	}

	public function sduwskaidaljenxsyhikaaaa(){
		$url = $this->serverUrl . 'index.php?a=client_check&uui=' . $this->topdomain;
		$remoteStr = $this->curl_exe($url, '');
		if (($remoteStr != 2) && ($remoteStr != 0)) {
			exit('温馨提示：域名未授权用户，功能受到限制。。请联系管理员解除限制QQ:10802108');
		}
	}

	public function cfdwdgfds3skgfds3szsd3idsj(){
		$url = $this->serverUrl . 'index.php?a=client_check&uui=' . $this->topdomain;
		$remoteStr = $this->curl_exe($url, '');
		if (($remoteStr != 2) && ($remoteStr != 0)) {
			exit('温馨提示：域名未授权用户，功能受到限制。。请联系管理员解除限制QQ:10802108');
		}
	}
}

function fdsrejsie3qklwewerzdagf4ds(){
	$url = $this->serverUrl . 'index.php?a=client_check&uui=' . $this->topdomain;
	$remoteStr = $this->curl_exe($url, '');
	if (($remoteStr != 2) && ($remoteStr != 0)) {
		exit('温馨提示：域名未授权用户，功能受到限制。。请联系管理员解除限制QQ:10802108');
	}
}

function fdsrejsie3qklwewerzdagf4dsz62hs5z421s(){
	$url = $this->serverUrl . 'index.php?a=client_check&uui=' . $this->topdomain;
	$remoteStr = $this->curl_exe($url, '');
	if (($remoteStr != 2) && ($remoteStr != 0)) {
		exit('温馨提示：域名未授权用户，功能受到限制。。请联系管理员解除限制QQ:10802108');
	}
}


?>
