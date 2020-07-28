<?php

/**
 * Controller of login page
 *
 * @package controllers
 */
class LoginController extends Controller
{
    /**
     * layout for login page
     * @var string
     */
    public $layout = '//layouts/login';

    /**
     * Render login form
     * @return void
     */
    public function actionIndex()
    {
        
		$model=new LoginForm;
		
		// if user is already logged in
		if (!Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->user->returnUrl);
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
            if($model->rememberMe == NULL){
                $model->rememberMe = 0;
            }
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
                
				$this->redirect('site');
			}
		}
		// display the login form
		$this->render('index',array('model'=>$model));
        

    }

    /**
     * Render forget password form
     * @return void
     */
    public function actionForgetPassword()
    {
        $model=new ForgetPasswordForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='forget-password-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['ForgetPasswordForm']))
        {
            $model->attributes=$_POST['ForgetPasswordForm'];

            // validate user input and redirect to the previous page if valid
            if($model->validate())
            {
                // get first_name & last_name of the user
                $user = User::model()->notRemoved()->find('email=? AND status<>? AND status<>?', array($model->email, User::STATUS_BANNED, User::STATUS_LOCKED));

                // generate password
                $newPassword = User::generatePassword(8);

                // encrypt password
                $encryptedPassword = User::hashPassword($newPassword);

                // save to database
                $user->password = $encryptedPassword;
                $user->password_repeat = $encryptedPassword;
                $user->save();

                // set email data
                $data = array(
                    'name' => $user->profile !== null ? $user->profile->full_name : $user->username,
                    'password' => $newPassword,
                );

                // send to email
                $mailer = EmailHelper::getMailer();

                $message = new YiiMailMessage;
                $message->setSubject('New Password Generated');
                $body = $this->renderPartial('forgetPasswordMessage', $data, true);
                $message->setBody($body, 'text/html');
                $message->addTo($model->email);
                $message->setFrom(Yii::app()->params['adminEmail']);

                $mailer->send($message);
                //Yii::app()->mail->send($message); // send email using setting in config

                /*
                    $message = $this->renderPartial('forgetPasswordMessage', $data, true);
                    $adminEmail = Yii::app()->params['adminEmail'];
                    $headers = "From: " .$adminEmail ."\r\n".
                        "Reply-To: " .$adminEmail ."\r\n".
                        "X-Mailer: PHP/". phpversion();
                    mail($model->email, "New Password Generated", $message, $headers);
                    */

                Yii::app()->user->setFlash('forgetPassword', 'We have sent a new password to your email.');
                $this->redirect(array('/site/login'));
            }
        }

        $this->render('forgetPassword',array('model'=>$model));
    }
}