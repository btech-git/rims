<?php

/**
 * Controller of logout page
 *
 * @package controllers
 */
class LogoutController extends Controller
{
    /**
     * Clear user sessions and redirect to login page
     */
    public function actionIndex()
    {
        // change status_login
        $user = MyHelper::getUser();
	    if ($user != null) {
	        $user->scenario = 'logout';
	        $user->status = User::STATUS_OFFLINE;
	        $user->save();
	    }

        Yii::app()->user->logout();
        $this->redirect('login');
    }
}