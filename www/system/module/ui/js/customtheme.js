$(document).ready(function()
{
    $.setAjaxForm('#customThemeForm');

    if($('.btn-reload').size() == 0) ajustModalSize();
    $.setAjaxLoader('.loadInModal', '#ajaxModal');

    var $form = $('#customThemeForm');
    var $css = $('#css');

    $css.height($form.height());

    $('[data-toggle="tooltip"]').tooltip({container: '#ajaxModal'});

    tempColor = new Color();
    $('.color').each(function()
    {
        var $this = $(this);
        var c = $this.attr('data');
        if(!c) return;
        var cc = new Color(c).contrast().toCssStr();

        var $inputColor = ($this.hasClass('input-group') ? $this.find('.input-group-btn .dropdown-toggle') : $this).css({'background': c === 'transparent' ? '' : c, 'color': cc}).find('.caret').css('border-top-color', cc).closest('.input-group').find('.input-color');
        if(!$inputColor.attr('placeholder'))
        {
            $inputColor.attr('placeholder', c);
        }
    }).click(function()
    {
        var $this = $(this);
        if($this.hasClass('input-group')) return;
        var $plate = $this.closest('.colorplate');
        $plate.find('.color.active').removeClass('active');
        if($this.hasClass('color-tile')) $plate.find('.input-color').val($this.attr('data')).change();
        $this.addClass('active');
    });

    $('.input-color').on('keyup change.color', function()
    {
        var $this = $(this);
        var val = $this.val();

        $this.closest('.colorplate').find('.color.active').removeClass('active');

        if(tempColor.isColor(val))
        {
            var ic = (new Color(val)).contrast().toCssStr();
            $this.attr('placeholder', val).closest('.color').removeClass('error').find('.input-group-btn .dropdown-toggle').css({'background': val, 'color': ic}).find('.caret').css('border-top-color', ic);;
        }
        else
        {
            $this.closest('.color').addClass('error');
        }
    });

    $('.input-group-textbox-couple input[data-target]').on('keyup change', function()
    {
        var $this = $(this);
        var name = $this.data('target');
        $('#' + name).val($('[data-sid="' + name + '-1"]').val() + ' ' + $('[data-sid="' + name + '-2"]').val());
    });

    $('#ajaxModal .modal-dialog').resize(ajustModalSize);

    // Hide tabs
    $('.theme-control-tab-pane').each(function()
    {
        $pane = $(this);
        if(!$pane.find('.table tr').length)
        {
            $('.theme-control-tab[href="#' + $pane.attr('id') +'"]').closest('li').hide();
        }
    });

    $('.nav-tabs li > a').first().trigger('click');

    var $resetThemeBtn = $('#resetTheme');
    $resetThemeBtn.click(function()
    {
        $form.find('input.form-control, select.form-control, input[type="hidden"]').each(function()
        {
            var $this = $(this);
            $this.val($this.data('origin-default') || $this.data('default') || $this.attr('placeholder') || $this.val()).trigger('change.color');
        });

        $resetThemeBtn.popover({trigger:'manual', content: $resetThemeBtn.data('success-tip'), placement:'left'}).popover('show');
        setTimeout(function(){$resetThemeBtn.popover('destroy')},2000);
    });

    $form.submit(function()
    {
        $form.find('input.form-control, select.form-control, input[type="hidden"]').each(function()
        {
            var $this = $(this);
            var val = $this.val();
            var type = $this.data('type');
            if(val === '') $this.val($this.data('origin-default') || $this.data('default') || $this.attr('placeholder') || $this.val()).trigger('change.color');
            else if($this.data('type') === 'image' && val != 'inherit' && val != 'none' && val.indexOf('url(') != 0)
            {
                $this.val('url(' + val + ')');
            }
        });

        $form.find('.input-group-textbox-couple input[data-target]').each(function()
        {
            var name = $(this).data('target');
            $('#' + name).val($('[data-sid="' + name + '-1"]').val() + ' ' + $('[data-sid="' + name + '-2"]').val());
        });
    });
});

