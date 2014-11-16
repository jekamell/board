<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules()
    {
        return [
            ['deny']
        ];
    }


    public $layout = '//layouts/column1';

    protected function getParam($name, $defaultValue = null)
    {
        return Yii::app()->getRequest()->getParam($name, $defaultValue);
    }

    protected function getPost($name, $defaultValue = null)
    {
        return Yii::app()->getRequest()->getPost($name, $defaultValue);
    }

    protected function setFlash($key, $value, $defaultValue = null)
    {
        Yii::app()->getUser()->setFlash($key, $value, $defaultValue);
    }

    protected function beforeAction($action)
    {
        if (!Yii::app()->getClientScript()->isScriptRegistered('jquery')) {
            Yii::app()->getClientScript()->registerCoreScript('jquery');
        }

        return parent::beforeAction($action);
    }
}