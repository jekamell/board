<?php

class UserController extends Controller
{
    public function accessRules()
    {
        return array_merge(
            [
                [
                    'allow',
                    'actions' => ['login', 'register'],
                    'users' => ['?'],
                ],
                [
                    'allow',
                    'actions' => ['profile', 'logout'],
                    'users' => ['@'],
                ],
            ],
            parent::accessRules()
        );
    }

    public function actionRegister()
    {
        $model = new User();

        if ($attributes = $this->getPost('User')) {
            $model->attributes = $attributes;
            if ($model->save()) {
                $this->setFlash(WebUser::FLASH_OK, 'aa');
                $this->redirect(Yii::app()->getBaseUrl(true));
            }
        }

        $this->render('register', ['model' => $model]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($attributes = $this->getPost('LoginForm')) {
            $model->attributes = $attributes;
            if ($model->validate() && $model->login()) {
                $this->setFlash(WebUser::FLASH_OK, 'aa');
                $this->redirect(Yii::app()->getUser()->returnUrl);
            }
        }

        $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::app()->getUser()->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionProfile()
    {
        $user = User::model()->findByPk(Yii::app()->getUser()->getId());

        if ($attributes = $this->getPost('User')) {
            $user->attributes = $attributes;
            if ($user->save()) {
                Yii::app()->getUser()->setName($user->name);
                Yii::app()->getUser()->setEmail($user->email);
                $this->setFlash(WebUser::FLASH_OK, 'aa');
            }
        }

        $this->render('profile', ['model' => $user]);
    }
}
