<?php include '../../common/view/header.modal.html.php';?>
<?php if(!$hasPriv):?>
<div class='alert alert-danger'>
  <div>
    <?php echo $errors;?>
    <span class='pull-right'><?php echo html::a($this->inlink('customtheme', "theme={$theme}&template={$template}"), $lang->ui->template->reload, "class='btn btn-primary loadInModal'");?></span>
  </div>
</div>
<?php else:?>
<form method='post' action='<?php echo inlink('customtheme', "theme={$theme}&template={$template}");?>' id='customThemeForm' class='form' data-theme='<?php echo $theme?>' data-template='<?php echo $template?>'>
  <ul class='nav nav-tabs'>
    <?php foreach($lang->ui->groups as $group => $name):?>
    <li><?php echo html::a('#' . $group . 'Tab', $name, "data-toggle='tab' class='theme-control-tab'");?></li>
    <?php endforeach;?>

    <li class='pull-right text-right w-150px'><button type='button' id='resetTheme' class='btn btn-link btn-sm text-danger' data-success-tip='<?php echo $lang->ui->theme->resetTip?>'><?php echo $lang->ui->theme->reset?></button></li>
  </ul>
  <div class='tab-content'>
    <?php foreach($lang->ui->groups as $group => $name):?>
    <div class='tab-pane theme-control-tab-pane' id='<?php echo $group?>Tab'>
      <table class='table table-form borderless'>
        <?php
        $options = isset($config->ui->themes[$theme][$group]) ? $config->ui->themes[$theme][$group] : '';
        if($options) foreach($options as $selector => $attributes):
        ?>
        <tr class='theme-control-group'>
          <th><?php echo $lang->ui->{$selector};?></th>
          <td>
            <div class='row'>
              <?php foreach($attributes as $label => $params):?>
              <?php $value = isset($setting[$params['name']]) ? $setting[$params['name']] : '';?>
              <div class='col-sm-3'><?php $this->ui->printFormControl($label, $params, $value);?></div>
              <?php endforeach;?>
            </div>
          </td>
        </tr>
        <?php endforeach;?>
      </table>
    </div>
    <?php endforeach;?>
  </div>
  <div class="form-footer">
    <?php echo html::hidden('theme', $theme) . html::hidden('template', $template) . html::submitButton();?>
  </div>
</form>
<?php endif;?>
<?php include '../../common/view/footer.modal.html.php';?>
