<?php

class WarehouseController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    /**
     * @return array action filters
     */
    /* public function filters()
      {
      return array(
      'accessControl', // perform access control for CRUD operations
      'postOnly + delete', // we only allow deletion via POST request
      );
      }

      /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'ajaxHtmlAddBranchDetail', 'ajaxHtmlRemoveBranchDetail', 'ajaxHtmlAddDivisionDetail', 'ajaxHtmlRemoveDivisionDetail', 'ajaxHtmlAddSectionDetail', 'ajaxProduct', 'ajaxHtmlRemoveSectionDetail', 'ajaxAssignSection'),
                'users' => array('Admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $branchesWarehouses = BranchWarehouse::model()->findAllByAttributes(array('warehouse_id' => $id));
        $warehouseDivisions = WarehouseDivision::model()->findAllByAttributes(array('warehouse_id' => $id));
        $warehouseSections = WarehouseSection::model()->findAllByAttributes(array('warehouse_id' => $id));
        
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'branchesWarehouses' => $branchesWarehouses,
            'warehouseDivisions' => $warehouseDivisions,
            'warehouseSections' => $warehouseSections,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //$model=new Warehouse;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['Warehouse']))
        // {
        // 	$model->attributes=$_POST['Warehouse'];
        // 	$model->status='Active';
        // 	if($model->save())
        // 		$this->redirect(array('admin'));
        // 		//$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('create',array(
        // 	'model'=>$model,
        // ));
        $warehouse = $this->instantiate(null);

        $branch = new Warehouse('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Branch']))
            $branch->attributes = $_GET['Branch'];

        $branchCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
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

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Product']))
            $product->attributes = $_GET['Product'];

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('name', $product->name, true);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $this->performAjaxValidation($warehouse->header);

        if (isset($_POST['Warehouse'])) {
            $this->loadState($warehouse);
            
            if ($warehouse->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $warehouse->header->id));
            }
        }

        $this->render('create', array(
            'warehouse' => $warehouse,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
            'division' => $division,
            'divisionDataProvider' => $divisionDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
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
        // if(isset($_POST['Warehouse']))
        // {
        // 	$model->attributes=$_POST['Warehouse'];
        // 	if($model->save())
        // 		$this->redirect(array('admin'));
        // 		//$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('update',array(
        // 	'model'=>$model,
        // ));

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Branch']))
            $branch->attributes = $_GET['Branch'];

        $branchCriteria = new CDbCriteria;
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
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

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $product->attributes = $_GET['Product'];

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('name', $product->name, true);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $warehouse = $this->instantiate($id);

        $this->performAjaxValidation($warehouse->header);

        if (isset($_POST['Warehouse'])) {
            $this->loadState($warehouse);
            
            if ($warehouse->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $warehouse->header->id));
            } 
        }
        $this->render('update', array(
            'warehouse' => $warehouse,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
            'division' => $division,
            'divisionDataProvider' => $divisionDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
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
        $dataProvider = new CActiveDataProvider('Warehouse');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Warehouse('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Warehouse']))
            $model->attributes = $_GET['Warehouse'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    //Add Branch Detail
    public function actionAjaxHtmlAddBranchDetail($id, $branchId) {
        if (Yii::app()->request->isAjaxRequest) {
            $warehouse = $this->instantiate($id);
            $this->loadState($warehouse);

            $warehouse->addDetail($branchId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailBranch', array('warehouse' => $warehouse), false, true);
        }
    }

    //Delete Branch Detail
    public function actionAjaxHtmlRemoveBranchDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $warehouse = $this->instantiate($id);
            $this->loadState($warehouse);
            $warehouse->removeDetailAt($index);
            
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailBranch', array('warehouse' => $warehouse), false, true);
        }
    }

    //Add Division Detail
    public function actionAjaxHtmlAddDivisionDetail($id, $divisionId) {
        if (Yii::app()->request->isAjaxRequest) {
            $warehouse = $this->instantiate($id);
            $this->loadState($warehouse);

            $warehouse->addDivisionDetail($divisionId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailDivision', array('warehouse' => $warehouse), false, true);
        }
    }

    //Delete Division Detail
    public function actionAjaxHtmlRemoveDivisionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $warehouse = $this->instantiate($id);
            $this->loadState($warehouse);
            $warehouse->removeDivisionDetailAt($index);
            
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailDivision', array('warehouse' => $warehouse), false, true);
        }
    }

    //Add Section Detail
    public function actionAjaxHtmlAddSectionDetail($id, $column, $row) {
        if (Yii::app()->request->isAjaxRequest) {
            $warehouse = $this->instantiate($id);
            $this->loadState($warehouse);

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            
            if (isset($_GET['Product']))
                $product->attributes = $_GET['Product'];

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);

            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));

            $warehouse->addSectionDetail($column, $row);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailSection', array('warehouse' => $warehouse, 'product' => $product, 'productDataProvider' => $productDataProvider), false, true);
        }
    }

    //Add Section Detail
    public function actionAjaxAssignSection($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $warehouse = $this->instantiate($id);
            $this->loadState($warehouse);

            $warehouse->assignSection($id);
        }
    }

    public function actionAjaxProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);

            $object = array(
                'name' => $product->name,
            );

            echo CJSON::encode($object);
        }
    }

    //Delete Division Detail
    public function actionAjaxHtmlRemoveSectionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $warehouse = $this->instantiate($id);
            $this->loadState($warehouse);

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product']))
                $product->attributes = $_GET['Product'];

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);

            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));

            $warehouse->removeSectionDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailSection', array('warehouse' => $warehouse, 'product' => $product, 'productDataProvider' => $productDataProvider), false, true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $warehouse = new Warehouses(new Warehouse(), array(), array(), array());
        } else {
            $warehouseModel = $this->loadModel($id);
            $warehouse = new Warehouses($warehouseModel, $warehouseModel->branchWarehouses, $warehouseModel->warehouseDivisions, $warehouseModel->warehouseSections);
        }
        return $warehouse;
    }

    public function loadState($warehouse) {
        if (isset($_POST['Warehouse'])) {
            $warehouse->header->attributes = $_POST['Warehouse'];
        }

        if (isset($_POST['BranchWarehouse'])) {
            foreach ($_POST['BranchWarehouse'] as $i => $item) {
                if (isset($warehouse->branchDetails[$i]))
                    $warehouse->branchDetails[$i]->attributes = $item;
                else {
                    $detail = new BranchWarehouse();
                    $detail->attributes = $item;
                    $warehouse->branchDetails[] = $detail;
                }
            }
            if (count($_POST['BranchWarehouse']) < count($warehouse->branchDetails))
                array_splice($warehouse->branchDetails, $i + 1);
        } else
            $warehouse->branchDetails = array();

        if (isset($_POST['WarehouseDivision'])) {
            foreach ($_POST['WarehouseDivision'] as $i => $item) {
                if (isset($warehouse->divisionDetails[$i]))
                    $warehouse->divisionDetails[$i]->attributes = $item;
                else {
                    $detail = new WarehouseDivision();
                    $detail->attributes = $item;
                    $warehouse->divisionDetails[] = $detail;
                }
            }
            
            if (count($_POST['WarehouseDivision']) < count($warehouse->divisionDetails))
                array_splice($warehouse->divisionDetails, $i + 1);
        } else
            $warehouse->divisionDetails = array();

        if (isset($_POST['WarehouseSection'])) {
            foreach ($_POST['WarehouseSection'] as $i => $item) {
                if (isset($warehouse->sectionDetails[$i]))
                    $warehouse->sectionDetails[$i]->attributes = $item;
                else {
                    $detail = new WarehouseSection();
                    $detail->attributes = $item;
                    $warehouse->sectionDetails[] = $detail;
                }
            }
            
            if (count($_POST['WarehouseSection']) < count($warehouse->sectionDetails))
                array_splice($warehouse->sectionDetails, $i + 1);
        }
        else
            $warehouse->sectionDetails = array();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Warehouse the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Warehouse::model()->findByPk($id);
        
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Warehouse $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'warehouse-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
