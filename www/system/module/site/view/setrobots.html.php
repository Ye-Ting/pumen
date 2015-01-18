<?php
/**
 * The setupload  view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     http://api.chanzhi.org/goto.php?item=license
 * @author      xiying Guang <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setRobots;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form'>
       <tr>
          <td><?php echo html::textarea('robots', $robots, "rows='4' class='form-control'");?></td>
        </tr>
        <tr>
          <td>
            <?php if($writeable):?>
            <?php echo html::submitButton();?>
            <?php else:?>
            <div class='text-danger'><?php printf($lang->site->robotsUnwriteable, $robotsFile);?>
            <?php echo html::a('javascript:location.reload();', $lang->site->reloadForRobots, "class='btn btn-primary btn-sm'");?>
            </div>
            <?php endif;?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
