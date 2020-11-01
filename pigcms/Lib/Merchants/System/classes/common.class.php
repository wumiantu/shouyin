<?php
	defined('IN_BACKGROUND') or exit('No permission');
	bpBase::loadAppClass('smarty','',0);
	class common_controller extends smarty_controller{
		protected $isLogin = 0;
		protected $adminuser = array();
		protected $tablepre='';
		protected $_mid=0;
		protected $_uid=0;
		public function __construct(){
			parent::__construct();
			$session_storage = getSessionStorageType();
			bpBase::loadSysClass($session_storage);
			$this->adminuser=unserialize($_SESSION['adminuser']);
			if(!$this->adminuser || !is_array($this->adminuser) || !($this->adminuser['uid'] >0)){
			  if(!in_array(ROUTE_ACTION,array('login','logout'))){
			     header('Location:/merchants.php?m=System&c=index&a=login');exit;
			  }
			}
			$db_config=loadConfig('db');
			$this->tablepre=$db_config['default']['tablepre'];
			unset($db_config);
			$this->_mid=!empty($this->adminuser) ? $this->adminuser['mid']:0;
			$this->_uid=!empty($this->adminuser) ? $this->adminuser['uid']:0;
			$this->assign('adminuser',$this->adminuser);
			$this->assign('_mid',$this->_mid);
			$this->assign('_uid',$this->_uid);
		}
	}
?>