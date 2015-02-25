<?php
/**
 * The set js view file of product module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php include '../../common/view/codeeditor.html.php';?>
<form id='ajaxForm' action="<?php echo inlink('setjs', "productID=$product->id");?>" method='post'>
  <table class="table table-form">
    <tr><td><?php echo html::textarea('js', $product->js, "rows=5 class='form-control codeeditor' data-mode='javascript' data-height='300px'");?></td></tr>
    <tr><td><div class='editor-actions'><?php echo html::submitButton();?></div></td></tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
