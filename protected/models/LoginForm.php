<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $email;
    public $password;

    private $_identity;

    public function rules()
    {
        return [
            ['email, password', 'required'],
            ['email', 'email'],
            ['password', 'authenticate'],
        ];
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     *
     * @param $attribute
     * @param $params
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->email, $this->password);
            if (!$this->_identity->authenticate()) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    /**
     * Logs in the user using the given email and password in the model.
     *
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->email, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            Yii::app()->getUser()->login($this->_identity);
            Yii::app()->getUser()->id = $this->_identity->id;
            Yii::app()->getUser()->setRole($this->_identity->role);
            Yii::app()->getUser()->setName($this->_identity->name);
            Yii::app()->getUser()->setEmail($this->_identity->email);

            return true;
        } else {
            return false;
        }
    }
}
