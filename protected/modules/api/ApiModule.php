<?php

class ApiModule extends CWebModule
{
    const MODULE_NAME = 'membership';

    protected function init()
    {
        parent::init();
        Yii::app()->errorHandler->errorAction = '/membership/default/error';
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        }

        return false;
    }
}
