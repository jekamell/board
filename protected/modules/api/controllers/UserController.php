<?php

class UserController extends ApiController
{
    public function accessRules()
    {
        return array_merge(
            [
                [
                    'allow',
                    'actions' => ['login'],
                    'users' => ['*'],
                ]
            ],
            parent::accessRules()
        );
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
        $user->setScenario(User::SCENARIO_API_AUTH);

        return $user->save(false, ['token']);
    }
} 