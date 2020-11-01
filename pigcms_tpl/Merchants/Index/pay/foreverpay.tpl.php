<!DOCTYPE html>
<html class="" lang="zh-CN">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
  <meta charset="utf-8" /> 
  <meta name="keywords" content="" /> 
  <meta name="HandheldFriendly" content="True" /> 
  <meta name="MobileOptimized" content="320" /> 
  <meta name="format-detection" content="telephone=no" /> 
  <meta http-equiv="cleartype" content="on" /> 
  <title><?php echo $ordertmp['title']?></title> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
  <link rel="stylesheet" href="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/styles/foreverpay.css"/> 
  <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jquery.js"/> </script>
 </head> 
 <body> 
  <div class="container" style="margin-top:15px;"> 
   <div class="content fixed-cash "> 
   <form method="post" action="" name="myform" id="mydataform">
    <div class="cashier-info-container center"> 
	 <?php if(isset($wxuserinfo['headimgurl']) && !empty($wxuserinfo['headimgurl'])){?>
     <div class="avatar cashier-avatar"> 
      <a href="javascript:;"> <img class="circular" src="<?php echo $wxuserinfo['headimgurl'];?>" /> </a> 
     </div> 
	 <?php } ?>
     <p class="avatar-price anonym"> <span class="rmb">￥</span><?php echo $ordertmp['price']?> </p> 
     <p class="reason"> 收款理由：<?php echo $ordertmp['title']?> </p> 

     <?php if(isset($wxuserinfo['nickname']) && !empty($wxuserinfo['nickname'])){?>
     <div class="block-wrapper-form payer-form"> 
      <div class="block-form-item"> 
       <label class="item-label">付款人</label> 
       <input type="text" class="item-input" id="js-payer-tname"  name="tname" value="<?php echo $wxuserinfo['nickname'];?>" /> 
      </div> 
     </div>
	 <?php }?>
	 
    </div>
	<input type="hidden" value="<?php echo $ordertmp['mid']?>"  name="mid">
	<input type="hidden" value="<?php echo $ordertmp['price']?>"  name="goods_price">
	<input type="hidden" value="<?php echo $ordertmp['title']?>"  name="goods_name">
	<input type="hidden" value="weixin" id="paytype" name="paytype">
	</form>
    <div class="action-container" id="js-cashier-action">
     <div style="margin-bottom: 10px;"> 
      <button class="btn-pay btn btn-block btn-large btn-umpay  btn-green" onclick="ByWxPay();"> 微信支付 </button>
     </div>
     <div style="margin-bottom: 10px;"> 
      <!--<button type="button" data-pay-type="baiduwap" class="btn-pay btn btn-block btn-large btn-baiduwap  btn-white"> 储蓄卡付款 </button>-->
     </div>
    </div> 
	
    <!--<div class="center action-tip js-cashier-tip">
     支付完成后，如需退款请及时联系卖家
    </div>-->
   </div> 
  </div> 
  <div class="footer"> 
  </div> 
  <script type="text/javascript">
  <?php if(defined('ABS_UPLOAD_PATH')){?>
  var formPostUrl="<?php echo ABS_UPLOAD_PATH;?>/pay/wxpay/index.php?m=Index&c=pay&a=foreverpaying&ordid=<?php echo  $orderid;?>";
  <?php }else{?>
  var formPostUrl="/pay/wxpay/index.php?m=Index&c=pay&a=foreverpaying&ordid=<?php echo  $orderid;?>";
  <?php } ?>
  </script>
	<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/topay.js?var=<?php echo time();?>"/> </script>
 </body>
</html>