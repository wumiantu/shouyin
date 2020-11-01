<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 特约商户管理</title>
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
                            <strong>特约商户管理</strong>
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
                            <h5>已配置微信支付商家</h5>
                        </div>
                        <div class="ibox-content">
						<div class="alert alert-warning">
						温馨提示：请确认您配置的微信商户号有特约商户管理功能，然后您可以选择一个平台的商家作为您的特约商家请在微信商户后台 =》特约商户管理配置相关信息
						 </div>
                            <table class="footable table table-stripped" data-page-size="30" id="listfootable">
                                <thead>
                                <tr>
									<th style="width: 120px;">选为特约商家</th>
									<th>Mid号</th>
									<th>商户名称</th>
									<th data-hide="phone">UserName</th> 
									<th data-hide="phone">Appid</th>
									<th data-hide="phone">Mchid</th> 
								   </tr>
                                </thead>
								  <tbody>
									{pg:if !empty($merInfo)}
									 {pg:section name=vv loop=$merInfo}
									  <tr>
									    <td style="padding-top:12px;" class="ptd"><input type="checkbox" {pg:if $merInfo[vv].proxymid eq $_mid} checked="checked" {pg:/if} data-type='weixin' class="i-checks"></td>
									   <td class="midnum">{pg:$merInfo[vv].mid}</td>
									      <td class="prelative"><span class="wxname">{pg:$merInfo[vv].wxname}</span><input type="text" class="form-control" placeholder="请输入商户名称">&nbsp;&nbsp;&nbsp;<span class="tips"><i class="fa fa-edit"></i><span>保存修改</span></span>
										</td>
									   <td>{pg:$merInfo[vv].username}</td>
									   <td>{pg:$merInfo[vv].wx_appid}</td>
									   <td>{pg:$merInfo[vv].wx_mchid}
									   </td>
									  </tr>
									 {pg:/section}
									{pg:else}
										   <tr class="widget-list-item"><td colspan="8">暂无商家信息</td></tr>
									{pg:/if}
								   </tbody> 
                            </table>

							<div id="editable_paginate" class="dataTables_paginate paging_simple_numbers">
                                <ul class="pagination pull-right"></ul>
							</div>

                        </div>
                    </div>
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
	 $('.i-checks').iCheck({
           checkboxClass: 'icheckbox_square-green',
           radioClass: 'iradio_square-green',
        });

		$('.i-checks').on('ifChanged', function(){
			var isselect=0;
			if($(this).is(':checked')){
				 isselect = 1;
			}else{
				 isselect = 0;
			}
			var s_mid=0;
			s_mid=$(this).parents('.ptd').siblings('.midnum').text();
			s_mid=$.trim(s_mid);
			var sdata={ischeck:isselect,mid:s_mid};
			$.post('?m=System&c=pay&a=isproxyed',sdata,function(ret){
			 
			
			},'JSON');
		});
	});

	 $('#listfootable .prelative .tips').click(function(){
	if($(this).hasClass('fedit')){
	   var mid= $(this).parent().siblings('.midnum').text();
	   mid=parseInt($.trim(mid));
	   var vv=$(this).siblings('.form-control').val();
	   vv=$.trim(vv);
	   if(!vv){
	      swal({title: "温馨提示",text:'没填写内容！',type: "error"});
		  return false;
	   }else{
		  var _this= $(this);
	     $.post('?m=System&c=index&a=mdfyName',{mid:mid,wxname:vv},function(ret){
		    if(!ret.error){
			 _this.siblings('.wxname').text(vv);
			 }else{
			    swal({title: "温馨提示",text:'修改失败！',type: "error"});
			 }
	   _this.siblings('.wxname').show();
	   _this.siblings('.form-control').hide();
	   _this.find('span').hide();
	   _this.removeClass('fedit');
		 },'JSON');
	   }
	}else{
	   $(this).siblings('.wxname').hide();
	   var wxname=$(this).siblings('.wxname').text();
	   $(this).siblings('.form-control').val(wxname).show();
	   $(this).find('span').show();
	   $(this).addClass('fedit');
	}
 });
</script>
</html>