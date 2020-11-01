
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
	<meta name="format-detection" content="telephone=no">
    <title>收银台注册</title>
    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
	<!-- Sweet Alert -->
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate.css" rel="stylesheet">
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <form class="m-t" id="form" role="form" method="post" action="?m=Index&c=login&a=signed">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="登录账号" required="">
                </div>
				<div class="form-group">
                    <input type="text" class="form-control" name="wxname" placeholder="商户名称" required="">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="邮箱地址" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="登录密码" required="">
					<input type="hidden" name="agree" value="1">
                </div>
                <!--<div class="form-group">
                     <div class="checkbox i-checks"><label> <input type="checkbox" name="agree" checked="checked" value="1"><i></i> 同意条款和政策 </label></div>
                </div>-->
                <button type="submit" class="btn btn-primary block full-width m-b">注册</button>

                <!--<p class="text-muted text-center"><small>已经有一个帐户?</small></p>-->
                <a class="btn btn-sm btn-white btn-block" href="?m=Index&c=login&a=index">立即登录</a>
            </form>
			<p class="m-t"> <small>Copyright：<?php echo str_replace('http://','',$_SERVER['HTTP_HOST'])?> &copy; <?php echo date('Y');?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo $this->RlStaticResource;?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	<!-- Jquery Validate -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/validate/jquery.validate.min.js"></script>
	<!-- Sweet alert -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $("#form").validate({
                 rules: {
                     password: {
                         required: true,
                         minlength: 6
                     },
                     username: {
                         required: true,
                       	 minlength: 4
                     }
                 }
             });
			 $("#form").submit(function(){
				 /*if($(this).find('input[type="checkbox"]').is(':checked') == false){
					 swal("提示！", "请先同意条款 :)", "error");
					 return false;
				 }*/
			 });
        });
    </script>
</body>

</html>
