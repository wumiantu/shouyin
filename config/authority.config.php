<?php
	/**
	 * 2015-08-11 Brooke
	 * 用户权限控制
	 * @param 第一列为项目名称 大小写不限制，为了美观最好大写
	 * @return Array
	 */
	 return array(
	 	'Merchants' => array(
			'User' => array(
				'Pay'=> array(
					'Config|Field' => '支付设置',
					'Des'=> '在线支付设置'
				),
				'Cashier'=> array(
					'Index' => '收银台首页',
					'PayRecord'=> '收款记录',
					'EwmRecord'=> '二维码生成记录',
					'Odetail'=> '订单详情',
					'DelOrderByid'=> '订单删除',
					'WxRefund'=> '退款',
					'payment'=> '刷卡支付页',
					'wxSmRefund'=> '扫码退款处理',
					'Des'=> '收银台设置'
				),
				'Merchant'=> array(
					'Employers' => '员工列表',
					'EmployersAdd' => '添加员工',
					'EmployersAppemd' => '编辑员工',
					'Field' => '修改员工登陆状态',
					'EmployersDel|EmployersDelAll' => '删除员工',
					'employersEdit' => '编辑',
					'Des'=> '商家设置'
				),
					'statistics'=> array(
					'index' => '收入数据统计',
					'fans' => '粉丝支付统计',
					'otherpie' => '概况统计',
					'Des'=> '数据统计'
				),
					'wxCoupon'=> array(
					'index' => '卡券管理',
					'createKq|docreateKq' => '创建卡券',
					'delCardByid' => '卡券删除',
					'ModifyStock'=>'卡券库存修改',
					'wxReceiveList' => '卡券领取列表',
					'consumeCard' => '卡券核销',
					'Des'=> '卡券设置'
				),
				'Des'=> '用户界面操作',
			)
		)
	 );
?>