CREATE TABLE `power` (
  `power_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`power_id`),
  KEY `read` (`read`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8