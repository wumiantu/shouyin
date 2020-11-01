<!DOCTYPE HTML>
<head>
<title>微信扫码支付</title>
<?php include PIGCMS_TPL_STATIC_PATH.'../'.ROUTE_MODEL.'/public/header.tpl.php';?>
 <script type="text/javascript">
	//var jump_url = '';/***提交之后跳转的URL****/
	/*$(function () {
		var currYear = (new Date()).getFullYear();  
		var opt={};
		opt.date = {preset : 'date'};
		opt.time = {preset : 'time'};
		opt.default = {
			theme: 'android-ics light', //皮肤样式
			display: 'modal', //显示方式 
			mode: 'scroller', //日期选择模式
			lang:'zh',
			startYear:currYear - 10, //开始年份
			endYear:currYear + 10 //结束年份
		};

		$("#start_dateField").scroller('destroy').scroller($.extend(opt['date'], opt['default']));
		
		var optTime = $.extend(opt['time'], opt['default']);
		$("#start_timeField").mobiscroll(optTime).time(optTime);
	});
	*/
</script>
</head>
<body>

<div id="preloader">
	<div id="status">
    	<p class="center-text">
			正在加载中...
            <em>加载取决于你的连接速度!</em>
        </p>
    </div>
</div>


<div class="all-elements">
<?php //include PIGCMS_TPL_STATIC_PATH.'../'.ROUTE_MODEL.'/public/left.tpl.php';?>
    <div id="content" class="page-content">
    	<div class="content-controls solid-color fixed-header">
        	<!---<a href="#" class="deploy-sidebar"></a>-->
			<a href="javascript:;"  style="width: 50px;height: 50px;"></a>
            <em class="content-title">微信扫码支付</em>
            <a href="contact.html" class="deploy-contact" style="display:none"></a>
        </div>    
        <div class="fixed-header-clear"></div>    
        

        <div class="content">
        	<!-- start-->
            <div class="one-half-responsive" style="min-height:900px;">
                <div class="container no-bottom">
                    <div class="contact-form no-bottom">
                        <h4>扫码支付确认信息</h4>
                        <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">
                            <div class="big-notification green-notification">
                                <h3 class="uppercase">温馨提示</h3>
                                <a href="#" class="close-big-notification">x</a>
                                <p>你提交的数据已经保存成功。</p>
                                <div class="msg" style="font-size:12px;padding:10px;padding-top: 0px;margin-bottom: 0px;">
                                  <span id="wait">3</span>秒后自动跳转
                                </div>
                            </div>
                        </div>
                        <form action="?m=Index&c=pay&a=pay" method="post" class="contactForm" id="contactForm">
							 	<input type="hidden" name="way" value="<?php echo $data['way']?>">
								<input type="hidden" name="type" value="<?php echo $data['type']?>">
								<input type="hidden" name="order_id" value="<?php echo $order['order_id']?>">
                            <fieldset>
                                <!--<div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="typeField">商品描述:<span>(必填)</span></label>
                                    <select  class="contactField requiredField ft_16"  id="typeField">
                                           <option  value="{$item.w_id}"></option>
                                    </select>
                                </div>-->
                                <div class="formFieldWrap">
                                    <label class="field-title contactEmailField" for="start_dateField">商品描述: <span>(必填)</span></label>
                                    <input type="text" name="goods_name" class="contactField requiredField" id="start_dateField" value="商品dddddd" readonly="readonly" />
                                </div>
                                 <div class="formFieldWrap">
                                    <label class="field-title contactEmailField" for="start_timeField">支付金额： <span>(必填)</span></label>
                                    <input type="text" name="goods_price" class="contactField requiredField" id="start_timeField" value="0.01" />
                                </div>
                                <div class="formFieldWrap">
                                    <label class="field-title contactEmailField" value="" for="days_numberField">授权码: <span>(必填)</span></label>
                                    <input type="text" name="auth_code" class="contactField requiredField" id="days_numberField" value="" style="min-width:50%;display: inline-block;"/>
									<a class="button button-green" style="overflow: initial;padding: 6px 10px;margin: 0px 0px 25px 20px;" id="qrcode_btn"/>扫一扫</a>
                                </div>
                                <div class="formSubmitButtonErrorsWrap">
                                    <input type="submit" class="buttonWrap button button-green contactSubmitButton" id="contactSubmitButton" value="提交"/>
                                </div>
                            </fieldset>
                        </form>       
                    </div>
                </div>
            </div>
            <!--申请 end-->
      <?php include PIGCMS_TPL_STATIC_PATH.'../'.ROUTE_MODEL.'/public/footer.tpl.php';?>     
    </div>  
</div>
<?php include PIGCMS_TPL_STATIC_PATH.'../'.ROUTE_MODEL.'/public/wxjshtml.tpl.php';?>    
</body>
</html>