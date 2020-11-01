<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection" content="telephone=no" />	
		<title>支付提示</title>
		<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/styles/weixin_pay.css" rel="stylesheet"/>
		<style>
		#footReturn li{
		    margin: 5px 20px;
		    text-align: center;
			height: 50px;
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
		}
		</style>
	</head>
	<body style="padding-top:20px;">
		<div id="payDom" class="cardexplain">
			<ul class="round">
				<li class="title mb"><span class="none">支付信息</span></li>
				<li class="nob">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
						<tr><th style="width:100px">支付金额：</th><td><?php echo $orderInfo['goods_price'];?> 元</td></tr>
					</table>
				</li>
			</ul>
		</div>

		<div id="footReturn">
			<ul class="round">
				<li class="mb"  style="text-align:center">支付成功</li>
			</ul>
		</div>
	</body>
</html>