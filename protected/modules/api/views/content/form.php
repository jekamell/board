<?php
/* @var $this Content */
/* @var $model Contents */

$this->renderPartial(
    '/crud/_form',
    array(
        'model'   =>  $model,
        'fields'  =>  array(
            array('name' => 'type', 'field' => 'dropDownList', 'icon' => 'icon-cog', 'data' => $types, 'htmlOptions' => !$model->isNewRecord ? array('disabled' => 'disabled') : array()),
            array('name' =>'Contents[asset]','field'=>'hiddenField','value'=>isset($_POST['Contents']['asset']) ? $_POST['Contents']['asset'] : ''),
            array('name' =>'Contents[thumb]','field'=>'hiddenField','value'=>isset($_POST['Contents']['thumb']) ? $_POST['Contents']['thumb'] : '',),
            !$model->isNewRecord ? array('name' => 'active', 'field' => 'dropDownList', 'icon' => 'icon-off', 'data' => array(0 => "No", 1 => "Yes")) : array(),
            array('name' => 'name', 'field' => 'textField', 'icon' => 'icon-pencil'),
            array('model' => $model->nodes_data, 'name' => 'description', 'field' => 'textArea', 'icon' => 'icon-comments-alt', 'htmlOptions' => array('placeholder' => 'Add some words about added content')),
            array('model' => $model->nodes_data, 'name' => 'url', 'field' => 'textField', 'icon' => 'icon-link', 'htmlOptions' => array('placeholder' => 'http://', 'class' => 'required')),
            $model->isNewRecord ? array(
                'name'  => 'asset',
                'field' => 'raw',
                'value' => $this->widget(
                    'MUploaderWidget',
                    array(
                        'url'   => $this->createUrl('/membership/content/upload') . '?contentType=' . $type,
                        'model' => $model,
                        'attribute' => 'asset',
                        'id'    => 'asset',
                        'start' => 'function(data) {
                            AssetsFormLock(true);
                        }',
                        'success' => 'function(data) {
                            $("#Contents_asset").val(data.name);
                            $("#asset").parent().find(".help-block").hide();
                            if(data.info) {
                                for(var param in data.info) {
                                    $("<div/>").addClass("muted").text(param+":\t"+data.info[param]).appendTo("#asset-files");
                                }
                            }
                            $("#asset p.text-error").hide();
                            $("span.btn-file").parents("div.control-group").removeClass("error");

                            AssetsFormLock(false);
                        }',
                        'fail' => 'function(data) {
                            $("#asset span.btn-file").show();
                            $("#asset").css("width", "300px");
                            $("#asset").parents("div.control-group").addClass("error");
                            AssetsFormLock(false);
                        }'
                    ),
                    true
                ),
                'hint' => ' ',
            ) : array(),
            $model->isNewRecord ? array(
                'name'  => 'thumb',
                'field' => 'raw',
                'value' => $this->widget(
                        'MUploaderWidget',
                        array(
                            'url'   => $this->createUrl('/membership/content/upload') . '?contentType=' . Contents::TYPE_IMAGE,
                            'model' => $model,
                            'attribute' => 'thumb',
                            'id'    => 'thumb',
                            'start' => 'function(data) {
                                AssetsFormLock(true);
                            }',
                            'success' => 'function(data) {
                            $("#Contents_thumb").val(data.name);
                            $("#thumb").parent().find(".help-block").hide();
                            if(data.info) {
                                for(var param in data.info) {
                                    $("<div/>").addClass("muted").text(param+":\t"+data.info[param]).appendTo("#thumb-files");
                                }
                            }
                            $("#thumb p.text-error").hide();
                            $("span.btn-file").parents("div.control-group").removeClass("error");

                            AssetsFormLock(false);
                        }',
                        'fail' => 'function(data) {
                            $("#thumb span.btn-file").show();
                            $("#thumb").css("width", "300px");
                            $("#thumb").parents("div.control-group").addClass("error");
                            AssetsFormLock(false);
                        }'
                        ),
                        true
                    ),
                'hint' => ' ',
            ) : array(),
        )
    )
); ?>
<? if (!$model->isNewRecord) {
    $attributes[] = CrudHelper::DetailedView()->Separator($model->getAttributeLabel('attached files'));

    if ($file = $model->getFile()) {
        $attributes[] = array('name' => 'file', 'type' => 'raw', 'value' => $this->renderPartial('_file', array('model' => $file, 'node' => $model,), true),);
    }

    if ($thumb = $model->getFile('thumb')) {
        $attributes[] = array('name' => 'thumbnail', 'type' => 'raw', 'value' => $this->renderPartial('_file', array('model' => $thumb, 'node' => $model,), true),);
    }

    $this->renderPartial('/crud/_view', array('model' => $model, 'attributes' => $attributes));
} ?>

<script>
    var fileTypes = <?= json_encode($this->contentFileTypes); ?>;
    var _AssetsFormLock = false;
    var fileBlock = $(':file').first().parents('div.control-group');
    var thumbBlock = $(':file').last().parents('div.control-group');
    var AssetsFormLock = function(lock){
        if(lock){
            _AssetsFormLock = true;
            $("#contents-form input[type='submit']").addClass('disabled');
        }else{
            _AssetsFormLock = false;
            $("#contents-form input[type='submit']").removeClass('disabled');
        }
    };
    $("#contents-form").submit(function(){
        return !_AssetsFormLock;
    });

    var fileFieldCheck = function () {
        proceedUrl();
        makeHint();
        var type = $('#Contents_type').val();
        if($("#asset-input").data('blueimpFileupload')){
            $("#asset-input").data('blueimpFileupload').options.url =
                "<?=$this->createUrl('/membership/content/upload')?>" + "?contentType=" + type;
        }
        switch (type) {
            case '<?= Contents::TYPE_LINK; ?>':
                thumbBlock.show();
                fileBlock.hide();
                break;
            case '<?= Contents::TYPE_VIDEO ?>':
            case '<?= Contents::TYPE_IMAGE ?>':
                thumbBlock.hide();
                fileBlock.show();
                break;
            case '<?= Contents::TYPE_AUDIO ?>':
            case '<?= Contents::TYPE_FILE ?>':
                thumbBlock.show();
                fileBlock.show();
        }
    }

    var proceedUrl = function() {
        if ($('#Contents_type').val() == <?= Contents::TYPE_LINK ?>) {
            $('#NodesData_url').parents('div.control-group').show();
        } else {
            $('#NodesData_url').parents('div.control-group').hide();
        }
    }

    var makeHint = function() {
        var type = $('#Contents_type').val();
        var hint = '';
        if (fileTypes[type] && fileTypes[type].length > 0) {
            hint += 'Accept file types: ' + fileTypes[type].join(', ');
        }
        $('div.help-block').first().html(hint);
        $('div.help-block').last().html(fileTypes[<?= Contents::TYPE_IMAGE?>].join(', '));
    }

    $('label[for="NodesData_url"]').text('Url *');

    $('document').ready(function() {
        fileFieldCheck();
    });

    $('#Contents_type').change(fileFieldCheck);
</script>
