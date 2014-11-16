<?php
$this->widget('zii.widgets.grid.CGridView', [
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'table table-hover',
    'pagerCssClass' => 'pagination',
    'columns' => [
        [
            'header' => 'Image',
            'value' => 'CHtml::image($data->getHttpPath(FileBehavior::PREFIX_THUMB), $data->title, ["class" => "img img-rounded"])',
            'type' => 'raw',
            'htmlOptions' => ['style' => 'width:' . Yii::app()->params['image']['thumb']['width']]
        ],
        [
            'name' => 'title',
            'value' => 'CHtml::link($data->title, Yii::app()->controller->createUrl("/product/update", ["id" => $data->id]))',
            'type' => 'raw',
        ],
        'price',
        'date_add',
        [
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => [
                    'imageUrl' => false,
                    'label' => '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                ],
                'delete' => [
                    'imageUrl' => false,
                    'label' => '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
                ],
            ],
        ]
    ]
]);
