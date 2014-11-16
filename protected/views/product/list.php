<?php
/* @var $this SiteController */

if ($items) { ?>
    <? foreach ($items as $model) { ?>
        <div class="well">
            <div class="pull-left" style="width: 200px;">
                <?= CHtml::image($model->getHttpPath(FileBehavior::PREFIX_THUMB), $model->title, ['class' => 'img-thumbnail']); ?>
            </div>
            <div class="pull-left" style="margin-left: 25px; ">
                <p><h2><?= CHtml::encode($model->title); ?></h2></p>
                <p>Price: <strong><?= CHtml::encode($model->price); ?></strong> $</p>
                <p>Contact seller: <?= CHtml::link($model->user->email, 'mailto:' . $model->user->email); ?> </p>
                <p>Date published: <?= date('jS F, Y H:i a', strtotime($model->date_add)); ?> </p>
            </div>

            <div class="clearfix"></div>


        </div>
    <? } ?>

<? } else { ?>
    No products exists. Register and add first
<? } ?>