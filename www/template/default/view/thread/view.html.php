<?php
/**
 * The view file of thread module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
include TPL_ROOT . 'common/header.html.php';
include TPL_ROOT . 'common/kindeditor.html.php';

echo "<div class='row focus-top' data-default-grid='4'>";
$this->block->printRegion($layouts, 'thread_view', 'top', true);
echo "</div>";

$common->printPositionBar($board, $thread);

if($pager->pageID == 1) include TPL_ROOT . 'thread/thread.html.php';
include TPL_ROOT . 'thread/reply.html.php';

$this->block->printRegion($layouts, 'thread_view', 'bottom');

include TPL_ROOT . 'common/footer.html.php';
