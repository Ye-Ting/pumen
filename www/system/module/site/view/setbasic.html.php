<?php
/**
 * The setbasic view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      xiying Guang <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setBasic;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='col-xs-2'><?php echo $lang->site->status;?></th> 
          <td class='col-xs-6'><?php echo html::radio('status', $lang->site->statusList, isset($this->config->site->status) ? $this->config->site->status : 'normal', "class='checkbox'");?></td><td></td>
        </tr>
        <?php $class = $this->config->site->status == 'pause' ? '' : 'hide';?>
        <tr class="pauseTip <?php echo $class?>">
          <th><?php echo $lang->site->pauseTip;?></th> 
          <td><?php echo html::textarea('pauseTip', !empty($this->config->site->pauseTip) ? $this->config->site->pauseTip : $lang->site->defaultTip);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->type;?></th> 
          <td><?php echo html::radio('type', $lang->site->typeList, isset($this->config->site->type) ? $this->config->site->type : 'portal', "class='checkbox'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->name;?></th> 
          <td><?php echo html::input('name', $this->config->site->name, "class='form-control'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->module;?></th>
          <td><?php echo html::checkbox('modules', $lang->site->moduleAvailable, isset($this->config->site->modules) ? $this->config->site->modules : '');?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->lang;?></th>
          <td><?php echo html::select('lang', $config->langs, isset($this->config->site->lang) ? $this->config->site->lang : 'zh-cn', "class='form-control chosen'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->copyright;?></th> 
          <td><?php echo html::input('copyright', $this->config->site->copyright, "class='form-control'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->keywords;?></th> 
          <td colspan='2'><?php echo html::input('keywords', $this->config->site->keywords, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->indexKeywords;?></th> 
          <td colspan='2'><?php echo html::input('indexKeywords', $this->config->site->indexKeywords, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->slogan;?></th> 
          <td colspan='2'><?php echo html::input('slogan', $this->config->site->slogan, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->meta;?></th> 
          <td colspan='2'><?php echo html::textarea('meta', htmlspecialchars($this->config->site->meta), "placeholder='{$lang->site->metaHolder}' class='form-control' rows=3");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->desc;?></th> 
          <td colspan='2'><?php echo html::textarea('desc', htmlspecialchars($this->config->site->desc), "class='form-control' rows='3'");?></td> 
        </tr>
       <tr class='icpSN'>
          <th><?php echo $lang->site->icpSN;?></th> 
          <td colspan='2'>
            <div class='row'>
              <div class='col-sm-3'><?php echo html::input('icpSN', $this->config->site->icpSN, "class='form-control col-xs-2'");?></div>
              <div class='col-sm-9'>
                <div class='input-group'>
                  <span class="input-group-addon"><?php echo $lang->site->icpLink;?></span>
                  <?php echo html::input('icpLink', isset($this->config->site->icpLink) ? $this->config->site->icpLink : 'http://www.miitbeian.gov.cn', "class='form-control'")?>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'>
            <?php echo html::submitButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
