<?php

class BranchController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('masterBranchCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'updateDivision'
        ) {
            if (!(Yii::app()->user->checkAccess('masterBranchEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'addInterbranch' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('masterBranchCreate')) || !(Yii::app()->user->checkAccess('masterBranchEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $branchWarehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $id));
        $divisionBranches = DivisionBranch::model()->findAllByAttributes(array('branch_id' => $id));
        $branchPhones = BranchPhone::model()->findAllByAttributes(array('branch_id' => $id));
        $branchFaxes = BranchFax::model()->findAllByAttributes(array('branch_id' => $id));
        $equipments = Equipments::model()->findAllByAttributes(array('branch_id' => $id));
        
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'branchWarehouses' => $branchWarehouses,
            'divisionBranches' => $divisionBranches,
            'branchPhones' => $branchPhones,
            'branchFaxes' => $branchFaxes,
            'equipments' => $equipments,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $branch = $this->instantiate(null);

        $warehouse = new Warehouse('search');
        $warehouse->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Warehouse']))
            $warehouse->attributes = $_GET['Warehouse'];

        $warehouseCriteria = new CDbCriteria;
        $warehouseCriteria->addCondition("branch_id is null");
        $warehouseCriteria->compare('name', $warehouse->name, true);

        $warehouseDataProvider = new CActiveDataProvider('Warehouse', array(
            'criteria' => $warehouseCriteria,
        ));

        $division = new Division('search');
        $division->unsetAttributes();  // clear any default values
        if (isset($_GET['Division']))
            $division->attributes = $_GET['Division'];

        $divisionCriteria = new CDbCriteria;
        $divisionCriteria->compare('name', $division->name, true);

        $divisionDataProvider = new CActiveDataProvider('Division', array(
            'criteria' => $divisionCriteria,
        ));

        $divisionArray = array();

        $coaInterbranch = new Coa('search');
        $coaInterbranch->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Coa']))
            $coaInterbranch->attributes = $_GET['Coa'];
        
        $coaInterbranchCriteria = new CDbCriteria;
        $coaInterbranchCriteria->addCondition("coa_sub_category_id = 7");
        $coaInterbranchCriteria->compare('code', $coaInterbranch->code . '%', true, 'AND', false);
        $coaInterbranchCriteria->compare('name', $coaInterbranch->name, true);
        $coaInterbranchDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaInterbranchCriteria,
        ));

        $this->performAjaxValidation($branch->header);

        if (isset($_POST['Branch'])) {
            $this->loadState($branch);
            
            if ($branch->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $branch->header->id));
            }
        }

        $this->render('create', array(
            'branch' => $branch,
            'warehouse' => $warehouse,
            'warehouseDataProvider' => $warehouseDataProvider,
            'division' => $division,
            'divisionDataProvider' => $divisionDataProvider,
            'divisionArray' => $divisionArray,
            'coaInterbranch' => $coaInterbranch,
            'coaInterbranchDataProvider' => $coaInterbranchDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $warehouse = new Warehouse('search');
        $warehouse->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Position']))
            $warehouse->attributes = $_GET['Position'];

        $warehouseCriteria = new CDbCriteria;
        $warehouseCriteria->compare('name', $warehouse->name, true);

        $warehouseDataProvider = new CActiveDataProvider('Warehouse', array(
            'criteria' => $warehouseCriteria,
        ));

        $division = new Division('search');
        $division->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Division']))
            $division->attributes = $_GET['Division'];

        $divisionCriteria = new CDbCriteria;
        $divisionCriteria->compare('name', $division->name, true);

        $divisionDataProvider = new CActiveDataProvider('Division', array(
            'criteria' => $divisionCriteria,
        ));
        
        $divisionArray = array();
        $divisionChecks = DivisionBranch::model()->findAllByAttributes(array('branch_id' => $id));
        
        foreach ($divisionChecks as $key => $divisionCheck) {
            array_push($divisionArray, $divisionCheck->division_id);
        }

        $branch = $this->instantiate($id);
        $this->performAjaxValidation($branch->header);

        $coaInterbranch = new Coa('search');
        $coaInterbranch->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Coa']))
            $coaInterbranch->attributes = $_GET['Coa'];
        
        $coaInterbranchCriteria = new CDbCriteria;
        $coaInterbranchCriteria->addCondition("coa_sub_category_id = 7");
        $coaInterbranchCriteria->compare('code', $coaInterbranch->code . '%', true, 'AND', false);
        $coaInterbranchCriteria->compare('name', $coaInterbranch->name, true);
        $coaInterbranchDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaInterbranchCriteria,
        ));

        if (isset($_POST['Branch'])) {
            $this->loadState($branch);
            
            if ($branch->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $branch->header->id));
            } 
        }
        $this->render('update', array(
            'branch' => $branch,
            'warehouse' => $warehouse,
            'warehouseDataProvider' => $warehouseDataProvider,
            'division' => $division,
            'divisionDataProvider' => $divisionDataProvider,
            'divisionArray' => $divisionArray,
            'coaInterbranch' => $coaInterbranch,
            'coaInterbranchDataProvider' => $coaInterbranchDataProvider,
        ));
    }

    public function actionUpdateDivision($branchId, $divisionId) {

        $division = new Division('search');
        $division->unsetAttributes();  // clear any default values
        if (isset($_GET['Division']))
            $division->attributes = $_GET['Division'];

        $divisionCriteria = new CDbCriteria;
        $divisionCriteria->compare('name', $division->name, true);

        $divisionDataProvider = new CActiveDataProvider('Division', array(
            'criteria' => $divisionCriteria,
        ));

        $branch = $this->instantiate($branchId);
        $model = DivisionBranch::model()->findByPk($divisionId);
        if (isset($_POST['DivisionBranch'])) {
            $model->attributes = $_POST['DivisionBranch'];
            
            if ($model->save())
                $this->redirect(array('view', 'id' => $branchId));
        }

        $this->render('update', array(
            'branch' => $branch,
            'division' => $division,
            'divisionDataProvider' => $divisionDataProvider,
            'model' => $model,
        ));
    }

    public function actionAddInterbranch($id) {
        $branch = $this->instantiateInterbranch($id);

        $interbranch = new Branch('search');
        $interbranch->unsetAttributes();  // clear any default values
        if (isset($_GET['Branch']))
            $interbranch->attributes = $_GET['Branch'];

        $interbranchCriteria = new CDbCriteria;
        $interbranchCriteria->addCondition("id <> $id");
        $interbranchCriteria->compare('id', $interbranch->id);
        $interbranchCriteria->compare('t.code', $interbranch->code, true);
        $interbranchCriteria->compare('t.name', $interbranch->name, true);
        
        $interbranchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $interbranchCriteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $branch->header->id));

        if (isset($_POST['Submit'])) {
            $this->loadState($branch);

            if ($branch->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $branch->header->id));
        }

        $this->render('addInterbranch', array(
            'branch' => $branch,
            'interbranch' => $interbranch,
            'interbranchDataProvider' => $interbranchDataProvider,
        ));
    }

    public function actionAjaxHtmlAddInterbranches($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch = $this->instantiateInterbranch($id);
            $this->loadState($branch);

            if (isset($_POST['selectedIds'])) {
                $interbranchDetails = array();
                $interbranchDetails = $_POST['selectedIds'];

                foreach ($interbranchDetails as $interbranchDetail)
                    $branch->addInterbranch($interbranchDetail);
            }
            
            $this->renderPartial('_detailInterbranch', array(
                'branch' => $branch,
            ));
        }
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
        $dataProvider = new CActiveDataProvider('Branch');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Branch('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Branch']))
            $model->attributes = $_GET['Branch'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    // Get City
    public function actionAjaxGetCity() {

        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['Branch']['province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    //Add Warehouse Detail
    public function actionAjaxHtmlAddWarehouseDetail($id, $warehouseId) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch = $this->instantiate($id);
            $this->loadState($branch);

            $branch->addDetail($warehouseId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailWarehouse', array('branch' => $branch), false, true);
        }
    }

    //Delete Warehouse Detail
    public function actionAjaxHtmlRemoveWarehouseDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $branch = $this->instantiate($id);
            $this->loadState($branch);

            $branch->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailWarehouse', array('branch' => $branch), false, true);
        }
    }

    //Add Division Detail
    public function actionAjaxHtmlAddDivisionDetail($id, $divisionId) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch = $this->instantiate($id);
            $this->loadState($branch);

            $branch->addDivisionDetail($divisionId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailDivision', array('branch' => $branch), false, true);
        }
    }

    //Delete Division Detail
    public function actionAjaxHtmlRemoveDivisionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $branch = $this->instantiate($id);
            $this->loadState($branch);

            $branch->removeDivisionDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailDivision', array('branch' => $branch), false, true);
        }
    }

    //Add PhoneDetail
    public function actionAjaxHtmlAddPhoneDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch = $this->instantiate($id);
            $this->loadState($branch);

            $branch->addPhoneDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPhone', array('branch' => $branch), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemovePhoneDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $branch = $this->instantiate($id);
            $this->loadState($branch);

            $branch->removePhoneDetailAt($index);
            $this->renderPartial('_detailPhone', array('branch' => $branch), false, true);
        }
    }

    //Add Fax Detail
    public function actionAjaxHtmlAddFaxDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch = $this->instantiate($id);
            $this->loadState($branch);

            $branch->addFaxDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailFax', array('branch' => $branch), false, true);
        }
    }

    //Delete Mobile Detail
    public function actionAjaxHtmlRemoveFaxDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $branch = $this->instantiate($id);
            $this->loadState($branch);

            $branch->removeFaxDetailAt($index);
            $this->renderPartial('_detailFax', array('branch' => $branch), false, true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $branch = new Branches(new Branch(), array(), array(), array(), array(), array());
        } else {
            $branchModel = $this->loadModel($id);
            $branch = new Branches($branchModel, $branchModel->divisionBranches, $branchModel->branchWarehouses, $branchModel->branchPhones, $branchModel->branchFaxes, $branchModel->branchCoaInterbranches);
        }
        return $branch;
    }

    public function instantiateInterbranch($id) {
        if (empty($id)) {
            $branch = new Branches(new Branch(), array(), array(), array(), array(), array());
        } else {
            $branchModel = $this->loadModel($id);
            $branch = new Branches($branchModel, array(), array(), array(), array(), $branchModel->branchCoaInterbranches);
        }
        return $branch;
    }

    public function loadState($branch) {
        if (isset($_POST['Branch'])) {
            $branch->header->attributes = $_POST['Branch'];
        }
        if (isset($_POST['BranchWarehouse'])) {
            foreach ($_POST['BranchWarehouse'] as $i => $item) {
                if (isset($branch->warehouseDetails[$i]))
                    $branch->warehouseDetails[$i]->attributes = $item;
                else {
                    $detail = new BranchWarehouse();
                    $detail->attributes = $item;
                    $branch->warehouseDetails[] = $detail;
                }
            }
            if (count($_POST['BranchWarehouse']) < count($branch->warehouseDetails))
                array_splice($branch->warehouseDetails, $i + 1);
        } else
            $branch->warehouseDetails = array();

        if (isset($_POST['DivisionBranch'])) {
            foreach ($_POST['DivisionBranch'] as $i => $item) {
                if (isset($branch->divisionDetails[$i]))
                    $branch->divisionDetails[$i]->attributes = $item;
                else {
                    $detail = new DivisionBranch();
                    $detail->attributes = $item;
                    $branch->divisionDetails[] = $detail;
                }
            }
            if (count($_POST['DivisionBranch']) < count($branch->divisionDetails))
                array_splice($branch->divisionDetails, $i + 1);
        } else
            $branch->divisionDetails = array();

        if (isset($_POST['BranchPhone'])) {
            foreach ($_POST['BranchPhone'] as $i => $item) {
                if (isset($branch->phoneDetails[$i]))
                    $branch->phoneDetails[$i]->attributes = $item;
                else {
                    $detail = new BranchPhone();
                    $detail->attributes = $item;
                    $branch->phoneDetails[] = $detail;
                }
            }
            if (count($_POST['BranchPhone']) < count($branch->phoneDetails))
                array_splice($branch->phoneDetails, $i + 1);
        } else
            $branch->phoneDetails = array();

        if (isset($_POST['BranchFax'])) {
            foreach ($_POST['BranchFax'] as $i => $item) {
                if (isset($branch->faxDetails[$i]))
                    $branch->faxDetails[$i]->attributes = $item;
                else {
                    $detail = new BranchFax();
                    $detail->attributes = $item;
                    $branch->faxDetails[] = $detail;
                }
            }
            if (count($_POST['BranchFax']) < count($branch->faxDetails))
                array_splice($branch->faxDetails, $i + 1);
        } else
            $branch->faxDetails = array();
        
        if (isset($_POST['BranchCoaInterbranch'])) {
            foreach ($_POST['BranchCoaInterbranch'] as $i => $item) {
                if (isset($branch->interbranchDetails[$i]))
                    $branch->interbranchDetails[$i]->attributes = $item;
                else {
                    $detail = new BranchCoaInterbranch();
                    $detail->attributes = $item;
                    $branch->interbranchDetails[] = $detail;
                }
            }
            if (count($_POST['BranchCoaInterbranch']) < count($branch->interbranchDetails))
                array_splice($branch->interbranchDetails, $i + 1);
        } else
            $branch->interbranchDetails = array();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Branch the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Branch::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Branch $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'branch-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxCoa($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $coa = Coa::model()->findByPk($id);

            $object = array(
                'id' => $coa->id,
                'code' => $coa->code,
                'name' => $coa->name,
            );

            echo CJSON::encode($object);
        }
    }

}
