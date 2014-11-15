<?php

class UserController extends Controller
{
    public function actionRegister()
    {
        $model = new User();

        if ($attributes = $this->getPost('User')) {
            $model->attributes = $attributes;
            if ($model->save()) {
                $this->setFlash(WebUser::FLASH_OK, 'aa');
                $this->redirect($this->createUrl('/'));
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
}
