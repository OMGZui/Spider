/*
Source Server         : localhost
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2015-09-07 01:00:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for films
-- ----------------------------
DROP TABLE IF EXISTS `films`;
CREATE TABLE `films` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(64) NOT NULL COMMENT '标题',
  `subtitle` varchar(64) NOT NULL COMMENT '副标题',
  `link` varchar(64) NOT NULL COMMENT '豆瓣链接',
  `img` varchar(64) NOT NULL COMMENT '封面图片',
  `rate` float(8,1) NOT NULL COMMENT '评分',
  `quote` varchar(64) NOT NULL COMMENT '简介',
  `flag` tinyint(8) NOT NULL DEFAULT '0' COMMENT '是否已观影',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
