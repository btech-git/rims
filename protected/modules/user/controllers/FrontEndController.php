<?php

class FrontEndController extends Controller
{
    public $layout = '//layouts/main2';
    public $defaultAction = 'login';

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest) {
            $model = new FrontEndUserLogin;
            // collect user input data
            if (isset($_POST['FrontEndUserLogin'])) {
                $model->attributes = $_POST['FrontEndUserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->redirect(array('/frontEnd/default/index'));
                }
            }
            // display the login form
            $this->render('login', array('model' => $model));
        } else {
            $this->redirect(Yii::app()->controller->module->returnUrl);
        }
    }
}