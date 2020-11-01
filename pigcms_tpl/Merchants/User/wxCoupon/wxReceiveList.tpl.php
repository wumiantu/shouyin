<!DOCTYPE html>
<html>
<head>
    <title>核销卡券</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
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
			padding:3px;
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
                    <h2>微信卡券</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>wxCoupon</a>
                        </li>
                        <li class="active">
                            <strong>wxReceiveList</strong>
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
						<li><button class="btn btn-primary" id="pop_add_card"><i class="fa fa-plus"></i> 创建新卡券 </button></li> 
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
        <h1 class="realtime-title">卡券核销列表</h1> 
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
            <th>卡券类型</th> 
            <th data-hide="phone">卡券名称</th>
			<th data-hide="phone">卡券ID</th>
            <th data-hide="phone">领取人OpenId</th> 
            <th data-hide="phone">状态</th>
			<th data-hide="phone">核销码</th>
			<th data-hide="phone">领取时间</th>
			<th data-hide="phone">核销时间</th>
			<!--<th data-hide="phone">操作</th>-->
           </tr>
          </thead>
          <tbody class="js-list-body-region" id="table-list-body">
		   <?php if(!empty($wxReceiveUser)){
		      foreach($wxReceiveUser as $rvv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $rvv['id'];?></td>
			<td><?php echo $this->card_type[$rvv['cardtype']]['zhname'];?></td> 
			<td><?php echo $rvv['card_title'];?></td> 
            <td><?php echo $rvv['cardid'];?></td> 
            <td><?php if(!empty($rvv['nickname'])){echo $rvv['nickname'];}else{echo $rvv['openid'];}?></td> 
			<td><?php if($rvv['status']>0){ echo '<span class="btn btn-sm btn-primary">已核销</span>';}else{ echo '<span class="btn btn-sm btn-danger">已领取</span>';}?></td>
			<td><?php echo $rvv['cardcode'];?></td>
			<td><?php echo date('Y-m-d H:i:s',$rvv['addtime']);?></td>
			<td><?php if($rvv['consumetime']>0) echo date('Y-m-d H:i:s',$rvv['consumetime']);?></td>
			<!--<td class="footable-visible footable-last-column"><button onclick="deltheOrder(this,<?php echo $rvv['id'];?>);" class="btn btn-sm btn-primary"><strong> 删 除 </strong></button></td>-->
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="10">暂无卡券领取数据</td></tr>
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

		<div class="modal inmodal" tabindex="-1" role="dialog"  id="Pop_Set_Cardtype">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span style="font-size: 35px;">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">选择卡券类型</h4>
                </div>
				<div class="modal-body">
				<div class="dialog_bd">
					<div class="setting_rows">
					<div class="frm_control_group radio_row">
						<label class="frm_label" for="">选择你要创建的卡券类型</label>
						<div id="select_Cardtype">
							<div class="i-checks">
								<label for="checkbox1">
								<input type="radio"  value="2" id="checkbox1" name="cardtype"> &nbsp;折扣券 <i></i>
								</label>
								<p class="frm_tips">可为用户提供消费折扣</p>
							</div>
							<div class="i-checks">
								<label for="checkbox2">
								<input type="radio"  value="4" id="checkbox2" name="cardtype"> &nbsp;代金券
								<i></i>
								</label>
								<p class="frm_tips">可为用户提供抵扣现金服务。可设置成为“满*元，减*元”</p>
							</div>
							<div class="i-checks">
								<label for="checkbox3">
								<input type="radio"  value="3" id="checkbox3" name="cardtype"> &nbsp;礼品券
								<i></i>
								</label>
								<p class="frm_tips">可为用户提供消费送赠品服务</p>
							</div>
						
							<div class="i-checks">
								<label for="checkbox4">
								<input type="radio"  value="1" id="checkbox4" name="cardtype"> &nbsp;团购券
								<i></i>
								</label>
								<p class="frm_tips">可为用户提供团购套餐服务</p>
							</div>
						
							<div class="i-checks">
								<label for="checkbox5">
								<input type="radio"  value="0" id="checkbox5" name="cardtype" checked="checked"> &nbsp;优惠券
								<i></i>
								</label>
								<p class="frm_tips">即“通用券”，建议当以上四种无法满足需求时采用</p>
							</div>
						</div>
					</div>
					</div>
					</div>
				</div>
				<div class="modal-footer">
				   <button type="button" class="btn btn-primary btn-confirm">确 定</button>&nbsp;&nbsp;&nbsp;
                   <button type="button" class="btn btn-white _close">取 消</button>
                </div>
			</div>
		</div>
	</div>

</body>
    <!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
 <script>
 $(document).ready(function(){
	 if ($(this).width() < 769) {
		$('.float-e-margins .ibox-title').hide();
     } else {
		$('.float-e-margins .ibox-title').show();

     }
		$('.ui-table-list').footable();
         $('#select_Cardtype .i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
		  $("#pop_add_card").click(function(){
			   $('body').append('<div class="modal-backdrop in"></div>');
			   $('#Pop_Set_Cardtype').show();
		   });

		  $("#Pop_Set_Cardtype ._close").click(function(){
			  $('#Pop_Set_Cardtype').hide();
			  $('.modal-backdrop').remove();
		  });

		 $("#Pop_Set_Cardtype .btn-confirm").click(function(){
			  var typeid=$.trim($('#select_Cardtype input:checked').val());
			  typeid=parseInt(typeid);
			  if(typeid >= 0){
				 window.location.href="?m=User&c=wxCoupon&a=createKq&typeid="+typeid;
			  }else{
			     alert('请选择一个卡券类型！');
				 return false;
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