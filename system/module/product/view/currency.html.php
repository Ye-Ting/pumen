<?php
/**
 * The currency view file of product module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     http://api.chanzhi.org/goto.php?item=license
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<form id='ajaxForm' action="<?php echo inlink('currency');?>" method='post'>
  <table class="table table-form">
    <tr>
      <td><?php echo html::radio('currency', $lang->product->currencyList, isset($config->product->currency) ? $config->product->currency : '');?></td>
    </tr>
    <tr>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
