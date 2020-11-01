<!DOCTYPE html>
<html>
<head>
<title>创建会员卡</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/card_control.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/section_card_notification.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<style type="text/css">
#dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
#dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
#dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
#dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
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
                    <h2>微信会员卡</h2>
                    <ol class="breadcrumb">
                        <li><a>User</a></li>
                        <li><a>wxCoupon</a></li>
                        <li class="active"><strong>card</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeIn">
				<div class="row" id="wrapper-content-list">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">	
								<div class="alert alert-warning" style="font-size: 16px;"> 温馨提示：如果您输入的字数超过规定的字数，提交到微信服务器审核，会报错或审核不通过</div>
							</div>
							<div class="ibox-content">
								<div class="group">
									<div id="js_preview_area" class="media_preview_area">
										<div class="msg_card"> 
											<div class="msg_card_inner">
												<p class="msg_title" style="margin: 0;"><?php echo $this->card_type[$typeid]['zhname']?></p> 
												<div class="js_preview msg_card_section shop disabled focus itemdiv"> 
													<div id="js_color_preview" class="shop_panel" style="background-color: rgb(99, 179, 89);"> 
														<div class="logo_area group"> 
															<span class="logo l"> <img src="<?php echo $wxcouponSet['logurl']?>" id="js_logo_url_preview" /> </span> 
															<p id="brand_name_preview"><?php echo $wxcouponSet['mname']?></p> 
														</div> 
														<div class="msg_area"> 
															<div class="tick_msg"> 
																<p> <b id="title_preview"></b> </p> 
																<span id="sub_title_preview"></span> 
																<br /> 
															</div> 
															<p class="time"><span id="js_time_preview">有效期：<span class="time1"><?php echo $datestart;?></span> - <span class="time2"><?php echo $dateend;?></span></span></p> 
														</div> 
													</div> 
													<div class="msg_card_mask"> 
														<span class="vm_box"></span> 
														<a class="js_edit_icon edit_oper" data-actionid="1" href="javascript:;"><i class="icon18_common edit_gray"></i></a> 
													</div> 
													<div class="deco"></div> 
												</div> 
												<div class="js_preview msg_card_section dispose disabled itemdiv"> 
													<div id="js_destroy_title" class="unset"> 
														<p>销券设置</p> 
													</div> 
													<div id="js_destroy_type_preview"> 
														<div class="barcode_area js_code_preview js_code_preview_1" style="display: none;"> 
															<div class="barcode"></div> 
															<p class="code_num">8557-4294-9941</p> 
														</div> 
														<div class="qrcode_area js_code_preview js_code_preview_2" style="display: none;"> 
															<div class="qrcode"></div> 
															<p class="code_num">8557-4294-9941</p> 
														</div> 
														<div class="sn_area js_code_preview js_code_preview_0" style="display: none;">8557-4294-9941</div> 
														<p id="noticehint_preview" class="sub_msg tc"></p> 
													</div> 
													<div class="msg_card_mask"> 
														<span class="vm_box"></span> 
														<a class="js_edit_icon edit_oper" data-actionid="2" href="javascript:;"><i class="icon18_common edit_gray"></i></a> 
													</div> 
												</div> 
												<div class="shop_detail"> 
													<ul class="list"> 
														<li class="msg_card_section js_preview itemdiv"> 
															<div href="" class="li_panel"> 
																<div class="li_content"> 
																	<p><?php echo $this->card_type[$typeid]['zhname']?>详情</p> 
																</div> 
																<span class="ic ic_go"></span> 
															</div> 
															<div class="msg_card_mask"> 
																<span class="vm_box"></span> 
																<a class="js_edit_icon edit_oper" data-actionid="3" href="javascript:;"><i class="icon18_common edit_gray"></i></a> 
															</div> 
														</li> 
														<li class="msg_card_section js_preview last_li itemdiv"> 
															<div href="" class="li_panel"> 
																<div class="li_content"> 
																	<p>适用门店</p> 
																</div> 
																<span class="ic ic_go"></span> 
															</div> 
															<div class="msg_card_mask"> 
																<span class="vm_box"></span> 
																<a class="js_edit_icon edit_oper" data-actionid="4" href="javascript:;"><i class="icon18_common edit_gray"></i></a> 
															</div> 
														</li>
													</ul> 
												</div> 
												<div class="custom_detail"> 
													<ul id="js_custom_url_preview" class="list">
														<li class="msg_card_section js_preview last_li itemdiv"> 
															<div class="li_panel">
																<div class="li_content">
																	<p><span id="customurlname_preview">自定义入口一(选填)</span><span class="supply_area"><span id="customurlsubtitle_preview"></span><span class="ic ic_go"></span></span></p>
																</div> 
															</div> 
															<div class="msg_card_mask"> 
																<span class="vm_box"></span> 
																<a class="js_edit_icon edit_oper" href="javascript:;" data-actionid="5"><i class="icon18_common edit_gray"></i></a>
															</div> 
														</li>
														<li class="msg_card_section js_preview last_li itemdiv"> 
															<div class="li_panel">
																<div class="li_content">
																	<p><span id="promotionname_preview">自定义入口二(选填)</span><span class="supply_area"><span id="promotionsubtitle_preview"></span><span class="ic ic_go"></span></span></p>
																</div> 
															</div>
															<div class="msg_card_mask"> 
																<span class="vm_box"></span> 
																<a class="js_edit_icon edit_oper" href="javascript:;" data-actionid="5"><i class="icon18_common edit_gray"></i></a>
															</div>
														</li>
														<li class="msg_card_section js_preview last_li itemdiv"> 
															<div class="li_panel">
																<div class="li_content">
																	<p><span id="custom_cell1name_preview">自定义入口三(选填)</span><span class="supply_area"><span id="custom_cell1tips_preview"></span><span class="ic ic_go"></span></span></p>
																</div> 
															</div>
															<div class="msg_card_mask"> 
																<span class="vm_box"></span> 
																<a class="js_edit_icon edit_oper" href="javascript:;" data-actionid="5"><i class="icon18_common edit_gray"></i></a>
															</div>
														</li>
													</ul> 
												</div> 
											</div> 
										</div>
									</div> 
									<form id="js_editform" name="js_editform" class="media_edit" novalidate="novalidate" method="POST" action="?m=User&c=wxCoupon&a=docreateKq&typeid=<?php echo $typeid;?>"> 
										<div id="js_edit_area" class="media_edit_area" style="margin-top: 0px;">
											<div class="js_edit_content portable_editor to_left appmsg_editor econtent1" style="display: block;"> 
												<input type="hidden" value="5" name="ctype" /> 
												<div class="inner"> 
													<div class="editor_section"> 
														<h3 class="title"> 券面信息 </h3> 
														<div class="appmsg_edit_item"> 
															<label class="frm_label" for=""> <strong class="title">商户LOGO</strong> </label> 
															<div class="input_submsg"> 
																<div class="frm_controls frm_vertical_lh"> 
																	<div class="brand_item"> 
																		<div class="brand_img">
																			<img src="<?php echo $wxcouponSet['logurl']?>" id="js_logo_url_preview_1" />
																		</div>
																		<input type="hidden" value="<?php echo $wxcouponSet['wxlogurl']?>" id="js_logo_url" name="base_info[logo_url]" /> 
																		<div class="dropz" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 80px;text-align: center;cursor: pointer; display: inline-block; background-color: #fff;">上传LOGO</div>
																	</div> 
																</div> 
															</div> 
															<p class="frm_tips"></p> 
														</div> 
														 
														<div class="appmsg_edit_item appmsg_input_submsg_item group appmsg_edit_item_label_mult"> 
															<label class="frm_label" for=""> <strong class="title">商户名称</strong> <br /></label> 
															<div class="appmsg_edit_item frm_normal"> 
																<span class="frm_input_box"> <input type="text" placeholder="请填写商户名称" class="frm_input ckinput" name="base_info[brand_name]" id="brand_name" value="<?php echo $wxcouponSet['mname']?>" /> </span>
																<span class="tips"><span id="js_brand_name_tip">0</span>/<span id="js_brand_name_limit">12</span></span> 
																<p class="frm_msg fail" style="display: none;"><span for="title" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
																<p class="frm_tips">商户名称请保持在12汉子或24个英文字母以内</p> 
															</div>
														</div>
														 
														<div class="appmsg_edit_item"> 
															<label class="frm_label" for=""> <strong class="title">卡券颜色</strong> </label> 
															<div class="color_picker dropdown_menu" id="js_colorpicker">
																<a class="btn dropdown_switch jsDropdownBt" href="javascript:;"><label class="jsBtLabel" style="background-color: rgb(99, 179, 89);">#63b359</label><i class="arrow"></i></a> 
																<div class="dropdown_data_container jsDropdownList" style="display: none;"> 
																	<ul class="dropdown_data_list"> 
																		<?php 
																			if(!empty($wxCardColor)){
																				foreach($wxCardColor as $key=>$wxc){
																		?>
																		<li class="dropdown_data_item wxcolor<?php echo $key;?>"> <a class="jsDropdownItem" href="javascript:;" onclick="GetTishColor('<?php echo $wxc['name'];?>','<?php echo $wxc['value'];?>');return false;" style="background-color:<?php echo $wxc['value'];?>"><?php echo $wxc['value'];?></a> </li> 
																		<?php 
																				}
																			}
																		?>
																	</ul> 
																</div> 
															</div> 
															<span> <input type="hidden" id="js_color" name="base_info[color]" value="Color010" /> </span> 
														</div> 
														
														<div class="appmsg_edit_item frm_normal"> 
															<label class="frm_label" for=""> <strong class="title"><?php echo $this->card_type[$typeid]['zhname']?>标题</strong> </label> 
															<span class="frm_input_box"> <input type="text" placeholder="" class="frm_input ckinput"id="title" name="base_info[title]" value="" /> </span> 
															<span class="tips"><span id="js_title_tip">0</span>/<span id="js_title_limit">9</span></span> 
															<p class="frm_msg fail"><span for="title" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
															<p class="frm_tips">建议填写优惠券提供的服务或商品名称，描述卡券提供的具体优惠</p> 
														</div> 
														<div class="appmsg_edit_item"> 
															<label class="frm_label" for=""> <strong class="title">副标题<br /><span class="tips">(选填)</span></strong> </label> 
															<span class="frm_input_box"> <input type="text" placeholder="" class="frm_input ckinput" id="sub_title" name="base_info[sub_title]" value="" /> </span> 
															<span class="tips"><span id="js_sub_title_tip">0</span>/<span id="js_sub_title_limit">18</span></span>
															<p class="frm_msg fail"><span for="sub_title" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p> 
														</div> 
														
														<div class="appmsg_edit_item"> 
															<label class="frm_label"><strong class="title">是否支持储值</strong></label> 
															<span class="frm_checkbox_label"><input type="checkbox" class="frm_radio frm_checkbox" value="1" id="supply_balance" name="supply_balance"/></span> 
														</div>
														<div class="js_appmsg_edit_item_p balance" style="display: none;">
															<div class="appmsg_edit_item">
																<label class="frm_label"><strong class="title">查看余额详情</strong></label>
																<div class="frm_controls">
																	<span class="frm_hint">http://</span>
																	<span class="frm_input_box url_box">
																		<input type="text" class="frm_input js_link_url" name="balance_url" value="">
																	</span>
																</div>
															</div>
														</div>
														<div class="appmsg_edit_item balance" style="display: none;"> 
															<label class="frm_label"><strong class="title">储值说明</strong></label> 
															<span class="frm_input_box"><input type="text" placeholder="" class="frm_input" value="" name="balance_rules"/></span> 
														</div> 
														
														<div class="appmsg_edit_item"> 
															<label class="frm_label"><strong class="title">是否显示积分</strong></label> 
															<span class="frm_checkbox_label"><input type="checkbox" class="frm_radio frm_checkbox" checked="checked" id="supply_bonus" name="supply_bonus" value="1"/></span> 
														</div>
														<div class="js_appmsg_edit_item_p bonus">
															<div class="appmsg_edit_item">
																<label class="frm_label"><strong class="title">查看积分详情</strong></label>
																<div class="frm_controls">
																	<span class="frm_hint">http://</span>
																	<span class="frm_input_box url_box">
																		<input type="text" class="frm_input js_link_url" name="bonus_url" value="">
																	</span>
																</div>
															</div>
														</div>
														<div class="appmsg_edit_item bonus"> 
															<label class="frm_label"><strong class="title">积分规则说明</strong></label> 
															<span class="frm_input_box"><input type="text" placeholder="每消费一元获取1点积分" class="frm_input" value="" name="bonus_rules"/></span> 
														</div>
														<div class="appmsg_edit_item bonus"> 
															<label class="frm_label"><strong class="title">积分规则</strong></label>
															<div class="input-daterange input-group">
																<input type="text" value="" name="bonus_rule[cost_money_unit]" class="input-sm form-control" id="cost_money_unit" placeholder="100">
																<span class="input-group-addon">￥(单位：分),增加</span>
																<input type="text" value="" name="bonus_rule[increase_bonus]" class="input-sm form-control" id="increase_bonus" placeholder="10">
															</div>
														</div>
														<div class="appmsg_edit_item bonus"> 
															<label class="frm_label"><strong class="title">清零规则</strong></label> 
															<span class="frm_input_box"><input type="text" placeholder="每年年底12月30号积分清0。" class="frm_input" value="" name="bonus_cleared"/></span> 
														</div>
														<div class="appmsg_edit_item bonus"> 
															<label class="frm_label"><strong class="title">初始积分</strong></label> 
															<span class="frm_input_box"><input type="text" placeholder="10" class="frm_input" value="" name="bonus_rule[init_increase_bonus]"/></span> 
														</div>
														<div class="appmsg_edit_item bonus"> 
															<label class="frm_label"><strong class="title">积分上限</strong></label> 
															<span class="frm_input_box"><input type="text" placeholder="10000" class="frm_input" value="" name="bonus_rule[max_increase_bonus]"/></span> 
														</div>
														
														<div class="appmsg_edit_item radio_item"> 
															<div class="frm_control_group radio_row"> 
																<label class="frm_label" for="">有效期</label> 
																<div class="frm_controls frm_vertical_lh"> 
																	<div class="radio_control_group group"> 
																		<label class="frm_radio_label frm_radio_input selected" for="DATE_TYPE_PERMANENT"> <i class="icon_radio"></i><input type="radio" class="frm_radio js_validtime" value="DATE_TYPE_PERMANENT" id="DATE_TYPE_PERMANENT" checked="checked" name="date_type"/><span class="lbl_content"> 永久有效 &nbsp;&nbsp;</span> </label> 
																	</div> 
																</div> 
																<div class="frm_controls frm_vertical_lh"> 
																	<div class="radio_control_group group"> 
																		<label class="frm_radio_label frm_radio_input selected" for="DATE_TYPE_FIX_TIME_RANGE"> <i class="icon_radio"></i><input type="radio" class="frm_radio js_validtime" value="DATE_TYPE_FIX_TIME_RANGE" id="DATE_TYPE_FIX_TIME_RANGE" name="date_type"/><span class="lbl_content"> 固定日期 &nbsp;&nbsp;</span> </label> 
																		<div id="ymdatepicker" class="input-daterange input-group">
																			<input type="text" value="<?php echo $datestart;?>" name="datestart" class="input-sm form-control" id="ymstart" placeholder="有效开始时间">
																			<span class="input-group-addon"> T O </span>
																			<input type="text" value="<?php echo $dateend;?>" name="dateend" class="input-sm form-control" id="ymend" placeholder="有效结束时间">
																		</div>
																	</div> 
																</div> 
															</div> 
														</div> 
													</div> 
												</div> 
												<i style="margin-top: 0px;" class="arrow arrow_out"></i> 
												<i style="margin-top: 0px;" class="arrow arrow_in"></i> 
											</div> 
											<div class="js_edit_content portable_editor to_left appmsg_editor econtent2" style="display: none;"> 
												<div class="inner"> 
													<div class="editor_section"> 
														<h3 class="title"> 领券设置 </h3> 
														<div class="appmsg_edit_item"> 
															<label class="frm_label" for=""> <strong class="title">库存</strong> </label> 
															<div class="input_submsg"> 
																<span class="frm_input_box"><input type="text" class="frm_input" value="" name="quantity" onkeyup="value=value.replace(/[^1234567890]+/g,'')"/></span> 
																<span class="input_sub_msg">份</span> 
																<p class="frm_msg fail"><span for="quantity" class="frm_msg_content">库存只能是大于0的数字</span></p>
															</div> 
														</div> 
														<div class="appmsg_edit_item appmsg_edit_item_label_mult appmsg_input_submsg_item group"> 
															<label class="frm_label l" for=""> <strong class="title">领券限制<br /><span class="tips">(选填)</span></strong> </label> 
															<div class="input_submsg l"> 
																<span class="frm_input_box"><input type="text" placeholder="" class="frm_input" value=""name="base_info[get_limit]" onkeyup="value=value.replace(/[^1234567890]+/g,'')"/></span> 
																<span class="input_sub_msg">张</span> 
															</div> 
															<p class="frm_tips">每个用户领券上限，如不填，则默认为1</p> 
														</div> 
														<div id="js_share_type" class="appmsg_edit_item"> 
															<div class="frm_control_group"> 
																<div class="frm_controls frm_vertical_lh"> 
																	<label class="frm_checkbox_label selected" for="checkbox11"> <i class="icon_checkbox"></i> <span class="lbl_content">卡券领取页面是否可分享</span> <input type="checkbox" class="frm_radio frm_checkbox" checked="checked" value="1" id="checkbox11" name="base_info[can_share]"/></label>
																	<label class="frm_checkbox_label selected" for="checkbox12"> <i class="icon_checkbox"></i> <span class="lbl_content">用户领券后可转赠其他好友</span> <input type="checkbox" class="frm_radio frm_checkbox" checked="checked" id="checkbox12" name="base_info[can_give_friend]" value="1"/> </label> 
																</div> 
															</div> 
														</div> 
													</div> 
													<div class="editor_section"> 
														<h3 class="title"> 销券设置 </h3> 
														<div class="appmsg_edit_item row_item"> 
															<div id="js_destroy_type" class="frm_control_group radio_row"> 
																<label class="frm_label" for="">销券方式</label> 
																<div class="radio_control_group group"> 
																	<label class="frm_radio_label" for="checkbox4"> <span class="lbl_content">二维码 ： </span> 包含卡券信息的二维码，扫描后可进行销券 </label> 
																</div>
																<input type="hidden" id="js_hidden_code_type" name="code_type" value="CODE_TYPE_QRCODE" /> 
															</div> 
														</div> 
														<div class="appmsg_edit_item frm_normal"> 
															<label class="frm_label" for=""> <strong class="title">操作提示</strong> </label> 
															<span class="frm_input_box"> <input type="text" class="frm_input ckinput" value="" name="base_info[notice]" id="noticehint"/> </span> 
															<span class="tips"><span id="js_noticehint_tip">0</span>/<span id="js_noticehint_limit">16</span></span>
															<p class="frm_msg fail"><span for="noticehint" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
															<p class="frm_tips">建议引导用户到店出示卡券，由店员完成核销操作</p> 
														</div> 
													</div> 
												
												</div> 
												<i style="margin-top: 0px;" class="arrow arrow_out"></i> 
												<i style="margin-top: 0px;" class="arrow arrow_in"></i> 
											</div> 
											<div class="js_edit_content portable_editor to_left appmsg_editor econtent3" style="display: none;"> 
												<div class="inner"> 			 
													<div class="appmsg_edit_item textarea_item">
														<label class="frm_label">
															<strong class="title">特权说明</strong>
														</label>
														<div class="frm_controls">
															<div class="frm_textarea_box">
																<textarea placeholder="" name="prerogative" class="frm_textarea valid" id="prerogative"></textarea>
															</div>
														</div>
														<p class="frm_msg fail"><span for="detailtext" class="frm_msg_content">特权说明不能为空且长度不超过1024个汉字</span></p>
													</div>
													
													<div class="appmsg_edit_item textarea_item"> 
														<label class="frm_label" for=""> <strong class="title">使用须知</strong> </label> 
														<div class="frm_controls"> 
															<div class="frm_textarea_box"> 
																<textarea placeholder="" name="base_info[description]" class="frm_textarea" id="description"></textarea> 
															</div> 
														</div> 
														<p class="frm_msg fail"><span for="description" class="frm_msg_content">使用须知不能为空且长度不超过300个汉字</span></p>
													</div> 
													<div class="appmsg_edit_item"> 
														<label class="frm_label" for=""> <strong class="title">客服电话</strong> </label> 
														<span class="frm_input_box"><input type="text" placeholder="" class="frm_input" value="" name="base_info[service_phone]" onkeyup="value=value.replace(/[^1234567890-]+/g,'')"/></span> 
														<p class="frm_tips">手机或固话</p>
													</div> 
												</div> 
												<i style="margin-top: 0px;" class="arrow arrow_out"></i> 
												<i style="margin-top: 0px;" class="arrow arrow_in"></i> 
											</div> 
											
											<div class="js_edit_content portable_editor to_left appmsg_editor econtent4" style="display: none;"> 
												<div class="inner"> 			 
													<div class="editor_section">
														<h3 class="title">适用门店</h3>
														<div class="ibox float-e-margins">
															<div class="table-responsive">
																<table class="table table-striped">
																	<thead>
																		<tr>
																			<th>请选择</th>
																			<th>门店名</th>
																			<th>地址</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php if(!empty($shoplist)){
																		foreach($shoplist as $svv){
																		?>
																		<tr>
																			<td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" name="inputpoiid[]" value="<?php echo $svv['poi_id']?>" class="i-checks"><ins class="iCheck-helper"></ins></div></td>
																			<td><?php echo $svv['business_name'];if(!empty($svv['branch_name'])) echo "（".$svv['branch_name']."）";?></td>
																			<td><?php echo $svv['address']?></td>
																		</tr>
																		<?php }}else{?>
																		<tr>
																			<td colspan="3">您还没有创建店铺，请到微信公共平台创建</td>
																		</tr>
																		<?php }?>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div> 
												<i style="margin-top: 0px;" class="arrow arrow_out"></i> 
												<i style="margin-top: 0px;" class="arrow arrow_in"></i> 
											</div> 
											
											<div class="js_edit_content portable_editor to_left appmsg_editor econtent5" style="display: none;"> 
												<div class="inner"> 
													<div id="js_config_url_p1"> 
														<div class="editor_section js_appmsg_url_item">
															<h3 class="title js_card_title">
																<p><span class="js_appmsg_url_intro">入口一</span>
																<!--<a href="javascript:;" class="link js_delete_item">删除</a>-->
																</p>
															</h3>
															<div class="">
																<div class="appmsg_edit_item frm_normal">
																	<label class="frm_label" for="">
																		<strong class="title">入口名称</strong>
																	</label>
																	<span class="frm_input_box">
																		<input type="text" class="frm_input ckinput" id="customurlname" name="base_info[custom_url_name]" value="">
																	</span>
																	<span class="tips"><span id="js_customurlname_tip">0</span>/<span id="js_customurlname_limit">5</span></span>
																	<p class="frm_msg fail"><span for="customurlname" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
																</div>
																<div class="appmsg_edit_item frm_normal">
																	<label class="frm_label" for="">
																		<strong class="title">引导语<br>
																		<span class="tips">(选填)</span>
																		</strong>
																	</label>
																	<span class="frm_input_box">
																		<input type="text" class="frm_input ckinput" value="" id="customurlsubtitle" name="base_info[custom_url_sub_title]">
																	</span>
																	<span class="tips"><span id="js_customurlsubtitle_tip">0</span>/<span id="js_customurlsubtitle_limit">6</span></span>
																	<p class="frm_msg fail"><span for="customurlsubtitle" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
																</div>
																<div class="appmsg_edit_item js_jump_url_p">
																	<label class="frm_label" for="">点击跳转</label>
																	<div class="frm_controls">
																		<label class="frm_radio_label" for="checkbox24">
																			<i class="icon_radio"></i>
																			<span class="lbl_content">网页链接</span>
																			 <!--<input type="radio" class="frm_radio js_jump_custom_url" name="js_jump_url_1" id="checkbox24">-->
																		</label>
																	</div>
																</div>
																<div class="js_appmsg_edit_item_p">
																	<div class="appmsg_edit_item">
																		<label class="frm_label">
																			<strong class="title">网页链接</strong>
																		</label>
																		<div class="frm_controls">
																			<span class="frm_hint">http://</span>
																			<span class="frm_input_box url_box">
																				<input type="text" class="frm_input js_link_url" name="base_info[custom_url]" value="">
																			</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div> 
													<div id="js_config_url_p2"> 
														<div class="editor_section js_appmsg_url_item">
															<h3 class="title js_card_title">
																<p><span class="js_appmsg_url_intro">入口二</span>
																<!--<a class="link js_delete_item" href="javascript:;">删除</a>-->
																</p>
															</h3>
															<div class="">
																<div class="appmsg_edit_item frm_normal">
																	<label for="" class="frm_label">
																		<strong class="title">入口名称</strong>
																	</label>
																	<span class="frm_input_box">
																		<input type="text" value="" id="promotionname" name="base_info[promotion_url_name]" class="frm_input ckinput">
																	</span>
																	<span class="tips"><span id="js_promotionname_tip">0</span>/<span id="js_promotionname_limit">5</span></span>
																	<p class="frm_msg fail"><span for="promotionname" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
																</div>
																<div class="appmsg_edit_item frm_normal">
																	<label for="" class="frm_label">
																		<strong class="title">引导语<br>
																			<span class="tips">(选填)</span>
																		</strong>
																	</label>
																	<span class="frm_input_box">
																		<input type="text" value="" class="frm_input ckinput" id="promotionsubtitle" name="base_info[promotion_url_sub_title]">
																	</span>
																	<span class="tips"><span id="js_promotionsubtitle_tip">0</span>/<span id="js_promotionsubtitle_limit">6</span></span>
																	<p class="frm_msg fail"><span for="promotionsubtitle" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
																</div>
																<div class="appmsg_edit_item js_jump_url_p">
																	<label for="" class="frm_label">点击跳转</label>
																	<div class="frm_controls">
																		<label for="checkbox24" class="frm_radio_label">
																			<i class="icon_radio"></i>
																			<span class="lbl_content">网页链接</span>
																			<!--<input type="radio" class="frm_radio js_jump_custom_url" name="js_jump_url_1" id="checkbox24">-->
																		</label>
																	</div>
																</div>
																<div class="js_appmsg_edit_item_p">
																	<div class="appmsg_edit_item">
																		<label class="frm_label">
																			<strong class="title">网页链接</strong>
																		</label>
																		<div class="frm_controls">
																			<span class="frm_hint">http://</span>
																			<span class="frm_input_box url_box">
																				<input type="text" value="" class="frm_input js_link_url" name="base_info[promotion_url]">
																			</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div id="js_config_url_p3"> 
														<div class="editor_section js_appmsg_url_item">
															<h3 class="title js_card_title">
																<p><span class="js_appmsg_url_intro">入口三</span>
																</p>
															</h3>
															<div class="">
																<div class="appmsg_edit_item frm_normal">
																	<label for="" class="frm_label">
																		<strong class="title">入口名称</strong>
																	</label>
																	<span class="frm_input_box">
																		<input type="text" value="" id="custom_cell1name" name="custom_cell1[name]" class="frm_input ckinput">
																	</span>
																	<span class="tips"><span id="js_custom_cell1name_tip">0</span>/<span id="js_custom_cell1name_limit">6</span></span>
																	<p class="frm_msg fail"><span for="custom_cell1name" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
																</div>
																<div class="appmsg_edit_item frm_normal">
																	<label for="" class="frm_label">
																		<strong class="title">引导语<br>
																			<span class="tips">(选填)</span>
																		</strong>
																	</label>
																	<span class="frm_input_box">
																		<input type="text" value="" class="frm_input ckinput" id="custom_cell1tips" name="custom_cell1[tips]">
																	</span>
																	<span class="tips"><span id="js_promotionsubtitle_tip">0</span>/<span id="js_custom_cell1tips_limit">6</span></span>
																	<p class="frm_msg fail"><span for="promotionsubtitle" class="frm_msg_content">您已经超出长度了，超出了<strong></strong></span></p>
																</div>
																<div class="appmsg_edit_item js_jump_url_p">
																	<label for="" class="frm_label">点击跳转</label>
																	<div class="frm_controls">
																		<label for="checkbox24" class="frm_radio_label">
																			<i class="icon_radio"></i>
																			<span class="lbl_content">网页链接</span>
																			<!--<input type="radio" class="frm_radio js_jump_custom_url" name="js_jump_url_1" id="checkbox24">-->
																		</label>
																	</div>
																</div>
																<div class="js_appmsg_edit_item_p">
																	<div class="appmsg_edit_item">
																		<label class="frm_label">
																			<strong class="title">网页链接</strong>
																		</label>
																		<div class="frm_controls">
																			<span class="frm_hint">http://</span>
																			<span class="frm_input_box url_box">
																				<input type="text" value="" class="frm_input js_link_url" name="custom_cell1[url]">
																			</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div> 
												<i style="margin-top: 0px;" class="arrow arrow_out"></i> 
												<i style="margin-top: 0px;" class="arrow arrow_in"></i> 
											</div>
										</div> 
									</form> 
								</div> 
								<div class="tool_bar border tc">
									<button id="add_wx_card" class="btn btn-primary" style="height: 36px;"> 提交审核 </button>
								</div>
							</div>
						</div>
                    </div>
                </div>
        	</div>
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>
	<!-- DROPZONE -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
    <script type="text/javascript">
     var  wxCouponType='<?php echo $typeid;?>';
	      wxCouponType=parseInt(wxCouponType);
        $(document).ready(function() { 
			$('#ymdatepicker input').datepicker({
                keyboardNavigation: false,
                forceParse: false,
				format: "yyyy-mm-dd",
                autoclose: true
            });
		    	$(".dropz").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $(".dropz")****/
						if(!rept.error){
					        $('#js_logo_url_preview,#js_logo_url_preview_1').attr('src',rept.localimg);
						    $('#js_logo_url').val(rept.wxlogurl);
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});

          $('.i-checks').iCheck({
               checkboxClass: 'icheckbox_square-green',
               radioClass: 'iradio_square-green',
           });

		});
    </script>
	<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/commonfunc.js"></script>
</body>
</html>