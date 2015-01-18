<?php
/**
 * The view file of product category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php 
include '../../../../common/view/header.html.php'; 
include '../../../../common/view/treeview.html.php'; 
js::import($jsRoot . 'mulanshi/slide.js');     
css::import($themeRoot . 'mulanshi/css/lrtk.css');

/* set categoryPath for topNav highlight. */
js::set('path',  $product->path);
js::set('productID', $product->id);
?>
<?php $common->printPositionBar($category, $product);?>
<div class='row'>
  <div class='col-md-12'>
    <div class='article-content'>
      <div style="HEIGHT: 750px; PADDING-TOP: 20px" class="wrap picshow">
        <div id='picarea'>

          <div style="MARGIN: 0px auto; WIDTH: 800px; HEIGHT: 600px; OVERFLOW: hidden">
            <div style="MARGIN: 0px auto; WIDTH: 800px; HEIGHT: 600px; OVERFLOW: hidden" id=bigpicarea>
              <P class=bigbtnPrev><SPAN id=big_play_prev></SPAN></P>
              <?php $i=1; foreach($product->files as $photo): ?>
              <div id=image_xixi-<?php echo $i++; ?>><IMG alt="<?php echo $photo->title;?>" src="<?php echo $photo->largeURL;?>" class='img-thumbnail' />
              <div class='word'>
              <H3><?php echo $photo->title;?></H3></div></div>
              <?php endforeach;?>
              <P class='bigbtnNext'><SPAN id='big_play_next'></SPAN></P>
            </div>
          </div>

          <div id='smallpicarea'>
            <div id='thumbs'>
              <ul>
                <li class="first btnPrev">
                <?php echo html::image( $themeRoot . 'mulanshi/images/left.png', "id='play_prev'"); ?>
                </li>
                <?php $i=1; foreach($product->files as $photo): ?>
                <li class=slideshowitem> <a id=thumb_xixi-<?php echo $i++; ?> href="#"><img src="<?php echo $photo->smallURL;?>" width=90 height=60></a> </li>
                <?php endforeach;?>
                <li class="last btnNext">
                <?php echo html::image( $themeRoot . 'mulanshi/images/right.png', "id='play_next'"); ?>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<script>
<?php
$strr ="";
$i=1;
foreach($product->files as $photo)
{
    $arstr = "xixi-" . $i++;
    if($i==2) 
    {
        $strr ="\"$arstr\"";
    }
    else
    {
        $strr =$strr . "," . "\"$arstr\"";
    }
}
?>
var target = [<?php echo $strr;?>];
</script>
<?php include '../../../../common/view/footer.html.php'; ?>
