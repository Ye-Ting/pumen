<?php
/**
 * The thread module english file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->thread->common    = 'Thread';

$lang->thread->id         = 'Id';
$lang->thread->title      = 'Title';
$lang->thread->board      = 'Board';
$lang->thread->author     = 'Autuor';
$lang->thread->content    = 'Content ';
$lang->thread->file       = 'File ';
$lang->thread->postedDate = 'Posted date';
$lang->thread->replies    = 'Replies';
$lang->thread->views      = 'Views';
$lang->thread->lastReply  = 'Last reply';
$lang->thread->isLink     = 'Locate';
$lang->thread->link       = 'Link';

$lang->thread->post       = 'Post';
$lang->thread->postTo     = 'Post to';
$lang->thread->browse     = 'Threads';
$lang->thread->stick      = 'Sticky';
$lang->thread->edit       = 'Edit';
$lang->thread->status     = 'Status';
$lang->thread->hide       = 'Hide';
$lang->thread->show       = 'Show';
$lang->thread->transfer   = 'Transfer';

$lang->thread->sticks[0] = 'Don\'t stick';
$lang->thread->sticks[1] = 'Stick on board';
$lang->thread->sticks[2] = 'Global stick';

$lang->thread->statusList['hidden'] = 'hidden';
$lang->thread->statusList['normal'] = 'normal';

$lang->thread->confirmDeleteThread = "Are you sure to delete this thread?";
$lang->thread->confirmHideReply    = "Are you sure to hide this reply?";
$lang->thread->confirmHideThread   = "Are you sure to hide this thread?";
$lang->thread->confirmDeleteReply  = "Are you sure to delete this reply?";
$lang->thread->confirmDeleteFile   = "Are you sure to delete this file?";

$lang->thread->lblEdited       = '%s Last edited, %s';
$lang->thread->message         = '%s reply at #%s in forum, the thread is: %s, the content is: %s';
$lang->thread->readonly        = 'Read only';
$lang->thread->successStick    = 'Successfully sticky.';
$lang->thread->successUnstick  = 'Successfully unsticky.';
$lang->thread->successHide     = 'Successfully hide.';
$lang->thread->successShow     = 'Successfully show.';
$lang->thread->readonlyMessage = 'The thread has been set <strong>READONLY</strong>，you can not post new reply。';
$lang->thread->successTransfer = 'Successfully Transfered';

$lang->thread->placeholder = new stdclass();
$lang->thread->placeholder->link = 'Input link, it can be outer chain.';

/* Adjust the pager. */
if(!isset($lang->pager->settedInForum))
{
    $lang->pager->noRecord = '';
    $lang->pager->digest   = str_replace('records', 'replies', $lang->pager->digest);
}
