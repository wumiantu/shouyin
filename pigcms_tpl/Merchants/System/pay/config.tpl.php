
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>代理商家支付配置</title>
	{pg:include file="$tplHome/System/public/header.tpl.php"}
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/dropzone/dropzone.css" rel="stylesheet">
    <!-- iCheck -->
    <script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
	<!-- DROPZONE -->
    <script src="{pg:$smarty.const.RlStaticResource}plugins/js/dropzone/dropzone.js"></script>
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
		.red{color:red;}
	</style>
</head>

<body>

    <div id="wrapper">
		{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
        <div id="page-wrapper" class="gray-bg">
        {pg:include file="$tplHome/System/public/top.tpl.php"}
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>在线支付配置</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>System</a>
                        </li>
                        <li>
                            <a>pay</a>
                        </li>
                        <li class="active">
                            <strong>支付配置</strong>
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
            	            <h5 style="margin: 10px 0 0px;">支付配置</h5>
            	        </div>
            	        <div class="ibox-content">
							<div class="alert alert-warning">
                               请配置一个有特约商户管理功能的商户号相关微信支付信息，不然代理功能不可用。
                            </div>
							<table class="table table-striped">
            	                <tr>
            	                    <td><img style="margin-left: 15px" src="{pg:$smarty.const.RlStaticResource}pay_icon/weixin.png"></td>
            	                    <td style="padding-top: 14px;">微信支付</td>
            	                    <td id="wxapiinfo1"><button class="btn btn-info " type="button" checked="checked" data-toggle="modal" data-target="#weixinSetting"><i class="fa fa-paste"></i>配置信息</button></td>
									<td id="wxapiinfo2"></td>
            	                </tr>
								<!--<tr>
            	                    <td><img style="margin-left: 15px" src="{pg:$smarty.const.RlStaticResource}pay_icon/alipay.png"></td>
            	                    <td style="padding-top: 14px;">支付宝支付</td>
            	                    <td><button class="btn btn-info " type="button"><i class="fa fa-paste"></i>开发中</button></td>
									<td></td>
            	                </tr>--->
            	            </table>
            	        </div>
            	    </div>
            	</div>
            </div>
        </div>
	{pg:include file="$tplHome/System/public/footer.tpl.php"}
        </div>
    </div>
	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="weixinSetting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">微信支付 支付配置</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="new_wxpay_box" class="wxpay_box">
							
							<div class="form-group">
								<label>Appid</label>
								<input type="text" placeholder="Appid" value="{pg:$payConfig.weixin.appid}" name="weixin[appid]" class="form-control">
							</div>

							<div class="form-group">
								<label>AppSecret</label>
								<input type="text" placeholder="应用密钥" value="{pg:$payConfig.weixin.appSecret}" name="weixin[appSecret]" class="form-control">
							</div>

							<div class="form-group">
								<label>微支付商户号</label>
								<input type="text" placeholder="商户号" value="{pg:$payConfig.weixin.mchid}" name="weixin[mchid]" class="form-control">
							</div>
							<div class="form-group">
								<label>API密钥</label>
								<input type="text" placeholder="Api密钥" value="{pg:$payConfig.weixin.key}" name="weixin[key]" class="form-control">
							</div>
							<div class="form-group uploade">
								<label>apiclient_cert私钥文件</label>
								<input type="text" placeholder="apiclient_cert私钥文件" {pg:if !empty($payConfig.weixin.apiclient_cert)} value="pem文件已上传" readonly="readonly" {pg:else} value="" {pg:/if} class="form-control" >
								<input type="hidden" placeholder="apiclient_cert私钥文件" value="{pg:$payConfig.weixin.apiclient_cert|urldecode}" name="weixin[apiclient_cert]" class="hiddeninput">
								<div class="dropz" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 70px;text-align: center;position: relative;top: -34px;float: right;cursor: pointer;">文件上传</div>
							</div>
							<div class="form-group uploade">
								<label>apiclient_key公钥文件</label>
								<input type="text" placeholder="apiclient_key公钥文件" {pg:if !empty($payConfig.weixin.apiclient_key)} value="pem文件已上传" readonly="readonly" {pg:else} value="" {pg:/if} class="form-control">
								<input type="hidden" placeholder="apiclient_key公钥文件" value="{pg:$payConfig.weixin.apiclient_key|urldecode}" name="weixin[apiclient_key]" class="hiddeninput">
								<div class="dropz" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 70px;text-align: center;position: relative;top: -34px;float: right;cursor: pointer;">文件上传</div>
							</div>
								<div class="form-group uploade">
								<label>CA证书文件</label>
								<input type="text" placeholder="微信支付rootca文件" {pg:if !empty($payConfig.weixin.rootca)} value="rootca.pem文件已上传" readonly="readonly" {pg:else} value="" {pg:/if}  class="form-control">
								<input type="hidden" placeholder="微信支付rootca文件" value="{pg:$payConfig.weixin.rootca|urldecode}" name="weixin[rootca]" class="hiddeninput">
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

	<div class="modal inmodal" tabindex="-1"  id="wxApi_Setting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">微信服务器配置接口信息</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="wxActionBox" class="wxpay_box">
							<div class="form-group">
								<label>URL：</label>
								<input type="text" placeholder="服务器推送事件地址" value="{pg:$SiteUrl}/merchants.php?m=Index&c=wxAction&a=index&mymid={pg:$_mid}" class="form-control" readonly="readonly">
							</div>
							<div class="form-group">
								<label>Token：</label>
								<input type="text" placeholder="Token令牌" value="" class="form-control wxtoken" readonly="readonly">
							</div>
							<div class="form-group">
								<label>EncodingAESKey：</label>
								<input type="text" placeholder="消息加解密密钥" value="" class="form-control aeskey" readonly="readonly">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-primary _close">关闭</button>
                </div>
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
								<input type="text" placeholder="Appid" value="{pg:$payConfig.alipay.appid}" name="alipay[appid]" class="form-control">
							</div>
							<div class="form-group">
								<label>Key</label>
								<input type="text" placeholder="Key" value="{pg:$payConfig.alipay.key}" name="alipay[key]" class="form-control">
							</div>
							<div class="form-group">
								<label>卖家账号</label>
								<input type="text" placeholder="卖家账号" value="{pg:$payConfig.alipay.name}" name="alipay[name]" class="form-control">
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



	
    <script>
	 var apihtml="<button class='btn btn-info api' type='button' {pg:if ($payConfig.alipay.isOpen eq 1)} checked='checked' {pg:/if} id='wxApiSetting'> API接口 </button>";
	 {pg:if !($_mid gt 0)}
		apihtml='';
	 {pg:/if}
	 if(mobilecheck()){
	     $('#wxapiinfo1').append(apihtml);
		 $('#wxapiinfo1 .api').css('margin-top','15px');
		 $('#new_wxpay_box .uploade').css('display','none');
		 $('#new_wxpay_box').append('<div class="form-group noticee"><label>apiclient_cert私钥文件，apiclient_key公钥文件，CA证书文件等配置请登陆PC端修改</label></div>');
	 }else{
		 $('#new_wxpay_box .uploade').css('display','block');
		 $('#new_wxpay_box .noticee').remove();
	     $('#wxapiinfo2').html(apihtml);
	 }
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
			/*$('.switch').change(function(){
				if($(this).val() == 1){
					$('.ibox-content').hasClass('hide') && ($('.ibox-content').removeClass('hide')),$('.ibox-content').show();
				}else if($(this).val() == 0){
					$('.ibox-content').hide();
				}
				$.post('?m=System&c=pay&a=field',{isOpen:$(this).val()});
			});*/
			$('.btn-confirm').click(function(){
				var payConfigData = $(this).parents('form').serialize();
				$.post('?m=System&c=pay&a=config',{data:htmlToArray(payConfigData)},function(result){
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
			/*$('.isOpen').on('ifChanged', function(){
				if($(this).is(':checked')){
					var isOpen = 1;
				}else{
					var isOpen = 0;
				}
				var payConfigData = {};
				typeof(payConfigData[$(this).attr('data-type')]) == 'undefined' && (payConfigData[$(this).attr('data-type')] = {}),payConfigData[$(this).attr('data-type')].isOpen = isOpen;
				$.post('?m=System&c=pay&a=config',{data:payConfigData});
			});*/
			$(".dropz").dropzone({
				url: "?m=System&c=pay&a=pem_upload",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".pem",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $(".dropz")****/
						$(this.element).siblings('.form-control').val('pem文件已上传');
						$(this.element).siblings('.form-control').attr('readonly','readonly');
						$(this.element).siblings('.hiddeninput').val(rept.fileUrl);
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

		 $("#wxApiSetting").click(function(){
			$.post('/merchants.php?m=System&c=pay&a=getApiData',function(ret){
			    $('#wxApi_Setting .wxtoken').val(ret.wxtoken);
				$('#wxApi_Setting .aeskey').val(ret.aeskey);
				
				var winW=$(window).width();
				if(winW<750){
				   $('#wxApi_Setting .modal-dialog').css('width','92%');
				}else{
				   $('#wxApi_Setting .modal-dialog').width(730);
				}
				$('body').append('<div class="modal-backdrop in"></div>');
				$('#wxApi_Setting').show();
			},'JSON');
		  });
		  $("#wxApi_Setting ._close").click(function(){
			  $('#wxApi_Setting').hide();
			  $('#wxApi_Setting .wxtoken').val('');
			  $('#wxApi_Setting .aeskey').val('');
			  $('.modal-backdrop').remove();
		  });
    </script>

</body>

</html>