<?php

class ProductController extends ApiController
{
    public $defaultAction = 'list';

    public function accessRules()
    {
        return array_merge(
            [
                [
                    'allow',
                    'users' => ['*'],
                    'actions' => ['list', 'index', 'view']
                ]
            ],
            parent::accessRules()
        );
    }


    public function actionList()
    {
        $this->response->status = true;
        $result = [];
        foreach (Product::model()->noDeleted()->findAll() as $model) {
            $result[] = $model->getApiAttributes();
        }
        $this->response->result = $result;
    }

    public function actionView($id)
    {
        if ($model = Product::model()->noDeleted()->findByPk($id)) {
            $this->response->status = true;
            $this->response->result = $model->getApiAttributes();
        }
    }

    public function actionCreate()
    {
        echo __METHOD__;
    }

    public function actionUpdate($id)
    {
        echo __METHOD__;
    }


    public function actionDelete($id)
    {
        echo __METHOD__;
    }
}
