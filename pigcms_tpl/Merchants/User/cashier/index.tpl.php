<!DOCTYPE html>
<html>
<head>
    <title>收银台 | 收银台</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<style>
		.ibox-title h5 {
  			margin: 10px 0 0px;
		}
		select.input-sm {
  			height: 35px;
  			line-height: 35px;
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
		#spantext{    display: inline-block;height: 32px;line-height: 29px;position: relative;top: -10px;}
		#qr-code-zone canvas{vertical-align: middle;}
		#qr-code-zone {line-height: 200px;padding-top: 4px;}
		#qr-code-forever canvas{vertical-align: middle;}
		#qr-code-forever {line-height: 200px;padding-top: 4px;}
		#qr-code-autopay canvas{vertical-align: middle;}
		#qr-code-autopay {line-height: 200px;padding-top: 4px;}
		#table-list-body .btn-st{background-color: #337ab7;border-color: #2e6da4;cursor:auto;}
		#oderinfo{overflow-y: scroll;}
		.float-e-margins .ibox-content{border-style:none;}
		.nav-tabs > li > a:hover,
		.nav-tabs > li > a:focus {
		 background-color: #FFF;
		}
		.nav-tabs li.active  a {border-color:#dddddd #dddddd #fff #fff}
		.nav-tabs li.active  a:hover,.nav-tabs li.active a:focus {border-color:#dddddd #dddddd #fff #fff;background-color:#FFF;}
		.mbform .controls{text-align: left;}
	</style>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all.min.js"></script>
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
                            <strong>Index</strong>
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
						<!--<ul class="nav nav-tabs"> 
						<li class="active"> <a href="#">收银台</a> </li> 
						<li> <a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=payRecord">收款记录</a> </li> 
						<li> <a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=ewmRecord">二维码记录</a> </li> 
						</ul> --->
						 <strong>指定金额收款</strong> 
            	     </div>
<div class="ibox-content"> 
 
   <div class="app__content js-app-main page-cashier carousel slide" id="carousel3" >
    <div class="carousel-inner">
     <div class="page-cashier-box"> 
      <div class="cashier-desk clearfix"> 
       <!-- 实时收款二维码 --> 
       <div class="realtime-pay js-pay-code-region clearfix">
        <div style="text-align: center;">
         <div class="pay-config" style="margin-top: 7%;"> 
         
          <form class="form-horizontal"> 
		  <div class="control-group config-title"> 
            <!--<div class="controls"> 
			 <span id="spantext">支付类型：</span>
				<select name="paytype" id="paytype" class="input-sm form-control input-s-sm inline switch" style="width:251px;">
                  <option value="wxpay">微信支付</option>
                </select>
             <span class="clear-btn js-clear"></span> 
            </div>  --->
           </div>

           <div class="control-group config-title"> 
            <div class="controls"> 
             <input type="text" name="cashier_name" class="js-cashier-name js-input" value="" placeholder="收款商品名称" /> 
             <span class="clear-btn js-clear"></span> 
            </div> 
           </div> 
           <div class="control-group config-amount"> 
            <div class="controls"> 
             <input type="text" name="cashier_value" class="js-cashier-value js-input" value="" placeholder="输入金额(元)" /> 
             <a href="javascript:void(0)" class="btn btn-primary js-create-qrcode">生成二维码</a> 
            </div> 
           </div> 
           <p class="gray tips fixed-tips"></p> 
          </form> 
         </div> 

		 <div class="pay-code" id="immediately"> 
		  <h5>立刻支付二维码</h5>
          <div class="qr-code-zone gray" id="qr-code-zone">
            二维码区域 
          </div> 
          <p class="gray tips" id="receivables">收款: &nbsp;-&nbsp; 元</p> 
		   <p class="tips">&nbsp;&nbsp;</p> 
         </div>

		  <div class="pay-code f-pay-code"> 
		  <h5>永久支付二维码</h5>
          <div class="qr-code-zone gray" id="qr-code-forever">
            二维码区域 
          </div> 
          <p class="gray tips" id="receivablesforever">收款: &nbsp;-&nbsp; 元</p> 
          <p class="tips downLoadEwm"> <a href="javascript:void(0)" id="downloadEwm">下载二维码</a> </p> 
         </div>

         <div class="pay-code" id="autopay-qrcode"> 
		  <h5>自助付款</h5>
          <div class="qr-code-zone gray" id="qr-code-autopay">
           
          </div> 
          <p class="gray tips" id="receivables">买家可自助输入付款金额</p>
		  <p class="tips downLoadEwm"> <a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=qrcode&tpy=autopay&dwd=1">下载二维码</a></p>
         </div>

        </div>
       </div> 

      </div> 
      <!-- 实时交易信息展示区域 --> 
      <div class="cashier-realtime"> 
       <div class="realtime-title-block clearfix"> 
        <h1 class="realtime-title">近期收款情况</h1> 
        <a href="javascript:void(0)" class="js-refresh-list refresh-list">刷新</a> 
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
            <th  data-hide="phone">付款人</th> 
            <th  data-hide="phone">付款时间</th> 
            <th  data-hide="phone">付款金额(元)</th> 
			<th  data-hide="phone">退款情况</th> 
            <th>操作</th>
           </tr>
          </thead>
          <tbody class="js-list-body-region" id="table-list-body">
		   <?php if(!empty($neworder)){
		      foreach($neworder as $ovv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $ovv['id'];?></td> 
            <td><?php if(!empty($ovv['nickname'])){
				echo $ovv['nickname'];
			}elseif(!empty($ovv['truename'])){
			     echo htmlspecialchars_decode($ovv['truename'],ENT_QUOTES);
			}elseif(!empty($ovv['openid'])){
			    echo $ovv['openid'];
			}else{
			    echo '未知客户';
			}?></td> 
            <td><?php $paytime=$ovv['paytime'] > 0 ? $ovv['paytime'] : $ovv['add_time']; echo date('Y-m-d H:i:s',$paytime);?></td> 
			<td><?php echo $ovv['goods_price'];?></td>
			<td><?php if($ovv['refund']==1){?>
			     退款中...
			<?php }elseif($ovv['refund']==2){?>
			     已退款
			<?php }elseif($ovv['refund']==3){?>
			     退款失败
			 <?php }else{
			     echo "已支付";
			 } ?>
			</td> 
            <td> <?php if($ovv['comefrom']>0){ ?> <button class="btn btn-sm btn-success btn-st"><strong> 已支付 </strong></button> <?php }elseif($ovv['refund']!=2 && $ovv['refund']!=1){?> <button class="btn btn-sm btn-warning" onclick="wxRefundBtn(this,<?php echo $ovv['id'];?>,<?php echo $ovv['mid'];?>);"><strong> 退&nbsp;&nbsp;&nbsp;款 </strong></button>  <?php }elseif($ovv['refund']==2){?><button class="btn btn-sm btn-success btn-st"><strong> 已退款 </strong></button>  <?php }?><button class="btn btn-sm btn-info" onclick="GetDetail(<?php echo $ovv['id'];?>,<?php echo $ovv['mid'];?>);"><strong>支付详情</strong></button>  <button class="btn btn-sm btn-danger" onclick="deltheOrder(this,<?php echo $ovv['id'];?>,<?php echo $ovv['mid'];?>);"><strong> 删 除 </strong></button></td>
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="7">暂无订单</td></tr>
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
            	</div>
            </div>
        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>

		<div class="modal inmodal" tabindex="-1" role="dialog"  id="oderinfo">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span style="font-size: 35px;">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">支付详情</h4>
                </div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white _close">关闭</button>
                </div>
			</div>
		</div>
	</div>

	<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/canvas2image.js"></script>
	 <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/commonfunc.js"></script>
    <script>
	//$('.qr-code-zone').qrcode("http://www.helloweba.com"); //任意字符串 
	var qwidth=qheight=200;
	if(is_mobile()){
	  $('.form-horizontal').addClass('mbform');
	  $('.row .col-lg-12').css('padding','1px');
	  $('.float-e-margins .ibox-content').css('padding','15px 5px 20px 5px');
	  $('.cashier-desk .realtime-pay').css('float','none').css('padding','0 0 0 5px');
	  $('.js-pay-code-region .pay-code').css('float','none').css('margin-left','0px').css('padding','0px');
	  $('.js-cashier-name').css('width','95%');
	  $('.js-fixed-code-region').css('width','auto').css('border-left','none');
	  $('.qr-code-zone').css('width','251px').css('height','251px').css('padding-top','9px');
	  $('.js-fixed-code-region').css('margin','0px').css('float','none');
	  $('.self-pay-code').css('width','251px').css('height','251px');
	  $('.self-pay-code img').css('width','251px').css('height','251px');
	  $('#paytype').css('width','70%');
	  $('.js-cashier-value').css('width','50%');
	  $('.nav-tabs li a').css('padding','10px');
	  $('#immediately').css('margin-top','40px');
	  $('.downLoadEwm').hide();
	  qwidth=qheight=230;
	}else{
	  $('.form-horizontal').removeClass('mbform');
	}
	 var topost=true;
	 var thismoney=0;
        $(document).ready(function(){
			 $('.ui-table-list').footable();
			$("#qr-code-autopay").html('').css('background-color','#FFF').qrcode({ 
					//render: "table", //table方式 
					width: qwidth, //宽度 
					height: qheight, //高度
					text:'<?php echo $this->SiteUrl;?>/merchants.php?m=Index&c=pay&a=autopay&mid=<?php echo $this->mid;?>' //任意内容 
				});
			$('.js-create-qrcode').click(function(){
			     if(!topost) return false;
				 var postdata={paytype:'wxpay'};
				 postdata.tname=$.trim($('input[name="cashier_name"]').val());
				 if(!postdata.tname){
					swal({title:'付款理由必须填！',text:'', type:"error"});
				    return false;
				 }
			     postdata.tprice=$.trim($('input[name="cashier_value"]').val());
				 postdata.tprice=parseFloat(postdata.tprice);
				 if(!(postdata.tprice > 0)){
				   	swal({title:'付款金额必须填！',text:'', type: "error"});
				    return false; 
				 }
				 thismoney=postdata.tprice;
				 topost=false;
				 $.post('?m=User&c=cashier&a=getEwm',postdata,function(ret){
					topost=true;
					if(!ret.error){
						$("#qr-code-zone").html('').css('background-color','#FFF').qrcode({ 
							//render: "table", //table方式 
							width: qwidth, //宽度 
							height: qheight, //高度
							text:ret.qrcode //任意内容 
						});
						$('#receivables').html('收款: '+postdata.tprice+' 元');

						$("#qr-code-forever").html('').css('background-color','#FFF').qrcode({ 
							//render: "table", //table方式 
							width: qwidth, //宽度 
							height: qheight, //高度 
							text:"<?php echo $this->SiteUrl;?>/merchants.php?m=Index&c=pay&a=foreverpay&ordid="+ret.ewminfo //任意内容 
						});
						$('#receivablesforever').html('收款: '+postdata.tprice+' 元');
					}else{
						swal("失败", ret.msg , "error");
					}
				},'json');
			});

			$('.js-refresh-list').click(function(){
				if(is_mobile()){
				  window.location.reload();
				  return false;
				}
			     $.ajax({
					url: "?m=User&c=cashier&a=getajaxOrder&cf=index",
					type: "POST",
					dataType: "json",
					/*async:true,
					data:{cf:'index'},*/
					success: function(res){
						if(!res.error && res.datas){
							var datahtml='';
							$.each(res.datas,function(kk,vv){
							   datahtml+='<tr class="widget-list-item">';
							   datahtml+='<td>'+vv.id+'</td>';
							   datahtml+='<td>'+vv.truename+'</td>';
							   datahtml+='<td>'+vv.paytimestr+'</td>';
							   datahtml+='<td>'+vv.goods_price+'</td>';
							   datahtml+='<td>'+vv.refundstr+'</td>';
							   datahtml+='<td>';
							   if(vv.comefrom > 0){
							     datahtml+='<button class="btn btn-sm btn-success btn-st"><strong> 已支付 </strong></button> ';
							   }else if(vv.refund!=2 && vv.refund!=1){
							      datahtml+='<button class="btn btn-sm btn-warning" onclick="wxRefundBtn(this,'+vv.id+','+vv.mid+');"><strong> 退&nbsp;&nbsp;&nbsp;款 </strong></button> ';
							   }else{
							     datahtml+='<button class="btn btn-sm btn-success btn-st"><strong> 已退款 </strong></button> ';
							   }
							   datahtml+='<button class="btn btn-sm btn-info" onclick="GetDetail('+vv.id+','+vv.mid+');"><strong>支付详情</strong></button> '+' <button class="btn btn-sm btn-danger" onclick="deltheOrder(this,'+vv.id+','+vv.mid+');"><strong> 删 除 </strong></button></td></td> </tr>';
							});
						  $('.js-list-body-region').html(datahtml);
						}else{
						    $('.js-list-body-region').html('<tr class="widget-list-item"><td colspan="6">暂无订单</td></tr>');
						}
						 $('.ui-table-list').footable();
						/*setTimeout(function(){
						
						}, 2000);*/
					}
				});
			});
        });


   var screenH=$(window).height();
	screenH=  screenH-20;
	$('#oderinfo').css('height',screenH);
    </script>
  <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/lhsw.js"></script>
 
</body>

</html>