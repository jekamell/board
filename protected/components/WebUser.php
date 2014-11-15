<?php

class WebUser extends CWebUser
{
    const FLASH_OK = 'ok';
    const FLASH_ERR = 'err';

    public $email;
    public $logoutUrl;

    public function setRole($role)
    {
        $this->setState('role', $role);
    }

    public function getRole()
    {
        return $this->getState('role');
    }

    public function getIsGuest()
    {
        return $this->getRole() == User::ROLE_GUEST || parent::getIsGuest();
    }
} 