-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: quantumd_dev
-- ------------------------------------------------------
-- Server version	5.7.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `quantumd_dev`;
USE `quantumd_dev`;

--
-- Table structure for table `activation_code`
--

DROP TABLE IF EXISTS `activation_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activation_code` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `code` varchar(32) NOT NULL,
  `sent` tinyint(1) NOT NULL,
  `resend_requests` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activation_code`
--

/*!40000 ALTER TABLE `activation_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `activation_code` ENABLE KEYS */;

--
-- Table structure for table `address_email`
--

DROP TABLE IF EXISTS `address_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address_email` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_email` (`address`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address_email`
--

/*!40000 ALTER TABLE `address_email` DISABLE KEYS */;
/*!40000 ALTER TABLE `address_email` ENABLE KEYS */;

--
-- Table structure for table `banned`
--

DROP TABLE IF EXISTS `banned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banned` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `action_by` varchar(42) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reason` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk_banned_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banned`
--

/*!40000 ALTER TABLE `banned` DISABLE KEYS */;
/*!40000 ALTER TABLE `banned` ENABLE KEYS */;

--
-- Table structure for table `brute_defense`
--

DROP TABLE IF EXISTS `brute_defense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brute_defense` (
  `id` varchar(40) NOT NULL,
  `time_added` int(11) NOT NULL,
  KEY `time_added` (`time_added`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brute_defense`
--

/*!40000 ALTER TABLE `brute_defense` DISABLE KEYS */;
/*!40000 ALTER TABLE `brute_defense` ENABLE KEYS */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'art','art',1,'2018-10-30 11:44:59','2018-10-30 11:44:59');
INSERT INTO `category` VALUES (2,'music','music',1,'2018-10-30 11:45:34','2018-10-30 11:45:34');
INSERT INTO `category` VALUES (3,'games','games',1,'2018-10-30 11:45:34','2018-10-30 11:45:34');
INSERT INTO `category` VALUES (4,'sports','sports',1,'2018-10-30 11:45:34','2018-10-30 11:45:34');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

--
-- Table structure for table `category_tag`
--

DROP TABLE IF EXISTS `category_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_tag` (
  `category_id` bigint(20) NOT NULL,
  `tag_id` bigint(20) NOT NULL,
  PRIMARY KEY (`category_id`,`tag_id`),
  KEY `fk_category_tag_tag_id` (`tag_id`),
  CONSTRAINT `fk_category_tag_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_category_tag_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_tag`
--

/*!40000 ALTER TABLE `category_tag` DISABLE KEYS */;
INSERT INTO `category_tag` VALUES (1,1);
INSERT INTO `category_tag` VALUES (1,2);
INSERT INTO `category_tag` VALUES (2,3);
INSERT INTO `category_tag` VALUES (2,4);
INSERT INTO `category_tag` VALUES (3,5);
INSERT INTO `category_tag` VALUES (3,6);
INSERT INTO `category_tag` VALUES (4,7);
INSERT INTO `category_tag` VALUES (4,8);
/*!40000 ALTER TABLE `category_tag` ENABLE KEYS */;

--
-- Table structure for table `conference_session`
--

DROP TABLE IF EXISTS `conference_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conference_session` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ref` varchar(14) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `room_id` varchar(10) NOT NULL,
  `fee` int(11) NOT NULL COMMENT 'cents',
  `fee_wei` bigint(20) NOT NULL DEFAULT '0' COMMENT 'wei',
  `eth_usd` float NOT NULL DEFAULT '0' COMMENT 'conversion rate',
  `date_added` datetime NOT NULL,
  `is_open` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ref` (`ref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference_session`
--

/*!40000 ALTER TABLE `conference_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `conference_session` ENABLE KEYS */;

--
-- Table structure for table `conference_session_participants`
--

DROP TABLE IF EXISTS `conference_session_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conference_session_participants` (
  `conference_session_ref` varchar(14) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_address` varchar(50) DEFAULT NULL,
  `in_session` tinyint(4) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`conference_session_ref`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference_session_participants`
--

/*!40000 ALTER TABLE `conference_session_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `conference_session_participants` ENABLE KEYS */;

--
-- Table structure for table `conference_session_user`
--

DROP TABLE IF EXISTS `conference_session_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conference_session_user` (
  `conference_session_id` varchar(14) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `is_kp` tinyint(1) DEFAULT '0',
  `data_start` datetime DEFAULT NULL,
  `data_end` datetime DEFAULT NULL,
  `duration` bigint(20) DEFAULT NULL,
  `cost_eth` bigint(20) DEFAULT '0' COMMENT 'wei',
  `cost_usd` float DEFAULT '0' COMMENT 'dollar',
  PRIMARY KEY (`conference_session_id`,`user_id`),
  KEY `fk_conference_session_user_user_id` (`user_id`),
  CONSTRAINT `fk_conference_session_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference_session_user`
--

/*!40000 ALTER TABLE `conference_session_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `conference_session_user` ENABLE KEYS */;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `key` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES ('api.keys.payment_pool','s:4:\"1234\";');
INSERT INTO `config` VALUES ('api.secrets.invite','s:15:\"xxxyyywegewgewg\";');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;

--
-- Table structure for table `crowdfund`
--

DROP TABLE IF EXISTS `crowdfund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crowdfund` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `address` varchar(50) CHARACTER SET utf8 NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 = usd, 2 = eth, 3 = btc',
  `amount` decimal(25,8) NOT NULL,
  `usd_amount` int(11) NOT NULL COMMENT 'cents',
  `tokens` int(11) NOT NULL,
  `confirmed` int(11) NOT NULL,
  `props` text CHARACTER SET utf8,
  `date_added` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usd_amount` (`usd_amount`,`confirmed`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crowdfund`
--

/*!40000 ALTER TABLE `crowdfund` DISABLE KEYS */;
/*!40000 ALTER TABLE `crowdfund` ENABLE KEYS */;

--
-- Table structure for table `crypto_price`
--

DROP TABLE IF EXISTS `crypto_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crypto_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '2 = ETH, 3 = BTC',
  `usd_price` double(15,8) NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crypto_price`
--

/*!40000 ALTER TABLE `crypto_price` DISABLE KEYS */;
INSERT INTO `crypto_price` VALUES (1,1,674.74000000,'2018-05-18 07:29:23');
INSERT INTO `crypto_price` VALUES (2,2,8099.23000000,'2018-05-18 07:29:24');
/*!40000 ALTER TABLE `crypto_price` ENABLE KEYS */;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `object` varchar(25) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `data` text,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`action`),
  KEY `object` (`object`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;

--
-- Table structure for table `meta_info`
--

DROP TABLE IF EXISTS `meta_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meta_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `props` text,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meta_info`
--

/*!40000 ALTER TABLE `meta_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `meta_info` ENABLE KEYS */;

--
-- Table structure for table `moderation`
--

DROP TABLE IF EXISTS `moderation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moderation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `action_by` varchar(42) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `moderation_user_id_fk` (`user_id`),
  CONSTRAINT `moderation_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moderation`
--

/*!40000 ALTER TABLE `moderation` DISABLE KEYS */;
/*!40000 ALTER TABLE `moderation` ENABLE KEYS */;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1 = update, 2 = crowdsource',
  `url_slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` varchar(255) DEFAULT NULL,
  `body` text,
  `position` int(11) NOT NULL,
  `date` date NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_published` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`,`url_slug`),
  KEY `position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` int(11) DEFAULT '1' COMMENT '1: one to one with a user from contact list; 2: group; 3: video session',
  `encrypted` int(11) DEFAULT '0' COMMENT '0: no; 1: yes',
  `date_added` datetime NOT NULL,
  `description` text,
  `discoverable` tinyint(4) DEFAULT '0' COMMENT 'for private groups, 0 - not discoverable 1- discoverable',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

/*!40000 ALTER TABLE `room` DISABLE KEYS */;
/*!40000 ALTER TABLE `room` ENABLE KEYS */;

--
-- Table structure for table `room_category_tag`
--

DROP TABLE IF EXISTS `room_category_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_category_tag` (
  `room_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `tag_id` bigint(20) NOT NULL,
  PRIMARY KEY (`room_id`,`category_id`,`tag_id`),
  KEY `fk_room_category_tag_category_id` (`category_id`),
  KEY `fk_room_category_tag_tag_id` (`tag_id`),
  CONSTRAINT `fk_room_category_tag_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_room_category_tag_room_id` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_room_category_tag_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_category_tag`
--

/*!40000 ALTER TABLE `room_category_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_category_tag` ENABLE KEYS */;

--
-- Table structure for table `room_keys`
--

DROP TABLE IF EXISTS `room_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_keys` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `room_id`  bigint(20) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `key` text,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_room_keys_user_id` (`user_id`),
  KEY `room_keys_room_id_fk` (`room_id`),
  CONSTRAINT `fk_room_keys_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `room_keys_room_id_fk` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_keys`
--

/*!40000 ALTER TABLE `room_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_keys` ENABLE KEYS */;

--
-- Table structure for table `room_message`
--

DROP TABLE IF EXISTS `room_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `room_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `message` text,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_message_date_added_index` (`date_added`),
  KEY `fk_room_message_room_id` (`room_id`),
  KEY `fk_room_message_user_id` (`user_id`),
  CONSTRAINT `fk_room_message_room_id` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_room_message_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_message`
--

/*!40000 ALTER TABLE `room_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_message` ENABLE KEYS */;

--
-- Table structure for table `room_user`
--

DROP TABLE IF EXISTS `room_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_user` (
  `room_id` bigint(20) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `date_added` datetime NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`room_id`,`user_id`),
   KEY `fk_room_user_user_id` (`user_id`),
  CONSTRAINT `fk_room_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_user`
--

/*!40000 ALTER TABLE `room_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_user` ENABLE KEYS */;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `id` char(32) NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

--
-- Table structure for table `suspended`
--

DROP TABLE IF EXISTS `suspended`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suspended` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `eth_address` varchar(42) DEFAULT NULL,
  `action_by` varchar(42) DEFAULT NULL,
  `is_pending` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_ethaddr` (`eth_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suspended`
--

/*!40000 ALTER TABLE `suspended` DISABLE KEYS */;
/*!40000 ALTER TABLE `suspended` ENABLE KEYS */;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'design','design',1,'2018-10-30 11:49:54','2018-10-30 11:49:54');
INSERT INTO `tag` VALUES (2,'painting','painting',1,'2018-10-30 11:50:40','2018-10-30 11:50:40');
INSERT INTO `tag` VALUES (3,'musical instruments','musical instruments',1,'2018-10-30 11:50:40','2018-10-30 11:50:40');
INSERT INTO `tag` VALUES (4,'composing','composing',1,'2018-10-30 11:50:40','2018-10-30 11:50:40');
INSERT INTO `tag` VALUES (5,'RPG','RPG',1,'2018-10-30 11:50:40','2018-10-30 11:51:42');
INSERT INTO `tag` VALUES (6,'Shooters','Shooters',1,'2018-10-30 11:51:16','2018-10-30 11:51:16');
INSERT INTO `tag` VALUES (7,'tennis','tennis',1,'2018-10-30 11:51:16','2018-10-30 11:51:16');
INSERT INTO `tag` VALUES (8,'running','running',1,'2018-10-30 11:51:16','2018-10-30 11:51:42');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `eth_address` varchar(42) DEFAULT NULL,
  `registered_from` varchar(32) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `public_key` varchar(255) DEFAULT NULL,
  `is_suspended` tinyint(1) DEFAULT '0',
  `access_token` varchar(36) DEFAULT NULL,
  `last_session_id` char(32) DEFAULT NULL,
  `is_banned` tinyint(1) DEFAULT '0',
  `is_photo_valid` tinyint(1) DEFAULT '1',
  `photo_url` varchar(256) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_ethaddr` (`eth_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER user_suspended_after_update
AFTER UPDATE
ON user
FOR EACH ROW
BEGIN
	IF (NEW.is_suspended > 0 && OLD.is_suspended < 1) THEN
    INSERT INTO `suspended` (eth_address, action_by, is_pending) VALUES(OLD.eth_address, 'admin', 1);
	END IF;

	IF (NEW.is_suspended < 1 && OLD.is_suspended > 0) THEN
    DELETE FROM `suspended` where eth_address = OLD.eth_address;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER user_banned_after_update
AFTER UPDATE
ON user
FOR EACH ROW
BEGIN
	IF (NEW.is_banned > 0 && OLD.is_banned < 1) THEN
		INSERT INTO `banned` (user_id, action_by, fullname, email) VALUES (NEW.id, 'admin', NEW.fullname, NEW.email);
		INSERT INTO `moderation` (user_id, action_by, action) VALUES (NEW.id, 'admin', 'BANNED');
	END IF;

	IF (NEW.is_banned < 1 && OLD.is_banned > 0) THEN
		  DELETE FROM `banned` where user_id = NEW.id;
		  INSERT INTO `moderation` (user_id, action_by, action) VALUES (NEW.id, 'admin', 'UNBANNED');
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER user_moderation_after_update
AFTER UPDATE
ON user
FOR EACH ROW
BEGIN
	IF (NEW.is_photo_valid > 0 && OLD.is_photo_valid < 1) THEN
		INSERT INTO `moderation` (user_id, action_by, action) VALUES (NEW.id, 'admin', 'PHOTO  VALIDATED');
	END IF;

	IF (NEW.is_photo_valid < 1 && OLD.is_photo_valid > 0) THEN
		  INSERT INTO `moderation` (user_id, action_by, action) VALUES (NEW.id, 'admin', 'PHOTO UNVALIDATED');
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER user_suspended_after_delete
AFTER DELETE
ON user
FOR EACH ROW
BEGIN
	IF (OLD.is_suspended > 0) THEN
		UPDATE `suspended` SET `is_pending` = 0 WHERE `eth_address` = OLD.eth_address;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `user_contact`
--

DROP TABLE IF EXISTS `user_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_contact` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id_from` bigint(20) unsigned NOT NULL COMMENT 'user_id of the person initiating the friendship',
  `user_id_to` bigint(20) unsigned NOT NULL COMMENT 'user_id of the person who needs to accept',
  `accepted` tinyint(1) DEFAULT '0',
  `date_accepted` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniquer_friendship` (`user_id_from`,`user_id_to`),
  KEY `accepted` (`accepted`),
  KEY `fk_user_id_to` (`user_id_to`),
  CONSTRAINT `fk_user_id_from` FOREIGN KEY (`user_id_from`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_id_to` FOREIGN KEY (`user_id_to`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_contact`
--

/*!40000 ALTER TABLE `user_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_contact` ENABLE KEYS */;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`role`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

ALTER TABLE `conference_session` MODIFY `is_open` tinyint(1) DEFAULT '1';
ALTER TABLE `conference_session` MODIFY room_id BIGINT(20) NOT NULL;
ALTER TABLE `conference_session`
ADD CONSTRAINT `fk_conference_session_room_room_id` FOREIGN KEY (`room_id`) REFERENCES `room`(`id`) ON DELETE CASCADE;

ALTER TABLE `conference_session` MODIFY `owner_id` bigint(20) unsigned NOT NULL;
ALTER TABLE `conference_session`
ADD CONSTRAINT `fk_conference_session_user_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `user`(`id`) ON DELETE CASCADE;

ALTER TABLE `conference_session`
ADD COLUMN `name` varchar(255) NOT NULL,
ADD COLUMN `description` text;

ALTER TABLE `conference_session_user`
ADD CONSTRAINT `fk_conference_session_user_conference_session_id` FOREIGN KEY (`conference_session_id`) REFERENCES `conference_session`(`ref`) ON DELETE CASCADE;

ALTER TABLE `room_user` DROP PRIMARY KEY;
ALTER TABLE `room_user` ADD COLUMN id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `room_user`
ADD CONSTRAINT `fk_room_user_room_room_id` FOREIGN KEY (`room_id`) REFERENCES `room`(`id`) ON DELETE CASCADE;
ALTER TABLE `room_user`
ADD CONSTRAINT `unique_user_id_room_id` UNIQUE (`room_id`, `user_id`);
