<? $form = $this->beginWidget('CActiveForm',
    [
        'htmlOptions' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
    ]
); ?>

    <? if ($model->getErrors()) { ?>
        <div class="alert alert-danger alert-dismissable">
            <?= $form->errorSummary($model); ?>
        </div>
    <? } ?>

    <div class="form-group">
        <?= $form->labelEx($model, 'title', ['class' => 'col-sm-2 control-label']); ?>
        <div class="col-sm-10">
            <?= $form->textField($model, 'title', ['class' => 'form-control', 'placeholder' => 'HP Pavilion 15" ']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $form->labelEx($model, 'price', ['class' => 'col-sm-2 control-label']); ?>
        <div class="col-sm-10">
            <?= $form->textField($model, 'price', ['class' => 'form-control', 'placeholder' => '9999.90']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $form->labelEx($model, 'image', ['class' => 'col-sm-2 control-label']); ?>
        <div class="col-sm-10">
            <? if (!$model->getIsNewRecord() && $image = $model->getHttpPath(FileBehavior::PREFIX_THUMB)) { ?>
                <?= CHtml::image($image, $model->title, ['style' => 'max-width: 60px; ']) ?>
            <? } ?>
            <?= $form->fileField($model, 'image', ['style' => 'margin-top: 5px']); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= CHtml::submitButton($model->getIsNewRecord() ? 'Add' : 'Update', ['class' => 'btn btn-default']); ?>
        </div>
    </div>
<? $this->endWidget(); ?>
