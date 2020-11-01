<?php
bpBase::loadAppClass('base', '', 0);
class auth_controller extends base_controller{
	private $_siteInfo;
	private $_path = '';
	private $_merchants;
	private $_salt = '';
	private $_exist = 120;
	private $_sourceArray = array('pigcms'=>1,'weidian'=>2,'o2o'=>3);
	private $_status = array(
			0	 => array('status'=>0,	  'message' => 'success'),
			1000 => array('status'=>1000, 'message' => '操作类型错误'),
			1001 => array('status'=>1001, 'message' => '签名无效'),
			1002 => array('status'=>1002, 'message' => '操作符失效'),
			1003 => array('status'=>1003, 'message' => '数据错误'),
			1004 => array('status'=>1004, 'message' => '商户不存在'),
			1005 => array('status'=>1005, 'message' => '订单不存在')
	);
	public function __construct(){
		parent::__construct();
		$session_storage = getSessionStorageType();
		bpBase::loadSysClass($session_storage);
		
		$this->_merchants = M('cashier_Merchants');
		$this->_salt = PIGCMS_KEY;
		$parseSiteUrl = parse_url($this->site_info['SITE_URL']);
		$this->_path = $parseSiteUrl['scheme'].'://'.$parseSiteUrl['host'];
	}
	public function getIdentifier(){
		if(IS_POST){
			$postStr=file_get_contents("php://input");
			$postStr = trim($postStr);
			$postStr=Encryptioncode(urldecode($postStr),'DECODE');
			$data=json_decode($postStr,true);
			if($this->_signVeryfy($data)){
				if(isset($data['sign'])){ unset($data['sign']);}
				$mid=$this->_checkUser($data);
				$payconfigDb = M('cashier_payconfig');
				$tmppayconf=$payconfigDb->get_one(array('mid' => $mid),'*');
				if(empty($tmppayconf)){
				  $configData=serialize(array('weixin'=>array('appid'=>$data['appid'],'appSecret'=>$data['appsecret'],'isOpen'=>1)));
				  $inserData=array('mid'=>$mid,'isOpen'=>1,'configData'=>$configData);
				  $payconfigDb->insert($inserData,1);
				}elseif(empty($tmppayconf['configData'])){
					$configData=serialize(array('weixin'=>array('appid'=>$data['appid'],'appSecret'=>$data['appsecret'],'isOpen'=>1)));
				    $payconfigDb->update(array('configData'=>$configData),array('mid'=>$mid));
				}
				$code = json_encode(array('mid'=>$mid,'mktime'=>SYS_TIME));
				$codeStr=Encryptioncode($code,'ENCODE');
				$codeStr=base64_encode($codeStr);
				$error = array_merge($this->_status[0],array('code'=>$codeStr));
			}else{
				$error = $this->_status[1001];
			}
		}else{
			$error = $this->_status[1000];
		}
		$this->dexit($error);
	}

	/****POST过来的数据
	**是$postdataStr=base64_encode(json_encode($data));处理过的字符串
	***其中应包含下面所需数据
	**** 数据格式请参照
	** [thirduserid] => wbuyhw1418634769
    ** [order_id] => NF0DI20150916092339
    ** [comefrom] => 1  //1是营销系统，2微店、3是o2o
    ** [pay_way] => daofu
    ** [pay_type] => daofu
    ** [goods_id] => 111
    ** [goods_name] => 
    ** [goods_price] => 52
    ** [transaction_id] => 
    ** [openid] => oZrMms12QuDmt_mCJOam85yNF0DI
    ** [headimgurl] => 
    ** [is_subscribe] => 0
    ** [nickname] => fxgfdg
    ** [sex] => 1
    ** [province] => 
    ** [city] => 
	** 请保持这16个字段必须都要有
	***如果没有fans数据 请将$data['openid']的值设置为空
	******/
	public function orderCreat(){
		if(IS_POST){
			$postStr=file_get_contents("php://input");
			$postStr = trim($postStr);
			$data=json_decode(base64_decode($postStr),true);
			$data = $this->clear_html($data);
			if(!isset($data['thirduserid'])) $this->dexit(array('status'=>1006, 'message' => '商户ID不存在')); 
			if($this->_signVeryfy($data)){
				$info = $this->_merchants->get_one(array('thirduserid'=>$data['thirduserid']),'*');
				if(empty($info) || !is_array($info)){
				   $this->dexit($this->_status[1004]);  
				}
				$orderdata=array('mid'=>$info['mid']);
				$order_idlen=strlen($data['order_id']);
				if($order_idlen<31){
				   $tmplen=32-$order_idlen-1;
				   $orderdata['order_id']=$data['order_id']."_".createRandomstr($tmplen);
				  }else{
				      $orderdata['order_id']=substr($data['order_id'],0,32);
				  }
			    $orderdata['pay_way']=$data['pay_way'];
				$orderdata['pay_type']=$data['pay_type'];
				$orderdata['goods_type']='unlimit';
				$orderdata['goods_id']=isset($data['goods_id']) && !empty($data['goods_id']) ? $data['goods_id']:111;
				$goods_name=isset($data['goods_name']) && !empty($data['goods_name']) ? $data['goods_name']:'';
				if(empty($goods_name)){
				   if($data['comefrom']==1) $goods_name='来自微信营销系统订单';
				   if($data['comefrom']==2) $goods_name='来自微店系统订单';
				   if($data['comefrom']==3) $goods_name='来自o2o系统订单';
				}
				$orderdata['goods_name']=$goods_name;
				$orderdata['goods_describe']='来自第三方系统对接的订单';
				$orderdata['goods_price']=$data['goods_price'];
				$orderdata['add_time'] = $orderdata['paytime'] = SYS_TIME;
				$orderdata['ispay'] = $orderdata['state'] = 1;
				$orderdata['truename']=$data['nickname'];
				$orderdata['openid']=$data['openid'];
				$orderdata['transaction_id']=$data['transaction_id'];
				$orderdata['comefrom']=$data['comefrom'];
				/***入订单表***/
				$insert_id = M('cashier_order')->insert($orderdata,1);
				unset($orderdata);
				if(($insert_id > 0) && !empty($data['openid'])){
					$fansDb = M('cashier_Fans');
					$fanTmp=$fansDb->get_one(array('openid'=>$data['openid'],'mid'=>$info['mid']));
					if(!empty($fanTmp)){
					   $totalfee=$fanTmp['totalfee']+($data['goods_price']*100);
					   $fansdata=array('totalfee'=>$totalfee);
					   empty($fanTmp['headimgurl']) && !empty($data['headimgurl']) && $fansdata['headimgurl']=$data['headimgurl'];
					   empty($fanTmp['nickname']) && !empty($data['nickname']) && $fansdata['nickname']=$data['nickname'];
					   empty($fanTmp['is_subscribe']) && !empty($data['is_subscribe']) && $fansdata['is_subscribe']=$data['is_subscribe'];
					   empty($fanTmp['sex']) && $fansdata['sex']=$data['sex'];
					   empty($fanTmp['province']) && $fansdata['province']=$data['province'];
					   empty($fanTmp['city']) && $fansdata['city']=$data['city'];
					   $fansdata['country']='中国';
					   $fansDb->update($fansdata, array('id' => $fanTmp['id']));
					}else{
					   $totalfee=$data['goods_price']*100;
					   $fansdata=array('mid'=>$info['mid'],'totalfee'=>$totalfee);
					   $fansdata['openid']=$data['openid'];
					   $fansdata['is_subscribe']=$data['is_subscribe'];
					   $fansdata['nickname']=$data['nickname'];
					   $fansdata['sex']=$data['sex'];
					   $fansdata['province']=$data['province'];
					   $fansdata['city']=$data['city'];
					   $fansdata['country']='中国';
					   $fansdata['headimgurl']=$data['headimgurl'];
					   $fansDb->insert($fansdata,1);
					}
					unset($fansdata,$data);
					$error = $this->_status[0];
				}else{
					$error = $this->_status[1003];
				}
			}else{
				$error = $this->_status[1001];
			}
		}else{
			$error = $this->_status[1000];
		}
		$this->dexit($error);
	}
	private function checkFansInfo($openid,$mid){
		$fansDb = M('cashier_Fans');
		$fans = $fansDb->get_one(array('openid'=>$openid,'mid'=>$mid));
		if(!$fans){
			$url = $this->_path.'/index.php?g=Home&m=ShouYin&a=fansSync';  //请对接项目者修改为项目对接接口地址
			$data['openid'] = $openid;
			$data['sign'] = $this->_getSign($data);
			$info = json_decode($this->_post($url,$data),'true');
			if($info['error'] == 0){
				$this->_add($fansDb,$info['data']);				
			}
		}
		return $fans;
	}
	public function loginSigns(){
		if(IS_POST){
			$data = $this->clear_html($_POST);
			if($this->_signVeryfy($data)){
				$info = $this->_checkIdentifier();
				$this->_merchants->update($data,array('mid'=>$info['mid']));
				
				$code = code(http_build_query(array('mid'=>$info['mid'],'login'=>1,'time'=>SYS_TIME)),'encode',$this->_salt);
				$error = array_merge($this->_status[0],array('code'=>$code));
			}else{
				$error = $this->_status[1001];
			}
		}else{
			$error = $this->_status[1000];
		}
		$this->dexit($error);
	}
	public function login(){
		if(IS_GET){
			$data = $this->clear_html($_GET);
			if(isset($data['code'])){
				$info = $this->_checkIdentifier($data['code']);
				$_SESSION['employer']=null;
				$_SESSION['merchant']['mid'] = $info['mid'];
				header('Location:/merchants.php?m=User&c=index&a=index');
			}else{
				echo '参数错误';
			}
		}
	}
	private function _checkIdentifier($code=''){
		if(!empty($code)){
			$code=base64_decode($code);
			$code=Encryptioncode($code,'DECODE');
			$data=json_decode($code,true);
			if(empty($data)){
				$this->errorTip($this->_status[1002]['message'], $_SERVER['HTTP_REFERER']);exit;
			}elseif($data['mktime']+$this->_exist < SYS_TIME){
				$this->errorTip($this->_status[1002]['message'], $_SERVER['HTTP_REFERER']);exit;
			}else{
				if($data=$this->_merchants->get_one(array('mid'=>$data['mid']),'*')){
					if(($data['lastLoginTime']+$this->_exist < SYS_TIME)){
					    $this->errorTip($this->_status[1002]['message'], $_SERVER['HTTP_REFERER']);exit;
					}else{
					   $this->_merchants->update(array('lastLoginTime'=>SYS_TIME), array('mid' => $data['mid']));
					   return $data;
					}
				}else{
					$this->errorTip($this->_status[1004]['message'], $_SERVER['HTTP_REFERER']);exit;
				}
			}
		}else{
			$this->errorTip($this->_status[1002]['message'], $_SERVER['HTTP_REFERER']);exit;
		}
	}
	private function _checkUser($data){
		$source = $this->_typeConvert($data['source']);
		$NsourceArray=array_flip($this->_sourceArray);
		//$username = $data['account'].'_'.$NsourceArray[$source];/***chen zong yao qiu yao gai***/
		$username = $data['account'];
		if(!empty($data['weixin']) && (strlen($data['weixin']) < strlen($data['account']))){
		    $username=$data['weixin'];
		}
		$thirduserid=trim($data['userid']);
		$user = $this->_merchants->get_one(array('thirduserid' => $thirduserid,'source'=>$source),'mid');
		if(!empty($user)){
			$mid =$user['mid'];
			$this->_merchants->update(array('lastLoginTime'=>SYS_TIME), array('mid' => $mid));
		}else{
			$password=md5($thirduserid.'@me');
			$num=rand(1,25);
			$username=$username.substr($password,$num,2);
			$password=substr($password,2,8).'cf'.$source;

			$logo=$data['logo'];
			if(strpos($logo,"http:")===false && strpos($logo,"https:")===false){
			   $logo='http://'.$data['domain'].ltrim($data['logo'],'.');
			}
			$data = array(
				'username' => $username,
				'password' => $this->toPassword($password,$this->_salt),
				'thirduserid'=>$thirduserid,
				'wxname'=>$data['username'],
				'weixin'=>$data['weixin'],
				'logo'=>!empty($logo) ? $logo :'',
				'email'=>!empty($data['email']) ? $data['email'] :'',
				'salt' => $this->_salt,
				'source' => $source,
				'regTime' => SYS_TIME,
				'lastLoginTime'=>SYS_TIME,
				'regIp' => ip2long(ip())
			);
			$mid = $this->_merchants->insert($data,1);
		}
		return $mid;
	}
	private function _typeConvert($data){
		$data = is_numeric($data) ? $data : $this->_sourceArray[strtolower($data)];
		return $data;
	}
	private function _signVeryfy(&$data){
		$sign = $data['sign'];
		unset($data['sign']);
		if($this->_getSign($data) == $sign){
			return true;
		}else{
			return false;
		}
	}
	private function _getSign($data) {
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$validate[$key] = $this->_getSign($value);
			} else {
				$validate[$key] = $value;
			}			
		}
		$validate['salt'] = $this->_salt;
		sort($validate, SORT_STRING);
		return sha1(implode($validate));
	}
	private function _post($url,$data){
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		 curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$info = curl_exec($curl); // 执行操作
		if (curl_errno($curl)) {
			echo 'Errno'.curl_error($curl);
		}
		curl_close($curl); // 关键CURL会话
		return $info; // 返回数据
	}
}

?>