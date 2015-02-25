<?php
/**                            
 * The favicon view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     site           
 * @version     $Id$           
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-globe'></i> <?php echo $lang->ui->setFavicon;?></strong>
    <?php echo html::a('http://api.chanzhi.org/goto.php?item=help_favicon', "<i class='icon-question-sign'></i> {$lang->ui->favicon->help}", "class='pull-right' target='_blank'");?>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' enctype='multipart/form-data'>
      <table class='table table-form'>
        <tr>
          <?php if(isset($this->config->site->favicon)) echo '<td>' . html::image($favicon->webPath) . '</td>';?>
          <td><input type='file' name='files' id='files' class='form-control'></td>
          <td><?php echo html::submitButton();?><?php if($favicon) echo html::a(inlink('deleteFavicon'), $lang->reset, "class='btn'");?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
