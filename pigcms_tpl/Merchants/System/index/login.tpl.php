<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
	<meta name="format-detection" content="telephone=no">

    <title>收银台管理后台登录</title>

    <link href="{pg:$smarty.const.RlStaticResource}bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}font-awesome/css/font-awesome.css" rel="stylesheet">
	 <link href="{pg:$smarty.const.RlStaticResource}plugins/css/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}css/animate.css" rel="stylesheet">
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}css/style.css" rel="stylesheet">
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}css/login.css" rel="stylesheet">
</head>

<body class="gray-bg">
<div class="addBg">
    <div class="addBgArea">
        <img class="balloon" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/balloon.png" alt="balloon">
        <img class="cricle" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/cricle.png" alt="cricle">
        <img class="could" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/could.png" alt="could">
        <img class="mountain0" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/mountain0.png" alt="mountain0">
        <img class="mountain1" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/mountain1.png" alt="mountain1">
        <img class="mountain2" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/mountain2.png" alt="mountain2">
        <img class="tree tree0" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/tree.png" alt="tree">
        <img class="tree tree1" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/tree.png" alt="tree">
        <img class="tree tree2" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/tree.png" alt="tree">
        <img class="point" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/point.png" alt="point">
        <img class="stick" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/stick.png" alt="stick">
        <img class="footprint0" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/footprint.png" alt="footprint">
        <img class="footprint1" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/footprint.png" alt="footprint">
        <img class="footprint2" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/footprint.png" alt="footprint">
        <img class="footprint3" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/login/footprint.png" alt="footprint">
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
			  <p class="m-t"> <small>Copyright：{pg:$smarty.server.HTTP_HOST|replace:'http://':''} &copy; {pg:$smarty.now|date_format:"%Y"}</small> </p>
        </div>
    </div>
</div>
    <!-- Mainly scripts -->
    <script src="{pg:$smarty.const.RlStaticResource}js/jquery-2.1.1.js"></script>
    <script src="{pg:$smarty.const.RlStaticResource}bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Jquery Validate -->
    <script src="{pg:$smarty.const.RlStaticResource}plugins/js/validate/jquery.validate.min.js"></script>
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
