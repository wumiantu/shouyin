<?php
bpBase::loadAppClass('base', '', 0);
class login_controller extends base_controller {
	public $merchants;
	public $employees;
	public function __construct(){
		parent::__construct();
		$this->merchants = M('cashier_merchants');
		$this->employee = M('cashier_employee');
	}
	public function index() {
		$ltyp=isset($_GET['ltyp']) ? intval($_GET['ltyp']) :0;
    	include $this->showTpl();
    }
	public function register(){
		include $this->showTpl();
	}
	public function signin(){
		if(IS_POST){
			$data = $this->clear_html($_POST);
			if($data['type'] == 'merchant'){
				$user = $this->merchants->get_one(array('username'=>$data['username']));
			}elseif($data['type'] == 'employee'){
				$user = $this->employee->get_one(array('account'=>$data['username']));
			}
			
			if(!$user){
				$this->errorTip('用户名不存在！', $_SERVER['HTTP_REFERER']);exit;
			}
			if($this->toPassword($data['password'],$user['salt']) != $user['password']){
				$this->errorTip('密码错误！', $_SERVER['HTTP_REFERER']);exit;
			}
			if($user['status'] == 0){
				$this->errorTip('该账户暂时被禁止登录！', $_SERVER['HTTP_REFERER']);exit;
			}
			$_SESSION['employer']=null;
			$_SESSION['merchant']=null;
			unset($_SESSION['employer'],$_SESSION['merchant']);
			$session_storage = getSessionStorageType();
			bpBase::loadSysClass($session_storage);
			if($data['type'] == 'merchant'){
				$_SESSION['merchant']['mid'] = $user['mid'];
			}elseif($data['type'] == 'employee'){
				$_SESSION['employer']['eid'] = $user['eid'];
			}
			$this->successTip('登录成功！', '/merchants.php?m=User&c=index&a=index');exit;
		}
	}
	public function signed(){
		if(IS_POST){
			$data = $this->clear_html($_POST);
			$merchants = $this->merchants->get_one("username='".$data['username']."' OR email='".$data['email']."'");
			if($merchants){
				if($merchants['username'] == $data['username']){
					$this->errorTip('用户名已存在！', $_SERVER['HTTP_REFERER']);exit;
				}elseif($merchants['email'] == $data['email']){
					$this->errorTip('邮箱已存在！', $_SERVER['HTTP_REFERER']);exit;
				}
			}
			if($data['agree'] != 1){
				$this->errorTip('请先同意使用条款！', $_SERVER['HTTP_REFERER']);exit;
			}
			unset($data['agree']);
			$_SESSION['merchant']=null;
			$data['salt'] = mt_rand(111111,999999);
			$data['password'] = $this->toPassword($data['password'],$data['salt']);
			$data['lastLoginTime'] = $data['regTime'] = SYS_TIME;
			$data['lastLoginIp'] = $data['regIp'] = ip2long(ip());
			if($vo = $this->merchants->insert($data,1)){
				$session_storage = getSessionStorageType();
				bpBase::loadSysClass($session_storage);
	
				$_SESSION['merchant']['mid'] = $vo;
				$this->successTip('注册成功！', '/merchants.php?m=User&c=index&a=index');exit;
			}else{
				$this->errorTip('注册失败！', $_SERVER['HTTP_REFERER']);exit;
			}
		}
	}
}

?>