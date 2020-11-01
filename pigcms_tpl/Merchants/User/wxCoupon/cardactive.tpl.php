<!DOCTYPE html>
<html>
<head>
<title>创建会员卡</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/card_control.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/section_card_notification.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<style type="text/css">
#dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
#dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
#dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
#dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
.ibox-content{ min-height:800px;}
.dropz .dz-image-preview{display:none;}
</style>
<!-- Data picker -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
</head>
<body>
	<div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
		<div id="page-wrapper" class="gray-bg">
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>微信会员卡</h2>
                    <ol class="breadcrumb">
                        <li><a>User</a></li>
                        <li><a>wxCoupon</a></li>
                        <li class="active"><strong>card</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeIn">
				<div class="row" id="wrapper-content-list">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">	
								<div class="alert alert-warning" style="font-size: 16px;"> 设置 【<?php echo $cardinfo['card_title'];?>】的会员信息输入项 </div>
							</div>
							<div class="ibox-content">
								<form id="js_editform" name="js_editform" method="POST" action="?m=User&c=wxCoupon&a=setActivateUserForm"> 
								<input type="hidden" name="id" value="<?php echo $cardinfo['id'];?>" />
								<div class="appmsg_edit_item radio_item"> 
									<div class="frm_control_group radio_row"> 
										<label class="frm_label" for="">必填项</label> 
										<div class="frm_controls frm_vertical_lh"> 
											<div class="radio_control_group group"> 
												<?php foreach ($key_val as $key => $val) {?>
												<label class="frm_radio_label frm_radio_input selected" for="<?php echo $key;?>"> 
												<i class="icon_checkbox"></i>
												<input type="checkbox" class="frm_radio js_validtime" value="<?php echo $key;?>" id="<?php echo $key;?>" name="field_list[]" <?php if (in_array($key, $required_form_id_list)) echo 'checked';?>/>
												<span class="lbl_content"><?php echo $val;?>&nbsp;&nbsp; &nbsp;&nbsp;</span> 
												</label>  
												<?php }?>
											</div> 
										</div>
									</div> 
								</div> 
								<div class="form-group"> 
									<label class="frm_label"> <strong class="title">必填自定义项：</strong></label> 
									<input type="text" placeholder="请填写自定项名称，多个用逗号（，）隔开" class="form-control" name="custom" value="<?php echo $required_form_custom_field_list;?>" /> 
								</div>
								<div class="appmsg_edit_item radio_item"> 
									<div class="frm_control_group radio_row"> 
										<label class="frm_label" for="">选填项</label> 
										<div class="frm_controls frm_vertical_lh"> 
											<div class="radio_control_group group"> 
												<?php foreach ($key_val as $key => $val) {?>
												<label class="frm_radio_label frm_radio_input selected" for="<?php echo $key;?>1"> 
												<i class="icon_checkbox"></i>
												<input type="checkbox" class="frm_radio js_validtime" value="<?php echo $key;?>" id="<?php echo $key;?>1" name="sel_field_list[]" <?php if (in_array($key, $optional_form_id_list)) echo 'checked';?>/>
												<span class="lbl_content"><?php echo $val;?>&nbsp;&nbsp; &nbsp;&nbsp;</span> 
												</label>  
												<?php }?>
											</div> 
										</div>
									</div> 
								</div> 
								<div class="form-group"> 
									<label class="frm_label"> <strong class="title">选填自定义项：</strong></label> 
									<input type="text" placeholder="请填写自定项名称，多个用逗号（，）隔开" class="form-control" name="custom_sel" value="<?php echo $optional_form_custom_field_list;?>" /> 
								</div>
								</form>
								<div class="tool_bar border tc">
									<button id="sub_add_card" class="btn btn-primary" style="height: 36px;"> 提交设置 </button>
								</div>
							</div>
						</div>
                    </div>
                </div>
        	</div>
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>
	<!-- DROPZONE -->
</body>
<script type="text/javascript">
$(document).ready(function() {
	  $('#sub_add_card').click(function(){
	  		$.ajax({
	  			url:$('#js_editform').attr('action'),
	  			type:"post",
	  			data:$('form').serialize(),
	  			dataType:"JSON",
	  			success:function(ret){
	  				if(!ret.error){
	  				   window.location.href="?m=User&c=wxCoupon&a=cardindex";
	  				}else{
	  					swal({
	  					  title: "保存失败！",
	  					  text: ret.msg,
	  					  type: "error"
	  					 });
	  			   }
	  			}
	  		});
	  	  return false;
	  	}); 
});
</script>
</html>