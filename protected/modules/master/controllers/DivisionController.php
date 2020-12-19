<?php

class DivisionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'restore' || 
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('generalManager')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $divisionPositions = DivisionPosition::model()->findAllByAttributes(array('division_id' => $id));
        $divisionBranches = DivisionBranch::model()->findAllByAttributes(array('division_id' => $id));
        $divisionWarehouses = WarehouseDivision::model()->findAllByAttributes(array('division_id' => $id));
        //$positions = Position::model()->findAllByPk($divisionPosition->position_id);
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'divisionPositions' => $divisionPositions,
            'divisionBranches' => $divisionBranches,
            'divisionWarehouses' => $divisionWarehouses,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Division;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['Division']))
        // {
        // 	$model->attributes=$_POST['Division'];
        // 	$model->status='Active';
        // 	if($model->save())
        // 		$this->redirect(array('admin'));
        // 		//$this->redirect(array('view','id'=>$model->id));
        // }

        $division = $this->instantiate(null);

        $position = new Position('search');
        $position->unsetAttributes();  // clear any default values
        if (isset($_GET['Position']))
            $position->attributes = $_GET['Position'];

        $positionCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $positionCriteria->compare('name', $position->name, true);

        $positionDataProvider = new CActiveDataProvider('Position', array(
            'criteria' => $positionCriteria,
        ));

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Branch']))
            $branch->attributes = $_GET['Branch'];

        $branchCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
        ));

        $warehouse = new Warehouse('search');
        $warehouse->unsetAttributes();  // clear any default values
        if (isset($_GET['Warehouse']))
            $warehouse->attributes = $_GET['Warehouse'];

        $warehouseCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $warehouseCriteria->compare('name', $warehouse->name, true);

        $warehouseDataProvider = new CActiveDataProvider('Warehouse', array(
            'criteria' => $warehouseCriteria,
        ));
        $positionArray = array();
        $branchArray = array();
        $warehouseArray = array();


        $this->performAjaxValidation($division->header);

        if (isset($_POST['Division'])) {


            $this->loadState($division);
            if ($division->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $division->header->id));
            } else {
                echo "test";
            }
        }



        $this->render('create', array(
            //'model'=>$model,
            'division' => $division,
            'position' => $position,
            'positionDataProvider' => $positionDataProvider,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
            'warehouse' => $warehouse,
            'warehouseDataProvider' => $warehouseDataProvider,
            'positionArray' => $positionArray,
            'branchArray' => $branchArray,
            'warehouseArray' => $warehouseArray,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //$model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['Division']))
        // {
        // 	$model->attributes=$_POST['Division'];
        // 	if($model->save())
        // 		$this->redirect(array('admin'));
        // 		//$this->redirect(array('view','id'=>$model->id));
        // }
        $position = new Position('search');
        $position->unsetAttributes();  // clear any default values
        if (isset($_GET['Position']))
            $position->attributes = $_GET['Position'];

        $positionCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $positionCriteria->compare('name', $position->name, true);

        $positionDataProvider = new CActiveDataProvider('Position', array(
            'criteria' => $positionCriteria,
        ));

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Branch']))
            $branch->attributes = $_GET['Branch'];

        $branchCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
        ));

        $warehouse = new Warehouse('search');
        $warehouse->unsetAttributes();  // clear any default values
        if (isset($_GET['Warehouse']))
            $warehouse->attributes = $_GET['Warehouse'];

        $warehouseCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $warehouseCriteria->compare('name', $warehouse->name, true);

        $warehouseDataProvider = new CActiveDataProvider('Warehouse', array(
            'criteria' => $warehouseCriteria,
        ));

        $division = $this->instantiate($id);

        $this->performAjaxValidation($division->header);

        $positionChecks = DivisionPosition::model()->findAllByAttributes(array('division_id' => $id));
        $positionArray = array();
        foreach ($positionChecks as $key => $positionCheck) {
            array_push($positionArray, $positionCheck->position_id);
        }
        $branchChecks = DivisionBranch::model()->findAllByAttributes(array('division_id' => $id));
        $branchArray = array();
        foreach ($branchChecks as $key => $branchCheck) {
            array_push($branchArray, $branchCheck->branch_id);
        }

        $warehouseChecks = WarehouseDivision::model()->findAllByAttributes(array('division_id' => $id));
        $warehouseArray = array();
        foreach ($warehouseChecks as $key => $warehouseCheck) {
            array_push($warehouseArray, $warehouseCheck->warehouse_id);
        }
        //print_r($levelArray);
        if (isset($_POST['Division'])) {


            $this->loadState($division);
            if ($division->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $division->header->id));
            } else {
                /* foreach ($division->positions as $key => $position) {
                  //print_r(CJSON::encode($detail->jenis_persediaan_id));
                  } */
                echo 'tes2';
            }
        }
        $this->render('update', array(
            //'model'=>$model,
            'division' => $division,
            'position' => $position,
            'positionDataProvider' => $positionDataProvider,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
            'warehouse' => $warehouse,
            'warehouseDataProvider' => $warehouseDataProvider,
            'positionArray' => $positionArray,
            'branchArray' => $branchArray,
            'warehouseArray' => $warehouseArray,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->remove();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionRestore($id) {
        // var_dump($id); die("S");
        $this->loadModel($id)->restore();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Division');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Division('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Division']))
            $model->attributes = $_GET['Division'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    //Add Position Detail
    public function actionAjaxHtmlAddPositionDetail($id, $positionId) {
        if (Yii::app()->request->isAjaxRequest) {
            $division = $this->instantiate($id);
            $this->loadState($division);

            $division->addDetail($positionId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = true;
            Yii::app()->clientscript->scriptMap['jquery.js'] = true;
            $this->renderPartial('_detail', array('division' => $division), false, true);
        }
    }

    //Delete Position Detail
    public function actionAjaxHtmlRemovePositionDetail($id, $index, $position_name) {
        if (Yii::app()->request->isAjaxRequest) {
            $position_id = 'pos_' . $index;
            $position_name = $position_name;
            $division = $this->instantiate($id);
            $this->loadState($division);
            $division->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery.js'] = true;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = true;
            $this->renderPartial('_detail', array('division' => $division), false, true);
        }
    }

    //Add Branch Detail
    public function actionAjaxHtmlAddBranchDetail($id, $branchId) {
        if (Yii::app()->request->isAjaxRequest) {
            $division = $this->instantiate($id);
            $this->loadState($division);

            $division->addBranchDetail($branchId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = true;
            Yii::app()->clientscript->scriptMap['jquery.js'] = true;
            $this->renderPartial('_detailBranch', array('division' => $division), false, true);
        }
    }

    //Delete Branch Detail
    public function actionAjaxHtmlRemoveBranchDetail($id, $index, $branch_name) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch_name = $branch_name;
            $division = $this->instantiate($id);
            $this->loadState($division);
            $division->removeBranchDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = true;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailBranch', array('division' => $division), false, true);
        }
    }

    //Add Warehouse Detail
    public function actionAjaxHtmlAddWarehouseDetail($id, $warehouseId) {
        if (Yii::app()->request->isAjaxRequest) {
            $division = $this->instantiate($id);
            $this->loadState($division);

            $division->addWarehouseDetail($warehouseId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = true;
            Yii::app()->clientscript->scriptMap['jquery.js'] = true;
            $this->renderPartial('_detailWarehouse', array('division' => $division), false, true);
        }
    }

    //Delete Warehouse Detail
    public function actionAjaxHtmlRemoveWarehouseDetail($id, $war_name, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            //echo $id.'=>'. $war_name.'=>'.$index; exit;
            $war_name = $war_name;
            $division = $this->instantiate($id);
            $this->loadState($division);

            $division->removeWarehouseDetailAt($index);
            //print_r(CJSON::encode($division->warehouseDetails));exit;
            Yii::app()->clientScript->registerScript(
                    "test", "jQuery.ajax({
												type: 'POST',
												success: function(html){
												   jQuery('#warehouse-dialog').html(html);
											}
											  });
										  ", CClientScript::POS_READY
            );
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = true;
            Yii::app()->clientscript->scriptMap['jquery.js'] = true;
            $this->renderPartial('_detailWarehouse', array('division' => $division), false, true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $division = new Divisions(new Division(), array(), array(), array());
            //print_r("test");
        } else {
            $divisionModel = $this->loadModel($id);
            $division = new Divisions($divisionModel, $divisionModel->divisionPositions, $divisionModel->divisionBranches, $divisionModel->warehouseDivisions);
        }
        //echo '<pre>'; print_r($division); exit;
        return $division;
    }

    public function loadState($division) {
        if (isset($_POST['Division'])) {
            $division->header->attributes = $_POST['Division'];
        }
        if (isset($_POST['DivisionPosition'])) {
            foreach ($_POST['DivisionPosition'] as $i => $item) {
                if (isset($division->positions[$i]))
                    $division->positions[$i]->attributes = $item;
                else {
                    $detail = new DivisionPosition();
                    $detail->attributes = $item;
                    $division->positions[] = $detail;
                }
            }
            if (count($_POST['DivisionPosition']) < count($division->positions))
                array_splice($division->positions, $i + 1);
        } else
            $division->positions = array();

        if (isset($_POST['DivisionBranch'])) {
            foreach ($_POST['DivisionBranch'] as $i => $item) {
                if (isset($division->branchDetails[$i]))
                    $division->branchDetails[$i]->attributes = $item;
                else {
                    $detail = new DivisionBranch();
                    $detail->attributes = $item;
                    $division->branchDetails[] = $detail;
                }
            }
            if (count($_POST['DivisionBranch']) < count($division->branchDetails))
                array_splice($division->branchDetails, $i + 1);
        } else
            $division->branchDetails = array();

        if (isset($_POST['WarehouseDivision'])) {
            foreach ($_POST['WarehouseDivision'] as $i => $item) {
                if (isset($division->warehouseDetails[$i]))
                    $division->warehouseDetails[$i]->attributes = $item;
                else {
                    $detail = new WarehouseDivision();
                    $detail->attributes = $item;
                    $division->warehouseDetails[] = $detail;
                }
            }
            if (count($_POST['WarehouseDivision']) < count($division->warehouseDetails))
                array_splice($division->warehouseDetails, $i + 1);
        } else
            $division->warehouseDetails = array();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Division the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Division::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Division $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'division-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
