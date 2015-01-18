<?php
js::set('objectType', $objectType);
js::set('objectID',   $objectID);
if(isset($pageCSS)) css::internal($pageCSS);
?>
<?php if(isset($comments) and $comments):?>
<div class='panel mgb-0'>
  <div class='panel-heading'>
    <div class='panel-actions'><a href='#commentForm' class='btn btn-primary'><i class='icon-comment-alt'></i> <?php echo $lang->message->post; ?></a></div>
    <strong><i class='icon-comments'></i> <?php echo $lang->message->list;?></strong>
  </div>
</div>
<?php $i = 0;?>
<?php foreach($comments as $number => $comment):?>
<?php $class = $i%2 ? '' : 'success';?>
<div class='comment w-p100 <?php if($i == 0) echo 'first'?>' id="comment<?php echo $comment->id?>">
  <div class='<?php echo $class;?> comment-id'><?php echo $comment->id?></div>
  <table class='table table-borderless w-p100'>
    <tr>
    <th class='th-from'>
      <?php echo $comment->from?><br>
      <span class='time'><?php echo formatTime($comment->date, 'Y/m/d');?> </span>
    </th>
    <td class='td-content'>
      <?php echo nl2br($comment->content);?>
    </td>
    <td class='td-action'> <?php echo html::a($this->createLink('message', 'reply', "commentID=$comment->id"), $lang->comment->reply, "data-toggle='modal' data-type='iframe' data-icon='reply' data-title='{$lang->comment->reply}'");?> </td>
    </tr>
    <?php $this->message->getFrontReplies($comment);?>
  </table>
</div>
<?php $i ++;?>
<?php endforeach;?>
<div class='text-right'>
  <div class='pager clearfix' id='pager'><?php $pager->show('right', 'shortest');?></div>
</div>
<?php endif;?>

<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-comment-alt'></i> <?php echo $lang->message->post;?></strong></div>
  <div class='panel-body'>
    <form method='post' class='form-horizontal' id='commentForm' action="<?php echo $this->createLink('message', 'post', 'type=comment');?>">
      <?php if($this->session->user->account == 'guest'): ?>
      <div class='form-group'>
        <label for='from' class='col-sm-1 control-label'><?php echo $lang->message->from; ?></label>
        <div class='col-sm-5 required'>
          <?php echo html::input('from', '', "class='form-control'"); ?>
        </div>
      </div>
      <div class='form-group'>
        <label for='email' class='col-sm-1 control-label'><?php echo $lang->message->email; ?></label>
        <div class='col-sm-5'>
          <?php echo html::input('email', '', "class='form-control'"); ?>
        </div>
        <div class='col-sm-5'>
          <label class='checkbox'><input type='checkbox' name='receiveEmail' value='1' checked /> <?php echo $lang->comment->receiveEmail; ?></label>
        </div>
      </div>
      <?php else: ?>
      <div class='form-group'>
        <label for='from' class='col-sm-1 control-label'><?php echo $lang->message->from; ?></label>
        <div class='col-sm-11'>
          <span class='signed-user-info'>
            <i class='icon-user text-muted'></i> <strong><?php echo $this->session->user->realname ;?></strong>
            <?php echo html::hidden('from', $this->session->user->realname);?>
            <?php if($this->session->user->email != ''): ?>
            <span class='text-muted'>&nbsp;(<?php echo $this->session->user->email;?>)</span>
            <?php echo html::hidden('email', $this->session->user->email); ?>
            <?php endif; ?>
          </span>
          <label class='checkbox-inline'><input type='checkbox' name='receiveEmail' value='1' checked /> <?php echo $lang->comment->receiveEmail; ?></label>
        </div>
      </div>
      <?php endif; ?>
      <div class='form-group'>
        <label for='content' class='col-sm-1 control-label'><?php echo $lang->message->content; ?></label>
        <div class='col-sm-11 required'>
          <?php
          echo html::textarea('content', '', "class='form-control'");
          echo html::hidden('objectType', $objectType);
          echo html::hidden('objectID', $objectID);
          ?>
        </div>
      </div>
      <div class='form-group hiding' id='captchaBox'></div>
      <div class='form-group'>
        <div class='col-sm-11 col-sm-offset-1'>
          <span><?php echo html::submitButton();?></span>
          <span><small class="text-important"><?php echo $lang->comment->needCheck;?></small></span>
        </div>
      </div>
    </form>
  </div>
</div>
<?php if(isset($pageJS)) js::execute($pageJS);?>
