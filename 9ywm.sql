-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 12 月 01 日 03:03
-- 服务器版本: 5.0.96-community-nt
-- PHP 版本: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `demo8`
--

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_adminuser`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_adminuser` (
  `uid` int(10) unsigned NOT NULL auto_increment,
  `mid` int(10) unsigned NOT NULL,
  `account` varchar(100) NOT NULL,
  `pwd` varchar(35) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `lastlogintime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `mid` USING BTREE (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `pigcms_cashier_adminuser`
--

INSERT INTO `pigcms_cashier_adminuser` (`uid`, `mid`, `account`, `pwd`, `salt`, `lastlogintime`) VALUES
(1, 1, 'admin', 'f38c5e02893208eae391079d20488558', 'pigcmso2oCashier', 1448910101);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_employee`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_employee` (
  `eid` int(11) NOT NULL auto_increment,
  `mid` int(11) NOT NULL,
  `username` char(50) NOT NULL,
  `account` char(100) NOT NULL,
  `password` char(32) NOT NULL,
  `email` char(200) NOT NULL,
  `salt` char(20) NOT NULL,
  `authority` text,
  `status` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`eid`),
  KEY `mid` USING BTREE (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_fans`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_fans` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mid` int(10) unsigned NOT NULL,
  `appid` varchar(200) NOT NULL COMMENT '公众号id',
  `openid` varchar(250) NOT NULL COMMENT '公众号对应的公众号openid',
  `cf` varchar(100) NOT NULL default 'local' COMMENT '来源',
  `totalfee` int(10) unsigned NOT NULL default '0' COMMENT '支付总额(分)',
  `refund` int(10) unsigned NOT NULL default '0' COMMENT '退款金额分',
  `is_subscribe` tinyint(4) NOT NULL COMMENT '1关注',
  `nickname` varchar(250) NOT NULL COMMENT '昵称',
  `sex` tinyint(1) unsigned NOT NULL default '0' COMMENT '1男2女0未知',
  `province` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `headimgurl` varchar(500) NOT NULL COMMENT '头像',
  `groupid` int(10) unsigned NOT NULL default '0' COMMENT '微信粉丝分组id',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_merchants`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_merchants` (
  `mid` int(11) NOT NULL auto_increment,
  `username` char(50) default NULL,
  `thirduserid` varchar(100) NOT NULL COMMENT '第三方唯一身份ID',
  `password` char(32) default NULL,
  `salt` char(50) NOT NULL,
  `wxname` char(210) NOT NULL,
  `weixin` varchar(150) NOT NULL COMMENT '微信号',
  `email` char(100) default NULL,
  `logo` char(200) NOT NULL,
  `regTime` int(11) default NULL,
  `regIp` char(20) default NULL,
  `lastLoginTime` int(11) default '0',
  `lastLoginIp` char(20) default NULL,
  `source` tinyint(1) unsigned NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '1',
  `mfypwd` tinyint(1) unsigned NOT NULL COMMENT '1修改过密码',
  `aeskey` varchar(50) NOT NULL COMMENT 'EncodingAESKey',
  `wxtoken` varchar(40) NOT NULL COMMENT 'wxToken',
  `encodetype` tinyint(1) unsigned NOT NULL default '0' COMMENT '消息加解密方式',
  `isadmin` tinyint(1) unsigned NOT NULL default '0' COMMENT '1是总后台生成账号',
  PRIMARY KEY  (`mid`),
  KEY `thirduserid` (`thirduserid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `pigcms_cashier_merchants`
--

INSERT INTO `pigcms_cashier_merchants` (`mid`, `username`, `thirduserid`, `password`, `salt`, `wxname`, `weixin`, `email`, `logo`, `regTime`, `regIp`, `lastLoginTime`, `lastLoginIp`, `source`, `status`, `mfypwd`, `aeskey`, `wxtoken`, `encodetype`, `isadmin`) VALUES
(14, '52jscn', '', '69b8753c40df2cce8246300150ac6aa4', '272736', '52jscn', '', '52jscn@163.com', '', 1448909963, '2130706433', 1448909963, '2130706433', 0, 1, 0, '', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_order`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_order` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` char(32) NOT NULL,
  `mid` int(11) NOT NULL,
  `pmid` int(10) unsigned NOT NULL default '0' COMMENT '代理者mid',
  `pay_way` char(50) NOT NULL,
  `pay_type` char(50) NOT NULL,
  `goods_type` char(50) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `goods_name` char(200) NOT NULL,
  `goods_describe` varchar(500) NOT NULL,
  `goods_price` decimal(12,2) NOT NULL default '0.00',
  `add_time` int(11) NOT NULL,
  `paytime` int(10) unsigned NOT NULL default '0' COMMENT '支付时间',
  `state` tinyint(1) NOT NULL default '0',
  `ispay` tinyint(1) unsigned NOT NULL default '0' COMMENT '1已支付',
  `truename` varchar(250) NOT NULL,
  `openid` varchar(250) NOT NULL,
  `p_openid` varchar(250) NOT NULL COMMENT 'p_mid对应openid',
  `transaction_id` varchar(250) NOT NULL COMMENT '第三方支付订单号',
  `refund` tinyint(1) unsigned NOT NULL default '0' COMMENT '1退款中2已退款3失败',
  `refundtext` text NOT NULL COMMENT '退款结果数据',
  `comefrom` tinyint(1) unsigned NOT NULL default '0' COMMENT '0本地1微信营销 2微店 3 o2o系统',
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_payconfig`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_payconfig` (
  `id` int(11) NOT NULL auto_increment,
  `mid` int(11) NOT NULL,
  `isOpen` tinyint(1) NOT NULL default '0',
  `configData` varchar(2000) default NULL,
  `proxymid` int(10) unsigned NOT NULL default '0' COMMENT '代理者的mid',
  `wxsubmchid` varchar(30) NOT NULL COMMENT '分配到的子商户号',
  `pfpaymid` tinyint(1) unsigned NOT NULL default '0' COMMENT '平台代付mid',
  PRIMARY KEY  (`id`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_wxcoupon`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_wxcoupon` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mid` int(10) unsigned NOT NULL,
  `card_type` tinyint(1) unsigned NOT NULL default '0',
  `card_title` varchar(250) NOT NULL,
  `card_id` varchar(250) NOT NULL COMMENT '微信卡券ID',
  `status` tinyint(1) NOT NULL default '0' COMMENT '卡券状态',
  `isdel` tinyint(1) unsigned NOT NULL default '0' COMMENT '1删除',
  `begin_timestamp` int(10) unsigned NOT NULL default '0',
  `end_timestamp` int(10) unsigned NOT NULL default '0',
  `quantity` int(10) unsigned NOT NULL default '0' COMMENT '库存',
  `receivenum` int(10) unsigned NOT NULL default '0' COMMENT '领取数',
  `consumenum` int(10) unsigned NOT NULL default '0' COMMENT '核销数量',
  `get_limit` int(10) unsigned NOT NULL default '1' COMMENT '每人可领几张',
  `kqcontent` text NOT NULL COMMENT '卡券内容',
  `kqexpand` text NOT NULL COMMENT '卡券扩展内容',
  `checktime` int(10) unsigned NOT NULL default '0' COMMENT '审核通过时间',
  `addtime` int(10) unsigned NOT NULL default '0' COMMENT '添加时间',
  `cardticket` varchar(250) NOT NULL,
  `cardurl` varchar(250) NOT NULL COMMENT ' 二维码图片解析后的地址',
  `is_open_cell` tinyint(1) NOT NULL default '0' COMMENT '是否开启买单功能（0：否，1：开启）',
  `activate` tinyint(1) unsigned NOT NULL default '0' COMMENT '会员卡激活方式（0:字段激活，1：一键激活，2：手动激活）',
  PRIMARY KEY  (`id`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_wxcoupon_common`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_wxcoupon_common` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mid` int(10) unsigned NOT NULL,
  `logurl` varchar(250) NOT NULL,
  `mname` varchar(100) NOT NULL COMMENT '商户名字',
  `wxlogurl` varchar(250) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_cashier_wxcoupon_receive`
--

CREATE TABLE IF NOT EXISTS `pigcms_cashier_wxcoupon_receive` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `openid` varchar(250) NOT NULL COMMENT '领取人openid',
  `give_openId` varchar(250) NOT NULL COMMENT '转赠送方账号openid',
  `cardid` varchar(250) NOT NULL,
  `cardtype` tinyint(1) unsigned NOT NULL default '0' COMMENT '卡券类型',
  `cardtitle` varchar(250) NOT NULL COMMENT '卡券标题',
  `isgivebyfriend` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否为转赠',
  `cardcode` varchar(100) NOT NULL COMMENT 'code序列号',
  `oldcardcode` varchar(100) NOT NULL COMMENT '转赠前的code序列号',
  `outerid` int(10) unsigned NOT NULL COMMENT 'mid值',
  `status` tinyint(3) unsigned NOT NULL default '0' COMMENT '0领取1核销',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `deltime` int(10) unsigned NOT NULL COMMENT '用户删除时间',
  `consumetime` int(10) unsigned NOT NULL COMMENT '消费时间',
  `consumesource` varchar(100) NOT NULL COMMENT '核销来源',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
