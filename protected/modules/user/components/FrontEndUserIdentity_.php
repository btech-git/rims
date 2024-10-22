<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class FrontEndUserIdentity extends CUserIdentity {

    private $_id;
    private $_branchId;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $user = User::model()->notsafe()->findByAttributes(array('username' => $this->username));
        
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (Yii::app()->getModule('user')->encrypting($this->password) !== $user->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $userBranches = UserBranch::model()->findAllByAttributes(array('users_id' => $user->id));
            $branchIds = array_map(function($userBranch) {
                return $userBranch->branch_id;
            }, $userBranches);
            $this->setState('branch_ids', $branchIds);
            $this->setState('branch_id', $this->_branchId);
            $this->_id = $user->id;
            $this->username = $user->username;
            $this->errorCode = self::ERROR_NONE;
        }
        
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

    public function setBranchId($branchId) {
        $this->_branchId = $branchId;
    }
}
