<?php
    /********************************************************
     *      @author Kyler You <QQ:2444756311>
     *      @link http://mp.weixin.qq.com/wiki/home/index.html
     *      @version 2.0.1
     *      @uses $wxApi = new WxApi();
     *      @package 微信API接口 陆续会继续进行更新
     ********************************************************/
 
    class WxApi {
        const appId         = "";
        const appSecret     = "";
        const mchid         = ""; //商户号
        const privatekey    = ""; //私钥
        public $parameters  = array();
        public $jsApiTicket = NULL;
        public $jsApiTime   = NULL;
 
        public function __construct(){
 
        }
 
        /****************************************************
         *  微信提交API方法，返回微信指定JSON
         ****************************************************/
 
        public function wxHttpsRequest($url,$data = null){
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                if (!empty($data)){
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($curl);
                curl_close($curl);
                return $output;
        }
 
        /****************************************************
         *  微信带证书提交数据 - 微信红包使用
         ****************************************************/
 
        public function wxHttpsRequestPem($url, $vars, $second=30,$aHeader=array()){
                $ch = curl_init();
                //超时时间
                curl_setopt($ch,CURLOPT_TIMEOUT,$second);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
                //这里设置代理，如果有的话
                //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
                //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
 
                //以下两种方式需选择一种
 
                //第一种方法，cert 与 key 分别属于两个.pem文件
                //默认格式为PEM，可以注释
                curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
                curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/apiclient_cert.pem');
                //默认格式为PEM，可以注释
                curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
                curl_setopt($ch,CURLOPT_SSLKEY,getcwd().'/apiclient_key.pem');
 
                curl_setopt($ch,CURLOPT_CAINFO,'PEM');
                curl_setopt($ch,CURLOPT_CAINFO,getcwd().'/rootca.pem');
 
                //第二种方式，两个文件合成一个.pem文件
                //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
 
                if( count($aHeader) >= 1 ){
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
                }
 
                curl_setopt($ch,CURLOPT_POST, 1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
                $data = curl_exec($ch);
                if($data){
                        curl_close($ch);
                        return $data;
                }
                else { 
                        $error = curl_errno($ch);
                        echo "call faild, errorCode:$error\n"; 
                        curl_close($ch);
                        return false;
                }
        }
 
        /****************************************************
         *  微信获取AccessToken 返回指定微信公众号的at信息
         ****************************************************/
 
        public function wxAccessToken($appId = NULL , $appSecret = NULL){
                $appId          = is_null($appId) ? self::appId : $appId;
                $appSecret      = is_null($appSecret) ? self::appSecret : $appSecret;
                 
                $url            = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
                $result         = $this->wxHttpsRequest($url);
                //print_r($result);
                $jsoninfo       = json_decode($result, true);
                $access_token   = $jsoninfo["access_token"];
                 
                return $access_token;
        }
 
        /****************************************************
         *  微信获取ApiTicket 返回指定微信公众号的at信息
         ****************************************************/
 
        public function wxJsApiTicket($appId = NULL , $appSecret = NULL){
                $appId          = is_null($appId) ? self::appId : $appId;
                $appSecret      = is_null($appSecret) ? self::appSecret : $appSecret;
                 
                $url            = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$this->wxAccessToken();
                $result         = $this->wxHttpsRequest($url);
                $jsoninfo       = json_decode($result, true);
                $ticket         = $jsoninfo['ticket'];
                //echo $ticket . "<br />";
                return $ticket;
        }
         
        public function wxVerifyJsApiTicket($appId = NULL , $appSecret = NULL){
            if(!empty($this->jsApiTime) && intval($this->jsApiTime) > time() && !empty($this->jsApiTicket)){
                $ticket = $this->jsApiTicket;
            }
            else{
                $ticket = $this->wxJsApiTicket($appId,$appSecret);
                $this->jsApiTicket = $ticket;
                $this->jsApiTime = time() + 7200;
            }
            return $ticket;
        }
         
        /****************************************************
         *  微信通过OPENID获取用户信息，返回数组
         ****************************************************/
 
        public function wxGetUser($openId){
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$wxAccessToken."&openid=".$openId."&lang=zh_CN";
            $result         = $this->wxHttpsRequest($url);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;
        }        
 
        /****************************************************
         *  微信生成二维码ticket
         ****************************************************/
 
        public function wxQrCodeTicket($jsonData){
            $wxAccessToken  = $this->wxAccessToken();
            $url        = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            return $result;
        }
         
        /****************************************************
         *  微信通过ticket生成二维码
         ****************************************************/
        public function wxQrCode($ticket){
            $url    = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
            return $url;
        }
 
        /****************************************************
         *      发送自定义的模板消息
         ****************************************************/
 
        public function wxSetSend($touser, $template_id, $url, $data, $topcolor = '#7B68EE'){
                $template = array(
                        'touser' => $touser,
                        'template_id' => $template_id,
                        'url' => $url,
                        'topcolor' => $topcolor,
                        'data' => $data
                );
                $jsonData = json_encode($template);
                $result = $this->wxSendTemplate($jsonData);
                return $result;
        }
 
        /****************************************************
         *  微信设置OAUTH跳转URL，返回字符串信息 - SCOPE = snsapi_base //验证时不返回确认页面，只能获取OPENID
         ****************************************************/
 
        public function wxOauthBase($redirectUrl,$state = "",$appId = NULL){
                $appId          = is_null($appId) ? self::appId : $appId;
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=".$state."#wechat_redirect";
                return $url;
        }
 
        /****************************************************
         *  微信设置OAUTH跳转URL，返回字符串信息 - SCOPE = snsapi_userinfo //获取用户完整信息
         ****************************************************/
 
        public function wxOauthUserinfo($redirectUrl,$state = "",$appId = NULL){
                $appId          = is_null($appId) ? self::appId : $appId;
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_userinfo&state=".$state."#wechat_redirect";
                return $url;
        }
 
        /****************************************************
         *  微信OAUTH跳转指定URL
         ****************************************************/
 
        public function wxHeader($url){
                header("location:".$url);
        }
 
        /****************************************************
         *  微信通过OAUTH返回页面中获取AT信息
         ****************************************************/
 
        public function wxOauthAccessToken($code,$appId = NULL , $appSecret = NULL){
                $appId          = is_null($appId) ? self::appId : $appId;
                $appSecret      = is_null($appSecret) ? self::appSecret : $appSecret;
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appId."&secret=".$appSecret."&code=".$code."&grant_type=authorization_code";
                $result         = $this->wxHttpsRequest($url);
                //print_r($result);
                $jsoninfo       = json_decode($result, true);
                //$access_token     = $jsoninfo["access_token"];
                return $jsoninfo;           
        }
 
        /****************************************************
         *  微信通过OAUTH的Access_Token的信息获取当前用户信息 // 只执行在snsapi_userinfo模式运行
         ****************************************************/
 
        public function wxOauthUser($OauthAT,$openId){
                $url            = "https://api.weixin.qq.com/sns/userinfo?access_token=".$OauthAT."&openid=".$openId."&lang=zh_CN";
                $result         = $this->wxHttpsRequest($url);
                $jsoninfo       = json_decode($result, true);
                return $jsoninfo;           
        }
         
        /*****************************************************
         *      生成随机字符串 - 最长为32位字符串
         *****************************************************/
        public function wxNonceStr($length = 16, $type = FALSE) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $str = "";
            for ($i = 0; $i < $length; $i++) {
              $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            }
            if($type == TRUE){
                return strtoupper(md5(time() . $str));
            }
            else {
                return $str;
            }
        }
         
        /*******************************************************
         *      微信商户订单号 - 最长28位字符串
         *******************************************************/
         
        public function wxMchBillno($mchid = NULL) {
            if(is_null($mchid)){
                if(self::mchid == "" || is_null(self::mchid)){
                    $mchid = time();
                }
                else{
                    $mchid = self::mchid;
                }
            }
            else{
                $mchid = substr(addslashes($mchid),0,10);
            }
            return date("Ymd",time()).time().$mchid;
        }
         
        /*******************************************************
         *      微信格式化数组变成参数格式 - 支持url加密
         *******************************************************/      
         
        public function wxSetParam($parameters){
            if(is_array($parameters) && !empty($parameters)){
                $this->parameters = $parameters;
                return $this->parameters;
            }
            else{
                return array();
            }
        }
         
        /*******************************************************
         *      微信格式化数组变成参数格式 - 支持url加密
         *******************************************************/
         
    public function wxFormatArray($parameters = NULL, $urlencode = FALSE){
            if(is_null($parameters)){
                $parameters = $this->parameters;
            }
            $restr = "";//初始化空
            ksort($parameters);//排序参数
            foreach ($parameters as $k => $v){//循环定制参数
                if (null != $v && "null" != $v && "sign" != $k) {
                    if($urlencode){//如果参数需要增加URL加密就增加，不需要则不需要
                        $v = urlencode($v);
                    }
                    $restr .= $k . "=" . $v . "&";//返回完整字符串
                }
            }
            if (strlen($restr) > 0) {//如果存在数据则将最后“&”删除
                $restr = substr($restr, 0, strlen($restr)-1);
            }
            return $restr;//返回字符串
    }
         
        /*******************************************************
         *      微信MD5签名生成器 - 需要将参数数组转化成为字符串[wxFormatArray方法]
         *******************************************************/
        public function wxMd5Sign($content, $privatekey){
        try {
                if (is_null($privatekey)) {
                    throw new Exception("财付通签名key不能为空！");
                }
                if (is_null($content)) {
                    throw new Exception("财付通签名内容不能为空");
                }
                $signStr = $content . "&key=" . $privatekey;
                return strtoupper(md5($signStr));
            }
            catch (Exception $e)
            {
                die($e->getMessage());
            }
        }
         
        /*******************************************************
         *      微信Sha1签名生成器 - 需要将参数数组转化成为字符串[wxFormatArray方法]
         *******************************************************/
        public function wxSha1Sign($content){
            try {
                if (is_null($content)) {
                    throw new Exception("签名内容不能为空");
                }
                //$signStr = $content;
                return sha1($content);
            }
            catch (Exception $e)
            {
                die($e->getMessage());
            }
        }
         
        /*******************************************************
         *      微信jsApi整合方法 - 通过调用此方法获得jsapi数据
         *******************************************************/       
        public function wxJsapiPackage(){
            $jsapi_ticket = $this->wxVerifyJsApiTicket();
             
            // 注意 URL 一定要动态获取，不能 hardcode.
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url = $protocol.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
             
            $timestamp = time();
            $nonceStr = $this->wxNonceStr();
             
            $signPackage = array(
              "jsapi_ticket" => $jsapi_ticket,
              "nonceStr"  => $nonceStr,
              "timestamp" => $timestamp,
              "url"       => $url
            ); 
             
            // 这里参数的顺序要按照 key 值 ASCII 码升序排序
            $rawString = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
             
            //$rawString = $this->wxFormatArray($signPackage);
            $signature = $this->wxSha1Sign($rawString);
             
            $signPackage['signature'] = $signature;
            $signPackage['rawString'] = $rawString;
            $signPackage['appId'] = self::appId;
             
            return $signPackage;
        }
 
         
        /*******************************************************
         *      微信卡券：JSAPI 卡券Package - 基础参数没有附带任何值 - 再生产环境中需要根据实际情况进行修改
         *******************************************************/      
        public function wxCardPackage($cardId , $timestamp = ''){
            $api_ticket = $this->wxVerifyJsApiTicket();
            if(!empty($timestamp)){
                $timestamp = $timestamp;
            }
            else{
                $timestamp = time();
            }
             
            $arrays = array(self::appSecret,$timestamp,$cardId);
            sort($arrays , SORT_STRING);
            //print_r($arrays);
            //echo implode("",$arrays)."<br />";
            $string = sha1(implode($arrays));
            //echo $string;
            $resultArray['cardId'] = $cardId;
            $resultArray['cardExt'] = array();
            $resultArray['cardExt']['code'] = '';
            $resultArray['cardExt']['openid'] = '';
            $resultArray['cardExt']['timestamp'] = $timestamp;
            $resultArray['cardExt']['signature'] = $string;
            //print_r($resultArray);
            return $resultArray;
        }
         
        /*******************************************************
         *      微信卡券：JSAPI 卡券全部卡券 Package
         *******************************************************/
        public function wxCardAllPackage($cardIdArray = array(),$timestamp = ''){
            $reArrays = array();
            if(!empty($cardIdArray) && (is_array($cardIdArray) || is_object($cardIdArray))){
                //print_r($cardIdArray);
                foreach($cardIdArray as  $value){
                    //print_r($this->wxCardPackage($value,$openid));
                    $reArrays[] = $this->wxCardPackage($value,$timestamp);
                }
                //print_r($reArrays);
            }
            else{
                $reArrays[] = $this->wxCardPackage($cardIdArray,$timestamp);
            }
            return strval(json_encode($reArrays));
        }
         
        /*******************************************************
         *      微信卡券：获取卡券列表
         *******************************************************/       
        public function wxCardListPackage($cardType = "" , $cardId = ""){
            //$api_ticket = $this->wxVerifyJsApiTicket();
            $resultArray = array();
            $timestamp = time();
            $nonceStr = $this->wxNonceStr();
            //$strings = 
            $arrays = array(self::appId,self::appSecret,$timestamp,$nonceStr);
            sort($arrays , SORT_STRING);
            $string = sha1(implode($arrays));
             
            $resultArray['app_id'] = self::appId;
            $resultArray['card_sign'] = $string;
            $resultArray['time_stamp'] = $timestamp;
            $resultArray['nonce_str'] = $nonceStr;
            $resultArray['card_type'] = $cardType;
            $resultArray['card_id'] = $cardId;
            return $resultArray;
        }
         
        /*******************************************************
         *      将数组解析XML - 微信红包接口
         *******************************************************/
        public function wxArrayToXml($parameters = NULL){
            if(is_null($parameters)){
                $parameters = $this->parameters;
            }
             
            if(!is_array($parameters) || empty($parameters)){
                die("参数不为数组无法解析");
            }
             
            $xml = "<xml>";
            foreach ($arr as $key=>$val)
            {
                if (is_numeric($val))
                {
                    $xml.="<".$key.">".$val."</".$key.">"; 
                }
                else
                    $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
            }
            $xml.="</xml>";
            return $xml; 
        }
         
        /*******************************************************
         *      微信卡券：上传LOGO - 需要改写动态功能
         *******************************************************/
        public function wxCardUpdateImg() {
            $wxAccessToken  = $this->wxAccessToken();
            //$data['access_token'] =  $wxAccessToken;
            $data['buffer']     =  '@D:\\workspace\\htdocs\\yky_test\\logo.jpg';
            $url            = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$data);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;
            //array(1) { ["url"]=> string(121) "http://mmbiz.qpic.cn/mmbiz/ibuYxPHqeXePNTW4ATKyias1Cf3zTKiars9PFPzF1k5icvXD7xW0kXUAxHDzkEPd9micCMCN0dcTJfW6Tnm93MiaAfRQ/0" } 
        }
         
        /*******************************************************
         *      微信卡券：获取颜色
         *******************************************************/
        public function wxCardColor(){
            $wxAccessToken  = $this->wxAccessToken();
            $url                = "https://api.weixin.qq.com/card/getcolors?access_token=".$wxAccessToken;
            $result         = $this->wxHttpsRequest($url);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;
        }
         
        /*******************************************************
         *      微信卡券：创建卡券
         *******************************************************/
        public function wxCardCreated($jsonData) {
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/card/create?access_token=" . $wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;
        }
     
        /*******************************************************
         *      微信卡券：查询卡券详情
         *******************************************************/
        public function wxCardGetInfo($jsonData) {
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/card/get?access_token=" . $wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;
        }
 
        /*******************************************************
         *      微信卡券：设置白名单
         *******************************************************/
        public function wxCardWhiteList($jsonData){
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/card/testwhitelist/set?access_token=" . $wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;
        }
 
 
        /*******************************************************
         *      微信卡券：消耗卡券
         *******************************************************/
        public function wxCardConsume($jsonData){
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/card/code/consume?access_token=" . $wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;            
        }
 
        /*******************************************************
         *      微信卡券：删除卡券
         *******************************************************/
        public function wxCardDelete($jsonData){
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/card/delete?access_token=" . $wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;            
        }
         
        /*******************************************************
         *      微信卡券：选择卡券 - 解析CODE
         *******************************************************/       
        public function wxCardDecryptCode($jsonData){
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/card/code/decrypt?access_token=" . $wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;              
        }
         
        /*******************************************************
         *      微信卡券：更改库存
         *******************************************************/
        public function wxCardModifyStock($cardId , $increase_stock_value = 0 , $reduce_stock_value = 0){
            if(intval($increase_stock_value) == 0 && intval($reduce_stock_value) == 0){
                return false;
            }
             
            $jsonData = json_encode(array("card_id" => $cardId , 'increase_stock_value' => intval($increase_stock_value) , 'reduce_stock_value' => intval($reduce_stock_value)));
             
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/card/modifystock?access_token=" . $wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;              
        }
 
        /*******************************************************
         *      微信卡券：查询用户CODE
         *******************************************************/       
        public function wxCardQueryCode($code , $cardId = ''){
             
            $jsonData = json_encode(array("code" => $code , 'card_id' => $cardId ));
             
            $wxAccessToken  = $this->wxAccessToken();
            $url            = "https://api.weixin.qq.com/card/code/get?access_token=" . $wxAccessToken;
            $result         = $this->wxHttpsRequest($url,$jsonData);
            $jsoninfo       = json_decode($result, true);
            return $jsoninfo;             
        }
    }