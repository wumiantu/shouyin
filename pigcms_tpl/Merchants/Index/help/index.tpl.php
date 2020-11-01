<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>收银台帮助</title>

    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>font-awesome/css/font-awesome.css" rel="stylesheet">
	 <link href="<?php echo $this->RlStaticResource;?>plugins/css/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate_new.css" rel="stylesheet">
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">
        <div class="gray-bg">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>帮助文档</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>后台支付配置</a>
                        </li>
                        <li>
                            <span>帮助说明</span>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

        <div class="wrapper wrapper-content  animated fadeInRight article">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="text-center article-title">
                                <h2>
                                    支付配置说明
                                </h2>
                            </div>
                            <p>
                                <strong>1、微信公众平台配置</strong>
                            </p>
                            <div>
							   <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/weixinpay01.jpg">
							   <br/>
							   <br/>
							   <p>如图，1、请登录微信公众平台，点击 微信支付 =》开发配置,点击支付授权目录修改，如果您已经配置了，那么如图请再加一个支付授权目录（当然是要换上您的站点域名喽！）
							   <br/>
							   2、请换上您的域名将扫码支付支付回调URL配置上：您的域名+<?php echo $imgpath;?>/pay/wxpay/wxsaomahandle.php
							   </p>
								<p>3、其他必须配置项。1、点击开发者中心找到 网页授权获取用户基本信息 点击修改，将域名填上</p>
							    <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/weixinpay10.png">
								<br/>
								<br/>
								<p>3、其他必须配置项。2、点击公众号设置 =》功能设置，将JS接口安全域名加上</p>
							    <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/weixingpa11.png">
								<br/>
								<br/>
                            </div>

							<p>
                                <strong>2、我们自己平台支付配置</strong>
                            </p>
                            <div>
							   <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/weixinpay02.png">
							   <br/>
							   <br/>
							   <p>如图，1、请登录我们的&nbsp;<a href="/merchants.php?m=Index&c=login&a=index" target="_blank">收银台系统</a>&nbsp;点击在线支付设置 =》支付配置 =》微信那项的 配置信息按钮将弹出如图的层页面，填上相关信息。<br/>微支付商户号、API秘钥和下面三个证书是要从您的微信支付商户平台获取的。<br/><br/>下面是微信支付商户平台三个证书获取页面截图
							  </p>
                            </div>
                            <div>
							   <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/weixinpay03.jpg">
							   <br/><br/>
                            </div>
							<br/>
          					<p>
                                <strong>3、如果你是独立使用此系统（如果是对接系统无需填写）</strong>
                            </p>
                            <div>
							   <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/wxapipz.png">
							   <br/>
							   <br/>
							   <br/>
							   <p>1、如图请登录我们的&nbsp;<a href="/merchants.php?m=Index&c=login&a=index" target="_blank">收银台系统</a>&nbsp;点击在线支付设置 =》支付配置 =》微信那项的 API接口 弹出如图的层页面，如图<br/><br/>
							    <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/wxapipz02.png">
								<br/>
								<br/>
								<p>
							    2、请将上面的信息对应填写到微信公众号平台的服务器配置，然后点击启用，如图</p>
								<br/>
								<img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/wxapipz03.png">
							  </p>
							  	<h2>填写好上面相关本平台的配置 您就可畅心所欲的使用本平台啦，希望能给您带来便捷，愉快！
							    </h2>
                            </div>
							
                            <hr>
                            <div class="row">

                            </div>


                        </div>
                    </div>
                </div>
            </div>


        </div>

        </div>
        </div>

</body>

</html>
