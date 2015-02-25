<?php
/**
 * The category form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<tr>
  <th><?php echo $lang->block->category->showChildren;?></th>
  <td><?php echo html::radio('params[showChildren]', $lang->block->category->showChildrenList, isset($block->content->showChildren) ? $block->content->showChildren : 'no');?></td>
</tr>
