CREATE TABLE `triggers` (
  `trigger_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trigger_name` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `trigger_type` int(11) NOT NULL,
  `trigger_value` int(11) DEFAULT NULL,
  `alert_type` int(11) NOT NULL,
  `alert_msg` varchar(255) NOT NULL,
  `alert_recipient` varchar(255) NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`trigger_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `triggers` VALUES (1,'Broken Comm: SMS Will','crickets',0,NULL,1,'I havn\'t heard from the hyduino in over %d minutes.','310-804-9330',1,'2013-01-24 02:31:58','2013-01-24 02:32:01');
