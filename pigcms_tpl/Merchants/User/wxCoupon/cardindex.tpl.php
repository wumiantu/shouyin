<!DOCTYPE html>
<html>
<head>
    <title>微信会员卡</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
	<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
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
		}
		.fa-paste{
			margin-right:7px;
			padding: 0px;
		}
		.dz-preview{
			display:none;
		}
		.ibox-title ul{ list-style: outside none none !important; margin: 0; padding: 0;}
		.ibox-title li { float: left;width: 30%; }
		#commonpage {float: right;margin-bottom: 10px;}
		#table-list-body .btn-st{background-color: #337ab7;border-color: #2e6da4;cursor:auto;}
		#select_Cardtype .i-checks label{cursor: pointer;}
		#ewmPopDiv .modal-body{text-align: center;}
	.modal-footer {text-align: center;}
	.modal-footer .btn {padding: 7px 30px;}
	.js_modify_quantity .fa{margin-left: 10px;}
	#ewmPopDiv .downewm{ font-size: 14px;padding: 15px;text-align: center;}
	.modal-body {padding: 20px 30px 15px;}
	#select_Cardtype p{ margin-bottom: 8px;}
	</style>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
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
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>wxCoupon</a>
                        </li>
                        <li class="active">
                            <strong>cardindex</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-12">
            	    <div class="ibox float-e-margins">
            	        <div class="ibox-title clearfix">
						<ul class="nav"> 
						<li><button class="btn btn-primary" id="pop_add_card"><i class="fa fa-plus"></i> 创建新会员卡 </button></li> 
						</ul> 
            	     </div>
<div class="ibox-content"> 
   <nav class="ui-nav clearfix"> 
    <!--<div class="pull-right common-helps-entry"> 
     <a href="" target="_blank"> <span class="help-icon"></span> 查看【收银台】使用教程 </a> 
    </div>--->
   </nav> 
   <div class="app__content js-app-main page-cashier">
    <div>
      <!-- 实时交易信息展示区域 --> 
      <div class="cashier-realtime"> 
       <div class="realtime-title-block clearfix"> 
        <h1 class="realtime-title">卡券列表</h1> 
       </div> 
      </div> 
      <div class="js-real-time-region realtime-list-box loading">
       <div class="widget-list">
        <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
         <div class="widget-list-filter"></div>
        </div> 
        <div class="ui-box"> 
         <table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px;"> 
          <thead class="js-list-header-region tableFloatingHeaderOriginal">
           <tr class="widget-list-header">
		    <th>编号</th>
            <th data-hide="phone">卡券名称</th>
			<th data-hide="phone">卡券ID</th>
            <th data-hide="phone">卡券有效期</th> 
            <th data-hide="phone">状态</th>
			<th data-hide="phone">库存</th>
			<th data-hide="phone">操作</th>
           </tr>
          </thead>
          <tbody class="js-list-body-region" id="table-list-body">
		   <?php if(!empty($wxcoupons)){
		      foreach($wxcoupons as $ovv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $ovv['id'];?></td>
			<td><?php echo $ovv['card_title'];?></td> 
            <td><?php echo $ovv['card_id'];?></td> 
            <td><?php echo date('Y-m-d',$ovv['begin_timestamp']).' 至 '.date('Y-m-d',$ovv['end_timestamp']);?></td> 
			<td><?php echo $ovv['statusstr'];?></td>
			<td><span><?php echo $ovv['quantity'];?></span><a class="icon_edit js_modify_quantity" href="javascript:;" data-actionid="<?php echo $ovv['id'];?>" data-cdid="<?php echo $ovv['card_id'];?>"><i class="fa fa-pencil"></i></a></td>
			<td class="footable-visible footable-last-column">
			<button class="btn btn-sm btn-primary btn-primary-ewm" data-cdid="<?php echo $ovv['id'];?>"><strong>查看二维码</strong></button>  
			<button class="btn btn-sm <?php if (empty($ovv['is_open_cell'])) echo 'btn-primary'; else echo 'btn-danger';?> btn-primary-cell" data-cdid="<?php echo $ovv['id'];?>"><strong><?php if (empty($ovv['is_open_cell'])) echo '增加'; else echo '取消';?>买单功能</strong></button>  
			<a class="btn btn-sm btn-info"  href="?m=User&c=wxCoupon&a=cardetail&id=<?php echo $ovv['id'];?>" style="vertical-align:top;"> 详 情 </a> 
			<button class="btn btn-sm btn-primary btn-primary-info" data-cdid="<?php echo $ovv['id'];?>"><strong>设置填写资料</strong></button> 
			<button onclick="deltheOrder(this,<?php echo $ovv['id'];?>);" class="btn btn-sm btn-danger"><strong> 删 除 </strong></button>
			</td>
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="8">暂无卡券</td></tr>
		   <?php }?>
          </tbody> 
         </table> 
         <div class="js-list-empty-region"></div> 
        </div> 
        <div class="js-list-footer-region ui-box">
         <div class="widget-list-footer"></div>
        </div> 
       </div>
      </div> 
     </div>
    </div>
   </div> 
  </div>    
            	</div>
				<?php echo $pagebar;?>
            </div>
        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>

<div class="modal inmodal" tabindex="-1" role="dialog"  id="ewmPopDiv">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close _close"><span style="font-size: 35px;">×</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">卡券领取二维码</h4>
			</div>
			<div class="modal-body"></div>
			<div class="downewm"><a href="javascript:;">点击下载此二维码</a></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white _close">关闭</button>
			</div>
		</div>
	</div>
</div>

<div class="popover" id="quantitypopover">
    <div class="popover_inner">
        <div class="popover_content"><div class="pop_store">
	<!--增减库存-->
	
	<div class="frm_control_group">
        <div class="frm_controls">
			<label class="frm_radio_label selected">
				<input type="radio" class="frm_radio" value="1" checked="" name="isadd">
				<span class="lbl_content">增加</span>
			</label>
			<label class="frm_radio_label">
				<input type="radio" class="frm_radio" value="0" name="isadd">
				<span class="lbl_content">减少</span>
			</label>
		</div>
	</div>
	
	<div class="frm_control_group">                        
		<div class="frm_controls">
			<div class="frm_controls_hint group">
				<span class="frm_input_box"><input type="text" name="quantitynum" class="frm_input js_value" onkeyup="value=value.replace(/[^1234567890]+/g,'')"></span>
				<span class="frm_hint"> 份</span>
			</div>
			<p class="frm_tips fail">库存不能少于1</p>
		</div>
	</div>
	<!--增减库存 end-->
</div></div>
        <div class="popover_bar">
			<button type="button" class="btn btn-primary btn_confirm">确 定</button>&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-white c-close">取 消</button>
        </div>
        
    </div>
    <i class="popover_arrow popover_arrow_out"></i>
    <i class="popover_arrow popover_arrow_in"></i>
</div>

</body>


<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
 <script>
 
var actid=0,cdid;
var numObj='';
 $(document).ready(function(){
		$('.ui-table-list').footable();
         $('#select_Cardtype .i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
		  $("#pop_add_card").click(function(){
			  window.location.href="?m=User&c=wxCoupon&a=card";
		   });

		  $(".btn-primary-ewm").click(function(){
		     	var cdid=$(this).data('cdid');
				$.post('?m=User&c=wxCoupon&a=wxCardQrCodeTicket',{cdid:cdid},function(rets){
					if(!rets.error){
						$('#ewmPopDiv .modal-body').append('<img src="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=wxCoupon&a=qrcode&cdid='+cdid+'">');
						$('body').append('<div class="modal-backdrop in"></div>');
						$('#ewmPopDiv .downewm a').attr('href','<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=wxCoupon&a=qrcode&cdid='+cdid+'&dwd=1');
						$('#ewmPopDiv').show();
					}else{
						swal({
								title: "获取二维码失败！",
								text: rets.msg,
								type: "error"
							});
					}
				},'JSON');
		   });

		  $("#ewmPopDiv ._close").click(function(){
			  $('#ewmPopDiv').hide();
			  $('.modal-backdrop').remove();
			  $('#ewmPopDiv .modal-body').html('');
		  });

		  $(".btn-primary-cell").click(function(){
				var obj = $(this), id = $(this).data('cdid');
				$.post('?m=User&c=wxCoupon&a=setPayCell', {id:id}, function(rets){
					if(!rets.errcode){
						if (obj.html() == '<strong>取消买单功能</strong>') {
							obj.removeClass('btn-danger').addClass('btn-primary');
							obj.html('<strong>增加买单功能</strong>');
						} else {
							obj.removeClass('btn-primary').addClass('btn-danger');
							obj.html('<strong>取消买单功能</strong>');
						}
					}else{
						swal({
								title: "更新失败！",
								text: rets.errmsg,
								type: "error"
							});
					}
				},'JSON');
		   });

		  $(".btn-primary-info").click(function(){
				var obj = $(this), id = $(this).data('cdid');
				$.post('?m=User&c=wxCoupon&a=setActivateUserForm', {id:id}, function(rets){
					if(!rets.errcode){
						swal({
							title: "设置",
								text: "设置成功",
								type: "success"
							});
					}else{
						swal({
								title: "设置！",
								text: rets.errmsg,
								type: "error"
							});
					}
				},'JSON');
		   });
		/*$('.js_modify_quantity').click(function(){
		   var id=$(this).data('actionid');
		   var cdid=$(this).data('cdid');
		   var offsetpx=$(this).offset();
		   $('#quantitypopover').css('position','absolute').css('left',offsetpx.left-121).css('top',offsetpx.top+7).css('zIndex','100').show();
		});*/
	$(document).on('click',function(e){
		   var target = $(e.target);
		   var quantityobj=target.closest(".js_modify_quantity");
		   if(quantityobj.size()!=0){
		    actid=quantityobj.data('actionid');
		    cdid=quantityobj.data('cdid');
			numObj=quantityobj.siblings('span');
		   var offsetpx=quantityobj.offset();
		   $('#quantitypopover').css('position','absolute').css('left',offsetpx.left-121).css('top',offsetpx.top+7).css('zIndex','100').show();
		   }else if(target.closest("#quantitypopover").size()==0){
			   actid=0;cdid='';numObj='';
		      $("#quantitypopover").hide();
		   }
		});

		$("#quantitypopover .c-close").click(function(){
			  actid=0;cdid='';numObj='';
		     $("#quantitypopover").hide();
		});

		$("#quantitypopover .btn_confirm").click(function(){
			var datas = {cdid:cdid,id:actid};
			var qtype = $('.frm_control_group input:checked').val();
			var qmun = $('.frm_control_group input[name="quantitynum"]').val();
			qmun=parseInt(qmun);
			if(!(qmun > 0)){
			   $('.frm_control_group input[name="quantitynum"]').focus();
			   return false;
			}
			datas.qtype=qtype;
			datas.qmun=qmun;
		    if(actid>0 && cdid){
		     $("#quantitypopover").hide();
				actid=0;cdid='';
				$.ajax({
				url: "?m=User&c=wxCoupon&a=ModifyStock",
				type: "POST",
				dataType: "json",
				data:datas,
				success: function(res){
					if(!res.error){
						if(numObj){
						     numObj.text(res.msg);
						}
						numObj='';
						swal({
							title: "修改成功",
								text: "修改成功",
								type: "success"
							});
					}else{
						swal({
								title: "修改失败",
								text: res.msg,
								type: "error"
							}, function () {
								//window.location.reload();
							});
					}
				}
				});
			}
		});
	});
/*****删除处理******/
function deltheOrder(dom,id){
   if(confirm('您确定要删除此项？')){
		$.ajax({
			url: "?m=User&c=wxCoupon&a=delCardByid",
			type: "POST",
			dataType: "json",
			data:{cdid:id},
			success: function(res){
				if(!res.error){
					swal({
        				title: "删除成功",
        					text: res.msg,
        					type: "success"
    					}, function () {
        					$(dom).parent().parent('tr').remove();
   						});

				}else{
					swal({
        					title: "删除失败",
        					text: res.msg,
        					type: "error"
    					}, function () {
        					//window.location.reload();
   						});
				}
				
				/*setTimeout(function(){
				  window.location.reload();
				}, 1000);*/
			}
		});
   }
}
 </script>
 
</html>