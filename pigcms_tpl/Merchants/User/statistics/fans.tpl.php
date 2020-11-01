<!DOCTYPE html>
<html>
<head>
    <title>商家收入数据统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
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
		.ibox-title li { float: left;width: 30%; }
		#commonpage {float: right;margin-bottom: 10px;}
		#table-list-body .btn-st{background-color: #337ab7;border-color: #2e6da4;cursor:auto;}
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
                    <h2>商家粉丝数据统计</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>statistics</a>
                        </li>
                        <li class="active">
                            <strong>fans</strong>
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
        <h1 class="realtime-title">粉丝支付情况</h1> 
       </div> 
      </div> 
      <div class="js-real-time-region realtime-list-box loading">
       <div class="widget-list">
        <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
         <div class="widget-list-filter"></div>
        </div> 
        <div class="ui-box"> 
         <table class="ui-table ui-table-list" style="padding: 0px;"> 
          <thead class="js-list-header-region tableFloatingHeaderOriginal">
           <tr class="widget-list-header">
		    <th>编号</th>
            <th>昵称</th>
			<th>头像</th>
            <th data-hide="phone">支付总额</th> 
            <th data-hide="phone">退款金额</th> 
            <th data-hide="phone">关注公众号</th>
           </tr>
          </thead>
          <tbody class="js-list-body-region" id="table-list-body">
		   <?php if(!empty($fansarr)){
		      foreach($fansarr as $ovv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $ovv['id'];?></td>
			<td><?php if(!empty($ovv['nickname'])){
			  echo '<span  style="margin-right: 10px;font-size: 14px">'.$ovv['nickname'].'</span>';
			}else{echo $ovv['openid'];}?></td> 
			<td><?php if(!empty($ovv['headimgurl'])){
			    echo '<img src="'.$ovv['headimgurl'].'" height="50px" width="50px">';
			  }?></td>
            <td><?php echo ($ovv['totalfee']/100);?> 元</td> 
            <td><?php echo ($ovv['refund']/100);?> 元</td> 
			<td><?php if($ovv['is_subscribe']>0){ echo "已关注";}else{echo "未关注";}?></td>
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="7">暂无粉丝支付</td></tr>
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
 <script>
 $(document).ready(function(){
 $('.ui-table-list').footable();
	});
 </script>
 <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/commonfunc.js"></script>
</html>