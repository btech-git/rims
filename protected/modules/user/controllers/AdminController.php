<?php

class AdminController extends Controller {

    public $defaultAction = 'admin';
    public $layout = '//layouts/column2';
    private $_model;

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterUserCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterUserEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'profile' || 
            $filterChain->action->id === 'admin'
        ) {
            if (!(Yii::app()->user->checkAccess('masterUserCreate')) || !(Yii::app()->user->checkAccess('masterUserEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
        /* $dataProvider=new CActiveDataProvider('User', array(
          'pagination'=>array(
          'pageSize'=>Yii::app()->controller->module->user_page_size,
          ),
          ));

          $this->render('index',array(
          'dataProvider'=>$dataProvider,
          ));// */
    }

    /**
     * Displays a particular model.
     */
    public function actionView($id) {
        $model = $this->loadModel();
        $attendances = EmployeeAttendance::model()->findAllByAttributes(array('user_id' => $model->id));
        
        $this->render('view', array(
            'model' => $model,
            'attendances' => $attendances,
            'counter' => 0,
        ));
    }

    /**
     * Displays a particular model.
     */
    public function actionProfile($id) {
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
    public function actionCreate() {
        $model = new User;
        $model->create_at = date('Y-m-d H:i:s');
        $model->lastvisit_at = date('Y-m-d H:i:s');
        $employees = Employee::model()->findAll();
        
//        $profile = new Profile;
        $this->performAjaxValidation(array($model));
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->employee_id = $_POST['User']['employee_id'];
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
                    
                    if ((int) $model->superuser === 1) {
                        $authorizer->authManager->assign('Admin', $model->id);
                    }
                    
                    $branches = isset($_POST['BranchId']) ? $_POST['BranchId'] : $_POST['BranchId'];
                    foreach($branches as $i=>$branch) {
                        $userBranch = new UserBranch;
                        $userBranch->users_id = $model->id;
                        $userBranch->branch_id = $branch;
                        $userBranch->save();
                    }
                    
                    $this->redirect(array('view', 'id' => $model->id));
                }
//            } else {
//                $profile->validate();
            }
        }

        $this->render('create', array(
            'model' => $model,
            'employees' => $employees,
//            'profile' => $profile,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate() {
        $model = $this->loadModel();
        $employees = Employee::model()->findAll();
//        $profile = $model->profile;
        $this->performAjaxValidation(array($model));
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
//            $profile->attributes = $_POST['Profile'];

            if ($model->validate()) {
//                $old_password = User::model()->notsafe()->findByPk($model->id);
//                if ($old_password->password != $model->password) {
//                    $model->password = Yii::app()->controller->module->encrypting($model->password);
//                    $model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
//                }
                $model->save();
//                $profile->save();
                $authorizer = Yii::app()->getModule("rights")->getAuthorizer();
                $authorizer->authManager->assign('Authenticated', $model->id);

                UserBranch::model()->deleteAllByAttributes(array('users_id' => $model->id,));
                
                $branches = isset($_POST['BranchId']) ? $_POST['BranchId'] : $_POST['BranchId'];
                foreach($branches as $i=>$branch) {
                    $userBranch = new UserBranch;
                    $userBranch->users_id = $model->id;
                    $userBranch->branch_id = $branch;
                    $userBranch->save();
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
//            else {
//                $profile->validate();
//            }
        }

        $this->render('update', array(
            'model' => $model,
            'employees' => $employees,
//            'profile' => $profile,
        ));
    }

    public function actionEdit() {
        $this->layout = '//layouts/column1';

        $model = User::model()->findbyPk($_GET['id']);
        $this->performAjaxValidation(array($model));

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if ($model->validate()) {
//                $old_password = User::model()->findByPk($model->id);
//                if ($old_password->password != $model->password) {
                $model->password = Yii::app()->controller->module->encrypting($_POST['User']['password']);
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
    public function actionDelete() {
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

    public function actionAjaxHtmlUpdateEmployeeSelect() {
        if (Yii::app()->request->isAjaxRequest) {
//            $employeeId = '';
            $model = new User;
            $branchId = isset($_POST['User']['branch_id']) ? $_POST['User']['branch_id'] : 0;

            $employees = Employee::model()->findAllByAttributes(
                array(
                    'branch_id' => $branchId
                ), array(
                    'order' => 'name ASC'
                )
            );

            $this->renderPartial('_employeeSelect', array(
                'model' => $model,
                'employees' => $employees,
            ));
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel() {
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
