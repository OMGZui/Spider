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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL COMMENT '评论人名字',
  `content` varchar(5000) DEFAULT NULL COMMENT '内容',
  `votes` varchar(50) DEFAULT NULL COMMENT '投票',
  `time` varchar(50) DEFAULT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=207109 DEFAULT CHARSET=utf8mb4 COMMENT='战狼2影评';

SET FOREIGN_KEY_CHECKS = 1;
