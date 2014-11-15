<? $form = $this->beginWidget('CActiveForm',
    [
        'htmlOptions' => ['class' => 'form-horizontal'],
    ]
); ?>

    <? if ($model->getErrors()) { ?>
        <div class="alert alert-danger alert-dismissable">
            <?= $form->errorSummary($model); ?>
        </div>
    <? } ?>

    <div class="form-group">
        <?= $form->labelEx($model, 'email', ['class' => 'col-sm-2 control-label']); ?>
        <div class="col-sm-10">
            <?= $form->textField($model, 'email', ['class' => 'form-control', 'placeholder' => 'Email']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $form->labelEx($model, 'password', ['class' => 'col-sm-2 control-label']); ?>
        <div class="col-sm-10">
            <?= $form->textField($model, 'password', ['class' => 'form-control', 'placeholder' => 'Password']); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= CHtml::submitButton('Sign up', ['class' => 'btn btn-default']); ?>
        </div>
    </div>
<? $this->endWidget(); ?>