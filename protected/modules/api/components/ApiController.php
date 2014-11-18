<?php

class ApiController extends Controller
{
    /**
     * @var Response
     */
    protected $response;

    public function init()
    {
        $this->response = new Response();
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

    public function afterAction($action)
    {
        $this->response->send();
    }
}
