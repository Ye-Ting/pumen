<?php
/**
 * The site module zh-tw file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->site->common        = "站點";

$lang->site->type          = '站點類型';
$lang->site->status        = '站點狀態';
$lang->site->pauseTip      = '暫停提示';
$lang->site->name          = '網站名稱';
$lang->site->module        = '功能模組';
$lang->site->lang          = '前台語言';
$lang->site->domain        = '網站域名';
$lang->site->keywords      = '關鍵詞';
$lang->site->indexKeywords = '首頁關鍵詞';
$lang->site->meta          = 'Meta信息';
$lang->site->desc          = '站點描述';
$lang->site->icpSN         = '備案編號';
$lang->site->icpLink       = '備案連結';
$lang->site->slogan        = '站點口號';
$lang->site->mission       = '站點使命';
$lang->site->copyright     = '創建年份';
$lang->site->allowUpload   = '允許上傳附件';
$lang->site->allowedFiles  = '允許附件類型';

$lang->site->setBasic      = "基本信息設置";
$lang->site->setUpload     = "檔案上傳設置";
$lang->site->setRobots     = "Robots 設置";
$lang->site->setOauth      = "開放登錄設置";
$lang->site->setSinaOauth  = "新浪微博接入";
$lang->site->setQQOauth    = "QQ接入";
$lang->site->oauthHelp     = "使用幫助";

$lang->site->typeList = new stdclass();
$lang->site->typeList->portal = '企業門戶';
$lang->site->typeList->blog   = '個人博客';

$lang->site->statusList = new stdclass();
$lang->site->statusList->normal = '正常';
$lang->site->statusList->pause  = '暫停';

$lang->site->moduleAvailable = array();
$lang->site->moduleAvailable['user']    = '會員';
$lang->site->moduleAvailable['forum']   = '論壇';
$lang->site->moduleAvailable['blog']    = '博客';
$lang->site->moduleAvailable['book']    = '手冊';
$lang->site->moduleAvailable['message'] = '評論留言';

$lang->site->metaHolder        = '可放置<meta><script><style>和<link>標籤。';
$lang->site->fileAllowedRole   = '多個尾碼名之間請用 "," 隔開';

$lang->site->robots            = 'Robots';
$lang->site->robotsUnwriteable = 'Robots檔案%s 不可寫，請修改權限後設置。';
$lang->site->reloadForRobots   = '刷新頁面';
$lang->site->defaultTip        = '站點維護中……';
