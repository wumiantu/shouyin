<?php
	defined('IN_BACKGROUND') or exit('No permission');
	bpBase::loadAppClass('base','',0);
	class common_controller extends base_controller{
		protected $merchant = array();
		protected $employer = array();
		protected $mid;
		public function __construct(){
			parent::__construct();
			$session_storage = getSessionStorageType();
			bpBase::loadSysClass($session_storage);
			$isLogin = 0;
			if(isset($_SESSION['merchant']['mid']) || !empty($_SESSION['merchant']['mid'])){
				$isLogin = 1;
				$this->merchant = M('cashier_merchants')->get_one(array('mid'=>$_SESSION['merchant']['mid']));
				$this->mid = $this->merchant['mid'];
			}elseif(isset($_SESSION['employer']['eid']) || !empty($_SESSION['employer']['eid'])){
				$isLogin = 1;
				$this->employer = M('cashier_employee')->get_one(array('eid'=>$_SESSION['employer']['eid']));
				$this->merchant = M('cashier_merchants')->get_one(array('mid'=>$this->employer['mid']));
				$this->mid = $this->employer['mid'];
			}
			if($isLogin == 0){
				header('Location:merchants.php?m=Index&c=login&a=index');exit;
			}elseif(!$this->merchant && !$this->employer){
				$this->errorTip('账号异常，请重新登录！', '/merchants.php?m=Index&c=login&a=index');exit;
			}
		}
		protected function authorityControl($data = array()){
			$eid=0;
			isset($_SESSION['employer']) && !empty($_SESSION['employer']) && isset($_SESSION['employer']['eid']) && !empty($_SESSION['employer']['eid']) && $eid=intval($_SESSION['employer']['eid']);

			if(($eid>0) && !in_array(ROUTE_ACTION,$data)){
				if(!$this->authority($this->employer['authority'])){
					if(isAjax()){
						exit(json_encode(array('status'=>0,'error'=>1,'msg'=>'您没有权限访问！')));
					}else{
						$this->errorTip('您没有权限访问！');
					}
				}
			}
			return true;
		}
	}
?>