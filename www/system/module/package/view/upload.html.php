<?php
/**
 * The upload view file of package module of ChanZhiEPS.
 *
 * @copyright   Copyright 2009-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     http://api.chanzhi.org/goto.php?item=license
 * @author      Chunsheng Wang <chunsheng@xirangit.com>
 * @package     package
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php if($canMange['result'] == 'success'):?>
<form method='post' enctype='multipart/form-data' id='uploadForm' action='<?php echo inlink('upload')?>'>
  <div id='responser'></div>
  <div class='input-group'>
    <input type='file' name='file' class='form-control' />
    <div class='input-group-btn'><?php echo html::submitButton($lang->package->install);?></div>
  </div>
</form>
<?php else:?>
<div>
  <?php printf($lang->setOkFile, $canMange['okFile']);?>
  <div class='text-right'><?php echo html::a($this->inlink('upload'), $lang->confirm, "class='btn btn-primary loadInModal'");?></div>
</div>
<?php endif;?>
<?php include '../../common/view/footer.modal.html.php';?>
