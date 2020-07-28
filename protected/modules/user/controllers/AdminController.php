<?php

class AdminController extends Controller
{
    public $defaultAction = 'admin';
    public $layout = '//layouts/column2';

    private $_model;

    /**
     * @return array action filters
     */
    /*public function filters()
    {
        return CMap::mergeArray(parent::filters(),array(
            'accessControl', // perform access control for CRUD operations
        ));
    }*/
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules()
//    {
//        return array(
//            array(
//                'allow', // allow authenticated user to perform 'profile' and 'edit' actions
//                'actions' => array('profile', 'edit'),
//                'users' => array('@'),
//            ),
//            array(
//                'allow', // allow admin user to perform 'admin' and 'delete' actions
//                'actions' => array('admin', 'delete', 'create', 'update', 'view'),
//                'users' => UserModule::getAdmins(),
//            ),
//            array(
//                'deny',  // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'view' || $filterChain->action->id === 'profile' || $filterChain->action->id === 'edit') {
            if (!(Yii::app()->user->checkAccess('Authenticated')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'update' || $filterChain->action->id === 'admin' || $filterChain->action->id === 'delete') {
            if (!Yii::app()->user->checkAccess('Authenticated'))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
        /*$dataProvider=new CActiveDataProvider('User', array(
            'pagination'=>array(
                'pageSize'=>Yii::app()->controller->module->user_page_size,
            ),
        ));

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));//*/
    }


    /**
     * Displays a particular model.
     */
    public function actionView($id)
    {
        $model = $this->loadModel();
        //$model = Users::model()->findByPk($id);
        $attendances = EmployeeAttendance::model()->findAllByAttributes(array('user_id' => $model->id));
        $this->render('view', array(
            'model' => $model,
            'attendances' => $attendances,
        ));
    }

    /**
     * Displays a particular model.
     */
    public function actionProfile($id)
    {
		$this->layout = '//layouts/column1';
        
        $model = $this->loadModel();
        $attendances = EmployeeAttendance::model()->findAllByAttributes(array('user_id' => $model->id));
        
        $this->render('profile', array(
            'model' => $model,
            'attendances' => $attendances,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new User;
        $model->create_at = date('Y-m-d H:i:s');
//        $profile = new Profile;
        $this->performAjaxValidation(array($model));
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
//            $profile->attributes = $_POST['Profile'];
//            $profile->user_id = 0;
            if ($model->validate()) {
                $model->password = Yii::app()->controller->module->encrypting($model->password);
                if ($model->save()) {
//                    $profile->user_id = $model->id;
//                    $profile->save();
                    $authorizer = Yii::app()->getModule("rights")->getAuthorizer();
                    $authorizer->authManager->assign('Authenticated', $model->id);
                    if ((int)$model->superuser === 1)
                        $authorizer->authManager->assign('Admin', $model->id);
                }
                $this->redirect(array('view', 'id' => $model->id));
            } else {
//                $profile->validate();
            }
        }

        $this->render('create', array(
            'model' => $model,
//            'profile' => $profile,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();
//        $profile = $model->profile;
        $this->performAjaxValidation(array($model));
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
//            $profile->attributes = $_POST['Profile'];

            if ($model->validate()) {
                $old_password = User::model()->notsafe()->findByPk($model->id);
                if ($old_password->password != $model->password) {
                    $model->password = Yii::app()->controller->module->encrypting($model->password);
                    $model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
                }
                $model->save();
//                $profile->save();
                $authorizer = Yii::app()->getModule("rights")->getAuthorizer();
                $authorizer->authManager->assign('Authenticated', $model->id);
                $this->redirect(array('view', 'id' => $model->id));
            } 
//            else {
//                $profile->validate();
//            }
        }

        $this->render('update', array(
            'model' => $model,
//            'profile' => $profile,
        ));
    }

    public function actionEdit()
    {
		$this->layout = '//layouts/column1';
        
        $model = User::model()->findbyPk($_GET['id']);
        $this->performAjaxValidation(array($model));
        
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if ($model->validate()) {
                $old_password = User::model()->findByPk($model->id);
//                if ($old_password->password != $model->password) {
                    $model->password = Yii::app()->controller->module->encrypting($model->password);
//                    $model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
//                }
                $model->save();
//                $authorizer = Yii::app()->getModule("rights")->getAuthorizer();
//                $authorizer->authManager->assign('Authenticated', $model->id);
                $this->redirect(array('profile', 'id' => $model->id));
            }
        }

        $this->render('edit', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model = $this->loadModel();
            $profile = Profile::model()->findByPk($model->id);
            $model->status = 0;
            $model->update(array('status'));
//            $profile->delete();
//            $model->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_POST['ajax'])) {
                $this->redirect(array('/user/admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

	public function actionAjaxHtmlUpdateEmployeeSelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $branchId = isset($_POST['User']['branch_id']) ? $_POST['User']['branch_id'] : 0;

            $this->renderPartial('_employeeSelect', array(
                'branchId' => $branchId,
            ));
        }
    }
    
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id'])) {
                $this->_model = User::model()->notsafe()->findbyPk($_GET['id']);
            }
            if ($this->_model === null) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
        return $this->_model;
    }

}