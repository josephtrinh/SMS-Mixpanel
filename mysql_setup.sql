/*
Database - lalamove
*********************************************************************
*/

CREATE DATABASE /*!32312 IF NOT EXISTS*/`lalamove` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `lalamove`;

/*Table structure for table `mixpanel_event` */

CREATE TABLE `mixpanel_event` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `distinct_id` varchar(50) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `referring_domain` varchar(50) DEFAULT NULL,
  `referring_url` varchar(255) DEFAULT NULL,
  `responsed` int(1) DEFAULT NULL,
  `sms_sent` int(1) DEFAULT NULL,
  `sms_to` varchar(20) DEFAULT NULL,
  `sms_message_id` varchar(20) DEFAULT NULL,
  `sms_status` int(5) DEFAULT NULL,
  `sms_remaining_balance` varchar(20) DEFAULT NULL,
  `sms_message_price` varchar(20) DEFAULT NULL,
  `sms_network` int(10) DEFAULT NULL,
  `sms_error_text` varchar(50) DEFAULT NULL,
  `sms_sent_date` datetime DEFAULT NULL,
  `sms_last_sent` datetime DEFAULT NULL,
  `last_seen` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
