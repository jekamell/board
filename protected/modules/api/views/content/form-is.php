<?php
/* @var $this Content */
/* @var $model Contents */

$this->renderPartial(
    '/crud/_form',
    array(
        'model'   => $model,
        'action'  => $this->createUrl('/membership/content/update', array('id' => $model->id)),
        'fields'  =>  array(
            array('name' => 'type', 'field' => 'dropDownList', 'icon' => 'icon-cog', 'data' => $types, 'htmlOptions' => !$model->isNewRecord ? array('disabled' => 'disabled') : array()),
            array('name' =>'Contents[asset]','field'=>'hiddenField','value'=>isset($_POST['Contents']['asset']) ? $_POST['Contents']['asset'] : ''),
            array('name' =>'Contents[thumb]','field'=>'hiddenField','value'=>isset($_POST['Contents']['thumb']) ? $_POST['Contents']['thumb'] : '',),
            array('name' => 'active', 'field' => 'dropDownList', 'icon' => 'icon-off', 'data' => array(0 => "No", 1 => "Yes")),
            array('name' => 'name', 'field' => 'textField', 'icon' => 'icon-pencil'),
        )
    )
);

$this->renderPartial(
    '/content/_info-page-form',
    array(
        'model' => $model
    )
);
