<?php

class DefaultController extends ApiController
{
    public function accessRules()
    {
        return [
            [
                'allow',
                'users' => ['*']
            ]
        ];
    }

    public function actionError()
    {
        $this->response->status = false;
        $this->response->message = Yii::app()->errorHandler->error['message'];
        $this->response->result = Response::$errors;
        Response::$errors = array();
    }
}
