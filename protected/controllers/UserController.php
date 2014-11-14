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
}
