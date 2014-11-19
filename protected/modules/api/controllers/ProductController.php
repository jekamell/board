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
                ],
                [
                    'allow',
                    'users' => ['@'],
                    'actions' => ['update', 'delete', 'create'],
                ],
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
        if ($model = $this->loadModelByIdAndUserId($id, Yii::app()->getUser()->getId())) {
            $model->attributes = array(
                'title' => $this->getParam('title'),
                'price' => $this->getParam('price'),
            );
            if (isset($_FILES['image'])) {
                $model->image = CUploadedFile::getInstanceByName('image');
            }

            if ($model->save()) {
                $this->response->status = true;
            } else {
                $this->response->message = $model->getErrors();
            }
        } else {
            throw new CHttpException(404, Response::NOT_FOUND);
        }

    }

    public function actionDelete($id)
    {
        if ($model = $this->loadModelByIdAndUserId($id, Yii::app()->getUser()->getId())) {
            $model->is_deleted = 1;
            if ($model->save()) {
                $this->response->status = true;
            } else {
                $this->response->message = $model->getErrors();
            }
        } else {
            throw new CHttpException(404, Response::NOT_FOUND);
        }
    }

    protected function loadModelByIdAndUserId($id, $userId)
    {
        return Product::model()->findByAttributes(['id' => $id, 'user_id' => Yii::app()->getUser()->getId()]);
    }
}
