<?php

class WebUser extends CWebUser
{
    const FLASH_OK = 'ok';
    const FLASH_ERR = 'err';

    /**
     * @param $role
     */
    public function setRole($role)
    {
        $this->setState('role', $role);
    }

    /**
     * @return integer
     */
    public function getRole()
    {
        return $this->getState('role');
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getState('email');
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->setState('email', $email);
    }



    public function getIsGuest()
    {
        return $this->getRole() == User::ROLE_GUEST || parent::getIsGuest();
    }
} 