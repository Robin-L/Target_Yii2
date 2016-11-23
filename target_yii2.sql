/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 100113
Source Host           : 127.0.0.1:3306
Source Database       : target_yii2

Target Server Type    : MYSQL
Target Server Version : 100113
File Encoding         : 65001

Date: 2016-11-23 19:57:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for auth
-- ----------------------------
DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `source` varchar(255) NOT NULL,
  `source_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_auth_id_user_id` (`user_id`),
  CONSTRAINT `fk_auth_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth
-- ----------------------------

-- ----------------------------
-- Table structure for carousel_settings
-- ----------------------------
DROP TABLE IF EXISTS `carousel_settings`;
CREATE TABLE `carousel_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carousel_name` varchar(45) NOT NULL,
  `image_height` varchar(45) NOT NULL,
  `image_width` varchar(45) NOT NULL,
  `carousel_autoplay` tinyint(1) NOT NULL DEFAULT '1',
  `show_indicators` tinyint(1) NOT NULL DEFAULT '1',
  `show_caption_title` tinyint(1) NOT NULL DEFAULT '1',
  `show_captions` tinyint(1) NOT NULL DEFAULT '1',
  `show_caption_background` tinyint(1) NOT NULL DEFAULT '1',
  `caption_font_size` varchar(45) NOT NULL,
  `show_controls` tinyint(1) NOT NULL DEFAULT '1',
  `status_id` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_carousel_settings_status1_idx` (`status_id`),
  CONSTRAINT `fk_carousel_settings_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of carousel_settings
-- ----------------------------

-- ----------------------------
-- Table structure for country
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `code` char(2) NOT NULL,
  `name` char(52) NOT NULL,
  `population` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='国家';

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('AU', 'Australia', '18886000');
INSERT INTO `country` VALUES ('BR', 'Brazil', '170115000');
INSERT INTO `country` VALUES ('CA', 'Canada', '1147000');
INSERT INTO `country` VALUES ('CN', 'China', '1277558000');
INSERT INTO `country` VALUES ('DE', 'Germany', '82164700');
INSERT INTO `country` VALUES ('FR', 'France', '59225700');
INSERT INTO `country` VALUES ('GB', 'United Kingdom', '59623400');
INSERT INTO `country` VALUES ('IN', 'India', '1013662000');
INSERT INTO `country` VALUES ('RU', 'Russia', '146934000');
INSERT INTO `country` VALUES ('US', 'United States', '278357000');

-- ----------------------------
-- Table structure for faq
-- ----------------------------
DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faq_question` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `faq_answer` varchar(1055) NOT NULL,
  `faq_category_id` int(11) DEFAULT NULL,
  `faq_is_featured` tinyint(1) DEFAULT '0',
  `faq_weight` int(11) DEFAULT '100',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of faq
-- ----------------------------
INSERT INTO `faq` VALUES ('1', 'What is happened?', '', 'This is a test question', '1', '1', '100', '2', '2', '2016-11-21 09:30:34', '2016-11-21 09:30:34');
INSERT INTO `faq` VALUES ('2', 'This is a question two.', '', 'This is a question two.You know what happened? But I don\'t want to know it.', '2', '1', '100', '2', '2', '2016-11-21 12:08:45', '2016-11-21 12:08:45');
INSERT INTO `faq` VALUES ('3', 'This is a question three.', '', 'This is a question three.You know what happened? But I don\'t want to know it.', '1', '1', '100', '2', '2', '2016-11-21 12:09:14', '2016-11-21 12:09:18');
INSERT INTO `faq` VALUES ('4', 'This is a question four.', '', 'This is a question four.You know what happened? But I don\'t want to know it.', '2', '1', '100', '2', '2', '2016-11-21 12:09:58', '2016-11-21 12:09:59');
INSERT INTO `faq` VALUES ('5', 'Do Slugs work?', 'do-slugs-work', 'maybe', '1', '1', '99', '2', '2', '2016-11-21 15:57:08', '2016-11-21 15:57:08');

-- ----------------------------
-- Table structure for faq_category
-- ----------------------------
DROP TABLE IF EXISTS `faq_category`;
CREATE TABLE `faq_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faq_category_name` varchar(45) NOT NULL,
  `faq_category_weight` int(11) DEFAULT '100',
  `faq_category_is_featured` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of faq_category
-- ----------------------------
INSERT INTO `faq_category` VALUES ('1', 'Speak', '20', '1');
INSERT INTO `faq_category` VALUES ('2', 'General', '100', '1');

-- ----------------------------
-- Table structure for faq_rating
-- ----------------------------
DROP TABLE IF EXISTS `faq_rating`;
CREATE TABLE `faq_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `faq_id` int(11) NOT NULL,
  `faq_rating` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of faq_rating
-- ----------------------------

-- ----------------------------
-- Table structure for gender
-- ----------------------------
DROP TABLE IF EXISTS `gender`;
CREATE TABLE `gender` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gender
-- ----------------------------
INSERT INTO `gender` VALUES ('1', 'male');
INSERT INTO `gender` VALUES ('2', 'female');

-- ----------------------------
-- Table structure for marketing_image
-- ----------------------------
DROP TABLE IF EXISTS `marketing_image`;
CREATE TABLE `marketing_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `marketing_image_path` varchar(45) NOT NULL,
  `marketing_image_name` varchar(45) NOT NULL,
  `marketing_image_caption` varchar(100) DEFAULT NULL,
  `marketing_image_caption_title` varchar(100) DEFAULT NULL,
  `marketing_thumb_path` varchar(45) NOT NULL,
  `marketing_image_is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `marketing_image_is_active` tinyint(1) NOT NULL DEFAULT '0',
  `marketing_image_weight` int(11) NOT NULL DEFAULT '100',
  `status_id` smallint(6) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_marketing_image_status1_idx` (`status_id`),
  CONSTRAINT `fk_marketing_image_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of marketing_image
-- ----------------------------
INSERT INTO `marketing_image` VALUES ('1', 'uploads/Test.png', 'Test', '这是一张测试图片', '这是一张测试图片', 'uploads/thumbnail/Testthumb.png', '1', '1', '100', '1', '2016-11-23 15:05:19', '2016-11-23 15:05:19');
INSERT INTO `marketing_image` VALUES ('2', 'uploads/carousel_1.jpg', 'carousel_1', '这是一张测试图片carousel', '这是一张测试图片', 'uploads/thumbnail/carousel_1thumb.jpg', '1', '0', '100', '1', '2016-11-23 16:02:50', '2016-11-23 16:02:50');

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1479276070');
INSERT INTO `migration` VALUES ('m130524_201442_init', '1479276081');

-- ----------------------------
-- Table structure for profile
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `first_name` text,
  `last_name` text,
  `birthdate` date DEFAULT NULL,
  `gender_id` smallint(6) unsigned NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES ('1', '1', 'Lai', 'Rongbin', '2016-11-17', '1', '1479364234', '1479364234');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) NOT NULL,
  `role_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', 'user', '10');
INSERT INTO `role` VALUES ('2', 'admin', '20');
INSERT INTO `role` VALUES ('3', 'SuperUser', '30');

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) NOT NULL,
  `status_value` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES ('1', 'Active', '10');
INSERT INTO `status` VALUES ('2', 'Pending', '5');

-- ----------------------------
-- Table structure for status_message
-- ----------------------------
DROP TABLE IF EXISTS `status_message`;
CREATE TABLE `status_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(105) NOT NULL,
  `action_name` varchar(105) NOT NULL,
  `status_message_name` varchar(105) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` varchar(2025) NOT NULL,
  `status_message_description` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of status_message
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type_id` smallint(6) NOT NULL DEFAULT '1' COMMENT '用户类型ID',
  `role_id` smallint(6) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `status_id` smallint(6) NOT NULL DEFAULT '1' COMMENT '状态ID',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'lairb', 'hBYWl6wNGvyCvyCVD0WI-LA9trmGmm_7', '$2y$13$KQPGr92sBNoIlLWReR7V0OemhXZn84R44coiyDwex0bjJB2Uj.qLW', null, '18650808342@sina.cn', '1', '1', '1', '1479353618', '1479353618');
INSERT INTO `user` VALUES ('2', 'admin', 'sF4yF-iv3wY1GjBpqfy_4rGFfPmRGrv8', '$2y$13$VlxcLgtx8TGUduGHK0wwVOkM15TQ7yajcxO5yOG3jtei2PbecyRzi', null, 'pluske@163.com', '1', '2', '1', '1479375468', '1479375468');
INSERT INTO `user` VALUES ('3', 'super_admin', 'F57td66TVPxD82E3mp7rGWdwoYW0SyZ3', '$2y$13$9GA7JZ1OzSFZ1UvLvNKa0eP8S3AtvoeqcEhbpE4vcAUIOyGxkt206', null, 'admin@weektrip.cn', '1', '3', '1', '1479377299', '1479377328');
INSERT INTO `user` VALUES ('4', 'email', 'QQiJ01ssNIWnPfhwABnfGN5scv2mnlGR', '$2y$13$NTVk4X.m1NwrIaQMQfSGMO7X6SPxvPtBnHPrPaBg7j3gmSoxiM1KK', null, 'email@weektrip.cn', '1', '1', '1', '1479456205', '1479456205');

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(45) NOT NULL,
  `user_type_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_type
-- ----------------------------
INSERT INTO `user_type` VALUES ('1', 'Free', '10');
INSERT INTO `user_type` VALUES ('2', 'Paid', '30');
