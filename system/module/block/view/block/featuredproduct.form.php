<?php
/**
 * The featured product form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php include '../../common/view/chosen.html.php';?>
<?php $products = $this->loadModel('product')->getPairs(0);?>
<tr>
  <th><?php echo $lang->block->product;?></th>
  <td>
    <div class='row'>
      <div class='col-sm-6'>
        <?php echo html::select('params[product]', $products, isset($block->content->product) ? $block->content->product : '', "class='text-4 form-control'");?></td>
      </div>
    </div>
</tr>
