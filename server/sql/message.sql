CREATE TABLE `admin_announce` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '公告类型: 1一般游戏公告,2站点公告,3维护公告,4系统游戏公告',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '公告状态: 1启用,2禁用',
  `creator` varchar(20) NOT NULL DEFAULT '' COMMENT '创建人',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '公告内容',
  `note` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `area` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送区域: -1全部,1收件箱,2走马灯',
  `terminal` tinyint(3) NOT NULL DEFAULT '0' COMMENT '使用终端: -1全部,1电脑端,2移动端',
  `createTime` datetime NOT NULL COMMENT '创建时间',
  `publishTime` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `publishTime` (`publishTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='公告';



