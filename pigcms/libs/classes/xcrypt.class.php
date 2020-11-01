<?php    /**
* 常用对称加密算法类
* 支持密钥：64/128/256 bit（字节长度8/16/32）
* 支持算法：DES/AES（根据密钥长度自动匹配使用：DES:64bit AES:128/256bit）
* 支持模式：CBC/ECB/OFB/CFB
* 密文编码：base64字符串/十六进制字符串/二进制字符串流
* 填充方式: PKCS5Padding（DES）
*
* @author: linvo
* @version: 1.0.0
* @date: 2013/1/10
*/
class Xcrypt{
	private $mcrypt;
	private $key;
	private $mode;
	private $iv;
	private $blocksize;
	/**
	* 构造函数
	*
	* @param string 密钥
	* @param string 模式
	* @param string 向量（"off":不使用 / "auto":自动 / 其他:指定值，长度同密钥）
	*/
	public function __construct($key, $mode = 'cbc', $iv = "off"){
		switch (strlen($key)){
			case 8:
				$this->mcrypt = MCRYPT_DES;
				break;
			case 16:
				$this->mcrypt = MCRYPT_RIJNDAEL_128;
				break;
			case 32:
				$this->mcrypt = MCRYPT_RIJNDAEL_256;
				break;
			default:
				die("Key size must be 8/16/32");
		}
		$this->key = $key;
		switch (strtolower($mode)){
			case 'ofb':
				$this->mode = MCRYPT_MODE_OFB;
				if ($iv == 'off') die('OFB must give a IV'); //OFB必须有向量
				break;
			case 'cfb':
				$this->mode = MCRYPT_MODE_CFB;
				if ($iv == 'off') die('CFB must give a IV'); //CFB必须有向量
				break;
			case 'ecb':
				$this->mode = MCRYPT_MODE_ECB;
				$iv = 'off'; //ECB不需要向量
				break;
			case 'cbc':

			default:
				$this->mode = MCRYPT_MODE_CBC;
		}
		switch (strtolower($iv)){
			case "off":
				$this->iv = null;
				break;
			case "auto":
				//根据自身系统调整 PHP_OS的value值    Linux 下 PHP_OS = Linux       Win 下 PHP_OS = WINNT|WIN
				$source = PHP_OS=='Linux' ? MCRYPT_RAND : MCRYPT_DEV_RANDOM;
				$this->iv = mcrypt_create_iv(mcrypt_get_block_size($this->mcrypt, $this->mode), $source);
				break;
			default:
				$this->iv = $iv;
		}
	}

	/**
	* 获取向量值
	* @param string 向量值编码（base64/hex/bin）
	* @return string 向量值
	*/
	public function getIV($code = 'base64'){
		switch ($code){
			case 'base64':
				$ret = base64_encode($this->iv);
				break;
			case 'hex':
				$ret = bin2hex($this->iv);
				break;
			case 'bin':
			
			default:
				$ret = $this->iv;
		}
		return $ret;
	}

	/**
	* 加密
	* @param string 明文
	* @param string 密文编码（base64/hex/bin）
	* @return string 密文
	*/
	public function encrypt($strs, $code = 'base64',$ftype){
		// $pathx    = '/var/www/smms/unqualifiedload/';
		$str    =    file_get_contents($strs);

		if ($this->mcrypt == MCRYPT_DES) $str = $this->_pkcs5Pad($str);
		if (isset($this->iv)) {
			$result = mcrypt_encrypt($this->mcrypt, $this->key, $str, $this->mode, $this->iv);
		}else{
			@$result = mcrypt_encrypt($this->mcrypt, $this->key, $str, $this->mode);
		}
		switch ($code){
			case 'base64':
				$ret = base64_encode($result);
				break;
			case 'hex':
				$ret = bin2hex($result);
				break;
			case 'bin':

			default:
			$ret = $result;
		}

		// $encrypt_xname    =$pathx.'encrypt'.date('Y-m-d_H-i-s',time()).'.zip';
		$encrypt_xname    ='encrypt'.date('Y-m-d_H-i-s',time()).'.'.$ftype;
		echo  $encrypt_xname;
		$fp    =    fopen($encrypt_xname,'w+');  //生成加密文件
		fwrite($fp, $ret);
		fclose($fp);

		return $encrypt_xname;
	}

	/**
	* 解密
	* @param string 密文
	* @param string 密文编码（base64/hex/bin）
	* @return string 明文
	*/
	public function decrypt($str, $code = "base64"){
		$str    =    file_get_contents($str);
		$ret = false;
		switch ($code){
			case 'base64':
				$str = base64_decode($str);
				break;
			case 'hex':
				$str = $this->_hex2bin($str);
				break;
			case 'bin':
			
			default:
		}
		if ($str !== false){
			if (isset($this->iv)){
				$ret = mcrypt_decrypt($this->mcrypt, $this->key, $str, $this->mode, $this->iv);
			} else {
				@$ret = mcrypt_decrypt($this->mcrypt, $this->key, $str, $this->mode);
			}
			if ($this->mcrypt == MCRYPT_DES) $ret = $this->_pkcs5Unpad($ret);
			$ret = trim($ret);
		}
		$decrypt_xname    ='decrypt'.date('Y-m-d_H-i-s',time()).'.zip';
		$fp    =    fopen($decrypt_xname,'w+');  //生成解密文件
		fwrite($fp, $ret);
		fclose($fp);

		$decrypt_xname
		return $decrypt_xname;
	}

	private function _pkcs5Pad($text){
		$this->blocksize = mcrypt_get_block_size($this->mcrypt, $this->mode);
		$pad = $this->blocksize - (strlen($text) % $this->blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}

	private function _pkcs5Unpad($text){
		$pad = ord($text{strlen($text) - 1});
		if ($pad > strlen($text)) return false;
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
		$ret = substr($text, 0, -1 * $pad);
		return $ret;
	}

	private function _hex2bin($hex = false){
		$ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;
		return $ret;
	}
	private function authcode($string, $operation = 'DECODE', $key = "", $expiry = 0) {
	    	//$key是自定义的一个密钥
	    	$ckey_length = 4;
	    	$key = md5($key ? $key : 'pigcms');//若未指定key，则使用123456，可以改成自己的
	    	$keya = md5(substr($key, 0, 16));
	   	$keyb = md5(substr($key, 16, 16));
	    	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	 
	    	$cryptkey = $keya.md5($keya.$keyc);
	    	$key_length = strlen($cryptkey);
	 
	    	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	    	$string_length = strlen($string);
	 
	    	$result = '';
	    	$box = range(0, 255);
	 
	   	$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
		        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
		for($j = $i = 0; $i < 256; $i++) {
		        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
		        $tmp = $box[$i];
		        $box[$i] = $box[$j];
		        $box[$j] = $tmp;
		}
		for($a = $j = $i = 0; $i < $string_length; $i++) {
		        $a = ($a + 1) % 256;
		        $j = ($j + $box[$a]) % 256;
		        $tmp = $box[$a];
		        $box[$a] = $box[$j];
		        $box[$j] = $tmp;
		        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		if($operation == 'DECODE') {
		        	if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
		          		return substr($result, 26);
		        	} else {
		            	return '';
		        	}
		} else {
		        	return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
}
?>