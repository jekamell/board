<div>
<? foreach (Yii::app()->getUser()->getFlashes() as $key => $value) { ?>
    <div class="alert alert-<?= $key ?>">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p><?= $value ?></p>
    </div>
<? } ?>
</div>