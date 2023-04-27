/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50529
Source Host           : localhost:3306
Source Database       : guahao

Target Server Type    : MYSQL
Target Server Version : 50529
File Encoding         : 65001

Date: 2022-03-02 19:16:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for articles
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章标题',
  `content` longtext COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of articles
-- ----------------------------
INSERT INTO `articles` VALUES ('1', '开通挂号了啊哈啊', '开通挂号了啊哈啊开通挂号了啊哈啊开通挂号了啊哈啊开通挂号了啊哈啊开通挂号了啊哈啊', '2022-02-25 15:50:42', '2022-02-25 15:50:42');

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标题',
  `url` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '路径',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of banners
-- ----------------------------
INSERT INTO `banners` VALUES ('3', '2222', '/static/uploads/20220225155017502.jpg', '2022-02-25 15:50:19', '2022-02-25 15:50:19');
INSERT INTO `banners` VALUES ('2', '222', '/static/uploads/20220225101324608.jpg', '2022-02-25 10:13:24', '2022-02-25 10:13:24');

-- ----------------------------
-- Table structure for cards
-- ----------------------------
DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'openid',
  `name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `idcard` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证号',
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '性别',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cards
-- ----------------------------
INSERT INTO `cards` VALUES ('2', '18812345555', '吴迪', '101010199809091234', '18812346666', 'null', '2022-02-25 14:40:14', '2022-02-25 14:40:30');
INSERT INTO `cards` VALUES ('3', '18812345555', '张超', '101010200012035555', '18812345555', null, '2022-02-25 14:54:35', '2022-02-25 14:54:35');
INSERT INTO `cards` VALUES ('4', '18812340000', '张翠山', '101010198801014444', '18812341111', null, '2022-02-25 15:58:06', '2022-02-25 15:58:06');
INSERT INTO `cards` VALUES ('5', '18812340000', '殷素素', '101010198812345555', '18812342222', null, '2022-02-25 15:58:24', '2022-02-25 15:58:24');

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '城市',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cities
-- ----------------------------
INSERT INTO `cities` VALUES ('1', '北京', '2022-02-25 02:39:53', '2022-02-25 02:39:53');
INSERT INTO `cities` VALUES ('2', '上海', '2022-02-25 03:45:16', '2022-02-25 03:45:16');
INSERT INTO `cities` VALUES ('3', '重庆', '2022-02-25 15:52:50', '2022-02-25 15:52:50');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `avatar` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '性别',
  `idcard` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证号',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'openid',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', '阿斯蒂芬', '123456', '18812345555', null, 'boy', '1010', '北京', '18812345555', '0', '2022-02-25 12:04:44', '2022-02-28 11:04:17');
INSERT INTO `customers` VALUES ('2', '吴超', '123456', '18812340000', null, 'boy', '101010199910108888', '北京朝阳区', '18812340000', '0', '2022-02-25 15:51:35', '2022-02-25 16:11:59');

-- ----------------------------
-- Table structure for departments
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_id` bigint(20) unsigned NOT NULL COMMENT '医院ID',
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `tel` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '科室电话',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of departments
-- ----------------------------
INSERT INTO `departments` VALUES ('1', '1', '妇产科', '010-800001', '2022-02-25 05:03:33', '2022-02-25 05:03:33');
INSERT INTO `departments` VALUES ('2', '1', '肿瘤科', '010', '2022-02-25 05:11:05', '2022-02-25 05:11:05');
INSERT INTO `departments` VALUES ('3', '2', '胃肠科', '18812340001', '2022-02-25 15:54:50', '2022-02-25 15:54:50');
INSERT INTO `departments` VALUES ('4', '2', '儿科', '18812340002', '2022-02-25 15:55:06', '2022-02-25 15:55:06');

-- ----------------------------
-- Table structure for doctors
-- ----------------------------
DROP TABLE IF EXISTS `doctors`;
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` bigint(20) DEFAULT NULL COMMENT '城市ID',
  `hospital_id` bigint(20) unsigned NOT NULL COMMENT '医院ID',
  `department_id` bigint(20) unsigned NOT NULL COMMENT '科室ID',
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `code` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '账号',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `avatar` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '性别',
  `idcard` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证号',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `intro` text COLLATE utf8mb4_unicode_ci COMMENT '简介',
  `counts` int(11) NOT NULL DEFAULT '0' COMMENT '预约人数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of doctors
-- ----------------------------
INSERT INTO `doctors` VALUES ('1', '1', '1', '2', '李斯', 'lisi', '18812345555', '/static/uploads/20220225052451305.jpg', '男', '101010', null, '肿瘤科', '4', '2022-02-25 05:25:04', '2022-02-28 11:02:32');
INSERT INTO `doctors` VALUES ('2', '3', '2', '4', '张无忌', 'wuji', '19901019999', '/static/uploads/20220225155558600.jpg', '男', '110101198812145555', '重庆', '擅长儿科，有三十年从一纪念公演', '2', '2022-02-25 15:56:12', '2022-02-25 16:03:32');
INSERT INTO `doctors` VALUES ('3', '3', '2', '3', '谢逊', 'xiexun', '18812348989', '/static/uploads/20220225160210222.jpg', '男', null, null, '谢逊', '1', '2022-02-25 16:02:16', '2022-02-25 16:02:59');

-- ----------------------------
-- Table structure for forums
-- ----------------------------
DROP TABLE IF EXISTS `forums`;
CREATE TABLE `forums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8mb4_unicode_ci COMMENT '标题',
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '发帖人openid',
  `counts` int(11) NOT NULL DEFAULT '0' COMMENT '参与人数',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of forums
-- ----------------------------
INSERT INTO `forums` VALUES ('1', '这个挂号靠谱嘛', '18812340000', '1', '1', '2022-02-25 15:52:08', '2022-02-25 15:52:29');

-- ----------------------------
-- Table structure for hospitals
-- ----------------------------
DROP TABLE IF EXISTS `hospitals`;
CREATE TABLE `hospitals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` bigint(20) unsigned NOT NULL COMMENT '城市ID',
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `image` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `images` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片集',
  `address` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `tel` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '医院电话',
  `intro` text COLLATE utf8mb4_unicode_ci COMMENT '简介',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of hospitals
-- ----------------------------
INSERT INTO `hospitals` VALUES ('1', '1', '北京协和医院', '/static/uploads/20220225033349883.jpg', '/static/uploads/20220225033349883.jpg', '北京市朝阳区望京西路', '010-987123', '阿斯顿法国红酒看来000', '2022-02-25 03:34:31', '2022-02-25 03:44:41');
INSERT INTO `hospitals` VALUES ('2', '3', '重庆中心医院', '/static/uploads/20220225155353723.jpg', '/static/uploads/20220225155353723.jpg,/static/uploads/20220225155359861.jpg', '重庆市解放碑', '18812347777', '重庆重新一样是一家风场好的医院啦', '2022-02-25 15:54:00', '2022-02-25 15:54:12');

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL DEFAULT '0' COMMENT '留言人ID',
  `to_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复人ID',
  `receive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '接收类型',
  `content` longtext COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES ('1', '2', '1', 'doctor', '好医生', '2022-02-25 16:07:21', '2022-02-25 16:07:21');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2022_02_24_115820_create_hospitals_table', '1');
INSERT INTO `migrations` VALUES ('3', '2022_02_24_115903_create_departments_table', '1');
INSERT INTO `migrations` VALUES ('4', '2022_02_24_120831_create_cards_table', '1');
INSERT INTO `migrations` VALUES ('5', '2022_02_24_133958_create_cities_table', '1');
INSERT INTO `migrations` VALUES ('6', '2022_02_24_134634_create_banners_table', '1');
INSERT INTO `migrations` VALUES ('7', '2022_02_24_143757_create_articles_table', '1');
INSERT INTO `migrations` VALUES ('8', '2022_02_24_143816_create_customers_table', '1');
INSERT INTO `migrations` VALUES ('9', '2022_02_24_143935_create_doctors_table', '1');
INSERT INTO `migrations` VALUES ('10', '2022_02_24_143951_create_forums_table', '1');
INSERT INTO `migrations` VALUES ('11', '2022_02_24_144003_create_messages_table', '1');
INSERT INTO `migrations` VALUES ('12', '2022_02_24_144013_create_orders_table', '1');
INSERT INTO `migrations` VALUES ('13', '2022_02_24_144023_create_plans_table', '1');
INSERT INTO `migrations` VALUES ('14', '2022_02_24_144033_create_questions_table', '1');
INSERT INTO `migrations` VALUES ('15', '2022_02_24_144043_create_questionnaires_table', '1');
INSERT INTO `migrations` VALUES ('16', '2022_02_24_144052_create_replies_table', '1');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'openid',
  `hospital_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL COMMENT '医生ID',
  `plan_id` bigint(20) unsigned NOT NULL COMMENT '医生出诊ID',
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '订单号',
  `card` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '就诊人',
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '订单留言',
  `totals` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '合计',
  `status` int(11) DEFAULT '0' COMMENT '状态',
  `is_pay` int(11) NOT NULL DEFAULT '0' COMMENT '是否支付',
  `sn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '预约号',
  `pay_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付方式',
  `pay_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付时间',
  `pay_money` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付金额',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('2', '18812345555', '1', '1', '1', '1', '2022022514565868143', '张超 / 101010200012035555', '阿斯顿法国红酒看来', '100.00', '2', '1', null, '支付宝支付', '2022-02-25 23:13:51', '100.00', '2022-02-25 14:56:58', '2022-02-25 15:19:34');
INSERT INTO `orders` VALUES ('3', '18812345555', '2', '2', '1', '1', '2022022514565868143', '张超 / 101010200012035555', '阿斯顿法国红酒看来', '100.00', '3', '1', null, '支付宝支付', '2022-02-25 23:13:51', '100.00', '2022-02-25 14:56:58', '2022-02-28 11:01:52');
INSERT INTO `orders` VALUES ('4', '18812340000', '2', '4', '2', '3', '2022022515584824162', '殷素素 / 101010198812345555', '看怀孕', '10.00', '1', '1', null, '银行卡支付', '2022-02-26 00:00:47', '10.00', '2022-02-25 15:58:48', '2022-02-26 00:00:47');
INSERT INTO `orders` VALUES ('5', '18812340000', '2', '3', '3', '4', '2022022516025955531', '张翠山 / 101010198801014444', '阿斯蒂芬', '20.00', '1', '1', null, '支付宝支付', '2022-02-26 00:03:06', '20.00', '2022-02-25 16:02:59', '2022-02-26 00:03:06');
INSERT INTO `orders` VALUES ('6', '18812340000', '2', '4', '2', '2', '2022022516033253758', '张翠山 / 101010198801014444', '请按照', '10.00', '1', '0', 'A001', '微信支付', '2022-02-26 00:03:38', '10.00', '2022-02-25 16:03:32', '2022-02-28 10:52:04');
INSERT INTO `orders` VALUES ('7', '18812340000', '1', '2', '1', '1', '2022022516040387940', '张翠山 / 101010198801014444', '二手车', '100.00', '3', '1', null, '微信支付', '2022-02-26 00:04:09', '100.00', '2022-02-25 16:04:03', '2022-02-28 10:57:14');
INSERT INTO `orders` VALUES ('8', '18812345555', '1', '2', '1', '5', '2022022811023185780', '吴迪 / 101010199809091234', '请按照', '11.00', '1', '1', 'A100', '支付宝支付', '2022-02-28 19:02:39', '11.00', '2022-02-28 11:02:31', '2022-02-28 11:02:51');

-- ----------------------------
-- Table structure for plans
-- ----------------------------
DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL DEFAULT '0' COMMENT '医生ID',
  `date` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '日期',
  `time` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '时间',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of plans
-- ----------------------------
INSERT INTO `plans` VALUES ('1', '1', '2022-02-26', '08:00', '100.00', '0', '2022-02-25 12:17:15', '2022-02-25 16:04:27');
INSERT INTO `plans` VALUES ('2', '2', '2022-02-26', '08:00', '10.00', '1', '2022-02-25 15:57:03', '2022-02-25 16:03:32');
INSERT INTO `plans` VALUES ('3', '2', '2022-02-26', '08:30', '10.00', '1', '2022-02-25 15:57:15', '2022-02-25 15:58:48');
INSERT INTO `plans` VALUES ('4', '3', '2022-02-26', '09:00', '20.00', '1', '2022-02-25 16:02:39', '2022-02-28 10:59:28');
INSERT INTO `plans` VALUES ('5', '1', '2022-02-28', '20:00', '11.00', '1', '2022-02-28 11:02:23', '2022-02-28 11:02:32');
INSERT INTO `plans` VALUES ('6', '1', '2022-03-01', '10:00', '111.00', '0', '2022-02-28 11:04:57', '2022-02-28 11:04:57');

-- ----------------------------
-- Table structure for questionnaires
-- ----------------------------
DROP TABLE IF EXISTS `questionnaires`;
CREATE TABLE `questionnaires` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章标题',
  `counts` int(11) NOT NULL DEFAULT '0' COMMENT '参与人数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of questionnaires
-- ----------------------------

-- ----------------------------
-- Table structure for questions
-- ----------------------------
DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `questionnaire_id` int(11) NOT NULL DEFAULT '0' COMMENT '问卷ID',
  `no` int(11) NOT NULL DEFAULT '0' COMMENT '序号',
  `question` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '题目',
  `optiona` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '选项A',
  `counta` int(11) NOT NULL DEFAULT '0' COMMENT '选型A人数',
  `optionb` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '选项B',
  `countb` int(11) NOT NULL DEFAULT '0' COMMENT '选型B人数',
  `optionc` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '选项C',
  `countc` int(11) NOT NULL DEFAULT '0' COMMENT '选型C人数',
  `optiond` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '选项D',
  `countd` int(11) NOT NULL DEFAULT '0' COMMENT '选型D人数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of questions
-- ----------------------------

-- ----------------------------
-- Table structure for replies
-- ----------------------------
DROP TABLE IF EXISTS `replies`;
CREATE TABLE `replies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL DEFAULT '0' COMMENT '帖子ID',
  `content` longtext COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `from_id` int(11) NOT NULL DEFAULT '0' COMMENT '留言人ID',
  `to_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复人ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of replies
-- ----------------------------
INSERT INTO `replies` VALUES ('1', '1', '挺好的呢', '2', '2', '2022-02-25 15:52:29', '2022-02-25 15:52:29');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin' COMMENT '角色',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '$2y$10$zKQx.lfxVEi0JBUEj02atunBM51DfBCmD6BsF84Ae9Vm1zBWFmKkK', 'admin', 'imPtzVMq7x', '2022-02-24 14:43:45', '2022-02-24 14:43:45');
INSERT INTO `users` VALUES ('2', 'lisi', '$2y$10$9X9K1l72vTE.wGj3TU8zVuUdsJCMWYMA3ySmDbDUMmOueOd9LJ7ky', 'doctor', null, '2022-02-25 05:25:04', '2022-02-25 05:25:04');
INSERT INTO `users` VALUES ('3', 'wuji', '$2y$10$DF2ckc0C/N4isY6UUXWosOZd3ZrbricgzDKhOE7JMQuX3iI4kJJje', 'doctor', null, '2022-02-25 15:56:12', '2022-02-25 15:56:12');
INSERT INTO `users` VALUES ('4', 'xiexun', '$2y$10$U938NVscRw/UqzHH0VK4NOKnI84BMgDNXfB3tLaw2ufdvpgHm5aMS', 'doctor', null, '2022-02-25 16:02:16', '2022-02-25 16:02:16');
