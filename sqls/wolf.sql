/*
 Date: 10/20/2017 17:25:58 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `wolf`
-- ----------------------------
DROP TABLE IF EXISTS `wolf`;
CREATE TABLE `wolf` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '0' COMMENT '评论人名字',
  `rate` varchar(10) NOT NULL DEFAULT '0' COMMENT '评论人评分',
  `star` int(1) NOT NULL DEFAULT '0' COMMENT '评论人星级',
  `avatar` varchar(255) NOT NULL DEFAULT '0' COMMENT '评论人头像',
  `user_link` varchar(255) NOT NULL DEFAULT '0' COMMENT '评论人链接',
  `content` varchar(2000) NOT NULL DEFAULT '0' COMMENT '内容',
  `vote` int(1) NOT NULL DEFAULT '0' COMMENT '投票',
  `time` timestamp NULL DEFAULT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`),
  KEY `rate` (`rate`) USING BTREE COMMENT '评分',
  KEY `star` (`star`) USING BTREE COMMENT '星级',
  KEY `vote` (`vote`) USING BTREE COMMENT '投票',
  KEY `time` (`time`) USING BTREE COMMENT '时间'
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='战狼2影评';

SET FOREIGN_KEY_CHECKS = 1;
