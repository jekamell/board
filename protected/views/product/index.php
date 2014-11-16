<?php
/* @var $this SiteController */

if ($items) { ?>
    <? foreach ($items as $model) { ?>
        <div class="well">
            <div class="pull-left" style="width: 200px;">
                <?= CHtml::image($model->getHttpPath(), $model->title, ['class' => 'img-thumbnail', 'style' => 'max-width: 200px']); ?>
            </div>
            <div class="pull-left" style="margin-left: 25px; ">
                <h2><?= CHtml::encode($model->title); ?></h2>
                Price: <strong><?= CHtml::encode($model->price); ?></strong> $<br />
                Contact seller: <?= CHtml::link($model->user->email, 'mailto:' . $model->user->email); ?> <br />
                Date published: <?= date('jS F, Y H:i A', strtotime($model->date_add)); ?> <br />
            </div>

            <div class="clearfix"></div>


        </div>
    <? } ?>

<? } else { ?>
    No products exists. Register and add first
<? } ?>
