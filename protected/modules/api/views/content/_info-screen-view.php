<div class="well" style="background-color: #000000; color: ">
    <? $this->beginWidget('CHtmlPurifier'); ?>
        <?= $model->nodes_data->description_html; ?>
    <? $this->endWidget(); ?>
</div>
