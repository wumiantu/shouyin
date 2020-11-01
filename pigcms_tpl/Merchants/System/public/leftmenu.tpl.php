<nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
						<img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/profile_small.jpg" class="img-circle" style="width: 45px;height: 45px;">
                         </span>
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{pg:$adminuser.account}</strong>
                             </span> <span class="text-muted text-xs block">收银台管理后台</span> </span> </a>
                    </div>
					<div class="logo-element" style="text-align: center;">
						<img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}images/profile_small.jpg" class="img-circle" style="width: 45px;height: 45px;">
							
					</div>
                </li>
				<li {pg:if ROUTE_CONTROL eq 'index' && ROUTE_ACTION != 'ModifyPwd'} class="active" {pg:/if}>
					<a href="#"><i class="fa  fa-puzzle-piece"></i> <span class="nav-label">网站商家</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse {pg:if ROUTE_CONTROL eq 'index'} in {pg:/if}">
                        <li {pg:if ROUTE_CONTROL eq 'index' && ROUTE_ACTION=='merLists'} class="active" {pg:/if}><a href="/merchants.php?m=System&c=index&a=merLists">商家列表</a></li>
                        <li {pg:if ROUTE_CONTROL eq 'index' && ROUTE_ACTION=='affiliate'} class="active" {pg:/if}><a href="/merchants.php?m=System&c=index&a=affiliate">微信特约商户</a></li>
						<li {pg:if ROUTE_CONTROL eq 'index' && ROUTE_ACTION=='affiliatepay'} class="active" {pg:/if}><a href="/merchants.php?m=System&c=index&a=affiliatepay">特约商户支付列表</a></li>
                    </ul>

                </li>

				<li {pg:if ROUTE_CONTROL eq 'pay'} class="active" {pg:/if}>
					<a href="#"><i class="fa fa-cog"></i> <span class="nav-label">支付配置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse {pg:if ROUTE_CONTROL eq 'pay'} in {pg:/if}">
                        <li {pg:if ROUTE_CONTROL eq 'pay' && ROUTE_ACTION=='config'} class="active" {pg:/if}><a href="/merchants.php?m=System&c=pay&a=config">支付配置</a></li>
                    </ul>

                </li>
				<li {pg:if ROUTE_CONTROL eq 'index' && ROUTE_ACTION=='ModifyPwd'} class="active" {pg:/if}>
                    <a href="/merchants.php?m=System&c=index&a=ModifyPwd"><i class="fa fa-unlock-alt"></i> <span class="nav-label">修改密码</span><span class="label label-info pull-right"></span></a>
                </li>
            </ul>

        </div>
    </nav>