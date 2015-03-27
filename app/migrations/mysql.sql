-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-03-27 17:36:17
-- 服务器版本： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `{dbname}`
--

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}AuthAssignment`
--

DROP TABLE IF EXISTS `{tableprefix}AuthAssignment`;
CREATE TABLE IF NOT EXISTS `{tableprefix}AuthAssignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}AuthAssignment`
--

INSERT INTO `{tableprefix}AuthAssignment` (`item_name`, `user_id`, `created_at`) VALUES
('Admin', '2', 1427460723);

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
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}AuthItem`
--

INSERT INTO `{tableprefix}AuthItem` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/dashboard/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/dashboard/main', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/debug/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/debug/default/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/debug/default/download-mail', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/debug/default/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/debug/default/toolbar', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/debug/default/view', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/gii/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/gii/default/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/gii/default/action', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/gii/default/diff', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/gii/default/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/gii/default/preview', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/gii/default/view', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/mplugin/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/mplugin/ajax', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/mplugin/download-plugin', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/mplugin/get-plugin', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/mplugin/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/mplugin/local', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/mplugin/shop', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/permission/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/permission/list', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/permission/role', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/plugin/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/assignment/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/assignment/assign', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/assignment/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/assignment/role-search', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/assignment/view', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/permission/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/permission/assign', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/permission/create', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/permission/delete', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/permission/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/permission/role-search', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/permission/update', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/permission/view', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/role/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/role/assign', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/role/create', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/role/delete', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/role/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/role/role-search', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/role/update', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/role/view', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/route/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/route/assign', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/route/create', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/route/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/route/route-search', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/rule/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/rule/create', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/rule/delete', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/rule/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/rule/update', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/rbac/rule/view', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/site/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/site/error', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/site/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/admin/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/admin/create', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/admin/delete', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/admin/index', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/admin/update', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/admin/view', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/auth/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/auth/connect', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/auth/login', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/*', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/account', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/cancel', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/confirm', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/forgot', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/login', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/logout', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/profile', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/register', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/resend', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/resend-change', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('/user/default/reset', 2, NULL, NULL, NULL, 1427460519, 1427460519),
('Admin', 1, '管理员', NULL, NULL, 1427460654, 1427467637),
('User', 1, '普通用户', NULL, NULL, 1427461027, 1427467647);

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}AuthItemChild`
--

DROP TABLE IF EXISTS `{tableprefix}AuthItemChild`;
CREATE TABLE IF NOT EXISTS `{tableprefix}AuthItemChild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}AuthItemChild`
--

INSERT INTO `{tableprefix}AuthItemChild` (`parent`, `child`) VALUES
('Admin', '/*'),
('Admin', '/dashboard/*'),
('User', '/dashboard/*'),
('Admin', '/debug/*'),
('Admin', '/gii/*'),
('Admin', '/mplugin/*'),
('Admin', '/plugin/*'),
('User', '/plugin/*'),
('Admin', '/rbac/*'),
('Admin', '/site/*'),
('User', '/site/*'),
('Admin', '/user/*'),
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
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}profile`
--

DROP TABLE IF EXISTS `{tableprefix}profile`;
CREATE TABLE IF NOT EXISTS `{tableprefix}profile` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}profile`
--

INSERT INTO `{tableprefix}profile` (`id`, `user_id`, `create_time`, `update_time`, `full_name`) VALUES
(2, 2, '2015-03-24 22:58:37', '2015-03-26 06:25:23', '熊川');

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}role`
--

DROP TABLE IF EXISTS `{tableprefix}role`;
CREATE TABLE IF NOT EXISTS `{tableprefix}role` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}role`
--

INSERT INTO `{tableprefix}role` (`id`, `name`, `create_time`, `update_time`, `can_admin`) VALUES
(1, 'Admin', '2015-03-25 05:14:25', NULL, 1),
(2, 'User', '2015-03-25 05:14:25', NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}s_config`
--

DROP TABLE IF EXISTS `{tableprefix}s_config`;
CREATE TABLE IF NOT EXISTS `{tableprefix}s_config` (
`id` int(11) unsigned NOT NULL,
  `cfg_name` varchar(128) NOT NULL DEFAULT '' COMMENT '配置名称',
  `cfg_value` text NOT NULL COMMENT '配置值',
  `cfg_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `cfg_pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `cfg_type` set('SYSTEM','USER','ROUTE') NOT NULL DEFAULT 'USER' COMMENT 'SYSTEM:系统配置,USER:用户配置',
  `cfg_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 0 不显示',
  `cfg_comment` varchar(255) DEFAULT NULL COMMENT '配置说明'
) ENGINE=InnoDB AUTO_INCREMENT=5880 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `{tableprefix}s_config`
--

INSERT INTO `{tableprefix}s_config` (`id`, `cfg_name`, `cfg_value`, `cfg_order`, `cfg_pid`, `ctime`, `cfg_type`, `cfg_status`, `cfg_comment`) VALUES
(10, 'MAINMENU', '#', 501, 0, 0, 'USER', 1, '权限管理'),
(17, 'MAINMENU', '#', 500, 0, 0, 'USER', 1, '系统设置'),
(24, 'ICONS', '系统设置', 0, 0, 0, 'USER', 1, 'fa-cogs'),
(28, 'ICONS', '用户管理', 0, 0, 0, 'USER', 1, 'fa-users'),
(30, 'MAINMENU', '/dashboard/main', 0, 0, 0, 'USER', 1, '控制面板'),
(31, 'ICONS', '控制面板', 0, 0, 0, 'USER', 1, 'fa-dashboard'),
(145, 'SUBMENU', '/mplugin/local', 0, 17, 0, 'USER', 1, '插件管理'),
(147, 'THIRDMENU', '/mplugin/local/all', 0, 145, 0, 'USER', 1, '全部'),
(148, 'THIRDMENU', '/mplugin/local/setuped', 1, 145, 0, 'USER', 1, '已安装'),
(149, 'THIRDMENU', '/mplugin/local/new', 2, 145, 0, 'USER', 1, '未安装'),
(5810, 'MAINMENU', '#', 505, 0, 0, 'USER', 1, '用户管理'),
(5811, 'SUBMENU', '/user/admin', 0, 5810, 0, 'USER', 1, '用户列表'),
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
`id` int(11) NOT NULL,
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
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}user`
--

INSERT INTO `{tableprefix}user` (`id`, `role`, `status`, `email`, `new_email`, `username`, `password`, `auth_key`, `api_key`, `login_ip`, `login_time`, `create_ip`, `create_time`, `update_time`, `ban_time`, `ban_reason`) VALUES
(2, 'Admin', 1, 'admin@yetcms.com', NULL, 'admin', '$2y$13$n6XTxg7cSg./PM2aTkE2.OLysym7x4u1aLn8BBTXvxb/sAxek7IAC', 'rnJ08wbKZ09_l_InpAPvMrsJLkuvFogO', '3YyCNmSHJMh9vR_rDAJhK4z3_JXJ1lq6', '127.0.0.1', '2015-03-27 09:33:14', '127.0.0.1', '2015-03-24 22:58:37', '2015-03-26 06:25:23', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}user_auth`
--

DROP TABLE IF EXISTS `{tableprefix}user_auth`;
CREATE TABLE IF NOT EXISTS `{tableprefix}user_auth` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}user_key`
--

DROP TABLE IF EXISTS `{tableprefix}user_key`;
CREATE TABLE IF NOT EXISTS `{tableprefix}user_key` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `consume_time` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}user_key`
--

INSERT INTO `{tableprefix}user_key` (`id`, `user_id`, `type`, `key`, `create_time`, `consume_time`, `expire_time`) VALUES
(1, 2, 1, 'iWL22aiDnmXHG_OFVTpfVL5o0uW-6LbS', '2015-03-24 22:58:37', NULL, NULL),
(4, 2, 3, '-eU8QWIe57OOmJF7_yjnG3OJ7ohKKe_6', '2015-03-25 02:06:34', NULL, '2015-03-27 02:06:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `{tableprefix}AuthAssignment`
--
ALTER TABLE `{tableprefix}AuthAssignment`
 ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `{tableprefix}AuthItem`
--
ALTER TABLE `{tableprefix}AuthItem`
 ADD PRIMARY KEY (`name`), ADD KEY `rule_name` (`rule_name`), ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `{tableprefix}AuthItemChild`
--
ALTER TABLE `{tableprefix}AuthItemChild`
 ADD PRIMARY KEY (`parent`,`child`), ADD KEY `child` (`child`);

--
-- Indexes for table `{tableprefix}AuthRule`
--
ALTER TABLE `{tableprefix}AuthRule`
 ADD PRIMARY KEY (`name`);

--
-- Indexes for table `{tableprefix}profile`
--
ALTER TABLE `{tableprefix}profile`
 ADD PRIMARY KEY (`id`), ADD KEY `{tableprefix}profile_user_id` (`user_id`);

--
-- Indexes for table `{tableprefix}role`
--
ALTER TABLE `{tableprefix}role`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{tableprefix}s_config`
--
ALTER TABLE `{tableprefix}s_config`
 ADD PRIMARY KEY (`id`), ADD KEY `cfg_name` (`cfg_name`);

--
-- Indexes for table `{tableprefix}user`
--
ALTER TABLE `{tableprefix}user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `{tableprefix}user_email` (`email`), ADD UNIQUE KEY `{tableprefix}user_username` (`username`), ADD KEY `{tableprefix}user_role_id` (`role`);

--
-- Indexes for table `{tableprefix}user_auth`
--
ALTER TABLE `{tableprefix}user_auth`
 ADD PRIMARY KEY (`id`), ADD KEY `{tableprefix}user_auth_provider_id` (`provider_id`), ADD KEY `{tableprefix}user_auth_user_id` (`user_id`);

--
-- Indexes for table `{tableprefix}user_key`
--
ALTER TABLE `{tableprefix}user_key`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `{tableprefix}user_key_key` (`key`), ADD KEY `{tableprefix}user_key_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `{tableprefix}profile`
--
ALTER TABLE `{tableprefix}profile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `{tableprefix}role`
--
ALTER TABLE `{tableprefix}role`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `{tableprefix}s_config`
--
ALTER TABLE `{tableprefix}s_config`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5880;
--
-- AUTO_INCREMENT for table `{tableprefix}user`
--
ALTER TABLE `{tableprefix}user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `{tableprefix}user_auth`
--
ALTER TABLE `{tableprefix}user_auth`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `{tableprefix}user_key`
--
ALTER TABLE `{tableprefix}user_key`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- 限制导出的表
--

--
-- 限制表 `{tableprefix}AuthAssignment`
--
ALTER TABLE `{tableprefix}AuthAssignment`
ADD CONSTRAINT `{tableprefix}authassignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `{tableprefix}AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `{tableprefix}AuthItem`
--
ALTER TABLE `{tableprefix}AuthItem`
ADD CONSTRAINT `{tableprefix}authitem_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `{tableprefix}AuthRule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `{tableprefix}AuthItemChild`
--
ALTER TABLE `{tableprefix}AuthItemChild`
ADD CONSTRAINT `{tableprefix}authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `{tableprefix}AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `{tableprefix}authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `{tableprefix}AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `{tableprefix}profile`
--
ALTER TABLE `{tableprefix}profile`
ADD CONSTRAINT `{tableprefix}profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `{tableprefix}user` (`id`);

--
-- 限制表 `{tableprefix}user_auth`
--
ALTER TABLE `{tableprefix}user_auth`
ADD CONSTRAINT `{tableprefix}user_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `{tableprefix}user` (`id`);

--
-- 限制表 `{tableprefix}user_key`
--
ALTER TABLE `{tableprefix}user_key`
ADD CONSTRAINT `{tableprefix}user_key_user_id` FOREIGN KEY (`user_id`) REFERENCES `{tableprefix}user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
