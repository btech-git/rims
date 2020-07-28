<?php

class LoginController extends Controller
{
    public $layout = '//layouts/login';
    public $defaultAction = 'login';

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->lastViset();
                    $this->attendance();
                    if (Yii::app()->user->returnUrl == '/index.php') {
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    } else {
                        $this->redirect(Yii::app()->user->returnUrl);
                    }
                }
            }
            // display the login form
            $this->render('/user/login', array('model' => $model));
        } else {
            $this->redirect(Yii::app()->controller->module->returnUrl);
        }
    }

    private function lastViset()
    {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

    private function attendance()
    {
        $userData = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        //echo $userData->id;
        $attendance = EmployeeAttendance::model()->findbyAttributes(array(
            'user_id' => Yii::app()->user->id,
            'date' => date('y-m-d')
        ));

        if ($attendance->login_time == '00:00:00') {
            $attendance->login_time = date('H:i:s');
            $attendance->save(false);
        }


        //echo "hitung: ". count($check);

    }

}