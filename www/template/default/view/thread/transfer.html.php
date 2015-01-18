<?php 
/**
 * The transfer view of thread module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     http://api.chanzhi.org/goto.php?item=license
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     thread 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include TPL_ROOT . 'common/header.modal.html.php';?>
<?php js::set('parents', $parents);?>
<?php js::set('currentBoard', $thread->board);?>
<form id='ajaxForm' class='form-horizontal' action='<?php echo inlink('transfer', "threadID={$thread->id}")?>'  method='post'>
  <div class='form-group'>
    <label for='link' class='col-xs-2 control-label'><?php echo $lang->thread->board;?></label>
    <div class='col-xs-8'>
      <?php echo html::select('targetBoard', $boards, '', "class='form-control chosen'");?>
    </div>
  </div>
  <div class='form-group'>
    <div class='col-xs-2'></div>
    <div class='col-xs-8'>
      <?php echo html::submitButton();?>
    </div>
  </div>
</form>
<?php include TPL_ROOT . 'common/footer.modal.html.php';?>
