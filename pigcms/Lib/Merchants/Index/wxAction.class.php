<?php

bpBase::loadAppClass('base', '', 0);

class wxAction_controller extends base_controller {

    private $wxToken = '';
	private $mid=0;
    private $nonce = '';
    private $sTimeStamp = '';
    private $msg_signature = '';
	private $merData = '';

    public function __construct() {
        $this->wxToken = 'LHSistestwxToken';
		$this->mid=isset($_GET['mymid']) ? intval($_GET['mymid']) :0;
		if(!($this->mid > 0)){
		    exit('Missing parameter mymid OR the value of parameter mymid is unavailable!');
		}else{
		   $this->merData = M('cashier_merchants')->get_one(array('mid'=>$this->mid));
		   if(empty($this->merData))  exit('User does not exist!');
		   $this->wxToken=$this->merData['wxtoken'];
		}
        $this->nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
        $this->sTimeStamp = isset($_REQUEST['timestamp']) ? $_REQUEST['timestamp'] : time();
        $this->msg_signature = isset($_REQUEST['msg_signature']) ? $_REQUEST['msg_signature'] : '';
    }

    public function index() {
        if (IS_GET && isset($_GET['echostr'])) {
            $this->valid();
        } else {
            $this->responseMsg();
        }
    }

    public function valid() {
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature()) {
            echo $echoStr;
            exit();
        }
        exit();
    }

    private function checkSignature() {
        $signature = $_GET["signature"];
        $tmpArr = array($this->wxToken, $this->sTimeStamp, $this->nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if (trim($tmpStr) == trim($signature)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 	作用：将xml转为array
     */
    private function xmlToArray($xml) {
        //将XML转为array
        //禁止引用外部xml实体
        // libxml_disable_entity_loader(true);
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if (is_array($array_data) && !empty($array_data)) {
            foreach ($array_data as $kk => $vv) {
                if (is_array($vv)) {
                    $array_data[$kk] = !empty($vv) ? $vv : '';
                } else {
                    $array_data[$kk] = trim($vv);
                }
            }
            return $array_data;
        }
        return false;
    }

    public function responseMsg() {
        //$xmlStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $xmlStr = file_get_contents("php://input");
         /*if (empty($xmlStr)) {
          $xmlStr = '<xml> <ToUserName><![CDATA[mmmmmmm1123f]]></ToUserName>
          <FromUserName><![CDATA[fewtesGFFdsgsdgsdgdg]]></FromUserName>
          <CreateTime>123456789</CreateTime>
          <MsgType><![CDATA[event]]></MsgType>
          <Event><![CDATA[card_pass_check]]></Event>  //不通过为card_not_pass_check
          <CardId><![CDATA[pZrMmsyoBkRf57wndR9PPXumGa_4]]></CardId>
          </xml>';
          }*/
        //$logpath = './pay/wxpay/barpay/logs/wxAction.log';
        //file_put_contents($logpath, $xmlStr . "\n\n", FILE_APPEND);
        if (!empty($xmlStr)) {
            $xmlData = $this->xmlToArray($xmlStr);
            if (is_array($xmlData) && !empty($xmlData)) {
                $MsgType = strtolower($xmlData['MsgType']);
                if ($MsgType == 'event') {
                    $eventVarr = array('card_pass_check', 'card_not_pass_check', 'user_get_card', 'user_del_card', 'user_consume_card', 'user_view_card');
                    $eventV = isset($xmlData['Event']) ? $xmlData['Event'] : '';
                    if ($eventV == 'card_pass_check' || $eventV == 'card_not_pass_check') {
                        $wxcouponDb = M('cashier_wxcoupon');
                        $is_pass_check = 0;/**                         * 0审核中，1审核通过2审核不通过** */
                        if ($eventV == 'card_pass_check')
                            $is_pass_check = 1;
                        if ($eventV == 'card_not_pass_check')
                            $is_pass_check = 2;
                        if ($is_pass_check > 0) {
                            $wxcouponDb->update(array('status' => $is_pass_check, 'checktime' => time()), array('card_id' => $xmlData['CardId'],'mid'=>$this->mid));
                        }
                    } elseif ($eventV == 'user_get_card') {
                        $wxcouponDb = M('cashier_wxcoupon');
                        $wherearr = array('card_id' => $xmlData['CardId'],'mid'=>$this->mid);
                        isset($xmlData['OuterId']) && !empty($xmlData['OuterId']) && $wherearr['mid'] = $xmlData['OuterId'];
                        $wx_coupon = $wxcouponDb->get_one($wherearr, '*');
                        $cardtype = 0;
                        $outerid = $xmlData['OuterId'];
                        $cardtitle = '';
                        if (!empty($wx_coupon)) {
                            $cardtype = $wx_coupon['card_type'];
                            $outerid = $wx_coupon['mid'];
                            $cardtitle = $wx_coupon['card_title'];
                            $receivenum = $wx_coupon['receivenum'] + 1;
                            $wxcouponDb->update(array('receivenum' => $receivenum), array('id' => $wx_coupon['id']));
                        }
                        $insertData = array('openid' => $xmlData['FromUserName'],
                            'give_openId' => isset($xmlData['FromUserName']) ? $xmlData['FromUserName'] : '',
                            'cardid' => $xmlData['CardId'], 'cardtype' => $cardtype, 'cardtitle' => $cardtitle, 'isgivebyfriend' => $xmlData['IsGiveByFriend'], 'cardcode' => $xmlData['UserCardCode'], 'oldcardcode' => $xmlData['OldUserCardCode'], 'outerid' => $outerid, 'addtime' => time());
                        M('cashier_wxcoupon_receive')->insert($insertData, True);
                        
						$fansDb = M('cashier_fans');/***加入粉丝表***/
						$tmpfans = $fansDb->get_one(array('mid'=>$wx_coupon['mid'],'openid'=>$xmlData['FromUserName']), '*');
						if(empty($tmpfans)){
							$wx_user = M('cashier_payconfig')->getwxuserConf($wx_coupon['mid']);
							
							bpBase::loadOrg('wxCardPack');
							$wxCardPack = new wxCardPack($wx_user, $wx_coupon['mid']);
							$access_token = $wxCardPack->getToken();
							$wxuserinfo = $wxCardPack->GetwxUserInfoByOpenid($access_token, $xmlData['FromUserName']);
							$fansData = array('mid' => $wx_coupon['mid'], 'openid' => $xmlData['FromUserName']);
							if (isset($wxuserinfo['nickname'])) {
								$fansData['nickname'] = $wxuserinfo['nickname'];
								$fansData['sex'] = $wxuserinfo['sex'];
								$fansData['province'] = $wxuserinfo['province'];
								$fansData['city'] = $wxuserinfo['city'];
								$fansData['country'] = $wxuserinfo['country'];
								$fansData['headimgurl'] = $wxuserinfo['headimgurl'];
								$fansData['groupid'] = $wxuserinfo['groupid'];
							}
							$fansDb->insert($fansData, True);
						}
                    } elseif ($eventV == 'user_del_card') {
                        /** 用户删除* */
                        M('cashier_wxcoupon_receive')->update(array('isdel' => 1, 'deltime' => time()), array('cardid' => $xmlData['CardId'], 'openid' => $xmlData['FromUserName'], 'cardcode' => $xmlData['UserCardCode']));
                    } elseif ($eventV == 'user_consume_card') {
                        /*                         * 核销* */
                        $wxcouponDb = M('cashier_wxcoupon');
                        $wherearr = array('card_id' => $xmlData['CardId'],'mid'=>$this->mid);
                        $wx_coupon = $wxcouponDb->get_one($wherearr, '*');
                        if (!empty($wx_coupon)) {
                            $consumenum = $wx_coupon['consumenum'] + 1;
                            $wxcouponDb->update(array('consumenum' => $consumenum), array('id' => $wx_coupon['id']));
                        }
                        M('cashier_wxcoupon_receive')->update(array('status' => 1, 'consumetime' => time(), 'consumesource' => isset($xmlData['ConsumeSource']) ? $xmlData['ConsumeSource'] : ''), array('cardid' => $xmlData['CardId'], 'openid' => $xmlData['FromUserName'], 'cardcode' => $xmlData['UserCardCode']));
                    } elseif ($eventV == 'need_push_on_view') {
                        /*                         * * 进入会员卡事件推送**暂时没用** */
                    } elseif ($eventV == 'user_enter_session_from_card') {
                        /*                         * * 从卡券进入公众号会话事件推送**暂时没用** */
                    }
                } elseif ($MsgType == 'text') {

                } elseif ($eventV == 'user_pay_from_pay_cell')  {
                    
                }
            } else {
                $this->replywx();
            }
            $this->replywx();
        } else {
            $this->replywx();
        }
    }

    public function replywx($data = '') {
        if (empty($data)) {
            echo "";
            exit();
        } else {
            /* $time = time();
			  $textTpl = "<xml>
			  <ToUserName><![CDATA[%s]]></ToUserName>
			  <FromUserName><![CDATA[%s]]></FromUserName>
			  <CreateTime>%s</CreateTime>
			  <MsgType><![CDATA[%s]]></MsgType>
			  <Content><![CDATA[%s]]></Content>
			  <FuncFlag>0</FuncFlag>
			  </xml>";
			  if ($keyword == "?" || $keyword == "？") {
			  $msgType = "text";
			  $contentStr = date("Y-m-d H:i:s", time());
			  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			  echo $resultStr;
             } */
        }
    }

}

?>