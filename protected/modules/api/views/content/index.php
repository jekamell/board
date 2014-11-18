<?php
/* @var $this NodesController */
/* @var $model Nodes */
echo CrudHelper::GridView()->BatchDelete()->Script($this);
echo CrudHelper::GridView()->BatchDelete()->Template($this);

Yii::app()->clientScript->registerScript('form_vars', "
    Admin.form.init();
", CClientScript::POS_END);
?>
<? $this->renderPartial('/crud/_index',array(
    'model'=>$model,
    'columns'=>array(
        array(
            'name'=>'name',
        ),
        CrudHelper::GridView()->PreDefinedList('type', 'Contents', 'types'),
        CrudHelper::GridView()->Boolean('active'),
        array(
            'name'    => 'asset.status',
            'value'   => '$data->isAssetsUploaded() ? "Ready" : "Processing " . GridViewHelper::getPreloaderImage()',
            'type'    => 'raw',
            'visible' => in_array(MemberHelper::getRole(MemberHelper::getCurrent()), array(Members::ROLE_MEMBER, Members::ROLE_CHANNEL_OWNER)),
        ),
        CrudHelper::GridView()->DateRange('created', $model),
//buttons
        array(
            'class'       => 'CButtonColumn',
            'htmlOptions' => array('class'=>'button-column span2'),
            'template'    => '{up} {down} {view} {update} {delete}',
            'buttons'     => array(
                'up'     => CrudHelper::GridView()->UpButton($this),
                'down'   => CrudHelper::GridView()->DownButton($this),
                'view'   => CrudHelper::GridView()->ViewButton($this),
                'update' => array(
                    'url' => '$data->type == Contents::TYPE_INFO_SCREEN ? Yii::app()->createUrl("/membership/'.$this->id.'/updateInfoScreen", array("id" => $data->primaryKey)) : Yii::app()->createUrl("/membership/'.$this->id.'/update", array("id" => $data->primaryKey))',
                    'label' => false,
                    'options' => array('class' => 'icon-pencil', 'title' => 'Update'),
                    'imageUrl' => false,
                    'visible'=>'Yii::app()->controller->checkAccess("/membership/'.$this->id.'/update")',
                ),
                'delete' => array(
                    'url'      => 'Yii::app()->createUrl("/membership/'.$this->id.'/delete", array("id" => $data->primaryKey))',
                    'label'    => false,
                    'options'  => array('class' => 'icon-trash', 'title' => 'Delete'),
                    'imageUrl' => false,
                    'click'    => "function(){return Admin.grid.remove(this)}",
                    'visible'  => 'Yii::app()->controller->checkAccess("/membership/'.$this->id.'/delete") && $data->type != Contents::TYPE_INFO_SCREEN',
                )
            ),
        ),
    ),
)); ?>
<script>
    function updateGrid() {
        $.fn.yiiGridView.update('contents-grid');
    }
    setInterval(updateGrid, 60000);
</script>