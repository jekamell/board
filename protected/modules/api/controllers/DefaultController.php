<?php

class DefaultController extends MembershipController
{
    public function accessRules()
    {
        return array_merge(array(
            array(
                'allow',
                'actions' => array('login', 'register'),
                'users' => array('?'),
            ),
            array(
                'allow',
                'actions' => array('logout', 'error', 'index'),
                'users' => array('@'),
            ),
        ), parent::accessRules());
    }

    public function actionIndex()
    {
       echo 'qq';
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (Yii::app()->user->id) {
            Yii::app()->session->destroy();
        }
        $model = new LoginForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                if(($user = Members::model()->findByAttributes(array('email' => $model->email)))){
                    $this->redirectToHome($user);
                }else{
                    $this->redirect('/membership/chooseAPlan');
                }
            }
        }
        $this->pageCaption = 'Login';
        $this->pageTitle = Yii::app()->name . ' - ' . $this->pageCaption;
        $this->pageDescription = "You've been here before, haven't you?";
        $this->breadcrumbs = array(
            'Login',
        );

        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();

        $this->redirect(Yii::app()->user->logoutUrl);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
                Yii::app()->end();
            }
            $this->pageTitle = Yii::app()->name . ' - Error';
            $this->pageCaption = 'Error';
            $this->pageDescription = isset($code) ? $code : '';
            $this->breadcrumbs = array(
                'Error',
            );

            $this->render('error', $error);
        }
    }

    /**
     * Redirect user depends user role
     *
     * @param Members $user
     */
    protected function redirectToHome(Members $user)
    {
        if ($user->role == Members::ROLE_CHAMBER_OWNER) {
            $this->redirect($this->createUrl('/membership/chamber'));
        } else {
            $isFirstLogin = $user && is_null($user->last_login);
            $this->redirect($isFirstLogin ? $this->createUrl('/membership/user/account') : Yii::app()->user->returnUrl);
        }
    }
}