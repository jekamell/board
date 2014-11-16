<p>Please click
<?= CHtml::link('here', Yii::app()->controller->createAbsoluteUrl('/user/confirm', ['hash' => $model->hash_confirm])) ?>
 to confirm your account</p>