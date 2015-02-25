<?php
/**
 * The nav config file of chanzhiEPS. 
 * 
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan
 * @package     nav
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$config->nav->system = new stdclass();

$config->nav->system->home    = $config->webRoot;
$config->nav->system->company = commonModel::createFrontLink('company', 'index');
$config->nav->system->forum   = commonModel::createFrontLink('forum', 'index');
$config->nav->system->blog    = commonModel::createFrontLink('blog', 'index');
$config->nav->system->book    = commonModel::createFrontLink('book', 'index');
$config->nav->system->message = commonModel::createFrontLink('message', 'index');
