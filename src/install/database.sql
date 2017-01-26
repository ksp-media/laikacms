CREATE TABLE `laikacms_assets_file` (
  `id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `filename` text NOT NULL,
  `filepath` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `filetype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `laikacms_assets_folder` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `laikacms_cache` (
  `id` int(11) NOT NULL,
  `key` varchar(250) NOT NULL,
  `data` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `laikacms_content` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `laikacms_page` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `slug` text COLLATE utf8_unicode_ci NOT NULL,
  `template` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `meta_tags` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `compiled_template` text COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  `showinnav` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `laikacms_page_object` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `laikacms_page_version` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` text COLLATE utf8_unicode_ci,
  `template` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `meta_title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_tags` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `compiled_template` text COLLATE utf8_unicode_ci,
  `parent` int(11) DEFAULT '0',
  `position` int(11) DEFAULT '0',
  `origin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `laikacms_plugins` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `systemkey` varchar(255) DEFAULT NULL,
  `repository` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `is_active` int(11) DEFAULT '0',
  `is_installed` int(11) DEFAULT '0',
  `group` varchar(255) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `laikacms_slug_table` (
  `id` int(11) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `base_str` varchar(200) NOT NULL,
  `base_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `laikacms_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `full_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `laikacms_user_role` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `label` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `laikacms_assets_file`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_assets_folder`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_cache`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_content`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_page`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_page_object`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_page_version`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_plugins`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_slug_table`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `laikacms_user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `laikacms_assets_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

ALTER TABLE `laikacms_assets_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `laikacms_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `laikacms_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `laikacms_page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

ALTER TABLE `laikacms_page_object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `laikacms_page_version`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

ALTER TABLE `laikacms_plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `laikacms_slug_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `laikacms_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `laikacms_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


INSERT INTO `laikacms_user_role` (`id`, `created_at`, `updated_at`, `label`) VALUES
(1, '2014-11-17 00:00:00', '2014-11-17 00:00:00', 'Administrator'),
(2, '2014-11-17 00:00:00', '2014-11-17 00:00:00', 'Editor'),
(3, '2014-11-17 00:00:00', '2014-11-17 00:00:00', 'Publisher');

INSERT INTO `laikacms_user` (`id`, `email`, `password`, `created_at`, `updated_at`, `full_name`, `user_role_id`) VALUES
(1, 'ks@kspmedia.de', '7dc23c28207cac9a630c5a3f4c5a318e', '2014-11-17 00:00:00', '2015-03-25 15:29:52', 'Administrator', 1);