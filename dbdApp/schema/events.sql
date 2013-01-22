CREATE TABLE `events` (
  `event_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `event_date` (`event`,`date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8