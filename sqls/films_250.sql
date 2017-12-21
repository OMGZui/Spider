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
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(50) NOT NULL DEFAULT '0' COMMENT '标题',
  `sub_title` varchar(50) NOT NULL DEFAULT '0' COMMENT '副标题',
  `link` varchar(50) NOT NULL DEFAULT '0' COMMENT '链接',
  `img` varchar(255) NOT NULL DEFAULT '0' COMMENT '图片',
  `desc` varchar(2000) NOT NULL DEFAULT '0' COMMENT '描述',
  `rate` varchar(8) NOT NULL DEFAULT '0' COMMENT '评分',
  `num` varchar(8) NOT NULL DEFAULT '0' COMMENT '评分人数',
  `quote` varchar(200) NOT NULL DEFAULT '0' COMMENT '点评',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='电影top250';

SET FOREIGN_KEY_CHECKS = 1;
