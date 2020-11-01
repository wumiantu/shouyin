<!DOCTYPE html>
<html>
<head>
    <title>收银台 | 支付详细</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
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
		.ibox-title li { float: left;width: 8%; }
		#spantext{    display: inline-block;height: 32px;line-height: 29px;position: relative;top: -10px;}
		#qr-code-zone canvas{vertical-align: middle;}
		#qr-code-zone {line-height: 195px;}
		#qr-code-forever canvas{vertical-align: middle;}
		#qr-code-forever {line-height: 195px;}
		.info-table-right{}
	</style>
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
                            <strong>Odetail</strong>
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
				<li class="active"> <a href="">订单详情</a> </li> 
				<li> <a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=index">收银台</a> </li> 
				<li> <a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=payRecord">收款记录</a> </li> 
				</ul> 
            </div>
					 
          <div class="ibox-content">

   <div class="page-trade-order-detail">
         <?php if(!empty($orderInfo)){ ?>
			<div class="step-region">
			 <ul class="ui-step ui-step-4">
			  <li class="ui-step-done">
					<div class="ui-step-title">买家下单</div>
					<div class="ui-step-number">1</div>
					<div class="ui-step-meta"><?php echo date('Y-m-d H:i:s',$orderInfo['add_time'])?></div>
				</li>
			  <li class="ui-step-done">
					<div class="ui-step-title">付款至平台</div>
					<div class="ui-step-number">2</div>
					<div class="ui-step-meta"><?php echo date('Y-m-d H:i:s',$orderInfo['paytime'])?></div>
			   </li>
			  <li class="ui-step-done">
					<div class="ui-step-title">商家发货</div>
					<div class="ui-step-number">3</div>
					<div class="ui-step-meta"><?php echo date('Y-m-d H:i:s',$orderInfo['paytime'])?></div>
			   </li>
			  <li class="ui-step-done">
					<div class="ui-step-title">结算货款</div>
					<div class="ui-step-number">4</div>
					<div class="ui-step-meta"><?php echo date('Y-m-d H:i:s',$orderInfo['paytime'])?></div>
			   </li>
			 </ul>
			</div>
			
			<div class="content-region clearfix">
			
			 <div class="info-region">
			  <h3><span>订单信息</span></h3>
			  <table class="info-table">
			   <tbody>
				<tr>
				 <th>订单编号：</th>
				 <td><span><?php echo $orderInfo['order_id'];?></span><span> </span></td>
				 <td width="50px"></td>
				 <th>付款方式：</th>
				 <td><?php if($orderInfo['pay_way']=='weixin'){ echo "微信";
				     if($orderInfo['pay_type']=='wxsaoma2pay'){
					      echo " - 扫码";
					 }elseif($orderInfo['pay_type']=='micropay'){
					      echo " - 刷卡";
					 }elseif($orderInfo['pay_type']=='wxJSAPI'){
					     echo " - 公众号";
					 }
					 echo "支付";
				 }else{
				      echo "其他支付";
				 }?></td>
				</tr>
				<tr>
				 <th>第三方支付订单ID：</th>
				 <td><span><?php echo $orderInfo['transaction_id']?></span><span> </span></td>
				 <td width="50px"></td>
				 <th>支付者：</th>
				 <td><?php if(!empty($orderInfo['truename'])){ echo		htmlspecialchars_decode($orderInfo['truename'],ENT_QUOTES);
				 }elseif(!empty($orderInfo['openid'])){
				      echo $orderInfo['openid'];
				 }else{
					  echo '未知';
				 }?></td>
				</tr>
			   </tbody>
			  </table>
			  <div class="dashed-line"></div>
			 </div>
				 <div class="state-region">
					 <h3><span>退款情况</span></h3>
					 <?php if($orderInfo['refund']>0){?>
					 <div class="state-desc"><p><?php if($orderInfo['refund']==1){?>
						退款中...
						<?php }elseif($orderInfo['refund']==2){?>
						 已退款
						<?php }elseif($orderInfo['refund']==3){?>
						退款失败
						 <?php }?></p></div>
					 <div class="state-action"><?php if(!empty($orderInfo['refundtext'])){?><p>
					     <?php if(isset($orderInfo['refundtext']['refund_time'])){?>
						    <span>退款时间：<?php echo date('Y-m-d H:i:s',$orderInfo['refundtext']['refund_time'])?></span>
					     <?php }?>
						 <?php if($orderInfo['refundtext']['return_code'] == 'SUCCESS'){
						   if($orderInfo['refundtext']['result_code'] != 'SUCCESS'){
						       echo "&nbsp;&nbsp;<span>".$orderInfo['refundtext']['err_code_des']."</span>";
						   }else{
						       echo "&nbsp;&nbsp;<span>退款成功！</span>";
						     }  
						 ?> 
						 <?php }else{
						    echo "&nbsp;&nbsp;<span>".$orderInfo['refundtext']['return_msg']."</span>";
						 }?>
					 </p><?php }?></div>
					 <?php }else{
					    echo '<div class="state-desc"><p>无</p></div>';
					 }?>
				 </div>
			</div>

		<table class="ui-table ui-table-simple goods-table">
		 <thead>
		  <tr>
		   <th></th>
		   <th class="cell-38">商品名称</th>
		   <th>支付金额(元)</th>
		   <th class="cell-15">支付人</th>
		   <th>支付时间</th>
		   <th>状态</th>
		   <th>退款请款</th>
		  </tr>
		 </thead>
		 <tbody>
		  <tr class="test-item">
		   <td class="td-goods-image" rowspan="1">
			<div class="ui-centered-image" width="50" height="50">
			 <img src="<?php echo PIGCMS_TPL_STATIC_PATH;?>images/default_shop.png" style="max-width:50px;max-height:50px;" />
			</div></td>
		   <td><span><?php echo htmlspecialchars_decode($orderInfo['goods_name'],ENT_QUOTES);?></span><p class="c-gray"></p></td>
		   <td><span><?php echo $orderInfo['goods_price'];?></span></td>
		   <td><?php echo htmlspecialchars_decode($orderInfo['truename'],ENT_QUOTES);?></td>
		   <td><?php echo date('Y-m-d H:i:s',$orderInfo['paytime'])?></td>
		   <td><?php if($orderInfo['ispay']>0){
		         echo '<font color="green">已支付</font>';
		   }else{
		       echo  '<font color="red">未支付</font>';
		   }?></td>
		   <td><?php if($orderInfo['refund']==1){?>
			     退款中...
			<?php }elseif($orderInfo['refund']==2){?>
			     已退款
			<?php }elseif($orderInfo['refund']==3){?>
			     退款失败
			 <?php }else{ echo "无";} ?></td>
		  </tr>
		 </tbody>
		 <tfoot>
		  <tr>
		   <td colspan="8" class="text-right"><span class="c-gray">应收总价：</span><span class="real-pay ui-money-income"><span>&yen; </span><span><?php echo $orderInfo['goods_price'];?></span></span></td>
		  </tr>
		 </tfoot>
		</table>
	  <?php }else{?>
		<div class="step-region" style="border: medium none; font-size: 20px; margin-top: 15px;text-align: center;"><div>订单不存在！</div></div>
	  <?php }?>
   </div>
  </div> 
  </div> 
 </div>
  </div> 
			</div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>
</body>

</html>