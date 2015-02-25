<?php
/**
 * The featured product front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php 
$content  = json_decode($block->content);
$product  = $this->loadModel('product')->getByID($content->product);
?>
<?php if(!empty($product)):?>
<?php
$category = array_shift($product->categories);
$alias    = !empty($category) ? $category->alias : '';
$url      = helper::createLink('product', 'view', "id={$product->id}", "category={$alias}&name={$product->alias}");
?>
<div id="block<?php echo $block->id;?>" class='panel panel-block <?php echo $blockClass;?>'>
  <div class='panel-body'>
    <a class='card' href="<?php echo $url;?>">
      <div class='media' style='background-image: url(<?php echo $product->image->primary->middleURL; ?>); background-image:none\0;'><?php echo html::image($product->image->primary->middleURL, "title='{$product->name}' alt='{$product->name}'"); ?></div>
      <div class='card-heading'>
        <strong><?php echo $product->name; ?></strong>
        <span class='text-latin'>
        <?php
        if($product->promotion != 0)
        {
            echo "&nbsp;&nbsp;<strong class='text-danger'>" . zget($this->lang->product->currencySymbols, $this->config->product->currency) . $product->promotion . '</strong>';
            if($product->price != 0)
            {
                echo "&nbsp;&nbsp;<del class='text-muted'>" . zget($this->lang->product->currencySymbols, $this->config->product->currency) . $product->price .'</del>';
            }
        }
        else
        {
            if($product->price != 0)
            {
                echo "<span class='text-muted'> " . zget($this->lang->product->currencySymbols, $this->config->product->currency) . "</span> ";
                echo "<strong class='text-important'>" . $product->price . '</strong>&nbsp;&nbsp;';
            }
        }
        ?>
        </span>
      </div>
      <div class='card-content text-muted'><?php echo helper::substr(strip_tags($product->desc), 80);?></div>
    </a>
  </div>
</div>
<?php endif;?>
