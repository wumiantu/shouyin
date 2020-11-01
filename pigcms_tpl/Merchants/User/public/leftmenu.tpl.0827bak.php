<nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img src="./pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
                             </span>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="mailbox.html">Mailbox</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
				<li <?php if(ROUTE_CONTROL=='merchant') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">商家设置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='merchant') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='merchant' && ROUTE_ACTION=='employers') echo 'class="active"';?>><a href="?m=User&c=merchant&a=employers">员工管理</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='pay') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">在线支付设置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='pay') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='pay' && ROUTE_ACTION=='config') echo 'class="active"';?>><a href="?m=User&c=pay&a=config">支付配置</a></li>
                        <li <?php if(ROUTE_CONTROL=='pay' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="?m=User&c=order&a=index">订单列表</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='cashier') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">商家收银台</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='cashier') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="?m=User&c=cashier&a=index">收银台</a></li>
                        <li <?php if(ROUTE_CONTROL=='cashier' && (ROUTE_ACTION=='payRecord' || ROUTE_ACTION=='odetail')) echo 'class="active"';?>><a href="<?php echo $SiteUrl;?>/merchants.php?m=User&c=cashier&a=payRecord">收款记录</a></li>
						<li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='ewmRecord') echo 'class="active"';?>><a href="<?php echo $SiteUrl;?>/merchants.php?m=User&c=cashier&a=ewmRecord">二维码生成记录</a></li>
						<li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='payment') echo 'class="active"';?>><a href="<?php echo $SiteUrl;?>/merchants.php?m=User&c=cashier&a=payment">在线收银</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='statistics') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">数据统计</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='statistics') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="?m=User&c=statistics&a=index">商家收支</a></li>
						<li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='otherpie') echo 'class="active"';?>><a href="?m=User&c=statistics&a=otherpie">概况统计</a></li>
						<li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='fans') echo 'class="active"';?>><a href="?m=User&c=statistics&a=fans">粉丝支付</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>