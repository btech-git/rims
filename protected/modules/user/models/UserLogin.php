<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLogin extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    public $branchId;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password, branchId', 'required'),
            array('branchId', 'assigned'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => UserModule::t("Remember Me"),
            'username' => UserModule::t("Username or Email"),
            'password' => UserModule::t("Password"),
            'branchId' => UserModule::t("Branch"),
        );
    }
    
    public function assigned($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = Users::model()->findByAttributes(array('username' => $this->username));
            $userBranches = UserBranch::model()->findAllByAttributes(array('users_id' => $user->id));
            $userBranchIds = array_map(function($userBranch) { return $userBranch->branch_id; }, $userBranches);
            if (!in_array($this->branchId, $userBranchIds)) {
                $this->addError("branchId", UserModule::t("Branch is not assigned to user."));
            }
        }
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {  // we only want to authenticate when no input errors
            $identity = new UserIdentity($this->username, $this->password);
            $identity->setBranchId($this->branchId);
            $identity->authenticate();
            switch ($identity->errorCode) {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? Yii::app()->controller->module->rememberMeTime : 36000;
                    Yii::app()->user->login($identity, $duration);
                    break;
                case UserIdentity::ERROR_EMAIL_INVALID:
                    $this->addError("username", UserModule::t("Email is incorrect."));
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError("username", UserModule::t("Username is incorrect."));
                    break;
                case UserIdentity::ERROR_STATUS_NOTACTIV:
                    $this->addError("status", UserModule::t("You account is not activated."));
                    break;
                case UserIdentity::ERROR_STATUS_BAN:
                    $this->addError("status", UserModule::t("You account is blocked."));
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError("password", UserModule::t("Password is incorrect."));
                    break;
            }
        }
    }
}
