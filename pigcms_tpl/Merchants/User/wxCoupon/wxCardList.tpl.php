<!DOCTYPE html>
<html>
<head>
    <title>领卡记录</title>
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
                    <h2>领卡记录</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>wxCoupon</a>
                        </li>
                        <li class="active">
                            <strong>wxCardList</strong>
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
			  window.location.href="?m=User&c=wxCoupon&a=card";
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