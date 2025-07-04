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
            if (!(Yii::app()->user->checkAccess('masterUserCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!Yii::app()->user->checkAccess('masterUserEdit')) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'switchUser') {
            if (!Yii::app()->user->checkAccess('director')) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('masterUserCreate')) || !(Yii::app()->user->checkAccess('masterUserEdit'))) {
                $this->redirect(array('/site/login'));
            }
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

    public function actionAdminResigned() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }
        
        $dataProvider = $model->searchResigned();

        $this->render('adminResigned', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
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
        $model->user_id = Yii::app()->user->id;
        $model->created_datetime = date('Y-m-d H:i:s');
        $model->create_at = date('Y-m-d H:i:s');
        $model->lastvisit_at = date('Y-m-d H:i:s');
        $employees = Employee::model()->findAll(array('condition' => 'status = "Active"', 'order' => 't.name'));
        $emptyBranchErrorMessage = '';
        
        $this->performAjaxValidation(array($model));
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->employee_id = $_POST['User']['employee_id'];
            $branches = isset($_POST['BranchId']) ? $_POST['BranchId'] : array();
            $model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
            
            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                $valid = $model->validate();
                if ($valid) {
                    $model->password = Yii::app()->controller->module->encrypting($model->password);
                    $valid = $valid && !empty($branches);
                    if ($valid) {
                        $valid = $valid && $model->save();
                        
//                        $authorizer = Yii::app()->getModule("rights")->getAuthorizer();
//                        $authorizer->authManager->assign('Authenticated', $model->id);
//
//                        if ((int) $model->superuser === 1) {
//                            $authorizer->authManager->assign('Admin', $model->id);
//                        }

                        foreach ($branches as $i=>$branch) {
                            $userBranch = new UserBranch;
                            $userBranch->users_id = $model->id;
                            $userBranch->branch_id = $branch;
                            $valid = $valid && $userBranch->save();
                        }

                        $this->saveUserLog($model);

                        if ($valid) {
                            $dbTransaction->commit();
                        } else {
                            $dbTransaction->rollback();
                        }
                        
                        $this->redirect(array('view', 'id' => $model->id));
                    } else {
                        $emptyBranchErrorMessage = '1 or more branch must be selected!!';
                    }
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
            }
        }

        $this->render('create', array(
            'model' => $model,
            'employees' => $employees,
            'emptyBranchErrorMessage' => $emptyBranchErrorMessage,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate() {
        $model = $this->loadModel();
        $model->user_id_updated = Yii::app()->user->id;
        $model->updated_datetime = date('Y-m-d H:i:s');
        $employees = Employee::model()->findAll(array('order' => 't.name'));
        $this->performAjaxValidation(array($model));
        $emptyBranchErrorMessage = '';
        
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $branches = isset($_POST['BranchId']) ? $_POST['BranchId'] : array();

            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                $valid = $model->validate();
                if ($valid) {
                    if ($model->isNewRecord) {
                        $valid = $valid && !empty($branches);
                    }
                    if ($valid) {
                        $valid = $valid && $model->save();
                        
                        UserBranch::model()->deleteAllByAttributes(array('users_id' => $model->id,));
                        foreach ($branches as $i=>$branch) {
                            $userBranch = new UserBranch;
                            $userBranch->users_id = $model->id;
                            $userBranch->branch_id = $branch;
                            $valid = $valid && $userBranch->save();
                        }

                        $this->saveUserLog($model);

                        if ($valid) {
                            $dbTransaction->commit();
                        } else {
                            $dbTransaction->rollback();
                        }
                        
                        $this->redirect(array('view', 'id' => $model->id));
                    } else {
                        $emptyBranchErrorMessage = '1 or more branch must be selected!!';
                    }
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
            }
        }

        $this->render('update', array(
            'model' => $model,
            'employees' => $employees,
            'emptyBranchErrorMessage' => $emptyBranchErrorMessage,
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

    public function actionRequestDayoff($employeeId) {
        $model = new EmployeeDayoff;
        $model->date_from = date('Y-m-d');
        $model->date_to = date('Y-m-d');
        $model->date_created = date('Y-m-d');
        $model->time_created = date('H:i:s');
        $model->employee_id = $employeeId;
        $model->user_id = Yii::app()->user->id;
        $model->off_type = 'Unpaid';
        $model->notes = 'Need Approval';

        if (isset($_POST['EmployeeDayoff'])) {
            $model->attributes = $_POST['EmployeeDayoff'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->date_created)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->date_created)));
            
            $valid = true;
            if ($model->employeeOnleaveCategory->number_of_days > 0) {
                $valid = $model->day == $model->employeeOnleaveCategory->number_of_days ? true : false;
                
                if ($valid == false) {
                    $model->addError('error', 'Jumlah hari cuti melebihi ketentuan.');
                }
            } 
            
            if ($valid && $model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('requestDayoff', array(
            'model' => $model,
        ));
    }
    
    public function actionSwitchUser() {
        $userId = isset($_POST['UserId']) ? $_POST['UserId'] : '';
        $userList = User::model()->findAllByAttributes(array('status' => 1), array('order' => 'username ASC'));
        $userIsError = false;
        
        if (isset($_POST['Submit'])) {
            if ($userId === '') {
                $userIsError = true;
            } else {
                Yii::app()->user->logout();
                $user = User::model()->findByPk($userId);
                $identity = new AutoSwitchUserIdentity($user->username, '');
                $identity->authenticate();
                switch ($identity->errorCode) {
                    case UserIdentity::ERROR_NONE:
                        Yii::app()->user->login($identity, 3600);
                        $this->redirect(array('/site/index'));
                        break;
                }
            }
        }

        $this->render('switchUser', array(
            'userId' => $userId,
            'userList' => $userList,
            'userIsError' => $userIsError,
        ));
    }
    
    
    public function saveUserLog($user) {
        $userLog = new UserLog();
        $userLog->user_id_target = $user->id;
        $userLog->username_target = $user->username;
        $userLog->log_date = date('Y-m-d');
        $userLog->log_time = date('H:i:s');
        $userLog->table_name = $user->tableName();
        $userLog->table_id = $user->id;
        $userLog->user_id = Yii::app()->user->id;
        $userLog->username = Yii::app()->user->username;
        $userLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $userLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $user->attributes;
        
        $newData['roles'] = array();
        foreach($user->roles as $role) {
            $newData['roles'][] = $role;
        }
        
        $userLog->new_data = json_encode($newData);
        
        $userLog->save(false);
    }
    
    public function actionEmployeeCompletion() {
        echo CJSON::encode(Completion::employee($_GET['term']));
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
                $this->_model = User::model()->findByPk($_GET['id']);
            }
            if ($this->_model === null) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
        return $this->_model;
    }

}
