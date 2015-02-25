<?php
/**
 * The site module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->site->common        = "站点";

$lang->site->type          = '站点类型';
$lang->site->status        = '站点状态';
$lang->site->pauseTip      = '暂停提示';
$lang->site->name          = '网站名称';
$lang->site->module        = '功能模块';
$lang->site->lang          = '前台语言';
$lang->site->domain        = '网站域名';
$lang->site->keywords      = '关键词';
$lang->site->indexKeywords = '首页关键词';
$lang->site->meta          = 'Meta信息';
$lang->site->desc          = '站点描述';
$lang->site->icpSN         = '备案编号';
$lang->site->icpLink       = '备案链接';
$lang->site->slogan        = '站点口号';
$lang->site->mission       = '站点使命';
$lang->site->copyright     = '创建年份';
$lang->site->allowUpload   = '允许上传附件';
$lang->site->allowedFiles  = '允许附件类型';

$lang->site->setBasic      = "基本信息设置";
$lang->site->setUpload     = "文件上传设置";
$lang->site->setRobots     = "Robots 设置";
$lang->site->setOauth      = "开放登录设置";
$lang->site->setSinaOauth  = "新浪微博接入";
$lang->site->setQQOauth    = "QQ接入";
$lang->site->oauthHelp     = "使用帮助";

$lang->site->typeList = new stdclass();
$lang->site->typeList->portal = '企业门户';
$lang->site->typeList->blog   = '个人博客';

$lang->site->statusList = new stdclass();
$lang->site->statusList->normal = '正常';
$lang->site->statusList->pause  = '暂停';

$lang->site->moduleAvailable = array();
$lang->site->moduleAvailable['user']    = '会员';
$lang->site->moduleAvailable['forum']   = '论坛';
$lang->site->moduleAvailable['blog']    = '博客';
$lang->site->moduleAvailable['book']    = '手册';
$lang->site->moduleAvailable['message'] = '评论留言';

$lang->site->metaHolder        = '可放置<meta><script><style>和<link>标签。';
$lang->site->fileAllowedRole   = '多个后缀名之间请用 "," 隔开';

$lang->site->robots            = 'Robots';
$lang->site->robotsUnwriteable = 'Robots文件%s 不可写，请修改权限后设置。';
$lang->site->reloadForRobots   = '刷新页面';
$lang->site->defaultTip        = '站点维护中……';
