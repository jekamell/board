<?php

class Response extends CComponent 
{

    public $status = false;
    public $message = '';
    public $result = [];
    public static $errors = [];

    const NOT_AUTHORIZED = 'You are not authorized to perform this action';
    const LOGIN_PASSWORD_REQUIRED = 'Login and Password required';
    const LOGIN_PASSWORD_INVALID = 'Login or Password invalid';

    /**
     * Get response data
     * @return array
     */
    public function get() {
        return [
            'status' => (int)$this->status,
            'message' => $this->message,
            'result' => $this->result ? : new stdClass(),
        ];
    }
    /**
     * Send response data with headers. End application;
     */
    public function send(){
        header('HTTP/1.1 200 OK');
        header('Content-type: application/json');
        echo CJavaScript::jsonEncode($this->get());
        Yii::app()->end();
    }
}
