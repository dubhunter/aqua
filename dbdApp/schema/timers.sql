CREATE TABLE `timers` (
  `timer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `time_start` time NOT NULL,
  `time_stop` time NOT NULL,
  `running` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`time_id`),
  KEY `times_running` (`time_start`,`time_stop`,`running`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8