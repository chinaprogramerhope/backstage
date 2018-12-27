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


CREATE TABLE `admin_game_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `vipAccount` varchar(50) NOT NULL DEFAULT '' COMMENT '会员账号',
  `gameId` varchar(20) NOT NULL DEFAULT '' COMMENT '游戏id',
  `roomId` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '房间id',
  `bet` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '投注',
  `winAmount` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '中奖金额',
  `winLose` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '盈亏',
  `tax` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '税收',
  `timeBegin` datetime NOT NULL COMMENT '开始时间',
  `timeEnd` datetime NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`),
  KEY `gameId` (`gameId`),
  KEY `roomId` (`roomId`),
  KEY `vipAccount` (`vipAccount`),
  KEY `timeBegin` (`timeBegin`),
  KEY `timeEnd` (`timeEnd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='游戏投注记录';



