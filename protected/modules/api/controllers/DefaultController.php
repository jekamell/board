<?php

class DefaultController extends ApiController
{
    public function accessRules()
    {
        return [
            [
                'allow',
                'users' => ['*']
            ]
        ];
    }

    public function actionError()
    {
        $this->response->status = false;
        $this->response->message = Yii::app()->errorHandler->error['message'];
        $this->response->result = Response::$errors;
        Response::$errors = array();
    }

    public function actionLogin()
    {
        $login = $this->getParam('login');
        $password = $this->getParam('password');
        if (!($login && $password)) {
            throw new CHttpException(401, Response::LOGIN_PASSWORD_REQUIRED);
        }
        $identity = new UserIdentity($login, $password);
        $identity->authenticate();
        if ($identity->errorCode == UserIdentity::ERROR_NONE) {
            $this->response->status = 1;
            $securityToken = md5($login . $password . microtime(true));
            $this->response->result = [
                'token' => $securityToken
            ];
            $this->setUserSecurityToken(User::model()->findByPk($identity->id), $securityToken);
            Yii::app()->user->assignParams($identity);
        } else {
            throw new CHttpException(400, Response::LOGIN_PASSWORD_INVALID);
        }
    }

    protected function setUserSecurityToken(User $user, $token)
    {
        $user->token = $token;

        return $user->save(false, ['token']);
    }
}
