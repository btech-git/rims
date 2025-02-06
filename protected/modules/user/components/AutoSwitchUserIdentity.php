<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AutoSwitchUserIdentity extends CUserIdentity {

    private $_id;

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
        } else {
            $branch = Branch::model()->find();
            $userBranches = UserBranch::model()->findAllByAttributes(array('users_id' => $user->id));
            $branchIds = array_map(function ($userBranch) {
                return $userBranch->branch_id;
            }, $userBranches);
            $this->setState('branch_ids', $branchIds);
            $this->setState('branch_id', $branch->id);
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

}
