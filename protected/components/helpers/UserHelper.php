<?php

/**
 * @package common.extensions.helpers
 */
class UserHelper
{
    const FLASH_MESSAGE_TYPE_SUCCESS = 'success';
    const FLASH_MESSAGE_TYPE_ERROR = 'error';
    const FLASH_MESSAGE_TYPE_NOTICE = 'notice';

    /**
     * @var string
     */
    private static $_currentUser;

    /**
     * @return null|integer
     */
    public static function getCurrentUserId()
    {
        return Yii::app()->user->id;
    }

    /**
     * @return null|string
     */
    public static function getCurrentUsername()
    {
        $user = self::getCurrentUser();
        return $user == null ? null : $user->username;
    }

    /**
     * @return User
     */
    public static function getCurrentUser()
    {
        if (self::$_currentUser === null) {
	        $user_id = Yii::app()->user->id;
	        if ($user_id != null)
                self::$_currentUser = User::model()->find('id=?', array($user_id));
	        else
		        self::$_currentUser = null;
        }

        return self::$_currentUser;
    }

	/**
	 * @return Pool|null
	 */
	public static function getCurrentUserPool()
	{
		$user = self::getCurrentUser();
		return $user->employee->employeePosition->pool;
	}

    /**
     * @return null|string
     */
    public static function whatIsMyEmployeePositionType()
    {
        //return EnumEmployeePositionType::PROCUREMENT;
        $me = self::getCurrentUser();
        if ($me->employee != null && $me->employee->employeePosition != null) {
            return $me->employee->employeePosition->type;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public static function myEmployeePositionId()
    {
        $me = self::getCurrentUser();
        if ($me->employee != null && $me->employee->employeePosition != null) {
            return $me->employee->employee_position_id;
        }

        return null;
    }

    /*
     * @return array
     */
    public static function getAllRoles(){
        $roles = array();
        $types = AuthItem::$TYPES;
        $authItems = AuthItem::model()->findAll('type=?', array(array_search('Role', $types)));
        foreach($authItems as $var){
            $roles[$var->name] = $var->name;
        }
        asort($roles);
        return $roles;
    }

    public static function setFlashMessage($message, $type='success'){
        Yii::app()->user->setFlash($type, $message);
    }

    public static function getFlashMessage($type = 'success'){
        return Yii::app()->user->getFlash($type);
    }

    public static function printAlert(){
        $successMessage = UserHelper::getFlashMessage();
        $errorMessage = UserHelper::getFlashMessage(UserHelper::FLASH_MESSAGE_TYPE_ERROR);
        $noticeMessage = UserHelper::getFlashMessage(UserHelper::FLASH_MESSAGE_TYPE_NOTICE);
        if($successMessage!=NULL){
            return '<div class="alert alert-success">
                        <button class="close" data-dismiss="alert" type="button">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <strong>
                            <i class="ace-icon fa fa-check"></i>
                            Success!
                        </strong>
                            '.$successMessage.'
                        <br>
                    </div>';
        }
        else if($errorMessage!=NULL){
            return '<div class="alert alert-danger">
                        <button class="close" data-dismiss="alert" type="button">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <strong>
                            <i class="ace-icon fa fa-times"></i>
                            Error!
                        </strong>
                        '.$errorMessage.'
                        <br>
                    </div>';
        }
        else if($noticeMessage != NULL){
            return '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert" type="button">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <strong>
                            <i class="ace-icon fa fa-warning"></i>
                            Warning!
                        </strong>
                        '.$noticeMessage.'
                        <br>
                    </div>';
        }
    }
}