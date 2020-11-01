
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台 | 在线支付配置</title>
    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
	
	<!-- Sweet Alert -->
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
	
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate.css" rel="stylesheet">
	
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
	
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
	<style>
		.ibox-title h5 {
  			margin: 10px 0 0px;
		}
		select.input-sm {
  			height: 35px;
  			line-height: 35px;
		}
		.float-e-margins .btn-info{
			margin-bottom:0px;
			padding:3px;
		}
		.fa-paste{
			margin-right:7px;
			padding: 0px;
		}
		.dz-preview{
			display:none;
		}
	</style>
</head>

<body>

    <div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>在线支付配置</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Pay</a>
                        </li>
                        <li class="active">
                            <strong>Config</strong>
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
            	        <div class="ibox-title clearfix">
            	            <h5 style="margin: 10px 0 0px;">支付开关</h5>
							<div class="col-sm-2 m-b-xs">
								<select class="input-sm form-control input-s-sm inline switch">
                                    <option <?php if($payConfig['isOpen'] == 0){ echo 'selected="selected"'; }?> value="0">关闭</option>
                                    <option <?php if($payConfig['isOpen'] == 1){ echo 'selected="selected"'; }?> value="1">开启</option>
                             	</select>
                            </div>
            	        </div>
            	        <div class="ibox-content<?php if($payConfig['isOpen'] == 0){ echo ' hide'; }?>">
							<table class="table table-striped">
            	                <tr>
            	                    <td style="padding-top:12px;"><input type="checkbox" <?php if($payConfig['configData']['weixin']['isOpen'] == 1){ echo 'checked="checked"'; }?> data-type='weixin' class="i-checks isOpen"></td>
            	                    <td><img src="<?php echo $this->RlStaticResource;?>pay_icon/weixin.png"></td>
            	                    <td style="padding-top: 14px;">微信支付</td>
            	                    <td><button class="btn btn-info " type="button" <?php if($payConfig['configData']['alipay']['isOpen'] == 1){ echo 'checked="checked"'; }?> data-toggle="modal" data-target="#weixinSetting"><i class="fa fa-paste"></i>配置信息</button></td>
            	                </tr>
								<tr>
            	                    <td style="padding-top:12px;"><input type="checkbox" data-type='alipay' <?php if($payConfig['configData']['alipay']['isOpen'] == 1){ echo 'checked="checked"'; }?> class="i-checks isOpen"></td>
            	                    <td><img src="<?php echo $this->RlStaticResource;?>pay_icon/alipay.png"></td>
            	                    <td style="padding-top: 14px;">支付宝支付</td>
            	                    <td><button class="btn btn-info " type="button"><i class="fa fa-paste"></i>开发中</button></td>
            	                </tr>
            	            </table>
            	        </div>
            	    </div>
            	</div>
            </div>
        </div>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>
	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="weixinSetting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-wrench modal-icon"></i>
                    <h4 class="modal-title">微信支付 支付配置</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="new_wxpay_box" class="wxpay_box">
							
							<div class="form-group">
								<label>Appid</label>
								<input type="text" placeholder="Appid" value="<?php echo $payConfig['configData']['weixin']['appid']; ?>" name="weixin[appid]" class="form-control">
							</div>

							<div class="form-group">
								<label>AppSecret</label>
								<input type="text" placeholder="应用密钥" value="<?php echo $payConfig['configData']['weixin']['appSecret']; ?>" name="weixin[appSecret]" class="form-control">
							</div>

							<div class="form-group">
								<label>微支付商户号</label>
								<input type="text" placeholder="商户号" value="<?php echo $payConfig['configData']['weixin']['mchid']; ?>" name="weixin[mchid]" class="form-control">
							</div>
							<div class="form-group">
								<label>API密钥</label>
								<input type="text" placeholder="Api密钥" value="<?php echo $payConfig['configData']['weixin']['key']; ?>" name="weixin[key]" class="form-control">
							</div>
							<div class="form-group">
								<label>apiclient_cert私钥文件</label>
								<input type="text" placeholder="apiclient_cert私钥文件" value="<?php echo urldecode($payConfig['configData']['weixin']['apiclient_cert']); ?>" name="weixin[apiclient_cert]" class="form-control">
								<div class="dropz" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 70px;text-align: center;position: relative;top: -34px;float: right;cursor: pointer;">文件上传</div>
							</div>
							<div class="form-group">
								<label>apiclient_key公钥文件</label>
								<input type="text" placeholder="apiclient_key公钥文件" value="<?php echo urldecode($payConfig['configData']['weixin']['apiclient_key']); ?>" name="weixin[apiclient_key]" class="form-control">
								<div class="dropz" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 70px;text-align: center;position: relative;top: -34px;float: right;cursor: pointer;">文件上传</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary btn-confirm">确定</button>
                </div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="alipaySetting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-wrench modal-icon"></i>
                    <h4 class="modal-title">支付宝支付 支付配置</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="new_wxpay_box" class="wxpay_box">
							
							<div class="form-group">
								<label>Appid</label>
								<input type="text" placeholder="Appid" value="<?php echo $payConfig['configData']['alipay']['appid']; ?>" name="alipay[appid]" class="form-control">
							</div>
							<div class="form-group">
								<label>Key</label>
								<input type="text" placeholder="Key" value="<?php echo $payConfig['configData']['alipay']['key']; ?>" name="alipay[key]" class="form-control">
							</div>
							<div class="form-group">
								<label>卖家账号</label>
								<input type="text" placeholder="卖家账号" value="<?php echo $payConfig['configData']['alipay']['name']; ?>" name="alipay[name]" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary btn-confirm">确定</button>
                </div>
				</form>
			</div>
		</div>
	</div>


    <!-- Mainly scripts -->
    <script src="<?php echo $this->RlStaticResource;?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/slimscroll/jquery.slimscroll.min.js"></script>


    <!-- Custom and plugin javascript -->
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>js/inspinia.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	
	<!-- Sweet alert -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/sweetalert/sweetalert.min.js"></script>
	
	<!-- DROPZONE -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
	
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
			$('.switch').change(function(){
				if($(this).val() == 1){
					$('.ibox-content').hasClass('hide') && ($('.ibox-content').removeClass('hide')),$('.ibox-content').show();
				}else if($(this).val() == 0){
					$('.ibox-content').hide();
				}
				$.post('?m=User&c=pay&a=field',{isOpen:$(this).val()});
			});
			$('.btn-confirm').click(function(){
				var payConfigData = $(this).parents('form').serialize();
				$.post('?m=User&c=pay&a=config',{data:htmlToArray(payConfigData)},function(result){
					if(result.status == 1){
						swal({
        					title: "成功",
        					text: result.msg,
        					type: "success"
    					}, function () {
        					window.location.reload();
   						});
					}else{
						swal("失败", result.msg , "error");
					}
				},'json');
			});
			$('.isOpen').on('ifChanged', function(){
				if($(this).is(':checked')){
					var isOpen = 1;
				}else{
					var isOpen = 0;
				}
				var payConfigData = {};
				typeof(payConfigData[$(this).attr('data-type')]) == 'undefined' && (payConfigData[$(this).attr('data-type')] = {}),payConfigData[$(this).attr('data-type')].isOpen = isOpen;
				$.post('?m=User&c=pay&a=config',{data:payConfigData});
			});
			$(".dropz").dropzone({
				url: "?m=User&c=pay&a=pem_upload",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".pem",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $(".dropz")****/
						$(this.element).siblings('input').val(rept.fileUrl);
					});
				}
			});
        });
		function htmlToArray(data){
			data = data.split('&');
			var info = {};
			$.each(data,function(k,v){
				v = v.replace('%5D','').split('=');
				var s = v[0].split('%5B');
				typeof(info[s[0]]) == 'undefined' && (info[s[0]] = {}),info[s[0]][s[1]] = v[1];
			});
			return info;
		}


    </script>

</body>

</html>