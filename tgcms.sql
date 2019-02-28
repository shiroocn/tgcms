/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : tgcms

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2019-02-26 16:17:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_admin
-- ----------------------------
DROP TABLE IF EXISTS `t_admin`;
CREATE TABLE `t_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_admin
-- ----------------------------
INSERT INTO `t_admin` VALUES ('1', '1');

-- ----------------------------
-- Table structure for t_brand
-- ----------------------------
DROP TABLE IF EXISTS `t_brand`;
CREATE TABLE `t_brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) DEFAULT NULL,
  `brand_weixin` varchar(255) DEFAULT NULL,
  `brand_weixinqr_path` varchar(255) DEFAULT NULL,
  `brand_icon_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_brand
-- ----------------------------
INSERT INTO `t_brand` VALUES ('13', '刘少明', 'MB168166', '/static/uploads/f0/e60fe7c3b9cc9e2890149224d3c4de.png', '/static/uploads/24/1f54794f3800095b732d91df008104.jpg');
INSERT INTO `t_brand` VALUES ('14', '卜明', 'dibgding3350', '/static/uploads/91/64086ab3c5c5c7cde58676f30bbe0a.jpg', '/static/uploads/c1/2b15fa1112e67c69af5151fb769863.jpg');
INSERT INTO `t_brand` VALUES ('15', '陈鼎新', 'chendingxin68', '/static/uploads/73/07a0053151e8821e9117d4a5e148ae.jpg', '/static/uploads/f7/e4e7639eb49500b72bff5728fcce2a.jpg');
INSERT INTO `t_brand` VALUES ('16', '林智宏', 'cici111888cici', '/static/uploads/45/9814d04a64d6801e5011f6a7cdb482.jpg', '/static/uploads/35/e908080fe7dc5700b832a93c07132b.jpg');
INSERT INTO `t_brand` VALUES ('17', '刘国华', 'liuguohua28', '/static/uploads/c3/6c7bcedda8d9d139134ff64dd3bd1d.png', '/static/uploads/1b/3f77f7e3e0e26de6726008ab689746.jpg');

-- ----------------------------
-- Table structure for t_brand_define
-- ----------------------------
DROP TABLE IF EXISTS `t_brand_define`;
CREATE TABLE `t_brand_define` (
  `bd_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `bd_name` varchar(255) NOT NULL COMMENT '用户扩展字段名称',
  `bd_note` varchar(255) NOT NULL COMMENT '扩展字段文字描述',
  `bd_type` varchar(10) NOT NULL,
  PRIMARY KEY (`bd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_brand_define
-- ----------------------------
INSERT INTO `t_brand_define` VALUES ('1', 'banner_old', '老版本的banner图片地址', 'images');
INSERT INTO `t_brand_define` VALUES ('2', 'banner_new', '新版本的banner图片地址', 'images');

-- ----------------------------
-- Table structure for t_brand_define_list
-- ----------------------------
DROP TABLE IF EXISTS `t_brand_define_list`;
CREATE TABLE `t_brand_define_list` (
  `bdl_id` int(11) NOT NULL AUTO_INCREMENT,
  `bdl_define_id` int(11) NOT NULL COMMENT '对应user_define表的ID',
  `bdl_define_var` varchar(255) NOT NULL COMMENT 'define的值',
  `bdl_brand_id` int(11) NOT NULL COMMENT '对应用户ID',
  PRIMARY KEY (`bdl_id`),
  UNIQUE KEY `a` (`bdl_define_id`,`bdl_brand_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_brand_define_list
-- ----------------------------
INSERT INTO `t_brand_define_list` VALUES ('3', '1', '/static/uploads/ca/a545d455d81b671a97a7fdf724aad1.png', '13');
INSERT INTO `t_brand_define_list` VALUES ('5', '2', '/static/uploads/dc/75cc342dc5992a9433c9e7b6f9558d.png', '13');
INSERT INTO `t_brand_define_list` VALUES ('6', '1', '/static/uploads/f7/e4e7639eb49500b72bff5728fcce2a.jpg', '14');
INSERT INTO `t_brand_define_list` VALUES ('8', '1', '/static/uploads/ae/9f39bf1bb833297a6e6f70f9881ccf.png', '16');
INSERT INTO `t_brand_define_list` VALUES ('9', '2', '/static/uploads/f5/5b5d371ecdc34aa9f60ef020a43217.png', '16');

-- ----------------------------
-- Table structure for t_domain
-- ----------------------------
DROP TABLE IF EXISTS `t_domain`;
CREATE TABLE `t_domain` (
  `domain_id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_url` varchar(255) DEFAULT NULL,
  `domain_copyright` varchar(255) DEFAULT NULL,
  `domain_count_code` text,
  PRIMARY KEY (`domain_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_domain
-- ----------------------------
INSERT INTO `t_domain` VALUES ('1', 'tgcms.shiroo.com', '&lt;p&gt;版权所有 : 韩城集升商贸有限公司&lt;/p&gt; &lt;p&gt;商品交易有风险 投资入市需谨慎&lt;/p&gt;', '&lt;script id=&quot;kw_tongji&quot; src=&quot;http://tj.shangdee.com/kw.js?sign=d6396e998eb50d46970e7b04340747f1&quot; charset=&quot;UTF-8&quot;&gt;&lt;/script&gt;');
INSERT INTO `t_domain` VALUES ('2', 'tgcms1.shiroo.com', '&lt;p&gt;这里是tgcms1的版权信息加22个测试&lt;/p&gt;', '&lt;script&gt;\nvar _hmt = _hmt || [];\n(function() {\n  var hm = document.createElement(&quot;script&quot;);\n  hm.src = &quot;https://hm.baidu.com/hm.js?6420fcaecce980cd42226fbaf5a3370d&quot;;\n  var s = document.getElementsByTagName(&quot;script&quot;)[0]; \n  s.parentNode.insertBefore(hm, s);\n})();\n&lt;/script&gt;');
INSERT INTO `t_domain` VALUES ('3', 'tgcms2.shiroo.com', '&lt;p&gt;tgcms2的版d权信息加个测试&lt;/p&gt;', '&lt;script id=&quot;kw_tongji&quot; src=&quot;http://tj.shangdee.com/kw.js?sign=d6396e998eb50d46970e7b04340747f1&quot; charset=&quot;UTF-8&quot;&gt;&lt;/script&gt;');

-- ----------------------------
-- Table structure for t_file
-- ----------------------------
DROP TABLE IF EXISTS `t_file`;
CREATE TABLE `t_file` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL COMMENT '文件名',
  `file_path` varchar(255) NOT NULL COMMENT '文件存放路径',
  `file_create_time` int(11) NOT NULL COMMENT '文件上传时间',
  `file_md5` varchar(32) NOT NULL COMMENT '文件MD5值',
  `file_exists` int(1) NOT NULL COMMENT '文件是否存在0不存在1存在',
  `file_upload_ip` varchar(255) DEFAULT NULL,
  `file_admin_id` int(11) NOT NULL,
  `file_type` varchar(10) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_file
-- ----------------------------
INSERT INTO `t_file` VALUES ('6', 'd35388d97c86d9857a1618ef5d96c4.jpg', '83/d35388d97c86d9857a1618ef5d96c4.jpg', '1540898261', '83d35388d97c86d9857a1618ef5d96c4', '1', '127.0.0.1', '1', 'jpg', '14556');
INSERT INTO `t_file` VALUES ('9', '5bf4efce3ac5f148659a190d48122d.png', 'f5/5bf4efce3ac5f148659a190d48122d.png', '1540967540', 'f55bf4efce3ac5f148659a190d48122d', '1', '127.0.0.1', '1', 'png', '774359');
INSERT INTO `t_file` VALUES ('10', 'e5fe2aef4502013e9c12f79a2df535.png', 'f1/e5fe2aef4502013e9c12f79a2df535.png', '1540967556', 'f1e5fe2aef4502013e9c12f79a2df535', '1', '127.0.0.1', '1', 'png', '98146');
INSERT INTO `t_file` VALUES ('4', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1540454885', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('8', '8901125af6fbf8b1e441e44eed2d5b.jpg', '6b/8901125af6fbf8b1e441e44eed2d5b.jpg', '1540898418', '6b8901125af6fbf8b1e441e44eed2d5b', '1', '127.0.0.1', '1', 'jpg', '48307');
INSERT INTO `t_file` VALUES ('11', '8cd9a9ccd16f74eb3589a93fc9af13.png', '6f/8cd9a9ccd16f74eb3589a93fc9af13.png', '1540967578', '6f8cd9a9ccd16f74eb3589a93fc9af13', '1', '127.0.0.1', '1', 'png', '681348');
INSERT INTO `t_file` VALUES ('12', '4739345bb62dc62ef2799386bde313.png', '51/4739345bb62dc62ef2799386bde313.png', '1540967590', '514739345bb62dc62ef2799386bde313', '1', '127.0.0.1', '1', 'png', '701391');
INSERT INTO `t_file` VALUES ('13', '64170b3c27371ff4987a5185af1698.jpg', 'ef/64170b3c27371ff4987a5185af1698.jpg', '1540967603', 'ef64170b3c27371ff4987a5185af1698', '1', '127.0.0.1', '1', 'jpg', '160264');
INSERT INTO `t_file` VALUES ('14', '7a5bdbc070ded3d6ce79a192366d00.jpg', '9a/7a5bdbc070ded3d6ce79a192366d00.jpg', '1540967611', '9a7a5bdbc070ded3d6ce79a192366d00', '1', '127.0.0.1', '1', 'jpg', '185004');
INSERT INTO `t_file` VALUES ('15', '67c20f2afd6adbb0e083acf66481e5.jpg', '2c/67c20f2afd6adbb0e083acf66481e5.jpg', '1540967648', '2c67c20f2afd6adbb0e083acf66481e5', '1', '127.0.0.1', '1', 'jpg', '979707');
INSERT INTO `t_file` VALUES ('16', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548062158', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('17', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548062341', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('18', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548062482', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('19', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063121', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('20', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063309', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('21', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063488', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('22', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063570', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('23', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063681', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('24', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063711', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('25', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063733', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('26', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063765', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('27', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548063905', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('28', '285d7afccbaf9672db281c4d425c6d.png', '98/285d7afccbaf9672db281c4d425c6d.png', '1548064275', '98285d7afccbaf9672db281c4d425c6d', '1', '127.0.0.1', '1', 'png', '640774');
INSERT INTO `t_file` VALUES ('29', '8cd9a9ccd16f74eb3589a93fc9af13.png', '6f/8cd9a9ccd16f74eb3589a93fc9af13.png', '1548064284', '6f8cd9a9ccd16f74eb3589a93fc9af13', '1', '127.0.0.1', '1', 'png', '681348');
INSERT INTO `t_file` VALUES ('30', 'e5fe2aef4502013e9c12f79a2df535.png', 'f1/e5fe2aef4502013e9c12f79a2df535.png', '1548065305', 'f1e5fe2aef4502013e9c12f79a2df535', '1', '127.0.0.1', '1', 'png', '98146');
INSERT INTO `t_file` VALUES ('31', '58597a4dde958bb5bf43dccf8944ca.jpg', '33/58597a4dde958bb5bf43dccf8944ca.jpg', '1548065307', '3358597a4dde958bb5bf43dccf8944ca', '1', '127.0.0.1', '1', 'jpg', '4765');
INSERT INTO `t_file` VALUES ('32', '58597a4dde958bb5bf43dccf8944ca.jpg', '33/58597a4dde958bb5bf43dccf8944ca.jpg', '1548066070', '3358597a4dde958bb5bf43dccf8944ca', '1', '127.0.0.1', '1', 'jpg', '4765');
INSERT INTO `t_file` VALUES ('33', 'e5fe2aef4502013e9c12f79a2df535.png', 'f1/e5fe2aef4502013e9c12f79a2df535.png', '1548066074', 'f1e5fe2aef4502013e9c12f79a2df535', '1', '127.0.0.1', '1', 'png', '98146');
INSERT INTO `t_file` VALUES ('34', 'e5fe2aef4502013e9c12f79a2df535.png', 'f1/e5fe2aef4502013e9c12f79a2df535.png', '1548066115', 'f1e5fe2aef4502013e9c12f79a2df535', '1', '127.0.0.1', '1', 'png', '98146');
INSERT INTO `t_file` VALUES ('35', '58597a4dde958bb5bf43dccf8944ca.jpg', '33/58597a4dde958bb5bf43dccf8944ca.jpg', '1548066117', '3358597a4dde958bb5bf43dccf8944ca', '1', '127.0.0.1', '1', 'jpg', '4765');
INSERT INTO `t_file` VALUES ('36', '1f54794f3800095b732d91df008104.jpg', '24/1f54794f3800095b732d91df008104.jpg', '1548068203', '241f54794f3800095b732d91df008104', '1', '127.0.0.1', '1', 'jpg', '132686');
INSERT INTO `t_file` VALUES ('37', 'e60fe7c3b9cc9e2890149224d3c4de.png', 'f0/e60fe7c3b9cc9e2890149224d3c4de.png', '1548068211', 'f0e60fe7c3b9cc9e2890149224d3c4de', '1', '127.0.0.1', '1', 'png', '48287');
INSERT INTO `t_file` VALUES ('38', 'e4e7639eb49500b72bff5728fcce2a.jpg', 'f7/e4e7639eb49500b72bff5728fcce2a.jpg', '1548071947', 'f7e4e7639eb49500b72bff5728fcce2a', '1', '127.0.0.1', '1', 'jpg', '27086');
INSERT INTO `t_file` VALUES ('39', '1f54794f3800095b732d91df008104.jpg', '24/1f54794f3800095b732d91df008104.jpg', '1548071962', '241f54794f3800095b732d91df008104', '1', '127.0.0.1', '1', 'jpg', '132686');
INSERT INTO `t_file` VALUES ('40', '2b15fa1112e67c69af5151fb769863.jpg', 'c1/2b15fa1112e67c69af5151fb769863.jpg', '1548230893', 'c12b15fa1112e67c69af5151fb769863', '1', '127.0.0.1', '1', 'jpg', '27921');
INSERT INTO `t_file` VALUES ('41', '2b15fa1112e67c69af5151fb769863.jpg', 'c1/2b15fa1112e67c69af5151fb769863.jpg', '1548230898', 'c12b15fa1112e67c69af5151fb769863', '1', '127.0.0.1', '1', 'jpg', '27921');
INSERT INTO `t_file` VALUES ('42', '64086ab3c5c5c7cde58676f30bbe0a.jpg', '91/64086ab3c5c5c7cde58676f30bbe0a.jpg', '1548230933', '9164086ab3c5c5c7cde58676f30bbe0a', '1', '127.0.0.1', '1', 'jpg', '29812');
INSERT INTO `t_file` VALUES ('43', 'e60fe7c3b9cc9e2890149224d3c4de.png', 'f0/e60fe7c3b9cc9e2890149224d3c4de.png', '1548230958', 'f0e60fe7c3b9cc9e2890149224d3c4de', '1', '127.0.0.1', '1', 'png', '48287');
INSERT INTO `t_file` VALUES ('44', '1f54794f3800095b732d91df008104.jpg', '24/1f54794f3800095b732d91df008104.jpg', '1548230962', '241f54794f3800095b732d91df008104', '1', '127.0.0.1', '1', 'jpg', '132686');
INSERT INTO `t_file` VALUES ('45', 'e4e7639eb49500b72bff5728fcce2a.jpg', 'f7/e4e7639eb49500b72bff5728fcce2a.jpg', '1548231223', 'f7e4e7639eb49500b72bff5728fcce2a', '1', '127.0.0.1', '1', 'jpg', '27086');
INSERT INTO `t_file` VALUES ('46', '07a0053151e8821e9117d4a5e148ae.jpg', '73/07a0053151e8821e9117d4a5e148ae.jpg', '1548231226', '7307a0053151e8821e9117d4a5e148ae', '1', '127.0.0.1', '1', 'jpg', '81678');
INSERT INTO `t_file` VALUES ('47', 'e908080fe7dc5700b832a93c07132b.jpg', '35/e908080fe7dc5700b832a93c07132b.jpg', '1548231296', '35e908080fe7dc5700b832a93c07132b', '1', '127.0.0.1', '1', 'jpg', '42601');
INSERT INTO `t_file` VALUES ('48', '9814d04a64d6801e5011f6a7cdb482.jpg', '45/9814d04a64d6801e5011f6a7cdb482.jpg', '1548231301', '459814d04a64d6801e5011f6a7cdb482', '1', '127.0.0.1', '1', 'jpg', '59402');
INSERT INTO `t_file` VALUES ('49', '3f77f7e3e0e26de6726008ab689746.jpg', '1b/3f77f7e3e0e26de6726008ab689746.jpg', '1548232228', '1b3f77f7e3e0e26de6726008ab689746', '1', '127.0.0.1', '1', 'jpg', '83754');
INSERT INTO `t_file` VALUES ('50', '6c7bcedda8d9d139134ff64dd3bd1d.png', 'c3/6c7bcedda8d9d139134ff64dd3bd1d.png', '1548232233', 'c36c7bcedda8d9d139134ff64dd3bd1d', '1', '127.0.0.1', '1', 'png', '51546');
INSERT INTO `t_file` VALUES ('51', 'e4e7639eb49500b72bff5728fcce2a.jpg', 'f7/e4e7639eb49500b72bff5728fcce2a.jpg', '1548236939', 'f7e4e7639eb49500b72bff5728fcce2a', '1', '127.0.0.1', '1', 'jpg', '27086');
INSERT INTO `t_file` VALUES ('52', '9f39bf1bb833297a6e6f70f9881ccf.png', 'ae/9f39bf1bb833297a6e6f70f9881ccf.png', '1548310258', 'ae9f39bf1bb833297a6e6f70f9881ccf', '1', '127.0.0.1', '1', 'png', '210954');
INSERT INTO `t_file` VALUES ('53', '5b5d371ecdc34aa9f60ef020a43217.png', 'f5/5b5d371ecdc34aa9f60ef020a43217.png', '1548310273', 'f55b5d371ecdc34aa9f60ef020a43217', '1', '127.0.0.1', '1', 'png', '168011');
INSERT INTO `t_file` VALUES ('54', 'a545d455d81b671a97a7fdf724aad1.png', 'ca/a545d455d81b671a97a7fdf724aad1.png', '1551168037', 'caa545d455d81b671a97a7fdf724aad1', '1', '127.0.0.1', '1', 'png', '257160');
INSERT INTO `t_file` VALUES ('55', '75cc342dc5992a9433c9e7b6f9558d.png', 'dc/75cc342dc5992a9433c9e7b6f9558d.png', '1551168053', 'dc75cc342dc5992a9433c9e7b6f9558d', '1', '127.0.0.1', '1', 'png', '179969');

-- ----------------------------
-- Table structure for t_page
-- ----------------------------
DROP TABLE IF EXISTS `t_page`;
CREATE TABLE `t_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL COMMENT '落地页别名',
  `page_template_id` int(11) NOT NULL,
  `page_domain_id` int(11) NOT NULL,
  `page_brand_id` int(11) NOT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `a` (`page_name`,`page_domain_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_page
-- ----------------------------
INSERT INTO `t_page` VALUES ('77', '1', '1', '1', '13');
INSERT INTO `t_page` VALUES ('78', '2', '1', '1', '15');
INSERT INTO `t_page` VALUES ('79', '1', '1', '2', '13');
INSERT INTO `t_page` VALUES ('80', '2', '2', '2', '13');
INSERT INTO `t_page` VALUES ('81', '3', '3', '2', '13');
INSERT INTO `t_page` VALUES ('82', '4', '4', '2', '14');
INSERT INTO `t_page` VALUES ('83', '5', '5', '2', '13');
INSERT INTO `t_page` VALUES ('84', '6', '6', '2', '13');
INSERT INTO `t_page` VALUES ('85', '7', '7', '2', '13');
INSERT INTO `t_page` VALUES ('86', '8', '11', '2', '13');
INSERT INTO `t_page` VALUES ('87', '9', '26', '2', '13');
INSERT INTO `t_page` VALUES ('88', '10', '27', '2', '13');
INSERT INTO `t_page` VALUES ('89', '11', '28', '2', '13');
INSERT INTO `t_page` VALUES ('90', '12', '9', '2', '13');
INSERT INTO `t_page` VALUES ('91', '13', '10', '2', '13');
INSERT INTO `t_page` VALUES ('92', '14', '12', '2', '13');
INSERT INTO `t_page` VALUES ('93', '15', '8', '2', '13');

-- ----------------------------
-- Table structure for t_template
-- ----------------------------
DROP TABLE IF EXISTS `t_template`;
CREATE TABLE `t_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `_template_dir_id` int(255) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_template
-- ----------------------------
INSERT INTO `t_template` VALUES ('1', '15.html', '4');
INSERT INTO `t_template` VALUES ('2', '16.html', '4');
INSERT INTO `t_template` VALUES ('3', '17.html', '4');
INSERT INTO `t_template` VALUES ('4', '18.html', '4');
INSERT INTO `t_template` VALUES ('5', '19.html', '4');
INSERT INTO `t_template` VALUES ('6', '20.html', '4');
INSERT INTO `t_template` VALUES ('7', '21.html', '4');
INSERT INTO `t_template` VALUES ('8', '1.html', '5');
INSERT INTO `t_template` VALUES ('9', '16.html', '3');
INSERT INTO `t_template` VALUES ('10', '17.html', '3');
INSERT INTO `t_template` VALUES ('11', '1.html', '2');
INSERT INTO `t_template` VALUES ('12', 'index.html', '1');
INSERT INTO `t_template` VALUES ('28', '4.html', '2');
INSERT INTO `t_template` VALUES ('27', '3.html', '2');
INSERT INTO `t_template` VALUES ('26', '2.html', '2');

-- ----------------------------
-- Table structure for t_template_dir
-- ----------------------------
DROP TABLE IF EXISTS `t_template_dir`;
CREATE TABLE `t_template_dir` (
  `template_dir_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_dir_name` varchar(255) NOT NULL,
  PRIMARY KEY (`template_dir_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_template_dir
-- ----------------------------
INSERT INTO `t_template_dir` VALUES ('1', 'dome');
INSERT INTO `t_template_dir` VALUES ('2', 'lsm');
INSERT INTO `t_template_dir` VALUES ('3', 'new');
INSERT INTO `t_template_dir` VALUES ('4', 'tieba');
INSERT INTO `t_template_dir` VALUES ('5', 'weixin');

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_account` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO `t_user` VALUES ('1', 'admin', 'aa4524d3a3f92c7600258906fb9c0e082b1ab527');
