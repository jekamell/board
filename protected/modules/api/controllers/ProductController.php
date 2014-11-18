<?php

class ProductController extends Controller
{
    public function accessRules()
    {
        return array_merge(
            [
                [
                    'allow',
                    'actions' => ['list', 'index'],
                    'users' => ['*'],
                ],
                [
                    'allow',
                    'actions' => ['create', 'update', 'delete'],
                    'users' => ['@'],
                ]
            ],
            parent::accessRules()
        );
    }

    public function actionIndex($id)
    {

    }

    public function actionList()
    {

    }

    public function actionUpdate($id)
    {

    }

    public function actionDelete($id)
    {

    }
}
