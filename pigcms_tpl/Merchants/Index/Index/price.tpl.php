<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />-->
<title>产品报价_小猪cms收银系统—微信支付,微信收银,二维码收款,支付宝收银台,微信卡券</title>
<link rel="stylesheet" href="<?php echo $this->RlStaticResource;?>index/css/base2.css">
<link rel="stylesheet" href="<?php echo $this->RlStaticResource;?>index/css/animate.css">
<link rel="stylesheet" href="<?php echo $this->RlStaticResource;?>index/css/style.css">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<!--[if lte IE 8]>
	<style type="text/css">
		html,body{width:100%; height:100%}
		.section-btn{display:none;}
	</style>
	<![endif]-->
<style>
table{ width:1000px; text-align:center;}
table tr{ height:50px; line-height:50px;}
table tr:hover{ background:#f2f2f2;}
table .priceTitle{ background:#1BBC9B; height:90px; line-height:90px;}
table .priceTitle:hover{ background:#1BBC9B;}
table .priceTitle img{ padding-top:32px;}
table td{ border-bottom:1px solid #E6E6E6; border-left:1px solid #E6E6E6; font-size:14px; color:#666;}
table .priceTitle td{ font-size:18px; color:#fff; font-weight:bold; font-family:Microsoft Yahei}
table .wuXian{ border-left:0;}
table .shuanCeng{ height:70px; line-height:normal;}
table .shuanCeng .neiJu{ padding-top:9px;}
table .shuanCeng .neijuOne{ padding-top:15px; line-height:normal;}
table .cuoWu{ background:url(<?php echo $this->RlStaticResource;?>index/img/duicuo_cuo.png) no-repeat center;}
table .zhengQue{ background:url(<?php echo $this->RlStaticResource;?>index/img/duicuo_dui.png) no-repeat center;}
table .shuanCeng p{ line-height:28px;}
.datd{border-right:1px solid #e6e6e6;font-size:16px;}
.shuanCeng .neijuTwo{ padding-top:5px;}
.shuanCeng .neijuTwo .jiShu{ background:url(<?php echo $this->RlStaticResource;?>index/img/duicuo_cuo.png) no-repeat 40px center;}
.shuanCeng .neijuTwo .yunYing{ background:url(<?php echo $this->RlStaticResource;?>index/img/duicuo_dui.png) no-repeat 40px center;}
table .goumaizhuji a{ background:url(<?php echo $this->RlStaticResource;?>index/img/zfb.jpg) no-repeat center; display:block; height:50px;}
.biaoend td{ border-bottom:1px solid #1bbc6b;}
.lastduan td{ text-align:left; border-bottom:3px solid #1bbc6b; padding-top:20px; padding-bottom:20px;}
.lastduan .shouQuan{ font-size:18px; color:#000;}
.lastduan .listWord li{ line-height:26px; font-size:14px;}
.lastduan .wuXian{ padding-left:20px;}
.lastduan span{ padding:4px 25px;}
.lastduan .banBenO{ background:url(<?php echo $this->RlStaticResource;?>index/img/duicuo_cuo.png) no-repeat 1px 3px;}
.lastduan .banBenT{ background:url(<?php echo $this->RlStaticResource;?>index/img/duicuo_dui.png) no-repeat 1px 3px;}
	</style>
</head>
<body>
<div id="header"><a class="site-logo" href="/"><img src="<?php echo $this->RlStaticResource;?>index/img/logo.png" style="height:43px;"></a>
	<div id="menu" style="padding-right:60px">
		<span><a href="/Cashier">首页</a></span>
		<span class="on"><a href="price.php" target="_blank">产品报价</a></span>
		<span><a href="/merchants.php?m=Index&c=login&a=index" target="_blank">商户登录</a></span>
		<span><a href="http://sighttp.qq.com/authd?IDKEY=a5b54f59386952e2e70fa6b6a0f2f4ef3f5ee4724e438f52" target="_blank">申请体验</a></span>
	</div>
</div>
<div class="conxia clr" style="display: block; margin:100px auto 20px auto; width:1000px;"><style>			#online_qq_layer table, td{line-height:50px;}
			#online_qq_layer table, .priceTitle td{line-height:100px;}
			</style><table><tbody><tr class="priceTitle clr"><td colspan="2" class="wuXian">系统功能列表</td><td width="227">基础版</td><td width="227">尊享版</td><td width="229">全能版</td></tr><tr class="shuanCeng clr">
			  <td width="143" rowspan="6" class="wuXian datd" style="">版本信息</td>
		      <td width="150" class="wuXian neiJu">价格</td>
		      <td class="neiJu"><a href="http://sighttp.qq.com/authd?IDKEY=a5b54f59386952e2e70fa6b6a0f2f4ef3f5ee4724e438f52" target="_blank">点击咨询</a></td>
		      <td class="neiJu"><a href="http://sighttp.qq.com/authd?IDKEY=a5b54f59386952e2e70fa6b6a0f2f4ef3f5ee4724e438f52" target="_blank">点击咨询</a></td>
		      <td class="neiJu"><a href="http://sighttp.qq.com/authd?IDKEY=a5b54f59386952e2e70fa6b6a0f2f4ef3f5ee4724e438f52" target="_blank">点击咨询</a></td>
			  </tr><tr><td class="wuXian">商业授权</td>
			      <td>终生</td><td>终生</td><td>终生</td></tr><tr><td class="wuXian">系统免费升级</td>
			        <td>一年</td><td>一年</td><td>一年</td></tr><tr><td class="wuXian">系统客户数量</td>
			          <td>无上限</td><td>无上限</td><td>无上限</td></tr><tr><td class="wuXian"><span class="wuXian">域名授权<br>
			          </span></td>
			            <td>1个顶级域名</td>
			            <td>1个顶级域名</td>
			            <td>1个顶级域名</td>
			          </tr><tr><td class="wuXian">授权域名下子域名</td>
			              <td>终生使用</td><td>终生使用</td><td>终生使用</td></tr><tr>
			                <td rowspan="6" class="wuXian datd">微信支付</td>
			                <td class="wuXian">刷卡支付</td>
			                <td class="zhengQue"></td><td class="zhengQue"></td><td class="zhengQue"></td></tr><tr>
			                  <td class="wuXian">扫码支付</td>
			                   <td class="zhengQue"></td><td class="zhengQue"></td><td class="zhengQue"></td></tr><tr>
			                    <td class="wuXian">可变金额收款二维码</td>
			                    <td class="zhengQue"></td><td class="zhengQue"></td><td class="zhengQue"></td></tr>
			                  <tr>
			                    <td class="wuXian">固定金额收款二维码</td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">微信退款</td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">付款优惠规则设定</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td rowspan="6" class="wuXian datd">微信卡券</td>
			                    <td class="wuXian">微信会员卡</td>
		                      <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td></tr>
			                  <tr>
			                    <td class="wuXian">会员管理</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">优惠券创建</td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">优惠券核销</td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">支付核销</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">优惠券线上发放</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td rowspan="6" class="wuXian datd">权限及统计</td>
			                    <td class="wuXian">多店员权限管理</td>
		                      <td class="zhengQue"></td><td class="zhengQue"></td><td class="zhengQue"></td></tr>
			                  <tr>
			                    <td class="wuXian">门店管理</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">收款统计</td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">退款统计</td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">支付方式统计</td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">粉丝支付排行</td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td rowspan="4" class="wuXian datd">平台功能</td>
			                    <td class="wuXian">微信支付服务商支持</td>
		                      <td class="cuoWu"></td><td class="zhengQue"></td><td class="zhengQue"></td></tr>
			                  <tr>
			                    <td class="wuXian">平台收银</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">无公众号制券</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">代发卡券</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  
			                  <tr>
			                    <td rowspan="4" class="wuXian datd">O2O功能</td>
			                    <td class="wuXian">卡券平台</td>
              <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td></tr>
			                  <tr>
			                    <td class="wuXian">附近商家</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">附近优惠</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  <tr>
			                    <td class="wuXian">优惠闪付</td>
                                <td class="cuoWu"></td>
                                <td class="cuoWu"></td>
                                <td class="zhengQue"></td>
              </tr>
			                  
              <tr>
                <td rowspan="5" class="wuXian datd">终端支持</td>
                <td class="wuXian">无硬件收银</td>
              <td class="zhengQue"></td><td class="zhengQue"></td><td class="zhengQue"></td></tr>
              <tr>
                <td class="wuXian">PC/MAC</td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">平板电脑</td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">智能手机</td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">二维码扫码枪</td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
              </tr>
              <tr>
                <td rowspan="8" class="wuXian datd">微信营销</td>
                <td class="wuXian">微网站</td>
              <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td></tr>
              <tr>
                <td class="wuXian">自定义菜单</td>
               <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">微活动</td>
                <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">微游戏</td>
               <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">渠道二维码</td>
                <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">线上收款</td>
                <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">行业应用</td>
               <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td>
              </tr>
              <tr>
                <td class="wuXian">微信商城</td>
               <td class="cuoWu"></td><td class="cuoWu"></td><td class="zhengQue"></td>
              </tr>
              <tr>
                <td rowspan="4" class="wuXian datd">售后服务</td>
                <td class="wuXian">程序安装</td>
              <td class="zhengQue"></td><td class="zhengQue"></td><td class="zhengQue"></td></tr>
              <tr>
                <td class="wuXian">数据迁移</td>
                <td class="cuoWu"></td>
                <td>免费1次</td>
                 <td>免费1次</td>
              </tr>
              
              <tr>
                <td class="wuXian">数据自动备份</td>
                <td class="cuoWu"></td>
                <td class="zhengQue"></td>
                <td class="zhengQue"></td>
              </tr>
              <tr class="">
                <td class="wuXian">年服务费（次年收取）</td>
                <td>2000元/年</td>
                <td>4000元/年</td>
                <td>9000元/年</td>
              </tr>
             <tr class="lastduan clr">
				<td colspan="5" class="wuXian">
					<p class="shouQuan clr">授权</p>
					<div class="listWord clr">
					<ul>
						<li>1、一份程序使用授权安装为一个服务网站，同一域名下安装多套程序则视为多个服务网站。</li>
						<li>2、请大家做好服务器的安全，pigcms不做任何灾难性维护。</li>
						<li>3、在购买授权后如需更换更高版本的授权，需按官方最新产品报价补差价（另额外收取2000元数据及程序兼容调整费用）即可，如向低版本更换授权官方不退差价。</li>
					</ul>
					</div>
					<p class="shouQuan clr">以下情况不属于服务范围 </p>
					<div class="listWord clr">
					<ul>
						<li>1、所有版本的报价均不含税点。</li>
						<li>2、自行修改或使用非原始程序代码产生的问题。</li>
						<li>3、自行对数据库进行直接操作导致数据库出错或者崩溃。</li>
						<li>4、非官方的模块/插件的安装以及由于安装模块/插件造成的故障。</li>
						<li>5、服务器、虚拟主机原因造成的系统故障。</li>
						<li>6、二次开发或定制及其它可能产生问题的情况。</li>
						<li>7、收到安装包后请妥善保管,我们不发第二次。</li>
						<li>8、pigcms提供安装与调试服务,但是不提供服务器环境的安装。</li>
						<li>9、需要我们协助安装的时候，请提供服务器远程桌面信息或者ftp信息，拒绝QQ远程协助。</li>
					</ul>
					</div>
					<p>
						<span class="banBenO">表示该版本不具备或不支持此功能或服务</span>
						<span class="banBenT">表示该版本已具备或支持此功能或服务</span>
					</p>
				</td>
			</tr>
		</tbody>
		</table>
</div>
</body>
</html>