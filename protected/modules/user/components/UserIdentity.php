<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    private $_branchId;

    const ERROR_STATUS_NOTACTIV = 4;
    const ERROR_STATUS_BAN = 5;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $user = User::model()->findByAttributes(array('username' => $this->username));
        
        if ($user === null || !$user->is_main_access) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (Yii::app()->getModule('user')->encrypting($this->password) !== $user->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else if ($user->status == 0 && Yii::app()->getModule('user')->loginNotActiv == false) {
            $this->errorCode = self::ERROR_STATUS_NOTACTIV;
        } else if ($user->status == -1) {
            $this->errorCode = self::ERROR_STATUS_BAN;
        } else {
            $userBranches = UserBranch::model()->findAllByAttributes(array('users_id' => $user->id));
            $branchIds = array_map(function ($userBranch) {
                return $userBranch->branch_id;
            }, $userBranches);
            $this->setState('username', $this->username);
            $this->setState('branch_ids', $branchIds);
            $this->setState('branch_id', $this->_branchId);
            $this->_id = $user->id;
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
