<?php /* Smarty version 2.6.18, created on 2015-10-23 05:51:31
         compiled from C:%5CWWW%5CCashier%5C./pigcms_tpl/Merchants/System/index/login.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'C:\\WWW\\Cashier\\./pigcms_tpl/Merchants/System/index/login.tpl.php', 52, false),array('modifier', 'date_format', 'C:\\WWW\\Cashier\\./pigcms_tpl/Merchants/System/index/login.tpl.php', 52, false),)), $this); ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
	<meta name="format-detection" content="telephone=no">

    <title>收银台管理后台登录</title>

    <link href="<?php echo @RlStaticResource; ?>
bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo @RlStaticResource; ?>
font-awesome/css/font-awesome.css" rel="stylesheet">
	 <link href="<?php echo @RlStaticResource; ?>
plugins/css/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
css/animate.css" rel="stylesheet">
	<link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
css/style.css" rel="stylesheet">
	<link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
css/login.css" rel="stylesheet">
</head>

<body class="gray-bg">
<div class="addBg">
    <div class="addBgArea">
        <img class="balloon" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/balloon.png" alt="balloon">
        <img class="cricle" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/cricle.png" alt="cricle">
        <img class="could" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/could.png" alt="could">
        <img class="mountain0" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/mountain0.png" alt="mountain0">
        <img class="mountain1" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/mountain1.png" alt="mountain1">
        <img class="mountain2" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/mountain2.png" alt="mountain2">
        <img class="tree tree0" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/tree.png" alt="tree">
        <img class="tree tree1" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/tree.png" alt="tree">
        <img class="tree tree2" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/tree.png" alt="tree">
        <img class="point" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/point.png" alt="point">
        <img class="stick" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/stick.png" alt="stick">
        <img class="footprint0" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/footprint.png" alt="footprint">
        <img class="footprint1" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/footprint.png" alt="footprint">
        <img class="footprint2" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/footprint.png" alt="footprint">
        <img class="footprint3" src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
images/login/footprint.png" alt="footprint">
    </div>
    <div class="middle-box text-center loginscreen animated fadeInDown">
			<p class="m-t">收银台管理后台登录</p>
        <div>
            <form class="m-t" role="form" id="form" method="post" action="?m=System&c=index&a=login">
                <div class="form-group">
                    <input type="test" name="username" class="form-control" placeholder="账号" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="">
                </div>
				
                <button type="submit" class="btn btn-primary block full-width m-b">登录</button>
            </form>
			  <p class="m-t"> <small>Copyright：<?php echo ((is_array($_tmp=$_SERVER['HTTP_HOST'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'http://', '') : smarty_modifier_replace($_tmp, 'http://', '')); ?>
 &copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
</small> </p>
        </div>
    </div>
</div>
    <!-- Mainly scripts -->
    <script src="<?php echo @RlStaticResource; ?>
js/jquery-2.1.1.js"></script>
    <script src="<?php echo @RlStaticResource; ?>
bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Jquery Validate -->
    <script src="<?php echo @RlStaticResource; ?>
plugins/js/validate/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
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
		$(".addBg,.addBgArea").height($(window).height());
            $(window).resize(function(){
                $(".addBg,.addBgArea").height($(window).height());
          })
        });
    </script>
</body>

</html>