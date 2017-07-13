/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50171
Source Host           : localhost:3306
Source Database       : ruyi666

Target Server Type    : MYSQL
Target Server Version : 50171
File Encoding         : 65001

Date: 2017-02-21 13:05:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_ad`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_ad`;
CREATE TABLE `tbl_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_title` varchar(255) DEFAULT NULL,
  `ad_link` varchar(255) DEFAULT NULL,
  `ad_img` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `adtelnumber` varchar(20) DEFAULT NULL,
  `erweima` varchar(255) DEFAULT NULL,
  `quanping` varchar(255) NOT NULL,
  `ad_link2` varchar(500) NOT NULL,
  `quanping2` varchar(255) NOT NULL,
  `ad_link3` varchar(500) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `gzhname` varchar(100) NOT NULL,
  `gzhurl` varchar(350) NOT NULL,
  `pmd_top` varchar(255) DEFAULT NULL,
  `pmd_footer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=236 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_ad
-- ----------------------------
 
-- ----------------------------
-- Table structure for `tbl_admin`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE `tbl_admin` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `logintimes` int(5) NOT NULL DEFAULT '0',
  `logintime` datetime DEFAULT NULL,
  `lasttime` datetime DEFAULT NULL,
  `add_time` int(10) NOT NULL,
  `loginip` varchar(50) NOT NULL DEFAULT '',
  `jb` int(1) NOT NULL COMMENT '管理员级别',
  `xtgl` int(1) NOT NULL DEFAULT '0' COMMENT '系统管理',
  `dyxx` int(1) NOT NULL DEFAULT '0' COMMENT '单页信息',
  `lbxx` int(1) NOT NULL DEFAULT '0' COMMENT '类别信息',
  `xwgl` int(1) NOT NULL DEFAULT '0' COMMENT '类别信息',
  `sjgl` int(1) NOT NULL DEFAULT '0' COMMENT '商家管理',
  `hyqx` varchar(255) DEFAULT '0' COMMENT '行业权限',
  `hygl` int(10) NOT NULL DEFAULT '0' COMMENT '会员管理',
  `cjgl` int(1) NOT NULL DEFAULT '0' COMMENT '插件管理',
  `chao` int(1) NOT NULL DEFAULT '0' COMMENT '超级管理员',
  `kehushu` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_admin
-- ----------------------------
INSERT INTO `tbl_admin` VALUES ('16', 'admin', 'e241150329e0423ec62f619c89df756e', '1204', '2017-02-18 11:14:30', '2017-02-18 09:54:22', '1338364688', '112.234.69.223', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '100000');
 
-- ----------------------------
-- Table structure for `tbl_info`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_info`;
CREATE TABLE `tbl_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `adpic` varchar(255) DEFAULT NULL,
  `adlink` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `wcount` int(11) DEFAULT NULL,
  `acount` int(11) DEFAULT NULL,
  `addtime` varchar(100) DEFAULT NULL,
  `telnum` varchar(100) DEFAULT NULL,
  `ifweizhi` int(10) DEFAULT NULL,
  `gongzhonghao` text,
  `ifPublicNumber` int(10) DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `ywyuedu` text,
  `infoid` varchar(200) DEFAULT '0',
  `daili` varchar(255) DEFAULT NULL,
  `adid` int(10) DEFAULT NULL,
  `is_quanping` int(1) DEFAULT NULL,
  `musicid` int(10) DEFAULT NULL,
  `autoplay` int(2) NOT NULL,
  `titleimg` varchar(300) DEFAULT NULL,
  `topad_type` int(2) DEFAULT NULL,
  `pmd_top` varchar(255) DEFAULT NULL,
  `footerad_type` int(2) DEFAULT NULL,
  `pmd_footer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2472 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_info
-- ----------------------------
 
-- ----------------------------
-- Table structure for `tbl_jigou`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_jigou`;
CREATE TABLE `tbl_jigou` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评估项目ID',
  `name` varchar(255) DEFAULT NULL COMMENT '估评项目',
  `paid` int(11) DEFAULT NULL COMMENT '评估分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_jigou
-- ----------------------------
INSERT INTO `tbl_jigou` VALUES ('1', '张', '0');
INSERT INTO `tbl_jigou` VALUES ('2', '常', '0');
INSERT INTO `tbl_jigou` VALUES ('3', '昆', '0');
INSERT INTO `tbl_jigou` VALUES ('4', '太', '0');
INSERT INTO `tbl_jigou` VALUES ('5', '吴', '0');
INSERT INTO `tbl_jigou` VALUES ('6', '张1', '1');
INSERT INTO `tbl_jigou` VALUES ('7', '张2', '1');
INSERT INTO `tbl_jigou` VALUES ('8', '张3', '1');
INSERT INTO `tbl_jigou` VALUES ('9', '张4', '1');
INSERT INTO `tbl_jigou` VALUES ('10', '常1', '2');
INSERT INTO `tbl_jigou` VALUES ('11', '常2', '2');
INSERT INTO `tbl_jigou` VALUES ('12', '常3', '2');
INSERT INTO `tbl_jigou` VALUES ('13', '昆1', '3');
INSERT INTO `tbl_jigou` VALUES ('14', '昆2', '3');
INSERT INTO `tbl_jigou` VALUES ('15', '昆3', '3');
INSERT INTO `tbl_jigou` VALUES ('16', '昆4', '3');
INSERT INTO `tbl_jigou` VALUES ('17', '昆5', '3');
INSERT INTO `tbl_jigou` VALUES ('18', '太1', '4');
INSERT INTO `tbl_jigou` VALUES ('19', '太2', '4');
INSERT INTO `tbl_jigou` VALUES ('20', '太3', '4');
INSERT INTO `tbl_jigou` VALUES ('21', '太4', '4');
INSERT INTO `tbl_jigou` VALUES ('22', '太5', '4');
INSERT INTO `tbl_jigou` VALUES ('23', '太6', '4');
INSERT INTO `tbl_jigou` VALUES ('24', '吴1', '5');
INSERT INTO `tbl_jigou` VALUES ('25', '吴2', '5');
INSERT INTO `tbl_jigou` VALUES ('26', '吴3', '5');

-- ----------------------------
-- Table structure for `tbl_music`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_music`;
CREATE TABLE `tbl_music` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `path` varchar(255) NOT NULL,
  `add_time` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_music
-- ----------------------------
INSERT INTO `tbl_music` VALUES ('6', '孙子涵 - 最近还好么', '/upload/music/孙子涵 - 最近还好么.mp3', '1465912173', '1');

-- ----------------------------
-- Table structure for `tbl_music_cat`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_music_cat`;
CREATE TABLE `tbl_music_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_music_cat
-- ----------------------------
INSERT INTO `tbl_music_cat` VALUES ('1', '流行', '1466649894');
INSERT INTO `tbl_music_cat` VALUES ('2', '古典', '1466651523');
INSERT INTO `tbl_music_cat` VALUES ('3', 'cs', '1467014191');
INSERT INTO `tbl_music_cat` VALUES ('4', '网络', '1467036479');

-- ----------------------------
-- Table structure for `tbl_site`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_site`;
CREATE TABLE `tbl_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(200) NOT NULL,
  `fxdomain` varchar(400) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_site
-- ----------------------------
INSERT INTO `tbl_site` VALUES ('1', 'wdj.boyu199.com', 'wdj.boyu199.com', '0');

-- ----------------------------
-- Table structure for `tbl_type`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_type`;
CREATE TABLE `tbl_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `sort` int(11) DEFAULT NULL COMMENT '序排',
  `img` varchar(255) DEFAULT NULL COMMENT '标题图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_type
-- ----------------------------
INSERT INTO `tbl_type` VALUES ('1', '客户管理', '1', 'images/bar1.png');
INSERT INTO `tbl_type` VALUES ('2', '访前准备', '2', 'images/bar2.png');
INSERT INTO `tbl_type` VALUES ('3', '产品知识', '3', 'images/bar3.png');
INSERT INTO `tbl_type` VALUES ('4', '销售技巧', '4', 'images/bar4.png');
INSERT INTO `tbl_type` VALUES ('5', '访后记录', '5', 'images/bar5.png');
INSERT INTO `tbl_type` VALUES ('6', '随访总结', '6', 'images/bar5.png');

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `userpwd` varchar(255) DEFAULT NULL,
  `qq` varchar(255) DEFAULT NULL,
  `anums` int(11) DEFAULT NULL,
  `ctime` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `beizhu1` text,
  `beizhu2` text,
  `shuyu` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
 

-- ----------------------------
-- Table structure for `tbl_weixin`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_weixin`;
CREATE TABLE `tbl_weixin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `APPID` varchar(200) DEFAULT NULL,
  `APPSECRET` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_weixin
-- ----------------------------
INSERT INTO `tbl_weixin` VALUES ('1', 'wxbfadac03ea762dd8', '29441bd5a656bc103fc0ac982c6c1e9a');
