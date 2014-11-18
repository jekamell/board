<?php

class UserController extends Controller
{
    public function accessRules()
    {
        return array_merge(
            [
                [
                    'allow',
                    'actions' => ['login', 'index'],
                    'users' => ['*'],
                ],
                [
                    'allow',
                    'actions' => ['update'],
                    'users' => ['@'],
                ]
            ],
            parent::accessRules()
        );
    }

    public function actionIndex($id)
    {

    }

    public function actionLogin()
    {

    }

    public function actionUpdate($id)
    {

    }
}
