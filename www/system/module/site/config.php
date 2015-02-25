<?php
$config->site->help['sina'] = 'http://www.chanzhi.org/book/chanzhieps/41.html';
$config->site->help['qq']   = 'http://www.chanzhi.org/book/chanzhieps/57.html';

$config->site->editor = new stdclass();
$config->site->editor->setbasic = array('id' => 'pauseTip', 'tools' => 'simple');

global $app;
$config->site->ui = new stdclass();
if($config->multi)  $config->site->ui->customCssFile = $app->getDataRoot() . 'css/' . $config->site->code . '/%s/%s/style.css';
if(!$config->multi) $config->site->ui->customCssFile = $app->getDataRoot() . 'css/%s/%s/style.css';

$config->themeSetting = new stdclass();
$config->themeSetting->primaryColor = '#D1270A' ;
$config->themeSetting->backColor    = '#FFFFFF';
$config->themeSetting->borderRadius = '4px';
$config->themeSetting->fontSize     = '14px';
