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

$attributes[] = CrudHelper::DetailedView()->Separator($model->getAttributeLabel('attached files'));

if ($file = $model->getFile()) {
    $attributes[] = array(
        'name'  => 'file',
        'type'  => 'raw',
        'value' => $this->renderPartial(
            '_file',
            array(
                'model' => $file,
                'node'  => $model,
            ),
            true
        ),
    );
}
//CVarDumper::dump($model->getFile('thumb')->url, 10, 1);exit;
if ($thumb = $model->getFile('thumb')) {
    $attributes[] = array(
        'name'  => 'thumbnail',
        'type'  => 'raw',
        'value' => $this->renderPartial(
            '_file',
            array(
                'model' => $thumb,
                'node'  => $model,
            ),
            true
        ),
    );
}

$this->renderPartial(
    '/crud/_view',
    array(
        'model'=>$model,
        'attributes'=>$attributes
    )
);