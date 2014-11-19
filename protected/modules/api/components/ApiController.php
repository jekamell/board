<?php

class ApiController extends Controller
{
    public $defaultAction = 'list';
    /**
     * @var Response
     */
    protected $response;

    public function init()
    {
        $this->response = new Response();
        $this->module->auth;
        parent::init();
    }

    public function accessRules()
    {
        return [
            [
                'deny',
                'users' => ['*'],
            ]
        ];
    }

    public function filters()
    {
        return ['accessControl'];
    }

    public function view(ApiAccessible $model)
    {
        if ($model) {
            $this->response->status = true;
            $this->response->result = $model->getApiAttributes();
        }
    }

    /**
     * @param CActiveRecord $model
     */
    protected function saveModel($model)
    {
        if ($model->save()) {
            $this->response->status = true;
        } else {
            $this->response->message = $model->getErrors();
        }
    }

    public function afterAction($action)
    {
        $this->response->send();
    }
}
