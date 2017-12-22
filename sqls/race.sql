/*
 Date: 12/22/2017 17:25:58 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `race`
-- ----------------------------
DROP TABLE IF EXISTS `race`;
CREATE TABLE `race` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '0' COMMENT '赛事名字',
  `img` varchar(2000) NOT NULL DEFAULT '0' COMMENT '图片',
  `href` varchar(255) NOT NULL DEFAULT '0' COMMENT '链接',
  `follow` int(1) NOT NULL DEFAULT '0' COMMENT '关注数',
  `start_time` date NULL DEFAULT NULL COMMENT '评论时间',
  `inter_time` varchar(50) NOT NULL DEFAULT '0' COMMENT '报名时间',
  `apply_status` varchar(10) NOT NULL DEFAULT '0' COMMENT '报名状态',
  `address` varchar(50) NOT NULL DEFAULT '0' COMMENT '地址',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='赛事';

SET FOREIGN_KEY_CHECKS = 1;
