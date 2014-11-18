<?php
/* @var $this ContentController */
/* @var $model Contents */
$attributes = array(
    CrudHelper::DetailedView()->Separator($model->getAttributeLabel($model->name)),
    array('name' => 'type','value' => Contents::$types[$model->type],),
    array('name' => 'active','type' => 'boolean',),
    array(
        'name' => 'Status',
        'value' => $model->asset ? ($model->asset->status != ContentAssets::STATUS_READY ? '<b>' : '') .  ($model->asset->status == ContentAssets::STATUS_READY ? 'Ready' : 'Processing...') . ($model->asset->status != ContentAssets::STATUS_READY ? '</b>' : ''): '', 'visible' => (bool)$model->asset,
        'type'  => 'raw',
    ),
    'name',
);
if ($model->type == Contents::TYPE_LINK) {
    $attributes[] = 'nodes_data.url';
}
$attributes[] = CrudHelper::DetailedView()->CreatedBy($model);
$attributes[] = CrudHelper::DetailedView()->UpdatedBy($model);
$attributes[] = array('name'  => 'created','value' => $model->created ? date ("m-d-Y g:i A", strtotime($model->created)) : '',);
$attributes[] = array('name'  => 'updated','value' => $model->updated ? date ("m-d-Y g:i A", strtotime($model->updated)) : '',);
$attributes[] = 'favourite_cnt';
$attributes[] = 'comment_cnt';
$attributes[] = 'rating';

$this->renderPartial(
    '/crud/_view',
    array(
        'model'=>$model,
        'attributes'=>$attributes
    )
);

$this->renderPartial(
    '_info-page-view',
    array(
        'model' => $model
    )
);
