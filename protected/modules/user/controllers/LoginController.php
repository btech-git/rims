<?php

class LoginController extends Controller {

    public $layout = '//layouts/login';
    public $defaultAction = 'login';

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->lastViset();
//                    $this->attendance();
                    $user = User::model()->findByAttributes(array('username' => $model->username));

                    $userIpAddress = new UserIpAddress();
                    $userIpAddress->ip_address = $_SERVER['REMOTE_ADDR'];
                    $userIpAddress->access_datetime = date('Y-m-d H:i:s');
                    $userIpAddress->user_id = $user === null ? null : $user->id;
                    $userIpAddress->save();

                    $this->redirect(array('/site/index'));

//                    if (Yii::app()->user->returnUrl == '/index.php') {
//                        $this->redirect(Yii::app()->controller->module->returnUrl);
//                    } else {
//                        $this->redirect(Yii::app()->user->returnUrl);
//                    }
                }
            }
            // display the login form
            $this->render('/user/login', array('model' => $model));
        } else {
            $this->redirect(Yii::app()->controller->module->returnUrl);
        }
    }

    private function lastViset() {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit_at = date('Y-m-d H:i:s');
        $lastVisit->save();
    }

    private function attendance() {
        $userData = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        echo $userData->id;
        $attendance = EmployeeAttendance::model()->findbyAttributes(array(
            'user_id' => Yii::app()->user->id,
            'date' => date('y-m-d')
        ));

        if ($attendance->login_time == '0000-00-00 00:00:00') {
            $attendance->login_time = date('H:i:s');
            $attendance->save(false);
        }
    }

}
