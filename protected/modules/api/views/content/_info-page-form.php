<? if (!empty($model->infoPages)) { ?>
<style>
    span.mceIcon.mce_bgcolor {background-position:-760px 0}
</style>
    <legend>Info Pages</legend>
    <? $items = array();
    foreach ($model->infoPages as $i => $iPage) {
        $items[] = array(
            'title' => $iPage->name . ' <i class="icon-edit" style="color: #08C; cursor: pointer;' . ($i > 0 ? 'display: none' : '') . '" data-id=' . $iPage->id . '></i>',
            'content' => $this->renderPartial(
                '/content/_info-screen-view',
                array(
                    'model' => $iPage
                ),
                true,
                false
            ),
        );
    }
    if ($items) { ?>
        <? $this->widget(
            'ext.bootstrap-theme.widgets.BTabs',
            array(
                'id' => 'ip',
                'items' => $items,
            )
        )?>
    <? } ?>

    <div class="modal hide fade" id="tab-modal">
        <? $form = $this->beginWidget(
            'CActiveForm',
            array(
                'method' => 'post',
                'action' => $this->createUrl('/membership/content/updateInfoPage/', array('id' => $model->infoPages[0]->id)),
                'htmlOptions' => array(
                    'id' => 'infoPage-form'
                )
            )
        ); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Edit Tab</h3>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <?= $form->labelEx($model->infoPages[0], 'name', array('class' => 'control-label'));?>
                <div class="controls">
                    <?= $form->textField($model->infoPages[0], 'name', array('style' => 'width: 95%'));?>
                </div>
            </div>
            <div class="control-group">
                <?= $form->label($model->infoPages[0]->nodes_data, 'description_html', array('class' => 'control-label'));?>
                <div class="controls">
                    <? $this->widget('application.extensions.tinymce.TinyMce',
                        array(
                            'model'     => $model->infoPages[0]->nodes_data,
                            'attribute' => 'description_html',
                            'htmlOptions' => array('style' => 'height:auto'),
                            'settings' => array(
                                'init_instance_callback' => 'tinyMceInitCallback'
                            ),
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?= CHtml::submitButton('Save changes', array('class' => 'btn btn-primary', 'id' => 'ip-submit')) ?>
        </div>
        <? $this->endWidget(); ?>
    </div>

    <script>
        setTabBackground();

        function tinyMceInitCallback() {
            var ed = tinymce.activeEditor;
            ed.formatter.register('white-text', {
                inline : 'span',
                styles : {color : '#ffffff'}
            });
            ed.formatter.apply('white-text');
        }
        function setEditorBackground() {
            var ed = tinymce.activeEditor;
            var tabBackground = '#000000';
            var firstElement = $(ed.getContent());
            var firstDivExist = firstElement.prop('tagName') == 'DIV' && firstElement.css('width') == '100%';

            if (firstDivExist) {
                tabBackground = firstElement.css('background-color');
            }
            $(ed.getBody()).css('background-color', tabBackground);
        }
        function setTabBackground() {
            var wellCurrent = $('div.tab-pane.active').children('div.well');
            wellCurrent.css('background-color', wellCurrent.children('div').css('background-color'));
        }

        $('#ip.tabbable li').click(function() {
            $('#ip.tabbable i').hide();
            $(this).find('i.icon-edit').show();
            setTimeout(setTabBackground, 1);
        });
        $('#ip.tabbable i').click(function() {
            var action = $('#infoPage-form').attr('action');
            var id = $(this).attr('data-id');
            var actionNew = action.replace(/\d+$/g, id);

            $('#InfoPages_name').val($(this).parents('li').text().trim());
            tinymce.activeEditor.setContent($('#ip .active div.well').html().trim());
            tinyMceInitCallback();
            setEditorBackground();
            $('#infoPage-form').attr('action', actionNew);
            $('#tab-modal').modal();
        });

        $('#ip-submit').click(function() {
            var ed = tinymce.activeEditor;
            var color = $(ed.getBody()).css('background-color');

            var div = $('<div />')
                .css('background-color', color)
                .css('width', '100%')
                .css('min-height', '1112px')
                .attr('id', 'tWrapper')
                .html(ed.getContent());

            ed.setContent(div[0].outerHTML);
        });
    </script>
<? } ?>