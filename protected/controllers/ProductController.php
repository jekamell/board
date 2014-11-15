<?php

class ProductController extends Controller
{
    public function accessRules()
    {
        return array_merge(
            [
                [
                    'allow',
                    'actions' => ['index', 'error'],
                    'users' => ['*'],
                ],
                [
                    'allow',
                    'actions' => ['my', 'add'],
                    'users' => ['@'],
                ],
            ],
            parent::accessRules()
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionMy()
    {
        $this->render('index');
    }

    public function actionAdd()
    {
        $this->render('add');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }
}
