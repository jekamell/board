<?php

class ProductController extends ApiController
{
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
        parent::view(Product::model()->noDeleted()->findByPk($id));
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
