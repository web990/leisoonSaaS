/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : leisoonsaas

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2019-10-24 14:23:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yb_admin_action_log
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_action_log`;
CREATE TABLE `yb_admin_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '日志名称',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '模型',
  `controller` varchar(20) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(20) NOT NULL DEFAULT '' COMMENT '操作方法',
  `datatable` varchar(40) NOT NULL DEFAULT '' COMMENT '数据表',
  `method` varchar(20) NOT NULL DEFAULT '' COMMENT '请求类型',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT 'url',
  `content` text NOT NULL COMMENT '访问内容',
  `response_code` varchar(20) NOT NULL DEFAULT '' COMMENT '返回代码',
  `response_type` varchar(40) NOT NULL DEFAULT '' COMMENT '输出类型',
  `response_content` text NOT NULL COMMENT '访问内容',
  `ip` int(11) NOT NULL DEFAULT '0' COMMENT '执行者ip',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT 'path',
  `codetime` decimal(5,3) NOT NULL DEFAULT '0.000' COMMENT '代码执行时间',
  `exectime` decimal(5,3) NOT NULL DEFAULT '0.000' COMMENT '页面执行时间',
  `useragent` varchar(255) NOT NULL DEFAULT '' COMMENT 'User-Agent',
  `referer` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8201 DEFAULT CHARSET=utf8 COMMENT='行为日志表';

-- ----------------------------
-- Records of yb_admin_action_log
-- ----------------------------

-- ----------------------------
-- Table structure for yb_admin_category
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_category`;
CREATE TABLE `yb_admin_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '分类标识',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `list_row` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表每页行数',
  `meta_title` varchar(50) NOT NULL DEFAULT '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL DEFAULT '' COMMENT '频道页模板',
  `template_lists` varchar(100) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `template_detail` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑页模板',
  `ip_valid` varchar(1000) NOT NULL DEFAULT '' COMMENT 'IP白名单',
  `ip_invalid` varchar(1000) NOT NULL DEFAULT '' COMMENT 'IP黑名单',
  `model_id` int(10) NOT NULL DEFAULT '0' COMMENT '列表绑定模型id',
  `model_name` varchar(200) NOT NULL DEFAULT '' COMMENT '模型名称',
  `model_sub` varchar(100) NOT NULL DEFAULT '' COMMENT '子文档绑定模型',
  `type` varchar(100) NOT NULL DEFAULT '' COMMENT '允许发布的内容类型',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `allow_publish` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许发布内容（0不允许1仅允许后台2允许前后台',
  `reply` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许回复',
  `reply_model` varchar(100) NOT NULL DEFAULT '',
  `extend` varchar(2000) NOT NULL DEFAULT '' COMMENT '扩展设置',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL,
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `icon` varchar(255) NOT NULL DEFAULT '0' COMMENT '分类图标',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片id',
  `banner_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'banner_id',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT 'url链接',
  `check` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发布的文章是否需要审核',
  `is_menu` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否导航菜单（1是，0否',
  `is_wap` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否手机栏目（1是，0否',
  `is_paiming` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否参与排名统计（1是，0否',
  `is_qianshou` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否需要签收（1是，0否',
  `list_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '列表类型（0文本，1图片）',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE,
  KEY `uk_name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=134 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of yb_admin_category
-- ----------------------------
INSERT INTO `yb_admin_category` VALUES ('99', '9', 'daishenhe', '待审核信息', '0', '1', '20', '', '', '', '', '', '', '', '', '', '6', '', '', '', '0', '0', '0', '', '', '1562204546', '1564457814', null, '0', '1', '', '0', '0', '', '0', '1', '0', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('102', '9', 'guanyuwoju', '关于我局', '0', '17', '20', '', '', '', '', '', '', '', '', '', '4', '', '', '', '0', '0', '0', '', '', '1562903000', '1563526468', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('103', '9', 'contact', '联系我们', '102', '0', '20', '', '', '', '', '', '', '', '', '', '4', '', '', '', '0', '0', '0', '', '', '1562903017', '1566959466', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('104', '9', 'profile', '公司介绍', '102', '0', '20', '', '', '', '', '', '', '', '', '', '4', '', '', '', '0', '0', '0', '', '', '1562903030', '1566959446', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('120', '9', 'zhuantizhuanlan', '专题专栏', '0', '16', '20', '', '', '', '', '', '', '', '', '', '5', '', '', '', '0', '0', '0', '', '', '1562903410', '1563526468', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('121', '9', 'xinshidai_xindandang_xinzuowei', '新时代 新担当 新作为', '120', '20', '20', '', '', '', '', '', '', '', '', '', '5', '', '', '', '0', '0', '0', '', '', '1562903454', '1565662527', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('124', '9', 'fazhanlicheng', '发展历程', '102', '0', '20', '', '', '', '', '', '', '', '', '', '4', '', '', '', '0', '0', '0', '', '', '1566959511', '1566959573', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('125', '9', 'rongyuzizhi', '荣誉资质', '102', '0', '20', '', '', '', '', '', '', '', '', '', '4', '', '', '', '0', '0', '0', '', '', '1566959522', '1566959563', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('126', '9', 'qiyewenhua', '企业文化', '102', '0', '20', '', '', '', '', '', '', '', '', '', '4', '', '', '', '0', '0', '0', '', '', '1566959548', '1566959548', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('127', '9', 'leisudongtai', '雷速动态', '0', '0', '20', '', '', '', '', '', '', '', '', '', '2', '', '', '', '0', '0', '0', '', '', '1566959850', '1566959850', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('128', '9', 'leisudongtai', '雷速动态', '127', '0', '20', '', '', '', '', '', '', '', '', '', '2', '', '', '', '0', '0', '0', '', '', '1566959866', '1566959866', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('129', '9', 'changjianwenti', '常见问题', '127', '0', '20', '', '', '', '', '', '', '', '', '', '2', '', '', '', '0', '0', '0', '', '', '1566959878', '1566959878', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('130', '9', 'xiazaizhongxin', '下载中心', '127', '0', '20', '', '', '', '', '', '', '', '', '', '2', '', '', '', '0', '0', '0', '', '', '1566959891', '1566959906', null, '0', '1', '', '0', '0', '', '0', '0', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('131', '9', 'hulianwangketang', '互联网课堂', '0', '0', '20', '', '', '', '', '', '', '', '', '', '2', '', '', '', '0', '0', '0', '', '', '1566959991', '1566959991', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('132', '9', 'hulianwang_', '互联网+', '131', '0', '20', '', '', '', '', '', '', '', '', '', '2', '', '', '', '0', '0', '0', '', '', '1566960003', '1566960003', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');
INSERT INTO `yb_admin_category` VALUES ('133', '9', 'xingyeredian', '行业热点', '131', '0', '20', '', '', '', '', '', '', '', '', '', '2', '', '', '', '0', '0', '0', '', '', '1566960020', '1566960020', null, '0', '1', '', '0', '0', '', '0', '1', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for yb_admin_channel
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_channel`;
CREATE TABLE `yb_admin_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '频道ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级频道ID',
  `title` char(40) NOT NULL DEFAULT '' COMMENT '频道标题',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '频道连接',
  `tips` varchar(100) NOT NULL DEFAULT '' COMMENT '频道连接',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `target` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='频道导航';

-- ----------------------------
-- Records of yb_admin_channel
-- ----------------------------
INSERT INTO `yb_admin_channel` VALUES ('1', '9', '0', '网站首页', '/', '', '1', '1379475111', '1565689284', null, '1', '1');
INSERT INTO `yb_admin_channel` VALUES ('4', '9', '0', '关于我们', '/list/103.html', '', '3', '1562899986', '1563265833', null, '1', '0');
INSERT INTO `yb_admin_channel` VALUES ('5', '9', '4', '单位简介', '/list/103.html', '', '1', '1562900005', '1563265670', null, '1', '0');
INSERT INTO `yb_admin_channel` VALUES ('6', '9', '4', '领导简介', '/list/104.html', '', '2', '1562900065', '1563265679', null, '1', '0');
INSERT INTO `yb_admin_channel` VALUES ('7', '9', '0', '走进六安', '/list/101.html', '', '2', '1563265705', '1563265845', null, '1', '0');
INSERT INTO `yb_admin_channel` VALUES ('8', '9', '0', '通知通报', '/list/105.html', '', '4', '1563265737', '1563265845', null, '1', '0');
INSERT INTO `yb_admin_channel` VALUES ('9', '9', '0', '公司新闻', '/list/106.html', '', '5', '1563265758', '1567409846', null, '1', '0');
INSERT INTO `yb_admin_channel` VALUES ('10', '9', '0', '光辉历程', '/list/107.html', '', '6', '1563265782', '1563265846', null, '1', '0');

-- ----------------------------
-- Table structure for yb_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_config`;
CREATE TABLE `yb_admin_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL,
  `type` char(10) NOT NULL DEFAULT '' COMMENT '配置类型',
  `group` tinyint(3) NOT NULL DEFAULT '0' COMMENT '配置分组',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '小图标',
  `value` text NOT NULL COMMENT '配置值',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `type` (`type`) USING BTREE,
  KEY `group` (`group`) USING BTREE,
  KEY `uk_name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yb_admin_config
-- ----------------------------
INSERT INTO `yb_admin_config` VALUES ('1', '9', '1378898976', '1566875847', null, 'string', '1', 'title', '网站标题', '', '网站标题前台显示标题', '', '安徽雷速信息科技有限公司', '1', '2');
INSERT INTO `yb_admin_config` VALUES ('2', '9', '1378898976', '1566875847', null, 'text', '1', 'description', '网站描述', '', '网站搜索引擎描述', '', '安徽雷速信息科技有限公司（www.leisoon.com）为客户提供最全面的互联网应用服务，十年的互联网从业经验为您提供软件定制开发、网站制作、服务器托管、SEO、400电话、微信营销等服务，无论是安徽软件开发还是网站建设我们都会竭诚为您服务,联系我们：0564-3680564', '1', '3');
INSERT INTO `yb_admin_config` VALUES ('3', '9', '1378898976', '1566875847', null, 'text', '1', 'keyword', '网站关键字', '', '网站搜索引擎关键字', '', '六安网站建设 六安网络公司 六安网站开发 六安网站制作 六安软件开发 六安做网站的公司 六安软件定制 六安网页设计 六安手机网站 安徽雷速 六安雷速 雷速科技 雷速网络 软件开发 网站建设 云服务运维', '1', '6');
INSERT INTO `yb_admin_config` VALUES ('4', '9', '1378898976', '1566875847', null, 'select', '1', 'close', '关闭站点', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '', '1', '1', '1');
INSERT INTO `yb_admin_config` VALUES ('9', '9', '1378898976', '1566892715', null, 'array', '4', 'config_type_list', '配置类型列表', '', '主要用于数据解析和页面表单的生成', '', 'text:单行文本:varchar\nstring:字符串:varchar\npassword:密码:varchar\ntextarea:文本框:text\narray:数组:text\nbool:布尔型:tinyint\nselect:选择:varchar\ncheckbox:多选:smallint\nradio:单选:tinyint\nnum:数字:int\nbigint:大数字:bigint\ndecimal:金额:decimal\ntags:标签:varchar\ndatetime:时间控件:int\ndate:日期控件:varchar\neditor:编辑器:text\neditor2:编辑器(专题):text\nbind:模型绑定:int\nimage:图片上传:int\nimage2:图片上传(无压缩):int\nimages:多图上传:varchar\nattach:文件上传:varchar', '1', '5');
INSERT INTO `yb_admin_config` VALUES ('10', '9', '1378900335', '1566875847', null, 'string', '1', 'icp', '网站备案号', '', '设置在网站底部显示的备案号，如“皖ICP备20120015号-1', '', '皖B2-20120015', '1', '7');
INSERT INTO `yb_admin_config` VALUES ('20', '9', '1379228036', '1566892715', null, 'array', '4', 'config_group_list', '配置分组', '', '配置分组', '', '1:基本\n2:内容\n3:用户\n4:系统\n5:短信', '1', '6');
INSERT INTO `yb_admin_config` VALUES ('21', '9', '1379313397', '1566892501', '1566892501', 'array', '4', 'hooks_type', '钩子的类型', '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '', '1:视图\r\n2:控制器', '1', '8');
INSERT INTO `yb_admin_config` VALUES ('22', '9', '1379409310', '1566892523', '1566892523', 'array', '4', 'auth_config', 'Auth配置', '', '自定义Auth.class.php类配置', '', 'AUTH_ON:1\r\nAUTH_TYPE:2', '1', '10');
INSERT INTO `yb_admin_config` VALUES ('23', '9', '1379484332', '1566887104', '1566887104', 'select', '1', 'open_draftbox', '4', '0:关闭草稿功能\n1:开启草稿功能\n', '新增文章时的草稿功能配置', '', '0', '1', '4');
INSERT INTO `yb_admin_config` VALUES ('24', '9', '1379484574', '1566892049', '1566892049', 'num', '1', 'draft_aotosave_interval', '自动保存草稿时间', '', '自动保存草稿的时间间隔，单位：秒', '', '60', '1', '5');
INSERT INTO `yb_admin_config` VALUES ('25', '9', '1379503896', '1566892105', '1566892105', 'num', '1', 'list_rows', '后台每页记录数', '', '后台数据每页显示记录数', '', '10', '1', '8');
INSERT INTO `yb_admin_config` VALUES ('26', '9', '1379504487', '1477727426', null, 'select', '3', 'user_allow_register', '是否允许用户注册', '0:关闭注册\r\n1:允许注册', '是否开放用户注册', '', '0', '1', '11');
INSERT INTO `yb_admin_config` VALUES ('27', '9', '1379814385', '1566892474', '1566892474', 'select', '4', 'codemirror_theme', '预览插件的CodeMirror主题', '3024-day:3024 day\r\n3024-night:3024 night\r\nambiance:ambiance\r\nbase16-dark:base16 dark\r\nbase16-light:base16 light\r\nblackboard:blackboard\r\ncobalt:cobalt\r\neclipse:eclipse\r\nelegant:elegant\r\nerlang-dark:erlang-dark\r\nlesser-dark:lesser-dark\r\nmidnight:midnight', '详情见CodeMirror官网', '', 'ambiance', '1', '5');
INSERT INTO `yb_admin_config` VALUES ('28', '9', '1381482411', '1566892632', '1566892632', 'string', '4', 'data_backup_path', '数据库备份根路径', '', '路径必须以 / 结尾', '', './Data/', '1', '7');
INSERT INTO `yb_admin_config` VALUES ('29', '9', '1381482488', '1566892632', '1566892632', 'num', '4', 'data_backup_part_size', '数据库备份卷大小', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '', '20971520', '1', '9');
INSERT INTO `yb_admin_config` VALUES ('30', '9', '1381713345', '1566892632', '1566892632', 'select', '4', 'data_backup_compress', '数据库备份文件是否启用压缩', '0:不压缩\r\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '', '1', '1', '11');
INSERT INTO `yb_admin_config` VALUES ('31', '9', '1381713408', '1566892632', '1566892632', 'select', '4', 'data_backup_compress_level', '数据库备份文件压缩级别', '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '', '9', '1', '12');
INSERT INTO `yb_admin_config` VALUES ('32', '9', '1383105995', '1566892715', null, 'select', '4', 'develop_mode', '开启开发者模式', '0:关闭\r\n1:开启', '是否开启开发者模式', '', '1', '1', '1');
INSERT INTO `yb_admin_config` VALUES ('33', '9', '1386644047', '1566892715', null, 'array', '4', 'allow_visit', '不受限控制器方法', '', '', '', '0:article/draftbox\n1:article/mydocument\n2:Category/tree\n3:Index/verify\n4:file/upload\n5:file/download\n6:user/updatePassword\n7:user/updateNickname\n8:user/submitPassword\n9:user/submitNickname\n10:file/uploadpicture', '1', '3');
INSERT INTO `yb_admin_config` VALUES ('34', '9', '1386644141', '1566892715', null, 'array', '4', 'deny_visit', '超管专限控制器方法', '', '仅超级管理员可访问的控制器方法', '', '0:Addons/addhook\n1:Addons/edithook\n2:Addons/delhook\n3:Addons/updateHook\n4:Admin/getMenus\n5:Admin/recordList\n6:AuthManager/updateRules\n7:AuthManager/tree', '1', '4');
INSERT INTO `yb_admin_config` VALUES ('35', '9', '1386645376', '1566892100', '1566892100', 'num', '1', 'reply_list_rows', '回复列表每页条数', '', '', '', '10', '1', '13');
INSERT INTO `yb_admin_config` VALUES ('36', '9', '1387165454', '1566892715', null, 'text', '4', 'admin_allow_ip', '后台允许访问IP', '', '多个用逗号分隔，如果不配置表示不限制IP访问', '', '', '1', '7');
INSERT INTO `yb_admin_config` VALUES ('37', '9', '1387165685', '1566892715', null, 'select', '4', 'show_page_trace', '是否显示页面Trace', '0:关闭\r\n1:开启', '是否显示页面Trace信息', '', '1', '1', '2');
INSERT INTO `yb_admin_config` VALUES ('38', '9', '1410762680', '1566875847', null, 'textarea', '1', 'copyright', '底部信息', '', '站点底部信息，支持HTML', '', 'Copyright © Leisoon.com　版权所有：安徽雷速信息科技有限公司&nbsp;经营许可证编号：&nbsp;<a href=\"http://info.0564.tv/icp/\" target=\"_blank\" rel=\"nofollow\">皖B2-20120015</a>&nbsp;&nbsp;&nbsp;&nbsp; <img src=\"/home/img/z-07.png\" height=\"20\" width=\"20\" /> 皖公网安备 34240102120270号', '1', '9');
INSERT INTO `yb_admin_config` VALUES ('39', '9', '1410762736', '1566875847', null, 'textarea', '1', 'count_code', '统计代码', '', '统计代码，如CNZZ站长统计、百度统计等放在这里', '', '<script src=\"http://s87.cnzz.com/stat.php?id=2010486&web_id=2010486&show=pic1\" language=\"JavaScript\"></script>', '1', '10');
INSERT INTO `yb_admin_config` VALUES ('56', '9', '1565688250', '1565688268', '1565688268', '0', '2', '888', '', '', '', '', '', '1', '0');
INSERT INTO `yb_admin_config` VALUES ('43', '9', '1410762883', '1566875847', null, 'string', '1', 'email', '邮箱', '', '联系邮箱', '', '10000#leisoon.com', '1', '11');
INSERT INTO `yb_admin_config` VALUES ('54', '9', '1479539638', '1566875847', null, 'text', '1', 'url', '站点URL', '', '“http://”开头，结尾不要输入斜杠（“/”）', '', 'http://www.d.com', '1', '12');
INSERT INTO `yb_admin_config` VALUES ('55', '9', '1479541398', '1565688294', '1565688294', 'text', '1', 'address', '66', '', '地址', '', '安徽省六安市皋城东路与经三路交叉口六安科技创业服务中心506室', '1', '66');

-- ----------------------------
-- Table structure for yb_admin_department
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_department`;
CREATE TABLE `yb_admin_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `code` bigint(12) NOT NULL DEFAULT '0' COMMENT '编码',
  `pid` bigint(12) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `department_grade_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门等级ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `short` varchar(20) NOT NULL DEFAULT '' COMMENT '简称',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=479 DEFAULT CHARSET=utf8 COMMENT='部门';

-- ----------------------------
-- Records of yb_admin_department
-- ----------------------------
INSERT INTO `yb_admin_department` VALUES ('474', '9', '0', '0', '13', '办公室', '办公室', '0', '', null);
INSERT INTO `yb_admin_department` VALUES ('475', '9', '0', '0', '13', '财务部', '财务部', '0', '', null);
INSERT INTO `yb_admin_department` VALUES ('476', '9', '0', '0', '13', '技术部', '技术部', '0', '', null);
INSERT INTO `yb_admin_department` VALUES ('477', '9', '0', '476', '14', '研发部', '研发部', '0', '', null);
INSERT INTO `yb_admin_department` VALUES ('478', '9', '0', '476', '14', '设计部', '设计部', '0', '', null);

-- ----------------------------
-- Table structure for yb_admin_department_grade
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_department_grade`;
CREATE TABLE `yb_admin_department_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='部门等级';

-- ----------------------------
-- Records of yb_admin_department_grade
-- ----------------------------
INSERT INTO `yb_admin_department_grade` VALUES ('13', '9', '一级部门', '1', null);
INSERT INTO `yb_admin_department_grade` VALUES ('14', '9', '二级部门', '2', null);
INSERT INTO `yb_admin_department_grade` VALUES ('15', '9', '三级部门', '3', null);

-- ----------------------------
-- Table structure for yb_admin_enterprise
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_enterprise`;
CREATE TABLE `yb_admin_enterprise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '企业id',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '父类di',
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '企业名称',
  `email` char(64) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='企业表，租户';

-- ----------------------------
-- Records of yb_admin_enterprise
-- ----------------------------
INSERT INTO `yb_admin_enterprise` VALUES ('1', '9', '0', '企业1', 'web88@qq.com', '13805647119', '1546175946', '1546175946', null, '1');
INSERT INTO `yb_admin_enterprise` VALUES ('2', '9', '0', '企业2', '10000@leisoon.com', '15156488888', '1546175984', '1552031486', null, '1');
INSERT INTO `yb_admin_enterprise` VALUES ('3', '9', '0', '企业3', 'web88@qq.com', '', '1546176062', '1546695747', null, '1');
INSERT INTO `yb_admin_enterprise` VALUES ('4', '9', '3', '企业4', '', '', '1551242312', '1559812573', null, '1');
INSERT INTO `yb_admin_enterprise` VALUES ('5', '9', '0', '企业5', '', '15156482412', '1551667820', '1557988281', null, '2');
INSERT INTO `yb_admin_enterprise` VALUES ('9', '9', '5', '安徽雷速', 'web88@qq.com', '13805647119', '1551669400', '1558071620', null, '1');
INSERT INTO `yb_admin_enterprise` VALUES ('10', '9', '6', '飞讯科技', '123@qq.com', '13805647119', '1551669515', '1567409909', null, '1');

-- ----------------------------
-- Table structure for yb_admin_enterprise_user
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_enterprise_user`;
CREATE TABLE `yb_admin_enterprise_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `enterprise_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `enterprise_user` (`enterprise_id`,`user_id`) USING BTREE,
  KEY `uid` (`enterprise_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yb_admin_enterprise_user
-- ----------------------------
INSERT INTO `yb_admin_enterprise_user` VALUES ('34', '9', '1');
INSERT INTO `yb_admin_enterprise_user` VALUES ('35', '9', '4');
INSERT INTO `yb_admin_enterprise_user` VALUES ('23', '9', '2');
INSERT INTO `yb_admin_enterprise_user` VALUES ('60', '9', '8485579');
INSERT INTO `yb_admin_enterprise_user` VALUES ('67', '10', '8485330');
INSERT INTO `yb_admin_enterprise_user` VALUES ('37', '9', '3');
INSERT INTO `yb_admin_enterprise_user` VALUES ('59', '10', '8485579');
INSERT INTO `yb_admin_enterprise_user` VALUES ('56', '10', '8485072');
INSERT INTO `yb_admin_enterprise_user` VALUES ('57', '10', '8483959');
INSERT INTO `yb_admin_enterprise_user` VALUES ('58', '10', '10');
INSERT INTO `yb_admin_enterprise_user` VALUES ('62', '10', '8485577');
INSERT INTO `yb_admin_enterprise_user` VALUES ('63', '10', '8485578');
INSERT INTO `yb_admin_enterprise_user` VALUES ('66', '10', '8485574');

-- ----------------------------
-- Table structure for yb_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_menu`;
CREATE TABLE `yb_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `type` enum('menu','file') NOT NULL DEFAULT 'file' COMMENT 'menu为菜单,file为权限节点',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名字(路由)',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `jump` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单跳转url',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_menu` tinyint(4) NOT NULL DEFAULT '0' COMMENT '显示为菜单',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT 'icon图标',
  `condition` varchar(255) NOT NULL DEFAULT '' COMMENT '条件',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`pid`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `tenant_menu` (`tenant_id`,`is_menu`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8 COMMENT='后台菜单规则表';

-- ----------------------------
-- Records of yb_admin_menu
-- ----------------------------
INSERT INTO `yb_admin_menu` VALUES ('1', '9', 'file', '0', '/', '首页', '', '1', '1', 'layui-icon-home', '', '1560750347', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('2', '9', 'file', '0', 'admin', '系统设置', '', '2', '1', 'layui-icon-set', '', '1560751175', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('3', '9', 'file', '2', 'menu/index', '菜单管理', 'admin/menu/index', '8', '1', 'layui-icon-menu-fill', '', '1560751232', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('9', '9', 'file', '3', 'menu/batch', '批量快速添加', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('10', '9', 'file', '3', 'menu/sort', '排序', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('11', '9', 'file', '3', 'menu/selectTree', '返回下拉树数据', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('12', '9', 'file', '3', 'menu/add', '新增数据', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('13', '9', 'file', '3', 'menu/del', '删除分类', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('14', '9', 'file', '3', 'menu/edit', '更新数据', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('15', '9', 'file', '3', 'menu/detailed', '详细信息', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('16', '9', 'file', '3', 'menu/multi', '批量更新', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('17', '9', 'file', '3', 'menu/editfield', '字段修改', '', '0', '0', '', '', '1560752545', '1560752545', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('21', '9', 'file', '2', 'enterprise/index', '企业管理', 'admin/enterprise/index', '11', '1', '', '', '1560753697', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('22', '9', 'file', '21', 'enterprise/userAddList', '返回添加用户列表', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('23', '9', 'file', '21', 'enterprise/userList', '返回企业用户列表', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('24', '9', 'file', '21', 'enterprise/userUpdate', '更新用户tenant_id', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('25', '9', 'file', '21', 'enterprise/UserDel', '删除用户tenant_id', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('26', '9', 'file', '21', 'enterprise/add', '新增数据', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('27', '9', 'file', '21', 'enterprise/del', '删除数据', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('28', '9', 'file', '21', 'enterprise/edit', '更新数据', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('29', '9', 'file', '21', 'enterprise/detailed', '详细信息', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('30', '9', 'file', '21', 'enterprise/multi', '批量更新', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('31', '9', 'file', '21', 'enterprise/editfield', '字段修改', '', '0', '0', '', '', '1560753697', '1560753697', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('32', '9', 'file', '50', 'department/index', '部门管理', 'admin/department/index', '0', '1', '', '', '1560753880', '1560754179', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('33', '9', 'file', '32', 'department/sort', '排序', '', '0', '0', '', '', '1560753880', '1560753880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('34', '9', 'file', '32', 'department/selectTree', '返回下拉树数据', '', '0', '0', '', '', '1560753880', '1560753880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('35', '9', 'file', '32', 'department/add', '新增数据', '', '0', '0', '', '', '1560753880', '1560753880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('36', '9', 'file', '32', 'department/del', '删除数据', '', '0', '0', '', '', '1560753880', '1560753880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('37', '9', 'file', '32', 'department/edit', '更新数据', '', '0', '0', '', '', '1560753880', '1560753880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('38', '9', 'file', '32', 'department/detailed', '详细信息', '', '0', '0', '', '', '1560753880', '1560753880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('39', '9', 'file', '32', 'department/multi', '批量更新', '', '0', '0', '', '', '1560753880', '1560753880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('40', '9', 'file', '32', 'department/editfield', '字段修改', '', '0', '0', '', '', '1560753880', '1560753880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('41', '9', 'file', '50', 'departmentgrade/index', '部门等级', 'admin/department_grade/index', '0', '1', '', '', '1560753922', '1560754168', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('42', '9', 'file', '41', 'departmentgrade/sort', '排序', '', '0', '0', '', '', '1560753922', '1560753922', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('43', '9', 'file', '41', 'departmentgrade/selectTree', '返回下拉树数据', '', '0', '0', '', '', '1560753922', '1560753922', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('44', '9', 'file', '41', 'departmentgrade/add', '新增数据', '', '0', '0', '', '', '1560753922', '1560753922', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('45', '9', 'file', '41', 'departmentgrade/del', '删除数据', '', '0', '0', '', '', '1560753922', '1560753922', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('46', '9', 'file', '41', 'departmentgrade/edit', '更新数据', '', '0', '0', '', '', '1560753922', '1560753922', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('47', '9', 'file', '41', 'departmentgrade/detailed', '详细信息', '', '0', '0', '', '', '1560753922', '1560753922', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('48', '9', 'file', '41', 'departmentgrade/multi', '批量更新', '', '0', '0', '', '', '1560753922', '1560753922', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('49', '9', 'file', '41', 'departmentgrade/editfield', '字段修改', '', '0', '0', '', '', '1560753922', '1560753922', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('50', '9', 'file', '2', 'department', '部门管理', '', '4', '1', '', '', '1560754149', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('51', '9', 'file', '2', 'config/index', '配置管理', 'admin/config/index', '9', '1', '', '', '1560754353', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('52', '9', 'file', '51', 'config/getFieldParse', '解析配置信息字段', '', '0', '0', '', '', '1560754353', '1560754353', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('53', '9', 'file', '51', 'config/add', '新增数据', '', '0', '0', '', '', '1560754353', '1560754353', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('54', '9', 'file', '51', 'config/del', '删除数据', '', '0', '0', '', '', '1560754353', '1560754353', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('55', '9', 'file', '51', 'config/edit', '更新数据', '', '0', '0', '', '', '1560754353', '1560754353', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('56', '9', 'file', '51', 'config/detailed', '详细信息', '', '0', '0', '', '', '1560754353', '1560754353', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('57', '9', 'file', '51', 'config/multi', '批量更新', '', '0', '0', '', '', '1560754353', '1560754353', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('58', '9', 'file', '51', 'config/editfield', '字段修改', '', '0', '0', '', '', '1560754353', '1560754353', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('59', '9', 'file', '2', 'role/index', '角色管理', 'admin/role/index', '3', '1', '', '', '1560754397', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('60', '9', 'file', '59', 'role/ruleTree', '返回权限树数据', '', '0', '0', '', '', '1560754397', '1560754397', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('61', '9', 'file', '59', 'role/ruleTreeSave', '保存权限赋值', '', '0', '0', '', '', '1560754397', '1560754397', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('62', '9', 'file', '59', 'role/add', '新增数据', '', '0', '0', '', '', '1560754397', '1560754397', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('63', '9', 'file', '59', 'role/del', '删除数据', '', '0', '0', '', '', '1560754397', '1560754397', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('64', '9', 'file', '59', 'role/edit', '更新数据', '', '0', '0', '', '', '1560754397', '1560754397', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('65', '9', 'file', '59', 'role/detailed', '详细信息', '', '0', '0', '', '', '1560754397', '1560754397', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('66', '9', 'file', '59', 'role/multi', '批量更新', '', '0', '0', '', '', '1560754397', '1560754397', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('67', '9', 'file', '59', 'role/editfield', '字段修改', '', '0', '0', '', '', '1560754397', '1560754397', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('68', '9', 'file', '2', 'type/index', '字典控制器', 'admin/type/index', '10', '1', '', '', '1560754448', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('69', '9', 'file', '68', 'type/getStatus', '返回状态数组（无需登录）', '', '0', '0', '', '', '1560754448', '1560754448', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('70', '9', 'file', '68', 'type/getValue', '返回value=>title类型字典（未用）', '', '0', '0', '', '', '1560754448', '1560754448', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('71', '9', 'file', '68', 'type/sort', '排序', '', '0', '0', '', '', '1560754448', '1560754448', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('72', '9', 'file', '68', 'type/selectTree', '返回下拉树数据', '', '0', '0', '', '', '1560754449', '1560754449', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('73', '9', 'file', '68', 'type/add', '新增数据', '', '0', '0', '', '', '1560754449', '1560754449', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('74', '9', 'file', '68', 'type/del', '删除数据', '', '0', '0', '', '', '1560754449', '1560754449', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('75', '9', 'file', '68', 'type/edit', '更新数据', '', '0', '0', '', '', '1560754449', '1560754449', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('76', '9', 'file', '68', 'type/detailed', '详细信息', '', '0', '0', '', '', '1560754449', '1560754449', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('77', '9', 'file', '68', 'type/multi', '批量更新', '', '0', '0', '', '', '1560754449', '1560754449', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('78', '9', 'file', '68', 'type/editfield', '字段修改', '', '0', '0', '', '', '1560754449', '1560754449', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('79', '9', 'file', '2', 'user/index', '用户管理', 'admin/user/index', '2', '1', '', '', '1560754505', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('80', '9', 'file', '79', 'user/status', '返回用户状态', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('81', '9', 'file', '79', 'user/rolesTree', '返回角色树数据', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('82', '9', 'file', '79', 'user/rolesTreeSave', '保存角色赋值', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('83', '9', 'file', '79', 'user/add', '新增数据', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('84', '9', 'file', '79', 'user/del', '用户关联删除', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('85', '9', 'file', '79', 'user/edit', '用户关联更新', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('86', '9', 'file', '79', 'user/detailed', '详细信息', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('87', '9', 'file', '79', 'user/multi', '批量更新', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('88', '9', 'file', '79', 'user/editfield', '字段修改', '', '0', '0', '', '', '1560754505', '1560754505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('89', '9', 'file', '2', 'Website', '网站配置', 'admin/website/index', '1', '1', '', '', '1560754577', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('90', '9', 'file', '0', 'cms/index', '内容管理', 'cms/index', '0', '1', 'layui-icon-align-left', '', '1560755001', '1562122615', '1562122615', '1');
INSERT INTO `yb_admin_menu` VALUES ('91', '9', 'file', '2', 'category/index', '分类管理', 'admin/category/index', '5', '1', '', '', '1560994308', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('92', '9', 'file', '91', 'category/sort', '排序', '', '0', '0', '', '', '1560994308', '1560994308', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('93', '9', 'file', '91', 'category/selectTree', '返回下拉树数据', '', '0', '0', '', '', '1560994308', '1560994308', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('94', '9', 'file', '91', 'category/add', '新增数据', '', '0', '0', '', '', '1560994308', '1560994308', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('95', '9', 'file', '91', 'category/del', '删除分类', '', '0', '0', '', '', '1560994308', '1560994308', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('96', '9', 'file', '91', 'category/edit', '更新数据', '', '0', '0', '', '', '1560994308', '1560994308', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('97', '9', 'file', '91', 'category/detailed', '详细信息', '', '0', '0', '', '', '1560994308', '1560994308', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('98', '9', 'file', '91', 'category/multi', '批量更新', '', '0', '0', '', '', '1560994308', '1560994308', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('99', '9', 'file', '91', 'category/editfield', '字段修改', '', '0', '0', '', '', '1560994308', '1560994308', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('100', '9', 'file', '2', 'model/index', '系统模型', 'admin/model/index', '6', '1', '', '', '1560994351', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('101', '9', 'file', '100', 'model/add', '新增数据', '', '0', '0', '', '', '1560994351', '1560994351', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('102', '9', 'file', '100', 'model/del', '删除数据', '', '0', '0', '', '', '1560994351', '1560994351', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('103', '9', 'file', '100', 'model/edit', '更新数据', '', '0', '0', '', '', '1560994351', '1560994351', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('104', '9', 'file', '100', 'model/detailed', '详细信息', '', '0', '0', '', '', '1560994351', '1560994351', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('105', '9', 'file', '100', 'model/multi', '批量更新', '', '0', '0', '', '', '1560994351', '1560994351', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('106', '9', 'file', '100', 'model/editfield', '字段修改', '', '0', '0', '', '', '1560994351', '1560994351', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('107', '9', 'file', '0', 'user/index/index', '用户管理', '', '3', '0', '', '', '1562122334', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('108', '9', 'file', '107', 'user/index/getStatus', '返回用户状态', '', '0', '0', '', '', '1562122334', '1562122334', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('109', '9', 'file', '107', 'user/index/save', '用户关联新增、编辑', '', '0', '0', '', '', '1562122334', '1562122334', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('110', '9', 'file', '107', 'user/index/edit', '用户关联更新', '', '0', '0', '', '', '1562122334', '1562122334', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('111', '9', 'file', '107', 'user/index/del', '用户关联删除', '', '0', '0', '', '', '1562122334', '1562122334', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('112', '9', 'file', '107', 'user/index/setpassword', '修改密码', '', '0', '0', '', '', '1562122334', '1562122334', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('113', '9', 'file', '107', 'user/index/session', 'Session 登录信息', '', '0', '0', '', '', '1562122334', '1562122334', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('114', '9', 'file', '107', 'user/index/userinfo', '用户信息', '', '0', '0', '', '', '1562122334', '1562122334', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('115', '9', 'file', '107', 'user/index/userinfoSave', '用户信息保存', '', '0', '0', '', '', '1562122334', '1562122334', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('116', '9', 'file', '0', 'cms/index/index', '内容管理', 'cms/index', '4', '1', 'layui-icon-align-left', '', '1562122563', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('117', '9', 'file', '116', 'cms/index/getStatus', '返回状态', '', '0', '0', '', '', '1562122563', '1562122563', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('118', '9', 'file', '116', 'cms/index/getPosition', '返回、解析推荐位', '', '0', '0', '', '', '1562122563', '1562122563', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('119', '9', 'file', '116', 'cms/index/save', '添加', '', '0', '0', '', '', '1562124952', '1562124952', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('120', '9', 'file', '116', 'cms/index/edit', '修改', '', '0', '0', '', '', '1562124971', '1562124971', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('121', '9', 'file', '116', 'cms/index/del', '删除', '', '0', '0', '', '', '1562124985', '1562124985', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('122', '9', 'file', '116', 'cms/index/detailed', '查看', '', '0', '0', '', '', '1562125028', '1562125028', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('123', '9', 'file', '139', 'link/index/index', '友情链接', '', '0', '1', '', '', '1562553785', '1562553940', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('124', '9', 'file', '123', 'link/index/sort', '排序', '', '0', '0', '', '', '1562553785', '1562553785', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('125', '9', 'file', '123', 'link/index/add', '新增数据', '', '0', '0', '', '', '1562553785', '1562553785', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('126', '9', 'file', '123', 'link/index/del', '删除数据', '', '0', '0', '', '', '1562553785', '1562553785', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('127', '9', 'file', '123', 'link/index/edit', '更新数据', '', '0', '0', '', '', '1562553785', '1562553785', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('128', '9', 'file', '123', 'link/index/detailed', '详细信息', '', '0', '0', '', '', '1562553785', '1562553785', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('129', '9', 'file', '123', 'link/index/multi', '批量更新', '', '0', '0', '', '', '1562553785', '1562553785', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('130', '9', 'file', '123', 'link/index/editfield', '字段修改', '', '0', '0', '', '', '1562553785', '1562553785', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('131', '9', 'file', '139', 'link/type/index', '友情链接分类', '', '0', '1', '', '', '1562553809', '1562553967', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('132', '9', 'file', '131', 'link/type/sort', '排序', '', '0', '0', '', '', '1562553809', '1562553809', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('133', '9', 'file', '131', 'link/type/add', '新增数据', '', '0', '0', '', '', '1562553809', '1562553809', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('134', '9', 'file', '131', 'link/type/del', '删除数据', '', '0', '0', '', '', '1562553809', '1562553809', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('135', '9', 'file', '131', 'link/type/edit', '更新数据', '', '0', '0', '', '', '1562553809', '1562553809', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('136', '9', 'file', '131', 'link/type/detailed', '详细信息', '', '0', '0', '', '', '1562553809', '1562553809', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('137', '9', 'file', '131', 'link/type/multi', '批量更新', '', '0', '0', '', '', '1562553809', '1562553809', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('138', '9', 'file', '131', 'link/type/editfield', '字段修改', '', '0', '0', '', '', '1562553809', '1562553809', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('139', '9', 'file', '0', 'link/index', '友情链接', '', '5', '1', 'layui-icon-link', '', '1562553926', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('140', '9', 'file', '155', 'book/index/index', '留言管理', '', '0', '1', '', '', '1562575965', '1567416399', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('141', '9', 'file', '140', 'book/index/add', '新增数据', '', '0', '0', '', '', '1562575965', '1562575965', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('142', '9', 'file', '140', 'book/index/del', '删除数据', '', '0', '0', '', '', '1562575965', '1562575965', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('143', '9', 'file', '140', 'book/index/edit', '更新数据', '', '0', '0', '', '', '1562575965', '1562575965', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('144', '9', 'file', '140', 'book/index/detailed', '详细信息', '', '0', '0', '', '', '1562575965', '1562575965', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('145', '9', 'file', '140', 'book/index/multi', '批量更新', '', '0', '0', '', '', '1562575965', '1562575965', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('146', '9', 'file', '140', 'book/index/editfield', '字段修改', '', '0', '0', '', '', '1562575965', '1562575965', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('147', '9', 'file', '155', 'book/type/index', '留言分类', '', '0', '1', '', '', '1562575981', '1567416380', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('148', '9', 'file', '147', 'book/type/sort', '排序', '', '0', '0', '', '', '1562575981', '1562575981', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('149', '9', 'file', '147', 'book/type/add', '新增数据', '', '0', '0', '', '', '1562575981', '1562575981', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('150', '9', 'file', '147', 'book/type/del', '删除数据', '', '0', '0', '', '', '1562575981', '1562575981', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('151', '9', 'file', '147', 'book/type/edit', '更新数据', '', '0', '0', '', '', '1562575981', '1562575981', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('152', '9', 'file', '147', 'book/type/detailed', '详细信息', '', '0', '0', '', '', '1562575981', '1562575981', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('153', '9', 'file', '147', 'book/type/multi', '批量更新', '', '0', '0', '', '', '1562575981', '1562575981', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('154', '9', 'file', '147', 'book/type/editfield', '字段修改', '', '0', '0', '', '', '1562575981', '1562575981', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('155', '9', 'file', '0', 'book/index', '留言管理', '', '6', '1', 'layui-icon-carousel', '', '1562576007', '1567416351', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('156', '9', 'file', '0', 'poster/index', '广告管理', '', '7', '1', 'layui-icon-picture-fine', '', '1562742242', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('157', '9', 'file', '156', 'poster/index/index', '广告管理', '', '0', '1', '', '', '1562742385', '1562742400', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('158', '9', 'file', '157', 'poster/index/add', '新增数据', '', '0', '0', '', '', '1562742385', '1562742385', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('159', '9', 'file', '157', 'poster/index/del', '删除数据', '', '0', '0', '', '', '1562742385', '1562742385', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('160', '9', 'file', '157', 'poster/index/edit', '更新数据', '', '0', '0', '', '', '1562742385', '1562742385', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('161', '9', 'file', '157', 'poster/index/detailed', '详细信息', '', '0', '0', '', '', '1562742385', '1562742385', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('162', '9', 'file', '157', 'poster/index/multi', '批量更新', '', '0', '0', '', '', '1562742385', '1562742385', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('163', '9', 'file', '157', 'poster/index/editfield', '字段修改', '', '0', '0', '', '', '1562742385', '1562742385', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('164', '9', 'file', '156', 'poster/poster/index', '广告列表', '', '0', '0', '', '', '1562742452', '1562742462', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('165', '9', 'file', '164', 'poster/poster/add', '新增数据', '', '0', '0', '', '', '1562742452', '1562742452', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('166', '9', 'file', '164', 'poster/poster/del', '删除数据', '', '0', '0', '', '', '1562742452', '1562742452', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('167', '9', 'file', '164', 'poster/poster/edit', '更新数据', '', '0', '0', '', '', '1562742452', '1562742452', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('168', '9', 'file', '164', 'poster/poster/detailed', '详细信息', '', '0', '0', '', '', '1562742452', '1562742452', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('169', '9', 'file', '164', 'poster/poster/multi', '批量更新', '', '0', '0', '', '', '1562742452', '1562742452', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('170', '9', 'file', '164', 'poster/poster/editfield', '字段修改', '', '0', '0', '', '', '1562742452', '1562742452', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('171', '9', 'file', '0', 'zhiban/index', '值班管理', '', '8', '1', 'layui-icon-log', '', '1562894860', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('172', '9', 'file', '171', 'zhiban/index/index', '值班表', '', '0', '1', '', '', '1562894880', '1562894942', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('173', '9', 'file', '172', 'zhiban/index/add', '新增数据', '', '0', '0', '', '', '1562894880', '1562894880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('174', '9', 'file', '172', 'zhiban/index/del', '删除数据', '', '0', '0', '', '', '1562894880', '1562894880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('175', '9', 'file', '172', 'zhiban/index/edit', '更新数据', '', '0', '0', '', '', '1562894880', '1562894880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('176', '9', 'file', '172', 'zhiban/index/detailed', '详细信息', '', '0', '0', '', '', '1562894880', '1562894880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('177', '9', 'file', '172', 'zhiban/index/multi', '批量更新', '', '0', '0', '', '', '1562894880', '1562894880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('178', '9', 'file', '172', 'zhiban/index/editfield', '字段修改', '', '0', '0', '', '', '1562894880', '1562894880', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('179', '9', 'file', '171', 'zhiban/tag/index', '值班标签', '', '0', '1', '', '', '1562894921', '1562894941', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('180', '9', 'file', '179', 'zhiban/tag/getTag', '自动填充插件数据集', '', '0', '0', '', '', '1562894921', '1562894921', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('181', '9', 'file', '179', 'zhiban/tag/add', '新增数据', '', '0', '0', '', '', '1562894921', '1562894921', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('182', '9', 'file', '179', 'zhiban/tag/del', '删除数据', '', '0', '0', '', '', '1562894921', '1562894921', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('183', '9', 'file', '179', 'zhiban/tag/edit', '更新数据', '', '0', '0', '', '', '1562894921', '1562894921', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('184', '9', 'file', '179', 'zhiban/tag/detailed', '详细信息', '', '0', '0', '', '', '1562894921', '1562894921', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('185', '9', 'file', '179', 'zhiban/tag/multi', '批量更新', '', '0', '0', '', '', '1562894921', '1562894921', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('186', '9', 'file', '179', 'zhiban/tag/editfield', '字段修改', '', '0', '0', '', '', '1562894921', '1562894921', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('187', '9', 'file', '2', 'admin/channel/index', '频道导航', '', '7', '1', '', '', '1562900511', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('188', '9', 'file', '187', 'admin/channel/sort', '排序', '', '0', '0', '', '', '1562900511', '1562900511', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('189', '9', 'file', '187', 'admin/channel/selectTree', '返回下拉树数据', '', '0', '0', '', '', '1562900511', '1562900511', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('190', '9', 'file', '187', 'admin/channel/add', '新增数据', '', '0', '0', '', '', '1562900511', '1562900511', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('191', '9', 'file', '187', 'admin/channel/del', '删除数据', '', '0', '0', '', '', '1562900511', '1562900511', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('192', '9', 'file', '187', 'admin/channel/edit', '更新数据', '', '0', '0', '', '', '1562900511', '1562900511', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('193', '9', 'file', '187', 'admin/channel/detailed', '详细信息', '', '0', '0', '', '', '1562900511', '1562900511', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('194', '9', 'file', '187', 'admin/channel/multi', '批量更新', '', '0', '0', '', '', '1562900511', '1562900511', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('195', '9', 'file', '187', 'admin/channel/editfield', '字段修改', '', '0', '0', '', '', '1562900511', '1562900511', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('196', '9', 'file', '171', 'zhiban/file/index', '值班附件', '', '0', '1', '', '', '1563944294', '1563944350', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('197', '9', 'file', '196', 'zhiban/file/add', '新增数据', '', '0', '0', '', '', '1563944294', '1563944294', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('198', '9', 'file', '196', 'zhiban/file/del', '删除数据', '', '0', '0', '', '', '1563944294', '1563944294', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('199', '9', 'file', '196', 'zhiban/file/edit', '更新数据', '', '0', '0', '', '', '1563944294', '1563944294', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('200', '9', 'file', '196', 'zhiban/file/detailed', '详细信息', '', '0', '0', '', '', '1563944294', '1563944294', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('201', '9', 'file', '196', 'zhiban/file/multi', '批量更新', '', '0', '0', '', '', '1563944294', '1563944294', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('202', '9', 'file', '196', 'zhiban/file/editfield', '字段修改', '', '0', '0', '', '', '1563944294', '1563944294', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('203', '9', 'file', '0', 'page/index', '单页管理', '', '9', '1', 'layui-icon-website', '', '1565846663', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('204', '9', 'file', '203', 'page/index/index', '单页管理', '', '0', '1', '', '', '1565846699', '1565846774', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('205', '9', 'file', '204', 'page/index/add', '新增数据', '', '0', '0', '', '', '1565846699', '1565846699', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('206', '9', 'file', '204', 'page/index/del', '删除数据', '', '0', '0', '', '', '1565846699', '1565846699', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('207', '9', 'file', '204', 'page/index/edit', '更新数据', '', '0', '0', '', '', '1565846699', '1565846699', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('208', '9', 'file', '204', 'page/index/detailed', '详细信息', '', '0', '0', '', '', '1565846699', '1565846699', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('209', '9', 'file', '204', 'page/index/multi', '批量更新', '', '0', '0', '', '', '1565846699', '1565846699', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('210', '9', 'file', '204', 'page/index/editfield', '字段修改', '', '0', '0', '', '', '1565846699', '1565846699', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('211', '9', 'file', '203', 'page/type/index', '分类模板', '', '0', '1', '', '', '1565846735', '1565846774', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('212', '9', 'file', '211', 'page/type/sort', '排序', '', '0', '0', '', '', '1565846735', '1565846735', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('213', '9', 'file', '211', 'page/type/selectTree', '返回下拉树数据', '', '0', '0', '', '', '1565846735', '1565846735', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('214', '9', 'file', '211', 'page/type/add', '新增数据', '', '0', '0', '', '', '1565846735', '1565846735', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('215', '9', 'file', '211', 'page/type/del', '删除数据', '', '0', '0', '', '', '1565846735', '1565846735', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('216', '9', 'file', '211', 'page/type/edit', '更新数据', '', '0', '0', '', '', '1565846735', '1565846735', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('217', '9', 'file', '211', 'page/type/detailed', '详细信息', '', '0', '0', '', '', '1565846735', '1565846735', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('218', '9', 'file', '211', 'page/type/multi', '批量更新', '', '0', '0', '', '', '1565846735', '1565846735', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('219', '9', 'file', '211', 'page/type/editfield', '字段修改', '', '0', '0', '', '', '1565846735', '1565846735', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('220', '9', 'file', '0', 'report/index', '文件上报', '', '10', '1', 'layui-icon-upload-circle', '', '1565861488', '1565861684', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('221', '9', 'file', '220', 'report/index/index', '文件上报', '', '10', '1', 'layui-icon-release', '', '1565861505', '1565861678', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('222', '9', 'file', '221', 'report/index/add', '新增数据', '', '0', '0', '', '', '1565861505', '1565861505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('223', '9', 'file', '221', 'report/index/del', '删除数据', '', '0', '0', '', '', '1565861505', '1565861505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('224', '9', 'file', '221', 'report/index/edit', '更新数据', '', '0', '0', '', '', '1565861505', '1565861505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('225', '9', 'file', '221', 'report/index/detailed', '详细信息', '', '0', '0', '', '', '1565861505', '1565861505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('226', '9', 'file', '221', 'report/index/multi', '批量更新', '', '0', '0', '', '', '1565861505', '1565861505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('227', '9', 'file', '221', 'report/index/editfield', '字段修改', '', '0', '0', '', '', '1565861505', '1565861505', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('228', '9', 'file', '2', 'admin/actionlog/index', '系统日志', '', '12', '1', '', '', '1566290575', '1566290685', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('229', '9', 'file', '228', 'admin/actionlog/dellog', '批量删除', '', '0', '0', '', '', '1566290575', '1566290575', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('230', '9', 'file', '228', 'admin/actionlog/add', '新增数据', '', '0', '0', '', '', '1566290575', '1566290575', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('231', '9', 'file', '228', 'admin/actionlog/del', '删除数据', '', '0', '0', '', '', '1566290575', '1566290575', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('232', '9', 'file', '228', 'admin/actionlog/edit', '更新数据', '', '0', '0', '', '', '1566290575', '1566290575', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('233', '9', 'file', '228', 'admin/actionlog/detailed', '详细信息', '', '0', '0', '', '', '1566290575', '1566290575', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('234', '9', 'file', '228', 'admin/actionlog/multi', '批量更新', '', '0', '0', '', '', '1566290575', '1566290575', null, '1');
INSERT INTO `yb_admin_menu` VALUES ('235', '9', 'file', '228', 'admin/actionlog/editfield', '字段修改', '', '0', '0', '', '', '1566290575', '1566290575', null, '1');

-- ----------------------------
-- Table structure for yb_admin_model
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_model`;
CREATE TABLE `yb_admin_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模型标识',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `icon` varchar(20) NOT NULL DEFAULT '' COMMENT '模型图标',
  `relation` varchar(30) NOT NULL DEFAULT '' COMMENT '继承与被继承模型的关联字段',
  `is_user_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否会员中心显示',
  `need_pk` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '新建表时是否需要主键字段',
  `field_sort` text NOT NULL COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '1:基础' COMMENT '字段分组',
  `field_list` text NOT NULL COMMENT '字段列表',
  `attribute_list` text NOT NULL COMMENT '属性列表（表的字段）',
  `attribute_alias` varchar(255) NOT NULL DEFAULT '' COMMENT '属性别名定义',
  `template_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_add` varchar(100) NOT NULL DEFAULT '' COMMENT '新增模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑模板',
  `list_grid` text NOT NULL COMMENT '列表定义',
  `list_row` smallint(2) unsigned NOT NULL DEFAULT '10' COMMENT '列表数据长度',
  `search_key` varchar(50) NOT NULL DEFAULT '' COMMENT '默认搜索字段',
  `search_list` varchar(255) NOT NULL DEFAULT '' COMMENT '高级搜索的字段',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

-- ----------------------------
-- Records of yb_admin_model
-- ----------------------------
INSERT INTO `yb_admin_model` VALUES ('1', '9', 'document', '基础文档', '0', '', '', '0', '1', '{\"1\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\"]}', '1:基础', '', '', '', '', '', '', 'id:编号\r\ntitle:标题:article/edit?cate_id=[category_id]&id=[id]\r\ntype:类型\r\nupdate_time:最后更新\r\nstatus:状态\r\nview:浏览\r\nid:操作:[EDIT]&cate_id=[category_id]|编辑,article/setstatus?status=-1&ids=[id]|删除', '0', '', '', '1383891233', '1384507827', null, '1', 'MyISAM');
INSERT INTO `yb_admin_model` VALUES ('2', '9', 'article', '文章', '1', '', '', '0', '1', '{\"1\":[\"3\",\"12\",\"5\",\"10\",\"24\",\"36\",\"37\",\"34\"],\"2\":[\"35\",\"2\",\"9\",\"13\",\"19\",\"16\",\"17\",\"26\",\"20\",\"14\",\"11\",\"25\"]}', '1:基础,2:扩展', '', '', '', '', '', '', 'id:ID\r\ntitle:标题\r\nuid:发布人\r\ncreate_time:创建时间\r\nupdate_time:更新时间\r\nstatus:状态', '0', '', '', '1383891243', '1478069756', null, '1', 'MyISAM');
INSERT INTO `yb_admin_model` VALUES ('3', '9', 'download', '下载', '1', '', '', '0', '1', '', '1:基础', '', '', '', '', '', '', '', '0', '', '', '1383891252', '1479543119', null, '1', 'MyISAM');
INSERT INTO `yb_admin_model` VALUES ('4', '9', 'page', '单页面', '2', '', '', '1', '1', '{\"1\":[\"40\",\"42\"]}', '1:基础', '', '', '', '', '', '', 'id:ID\r\ntitle:标题\r\nuid:发布人\r\ncreate_time:创建时间\r\nupdate_time:更新时间', '10', '', '', '1479718246', '1480567068', null, '1', 'MyISAM');
INSERT INTO `yb_admin_model` VALUES ('13', '9', 'gongwen', '公文', '0', '', '', '0', '1', '', '1:基础', '', '', '', '', '', '', '', '10', '', '', '1562903181', '1563526187', null, '1', 'MyISAM');
INSERT INTO `yb_admin_model` VALUES ('5', '9', 'topic', '专题', '2', '', '', '1', '1', '\"{\\\"1\\\":[\\\"62\\\",\\\"61\\\",\\\"71\\\"]}\"', '1:基础', '', '', '', '', '', '', 'id:ID\r\ntitle:标题\r\nupdate_time:更新时间', '10', '', '', '1481354707', '1533895937', null, '1', 'MyISAM');
INSERT INTO `yb_admin_model` VALUES ('6', '9', 'shenhe', '审核', '0', '', '', '0', '1', '', '1:基础', '', '', '', '', '', '', '', '10', '', '', '1562204493', '1563526183', null, '1', 'MyISAM');
INSERT INTO `yb_admin_model` VALUES ('14', '9', 'only', '独立页面', '0', '', '', '0', '1', '', '1:基础', '', '', '', '', '', '', '', '10', '', '', '1563526164', '1566788646', '1566788646', '1', 'MyISAM');

-- ----------------------------
-- Table structure for yb_admin_position
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_position`;
CREATE TABLE `yb_admin_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` varchar(10) NOT NULL DEFAULT '' COMMENT '排序',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='职位';

-- ----------------------------
-- Records of yb_admin_position
-- ----------------------------
INSERT INTO `yb_admin_position` VALUES ('1', '9', '驾驶员', '', null);
INSERT INTO `yb_admin_position` VALUES ('2', '9', '押运员', '', null);
INSERT INTO `yb_admin_position` VALUES ('3', '9', '驾押员', '', null);

-- ----------------------------
-- Table structure for yb_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_role`;
CREATE TABLE `yb_admin_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '父组别',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '组类型',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `rules` text NOT NULL COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yb_admin_role
-- ----------------------------
INSERT INTO `yb_admin_role` VALUES ('1', '9', '0', '1', '超级管理员', '系统管理员权限', '*', '1545376305', '1562124739', null, '1');
INSERT INTO `yb_admin_role` VALUES ('2', '9', '0', '1', '管理员', '所有管理权限（除特殊权限）', '1,2,89,79,88,87,86,85,84,83,82,81,80,59,67,66,65,64,63,62,61,60,50,41,49,48,47,46,45,44,43,42,32,40,39,38,37,36,35,34,33,91,99,98,97,96,95,94,93,92,100,106,105,104,103,102,101,187,195,194,193,192,191,190,189,188,3,17,16,15,14,13,12,11,10,9,51,58,57,56,55,54,53,52,68,78,77,76,75,74,73,72,71,70,69,21,31,30,29,28,27,26,25,24,23,22,107,115,114,113,112,111,110,109,108,116,122,121,120,119,118,117,139,131,138,137,136,135,134,133,132,123,130,129,128,127,126,125,124,155,147,154,153,152,151,150,149,148,140,146,145,144,143,142,141,156,164,170,169,168,167,166,165,157,163,162,161,160,159,158,171,196,202,201,200,199,198,197,179,186,185,184,183,182,181,180,172,178,177,176,175,174,173,203,211,219,218,217,216,215,214,213,212,204,210,209,208,207,206,205,220,221,227,226,225,224,223,222', '0', '1565861902', null, '1');
INSERT INTO `yb_admin_role` VALUES ('3', '9', '0', '0', '网站编辑', '网站栏目部分权限', '116,118,117', '1545644315', '1562124646', null, '1');
INSERT INTO `yb_admin_role` VALUES ('4', '9', '0', '0', '公共权限', '所有用户都要选择', '116,118,117,107,115,114,113,112,110,108,2,68,70,69,1', '1545644326', '1562232784', null, '1');
INSERT INTO `yb_admin_role` VALUES ('5', '9', '0', '0', '测试角色', '测试权限', '116,122,121,120,119,118,117,2,91,99,98,97,96,95,94,93,92', '1559702136', '1562125076', null, '1');
INSERT INTO `yb_admin_role` VALUES ('6', '10', '0', '0', '管理员', '', '', '1567415766', '1567415766', null, '1');
INSERT INTO `yb_admin_role` VALUES ('7', '10', '0', '0', '友情链接', '', '', '1567415776', '1567415776', null, '1');

-- ----------------------------
-- Table structure for yb_admin_role_access
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_role_access`;
CREATE TABLE `yb_admin_role_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_group_id` (`uid`,`role_id`) USING BTREE,
  KEY `user_id` (`uid`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yb_admin_role_access
-- ----------------------------
INSERT INTO `yb_admin_role_access` VALUES ('34', '1', '1');
INSERT INTO `yb_admin_role_access` VALUES ('35', '5', '4');
INSERT INTO `yb_admin_role_access` VALUES ('23', '2', '2');
INSERT INTO `yb_admin_role_access` VALUES ('56', '2', '1');
INSERT INTO `yb_admin_role_access` VALUES ('38', '3', '4');
INSERT INTO `yb_admin_role_access` VALUES ('57', '3', '5');
INSERT INTO `yb_admin_role_access` VALUES ('41', '7', '4');
INSERT INTO `yb_admin_role_access` VALUES ('42', '7', '3');
INSERT INTO `yb_admin_role_access` VALUES ('43', '8485330', '5');
INSERT INTO `yb_admin_role_access` VALUES ('47', '8485330', '2');
INSERT INTO `yb_admin_role_access` VALUES ('46', '8485330', '4');
INSERT INTO `yb_admin_role_access` VALUES ('50', '2', '3');
INSERT INTO `yb_admin_role_access` VALUES ('51', '8485579', '5');
INSERT INTO `yb_admin_role_access` VALUES ('52', '8485579', '4');
INSERT INTO `yb_admin_role_access` VALUES ('53', '1', '2');
INSERT INTO `yb_admin_role_access` VALUES ('54', '8485583', '5');
INSERT INTO `yb_admin_role_access` VALUES ('58', '1', '4');
INSERT INTO `yb_admin_role_access` VALUES ('59', '2', '4');
INSERT INTO `yb_admin_role_access` VALUES ('60', '11', '4');
INSERT INTO `yb_admin_role_access` VALUES ('61', '11', '2');
INSERT INTO `yb_admin_role_access` VALUES ('62', '11', '1');

-- ----------------------------
-- Table structure for yb_admin_role_extend
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_role_extend`;
CREATE TABLE `yb_admin_role_extend` (
  `role_id` mediumint(10) unsigned NOT NULL COMMENT '用户id',
  `extend_id` mediumint(8) unsigned NOT NULL COMMENT '扩展表中数据的id',
  `read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '读',
  `add` tinyint(1) NOT NULL DEFAULT '0' COMMENT '添加',
  `edit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '编辑',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  `examine` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '扩展类型标识 1:栏目分类权限;2:模型权限',
  UNIQUE KEY `group_extend_type` (`role_id`,`extend_id`,`type`) USING BTREE,
  KEY `uid` (`role_id`) USING BTREE,
  KEY `group_id` (`extend_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组与分类的对应关系表';

-- ----------------------------
-- Records of yb_admin_role_extend
-- ----------------------------
INSERT INTO `yb_admin_role_extend` VALUES ('2', '121', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '120', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '118', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '117', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '116', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '115', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '114', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '4', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '14', '1', '1', '0', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '13', '1', '1', '0', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '11', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '10', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '6', '1', '1', '0', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '9', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '8', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '5', '1', '1', '0', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '12', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '3', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '2', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '7', '1', '1', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '113', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '112', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '111', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '110', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '109', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '108', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '107', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '106', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '105', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '104', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '103', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '102', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '101', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '2', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '3', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '4', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '10', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '11', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '12', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '5', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '6', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '13', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '14', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '7', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '8', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '9', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '15', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '16', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '17', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '18', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '19', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '20', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '21', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '22', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '23', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '24', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '25', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '26', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '27', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '28', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '29', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '31', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '32', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '33', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '34', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '35', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '45', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '37', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '40', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '49', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '50', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '51', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '44', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '46', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '47', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '48', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '52', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '53', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('3', '54', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('2', '99', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '21', '1', '0', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '22', '1', '0', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '23', '1', '0', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '24', '1', '0', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('5', '25', '1', '0', '1', '0', '0', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '99', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '102', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '103', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '104', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '124', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '125', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '126', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '120', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '121', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '127', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '128', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '129', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '130', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '131', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '132', '1', '1', '1', '1', '1', '1');
INSERT INTO `yb_admin_role_extend` VALUES ('1', '133', '1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for yb_admin_type
-- ----------------------------
DROP TABLE IF EXISTS `yb_admin_type`;
CREATE TABLE `yb_admin_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '名称',
  `value` char(20) NOT NULL DEFAULT '' COMMENT 'value',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '类别ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `group` varchar(50) NOT NULL DEFAULT '' COMMENT '分组',
  `is_dev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1166 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yb_admin_type
-- ----------------------------

-- ----------------------------
-- Table structure for yb_book
-- ----------------------------
DROP TABLE IF EXISTS `yb_book`;
CREATE TABLE `yb_book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `type_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属分类',
  `cover_id` int(10) NOT NULL DEFAULT '0' COMMENT '链接logo，选填',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(40) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(40) NOT NULL DEFAULT '' COMMENT '邮箱',
  `company` varchar(255) NOT NULL DEFAULT '' COMMENT '公司名称',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `remarks` varchar(2000) NOT NULL DEFAULT '' COMMENT '备注',
  `content` text NOT NULL COMMENT '内容',
  `re_content` text NOT NULL COMMENT '回复内容',
  `re_time` int(10) NOT NULL DEFAULT '0' COMMENT '回复时间',
  `re_update_time` int(10) NOT NULL DEFAULT '0' COMMENT '回复更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='留言';

-- ----------------------------
-- Records of yb_book
-- ----------------------------

-- ----------------------------
-- Table structure for yb_book_type
-- ----------------------------
DROP TABLE IF EXISTS `yb_book_type`;
CREATE TABLE `yb_book_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` varchar(10) NOT NULL DEFAULT '' COMMENT '排序',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='留言分类';

-- ----------------------------
-- Records of yb_book_type
-- ----------------------------

-- ----------------------------
-- Table structure for yb_document
-- ----------------------------
DROP TABLE IF EXISTS `yb_document`;
CREATE TABLE `yb_document` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(32) NOT NULL DEFAULT '' COMMENT '同一根节点下标识不重复',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `subtitle` varchar(200) NOT NULL DEFAULT '' COMMENT '副标题',
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '分类id',
  `description` char(140) NOT NULL DEFAULT '' COMMENT '描述',
  `root` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '根节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属ID',
  `model_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '内容类型',
  `position` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '推荐位',
  `istop` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '截至时间',
  `attach` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展统计字段',
  `level` int(10) NOT NULL DEFAULT '0' COMMENT '优先级',
  `bookmark` int(10) NOT NULL DEFAULT '0' COMMENT '收藏数,书签',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `keywords` char(40) NOT NULL DEFAULT '' COMMENT '关键词',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '外链URL',
  `author` char(10) NOT NULL DEFAULT '' COMMENT '作者',
  `source` char(20) NOT NULL DEFAULT '' COMMENT '来源',
  PRIMARY KEY (`id`),
  KEY `search_title` (`title`),
  KEY `s_desc_key` (`title`,`description`,`keywords`)
) ENGINE=InnoDB AUTO_INCREMENT=600 DEFAULT CHARSET=utf8 COMMENT='文档模型基础表';

-- ----------------------------
-- Records of yb_document
-- ----------------------------
INSERT INTO `yb_document` VALUES ('594', '9', '2', '', '安徽雷速信息科技有限公司', '', '133', '安徽雷速信息科技有限公司安徽雷速信息科技有限公司', '0', '0', '2', '2', '5', '0', '0', '0', '118', '1', '0', '0', '0', '0', '0', '0', '0', '1566961991', '1566965873', null, '1', '', '', '张飞', '安徽雷速');
INSERT INTO `yb_document` VALUES ('595', '9', '2', '', '7777777777777777777', '', '132', '7777777777755', '0', '0', '2', '2', '4', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1566965904', '1567472956', null, '1', '', '', '', '');
INSERT INTO `yb_document` VALUES ('596', '9', '2', '', '企业文化', '', '126', '', '0', '0', '4', '2', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1566967062', '1566967067', null, '1', '', '', '', '');
INSERT INTO `yb_document` VALUES ('597', '9', '2', '', '常见问题', '', '129', '', '0', '0', '2', '2', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1567472973', '1567472976', null, '1', '', '', '', '');
INSERT INTO `yb_document` VALUES ('598', '9', '2', '', '雷速动态', '', '128', '', '0', '0', '2', '2', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1567472985', '1567472989', null, '1', '', '', '', '');
INSERT INTO `yb_document` VALUES ('599', '9', '2', '', '新闻中心雷速动态', '', '133', '', '0', '0', '2', '2', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1567473016', '1567473019', null, '1', '', '', '', '');

-- ----------------------------
-- Table structure for yb_document_comment
-- ----------------------------
DROP TABLE IF EXISTS `yb_document_comment`;
CREATE TABLE `yb_document_comment` (
  `doc_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `content` text COMMENT '内容',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  `file_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  PRIMARY KEY (`doc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型下载表';

-- ----------------------------
-- Records of yb_document_comment
-- ----------------------------

-- ----------------------------
-- Table structure for yb_document_content
-- ----------------------------
DROP TABLE IF EXISTS `yb_document_content`;
CREATE TABLE `yb_document_content` (
  `document_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `content` mediumtext NOT NULL COMMENT '文章内容',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档模型文章表';

-- ----------------------------
-- Records of yb_document_content
-- ----------------------------
INSERT INTO `yb_document_content` VALUES ('594', '<p>安徽雷速信息科技有限公司安徽雷速信息科技有限公司</p><p><img src=\"http://a.com/uploads/picture/20190828/a503ac5ac0674d19fdc98a365ca04436.png\" title=\"a503ac5ac0674d19fdc98a365ca04436.png\" alt=\"3png_ico.png\"/></p><p>安徽雷速信息科技有限公司安徽雷速信息科技有限公司安徽雷速信息科技有限公司</p><p><br/></p><p>111<br/></p><p>2227777</p><p><br/></p><p>999</p><p>888</p>', '');
INSERT INTO `yb_document_content` VALUES ('595', '<p>77777777777777</p><p><br/></p><p><img src=\"http://a.com/uploads/picture/20190828/a503ac5ac0674d19fdc98a365ca04436.png\" title=\"a503ac5ac0674d19fdc98a365ca04436.png\" alt=\"3png_ico.png\"/></p><p>555</p><p><br/></p><p>55566665666</p><p><br/></p><p>666</p>', '');
INSERT INTO `yb_document_content` VALUES ('596', '<p>企业文化企业文化企业文化</p>', '');
INSERT INTO `yb_document_content` VALUES ('597', '<p>常见问题</p>', '');
INSERT INTO `yb_document_content` VALUES ('598', '<p>雷速动态</p>', '');
INSERT INTO `yb_document_content` VALUES ('599', '<p>雷速动态雷速动态</p>', '');

-- ----------------------------
-- Table structure for yb_document_qianshou
-- ----------------------------
DROP TABLE IF EXISTS `yb_document_qianshou`;
CREATE TABLE `yb_document_qianshou` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上报ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '接收用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `read_time` int(10) NOT NULL DEFAULT '0' COMMENT '阅读时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='公文签收';

-- ----------------------------
-- Records of yb_document_qianshou
-- ----------------------------

-- ----------------------------
-- Table structure for yb_link
-- ----------------------------
DROP TABLE IF EXISTS `yb_link`;
CREATE TABLE `yb_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `type_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属分类',
  `title` varchar(40) NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `url` varchar(256) NOT NULL DEFAULT '' COMMENT 'url地址，如：http://www.leisoon.com',
  `cover_id` int(10) NOT NULL DEFAULT '0' COMMENT '链接logo，选填',
  `sort` int(8) NOT NULL DEFAULT '0' COMMENT '排序字段',
  `icon` varchar(40) NOT NULL DEFAULT '' COMMENT '图标',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8 COMMENT='友情链接';

-- ----------------------------
-- Records of yb_link
-- ----------------------------
INSERT INTO `yb_link` VALUES ('165', '9', '2', '1566960258', '1566960258', null, '0', '1', '百度', 'http://www.baidu.com', '0', '0', '');
INSERT INTO `yb_link` VALUES ('166', '9', '2', '1566960295', '1566960304', null, '1', '1', '免抠素材', 'http://3png.com', '0', '0', '');

-- ----------------------------
-- Table structure for yb_link_type
-- ----------------------------
DROP TABLE IF EXISTS `yb_link_type`;
CREATE TABLE `yb_link_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` varchar(10) NOT NULL DEFAULT '' COMMENT '排序',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='部门等级';

-- ----------------------------
-- Records of yb_link_type
-- ----------------------------
INSERT INTO `yb_link_type` VALUES ('1', '9', '文字链接', '1', null);
INSERT INTO `yb_link_type` VALUES ('2', '9', '图片连接', '2', null);
INSERT INTO `yb_link_type` VALUES ('3', '9', '合作公司', '3', null);

-- ----------------------------
-- Table structure for yb_notice
-- ----------------------------
DROP TABLE IF EXISTS `yb_notice`;
CREATE TABLE `yb_notice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1驾驶员，2押运员',
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属分类',
  `user_ids` varchar(2000) NOT NULL DEFAULT '' COMMENT '通知用户id',
  `user_name` varchar(2000) NOT NULL DEFAULT '' COMMENT '通知用户用户名（逗号分隔）',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '通知标题',
  `content` text NOT NULL COMMENT '通知内容',
  `send_count` int(10) NOT NULL DEFAULT '0' COMMENT '发送数量',
  `receive_count` int(10) NOT NULL DEFAULT '0' COMMENT '接收数量',
  `read_count` int(10) NOT NULL DEFAULT '0' COMMENT '阅读数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='通知公告';

-- ----------------------------
-- Records of yb_notice
-- ----------------------------

-- ----------------------------
-- Table structure for yb_notice_send
-- ----------------------------
DROP TABLE IF EXISTS `yb_notice_send`;
CREATE TABLE `yb_notice_send` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送者uid',
  `notice_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知内容id',
  `receive_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接收用户uid',
  `read_time` int(10) NOT NULL DEFAULT '0' COMMENT '阅读时间',
  `read` int(10) NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态（1已读）',
  PRIMARY KEY (`id`),
  KEY `aid` (`notice_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10311 DEFAULT CHARSET=utf8 COMMENT='用户发送对应关系表';

-- ----------------------------
-- Records of yb_notice_send
-- ----------------------------

-- ----------------------------
-- Table structure for yb_oss
-- ----------------------------
DROP TABLE IF EXISTS `yb_oss`;
CREATE TABLE `yb_oss` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` varchar(200) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` varchar(200) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `type` char(30) NOT NULL DEFAULT '' COMMENT '类型',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '远程地址',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of yb_oss
-- ----------------------------

-- ----------------------------
-- Table structure for yb_oss_file
-- ----------------------------
DROP TABLE IF EXISTS `yb_oss_file`;
CREATE TABLE `yb_oss_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '远程地址',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of yb_oss_file
-- ----------------------------

-- ----------------------------
-- Table structure for yb_oss_images
-- ----------------------------
DROP TABLE IF EXISTS `yb_oss_images`;
CREATE TABLE `yb_oss_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '远程地址',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of yb_oss_images
-- ----------------------------

-- ----------------------------
-- Table structure for yb_page
-- ----------------------------
DROP TABLE IF EXISTS `yb_page`;
CREATE TABLE `yb_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `type_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属分类',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '名称标题',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '标识',
  `content` mediumtext NOT NULL COMMENT '内容',
  `template` varchar(40) NOT NULL DEFAULT '' COMMENT '模板名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COMMENT='独立页面';

-- ----------------------------
-- Records of yb_page
-- ----------------------------

-- ----------------------------
-- Table structure for yb_page_type
-- ----------------------------
DROP TABLE IF EXISTS `yb_page_type`;
CREATE TABLE `yb_page_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `template` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称',
  `description` varchar(200) NOT NULL DEFAULT '' COMMENT '说明',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='独立页面分类';

-- ----------------------------
-- Records of yb_page_type
-- ----------------------------

-- ----------------------------
-- Table structure for yb_poster
-- ----------------------------
DROP TABLE IF EXISTS `yb_poster`;
CREATE TABLE `yb_poster` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '广告类型（banner/float',
  `space_id` int(10) NOT NULL DEFAULT '0' COMMENT '广告位id',
  `img_id` int(10) NOT NULL DEFAULT '0' COMMENT '图片id',
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `width` smallint(4) NOT NULL DEFAULT '0' COMMENT '宽',
  `height` smallint(4) NOT NULL DEFAULT '0' COMMENT '高',
  `top` smallint(4) NOT NULL DEFAULT '0' COMMENT '顶部距离',
  `left` smallint(4) NOT NULL DEFAULT '0' COMMENT '左侧距离',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='广告海报';

-- ----------------------------
-- Records of yb_poster
-- ----------------------------
INSERT INTO `yb_poster` VALUES ('64', '9', '1', '1563355256', '1563376300', null, '1', '', '64', '57', '对党忠诚 服务人民 执法公正 纪律严明', '', '1160', '90', '0', '0', '1563375294', '0', '');
INSERT INTO `yb_poster` VALUES ('65', '9', '1', '1563355811', '1563414361', null, '1', '', '66', '59', '社会主义核心价值观', '', '0', '0', '0', '0', '1563355806', '0', '');
INSERT INTO `yb_poster` VALUES ('66', '9', '1', '1563378050', '1563413754', null, '0', '', '65', '0', '弹窗网址测试', 'http://baidu.com', '500', '300', '50', '150', '1563378049', '1563464461', '');
INSERT INTO `yb_poster` VALUES ('67', '9', '1', '1563378118', '1563379135', null, '0', '', '65', '0', '弹窗内容测试', '', '300', '300', '50', '50', '1563292800', '0', '弹窗内容测试弹窗内容测试弹窗内容测试弹窗内容测试弹窗内容测试弹窗内容测试2019年7月17日23:41:47');
INSERT INTO `yb_poster` VALUES ('68', '9', '1', '1563378150', '1563413929', null, '1', '', '65', '58', '弹窗图片测试', 'http://3png.com', '500', '450', '100', '100', '0', '0', '');
INSERT INTO `yb_poster` VALUES ('71', '9', '2', '1565675340', '1565675392', null, '1', '', '75', '97', '7777', '777', '6', '0', '0', '0', '0', '0', '');

-- ----------------------------
-- Table structure for yb_poster_space
-- ----------------------------
DROP TABLE IF EXISTS `yb_poster_space`;
CREATE TABLE `yb_poster_space` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `type` char(30) NOT NULL DEFAULT '' COMMENT '广告类型（banner/float',
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '名称',
  `width` smallint(4) NOT NULL DEFAULT '0' COMMENT '宽',
  `height` smallint(4) NOT NULL DEFAULT '0' COMMENT '高',
  `top` smallint(4) NOT NULL DEFAULT '0' COMMENT '顶部距离',
  `left` smallint(4) NOT NULL DEFAULT '0' COMMENT '左侧距离',
  `items` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示数量',
  `description` varchar(200) NOT NULL DEFAULT '' COMMENT '说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COMMENT='广告位空间';

-- ----------------------------
-- Records of yb_poster_space
-- ----------------------------

-- ----------------------------
-- Table structure for yb_poster_template
-- ----------------------------
DROP TABLE IF EXISTS `yb_poster_template`;
CREATE TABLE `yb_poster_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '标识',
  `sort` varchar(10) NOT NULL DEFAULT '' COMMENT '排序',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='留言分类';

-- ----------------------------
-- Records of yb_poster_template
-- ----------------------------
INSERT INTO `yb_poster_template` VALUES ('1', '9', '矩形横幅', 'banner', '1', null);
INSERT INTO `yb_poster_template` VALUES ('2', '9', '固定位置', 'fixure', '2', null);
INSERT INTO `yb_poster_template` VALUES ('3', '9', '漂浮移动', 'float', '3', null);
INSERT INTO `yb_poster_template` VALUES ('4', '9', '文字广告', 'text', '4', null);

-- ----------------------------
-- Table structure for yb_sms
-- ----------------------------
DROP TABLE IF EXISTS `yb_sms`;
CREATE TABLE `yb_sms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属分类',
  `sms_api` varchar(40) NOT NULL DEFAULT '' COMMENT '发送短信接口',
  `template_id` int(10) NOT NULL DEFAULT '0' COMMENT '短信模板id',
  `user_ids` varchar(2000) NOT NULL DEFAULT '' COMMENT '发送用户ids',
  `content` varchar(2000) NOT NULL DEFAULT '' COMMENT '行车途中事项记录',
  `mobile` text NOT NULL COMMENT '发送号码',
  `send_count` int(10) NOT NULL DEFAULT '0' COMMENT '发送条数',
  `success_count` int(10) NOT NULL DEFAULT '0' COMMENT '成功条数',
  `error_count` int(10) NOT NULL DEFAULT '0' COMMENT '错误条数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='短信管理';

-- ----------------------------
-- Records of yb_sms
-- ----------------------------

-- ----------------------------
-- Table structure for yb_sms_log
-- ----------------------------
DROP TABLE IF EXISTS `yb_sms_log`;
CREATE TABLE `yb_sms_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `sms_id` int(10) NOT NULL DEFAULT '0' COMMENT '短信id',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '发送手机号',
  `send_code` varchar(20) NOT NULL DEFAULT '' COMMENT '发送状态',
  `send_msg` varchar(40) NOT NULL DEFAULT '' COMMENT '发送状态',
  `content` varchar(1000) NOT NULL DEFAULT '' COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=982 DEFAULT CHARSET=utf8 COMMENT='短信管理，短信日志';

-- ----------------------------
-- Records of yb_sms_log
-- ----------------------------

-- ----------------------------
-- Table structure for yb_sms_template
-- ----------------------------
DROP TABLE IF EXISTS `yb_sms_template`;
CREATE TABLE `yb_sms_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '模板名称',
  `content` varchar(2000) NOT NULL DEFAULT '' COMMENT '短信模板内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='短信管理，短信模板';

-- ----------------------------
-- Records of yb_sms_template
-- ----------------------------

-- ----------------------------
-- Table structure for yb_user
-- ----------------------------
DROP TABLE IF EXISTS `yb_user`;
CREATE TABLE `yb_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `username` char(32) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `unionid` char(32) NOT NULL DEFAULT '' COMMENT 'unionid',
  `openid` char(32) NOT NULL DEFAULT '' COMMENT 'openid',
  `email` char(32) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户状态',
  `zhiwu_id` int(10) NOT NULL DEFAULT '0' COMMENT '职务id',
  `renzhiqingkuang_id` int(10) NOT NULL DEFAULT '0' COMMENT '任职情况id',
  `jingzhong_id` int(10) NOT NULL DEFAULT '0' COMMENT '警种id',
  `jingxian_id` int(10) NOT NULL DEFAULT '0' COMMENT '警衔id',
  `zhiji_id` int(10) NOT NULL DEFAULT '0' COMMENT '职级id',
  `dept_code` bigint(12) NOT NULL DEFAULT '0' COMMENT '部门编码',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`),
  KEY `openid` (`openid`),
  KEY `unionid` (`unionid`),
  KEY `username_password` (`username`,`password`),
  KEY `email` (`email`),
  KEY `mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户表';

-- ----------------------------
-- Records of yb_user
-- ----------------------------
INSERT INTO `yb_user` VALUES ('1', '9', 'admin', '08da348585b616f2ea61ed1ed2101ab3', '', '', 'web88@qq.com', '18905647110', '1557214153', '2130706433', '1557214153', '2130706433', '1564108742', '1557214153', null, '1', '1143', '1101', '1097', '1041', '1019', '341500390000');

-- ----------------------------
-- Table structure for yb_user_profile
-- ----------------------------
DROP TABLE IF EXISTS `yb_user_profile`;
CREATE TABLE `yb_user_profile` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `tenant_id` int(10) NOT NULL DEFAULT '0' COMMENT '租户ID企业ID',
  `nickname` varchar(40) NOT NULL DEFAULT '' COMMENT '昵称',
  `realname` varchar(10) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '父UID',
  `score` mediumint(8) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否VIP(1年会员,2月会员,3活动会员)',
  `vip_time` int(10) NOT NULL DEFAULT '0' COMMENT 'VIP到期时间',
  `tel` char(20) NOT NULL DEFAULT '' COMMENT '电话办公室',
  `tel_zx` char(20) NOT NULL DEFAULT '' COMMENT '电话专线内线',
  `tel_jwt` char(20) NOT NULL DEFAULT '' COMMENT '电话警务通',
  `tel_exp` char(20) NOT NULL DEFAULT '' COMMENT '备用电话',
  `idcardtype` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1身份证、2护照、3驾驶证',
  `idcard` varchar(32) NOT NULL DEFAULT '' COMMENT '证件号',
  `profession` varchar(50) NOT NULL DEFAULT '' COMMENT '职业',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '邮寄地址',
  `zipcode` varchar(200) NOT NULL DEFAULT '' COMMENT '邮编',
  `nationality` varchar(200) NOT NULL DEFAULT '' COMMENT '国籍',
  `birthprovince` varchar(200) NOT NULL DEFAULT '' COMMENT '出生省份',
  `birthcity` varchar(200) NOT NULL DEFAULT '' COMMENT '出生地',
  `birthdist` varchar(200) NOT NULL DEFAULT '' COMMENT '出生县（出生行政区/县）',
  `birthcommunity` varchar(200) NOT NULL DEFAULT '' COMMENT '出生小区',
  `resideprovince` varchar(255) NOT NULL DEFAULT '' COMMENT '居住省份',
  `residecity` varchar(255) NOT NULL DEFAULT '' COMMENT '居住地',
  `residedist` varchar(255) NOT NULL DEFAULT '' COMMENT '居住县（居住行政区/县）',
  `residecommunity` varchar(255) NOT NULL DEFAULT '' COMMENT '居住小区',
  `residesuite` varchar(255) NOT NULL DEFAULT '' COMMENT '房间（小区、写字楼门牌号',
  `graduateschool` varchar(255) NOT NULL DEFAULT '' COMMENT '毕业学校',
  `education` varchar(255) NOT NULL DEFAULT '' COMMENT '学历',
  `company` varchar(255) NOT NULL DEFAULT '' COMMENT '公司',
  `occupation` varchar(255) NOT NULL DEFAULT '' COMMENT '职业',
  `position` varchar(255) NOT NULL DEFAULT '' COMMENT '职位',
  `revenue` varchar(255) NOT NULL DEFAULT '' COMMENT '年收入（单位 元',
  `affectivestatus` varchar(255) NOT NULL DEFAULT '' COMMENT '情感状态',
  `lookingfor` varchar(255) NOT NULL DEFAULT '' COMMENT '交友目的',
  `bloodtype` varchar(255) NOT NULL DEFAULT '' COMMENT '血型',
  `height` varchar(255) NOT NULL DEFAULT '' COMMENT '身高 单位 cm',
  `weight` varchar(255) NOT NULL DEFAULT '' COMMENT '体重 单位 kg',
  `constellation` varchar(255) NOT NULL DEFAULT '' COMMENT '星座(根据生日自动计算)',
  `zodiac` varchar(255) NOT NULL DEFAULT '' COMMENT '生肖(根据生日自动计算)',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别1男2女',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `qq` char(11) NOT NULL DEFAULT '' COMMENT 'qq号',
  `wechat` char(20) NOT NULL DEFAULT '' COMMENT '微信号',
  `alipay` varchar(255) NOT NULL DEFAULT '' COMMENT '支付宝',
  `bio` varchar(1000) NOT NULL DEFAULT '' COMMENT '自我介绍',
  `interest` varchar(1000) NOT NULL DEFAULT '' COMMENT '兴趣爱好',
  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '城市',
  `country` varchar(30) NOT NULL DEFAULT '' COMMENT '国家',
  `headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像地址',
  `headimg_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户头像id',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `view` int(10) NOT NULL DEFAULT '0' COMMENT '主页总访问量',
  `upload` int(10) NOT NULL DEFAULT '0' COMMENT '总上传数量',
  `download` int(10) NOT NULL DEFAULT '0' COMMENT '总下载量',
  `favor` int(10) NOT NULL DEFAULT '0' COMMENT '总收藏量',
  `bg_download` int(10) NOT NULL DEFAULT '0' COMMENT '背景总下载量',
  `bg_favor` int(10) NOT NULL DEFAULT '0' COMMENT '背景总收藏量',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uid` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员表';

-- ----------------------------
-- Records of yb_user_profile
-- ----------------------------
INSERT INTO `yb_user_profile` VALUES ('1', '9', 'admin', '超级管理员', '0', '146', '0', '0', '321', '12345', '13805647119', '18905647110', '0', '', '', 'B楼506', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '2019-07-26', '', '', '', '', '', '', '', '', '/uploads/picture/20190726/857ffe6a2883262a3d87c2b69007b11b.jpg', '0', '1548641537', '0', null, '0', '0', '0', '0', '0', '0');
