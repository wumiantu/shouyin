<!DOCTYPE HTML>
<head>
<title>微信扫码退款</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1.0, maximum-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/styles/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/styles/colors/blue.css" rel="stylesheet" type="text/css">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/styles/framework.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jqueryui.js"></script>
<script type="text/javascript" src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/framework.js"></script>
<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jquery.qrcode.min.js" type="text/javascript"></script>
<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/layer/layer.min.js" type="text/javascript"></script>
 <script type="text/javascript">
 $(window).load(function() { // makes sure the whole site is loaded
	$("#status").fadeOut(); // will first fade out the loading animation
	$("#preloader").delay(350).fadeOut("slow"); // will fade out the white DIV that covers the website.
	});
	var jump_url = '';/***提交之后跳转的URL****/
	$(function(){
		$('#content').css('min-height',$(window).height());
	});
</script>
<style>
.one-half-responsive {margin-top: 25px;}
.one-half-responsive h4{line-height: 35px;}

</style>
</head>
<body>

<div id="preloader">
	<div id="status">
    	<p class="center-text">
			正在加载中...
            <em>加载取决于你的连接速度!</em>
        </p>
    </div>
</div>


<div class="all-elements">
    <div id="content" class="page-content">
    	<div class="content-controls solid-color fixed-header">
        	<!---<a href="#" class="deploy-sidebar"></a>-->
			<a href="javascript:;"  style="width: 50px;height: 50px;"></a>
            <em class="content-title">微信扫码退款</em>
            <a href="contact.html" class="deploy-contact" style="display:none"></a>
        </div>    
        <div class="fixed-header-clear"></div>    
        

        <div class="content">
        	<!-- start-->
            <div class="one-half-responsive">
                <div class="container no-bottom">
                    <div class="contact-form no-bottom">
                        <h4>只适用微信扫码支付退款<br/>扫微信扫码支付交易详情页的条形码来退款</h4>
                        <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">
                            <div class="big-notification green-notification">
                                <h3 class="uppercase">温馨提示</h3>
                                <a href="#" class="close-big-notification">x</a>
                                <p id="wxpaytips">你提交的数据已经保存成功。</p>
                                <div class="msg" style="font-size:12px;padding:10px;padding-top: 0px;margin-bottom: 0px;">
                                </div>
                            </div>
                        </div>
                    
                            <fieldset>
                                <div class="formFieldWrap" style="margin-top:20px;">
                                    <a class="buttonWrap button button-green contactSubmitButton"  id="micropayRefund"/>扫一扫退款</a>
                                </div>
							
                            </fieldset>
                       
                    </div>
                </div>
            </div>
            <!--申请 end-->
     <div class="content">
        	<div class="container" style="display:none">
                <div class="footer-socials">
                    <a href="#" class="facebook-footer"></a>
                    <a href="#" class="goup-footer"></a>
                    <a href="#" class="twitter-footer"></a>
                </div>
                <p class="copyright uppercase center-text no-bottom">Copyright 2015<br> All rights reserved</p>        
			</div>
		</div> 
    </div>  
</div>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
		wx.config({
		  debug: false,
		  appId: '<?php echo $signdata["appId"]; ?>',
		  timestamp: '<?php echo $signdata["timestamp"]; ?>',
		  nonceStr: '<?php echo $signdata["nonceStr"]; ?>',
		  signature: '<?php echo $signdata["signature"]; ?>',
		  jsApiList: [
		    'checkJsApi',
		    'onMenuShareTimeline',
		    'onMenuShareAppMessage',
		    'onMenuShareQQ',
		    'onMenuShareWeibo',
		    'scanQRCode',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage',
			'getLocation',
			'openLocation',
			'getNetworkType'
		  ]
		});
	</script>
	<script type="text/javascript">
	wx.ready(function () {
	  // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
	  /*document.querySelector('#checkJsApi').onclick = function () {
	    wx.checkJsApi({
	      jsApiList: [
	        'getNetworkType',
	        'previewImage'
	      ],
	      success: function (res) {
	        //alert(JSON.stringify(res));
	      }
	    });
	  };*/	
	});
function is_mobile(){
	var ua = navigator.userAgent.toLowerCase();
	if ((ua.match(/(iphone|ipod|android|ios|ipad)/i))){
		if(navigator.platform.indexOf("Win") == 0 || navigator.platform.indexOf("Mac") == 0){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}
function is_weixin(){
    var ua = navigator.userAgent.toLowerCase();
    if(is_mobile() && ua.indexOf('micromessenger') != -1){  
        return true;  
    } else {  
        return false;  
    }  
}
/*function getParam(url,name){ 
	var reg = new RegExp("[&|?]"+name+"=([^&$]*)", "gi"); 
	var a = reg.test(url); 
	return a ? RegExp.$1 : ""; 
}*/

   var $ = jQuery.noConflict(); 
   var formSubmitted = 'false';
	function validateForm(currentForm, formType){		
		// hide any error messages starts
	   	$('.formValidationError').hide();
		$('.fieldHasError').removeClass('fieldHasError');	
		if(formSubmitted == 'false' && ($('#' + currentForm + ' .requiredField').length - 1)){
			 	submitData(currentForm, formType);
			}
	};
   function submitData(currentForm, formType){
		formSubmitted = 'true';

		$('#contactSubmitButton').css('background-color','grey');
		//$('#contactSubmitButton').val('正在提交 ....');

		var formInput = $('#' + currentForm).serialize();		
		$.post($('#' + currentForm).attr('action'),formInput, function(data){
			$('#' + currentForm).hide();
			$('#' + currentForm).siblings('h4').hide();
			if(typeof(data.error) !='undefined' && data.error){
				$('#wxpaytips').css('color','red').html(data.msg);
			}
			$('#formSuccessMessageWrap').fadeIn(500);
			$('body').scrollTop('0');

			var wait = document.getElementById('wait');
			var interval = setInterval(function(){
				var time = --wait.innerHTML;
				if(time == 0) {
					location.href = jump_url;
					clearInterval(interval);
				};
			}, 1000);
		},'JSON');
		/*window.document.contactForm.submit();*/
	};

$('#micropayRefund').click(function(){
	if(is_weixin()){
		wx.scanQRCode({
			needResult:1,
			scanType:["qrCode"],
			success:function (res){
				/*
				 * URL提示：
				 * 
				 */
				var result = res.resultStr;
				if(result && /^\d+$/g.test(result)){
					if(confirm('您确定要给这这笔订单退款给？')){
					$('#contactSubmitButton').css('background-color','grey');	
					$.post('?m=User&c=wapcashier&a=wxSmRefund',{orderid:result}, function(data){
					$('#' + currentForm).hide();
					$('#' + currentForm).siblings('h4').hide();
					if(typeof(data.error) !='undefined' && data.error){
					$('#wxpaytips').css('color','red').html(data.msg);
					}
					$('#formSuccessMessageWrap').fadeIn(500);
					$('body').scrollTop('0');

					var wait = document.getElementById('wait');
					var interval = setInterval(function(){
					var time = --wait.innerHTML;
						if(time == 0) {
							location.href = jump_url;
							clearInterval(interval);
						};
					}, 1000);
					},'JSON');
					}
					 return false;
				}else{
					alert('不是有效的码，非法输入');
				}	
			}
		});
	}else{
		alert('您使用的不是微信浏览器，此功能无法使用！您可以使用浏览器自带的或其他扫描二维码工具进行扫描');
	}
	return false;
});

$('#days_numberField').focus();
$('#formSuccessMessageWrap').hide(0);
</script>
</body>
</html>