<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /*private $_id, $_username;

    const USER_STATUS_ACTIVE = 1;
    const USER_STATUS_LOCKED = 0;*/

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */

    public function authenticate()
    {
        $users=array(
            // username => password
            'demo'=>'demo',
            'admin'=>'admin',
        );
        if(!isset($users[$this->username]))
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        elseif($users[$this->username]!==$this->password)
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
            $this->errorCode=self::ERROR_NONE;
        return !$this->errorCode;
    }
    /*public function authenticate()
    {
        $user = User::model()->find('t.username=? AND t.status<> ? AND t.status<>?', array(
            $this->username,
            User::STATUS_LOCKED,
            User::STATUS_BANNED,
        ));

        if($user === null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } else {
            if($user->password != User::hashPassword($this->password)) {
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            } else {
                $this->errorCode=self::ERROR_NONE;
                $this->_id = $user->id;
            }
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }*/
}