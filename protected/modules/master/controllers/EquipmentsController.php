<?php

class EquipmentsController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterCustomerCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterCustomerEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'addVehicle' || 
            $filterChain->action->id === 'updatePic' || 
            $filterChain->action->id === 'updatePrice' || 
            $filterChain->action->id === 'updateVehicle'
        ) {
            if (!(Yii::app()->user->checkAccess('masterCustomerCreate')) || !(Yii::app()->user->checkAccess('masterCustomerEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $equipmentDetails = EquipmentDetails::model()->findAllByAttributes(array('equipment_id' => $id));
        $equipmentTasks = EquipmentTask::model()->findAllByAttributes(array('equipment_id' => $id));
        $equipmentMaintenances = EquipmentMaintenances::model()->findAllByAttributes(array('equipment_id' => $id));
        $this->render('view', array(
            'model' => $model,
            'equipmentDetails' => $equipmentDetails,
            'equipmentTasks' => $equipmentTasks,
            'equipmentMaintenances' => $equipmentMaintenances,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewDetail($id) {
        $model = $this->loadModel($id);
        $equipmentDetails = equipmentDetails::model()->findAllByAttributes(array('equipment_id' => $id));
        $equipmentTasks = EquipmentTask::model()->findAllByAttributes(array('equipment_id' => $id));
        $equipmentMaintenances = EquipmentMaintenances::model()->findAllByAttributes(array('equipment_id' => $id));
        $this->render('_detailMaintenances', array(
            'model' => $model,
            'equipmentDetails' => $equipmentDetails,
            'equipmentTasks' => $equipmentTasks,
            'equipmentMaintenances' => $equipmentMaintenances,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        /* $model=new Equipments;

          // Uncomment the following line if AJAX validation is needed
          // $this->performAjaxValidation($model);

          if(isset($_POST['Equipments']))
          {
          $model->attributes=$_POST['Equipments'];
          if($model->save())
          $this->redirect(array('admin'));
          }

          $this->render('create',array(
          'model'=>$model,
          )); */

        $equipment = $this->instantiate(null);

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Branch']))
            $branch->attributes = $_GET['Branch'];

        $branchCriteria = new CDbCriteria;
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
        ));

        $this->performAjaxValidation($equipment->header);


        if (isset($_POST['Equipments'])) {
            //echo "<pre>";print_r($_POST); exit;
            $this->loadState($equipment);

            if ($equipment->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $equipment->header->id));
            } else {
                foreach ($equipment->taskDetails as $key => $taskDetail) {
                    //print_r(CJSON::encode($detail->jenis_persediaan_id));
                }
                //echo "test";
            }
        }



        $this->render('create', array(
            //'model'=>$model,
            'equipment' => $equipment,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        /* 		$model=$this->loadModel($id);

          // Uncomment the following line if AJAX validation is needed
          // $this->performAjaxValidation($model);

          if(isset($_POST['Equipments']))
          {
          $model->attributes=$_POST['Equipments'];
          if($model->save())
          $this->redirect(array('admin'));
          }

          $this->render('update',array(
          'model'=>$model,
          )); */

        $equipment = $this->instantiate($id);

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Branch']))
            $branch->attributes = $_GET['Branch'];

        $branchCriteria = new CDbCriteria;
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
        ));

        $this->performAjaxValidation($equipment->header);


        if (isset($_POST['Equipments'])) {

            $this->loadState($equipment);

            if ($equipment->save(Yii::app()->db)) {
                //echo "here"; exit;	
                $this->redirect(array('view', 'id' => $equipment->header->id));
            } else {
                //echo "test";
            }
        }



        $this->render('update', array(
            //'model'=>$model,
            'equipment' => $equipment,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
        ));
    }

    public function actionUpdateDetails($id) {
        /* 		$model=$this->loadModel($id);

          // Uncomment the following line if AJAX validation is needed
          // $this->performAjaxValidation($model);

          if(isset($_POST['Equipments']))
          {
          $model->attributes=$_POST['Equipments'];
          if($model->save())
          $this->redirect(array('admin'));
          }

          $this->render('update',array(
          'model'=>$model,
          )); */

        $equipment = $this->instantiate($id);

        $this->performAjaxValidation($equipment->header);


        $equipmentMaintenances = array();
        $criteria = new CDbCriteria;
        $todays_month_year = date('Y-m');
        $criteria->addCondition(
                "DATE_FORMAT(maintenance_date, '%Y-%m') = '$todays_month_year'"
        );
        $criteria->addCondition('equipment_id = ' . $equipment->header->id);
        $equipmentMaintenances = EquipmentMaintenances::model()->findAll($criteria);
        $maintenanceCount = count($equipmentMaintenances);

        if (isset($_POST['EquipmentMaintenances'])) {
            $this->loadState($equipment);

            if ($equipment->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $equipment->header->id));
            }
        }



        $this->render('update_maintenance', array(
            'equipment' => $equipment,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateMaintenance($id) {

        $equipment = $this->instantiate($id);

        $this->performAjaxValidation($equipment->header);

        /* echo "<pre>"; print_r($equipment->equipmentDetails);
          if(empty(!$equipment->equipmentDetails))
          {
          echo "hi";
          }
          exit; */

        if (isset($_POST['EquipmentMaintenances'])) {
            $this->loadState($equipment);
            //echo "herer<pre>";
            //print_r($_POST['EquipmentMaintenances']);
            //exit;
            if ($equipment->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $equipment->header->id));
            }
        }



        $this->render('add_maintenance', array(
            //'model'=>$model,
            'equipment' => $equipment,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Equipments');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Equipments('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Equipments']))
            $model->attributes = $_GET['Equipments'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Equipments the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Equipments::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Equipments $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'equipments-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //Add Branch Detail
    public function actionAjaxHtmlAddBranchDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $equipment = $this->instantiate($id);
            $this->loadState($equipment);

            $equipment->addEquipmentDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_equipmentDetails', array('equipment' => $equipment), false, true);
        }
    }

    //Delete Branch Detail
    public function actionAjaxHtmlRemoveBranchDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $equipment = $this->instantiate($id);
            $this->loadState($equipment);

            $equipment->removeEquipmentDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_equipmentDetails', array('equipment' => $equipment), false, true);
        }
    }

    //Add TAsk Detail
    public function actionAjaxHtmlAddTaskDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $equipment = $this->instantiate($id);
            $this->loadState($equipment);

            $equipment->addTaskDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailTask', array('equipment' => $equipment), false, true);
        }
    }

    //Delete Task Detail
    public function actionAjaxHtmlRemoveTaskDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $equipment = $this->instantiate($id);
            $this->loadState($equipment);
            $equipment->removeTaskDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailTask', array('equipment' => $equipment), false, true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $equipment = new Equipment(new Equipments(), array(), array(), array());
        } else {
            $equipmentModel = $this->loadModel($id);
            $equipment = new Equipment($equipmentModel, $equipmentModel->equipmentDetails, $equipmentModel->equipmentTasks, $equipmentModel->equipmentMaintenances1);
        }
        return $equipment;
    }

    public function loadState($equipment) {
        if (isset($_POST['Equipments'])) {
            $equipment->header->attributes = $_POST['Equipments'];
        }

        if (isset($_POST['EquipmentDetails'])) {
            foreach ($_POST['EquipmentDetails'] as $i => $item) {
                if (isset($equipment->equipmentDetails[$i]))
                    $equipment->equipmentDetails[$i]->attributes = $item;
                else {
                    $detail = new EquipmentDetails();
                    $detail->attributes = $item;
                    $equipment->equipmentDetails[] = $detail;
                }
            }
            if (count($_POST['EquipmentDetails']) < count($equipment->equipmentDetails))
                array_splice($equipment->equipmentDetails, $i + 1);
        } else
            $equipment->equipmentDetails = array();

        if (isset($_POST['EquipmentTask'])) {
            foreach ($_POST['EquipmentTask'] as $i => $item) {
                if (isset($equipment->taskDetails[$i]))
                    $equipment->taskDetails[$i]->attributes = $item;
                else {
                    $detail = new EquipmentTask();
                    $detail->attributes = $item;
                    $equipment->taskDetails[] = $detail;
                }
            }
            if (count($_POST['EquipmentTask']) < count($equipment->taskDetails))
                array_splice($equipment->taskDetails, $i + 1);
        } else
            $equipment->taskDetails = array();

        if (isset($_POST['EquipmentMaintenances'])) {
            foreach ($_POST['EquipmentMaintenances'] as $i => $item) {
                if (isset($equipment->equipmentMaintenances1[$i])) {
                    $equipment->equipmentMaintenances1[$i]->attributes = $item;
                } else {
                    $detail = new EquipmentMaintenances();
                    $detail->attributes = $item;
                    $detail->employee_id = $item['employee_id'];
                    $equipment->equipmentMaintenances1[] = $detail;
                }
            }
            if (count($_POST['EquipmentMaintenances']) < count($equipment->equipmentMaintenances1))
                array_splice($equipment->equipmentMaintenances1, $i + 1);
        } else
            $equipment->equipmentMaintenances1 = array();
    }

    public function actionAjaxGetAge() {
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = true;
        Yii::app()->clientscript->scriptMap['jquery.js'] = true;

        $then = strtotime($_GET['purchase_date']);

        //Get the current timestamp.
        $now = time();

        //Calculate the difference.
        $difference = $now - $then;

        //Convert seconds into days.
        $days = floor($difference / (60 * 60 * 24));

        echo $days;
    }

    // calculate next maintenance date
    public function actionAjaxGetNext() {
        $check_period = EquipmentTask::model()->findAllByAttributes(array('id' => $_GET['selected_task']));
        if ($check_period != '') {
            switch ($check_period[0]['check_period']) {
                case 'Daily':
                    $add_days = 1;
                    break;
                case 'Weekly':
                    $add_days = 7;
                    break;
                case 'Monthly':
                    $add_days = 30;
                    break;
                case 'Quarterly':
                    $add_days = 91;
                    break;
                case '6 Months':
                    $add_days = 182;
                    break;
                case 'Yearly':
                    $add_days = 365;
                    break;
            }
            echo $nextDate = date('Y-m-d', strtotime($_GET['maintenance_date'] . ' + ' . $add_days . 'days'));
        } else {
            echo '0';
        }
    }

    // get equipment related Maintenance events
    public function actionGetEvents() {
        $id = $_GET['id'];
        $items = array();
        $equipments = $this->instantiate($id);

        foreach ($equipments->equipmentMaintenances1 as $i => $equipmentMaintenanc) {

            $color = '#CC0000';
            switch ($equipmentMaintenanc->equipmentTask->check_period) {
                case 'Daily':
                    $color = '#CC0000';
                    break;
                case 'Weekly':
                    $color = '#FFE633';
                    break;
                case 'Monthly':
                    $color = '#68FF33';
                    break;
                case 'Quarterly':
                    $color = '#33FF9C';
                    break;
                case '6 Months':
                    $color = '#33B5FF';
                    break;
                case 'Yearly':
                    $color = '#AC33FF';
                    break;
            }

            $items[] = array(
                'title' => $equipmentMaintenanc->equipmentTask->task,
                'start' => $equipmentMaintenanc->maintenance_date,
                'end' => $equipmentMaintenanc->next_maintenance_date,
                'color' => $color,
                'allDay' => true,
                'url' => $this->createUrl('equipmentMaintenance/update?id=' . $equipmentMaintenanc->id)
            );
        }
        echo CJSON::encode($items);
        Yii::app()->end();
    }

}
