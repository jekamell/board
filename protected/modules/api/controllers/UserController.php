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

    public function actionView($id)
    {
        if ($model = User::model()->findByPk($id)) {
            parent::view(Product::model()->noDeleted()->findByPk($id));
        } else {
            throw new CHttpException(404, Response::NOT_FOUND);
        }
    }

    public function actionUpdate()
    {
        if ($user = User::model()->confirmed()->findByPk(Yii::app()->getUser()->getId())) {
            $user->attributes = [
                'name' => $this->getParam('name'),
                'email' => $this->getParam('email'),
                'password' => $this->getParam('password'),
                'password_repeat' => $this->getParam('password_repeat'),
            ];
            $this->saveModel($user);
        } else {
            throw new CHttpException(401, Response::ACCOUNT_NOT_CONFIRMED);
        }
    }
}
