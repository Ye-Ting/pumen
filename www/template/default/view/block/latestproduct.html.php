<?php
/**
 * The hot product front view file of block module of chanzhiEPS.
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
$type     = str_replace('product', '', strtolower($block->type));
$method   = 'get' . $type;
if(empty($content->category)) $content->category = 0;
$products = $this->loadModel('product')->$method($content->category, $content->limit);
?>
<div id="block<?php echo $block->id;?>" class="panel-cards panel panel-block <?php echo $blockClass;?>">
  <div class='panel-heading'>
    <strong><?php echo $icon;?> <?php echo $block->title;?></strong>
    <?php if(!empty($content->moreText) and !empty($content->moreUrl)):?>
    <div class='pull-right'><?php echo html::a($content->moreUrl, $content->moreText);?></div>
    <?php endif;?>
  </div>
  <?php if(isset($content->image)):?>
  <div class='panel-body'>
    <div class='cards cards-borderless'>
      <?php foreach($products as $product):?>
      <?php 
      $url = helper::createLink('product', 'view', "id=$product->id", "category={$product->category->alias}&name=$product->alias");
      ?>
      <?php if(!empty($product->image)): ?>
      <div class='col-md-12'>
        <a class='card' href="<?php echo $url;?>">
          <?php $title = $product->image->primary->title ? $product->image->primary->title : $product->name;?>
          <div class='media' style='background-image: url(<?php echo $product->image->primary->middleURL; ?>); background-image:none\0;'><?php echo html::image($product->image->primary->middleURL, "title='{$title}' alt='{$product->name}'"); ?></div>
          <div class='card-heading'>
            <?php echo $product->name;?>
            <span class='text-latin'>
            <?php
            if($product->promotion != 0)
            {
                echo "&nbsp;&nbsp;";
                echo "<strong class='text-danger'>" . zget($this->lang->product->currencySymbols, $this->config->product->currency) . $product->promotion . '</strong>';
            }
            else
            {
                if($product->price != 0)
                {
                    echo "<strong class='text-danger'>" . zget($this->lang->product->currencySymbols, $this->config->product->currency) . $product->price . '</strong>';
                }
            }
            ?>
            </span>
          </div>
        </a>
      </div>
      <?php endif;?>
      <?php endforeach;?>
    </div>
  </div>
  <?php else:?>
  <div class='panel-body'>
    <ul class='ul-list'>
      <?php 
      foreach($products as $product):
      $url = helper::createLink('product', 'view', "id=$product->id", "category={$product->category->alias}&name=$product->alias");
      ?>
      <li>
        <span class='text-latin pull-right'>
        <?php
        if($product->promotion != 0)
        {
            if($product->price != 0)
            {
                echo "<small class='text-muted'>" . zget($this->lang->product->currencySymbols, $this->config->product->currency) . "</small> ";
                echo "<del><small class='text-muted'>" . $product->price . "</small></del>";
            }
            echo "&nbsp; <small class='text-muted'>" . zget($this->lang->product->currencySymbols, $this->config->product->currency) . "</small> ";
            echo "<strong class='text-danger'>" . $product->promotion . "</strong>";
        }
        else if($product->price != 0)
        {
            echo "&nbsp; <small class='text-muted'>" . zget($this->lang->product->currencySymbols, $this->config->product->currency) . "</small> ";
            echo "<strong class='text-important'>" . $product->price . "</strong>";
        }
        ?>
        </span>
        <?php echo html::a($url, $product->name);?>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
  <?php endif;?>
</div>
