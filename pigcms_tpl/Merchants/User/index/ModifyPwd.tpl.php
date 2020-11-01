<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台 | 收银台</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	
</head>

<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>收银台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Index</a>
                        </li>
                        <li class="active">
                            <strong>修改密码</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
			   <div class="row">
				<div class="col-lg-6">
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>密码修改</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" id="pwdform" action="/merchants.php?m=User&c=index&a=doModifyPwd" method="POST">
                                <p>密码很重要，请牢记住</p>
                                <div class="form-group"><label class="col-lg-2 control-label">旧密码</label>
                                    <div class="col-lg-10"><input type="password" class="form-control" placeholder="旧密码" name="oldpwd"> <span class="help-block m-b-none"></span>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">新密码</label>
                                    <div class="col-lg-10"><input type="password" class="form-control" placeholder="新密码" name="newpwd"></div>
                                </div>
								<div class="form-group"><label class="col-lg-2 control-label">新密码</label>
                                    <div class="col-lg-10"><input type="password" class="form-control" placeholder="再输入一次新密码" name="new2pwd"></div>
                                </div>
      
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button type="submit" class="btn btn-sm btn-primary"> 修 改 </button>
                                    </div>
                                </div>
                            </form>
                        </div>
						</div>
                    </div>
					</div>
            </div>
            </div>
        </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
</body>

 <script>
    	 $("#pwdform").submit(function(){
			var oldpwd=$.trim($('input[name="oldpwd"]').val());
			var newpwd=$.trim($('input[name="newpwd"]').val());
			var new2pwd=$.trim($('input[name="new2pwd"]').val());
			if(!oldpwd){
			     swal("温馨提醒", "您没有输入旧密码", "error");
				 $('input[name="oldpwd"]').focus();
				 return false;
			}
			if(!newpwd){
			     swal("温馨提醒", "您没有输入新密码", "error");
				 $('input[name="newpwd"]').focus();
				 return false;
			}
			if(!new2pwd){
			     swal("温馨提醒", "您没有输入新密码！", "error");
				 $('input[name="new2pwd"]').focus();
				 return false;
			}
		   if(newpwd != new2pwd){
		      	swal("温馨提醒", "两次输入的新密码不一致", "error");
				 $('input[name="new2pwd"]').focus();
				 return false;
		   }
		   return true;
		 });
  </script>
</html>