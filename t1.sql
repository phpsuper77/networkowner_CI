-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2016 at 08:35 PM
-- Server version: 5.6.26
-- PHP Version: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `t1`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_conditions`
--

CREATE TABLE IF NOT EXISTS `additional_conditions` (
  `id` int(11) NOT NULL,
  `condition` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bundles`
--

CREATE TABLE IF NOT EXISTS `bundles` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `create_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : active, 1 : deleted, 2 :paused',
  `isdemo` tinyint(4) NOT NULL DEFAULT '0',
  `min_offerspot` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bundle_campaigns`
--

CREATE TABLE IF NOT EXISTS `bundle_campaigns` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bundle_categories`
--

CREATE TABLE IF NOT EXISTS `bundle_categories` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `cat_order` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bundle_offers`
--

CREATE TABLE IF NOT EXISTS `bundle_offers` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `isgroup` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : offer, 1: group',
  `isactive` int(11) NOT NULL DEFAULT '0' COMMENT '1 : active, 0 : non active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `lastdate` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : active, 1 : removed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `checkinstalled_method`
--

CREATE TABLE IF NOT EXISTS `checkinstalled_method` (
  `id` int(11) NOT NULL,
  `method_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `combos`
--

CREATE TABLE IF NOT EXISTS `combos` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL DEFAULT '0',
  `combo` varchar(512) NOT NULL,
  `session` int(11) NOT NULL COMMENT 'all session from start'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exiturl`
--

CREATE TABLE IF NOT EXISTS `exiturl` (
  `id` int(11) NOT NULL,
  `exiturl` varchar(512) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : active, 1 :removed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exiturl_campaigns`
--

CREATE TABLE IF NOT EXISTS `exiturl_campaigns` (
  `id` int(11) NOT NULL,
  `exiturl_id` int(11) NOT NULL DEFAULT '0',
  `proj_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `geo_block`
--

CREATE TABLE IF NOT EXISTS `geo_block` (
  `id` int(11) NOT NULL,
  `start_ip` int(10) unsigned NOT NULL,
  `end_ip` int(10) unsigned NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `geo_location`
--

CREATE TABLE IF NOT EXISTS `geo_location` (
  `id` int(11) NOT NULL,
  `country` varchar(16) NOT NULL,
  `region` varchar(32) NOT NULL,
  `city` varchar(64) NOT NULL,
  `postalcode` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `metrocode` int(11) NOT NULL,
  `areacode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `install_metrix_users`
--

CREATE TABLE IF NOT EXISTS `install_metrix_users` (
  `id` int(11) NOT NULL,
  `subid` int(11) NOT NULL,
  `network_id` int(11) NOT NULL DEFAULT '-1',
  `join_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisit_ip` varchar(16) NOT NULL,
  `lastvisit_country` varchar(3) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `user_pass` varchar(64) NOT NULL,
  `userpass_recovery` varchar(64) NOT NULL,
  `user_first_name` varchar(64) NOT NULL,
  `user_last_name` varchar(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_company_name` varchar(255) NOT NULL,
  `website` varchar(256) DEFAULT NULL,
  `user_phone` varchar(32) NOT NULL,
  `user_aim` varchar(256) DEFAULT NULL,
  `user_skype` varchar(256) DEFAULT NULL,
  `user_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = regular user; 1 = admin, -1 - banned, 2 - expert',
  `user_description` text NOT NULL,
  `user_system_status` int(11) NOT NULL DEFAULT '1' COMMENT '0 - banned; 1 - active; 2 - pending, 3 - removed',
  `user_revenue` double NOT NULL DEFAULT '0',
  `user_manager` int(11) DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `install_offers`
--

CREATE TABLE IF NOT EXISTS `install_offers` (
  `id` int(11) NOT NULL,
  `network_id` int(11) NOT NULL,
  `proj_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `install_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `os_typeid` int(11) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `download_id` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `pub_revenue` int(11) NOT NULL DEFAULT '0',
  `pm_revenue` int(11) NOT NULL DEFAULT '0',
  `am_revenue` int(11) NOT NULL DEFAULT '0',
  `offer_shown` int(11) NOT NULL DEFAULT '0',
  `install_accepted` int(11) NOT NULL DEFAULT '0',
  `install_started` int(11) NOT NULL DEFAULT '0',
  `install_completed` int(11) NOT NULL DEFAULT '0',
  `adjust_rate` int(11) NOT NULL DEFAULT '100',
  `combo_id` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `install_projects`
--

CREATE TABLE IF NOT EXISTS `install_projects` (
  `id` int(11) NOT NULL,
  `proj_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `install_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `open_session` int(11) NOT NULL DEFAULT '0',
  `install_accepted` int(11) NOT NULL DEFAULT '0',
  `install_started` int(11) NOT NULL DEFAULT '0',
  `install_completed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL,
  `country_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `location_all` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_setting`
--

CREATE TABLE IF NOT EXISTS `network_setting` (
  `id` int(11) NOT NULL,
  `field_name` varchar(256) NOT NULL,
  `field_value` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `network_id` int(11) NOT NULL DEFAULT '-1',
  `news_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `news_title` text NOT NULL,
  `news_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offergroups`
--

CREATE TABLE IF NOT EXISTS `offergroups` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `offergroup_datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : active, 1 : removed, 2 : Paused',
  `offer1_id` int(11) NOT NULL,
  `isdefault_1` int(11) NOT NULL,
  `offer2_id` int(11) NOT NULL,
  `isdefault_2` int(11) NOT NULL,
  `offer3_id` int(11) NOT NULL,
  `isdefault_3` int(11) NOT NULL,
  `offer4_id` int(11) NOT NULL,
  `isdefault_4` int(11) NOT NULL,
  `offer5_id` int(11) NOT NULL,
  `isdefault_5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL,
  `offer_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `offer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `offer_description` text COLLATE utf8_unicode_ci NOT NULL,
  `offer_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_main` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_main1` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check1_on` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check1_off` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check2_on` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check2_off` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check3_on` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check3_off` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check4_on` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check4_off` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check5_on` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_silent_check5_off` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_tos_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_pp_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_eula_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `offer_show` tinyint(1) NOT NULL DEFAULT '1',
  `offer_price` double DEFAULT '0',
  `reg_path_pre` text COLLATE utf8_unicode_ci NOT NULL,
  `reg_path_64_pre` text COLLATE utf8_unicode_ci NOT NULL,
  `reg_path_post` text COLLATE utf8_unicode_ci NOT NULL,
  `reg_path_64_post` text COLLATE utf8_unicode_ci NOT NULL,
  `checkinstalled_method` int(11) NOT NULL DEFAULT '0',
  `add_condition` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `adjust_rate` int(11) NOT NULL DEFAULT '100',
  `offer_cap` int(11) NOT NULL DEFAULT '1000000',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : active, 1 : removed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_categories`
--

CREATE TABLE IF NOT EXISTS `offer_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `isgroup` int(11) NOT NULL DEFAULT '0' COMMENT '0 : normal offer, 1 : offer group'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offer_prices_country`
--

CREATE TABLE IF NOT EXISTS `offer_prices_country` (
  `id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL COMMENT 'geo_location id, but should be<240, if it is 0,then it means default price',
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `os_type`
--

CREATE TABLE IF NOT EXISTS `os_type` (
  `id` int(11) NOT NULL,
  `os_name` varchar(128) NOT NULL,
  `os_additional` varchar(128) NOT NULL,
  `os_build` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL DEFAULT '0',
  `network_id` int(11) NOT NULL,
  `proj_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `proj_name` text COLLATE utf8_unicode_ci NOT NULL,
  `proj_description` text COLLATE utf8_unicode_ci NOT NULL,
  `proj_exe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proj_logo` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : active, 1 : removed',
  `software_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `software_version` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `software_description` text COLLATE utf8_unicode_ci NOT NULL,
  `software_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `software_silent` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `software_tos_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `software_pp_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `software_eula_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects_downloads`
--

CREATE TABLE IF NOT EXISTS `projects_downloads` (
  `id` int(11) NOT NULL,
  `proj_id` int(11) NOT NULL,
  `network_id` int(11) NOT NULL DEFAULT '-1',
  `download_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` int(10) unsigned NOT NULL,
  `location_id` int(11) NOT NULL,
  `download_lat` double NOT NULL,
  `download_lon` double NOT NULL,
  `webbrowser_id` int(11) NOT NULL,
  `os_typeid` int(11) NOT NULL,
  `refer_url_id` int(11) NOT NULL,
  `subid_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refer_url`
--

CREATE TABLE IF NOT EXISTS `refer_url` (
  `id` int(11) NOT NULL,
  `refer_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subid`
--

CREATE TABLE IF NOT EXISTS `subid` (
  `id` int(11) NOT NULL,
  `subid1` varchar(256) NOT NULL,
  `subid2` varchar(256) NOT NULL,
  `subid3` varchar(256) NOT NULL,
  `subid4` varchar(256) NOT NULL,
  `subid5` varchar(256) NOT NULL,
  `subid_all` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `summary_rpobc`
--

CREATE TABLE IF NOT EXISTS `summary_rpobc` (
  `id` int(11) NOT NULL,
  `combo_id` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `revenue` double NOT NULL,
  `c_date` date NOT NULL,
  `c_hour` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_constants`
--

CREATE TABLE IF NOT EXISTS `system_constants` (
  `id` int(11) NOT NULL,
  `const_name` text NOT NULL,
  `const_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `camp_description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : active, 1 : removed',
  `maintemplate_filepath` varchar(256) NOT NULL,
  `downloadtemplate_filepath` varchar(256) NOT NULL,
  `thanktemplate_filepath` varchar(256) NOT NULL,
  `img1` varchar(256) NOT NULL,
  `img2` varchar(256) NOT NULL,
  `img3` varchar(256) NOT NULL,
  `img4` varchar(256) NOT NULL,
  `img5` varchar(256) NOT NULL,
  `img6` varchar(256) NOT NULL,
  `img7` varchar(256) NOT NULL,
  `img8` varchar(256) NOT NULL,
  `img9` varchar(256) NOT NULL,
  `img10` varchar(256) NOT NULL,
  `img11` varchar(256) NOT NULL,
  `img12` varchar(256) NOT NULL,
  `img13` varchar(256) NOT NULL,
  `img14` varchar(256) NOT NULL,
  `img15` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `template_campaigns`
--

CREATE TABLE IF NOT EXISTS `template_campaigns` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `subid` int(11) NOT NULL,
  `network_id` int(11) NOT NULL DEFAULT '-1',
  `join_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisit_ip` varchar(16) NOT NULL,
  `lastvisit_country` varchar(3) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `user_pass` varchar(64) NOT NULL,
  `userpass_recovery` varchar(64) NOT NULL,
  `user_first_name` varchar(64) NOT NULL,
  `user_last_name` varchar(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_company_name` varchar(255) NOT NULL,
  `website` varchar(256) DEFAULT NULL,
  `user_phone` varchar(32) NOT NULL,
  `user_aim` varchar(256) DEFAULT NULL,
  `user_skype` varchar(256) DEFAULT NULL,
  `user_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = regular user; 1 = admin, -1 - banned, 2 : Advertiser, 3 : Publisher, 4 : Advertiser Manager, 5 : Publisher Manager, 6 : Accountant',
  `user_description` text NOT NULL,
  `user_system_status` int(11) NOT NULL DEFAULT '1' COMMENT '0 - banned; 1 - active; 2 - pending, 3 - removed',
  `user_revenue` double NOT NULL DEFAULT '0',
  `user_manager` int(11) DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_log`
--

CREATE TABLE IF NOT EXISTS `users_log` (
  `id` int(11) NOT NULL,
  `tryout_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tryout_ip` varchar(16) NOT NULL,
  `tryout_country` varchar(3) NOT NULL,
  `tryout_username` varchar(255) NOT NULL,
  `tryout_status` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_statuses`
--

CREATE TABLE IF NOT EXISTS `users_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `webbrowser`
--

CREATE TABLE IF NOT EXISTS `webbrowser` (
  `id` int(11) NOT NULL,
  `useragent` varchar(512) NOT NULL,
  `hash_agent` varchar(256) NOT NULL,
  `browser` varchar(128) NOT NULL,
  `browser_ver` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_conditions`
--
ALTER TABLE `additional_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bundles`
--
ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `bundle_campaigns`
--
ALTER TABLE `bundle_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_campid` (`camp_id`),
  ADD KEY `ix_bundleid_campid` (`bundle_id`,`camp_id`);

--
-- Indexes for table `bundle_categories`
--
ALTER TABLE `bundle_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_bundleid` (`bundle_id`);

--
-- Indexes for table `bundle_offers`
--
ALTER TABLE `bundle_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_bundleid_catid` (`bundle_id`,`cat_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkinstalled_method`
--
ALTER TABLE `checkinstalled_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combos`
--
ALTER TABLE `combos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `combo` (`combo`);

--
-- Indexes for table `exiturl`
--
ALTER TABLE `exiturl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exiturl_campaigns`
--
ALTER TABLE `exiturl_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geo_block`
--
ALTER TABLE `geo_block`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_geo` (`start_ip`,`end_ip`);

--
-- Indexes for table `geo_location`
--
ALTER TABLE `geo_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_country` (`country`);

--
-- Indexes for table `install_metrix_users`
--
ALTER TABLE `install_metrix_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `install_offers`
--
ALTER TABLE `install_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `download_id` (`download_id`),
  ADD KEY `ix_comboid_installdatetime` (`combo_id`,`install_datetime`),
  ADD KEY `idx_download_combo_id` (`download_id`,`combo_id`);

--
-- Indexes for table `install_projects`
--
ALTER TABLE `install_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `download_id` (`download_id`),
  ADD KEY `ix_installdatetime` (`install_datetime`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_all` (`location_all`),
  ADD KEY `location_country` (`country_code`,`country`),
  ADD KEY `location_whole` (`country_code`,`country`,`region`,`city`);

--
-- Indexes for table `network_setting`
--
ALTER TABLE `network_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offergroups`
--
ALTER TABLE `offergroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_offername` (`offer_name`);

--
-- Indexes for table `offer_categories`
--
ALTER TABLE `offer_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_categoryid` (`category_id`);

--
-- Indexes for table `offer_prices_country`
--
ALTER TABLE `offer_prices_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `os_type`
--
ALTER TABLE `os_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `os_index` (`os_name`,`os_additional`,`os_build`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_assigned_user_id` (`assigned_user_id`);

--
-- Indexes for table `projects_downloads`
--
ALTER TABLE `projects_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_projid_locationid_subidid` (`proj_id`,`location_id`,`subid_id`),
  ADD KEY `ix_downloaddatetime` (`download_datetime`);

--
-- Indexes for table `refer_url`
--
ALTER TABLE `refer_url`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referer_url` (`refer_url`(767));

--
-- Indexes for table `subid`
--
ALTER TABLE `subid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_subid_all` (`subid_all`(767));

--
-- Indexes for table `summary_rpobc`
--
ALTER TABLE `summary_rpobc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_combo_c_date` (`combo_id`,`c_date`);

--
-- Indexes for table `system_constants`
--
ALTER TABLE `system_constants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_campaigns`
--
ALTER TABLE `template_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_log`
--
ALTER TABLE `users_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_statuses`
--
ALTER TABLE `users_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webbrowser`
--
ALTER TABLE `webbrowser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hash_agent` (`hash_agent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_conditions`
--
ALTER TABLE `additional_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bundle_campaigns`
--
ALTER TABLE `bundle_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bundle_categories`
--
ALTER TABLE `bundle_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bundle_offers`
--
ALTER TABLE `bundle_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checkinstalled_method`
--
ALTER TABLE `checkinstalled_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `combos`
--
ALTER TABLE `combos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exiturl`
--
ALTER TABLE `exiturl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exiturl_campaigns`
--
ALTER TABLE `exiturl_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `geo_block`
--
ALTER TABLE `geo_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `geo_location`
--
ALTER TABLE `geo_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `install_metrix_users`
--
ALTER TABLE `install_metrix_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `install_offers`
--
ALTER TABLE `install_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `install_projects`
--
ALTER TABLE `install_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `network_setting`
--
ALTER TABLE `network_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offergroups`
--
ALTER TABLE `offergroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offer_categories`
--
ALTER TABLE `offer_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offer_prices_country`
--
ALTER TABLE `offer_prices_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `os_type`
--
ALTER TABLE `os_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projects_downloads`
--
ALTER TABLE `projects_downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `refer_url`
--
ALTER TABLE `refer_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subid`
--
ALTER TABLE `subid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `summary_rpobc`
--
ALTER TABLE `summary_rpobc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `system_constants`
--
ALTER TABLE `system_constants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `template_campaigns`
--
ALTER TABLE `template_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_log`
--
ALTER TABLE `users_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_statuses`
--
ALTER TABLE `users_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `webbrowser`
--
ALTER TABLE `webbrowser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
