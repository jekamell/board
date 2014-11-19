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
}
