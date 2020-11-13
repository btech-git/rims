<?php

class ConsignmentOutHeaderController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    /* public function filters()
      {
      return array(
      'accessControl', // perform access control for CRUD operations
      'postOnly + delete', // we only allow deletion via POST request
      );
      } */

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
                'actions' => array('admin', 'delete', 'ajaxHtmlAddDetail', 'ajaxHtmlRemoveDetail', 'ajaxProduct', 'ajaxGetTotal', 'ajaxCustomer', 'updateStatus', 'updateApproval'),
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
        $details = ConsignmentOutDetail::model()->findAllByAttributes(array('consignment_out_id' => $id));
        $historis = ConsignmentOutApproval::model()->findAllByAttributes(array('consignment_out_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'details' => $details,
            'historis' => $historis,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //$model=new ConsignmentOutHeader;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);



        $consignmentOut = $this->instantiate(null);
        $consignmentOut->header->branch_id = $consignmentOut->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $consignmentOut->header->branch_id;
//        $consignmentOut->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($consignmentOut->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($consignmentOut->header->date_posting)), $consignmentOut->header->branch_id);
        $this->performAjaxValidation($consignmentOut->header);
        
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }
    
        $customerCriteria = new CDbCriteria;
        $customerCriteria->addCondition('customer_type = "company"');
        $customerCriteria->compare('t.name', $customer->name, true);
        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $product->attributes = $_GET['Product'];

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));
 
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['ConsignmentOutHeader'])) {
            $this->loadState($consignmentOut);
            $consignmentOut->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($consignmentOut->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($consignmentOut->header->date_posting)), $consignmentOut->header->branch_id);
            
            if ($consignmentOut->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $consignmentOut->header->id));
            }
        }

        $this->render('create', array(
            'consignmentOut' => $consignmentOut,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
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
        $consignmentOut = $this->instantiate($id);
        $consignmentOut->header->setCodeNumberByRevision('consignment_out_number');
        $this->performAjaxValidation($consignmentOut->header);

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer']))
            $customer->attributes = $_GET['Customer'];
        $customerCriteria = new CDbCriteria;
        $customerCriteria->addCondition('customer_type = "company"');
        $customerCriteria->compare('name', $customer->name, true);
        $customerDataProvider = new CActiveDataProvider('Customer', array(
                    'criteria' => $customerCriteria,
                ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $product->attributes = $_GET['Product'];

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('name', $product->name, true);
        $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->together = true;
        $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
        $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
        $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
        $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
        $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
        $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
        $productDataProvider = new CActiveDataProvider('Product', array(
                    'criteria' => $productCriteria,));

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['ConsignmentOutHeader'])) {
            // $model->attributes=$_POST['ConsignmentOutHeader'];
            // if($model->save())
            // 	$this->redirect(array('view','id'=>$model->id));

            $this->loadState($consignmentOut);
            if ($consignmentOut->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $consignmentOut->header->id));
            }
        }

        $this->render('update', array(
            'consignmentOut' => $consignmentOut,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
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
        $dataProvider = new CActiveDataProvider('ConsignmentOutHeader');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ConsignmentOutHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ConsignmentOutHeader']))
            $model->attributes = $_GET['ConsignmentOutHeader'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ConsignmentOutHeader the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ConsignmentOutHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ConsignmentOutHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'consignment-out-header-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $consignmentOut = new ConsignmentOuts(new ConsignmentOutHeader(), array());
        } else {
            $consignmentOutModel = $this->loadModel($id);
            $consignmentOut = new ConsignmentOuts($consignmentOutModel, $consignmentOutModel->consignmentOutDetails);
            //print_r("test");
        }
        return $consignmentOut;
    }

    public function loadState($consignmentOut) {
        if (isset($_POST['ConsignmentOutHeader'])) {
            $consignmentOut->header->attributes = $_POST['ConsignmentOutHeader'];
        }


        if (isset($_POST['ConsignmentOutDetail'])) {
            foreach ($_POST['ConsignmentOutDetail'] as $i => $item) {
                if (isset($consignmentOut->details[$i])) {
                    $consignmentOut->details[$i]->attributes = $item;
                } else {
                    $detail = new ConsignmentOutDetail();
                    $detail->attributes = $item;
                    $consignmentOut->details[] = $detail;
                }
            }
            if (count($_POST['ConsignmentOutDetail']) < count($consignmentOut->details))
                array_splice($consignmentOut->details, $i + 1);
        }
        else {
            $consignmentOut->details = array();
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;

            $productCriteria->together = true;
            $productCriteria->select = 't.id,t.name, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('t.name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->compare('findkeyword', $product->findkeyword, true);
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                        'criteria' => $productCriteria,
                    ));

            $consignmentOut = $this->instantiate($id);
            $this->loadState($consignmentOut);

            $consignmentOut->addDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array(
                'consignmentOut' => $consignmentOut,
                'product' => $product,
                'productDataProvider' => $productDataProvider,
                    ), false, true);
        }
    }

    //Add Detail
//	public function actionAjaxHtmlAddDetail($id)
//	{
//		if (Yii::app()->request->isAjaxRequest)
//		{
//			$product = new Product('search');
//	      	$product->unsetAttributes();  // clear any default values
//	      	if (isset($_GET['Product']))
//	        	$product->attributes = $_GET['Product'];
//
//			$productCriteria = new CDbCriteria;
//			$productCriteria->compare('name',$product->name,true);
//			$productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
//			$productCriteria->together=true;
//			$productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
//					$productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
//					$productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
//					$productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
//					$productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
//					$productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
//			$productDataProvider = new CActiveDataProvider('Product', array(
//			    	'criteria'=>$productCriteria,));
//
//			$consignmentOut = $this->instantiate($id); 	
//			$this->loadState($consignmentOut);
//			
//			$consignmentOut->addDetail();
//			// Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
//   // 			Yii::app()->clientscript->scriptMap['jquery.js'] = false;
//   // 			Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
//      		$this->renderPartial('_detail', array('consignmentOut'=>$consignmentOut,'product'=>$product,
//			'productDataProvider'=>$productDataProvider,
//      	
//      	), false, true);
//		}
//	}
    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product']))
                $product->attributes = $_GET['Product'];

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                        'criteria' => $productCriteria,));

            $consignmentOut = $this->instantiate($id);
            $this->loadState($consignmentOut);

            $consignmentOut->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            //Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('consignmentOut' => $consignmentOut, 'product' => $product,
                'productDataProvider' => $productDataProvider,
                    ), false, true);
        }
    }

    public function actionAjaxProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);

            $object = array(
                'id' => $product->id,
                'name' => $product->name,
                'retail_price' => $product->retail_price,
                'hpp' => $product->hpp,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $consignmentOut = $this->instantiate($id);
            $this->loadState($consignmentOut);
            //$requestType =$requestOrder->header->request_type;
            $total = 0;
            $total_items = 0;
            foreach ($consignmentOut->details as $key => $detail) {
                $total_items += $detail->quantity;
                $total += $detail->total_price;
            }
            $object = array('total' => $total, 'total_items' => $total_items);
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $customer = Customer::model()->findByPk($id);
            //$tanggal = empty($_POST['TransactionPurchaseOrder']['purchase_order_date'])?date('Y-m-d'): $_POST['TransactionPurchaseOrder']['purchase_order_date'] ;
            //$tanggal_jatuh_tempo = date('Y-m-d', strtotime( $tanggal .'+'.$supplier->tenor . ' days'));
            //$paymentEstimation= $tanggal_jatuh_tempo;
            //$supplier = Supplier::model()->findByPk($productPrice->supplier_id);

            $object = array(
                //'id'=>$supplier->id,
                'name' => $customer->name,
                    //'paymentEstimation'=>$paymentEstimation,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateStatus($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['ConsignmentOutHeader'])) {
            $model->status = $_POST['ConsignmentOutHeader']['status'];
            $model->approved_by = $_POST['ConsignmentOutHeader']['approved_by'];




            if ($model->update(array('status', 'approved_by')))
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('updateStatus', array(
            'model' => $model,
                //'jenisPersediaan'=>$jenisPersediaan,
                //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $consignment = ConsignmentOutHeader::model()->findByPK($headerId);
        $historis = ConsignmentOutApproval::model()->findAllByAttributes(array('consignment_out_id' => $headerId));
        $model = new ConsignmentOutApproval;
        $model->date = date('Y-m-d H:i:s');
        $branch = Branch::model()->findByPk($consignment->branch_id);
        //$model = $this->loadModelDetail($detailId);
        if (isset($_POST['ConsignmentOutApproval'])) {
            $model->attributes = $_POST['ConsignmentOutApproval'];
            if ($model->save()) {
                $consignment->status = $model->approval_type;
                $consignment->save(false);
                
                if ($consignment->status == "Approved") {
                    if ($consignment->customer->coa_id != "") {
                        $coaPiutang = Coa::model()->findByPk($consignment->customer->coa_id);
                        $getCoaPiutang = $coaPiutang->code;
                    } else {
                        $getCoaPiutang = '105.00.000';
                    }

                    $coaPiutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPiutang));
                    $jurnalUmumPiutang = new JurnalUmum;
                    $jurnalUmumPiutang->kode_transaksi = $consignment->consignment_out_no;
                    $jurnalUmumPiutang->tanggal_transaksi = $consignment->date_posting;
                    $jurnalUmumPiutang->coa_id = $coaPiutangWithCode->id;
                    $jurnalUmumPiutang->branch_id = $consignment->branch_id;
                    $jurnalUmumPiutang->total = $consignment->total_price;
                    $jurnalUmumPiutang->debet_kredit = 'D';
                    $jurnalUmumPiutang->tanggal_posting = date('Y-m-d');
                    $jurnalUmumPiutang->transaction_subject = $consignment->customer->name;
                    $jurnalUmumPiutang->is_coa_category = 0;
                    $jurnalUmumPiutang->transaction_type = 'CSO';
                    $jurnalUmumPiutang->save();

                    foreach ($consignment->consignmentOutDetails as $key => $coDetail) {
                        $coaMasterGroupConsignment = Coa::model()->findByAttributes(array('code'=> '106.00.000'));
                        $jurnalUmumMasterGroupConsignment = new JurnalUmum;
                        $jurnalUmumMasterGroupConsignment->kode_transaksi = $consignment->consignment_out_no;
                        $jurnalUmumMasterGroupConsignment->tanggal_transaksi = $consignment->date_posting;
                        $jurnalUmumMasterGroupConsignment->coa_id = $coaMasterGroupConsignment->id;
                        $jurnalUmumMasterGroupConsignment->branch_id = $consignment->branch_id;
                        $jurnalUmumMasterGroupConsignment->total = $coDetail->total_price;
                        $jurnalUmumMasterGroupConsignment->debet_kredit = 'K';
                        $jurnalUmumMasterGroupConsignment->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterGroupConsignment->transaction_subject = $consignment->customer->name;
                        $jurnalUmumMasterGroupConsignment->is_coa_category = 1;
                        $jurnalUmumPiutang->transaction_type = 'CSO';
                        $jurnalUmumMasterGroupConsignment->save();

                        //save product master coa consignment inventory
                        $coaMasterConsignment = Coa::model()->findByPk($coDetail->product->productMasterCategory->coaConsignmentInventory->id);
                        $getCoaMasterConsignment = $coaMasterConsignment->code;
                        $coaMasterConsignmentWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaMasterConsignment));
                        $jurnalUmumMasterConsignment = new JurnalUmum;
                        $jurnalUmumMasterConsignment->kode_transaksi = $consignment->consignment_out_no;
                        $jurnalUmumMasterConsignment->tanggal_transaksi = $consignment->date_posting;
                        $jurnalUmumMasterConsignment->coa_id = $coaConsignmentWithCode->id;
                        $jurnalUmumMasterConsignment->branch_id = $consignment->branch_id;
                        $jurnalUmumMasterConsignment->total = $coDetail->total_price;
                        $jurnalUmumMasterConsignment->debet_kredit = 'K';
                        $jurnalUmumMasterConsignment->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterConsignment->transaction_subject = $consignment->customer->name;
                        $jurnalUmumMasterConsignment->is_coa_category = 1;
                        $jurnalUmumPiutang->transaction_type = 'CSO';
                        $jurnalUmumMasterConsignment->save();
                        //save product sub master coa consignment inventory
                        
                        $coaConsignment = Coa::model()->findByPk($coDetail->product->productSubMasterCategory->coaConsignmentInventory->id);
                        $getCoaConsignment = $coaConsignment->code;
                        $coaConsignmentWithCode = Coa::model()->findByAttributes(array('code' => $getCoaConsignment));
                        $jurnalUmumConsignment = new JurnalUmum;
                        $jurnalUmumConsignment->kode_transaksi = $consignment->consignment_out_no;
                        $jurnalUmumConsignment->tanggal_transaksi = $consignment->date_posting;
                        $jurnalUmumConsignment->coa_id = $coaConsignmentWithCode->id;
                        $jurnalUmumConsignment->branch_id = $consignment->branch_id;
                        $jurnalUmumConsignment->total = $coDetail->total_price;
                        $jurnalUmumConsignment->debet_kredit = 'K';
                        $jurnalUmumConsignment->tanggal_posting = date('Y-m-d');
                        $jurnalUmumConsignment->transaction_subject = $consignment->customer->name;
                        $jurnalUmumConsignment->is_coa_category = 0;
                        $jurnalUmumPiutang->transaction_type = 'CSO';
                        $jurnalUmumConsignment->save();
                    }
                }
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'consignment' => $consignment,
            'historis' => $historis,
                //'jenisPersediaan'=>$jenisPersediaan,
                //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));
    }

}
