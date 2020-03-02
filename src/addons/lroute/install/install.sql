DROP TABLE IF EXISTS `pre__lroute`;
CREATE TABLE `pre__lroute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '所属模块',
  `type` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '规则类型',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '规则名称',
  `rule` text CHARACTER SET utf8mb4 COMMENT '路由规则',
  `route` text COLLATE utf8mb4_unicode_ci COMMENT '路由地址',
  `method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '请求类型',
  `option` text COLLATE utf8mb4_unicode_ci COMMENT '路由参数',
  `pattern` text COLLATE utf8mb4_unicode_ci COMMENT '变量规则',
  `domain` text COLLATE utf8mb4_unicode_ci COMMENT '子域名',
  `template` text COLLATE utf8mb4_unicode_ci COMMENT '路由模板地址',
  `template_vars` text CHARACTER SET utf8mb4 COMMENT '模版变量',
  `redirect_status` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '跳转状态码',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT '规则描述',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `edit_time` int(10) DEFAULT '0' COMMENT '编辑时间',
  `edit_ip` varchar(25) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '编辑IP',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(25) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='路由定义';
