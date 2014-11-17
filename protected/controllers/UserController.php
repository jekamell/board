<?php

class UserController extends Controller
{
    public function accessRules()
    {
        return array_merge(
            [
                [
                    'allow',
                    'actions' => ['login', 'register', 'confirm'],
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
                $this->setFlash(WebUser::FLASH_SUCCESS, Yii::t('user', 'registered'));
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
                $this->setFlash(WebUser::FLASH_SUCCESS, Yii::t('user', 'profile_updated'));
            }
        }

        $this->render('profile', ['model' => $user]);
    }

    public function actionConfirm($hash)
    {
        $result = false;
        if ($hash && ($user = User::model()->findByAttributes(['hash_confirm' => $hash]))) {
            $user->is_confirmed = 1;
            $result = $user->save(false, ['is_confirmed']);
            $this->setFlash(WebUser::FLASH_SUCCESS, Yii::t('user', 'email_confirmed'));
        }

        $this->render('confirm', ['result' => $result]);
    }
}
