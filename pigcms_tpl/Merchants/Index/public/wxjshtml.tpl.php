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
$('#qrcode_btn').click(function(){
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
				  $('#days_numberField').val(result);
				  	validateForm('contactForm');
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