<?php 
header("Content-type: text/html; charset=utf-8");
//require_once 'F2fpay.php';
if (!empty($_POST['out_trade_no'])&& trim($_POST['out_trade_no'])!=""){
	$f2fpay = new F2fpay();
	
	$out_trade_no = trim($_POST['out_trade_no']);
	$auth_code = trim($_POST['auth_code']);
	$total_amount = trim($_POST['total_amount']);
	$subject = trim($_POST['subject']);
	
	$response = 	$f2fpay->barpay($out_trade_no, $auth_code, $total_amount, $subject);
	print_r($response);
	return ;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<title>支付宝当面付 条码支付</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<form action="?m=Index&c=pay&a=pay" method="post">
		<input type="hidden" name="type" value="alipay">
        <div style="margin-left:2%;">商户订单号：</div><br>
       	<input type="text" style="width:96%;height:35px;margin-left:2%;" readonly value="pigcms<?php echo date('YmdHis',time()).mt_rand(11111,55555); ?>" name="out_trade_no"><br><br>
       	<div style="margin-left:2%;">订单名称：</div><br>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" readonly value="刷卡测试样例-支付" name="subject"><br><br>
        <div style="margin-left:2%;">付款金额：</div><br>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" readonly value="0.01" name="total_amount"><br><br>
		<div style="margin-left:2%;">付款条码：</div><br>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" name="auth_code"><br><br>
       	<div align="center">
			<input type="submit" value="提交刷卡" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" onclick="callpay()">
		</div>
	</form>
</body>
</html>