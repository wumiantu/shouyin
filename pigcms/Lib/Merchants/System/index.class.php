<?php

bpBase::loadAppClass('common', 'System', 0);

class index_controller extends common_controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        header('location:?m=System&c=index&a=merLists');
    }

    public function ModifyPwd() {

        $this->display();
    }

    /*     * **平台商家列表*** */

    public function merLists() {
        bpBase::loadOrg('common_page');
        $merchantsDb = M('cashier_merchants');
        $_count = $merchantsDb->count();
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $sqlStr = 'SELECT DISTINCT mer.mid,mer.*,pcf.configData FROM ' . $this->tablepre . 'cashier_merchants as mer LEFT JOIN ' . $this->tablepre . 'cashier_payconfig AS pcf ON mer.mid=pcf.mid  ORDER BY mer.mid DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
        $sqlObj = new model();
        $merInfo = $sqlObj->selectBySql($sqlStr);
        foreach ($merInfo as $kk => $vv) {
            $merInfo[$kk]['configData'] = !empty($vv['configData']) ? unserialize(htmlspecialchars_decode($vv['configData'], ENT_QUOTES)) : '';
        }
        $this->assign('pagebar', $pagebar);
        $this->assign('merInfo', $merInfo);

        $this->display();
    }

	/***特约商家支付列表****/
	public function affiliatepay(){
	    bpBase::loadOrg('common_page');
        $orderDb = M('cashier_order');
		$mid=intval($_GET['mid']);
		$where=array('pmid'=>$this->adminuser['mid'],'ispay'=>1);
		$mid>0 && $where['mid']=$mid;
        $_count = $orderDb->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
		$merOderInfo = $orderDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC'); 
		$merchants = M('cashier_merchants')->select(array('isadmin'=>'0'), 'mid,username,wxname','', 'mid DESC');
		$merInfos=array();
		if(!empty($merchants)){
		   foreach($merchants as $mvv){
		     $merInfos[$mvv['mid']]=$mvv;
		   }
		}
		if(!empty($merOderInfo)){
		  foreach($merOderInfo as $okk=>$ovv){
		      $merOderInfo[$okk]['merwxname']=$merInfos[$ovv['mid']]['wxname'];
			  $merOderInfo[$okk]['username']=$merInfos[$ovv['mid']]['username'];
			  if(!empty($ovv['truename'])){
			    $merOderInfo[$okk]['payneme']=$ovv['truename'];
			  }elseif(!empty($ovv['openid'])){
			    $merOderInfo[$okk]['payneme']=$ovv['openid'];
			  }elseif(!empty($ovv['p_openid'])){
			    $merOderInfo[$okk]['payneme']=$ovv['p_openid'];
			  }else{
			    $merOderInfo[$okk]['payneme']='未知';
			  }
			  $merOderInfo[$okk]['paytimestr']=$ovv['paytime'] > 0 ? date('Y-m-d H:i:s',$ovv['paytime']) :date('Y-m-d H:i:s',$ovv['add_time']);

			if ($ovv['refund'] == 1) {
			  $merOderInfo[$okk]['refundstr'] = '退款中...';
			} elseif ($ovv['refund'] == 2) {
				$merOderInfo[$okk]['refundstr'] = '已退款';
			} elseif ($ovv['refund'] == 3) {
				$merOderInfo[$okk]['refundstr'] = '退款失败';
			} else {
				$merOderInfo[$okk]['refundstr'] = '未退款';
			}
		  }
		}
		unset($merInfos);
		$this->assign('pagebar', $pagebar);
        $this->assign('merOderInfo', $merOderInfo);
		$this->display();
	}
	/***修改商家名称****/
	public function mdfyName(){
		$postdata=$this->clear_html($_POST);
	    $mid=intval($postdata['mid']);
		$wxname=$postdata['wxname'];
		if(($mid>0) && !empty($wxname)){
		     if(M('cashier_merchants')->update(array('wxname' => $wxname), array('mid' => $mid))){
			   $this->dexit(array('error'=>0));
			 }
		}
	   $this->dexit(array('error'=>1));
	} 
    public function affiliate() {
        $sqlStr = 'SELECT DISTINCT mer.mid,mer.username,mer.wxname,pcf.configData,pcf.proxymid,pcf.wxsubmchid FROM ' . $this->tablepre . 'cashier_merchants as mer LEFT JOIN ' . $this->tablepre . 'cashier_payconfig AS pcf ON mer.mid=pcf.mid where mer.isadmin !="1" and pcf.configData !="" ORDER BY mer.mid DESC';
        $merchantsDb = M('cashier_payconfig');
        $sqlObj = new model();
        $merInfo = $sqlObj->selectBySql($sqlStr);
        if ($merInfo) {
            foreach ($merInfo as $kk => $vv) {
                if (!empty($vv['configData'])) {
                    $tmpcfg = unserialize(htmlspecialchars_decode($vv['configData'], ENT_QUOTES));
                    if ($tmpcfg && isset($tmpcfg['weixin']) && !empty($tmpcfg['weixin']['appid']) && !empty($tmpcfg['weixin']['mchid'])) {
                        $merInfo[$kk]['wx_appid'] = $tmpcfg['weixin']['appid'];
                        $merInfo[$kk]['wx_mchid'] = $tmpcfg['weixin']['mchid'];
                        $merInfo[$kk]['wx_key'] = $tmpcfg['weixin']['key'];
                        $merInfo[$kk]['wx_appSecret'] = $tmpcfg['weixin']['appSecret'];
                        unset($merInfo[$kk]['configData']);
                    } else {
                        unset($merInfo[$kk]);
                    }
                }
            }
        }
		$payConfig = M('cashier_payconfig')->get_one(array('mid' => $this->_mid), 'id,isOpen,configData');
		$sub_mchidarr=array();
        if ($payConfig) {
            if ($payConfig['configData']) {
                $payConfigdata = unserialize(htmlspecialchars_decode($payConfig['configData'],ENT_QUOTES));
				$sub_mchid= isset($payConfigdata['weixin']['sub_mchid']) ? urldecode($payConfigdata['weixin']['sub_mchid']):'';
				$sub_mchidarr=!empty($sub_mchid) ? explode(',',$sub_mchid):false;
				unset($payConfig);
            }
        } 
        $this->assign('merInfo', $merInfo);
		$this->assign('sub_mchidarr', $sub_mchidarr);
        $this->display();
    }

    public function doModifyPwd() {
        $oldpwd = trim($_POST['oldpwd']);
        $newpwd = trim($_POST['newpwd']);
        $new2pwd = trim($_POST['new2pwd']);
        if (empty($oldpwd)) {
            $this->errorTip('旧密码不能为空！');
            exit;
        }
        if (empty($newpwd)) {
            $this->errorTip('新密码不能为空！');
            exit;
        }
        if ($newpwd != $new2pwd) {
            $this->errorTip('两次输入的密码不一致！');
            exit;
        }
        $oldpwd = $this->toPassword($oldpwd, $this->adminuser['salt']);
        if ($oldpwd != $this->adminuser['pwd']) {
            $this->errorTip('旧密码不对！');
            exit;
        }
        $newpwdstr = $this->toPassword($newpwd, $this->adminuser['salt']);
        $flage = M('cashier_adminuser')->update(array('pwd' => $newpwdstr), array('uid' => $this->adminuser['uid']));
        if ($flage) {
            $this->successTip('修改成功，请重新登录！', '/merchants.php?m=System&c=index&a=logout');
            exit;
        } else {
            $this->errorTip('密码修改失败！');
            exit;
        }
    }

    public function login() {
		if(IS_POST){
		   $username=$this->clear_html($_POST['username']);
		   $password=$this->clear_html($_POST['password']);
		   if(empty($username)) $this->errorTip('用户名不能为空！');
		   if(empty($password)) $this->errorTip('密码不能为空！');
		   $adminuserDb=M('cashier_adminuser');
		   $tmpU=$adminuserDb->get_one(array('account'=>$username),'*');
		   if(empty($tmpU)) $this->errorTip('用户不存在！');
		   $password=$this->toPassword($password, $tmpU['salt']);
		   if($password != $tmpU['pwd'])$this->errorTip('密码错误！');
		   $_SESSION['adminuser'] = serialize($tmpU);
		   $adminuserDb->update(array('lastlogintime' => SYS_TIME), array('uid' => $tmpU['uid']));
		   $this->successTip('登录成功！', '/merchants.php?m=System&c=index&a=merLists');
		   exit;
		}
	   $this->display();
    }
    public function logout() {
        $_SESSION['adminuser'] = null;
        unset($_SESSION['adminuser']);
        header('Location:?m=System&c=index&a=login');
    }

}

?>