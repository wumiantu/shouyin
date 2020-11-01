<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 特约商户支付列表</title>
	{pg:include file="$tplHome/System/public/header.tpl.php"}
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all2.min.js"></script>
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
	<style type="text/css">
	#listfootable .fa-edit{ color: #3DA142;font-size: 20px;}
	#listfootable .tips{ color: #3DA142;cursor: pointer;}
	#listfootable .tips span{ display: none;} 
	#listfootable .prelative .form-control {
    display: none;
    vertical-align: middle;
    width: auto;
	height: 30px;
	padding: 3px 10px;
 }
	</style>
</head>
<body>
    <div id="wrapper">
	{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
        <div id="page-wrapper" class="gray-bg dashbard-1">
	{pg:include file="$tplHome/System/public/top.tpl.php"}
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>管理后台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>特约商户支付列表</strong>
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
                        <div class="ibox-title">
                            <h5>特约商户支付列表</h5>
                        </div>
                        <div class="ibox-content">
						<div class="alert alert-warning">
						温馨提示：请确认您配置的微信商户号有特约商户管理功能，然后您可以选择一个平台的商家作为您的特约商家请在微信商户后台 =》特约商户管理配置相关信息
						 </div>
                            <table class="footable table table-stripped" data-page-size="30" id="listfootable">
                                <thead>
                                <tr>
									<th>商户名称</th>
									<th data-hide="phone">UserName</th>
									<th>付款人</th>
									<th data-hide="phone">付款时间</th>
									<th data-hide="phone">付款金额(元)</th>
									<th data-hide="phone">支付/退款情况</th>
								   </tr>
                                </thead>
								  <tbody>
									{pg:if !empty($merOderInfo)}
									 {pg:section name=vv loop=$merOderInfo}
									  <tr>
									    <td>{pg:$merOderInfo[vv].merwxname}</td>
									    <td>{pg:$merOderInfo[vv].username}</td>
									    <td>{pg:$merOderInfo[vv].payneme}</td>
									   <td>{pg:$merOderInfo[vv].paytimestr}</td>
									   <td>{pg:$merOderInfo[vv].goods_price}</td>
									   <td>已支付 / {pg:$merOderInfo[vv].refundstr}</td>
									  </tr>
									 {pg:/section}
									{pg:else}
										   <tr class="widget-list-item"><td colspan="8">暂无特约商家支付信息</td></tr>
									{pg:/if}
								   </tbody> 
                            </table>

                        </div>
                    </div>
					 {pg:$pagebar}
                </div>
            </div>
        </div>

			
            </div>
        </div>




	{pg:include file="$tplHome/System/public/footer.tpl.php"}
</body>
<script  type="text/javascript">
 $(document).ready(function(){
	$('#listfootable').footable();
 });
</script>
</html>