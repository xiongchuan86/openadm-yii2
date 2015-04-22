-- phpMyAdmin SQL Dump
-- version 4.0.10.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost:/tmp/mysql-generic-5.5.37.sock
-- 生成日期: 2015-04-22 15:04:10
-- 服务器版本: 5.5.37-log
-- PHP 版本: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `{dbname}`
--
CREATE DATABASE IF NOT EXISTS `{dbname}` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `{dbname}`;

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}AuthAssignment`
--

DROP TABLE IF EXISTS `{tableprefix}AuthAssignment`;
CREATE TABLE IF NOT EXISTS `{tableprefix}AuthAssignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}AuthAssignment`
--

INSERT INTO `{tableprefix}AuthAssignment` (`item_name`, `user_id`, `created_at`) VALUES
('Admin', '2', 1427460723),
('User', '3', 1429685850);

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}AuthItem`
--

DROP TABLE IF EXISTS `{tableprefix}AuthItem`;
CREATE TABLE IF NOT EXISTS `{tableprefix}AuthItem` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}AuthItem`
--

INSERT INTO `{tableprefix}AuthItem` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/dashboard/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/debug/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/gii/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/mplugin/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/permission/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/plugin/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/site/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/site/error', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/site/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/admin/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/auth/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('Admin', 1, '管理员', NULL, NULL, 1427460654, 1427467637),
('User', 1, '普通用户', NULL, NULL, 1427461027, 1427467647);

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}AuthItemChild`
--

DROP TABLE IF EXISTS `{tableprefix}AuthItemChild`;
CREATE TABLE IF NOT EXISTS `{tableprefix}AuthItemChild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}AuthItemChild`
--

INSERT INTO `{tableprefix}AuthItemChild` (`parent`, `child`) VALUES
('Admin', '/*'),
('Admin', '/dashboard/*'),
('Admin', '/debug/*'),
('Admin', '/gii/*'),
('Admin', '/mplugin/*'),
('Admin', '/plugin/*'),
('Admin', '/rbac/*'),
('Admin', '/site/*'),
('Admin', '/user/*'),
('User', '/dashboard/*'),
('User', '/plugin/*'),
('User', '/site/*'),
('User', '/user/default/*');

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}AuthRule`
--

DROP TABLE IF EXISTS `{tableprefix}AuthRule`;
CREATE TABLE IF NOT EXISTS `{tableprefix}AuthRule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}s_config`
--

DROP TABLE IF EXISTS `{tableprefix}s_config`;
CREATE TABLE IF NOT EXISTS `{tableprefix}s_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cfg_name` varchar(128) NOT NULL DEFAULT '' COMMENT '配置名称',
  `cfg_value` text NOT NULL COMMENT '配置值',
  `cfg_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `cfg_pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `cfg_type` set('SYSTEM','USER','ROUTE') NOT NULL DEFAULT 'USER' COMMENT 'SYSTEM:系统配置,USER:用户配置',
  `cfg_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 0 不显示',
  `cfg_comment` varchar(255) DEFAULT NULL COMMENT '配置说明',
  PRIMARY KEY (`id`),
  KEY `cfg_name` (`cfg_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6099 ;

--
-- 转存表中的数据 `{tableprefix}s_config`
--

INSERT INTO `{tableprefix}s_config` (`id`, `cfg_name`, `cfg_value`, `cfg_order`, `cfg_pid`, `ctime`, `cfg_type`, `cfg_status`, `cfg_comment`) VALUES
(10, 'MAINMENU', '#', 501, 0, 0, 'USER', 1, '权限管理'),
(17, 'MAINMENU', '#', 500, 0, 0, 'USER', 1, '系统设置'),
(24, 'ICONS', '系统设置', 0, 0, 0, 'USER', 1, 'fa-cogs'),
(30, 'MAINMENU', '/dashboard/main', 0, 0, 0, 'USER', 1, '控制面板'),
(31, 'ICONS', '控制面板', 0, 0, 0, 'USER', 1, 'fa-dashboard'),
(145, 'SUBMENU', '/mplugin/local', 0, 17, 0, 'USER', 1, '插件管理'),
(147, 'THIRDMENU', '/mplugin/local/all', 0, 145, 0, 'USER', 1, '全部'),
(148, 'THIRDMENU', '/mplugin/local/setuped', 1, 145, 0, 'USER', 1, '已安装'),
(149, 'THIRDMENU', '/mplugin/local/new', 2, 145, 0, 'USER', 1, '未安装'),
(5811, 'SUBMENU', '/user/admin', 0, 17, 0, 'USER', 1, '管理员列表'),
(5875, 'SUBMENU', '/rbac/assignment', 0, 10, 0, 'USER', 1, '授权用户'),
(5877, 'SUBMENU', '/rbac/role', 0, 10, 0, 'USER', 1, '角色列表'),
(5878, 'ICONS', '权限管理', 0, 0, 0, 'USER', 1, 'fa-unlock-alt'),
(5879, 'SUBMENU', '/rbac/route', 0, 10, 0, 'USER', 1, '路由列表');

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}user`
--

DROP TABLE IF EXISTS `{tableprefix}user`;
CREATE TABLE IF NOT EXISTS `{tableprefix}user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对应AuthItem的name',
  `status` smallint(6) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `create_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `ban_time` timestamp NULL DEFAULT NULL,
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `{tableprefix}user_email` (`email`),
  UNIQUE KEY `{tableprefix}user_username` (`username`),
  KEY `{tableprefix}user_role_id` (`role`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `{tableprefix}user`
--

INSERT INTO `{tableprefix}user` (`id`, `role`, `status`, `email`, `new_email`, `username`, `password`, `auth_key`, `api_key`, `login_ip`, `login_time`, `create_ip`, `create_time`, `update_time`, `ban_time`, `ban_reason`) VALUES
(2, 'Admin', 1, 'admin@yetcms.com', NULL, 'admin', '$2y$13$n6XTxg7cSg./PM2aTkE2.OLysym7x4u1aLn8BBTXvxb/sAxek7IAC', 'rnJ08wbKZ09_l_InpAPvMrsJLkuvFogO', '3YyCNmSHJMh9vR_rDAJhK4z3_JXJ1lq6', '218.241.82.18', '2015-04-21 07:42:59', '127.0.0.1', '2015-03-24 22:58:37', '2015-03-26 06:25:23', NULL, NULL),
(3, 'User', 1, '41404756@qq.com', NULL, 'xiaoer', '$2y$13$GM/DioyucGc25pXQdC5vlO9mFDvqzs4Ke.NMg4T/gDCy3lO6BxJMO', NULL, NULL, '218.241.82.18', '2015-04-22 06:57:50', NULL, '2015-04-02 23:14:39', '2015-04-22 06:57:30', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}user_auth`
--

DROP TABLE IF EXISTS `{tableprefix}user_auth`;
CREATE TABLE IF NOT EXISTS `{tableprefix}user_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `{tableprefix}user_auth_provider_id` (`provider_id`),
  KEY `{tableprefix}user_auth_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}user_key`
--

DROP TABLE IF EXISTS `{tableprefix}user_key`;
CREATE TABLE IF NOT EXISTS `{tableprefix}user_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `consume_time` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `{tableprefix}user_key_key` (`key`),
  KEY `{tableprefix}user_key_user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `{tableprefix}user_key`
--

INSERT INTO `{tableprefix}user_key` (`id`, `user_id`, `type`, `key`, `create_time`, `consume_time`, `expire_time`) VALUES
(1, 2, 1, 'iWL22aiDnmXHG_OFVTpfVL5o0uW-6LbS', '2015-03-24 22:58:37', NULL, NULL),
(4, 2, 3, '-eU8QWIe57OOmJF7_yjnG3OJ7ohKKe_6', '2015-03-25 02:06:34', NULL, '2015-03-27 02:06:34');


DROP TABLE IF EXISTS `{tableprefix}profile`;
CREATE TABLE IF NOT EXISTS `{tableprefix}profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `{tableprefix}profile_user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

INSERT INTO `{tableprefix}profile` (`id`, `user_id`, `create_time`, `update_time`, `full_name`) VALUES
(2, 2, '2015-03-24 22:58:37', '2015-03-26 06:25:23', '熊川'),
(3, 3, '2015-04-02 23:14:39', '2015-04-22 06:57:30', 'xiaoer');
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
