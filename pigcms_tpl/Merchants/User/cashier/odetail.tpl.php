<style>.modal-body{padding: 10px; }
#ibox-content-me{padding: 0px;}
#ibox-content-me .info-table th{text-align:left;}
</style>
<div class="ibox-content" id="ibox-content-me">
   <div class="page-trade-order-detail">
         <?php if(!empty($orderInfo)){ ?>
			<!--<div class="step-region">
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
			</div>-->
			
			<div class="content-region clearfix">
			
			 <div class="info-region" style="width: 100%;">
			  <h3><span>订单信息</span></h3>
			  <table class="info-table">
			   <tbody>
			   	<tr>
				 <th>商品名称：</th>
				 <td>&nbsp;&nbsp;<span><?php echo htmlspecialchars_decode($orderInfo['goods_name'],ENT_QUOTES);?></span></td>
				 </tr>
				<tr>
				 <th>订单编号：</th>
				 <td>&nbsp;&nbsp;<span><?php echo $orderInfo['order_id'];?></span></td>
				 </tr>
				 <tr>
				 <tr>
				 <th>付款方式：</th>
				 <td>&nbsp;&nbsp;<?php if($orderInfo['pay_way']=='weixin'){ echo "微信";
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
				 <td>&nbsp;&nbsp;<span><?php echo $orderInfo['transaction_id']?></span></td>
				 </tr>
				 <tr>
				 <th>支付者：</th>
				 <td>&nbsp;&nbsp;<?php if(!empty($orderInfo['truename'])){ echo		htmlspecialchars_decode($orderInfo['truename'],ENT_QUOTES);
				 }elseif(!empty($orderInfo['openid'])){
				      echo $orderInfo['openid'];
				 }else{
					  echo '未知';
				 }?></td>
				</tr>
				<tr>
				<th>退款情况：</th>
				<td>&nbsp;&nbsp;
				 <?php if($orderInfo['refund']>0){?>
					 <span><?php if($orderInfo['refund']==1){?>
						退款中...
						<?php }elseif($orderInfo['refund']==2){?>
						 已退款
						<?php }elseif($orderInfo['refund']==3){?>
						退款失败
						 <?php }?></span>
				 <?php }else{
					    echo '<span>无</span>';
				  }?>
				  </td>
				  </tr>
				  <?php if(!empty($orderInfo['refundtext'])){?>
				     		<tr>
							<th>退款时间：</th>
							<td>&nbsp;&nbsp;
					     <?php if(isset($orderInfo['refundtext']['refund_time'])){?>
						   <?php echo date('Y-m-d H:i:s',$orderInfo['refundtext']['refund_time'])?></span>
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
						</td>
						</tr>
					 <?php }?>
			   </tbody>
			  </table>
			  <div class="dashed-line"></div>
			 </div>

			</div>

		<table class="ui-table ui-table-simple goods-table">
		 <thead>
		  <tr>
		   <th>支付金额(元)</th>
		   <th data-hide="phone">支付人</th>
		   <th data-hide="phone">支付时间</th>
		   <th data-hide="phone">状态</th>
		  </tr>
		 </thead>
		 <tbody>
		  <tr class="test-item">
		   <td><span><?php echo $orderInfo['goods_price'];?></span></td>
		   <td><?php echo htmlspecialchars_decode($orderInfo['truename'],ENT_QUOTES);?></td>
		   <td><?php echo date('Y-m-d H:i:s',$orderInfo['paytime'])?></td>
		   <td><?php if($orderInfo['ispay']>0){
		         echo '<font color="green">已支付</font>';
		   }else{
		       echo  '<font color="red">未支付</font>';
		   }?></td>
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
  <script>
   $('.ui-table-simple').footable();
	</script>