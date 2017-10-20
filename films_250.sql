/*
 Date: 10/16/2017 09:50:49 AM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `films_250`
-- ----------------------------
DROP TABLE IF EXISTS `films_250`;
CREATE TABLE `films_250` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(64) DEFAULT NULL COMMENT '标题',
  `link` varchar(64) DEFAULT NULL COMMENT '链接',
  `img` varchar(5000) DEFAULT NULL COMMENT '图片',
  `desc` varchar(5000) DEFAULT NULL COMMENT '描述',
  `rate` varchar(8) DEFAULT NULL COMMENT '评分',
  `number` varchar(8) DEFAULT NULL COMMENT '评分人数',
  `quote` varchar(5000) DEFAULT NULL COMMENT '点评',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='电影top250';

SET FOREIGN_KEY_CHECKS = 1;
