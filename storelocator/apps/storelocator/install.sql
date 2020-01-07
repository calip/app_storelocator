
--
-- Table structure for table `app_storelocator_items`
--

CREATE TABLE IF NOT EXISTS `app_storelocator_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'untitled',
  `virtual_filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'untitled',
  `store` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pobox` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(253) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(18,15) DEFAULT NULL,
  `longitude` decimal(18,15) DEFAULT NULL,
  `map_zoom` tinyint(2) DEFAULT NULL,
  `display_map` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_available` datetime DEFAULT NULL,
  `date_expiry` datetime DEFAULT NULL,
  `created_by_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `modified_by_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `permission_write` text COLLATE utf8_unicode_ci,
  `permission_read` text COLLATE utf8_unicode_ci,
  `meta_key` text COLLATE utf8_unicode_ci,
  `meta_description` mediumtext COLLATE utf8mb4_unicode_ci,
  `pageview` bigint(20) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `version` decimal(20,2) NOT NULL DEFAULT '1.00',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `options` text COLLATE utf8_unicode_ci,
  `tags` text COLLATE utf8_unicode_ci,

  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `virtual_filename` (`virtual_filename`),
  KEY `date_created` (`date_created`),
  KEY `date_modified` (`date_modified`),
  KEY `created_by_id` (`created_by_id`),
  KEY `modified_by_id` (`modified_by_id`),
  KEY `status` (`status`),
  KEY `sort_order` (`sort_order`),
  UNIQUE KEY `guid` (`guid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

 
