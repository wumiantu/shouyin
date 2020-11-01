<!DOCTYPE html>
<html>
<head>
    <title>收银台 | 二维码记录</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
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
		.ibox-title li:nth-child(1) { float: left;width: 30%; }
		.ibox-title li:nth-child(2) { float: left;width: 32%; }
		.ibox-title li:nth-child(3){width: 35%; }
		#commonpage {float: right;margin-bottom: 10px;}
		.ui-centered-image img{cursor: pointer;}
		.ui-centered-image .tipsdiv{background-color: #1AB394;cursor: pointer;font-size: 22px;left: 80px;position: absolute;top: 55px;color: #F4FAF9;border-radius: 11px;padding: 5px;}
		.ui-centered-image { position: relative;}
		#ewmPopDiv .modal-body{text-align: center;}
		.float-e-margins .ibox-content{border-style:none;}
		.nav-tabs > li > a:hover,
		.nav-tabs > li > a:focus {
		 background-color: #FFF;
		}
		.nav-tabs li.active  a {border-color:#dddddd #dddddd #fff}
		.nav-tabs li.active  a:hover,.nav-tabs li.active a:focus {border-color:#dddddd #dddddd #fff;background-color:#FFF;}
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
                    <h2>收银台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Cashier</a>
                        </li>
                        <li class="active">
                            <strong>EwmRecord</strong>
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
						<ul class="nav nav-tabs"> 
						<li> <a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=index">收银台</a> </li> 
						<li> <a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=payRecord">收款记录</a> </li> 
						<li class="active"> <a href="">二维码记录</a> </li> 
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
        <h1 class="realtime-title">二维码记录</h1> 
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
            <th>二维码</th> 
            <th data-hide="phone">付款金额(元)</th>
			<th data-hide="phone">生成时间</th>
			<th data-hide="phone">支付状态</th> 
			<th data-hide="phone">付款理由</th>
			<th>操作</th>
           </tr>
          </thead>
          <tbody class="js-list-body-region">
		   <?php if(!empty($neworder)){
		      foreach($neworder as $ovv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $ovv['id'];?></td> 
			<td><div class="ui-centered-image">
			<img src="<?php echo $this->RlStaticResource;?>images/qrcode.png" width="90">
			  <input type="hidden" value="<?php echo $ovv['ewmurl']?>">
			</div></td> 
			<td><?php echo $ovv['goods_price'];?></td> 
            <td><?php echo date('Y-m-d H:i:s',$ovv['add_time']);?></td> 
			<td><?php  if($ovv['ispay']>0){
					echo '<font color="green">已支付</font>';
				}else{
					echo  '<font color="red">未支付</font>';
				}?><br/><br/>
				<?php if($ovv['refund']==1){?>
						 退款中...
					<?php }elseif($ovv['refund']==2){?>
						 已退款
					<?php }elseif($ovv['refund']==3){?>
						退款失败
					<?php }?>
				</td> 
			<td><?php echo htmlspecialchars_decode($ovv['goods_name'],ENT_QUOTES);?></td> 
			<td><button class="btn btn-sm btn-danger" onclick="deltheOrder(this,<?php echo $ovv['id'];?>,<?php echo $ovv['mid'];?>);"><strong> 删 除 </strong></button></td> 
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="6">暂无记录</td></tr>
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
                    <h4 class="modal-title">支付二维码</h4>
                </div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white _close">关闭</button>
                </div>
			</div>
		</div>
	</div>

</body>
	<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/canvas2image.js"></script>
	 <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/commonfunc.js"></script>
    <script>
	 	if(is_mobile()){
			$('.row .col-lg-12').css('padding','1px');
			 $('.nav-tabs li a').css('padding','10px');
		}
	   var bodyW=$('body').width();
	   bodyW=bodyW-80;
	   if(bodyW>350) bodyW=350;
        $(document).ready(function(){
			$('.ui-table-list').footable();
		   $(".ui-centered-image").click(function(){
		     	var ewm_url=$(this).find('input').val();
				$('#ewmPopDiv .modal-body').qrcode({ 
					//render: "table", //table方式 
					width: bodyW, //宽度 
					height:bodyW, //高度 
					text:ewm_url//任意内容 
			   });
			   $('body').append('<div class="modal-backdrop in"></div>');
			   $('#ewmPopDiv').show();
		   });

		  $("#ewmPopDiv ._close").click(function(){
			  $('#ewmPopDiv').hide();
			  $('.modal-backdrop').remove();
			  $('#ewmPopDiv .modal-body').html('');
		  });
        });
    </script>

</html>