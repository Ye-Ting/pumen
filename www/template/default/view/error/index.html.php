<?php
/**
 * The error view file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     error
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include TPL_ROOT . 'common/header.html.php';?>
<div class='alert alert-danger'>
  <h3><?php echo $lang->error->pageNotFound;?></h3>
  <p><?php echo $this->config->company->desc;?></p>
</div>
<?php $this->fetch('sitemap', 'index', 'onlyBody=yes')?>
<?php include TPL_ROOT . 'common/footer.html.php';?>
