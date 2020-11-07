<?php

class StockAdjustmentController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    // public function filters()
    // {
    // 	return array(
    // 		'accessControl', // perform access control for CRUD operations
    // 		'postOnly + delete', // we only allow deletion via POST request
    // 	);
    // }
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
                'actions' => array('admin', 'delete'),
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
        $modelDetail = $this->loadModelDetail($id);
        $listApproval = StockAdjustmentApproval::model()->findAllByAttributes(array('stock_adjustment_header_id' => $id));
        $product = new Product('search');
        $warehouse = Warehouse::model()->findAll();


        $this->render('view', array(
            'model' => $this->loadModel($id),
            'modelDetail' => $modelDetail,
            'product' => $product,
            'warehouse' => $warehouse,
            'listApproval' => $listApproval,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new StockAdjustmentHeader;
        $modelDetail = new StockAdjustmentDetail;
        $product = new Product('search');
        $warehouse = Warehouse::model()->findAll();

        $model->branch_id = $model->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $model->branch_id;
        $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->date_posting)), $model->branch_id);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['StockAdjustmentHeader'])) {
            $jumlahDetail = count($_POST['StockAdjustmentDetail']['id']);
            $model->attributes = $_POST['StockAdjustmentHeader'];
            $model->note = $_POST['StockAdjustmentHeader']['note'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->date_posting)), $model->branch_id);
            
            if ($model->save()) {
                for ($i = 1; $i <= $jumlahDetail;) {
                    foreach ($_POST['warehouse_id'] as $key => $value) {
                        // save semua warehouse jika wh_id > 0 atau < 0
                        if ($value[$i - 1] > 0) { // save stock in
                            $modelDetail = new StockAdjustmentDetail;
                            $modelDetail->stock_adjustment_header_id = $model->id;
                            $modelDetail->warehouse_id = $key;
                            $modelDetail->product_id = $_POST['StockAdjustmentDetail']['id'][$i - 1];
                            $modelDetail->stock_out = 0;
                            $modelDetail->stock_in = $value[$i - 1];
                            $modelDetail->save();
                        } elseif ($value[$i - 1] < 0) { // save stock out
                            $modelDetail = new StockAdjustmentDetail;
                            $modelDetail->stock_adjustment_header_id = $model->id;
                            $modelDetail->warehouse_id = $key;
                            $modelDetail->product_id = $_POST['StockAdjustmentDetail']['id'][$i - 1];
                            $modelDetail->stock_out = $value[$i - 1];
                            $modelDetail->stock_in = 0;
                            $modelDetail->save();
                        }
                    }
                    $i++;
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'product' => $product,
            'warehouse' => $warehouse,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modelDetail = $this->loadModelDetail($id);
        $listApproval = StockAdjustmentApproval::model()->findAllByAttributes(array('stock_adjustment_header_id' => $id));
        $modelApproval = new StockAdjustmentApproval;
        // var_dump($modelApproval); die("S");
        // var_dump($modelDetail); die("S");
        $product = new Product('search');
        $warehouse = Warehouse::model()->findAll();


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['StockAdjustmentHeader'])) {
            // var_dump($_POST['StockAdjustmentApproval']); die("S");

            $jumlahDetail = count($_POST['StockAdjustmentDetail']['id']);
            $model->attributes = $_POST['StockAdjustmentHeader'];
            $model->status = $_POST['StockAdjustmentApproval']['approval_type'];
            $model->note = $_POST['StockAdjustmentHeader']['note'];
            if ($model->save()) {
                $modelApproval->attributes = $_POST['StockAdjustmentApproval'];
                $modelApproval->save();
                for ($i = 1; $i <= $jumlahDetail;) {
                    foreach ($_POST['warehouse_id'] as $key => $value) {
                        // save semua warehouse jika wh_id > 0 atau < 0
                        // echo $id.$key.$_POST["StockAdjustmentDetail"]["id"][$i-1]; //die("S");
                        $productID = $_POST["StockAdjustmentDetail"]["id"][$i - 1];
                        // echo "<br >".$value[$i-1];
                        echo "<hr />";
                        $updateDetail = StockAdjustmentDetail::model()->findByAttributes(array('stock_adjustment_header_id' => $id, 'warehouse_id' => $key, 'product_id' => $productID));
                        if ($updateDetail != NULL) {

                            if ($value[$i - 1] > 0) { // save stock in
                                $updateDetail->stock_in = $value[$i - 1];
                                $updateDetail->save();
                            } elseif ($value[$i - 1] < 0) { // save stock out
                                $updateDetail->stock_out = $value[$i - 1];
                                $updateDetail->save();
                            }
                        } else {
                            if ($value[$i - 1] > 0) { // save stock in
                                $modelDetail = new StockAdjustmentDetail;
                                $modelDetail->stock_adjustment_header_id = $model->id;
                                $modelDetail->warehouse_id = $key;
                                $modelDetail->product_id = $_POST['StockAdjustmentDetail']['id'][$i - 1];
                                $modelDetail->stock_out = 0;
                                $modelDetail->stock_in = $value[$i - 1];
                                $modelDetail->save();
                            } elseif ($value[$i - 1] < 0) { // save stock out
                                $modelDetail = new StockAdjustmentDetail;
                                $modelDetail->stock_adjustment_header_id = $model->id;
                                $modelDetail->warehouse_id = $key;
                                $modelDetail->product_id = $_POST['StockAdjustmentDetail']['id'][$i - 1];
                                $modelDetail->stock_out = $value[$i - 1];
                                $modelDetail->stock_in = 0;
                                $modelDetail->save();
                            }
                        }
                    }
                    $i++;
                }
                // die(':S');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'product' => $product,
            'warehouse' => $warehouse,
            'modelApproval' => $modelApproval,
            'listApproval' => $listApproval,
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
        $dataProvider = new CActiveDataProvider('StockAdjustmentHeader');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new StockAdjustmentHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StockAdjustmentHeader']))
            $model->attributes = $_GET['StockAdjustmentHeader'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return StockAdjustmentHeader the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = StockAdjustmentHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelDetail($headerId) {
        $model = StockAdjustmentDetail::model()->findAllByAttributes(array('stock_adjustment_header_id' => $headerId));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionGetdefaultstock() {

        $product_id = $_POST['id'];
        // var_dump($product_id);//(!isset($_POST['id']))?$_POST['id']:$_POST['id'];
        //if (Yii::app()->request->isAjaxRequest){
        $warehouse = Warehouse::model()->findAll();

        $listwarehouse = '';
        foreach ($warehouse as $key) {
            $tok = Inventory::getTotalStock($product_id, $key->id);
            $listwarehouse .= "<td>"; //<input type=\"number\" placeholder=\"Stock\" class=\"stock_wh\" name=\"stock_wh_".$key->id."[]\"/>";
            $listwarehouse .= CHtml::numberField('warehouse_id[' . $key->id . '][]', '', array('placeholder' => 'Stock', 'class' => 'stock_wh'));
            $listwarehouse .= "<label class=\"sufix\">(" . $tok . ")</label></td>";
        }
        echo $listwarehouse;
        //}*/
    }

    /**
     * Performs the AJAX validation.
     * @param StockAdjustmentHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'stock-adjustment-header-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
