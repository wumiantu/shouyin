<!DOCTYPE html>
<html>
<head>
    <title>收银台 | 在线收银</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
</head>
<body>
    <div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>在线收款</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Cashier</a>
                        </li>
                        <li class="active">
                            <strong>PayRecord</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
       	 	<div class="wrapper wrapper-content animated fadeIn">
            	<div class="row">
                	<div class="col-lg-6">
                	    <div class="tabs-container weixin">
                	        <ul class="nav nav-tabs">
                	            <li class="active"><a data-toggle="tab" href="#tab-1">扫码收款</a></li>
                	            <li class=""><a data-toggle="tab" href="#tab-2">扫码退款</a></li>
                	        </ul>
                	        <div class="tab-content">
                	            <div id="tab-1" class="tab-pane active">
                	                <div class="panel-body">
                	                    <div class="row">
                            				<div class="col-sm-12 micropay"></div>
                        				</div>
                	                </div>
                	            </div>
                	            <div id="tab-2" class="tab-pane">
                	                <div class="panel-body">
                	                    <div class="row">
                            				<div class="col-sm-12 micropayRefund"></div>
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
	<script>
	var Ttype=<?php echo $type;?>;
	 if(Ttype==2){
		$('.nav-tabs li').removeClass('active');
	    $('.nav-tabs li:last').addClass('active');
		$('#tab-1').removeClass('active');
		$('#tab-2').addClass('active');
	 }
		!function(a,b){
			function is_mobile(){
				var ua = navigator.userAgent.toLowerCase();
				if ((ua.match(/(iphone|ipod|android|ios|ipad)/i))){
					if(navigator.platform.indexOf("Win") == 0 || navigator.platform.indexOf("Mac") == 0){
						return false;
					}else{
						return true;
					}
				}else{
					return false;
				}
			}
			function is_weixin(){
			    var ua = navigator.userAgent.toLowerCase();
			    if(is_mobile() && ua.indexOf('micromessenger') != -1){  
			        return true;
			    } else {  
			        return false;  
			    }
			}
			var c = c || {};
			c.config = {
				data : ['weixin_micropay','weixin_micropayRefund']
			}
			c.init = function(){
				c.tpl();
			}
			
			c.loadJs = function(d){
				var oHead = document.getElementsByTagName('head').item(0),
   					oScript= document.createElement("script");   
   				oScript.type = "text/javascript";   
				oScript.src = d;   
  				oHead.appendChild( oScript);  
			}
			c.tmpl = function(d){
				var e = {
					weixin : {
						micropay : '<h3 class="m-t-none m-b">收款</h3><p>只适用微信扫码支付</p><p>扫码支付确认信息.</p><form role="form" action="?m=User&c=cashier&a=pay"><div class="form-group"><label>商品描述</label> <input type="text" placeholder="商品名称" name="goods_name" class="form-control"></div><div class="form-group"><label>支付金额</label> <input type="text" placeholder="支付金额" name="goods_price" class="form-control"></div><div><button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>扫码收款</strong></button></div></form>',
						micropayRefund : '<h3 class="m-t-none m-b">退款</h3><p>只适用微信扫码支付退款</p><p>扫微信扫码支付交易详情页的条形码来退款.</p><form role="form" action="?m=User&c=cashier&a=wxSmRefund"><div><button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>扫码退款</strong></button></div></form>',
					}
				}
				var f;
				$.each(d,function(g,h){
					f = e = e[h];
				});
				return f;
			}
			c.tpl = function(){
				$.each(this.config.data,function(d,e){
					c.create(e.split('_'));
				});
			}
			c.weixin = function(){
				this.loadJs('http://res.wx.qq.com/open/js/jweixin-1.0.0.js');
				var d = setInterval(function(){
					if(typeof(wx) != 'undefined'){
						wx.config({
		  					debug: false,
		 					appId: '<?php echo $signdata["appId"]; ?>',
		  					timestamp: '<?php echo $signdata["timestamp"]; ?>',
		  					nonceStr: '<?php echo $signdata["nonceStr"]; ?>',
		  					signature: '<?php echo $signdata["signature"]; ?>',
		  					jsApiList: [
		    					'checkJsApi',
		    					'onMenuShareTimeline',
		    					'onMenuShareAppMessage',
		    					'onMenuShareQQ',
		    					'onMenuShareWeibo',
		    					'scanQRCode',
								'chooseImage',
								'previewImage',
								'uploadImage',
								'downloadImage',
								'getLocation',
								'openLocation',
								'getNetworkType'
		  					]
						});
						clearInterval(d);
					}
				},200);
			}
			c.submit = function(d){
    			swal({
				title: "提示 :)",
        			text: "确认此操作？",
        			type: "warning",
        			showCancelButton: true,
        			confirmButtonColor: "#DD6B55",
        			confirmButtonText: "确定",
					cancelButtonText: "取消",
        			closeOnConfirm: false
    			}, function () {
    			    var e = d.serialize();	
					b.post(d.attr('action'),e, function(data){
						console.log(data);
						if(data.error == 0){
							c.tpl();
							swal("成功!", "支付成功", "success");
						}else{
							swal("失败!", data.msg, "error");
						}
					},'JSON');
    			});
			}
			c.create = function(s){
				function d(e){
					if(is_weixin()){
						wx.scanQRCode({
							needResult:1,
							scanType:["qrCode","barCode"],
							success:function (res){
								var result = res.resultStr;
								
								if(result.indexOf(',')>0){
									var result = result.split(',');
									result = result[1];
								}
								
								if(result && /^\d+$/g.test(result)){
				 					e.prepend('<input type="hidden" name="auth_code" value="'+result+'">');
				  					c.submit(e);
				    				return false;
								}else{
									swal("错误!", "不是有效的码，非法输入！", "error");
								}	
							}
						});
					}else{
						swal("错误!", "您使用的不是微信浏览器，此功能无法使用！", "error");
					}
				}
				var e = this.tmpl(s),
					f,
					i = b('body');
				$.each(s,function(g,h){
					f = i = i.find('.'+h);
				});
				f.html(e);
	
				if(is_weixin()){
					f.find('form').find('button[type="submit"]').click(function(){
						d(f.find('form'));
						return false;
					});
				}else{
					if(f.find('form').find('.form-group').size()){
						f.find('form').find('.form-group').last().after('<div class="form-group"><label>支付二维码</label><input type="text" placeholder="扫码获取条码数据" name="auth_code" class="form-control"></div>');
					}else{
						f.find('form').prepend('<div class="form-group"><label>支付二维码</label> <input type="text" placeholder="扫码获取条码数据" name="auth_code" class="form-control"></div>');
					}
					f.find('form').find('button[type="submit"]').click(function(){
						c.submit(f.find('form'));
						return false;
					});
				}
			}
			b(document).ready(function(){
				if(is_weixin()){
					c.weixin();
				}
				c.init();
			});
		}(window,jQuery);

	</script>
</body>
</html>