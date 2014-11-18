<?php

class ApiModule extends CWebModule
{
    const MODULE_NAME = 'api';

    protected function init()
    {
        parent::init();
        Yii::app()->errorHandler->errorAction = '/api/default/error';
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        }
        return false;
    }
}
