<nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
					   <?php if(!empty($this->merchant['logo'])){?>
                            <img src="<?php echo $this->merchant['logo'];?>" class="img-circle" alt="image" height="70px" width="70px">
							<?php }elseif(defined('RESOURCEURL')){?>
							  <img src="<?php echo RESOURCEURL;?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php }elseif(defined('ABS_UPLOAD_PATH')){ ?>
							  <img src=".<?php echo ABS_UPLOAD_PATH;?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php }else{?>
								<img src="./pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" style="width: 45px;height: 45px;">
							<?php }?>
                             </span>
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php if(!empty($this->merchant['wxname'])){ echo $this->merchant['wxname'];}else{ echo 'My Cashier';}?></strong>
                             </span> <span class="text-muted text-xs block"><?php echo $this->merchant['weixin'];?> <!--<b class="caret"></b>--></span> </span> </a>
                        <!--<ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="mailbox.html">Mailbox</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
                        </ul>-->
                    </div>
					<div class="logo-element" style="text-align: center;">
					<?php if(!empty($this->merchant['logo'])){?>
                            <img src="<?php echo $this->merchant['logo'];?>" class="img-circle" style="width: 45px;height: 45px;">
							<?php }elseif(defined('RESOURCEURL')){?>
							  <img src="<?php echo RESOURCEURL;?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php }elseif(defined('ABS_UPLOAD_PATH')){ ?>
							  <img src=".<?php echo ABS_UPLOAD_PATH;?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php }else{?>
								<img src="./pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" style="width: 45px;height: 45px;">
							<?php }?>
					</div>
                </li>
				<li <?php if(ROUTE_CONTROL=='index' && ROUTE_ACTION=='index') echo 'class="active"';?>>
                    <a href="/merchants.php?m=User&c=index&a=index"><i class="fa fa-home"></i> <span class="nav-label">首页</span><span class="label label-info pull-right"></span></a>
                </li>
				<li <?php if(ROUTE_CONTROL=='merchant') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">商家设置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='merchant') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='merchant' && ROUTE_ACTION=='employers') echo 'class="active"';?>><a href="/merchants.php?m=User&c=merchant&a=employers">员工管理</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='pay') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">在线支付设置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='pay') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='pay' && ROUTE_ACTION=='config') echo 'class="active"';?>><a href="/merchants.php?m=User&c=pay&a=config">支付配置</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='cashier') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">商家收银台</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='cashier') echo 'in';?>">
					    <li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='payment' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=User&c=cashier&a=payment&type=1">扫码收银</a></li>
					    <li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='payment' && $type==2) echo 'class="active"';?>><a href="/merchants.php?m=User&c=cashier&a=payment&type=2">扫码退款</a></li>
                        <li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='index') echo 'class="active"';?> id="cashier_index"><a href="/merchants.php?m=User&c=cashier&a=index">二维码收款</a></li>
						<li <?php if(ROUTE_CONTROL=='cashier' && ROUTE_ACTION=='ewmRecord') echo 'class="active"';?>><a href="/merchants.php?m=User&c=cashier&a=ewmRecord">二维码记录</a></li>
                        <li <?php if(ROUTE_CONTROL=='cashier' && (ROUTE_ACTION=='payRecord' || ROUTE_ACTION=='odetail')) echo 'class="active"';?>><a href="/merchants.php?m=User&c=cashier&a=payRecord">收款记录</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='statistics') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-line-chart"></i> <span class="nav-label">数据统计</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='statistics') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="/merchants.php?m=User&c=statistics&a=index">商家收支</a></li>
						<li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='otherpie') echo 'class="active"';?>><a href="/merchants.php?m=User&c=statistics&a=otherpie">概况统计</a></li>
						<li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='fans') echo 'class="active"';?>><a href="/merchants.php?m=User&c=statistics&a=fans">粉丝支付排行</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='wxCoupon') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">微信卡券</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='wxCoupon') echo 'in';?>">
                        <li <?php if(ROUTE_CONTROL=='wxCoupon' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="/merchants.php?m=User&c=wxCoupon&a=index" id="wxCoupon_index">卡券管理</a></li>
						<li <?php if(ROUTE_CONTROL=='wxCoupon' && ROUTE_ACTION=='consumeCard') echo 'class="active"';?>><a href="/merchants.php?m=User&c=wxCoupon&a=consumeCard">核销卡券</a></li>
						<li <?php if(ROUTE_CONTROL=='wxCoupon' && ROUTE_ACTION=='wxReceiveList') echo 'class="active"';?>><a href="/merchants.php?m=User&c=wxCoupon&a=wxReceiveList">卡券消费列表</a></li>
						<li <?php if(ROUTE_CONTROL=='wxCoupon' && ROUTE_ACTION=='cardindex') echo 'class="active"';?>><a href="/merchants.php?m=User&c=wxCoupon&a=cardindex">会员卡专区</a></li>
						<li <?php if(ROUTE_CONTROL=='wxCoupon' && ROUTE_ACTION=='wxCardList') echo 'class="active"';?>><a href="/merchants.php?m=User&c=wxCoupon&a=wxCardList">领卡记录</a></li>
                    </ul>
                </li>
				<li <?php if(ROUTE_CONTROL=='index' && ROUTE_ACTION=='ModifyPwd') echo 'class="active"';?>>
                    <a href="/merchants.php?m=User&c=index&a=ModifyPwd"><i class="fa fa-unlock-alt"></i> <span class="nav-label">修改密码</span><span class="label label-info pull-right"></span></a>
                </li>
            </ul>

        </div>
    </nav>