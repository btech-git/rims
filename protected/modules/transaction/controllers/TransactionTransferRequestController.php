<?php

class TransactionTransferRequestController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    /*public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }*/

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
                'actions' => array(
                    'admin',
                    'delete',
                    'ajaxHtmlAddDetail',
                    'ajaxProduct',
                    'ajaxHtmlRemoveDetail',
                    'ajaxGetTotal',
                    'UpdateApproval'
                ),
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
        $transferDetails = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'transferDetails' => $transferDetails,
        ));
    }

    public function loadModel($id)
    {
        $model = TransactionTransferRequest::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        // $model=new TransactionTransferRequest;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // if(isset($_POST['TransactionTransferRequest']))
        // {
        // 	$model->attributes=$_POST['TransactionTransferRequest'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        // $this->render('create',array(
        // 	'model'=>$model,
        // ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);
//        $productCriteria->together = true;
//        $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
//        $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
//        $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
//        $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,
//            true);
//        $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
//        $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $transferRequest = $this->instantiate(null);
        $transferRequest->header->requester_branch_id = $transferRequest->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $transferRequest->header->requester_branch_id;
        $transferRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($transferRequest->header->transfer_request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($transferRequest->header->transfer_request_date)), $transferRequest->header->requester_branch_id);
        $this->performAjaxValidation($transferRequest->header);
        if (isset($_POST['TransactionTransferRequest'])) {

            $this->loadState($transferRequest);

            if ($transferRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $transferRequest->header->id));
            }
        }

        $this->render('create', array(
            'transferRequest' => $transferRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function instantiate($id)
    {
        if (empty($id)) {
            $transferRequest = new TransferRequests(new TransactionTransferRequest(), array());
            //print_r("test");
        } else {
            $transferRequestModel = $this->loadModel($id);
            $transferRequest = new TransferRequests($transferRequestModel,
                $transferRequestModel->transactionTransferRequestDetails);
            //print_r("test");
        }
        return $transferRequest;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionTransferRequest $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-transfer-request-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function loadState($transferRequest)
    {
        if (isset($_POST['TransactionTransferRequest'])) {
            $transferRequest->header->attributes = $_POST['TransactionTransferRequest'];
        }


        if (isset($_POST['TransactionTransferRequestDetail'])) {
            foreach ($_POST['TransactionTransferRequestDetail'] as $i => $item) {
                if (isset($transferRequest->details[$i])) {
                    $transferRequest->details[$i]->attributes = $item;

                } else {
                    $detail = new TransactionTransferRequestDetail();
                    $detail->attributes = $item;
                    $transferRequest->details[] = $detail;

                }
            }
            if (count($_POST['TransactionTransferRequestDetail']) < count($transferRequest->details)) {
                array_splice($transferRequest->details, $i + 1);
            }
        } else {
            $transferRequest->details = array();

        }


    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //$model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // if(isset($_POST['TransactionTransferRequest']))
        // {
        // 	$model->attributes=$_POST['TransactionTransferRequest'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        // $this->render('update',array(
        // 	'model'=>$model,
        // ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('name', $product->name, true);
        $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->together = true;
        $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
        $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
        $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
        $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,
            true);
        $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
        $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));
        //
        $transferRequest = $this->instantiate($id);
        $cashTransaction->header->setCodeNumberByRevision('transfer_request_no');

        $this->performAjaxValidation($transferRequest->header);

        if (isset($_POST['TransactionTransferRequest'])) {


            $this->loadState($transferRequest);
            if ($transferRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $transferRequest->header->id));
            } else {
                foreach ($transferRequest->details as $detail) {
                    echo $detail->quantity;
                }
            }

        }

        $this->render('update', array(
            'transferRequest' => $transferRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,

        ));


    }

    public function actionUpdateApproval($headerId)
    {
        $transferRequest = TransactionTransferRequest::model()->findByPk($headerId);
        //$transferRequestDetail = TransactionTransferRequestDetail::model()->findByPk($detailId);
        $historis = TransactionTransferRequestApproval::model()->findAllByAttributes(array('transfer_request_id' => $headerId));
        $model = new TransactionTransferRequestApproval;
        //$model = $this->loadModelDetail($detailId);
        if (isset($_POST['TransactionTransferRequestApproval'])) {
            $model->attributes = $_POST['TransactionTransferRequestApproval'];
            if ($model->save()) {
                $transferRequest->status_document = $model->approval_type;
                if ($model->approval_type == 'Approved') {
                    $transferRequest->approved_by = $model->supervisor_id;
                }
                $transferRequest->save(false);
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'transferRequest' => $transferRequest,
            //'transferRequestDetail'=>$transferRequestDetail,
            'historis' => $historis,
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
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

    //Add Detail

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('TransactionTransferRequest');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new TransactionTransferRequest('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionTransferRequest'])) {
            $model->attributes = $_GET['TransactionTransferRequest'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionTransferRequest the loaded model
     * @throws CHttpException
     */

    public function actionAjaxProduct($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $unit = "";
            $product = Product::model()->findByPk($id);
            $productUnit = ProductUnit::model()->findByAttributes(array(
                'product_id' => $product->id,
                'unit_type' => 'Main'
            ));
            if (count($productUnit) != 0) {
                $unit = $productUnit->unit_id;
            }

            $object = array(
                'id' => $product->id,
                'name' => $product->name,
                'retail_price' => $product->retail_price,
                'hpp' => $product->hpp,
                'unit' => $unit,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetTotal($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $transferRequest = $this->instantiate($id);
            $this->loadState($transferRequest);
            //$requestType =$transferRequest->header->request_type;
            $total = 0;
            $totalItems = 0;
            // if($requestType == 'Request for Purchase'){
            // 	foreach ($transferRequest->details as $key => $detail) {
            // 		$totalItems += $detail->total;
            // 		$total += $detail->subtotal;_quantity;
            // 	}
            // } else if($requestType == 'Request for Transfer'){
            // 	foreach ($transferRequest->transferDetails as $key => $transferDetail) {
            // 		$totalItems += $transferDetail->quantity;
            // 	}
            // }
            foreach ($transferRequest->details as $key => $detail) {
                $totalItems += $detail->quantity;
                $total += $detail->unit_price * $detail->quantity;
            }
            $object = array('total' => $total, 'totalItems' => $totalItems);
            echo CJSON::encode($object);

        }

    }

    public function actionAjaxHtmlAddDetail($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('t.name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,
                true);
            $productCriteria->compare('rims_product_sub_master_category.name',
                $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));
            $transferRequest = $this->instantiate($id);
            $this->loadState($transferRequest);

            $transferRequest->addDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial(
                '_detailTransferRequest',
                array(
                    'transferRequest' => $transferRequest,
                    'product' => $product,
                    'productDataProvider' => $productDataProvider,
                ),
                false,
                true
            );
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,
                true);
            $productCriteria->compare('rims_product_sub_master_category.name',
                $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));

            $transferRequest = $this->instantiate($id);
            $this->loadState($transferRequest);

            $transferRequest->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailTransferRequest', array(
                'transferRequest' => $transferRequest,
                'product' => $product,
                'productDataProvider' => $productDataProvider,

            ), false, true);
        }
    }
}
