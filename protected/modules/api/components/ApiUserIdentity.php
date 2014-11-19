<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class ApiUserIdentity extends CUserIdentity
{
    const ERROR_TOKEN_INVALID = 'Invalid token. Login and try again please';

    public $token;

    public $email;
    public $role;
    public $name;

    private $id;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Authenticates a user.
     *
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        if (!$user = User::model()->confirmed()->findByAttributes(['token' => $this->token])) {
            $this->errorCode = self::ERROR_TOKEN_INVALID;
        } else {
            $this->id = $user->id;
            $this->name = $user->name;
            $this->role = User::ROLE_USER;
            $this->errorCode = self::ERROR_NONE;
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}