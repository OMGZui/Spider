/*
 Navicat Premium Data Transfer

 Source Server         : root
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : 127.0.0.1
 Source Database       : film_top_250

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : utf-8

 Date: 08/27/2017 21:17:43 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `films`
-- ----------------------------
DROP TABLE IF EXISTS `films`;
CREATE TABLE `films` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(64) DEFAULT NULL COMMENT '标题',
  `subtitle` varchar(64) DEFAULT NULL COMMENT '副标题',
  `link` varchar(64) DEFAULT NULL COMMENT '豆瓣链接',
  `img` varchar(5000) DEFAULT NULL COMMENT '封面图片',
  `rate` varchar(8) DEFAULT NULL COMMENT '评分',
  `quote` varchar(64) DEFAULT NULL COMMENT '简介',
  `flag` tinyint(8) DEFAULT NULL COMMENT '是否已观影',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
