CREATE TABLE `admin_game` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `game_name` varchar(20) NOT NULL DEFAULT '' COMMENT '游戏名字',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '游戏分组id',
  `game_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '游戏类型',
  `game_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '游戏状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_name` (`game_name`),
  KEY `group_id` (`group_id`),
  KEY `game_type` (`game_type`),
  KEY `game_status` (`game_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

