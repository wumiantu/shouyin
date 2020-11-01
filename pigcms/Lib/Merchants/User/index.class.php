<?php
bpBase::loadAppClass('common','User',0);
class index_controller extends common_controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		include $this->showTpl();
	}

	public function ModifyPwd(){

		include $this->showTpl();
	}

	public function doModifyPwd(){
		$oldpwd=trim($_POST['oldpwd']);
		$newpwd=trim($_POST['newpwd']);
		$new2pwd=trim($_POST['new2pwd']);
		if(empty($oldpwd)){
		   $this->errorTip('旧密码不能为空！');exit;
		}
		if(empty($newpwd)){
		   $this->errorTip('新密码不能为空！');exit;
		}
		if($newpwd != $new2pwd){
		   $this->errorTip('两次输入的密码不一致！');exit;
		}
		$oldpwd=$this->toPassword($oldpwd,$this->merchant['salt']);
		if($oldpwd != $this->merchant['password']){
		     $this->errorTip('旧密码不对！');exit;
		} 
		$newpwdstr=$this->toPassword($newpwd,$this->merchant['salt']);
		$flage=M('cashier_merchants')->update(array('password'=>$newpwdstr,'mfypwd'=>1),array('mid'=>$this->merchant['mid']));
		if($flage){
		   $this->successTip('修改成功，请重新登录！','/merchants.php?m=User&c=index&a=logout');exit;
		}else{
		   $this->errorTip('密码修改失败！');exit;
		}
	}

	public function logout(){
		$_SESSION['merchant'] =null;
		unset($_SESSION['merchant']);
		$_SESSION['employer'] = null;
		unset($_SESSION['employer']);
		$_SESSION['wxshoplist']=null;
		unset($_SESSION['wxshoplist']);
		header('Location:?m=Index&c=login&a=index');
	}
}
?>