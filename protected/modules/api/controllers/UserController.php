<?php

class UserController extends ApiController
{
    public function accessRules()
    {
        return array_merge(
            [
                [
                    'allow',
                    'actions' => ['login', 'view'],
                    'users' => ['*'],
                ]
            ],
            parent::accessRules()
        );
    }

    public function actionView($id)
    {
        parent::view(User::model()->findByPk($id));
    }
}
