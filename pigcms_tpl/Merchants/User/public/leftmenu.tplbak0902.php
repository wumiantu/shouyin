<nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img src="<?php echo $this->merchant['logo'];?>" class="img-circle" alt="image" style="margin:0 auto;display:block;width: 170px;border-radius: 0;">
                             </span>
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->merchant['name'];?></strong>
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
                        <li <?php if(ROUTE_CONTROL=='cashier' && (ROUTE_ACTION=='payRecord' || ROUTE_ACTION=='odetail')) echo 'class="active"';?>><a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=payRecord">收款记录</a></li>
						<li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='ewmRecord') echo 'class="active"';?>><a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=ewmRecord">二维码生成记录</a></li>
						<li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='payment') echo 'class="active"';?>><a href="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=cashier&a=payment">在线收银</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='data') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-line-chart"></i> <span class="nav-label">数据统计</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='data') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='data' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="?m=User&c=data&a=index">收支统计</a></li>
                        <li <?php if(ROUTE_CONTROL=='data' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="?m=User&c=data&a=fans">粉丝统计</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='wxCoupon') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">微信核销卡券</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='wxCoupon') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='wxCoupon' && in_array(ROUTE_ACTION,array('index','cardetail','createKq'))) echo 'class="active"';?>><a href="?m=User&c=wxCoupon&a=index">卡券管理</a></li>
						<li <?php if(ROUTE_CONTROL=='wxCoupon' && ROUTE_ACTION=='consumeCard') echo 'class="active"';?>><a href="?m=User&c=wxCoupon&a=consumeCard">核销卡券</a></li>
						<li <?php if(ROUTE_CONTROL=='wxCoupon' && ROUTE_ACTION=='wxReceiveList') echo 'class="active"';?>><a href="?m=User&c=wxCoupon&a=wxReceiveList">卡券消费列表</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>