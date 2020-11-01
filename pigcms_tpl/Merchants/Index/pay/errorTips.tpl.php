<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection" content="telephone=no" />	
		<title>温馨提示</title>
		<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/styles/weixin_pay.css" rel="stylesheet"/>
		<style>
		#footReturn li{
		    margin: 5px 20px;
		    text-align: center;
			line-height: 50px;
			font-size: 22px;
			background-color: #179F00;
			padding: 10px 20px;
			text-decoration: none;
			border: 1px solid #0B8E00;
			background-image: linear-gradient(bottom, #179F00 0%, #5DD300 100%);
			background-image: -o-linear-gradient(bottom, #179F00 0%, #5DD300 100%);
			background-image: -moz-linear-gradient(bottom, #179F00 0%, #5DD300 100%);
			background-image: -webkit-linear-gradient(bottom, #179F00 0%, #5DD300 100%);
			background-image: -ms-linear-gradient(bottom, #179F00 0%, #5DD300 100%);
			background-image: -webkit-gradient(
			linear,
			left bottom,
			left top,
			color-stop(0, #179F00),
			color-stop(1, #5DD300)
			);
			-webkit-box-shadow: 0 1px 0 #94E700 inset, 0 1px 2px rgba(0, 0, 0, 0.5);
			-moz-box-shadow: 0 1px 0 #94E700 inset, 0 1px 2px rgba(0, 0, 0, 0.5);
			box-shadow: 0 1px 0 #94E700 inset, 0 1px 2px rgba(0, 0, 0, 0.5);
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			-o-border-radius: 5px;
			border-radius: 5px;
			color: #ffffff;
			display: block;
			text-align: center;
			text-shadow: 0 1px rgba(0, 0, 0, 0.2);
			word-break: break-all;
		}
		</style>
	</head>
	<body style="padding-top:20px;">
		<div id="footReturn" style="margin-top: 40px;">
		<h2 style="position: absolute;top: 10px;left: 40%;font-size: 20px;color: #35BE1A;">温馨提示</h2>
			<ul class="round">
				<li class="mb"  style="text-align:center"><?php echo $msg;?></li>
				<li class="mb"  style="text-align:center;margin-top: 45px;"><span id="returnSecond">7</span>秒后自动返回</li>
			</ul>
		</div>
	</body>
		<script type="text/javascript">
		var wait = document.getElementById('returnSecond');
			var interval = setInterval(function(){
				var time = --wait.innerHTML;
				if(time == 0) {
					window.history.back();
					clearInterval(interval);
				};
			}, 1000);
		</script>
</html>