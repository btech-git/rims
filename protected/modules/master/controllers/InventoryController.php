<?php

class InventoryController extends Controller
{
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
    public function accessRules()
    {
        return array(
            array(
                'allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'detail', 'ajaxHtmlInventoryPerWarehouse'),
                'users' => array('Admin'),
            ),
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    /*public function actionCreate()
    {
        $model=new Inventory;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Inventory']))
        {
            $model->attributes=$_POST['Inventory'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }*/

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Inventory'])) {
            $model->attributes = $_POST['Inventory'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Inventory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Inventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Inventory'])) {
            $model->attributes = $_GET['Inventory'];
        }


        //$sql='t.id, t.product_id, name as product_name, coalesce(sum(CASE WHEN warehouse_id = 1 THEN total_stock END), 0) Warehouse1';

        /* foreach ($warehouses as $key => $warehouse) {
         if ($key != $len - 1) {
             $sql .= 'coalesce(sum(CASE WHEN warehouse_id = ' . $warehouse->id . ' THEN total_stock END), 0) as Warehouse' . $warehouse->id . ',';
         } else {
             $sql .= 'coalesce(sum(CASE WHEN warehouse_id = ' . $warehouse->id . ' THEN total_stock END), 0) as Warehouse' . $warehouse->id;
         }
     }*/


        /*$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM rims_inventory')->queryScalar();
        $sql='SELECT rims_inventory.id, product_id, product.name as product_name, ';

        foreach ($warehouses as $key => $warehouse) {
            if ($key != $len - 1) {
                $sql .= 'coalesce(sum(CASE WHEN warehouse_id = ' . $warehouse->id . ' THEN total_stock END), 0) as Warehouse' . $warehouse->id . ',';
            } else {
                $sql .= 'coalesce(sum(CASE WHEN warehouse_id = ' . $warehouse->id . ' THEN total_stock END), 0) as Warehouse' . $warehouse->id;
            }
        }

        $sql .=' FROM rims_inventory JOIN rims_product product on product.id = rims_inventory.product_id GROUP BY product_id Order by product_id';
        $rawData=Yii::app()->db->createCommand($sql);
        $dataProvider=new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));*/

        $inventory2 = new Inventory('search');
        $inventory2->unsetAttributes();  // clear any default values
        if (isset($_GET['Inventory'])) {
            $inventory2->attributes = $_GET['Inventory'];
        }

        $inventory2Criteria = new CDbCriteria;
        $inventory2Criteria->together = true;
        $inventory2Criteria->with = array('product', 'inventoryDetails');

        //Query all warehouse
        $warehouses = Warehouse::model()->findAll();
        $len = count($warehouses);

        $selectArray = array(
            't.id',
            'product_id',
            'product.name as product_name',
            'product.manufacturer_code as manufacturer_code',
            'product.minimum_stock as minimum_stock'
        );

        foreach ($warehouses as $warehouse) {
            array_push($selectArray,
                'coalesce(sum(CASE WHEN inventoryDetails.warehouse_id = ' . $warehouse->id . ' THEN inventoryDetails.stock_in END) + sum(CASE WHEN inventoryDetails.warehouse_id = ' . $warehouse->id . ' THEN inventoryDetails.stock_out END), 0) as warehouse' . $warehouse->id);
        }

        $inventory2Criteria->compare('t.id', $inventory2->id);
        $inventory2Criteria->compare('t.product_id', $inventory2->product_id, false);
        $inventory2Criteria->compare('product.name', $inventory2->product_name, true);
        $inventory2Criteria->compare('product.minimum_stock', $inventory2->minimum_stock, true);
        $inventory2Criteria->compare('product.manufacturer_code', $inventory2->manufacturer_code, true);

        $inventory2Criteria->compare('product.brand_id', $inventory2->brand_id);
        $inventory2Criteria->compare('product.sub_brand_id', $inventory2->sub_brand_id);
        $inventory2Criteria->compare('product.sub_brand_series_id', $inventory2->sub_brand_series_id);
        $inventory2Criteria->compare('product.product_master_category_id', $inventory2->product_master_category_id);
        $inventory2Criteria->compare('product.product_sub_master_category_id',
            $inventory2->product_sub_master_category_id);
        $inventory2Criteria->compare('product.product_sub_category_id', $inventory2->product_sub_category_id);

        $explodeKeyword = explode(" ", $inventory2->findkeyword);

        foreach ($explodeKeyword as $key) {
            $inventory2Criteria->compare('product.code', $key, true, 'OR');
            $inventory2Criteria->compare('product.production_year', $key, true, 'OR');
            $inventory2Criteria->compare('product.manufacturer_code', $key, true, 'OR');
            $inventory2Criteria->compare('product.barcode', $key, true, 'OR');
            $inventory2Criteria->compare('product.name', $key, true, 'OR');
            $inventory2Criteria->compare('product.description', $key, true, 'OR');
            $inventory2Criteria->compare('product.extension', $key, true, 'OR');
        }

        $inventory2Criteria->select = $selectArray;
        $inventory2Criteria->group = 't.product_id';

        /*if(isset($_GET['Inventory']['warehouse1']) && $_GET['Inventory']['warehouse1'] != '') {
            $inventory2Criteria->having = 'warehouse1 = :warehouse1';
            $inventory2Criteria->params = array(':warehouse1' => $inventory2->warehouse1);
        }

        if(isset($_GET['Inventory']['warehouse2']) && $_GET['Inventory']['warehouse2'] != '') {
            $inventory2Criteria->having = 'warehouse2 = :warehouse2';
            $inventory2Criteria->params = array(':warehouse2' => $inventory2->warehouse2);
        }*/
        //echo json_encode($inventory2Criteria); die();
        $inventory2DataProvider = new CActiveDataProvider('Inventory', array(
            'criteria' => $inventory2Criteria,
            'sort' => array(
                'defaultOrder' => 't.id',
                'attributes' => array(
                    'product_name' => array(
                        'asc' => 'product.name ASC',
                        'desc' => 'product.name DESC',
                    ),
                    'manufacturer_code' => array(
                        'asc' => 'product.manufacturer_code ASC',
                        'desc' => 'product.manufacturer_code DESC',
                    ),
                    'minimum_stock' => array(
                        'asc' => 'product.minimum_stock ASC',
                        'desc' => 'product.minimum_stock DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),

        ));

        $this->render('admin', array(
            //'model'=>$model,
            //'dataProvider'=>$dataProvider,
            'inventory2' => $inventory2,
            'inventory2DataProvider' => $inventory2DataProvider
        ));
    }

    /**
     * Manages all models.
     */
    public function actionDetail($product_id)
    {
        // $details= InventoryDetail::model()->findAllByAttributes(array('product_id'=>$product_id));
        // $details= InventoryDetail::model()->with(array('warehouse'=>array('condition'=>'status="Active"')))->findAllByAttributes(array('product_id'=>$product_id));
        $details = InventoryDetail::model()->with(array('warehouse' => array('condition' => 'status="Active"')))->findAll('product_id = ' . $product_id . ' AND inventory_id !=""');

        $this->render('detail', array(
            'details' => $details,
        ));
    }

    public function actionAjaxHtmlInventoryPerWarehouse()
    {
        if (Yii::app()->request->isAjaxRequest) {
            //$model = $this->loadModel($id);

            //$inventory = ProductPrice::model()->findAllByAttributes(array('product_id'=>$id));
            $model = Inventory::model()->findAll();


            $this->renderPartial('_inventory-per-warehouse-dialog', array(
                'model' => $model,
            ), false, true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Inventory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Inventory::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Inventory $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionAjaxGetProductSubMasterCategory()
    {
        $data = ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $_POST['Inventory']['product_master_category_id']),
            array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Master Category--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Master Category--]', true);
        }
    }

    public function actionAjaxGetSubBrand()
    {
        $data = SubBrand::model()->findAllByAttributes(array('brand_id' => $_POST['Inventory']['brand_id']),
            array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand--]', true);
        }
    }

    public function actionAjaxGetSubBrandSeries()
    {
        if (isset($_POST['Inventory'])) {
            $data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $_POST['Inventory']['sub_brand_id']),
                array('order' => 'name'));
        }
        if (isset($_POST['Inventory'])) {
            $data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $_POST['Inventory']['sub_brand_id']),
                array('order' => 'name'));
        }
        if (isset($_POST['Inventory'])) {
            $data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $_POST['Inventory']['sub_brand_id']),
                array('order' => 'name'));
        }

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand Series--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand Series--]', true);
        }
    }

    public function actionAjaxGetProductSubCategory()
    {
        $data = ProductSubCategory::model()->findAllByAttributes(array(
            'product_master_category_id' => $_POST['Inventory']['product_master_category_id'],
            'product_sub_master_category_id' => $_POST['Inventory']['product_sub_master_category_id']
        ), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Category--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Category--]', true);
        }
    }

    public function actionAjaxGetCode()
    {
        $code = ProductMasterCategory::model()->findByPk($_POST['Inventory']['product_master_category_id'])->code . ProductSubMasterCategory::model()->findByPk($_POST['Inventory']['product_sub_master_category_id'])->code . ProductSubCategory::model()->findByPk($_POST['Inventory']['product_sub_category_id'])->code;

        echo $code;
    }

	public function actionStock()
	{
		$this->layout = '//layouts/column1';
        
		$product = new Product('search');
		$product->unsetAttributes();
		if (isset($_GET['Product']))
			$product->attributes = $_GET['Product'];

		$pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '1000';
		$currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';

		$dataProvider = $product->search();

		$page = array('size' => $pageSize, 'current' => $currentPage);

		$dataProvider = ReportHelper::finalizeDataProvider($dataProvider, $page);

		$this->render('stock', array(
			'product' => $product,
			'dataProvider' => $dataProvider,
		));
	}
}
