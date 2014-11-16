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
                    'actions' => ['my', 'add', 'delete'],
                    'users' => ['@'],
                ],
            ],
            parent::accessRules()
        );
    }

    public function actionIndex()
    {
        $items = Product::model()->noDeleted()->orderedDateDesc()->with('user')->findAll();

        $this->render('list', ['items' => $items]);
    }

    public function actionMy()
    {
        $model = new Product();

        $this->render('list-my', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        if ($model = Product::model()->noDeleted()->findByPk($id)) {
            $model->is_deleted = 1;
            $model->save(false);
            if (!$this->getParam('ajax')) {
                $this->redirect(array('my'));
            }

        }
    }

    public function actionAdd()
    {
        $model = new Product();

        if ($attributes = $this->getPost('Product')) {
            $model->attributes = $attributes;
            $model->image = CUploadedFile::getInstance($model, 'image');
            if ($model->save()) {
                $this->setFlash(WebUser::FLASH_OK, 'aa');

                $this->redirect(Yii::app()->getBaseUrl(true));
            }
        }

        $this->render('add', ['model' => $model]);
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
