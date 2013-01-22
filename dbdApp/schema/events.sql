CREATE TABLE `events` (
  `event_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_data` text NOT NULL,
  `event_date` datetime NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `event_date` (`event_name`,`event_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8