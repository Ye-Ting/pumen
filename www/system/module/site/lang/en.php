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
$lang->site->common        = "Site";

$lang->site->type          = 'Type';
$lang->site->status        = 'Status';
$lang->site->pauseTip      = 'Tip for pause site';
$lang->site->name          = 'Name';
$lang->site->module        = 'Modules';
$lang->site->lang          = 'Language';
$lang->site->domain        = 'Domain';
$lang->site->keywords      = 'Site Keywords';
$lang->site->indexKeywords = 'Index Keywords';
$lang->site->meta          = 'Meta';
$lang->site->desc          = 'Description';
$lang->site->icpSN         = 'ICP';
$lang->site->icpLink       = 'ICP Link';
$lang->site->slogan        = 'Slogan';
$lang->site->mission       = 'Mission';
$lang->site->copyright     = 'Copyright';
$lang->site->allowUpload   = 'Allow upload files';
$lang->site->allowedFiles  = 'Allowed file types';

$lang->site->setBasic      = "Baisc";
$lang->site->setUpload     = "Upload";
$lang->site->setRobots     = "Robots";
$lang->site->setOauth      = "Oauth";
$lang->site->setSinaOauth  = "Weibo Oauth";
$lang->site->setQQOauth    = "QQ Oauth";
$lang->site->oauthHelp     = "Help";

$lang->site->typeList = new stdclass();
$lang->site->typeList->portal = 'Portal';
$lang->site->typeList->blog   = 'Blog';

$lang->site->statusList = new stdclass();
$lang->site->statusList->normal = 'Normal';
$lang->site->statusList->pause  = 'Pause';

$lang->site->moduleAvailable = array();
$lang->site->moduleAvailable['user']    = 'Member';
$lang->site->moduleAvailable['forum']   = 'Forum';
$lang->site->moduleAvailable['blog']    = 'Blog';
$lang->site->moduleAvailable['book']    = 'Book';
$lang->site->moduleAvailable['message'] = 'Message';

$lang->site->metaHolder        = 'Tags liek <meta>, <script>, <style>, <link> is accepted.';
$lang->site->fileAllowedRole   = 'Use "," to divide different extension name.';

$lang->site->robots            = 'Robots';
$lang->site->robotsUnwriteable = 'Can not write robots file, please make sure %s writeable first.';
$lang->site->reloadForRobots   = 'Reload this ppage';
$lang->site->defaultTip        = 'Under maintenance.';
