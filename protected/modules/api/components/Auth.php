<?php

class Auth extends CApplicationComponent
{
    const TOKEN_PARAM = 'token';
    public function init()
    {
        parent::init();

        Yii::app()->user->clearStates();
        Yii::app()->user->allowAutoLogin = false;
        Yii::app()->user->setRole(User::ROLE_GUEST);
        Yii::app()->user->setId(0);

        if ($token = Yii::app()->request->getParam(self::TOKEN_PARAM)) {
            $identity = new ApiUserIdentity($token);
            $identity->authenticate();
            if ($identity->errorCode == ApiUserIdentity::ERROR_NONE) {
                Yii::app()->user->assignParams($identity);
            }
        }
    }
}
