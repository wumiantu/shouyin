<!DOCTYPE html>
<html>
<head>
    <title>核销卡券</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/card_detail.css" rel="stylesheet">
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/libdetail.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<style type="text/css">
	  .ibox-content{ min-height:800px;}
	  .dropz .dz-image-preview{display:none;}
	</style>
	<!-- Data picker -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>微信卡券</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>wxCoupon</a>
                        </li>
                        <li class="active">
                            <strong>cardetail</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
       	 	<div class="wrapper wrapper-content animated fadeIn">

			   <div class="row" id="wrapper-content-list">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
						<div class="ibox-title">
						<div class="form-group">
						  <span>卡券ID：<?php echo $cardinfo['card_id'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>卡券状态：<?php if($cardinfo['status']==0){echo '审核中';}elseif($cardinfo['status']==1){echo '已审核';}elseif($cardinfo['status']==2){echo '未通过';}?></span>
                         </div>
						</div>
                <div class="ibox-content">	
		<div id="js_showinfo">
		<div class="intro card_msg">
				<div class="list_img group">
				  	<div class="img_panel l">
						<div class="client_side">
							<div class="banner"><?php echo $this->card_type[$cardinfo['card_type']]['zhname'];?></div>
							<div class="wrp">
								<div style="background-color: <?php echo $kqcontent['colorV'];?>;border-bottom-color: <?php echo $kqcontent['colorV'];?>;" class="top">
									<div class="logo group">
										<div class="avartar l"><img class="js_noreferimg" src="<?php echo $mset['logurl'];?>"></div>
										<p><?php echo $mset['mname'];?></p>
									</div>
									<div class="msg">
										<div class="main_msg">
											<p><?php echo $cardinfo['card_title'];?></p>
											<p class="title_sub"><?php echo $kqcontent['sub_title'];?></p>
										</div>
										<p class="time">有效期 <?php echo date('Y-m-d',$cardinfo['begin_timestamp']);?>至<?php echo date('y-m-d',$cardinfo['end_timestamp']);?></p>
									</div>
									<div class="deco"></div>
								</div>
								<div class="wrp_content">
									<div class="wrp_section section_dispose">
									
										<div class="qr_code_panel">
											<div class="main_msg qr_code"></div>
											<p class="sn">8557-4294-9941</p>
										</div>			
										<p><?php echo $kqcontent['notice'];?></p>
									</div>
									<div class="wrp_section">
										<ul class="info_list">
											<li class="info_li">
												<p class="info"><?php echo $this->card_type[$cardinfo['card_type']]['zhname'];?>详情</p>
												<span class="supply_area"><i class="ic ic_go"></i></span>
											</li>
											<li class="info_li">
												<p class="info">适用门店</p>
												<span class="supply_area"><?php echo $kqcontent['shop_id_count'];?>家<i class="ic ic_go"></i></span>
											</li>
										</ul>
									</div>
									<?php if(!empty($kqcontent['custom_url_name']) || (isset($kqcontent['promotion_url_name']) && $kqcontent['promotion_url_name']) || (isset($cardinfo['kqexpand']['custom_cell1']['name']) && $cardinfo['kqexpand']['custom_cell1']['name'])){?>
                                    <div class="wrp_section">
                                        <ul class="info_list">
											<?php if(!empty($kqcontent['custom_url_name'])) {?>
                                            <li class="info_li">
                                                <p class="info"><?php echo $kqcontent['custom_url_name'];?></p>
                                                <span class="supply_area"><?php echo $kqcontent['custom_url_sub_title'];?><i class="ic ic_go"></i></span>
                                            </li>
											<?php }
												if (isset($kqcontent['promotion_url_name']) && $kqcontent['promotion_url_name']) {
											?>
                                            <li class="info_li">
                                                <p class="info"><?php echo $kqcontent['promotion_url_name'];?></p>
                                                <span class="supply_area"><?php echo $kqcontent['promotion_url_sub_title'];?><i class="ic ic_go"></i></span>
                                            </li>
											<?php }
												if (isset($cardinfo['kqexpand']['custom_cell1']['name']) && $cardinfo['kqexpand']['custom_cell1']['name']) {
											?>
                                            <li class="info_li">
                                                <p class="info"><?php echo $cardinfo['kqexpand']['custom_cell1']['name'];?></p>
                                                <span class="supply_area"><?php echo $cardinfo['kqexpand']['custom_cell1']['tips'];?><i class="ic ic_go"></i></span>
                                            </li>
											<?php }?>
                                        </ul>
                                    </div>
                                    <?php } ?>
								</div>
							</div>
						</div>
					</div>
					
					<div class="msg_preview_panel l">
						<div class="msg_section msg_pre_view">
							<ul>
								<li class="section_title">券面信息</li>
								<li class="group">
									<span class="l title">卡券类型</span>
									<div class="msg"><?php echo $this->card_type[$cardinfo['card_type']]['zhname'];?></div>
								</li>
								<li class="group">
									<span class="l title">卡券标题</span>
									<div class="msg"><?php echo $cardinfo['card_title'];?></div>
								</li>
								<li class="group">
									<span class="l title">副标题</span>
									<div class="msg"><?php echo $kqcontent['sub_title'];?></div>
								</li>
								<?php if($cardinfo['card_type']==2){ ?>
									  <li class="group">
										<span class="l title">折扣额度</span>
										<div class="msg">
										<span><?php echo $cardinfo['kqexpand']['discount'];?> 折</span>
										</div>
									 </li>
								<?php }elseif($cardinfo['card_type']==4){ ?>
									 <li class="group">
										<span class="l title">减免金额</span>
										<div class="msg">
										<span><?php echo $cardinfo['kqexpand']['reduce_cost'];?> 元</span>
										</div>
									</li>
									<li class="group">
										<span class="l title">抵扣条件</span>
										<div class="msg">
										<span id="js_least_cost_preview">满 <?php echo $cardinfo['kqexpand']['least_cost'];?> 元可用</span>
										</div>
									</li>
									<?php } ?>
								
								<li class="group">
									<span class="l title">卡券颜色</span>
									<div class="msg"><span style="background-color:<?php echo $kqcontent['colorV'];?>;" class="colour_block"><?php echo $kqcontent['colorV'];?></span></div>
								</li>
								<li class="group">
									<span class="l title">有效期</span>
									<div class="msg">
										<span id="js_time_container"> <?php echo date('Y-m-d',$cardinfo['begin_timestamp']);?>至<?php echo date('y-m-d',$cardinfo['end_timestamp']);?></span>
										<!---&nbsp;&nbsp;<a id="js_modifytime_btn" href="javascript:void(0);">延长有效期</a>-->
									</div>
								</li>
								<li class="group">
									<span class="l title">商家名称</span>
									<div class="msg"><?php echo $kqcontent['brand_name'];?></div>
								</li>
								<li class="group">
									<span class="l title">商家Logo</span>
									<div class="msg"><img class="js_noreferimg" src="<?php echo $mset['logurl'];?>"></div>
								</li>
							</ul>
						</div>
						<div class="msg_section msg_pre_view">
							<ul>
								<li class="section_title">投放设置</li>
								<li class="group">
									<span class="l title">库存</span>
									<div class="msg"><?php echo $cardinfo['quantity'];?></div>
								</li>
								<li class="group">
									<span class="l title">销券条码</span>
									<div class="msg">
									二维码									
									</div>
								</li>
								<li class="group">
									<span class="l title">操作提示</span>
									<div class="msg"><?php echo $kqcontent['notice'];?></div>
								</li>
								<li class="group">
									<span class="l title">领取限制</span>
									<div class="msg">每个用户限领<?php echo $kqcontent['get_limit'];?>张</div>
								</li>
								
								 
								<li class="group">
									<span class="l title">转赠设置</span>
									<div class="msg">用户领券后<?php if(!$kqcontent['can_give_friend']) echo '不';?>可转赠其他好友</div>
								</li>
								
							</ul>
                        </div>
                        
						<div class="msg_section msg_pre_view">
							<ul>
								<li class="section_title"><?php echo $this->card_type[$cardinfo['card_type']]['zhname'];?>详情</li>
								<li class="group">
									<span class="l title">使用须知</span>
									<div class="msg"><?php echo $kqcontent['description'];?></div>
								</li>
								<li class="group">
									<span class="l title">优惠详情</span>
									<div class="msg">
									 <?php if(in_array($cardinfo['card_type'],array(0,1,3))){
									    echo $cardinfo['kqexpand']['content'];
									 }elseif($cardinfo['card_type']==2){
									       echo '凭此券消费打 '.$cardinfo['kqexpand']['discount'].' 折 ';
									 }elseif($cardinfo['card_type']==4){
									     echo '价值 '.$cardinfo['kqexpand']['reduce_cost'].' 元代金券1张 ，满 '.$cardinfo['kqexpand']['least_cost'].' 元可使用。'; 
									 } elseif ($cardinfo['card_type']==5) {
									 	echo $cardinfo['kqexpand']['prerogative'];
									 }
									 ?>
									</div>
								</li>
								
								<li class="group">
									<span class="l title">客服电话</span>
									<div class="msg"><?php echo $kqcontent['service_phone'];?></div>
								</li>
							</ul>
						</div>
						<?php if(is_array($kqcontent['location_id_list'])){ ?>
						<div class="msg_section msg_pre_view">
							<ul>
								<li class="section_title">服务信息
                                <!--<a id="js_modifyservice_btn" href="javascript:void(0);">修改</a>---></li>
								<li class="group">
									<span class="l title">适用门店</span>
									<div class="msg msg_table">
									<div id="js_shoplist" class="table_wrp shop_list">
									<table cellspacing="0" class="table">
								<thead class="thead">
									<tr>
										<th class="table_cell" style="width:30%"><div class="td_panel tl">门店名称</div></th>
										<th class="table_cell"><div class="td_panel tl">地址</div></th>
									</tr>
								</thead>
				<tbody class="tbody">
				    <?php foreach($kqcontent['location_id_list'] as $vv){
					    if(empty($vv)) continue;
					?>
					<tr>
						<td class="table_cell"><div class="td_panel tl"><?php echo $shoplist[$vv]['business_name'];if(!empty($shoplist[$vv]['branch_name'])) echo '（'.$shoplist[$vv]['branch_name'].'）'?></div></td>
						<td class="table_cell"><div class="td_panel tl"><?php echo $shoplist[$vv]['address'];?></div></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
				<div id="js_pagerbar"></div>
				</div>
				</div>
			</li>
		</ul>
	</div>
    <?php } ?>
	<?php if(!empty($kqcontent['custom_url_name']) || (isset($kqcontent['promotion_url_name']) && $kqcontent['promotion_url_name']) || (isset($cardinfo['kqexpand']['custom_cell1']['name']) && $cardinfo['kqexpand']['custom_cell1']['name'])){?>
	<div class="msg_section msg_pre_view">
		<ul>
			<li class="section_title">自定义入口&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
			<li class="group">
				<span class="l title">&nbsp; </span>
				<div class="msg">
					<ul class="info_list custom_list">
						<?php if(!empty($kqcontent['custom_url_name'])) {?>
						<li class="info_li">
							<p class="info"><a target="_blank" href="<?php echo $kqcontent['custom_url'];?>"><?php echo $kqcontent['custom_url_name'];?></a></p>
							<span class="supply_area"><?php echo $kqcontent['custom_url_sub_title'];?><i class="ic ic_go"></i></span>
						</li>
						<?php }
							if (isset($kqcontent['promotion_url_name']) && $kqcontent['promotion_url_name']) {
						?>
						<li class="info_li">
							<p class="info"><a target="_blank" href="<?php echo $kqcontent['promotion_url'];?>"><?php echo $kqcontent['promotion_url_name'];?></a></p>
							<span class="supply_area"><?php echo $kqcontent['promotion_url_sub_title'];?><i class="ic ic_go"></i></span>
						</li>
						<?php }
							if (isset($cardinfo['kqexpand']['custom_cell1']['name']) && $cardinfo['kqexpand']['custom_cell1']['name']) {
						?>
						<li class="info_li">
							<p class="info"><a target="_blank" href="<?php echo $cardinfo['kqexpand']['custom_cell1']['url'];?>"><?php echo $cardinfo['kqexpand']['custom_cell1']['name'];?></a></p>
							<span class="supply_area"><?php echo $cardinfo['kqexpand']['custom_cell1']['tips'];?><i class="ic ic_go"></i></span>
						</li>
						<?php }?>
					</ul>
				</div>
			</li>					
		</ul>
	</div>
	<?php }?>
						
		</div>
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
</body>

</html>