-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-03-26 14:27:13
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
-- 表的结构 `{tableprefix}profile`
--

DROP TABLE IF EXISTS `{tableprefix}profile`;
CREATE TABLE IF NOT EXISTS `{tableprefix}profile` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `cfg_type` set('SYSTEM','USER') NOT NULL DEFAULT 'USER' COMMENT 'SYSTEM:系统配置,USER:用户配置',
  `cfg_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 0 不显示',
  `cfg_comment` varchar(255) DEFAULT NULL COMMENT '配置说明'
) ENGINE=InnoDB AUTO_INCREMENT=5844 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `{tableprefix}s_config`
--

INSERT INTO `{tableprefix}s_config` (`id`, `cfg_name`, `cfg_value`, `cfg_order`, `cfg_pid`, `ctime`, `cfg_type`, `cfg_status`, `cfg_comment`) VALUES
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
(5811, 'SUBMENU', '/user/admin', 0, 5810, 0, 'USER', 1, '用户列表');

-- --------------------------------------------------------

--
-- 表的结构 `{tableprefix}user`
--

DROP TABLE IF EXISTS `{tableprefix}user`;
CREATE TABLE IF NOT EXISTS `{tableprefix}user` (
`id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `{tableprefix}user`
--

INSERT INTO `{tableprefix}user` (`id`, `role_id`, `status`, `email`, `new_email`, `username`, `password`, `auth_key`, `api_key`, `login_ip`, `login_time`, `create_ip`, `create_time`, `update_time`, `ban_time`, `ban_reason`) VALUES
(2, 1, 1, 'admin@yetcms.com', NULL, 'admin', '$2y$13$n6XTxg7cSg./PM2aTkE2.OLysym7x4u1aLn8BBTXvxb/sAxek7IAC', 'rnJ08wbKZ09_l_InpAPvMrsJLkuvFogO', '3YyCNmSHJMh9vR_rDAJhK4z3_JXJ1lq6', '127.0.0.1', '2015-03-26 06:26:01', '127.0.0.1', '2015-03-24 22:58:37', '2015-03-26 06:25:23', NULL, NULL);

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
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `{tableprefix}user_email` (`email`), ADD UNIQUE KEY `{tableprefix}user_username` (`username`), ADD KEY `{tableprefix}user_role_id` (`role_id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `{tableprefix}role`
--
ALTER TABLE `{tableprefix}role`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `{tableprefix}s_config`
--
ALTER TABLE `{tableprefix}s_config`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5844;
--
-- AUTO_INCREMENT for table `{tableprefix}user`
--
ALTER TABLE `{tableprefix}user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
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
-- 限制表 `{tableprefix}profile`
--
ALTER TABLE `{tableprefix}profile`
ADD CONSTRAINT `{tableprefix}profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `{tableprefix}user` (`id`);

--
-- 限制表 `{tableprefix}user`
--
ALTER TABLE `{tableprefix}user`
ADD CONSTRAINT `{tableprefix}user_role_id` FOREIGN KEY (`role_id`) REFERENCES `{tableprefix}role` (`id`);

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
