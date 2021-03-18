<?php

class ConsignmentInHeaderController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'updateApproval' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('consignmentInCreate')) || !(Yii::app()->user->checkAccess('consignmentInEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $details = ConsignmentInDetail::model()->findAllByAttributes(array('consignment_in_id' => $id));
        $historis = ConsignmentInApproval::model()->findAllByAttributes(array('consignment_in_id' => $id));
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
        
        $consignmentIn = $this->instantiate(null);
        $consignmentIn->header->receive_branch = $consignmentIn->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $consignmentIn->header->receive_branch;
//        $consignmentIn->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($consignmentIn->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($consignmentIn->header->date_posting)), $consignmentIn->header->receive_branch);
        $this->performAjaxValidation($consignmentIn->header);
        
        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }
        
        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('t.name', $supplier->name, true);
        $supplierCriteria->together = true;
        $supplierCriteria->select = 't.id,t.name,rims_product.id, rims_product.name as product_name';
        $supplierCriteria->join = 'join rims_supplier_product on t.id = rims_supplier_product.supplier_id join rims_product on rims_product.id = rims_supplier_product.product_id';
        $supplierCriteria->compare('rims_product.name ', $supplier->product_name, true);
        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

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

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['ConsignmentInHeader'])) {

            $this->loadState($consignmentIn);
            $consignmentIn->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($consignmentIn->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($consignmentIn->header->date_posting)), $consignmentIn->header->receive_branch);
            
            if ($consignmentIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $consignmentIn->header->id));
            }
        }

        $this->render('create', array(
            //'model'=>$model,
            'consignmentIn' => $consignmentIn,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
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

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }
        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('t.name', $supplier->name, true);
        $supplierCriteria->together = true;
        $supplierCriteria->select = 't.*,rims_product.id, rims_product.name as product_name';
        $supplierCriteria->join = 'join rims_supplier_product on t.id = rims_supplier_product.supplier_id join rims_product on rims_product.id = rims_supplier_product.product_id';
        $supplierCriteria->compare('rims_product.name ', $supplier->product_name, true);
        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

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
        $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
        $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
        $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
        $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $consignmentIn = $this->instantiate($id);
        $consignmentIn->header->setCodeNumberByRevision('consignment_in_number');

        $this->performAjaxValidation($consignmentIn->header);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['ConsignmentInHeader'])) {
            $this->loadState($consignmentIn);
            if ($consignmentIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $consignmentIn->header->id));
            }
        }


        // if(isset($_POST['ConsignmentInHeader']))
        // {
        // 	$model->attributes=$_POST['ConsignmentInHeader'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        $this->render('update', array(
            //'model'=>$model,
            'consignmentIn' => $consignmentIn,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
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
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ConsignmentInHeader');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ConsignmentInHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ConsignmentInHeader'])) {
            $model->attributes = $_GET['ConsignmentInHeader'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ConsignmentInHeader the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ConsignmentInHeader::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ConsignmentInHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'consignment-in-header-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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

    public function instantiate($id) {
        if (empty($id)) {
            $consignmentIn = new ConsignmentIns(new ConsignmentInHeader(), array());
        } else {
            $consignmentInModel = $this->loadModel($id);
            $consignmentIn = new ConsignmentIns($consignmentInModel, $consignmentInModel->consignmentInDetails);
            //print_r("test");
        }
        return $consignmentIn;
    }

    public function loadState($consignmentIn) {
        if (isset($_POST['ConsignmentInHeader'])) {
            $consignmentIn->header->attributes = $_POST['ConsignmentInHeader'];
        }


        if (isset($_POST['ConsignmentInDetail'])) {
            foreach ($_POST['ConsignmentInDetail'] as $i => $item) {
                if (isset($consignmentIn->details[$i])) {
                    $consignmentIn->details[$i]->attributes = $item;
                } else {
                    $detail = new ConsignmentInDetail();
                    $detail->attributes = $item;
                    $consignmentIn->details[] = $detail;
                }
            }
            if (count($_POST['ConsignmentInDetail']) < count($consignmentIn->details)) {
                array_splice($consignmentIn->details, $i + 1);
            }
        } else {
            $consignmentIn->details = array();
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

            $consignmentIn = $this->instantiate($id);
            $this->loadState($consignmentIn);

            $consignmentIn->addDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array(
                'consignmentIn' => $consignmentIn,
                'product' => $product,
                'productDataProvider' => $productDataProvider,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
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
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));

            $consignmentIn = $this->instantiate($id);
            $this->loadState($consignmentIn);

            $consignmentIn->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array(
                'consignmentIn' => $consignmentIn,
                'product' => $product,
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
            $consignmentIn = $this->instantiate($id);
            $this->loadState($consignmentIn);
            //$requestType =$consignmentIn->header->request_type;
            $total = 0;
            $total_items = 0;
            foreach ($consignmentIn->details as $key => $detail) {
                $total_items += $detail->quantity;
                $total += $detail->total_price;
            }
            $object = array('total' => $total, 'total_items' => $total_items);
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $consignmentIn = $this->instantiate($id);
            $this->loadState($consignmentIn);

            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($consignmentIn->details[$index], 'total')));
            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $consignmentIn->totalQuantity));
            $totalPrice = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $consignmentIn->totalPrice));

            echo CJSON::encode(array(
                'total' => $total,
                'totalQuantity' => $totalQuantity,
                'totalPrice' => $totalPrice,
            ));
        }
    }

    public function actionAjaxSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $supplier = Supplier::model()->findByPk($id);
            //$tanggal = empty($_POST['TransactionPurchaseOrder']['purchase_order_date'])?date('Y-m-d'): $_POST['TransactionPurchaseOrder']['purchase_order_date'] ;
            //$tanggal_jatuh_tempo = date('Y-m-d', strtotime( $tanggal .'+'.$supplier->tenor . ' days'));
            //$paymentEstimation= $tanggal_jatuh_tempo;
            //$supplier = Supplier::model()->findByPk($productPrice->supplier_id);

            $object = array(
                //'id'=>$supplier->id,
                'name' => $supplier->name,
                    //'paymentEstimation'=>$paymentEstimation,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateApproval($headerId) {
        $consignment = ConsignmentInHeader::model()->findByPK($headerId);
        $historis = ConsignmentInApproval::model()->findAllByAttributes(array('consignment_in_id' => $headerId));
        $model = new ConsignmentInApproval;
        $model->date = date('Y-m-d H:i:s');
        $branch = Branch::model()->findByPK($consignment->receive_branch);
        //$model = $this->loadModelDetail($detailId);
        if (isset($_POST['ConsignmentInApproval'])) {
            $model->attributes = $_POST['ConsignmentInApproval'];
            if ($model->save()) {
                $consignment->status_document = $model->approval_type;
                $consignment->save(false);
                if ($consignment->status_document == "Approved") {

                    $coaHutang = Coa::model()->findByPk($consignment->supplier->coa_id);
                    $getCoaHutang = $coaHutang->code;
                    $coaHutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHutang));
                    $jurnalUmumHutang = new JurnalUmum;
                    $jurnalUmumHutang->kode_transaksi = $consignment->consignment_in_number;
                    $jurnalUmumHutang->tanggal_transaksi = $consignment->date_posting;
                    $jurnalUmumHutang->coa_id = $coaHutangWithCode->id;
                    $jurnalUmumHutang->branch_id = $consignment->receive_branch;
                    $jurnalUmumHutang->total = $consignment->total_price;
                    $jurnalUmumHutang->debet_kredit = 'K';
                    $jurnalUmumHutang->tanggal_posting = date('Y-m-d');
                    $jurnalUmumHutang->transaction_subject = $consignment->supplier->name;
                    $jurnalUmumHutang->is_coa_category = 0;
                    $jurnalUmumHutang->transaction_type = 'CSI';
                    $jurnalUmumHutang->save();

//                    $coaOutstanding = Coa::model()->findByPk($consignment->supplier->coa_outstanding_order);
//                    $jurnalUmumOutstanding = new JurnalUmum;
//                    $jurnalUmumOutstanding->kode_transaksi = $consignment->consignment_in_number;
//                    $jurnalUmumOutstanding->tanggal_transaksi = $consignment->date_posting;
//                    $jurnalUmumOutstanding->coa_id = $coaOutstanding->id;
//                    $jurnalUmumOutstanding->branch_id = $consignment->receive_branch;
//                    $jurnalUmumOutstanding->total = $consignment->total_price;
//                    $jurnalUmumOutstanding->debet_kredit = 'K';
//                    $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumOutstanding->transaction_subject = $consignment->supplier->name;
//                    $jurnalUmumOutstanding->is_coa_category = 0;
//                    $jurnalUmumOutstanding->transaction_type = 'CSI';
//                    $jurnalUmumOutstanding->save();

                    foreach ($consignment->consignmentInDetails as $key => $ciDetail) {
                        $coaMasterGroupConsignment = Coa::model()->findByAttributes(array('code' => '106.00.000'));
//                        $jurnalUmumMasterGroupConsignment = new JurnalUmum;
//                        $jurnalUmumMasterGroupConsignment->kode_transaksi = $consignment->consignment_in_number;
//                        $jurnalUmumMasterGroupConsignment->tanggal_transaksi = $consignment->date_posting;
//                        $jurnalUmumMasterGroupConsignment->coa_id = $coaMasterGroupConsignment->id;
//                        $jurnalUmumMasterGroupConsignment->branch_id = $consignment->receive_branch;
//                        $jurnalUmumMasterGroupConsignment->total = $ciDetail->total_price;
//                        $jurnalUmumMasterGroupConsignment->debet_kredit = 'D';
//                        $jurnalUmumMasterGroupConsignment->tanggal_posting = date('Y-m-d');
//                        $jurnalUmumMasterGroupConsignment->transaction_subject = $consignment->supplier->name;
//                        $jurnalUmumMasterGroupConsignment->is_coa_category = 1;
//                        $jurnalUmumMasterGroupConsignment->transaction_type = 'CSI';
//                        $jurnalUmumMasterGroupConsignment->save();

                        //save product master category coa consignment Inventory
                        $coaMasterConsignment = Coa::model()->findByPk($ciDetail->product->productMasterCategory->coaConsignmentInventory->id);
                        $getCoaMasterConsignment = $coaMasterConsignment->code;
                        $coaMasterConsignmentWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterConsignment));
                        $jurnalUmumMasterConsignment = new JurnalUmum;
                        $jurnalUmumMasterConsignment->kode_transaksi = $consignment->consignment_in_number;
                        $jurnalUmumMasterConsignment->tanggal_transaksi = $consignment->date_posting;
                        $jurnalUmumMasterConsignment->coa_id = $coaMasterConsignmentWithCode->id;
                        $jurnalUmumMasterConsignment->branch_id = $consignment->receive_branch;
                        $jurnalUmumMasterConsignment->total = $ciDetail->total_price;
                        $jurnalUmumMasterConsignment->debet_kredit = 'D';
                        $jurnalUmumMasterConsignment->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterConsignment->transaction_subject = $consignment->supplier->name;
                        $jurnalUmumMasterConsignment->is_coa_category = 1;
                        $jurnalUmumMasterConsignment->transaction_type = 'CSI';
                        $jurnalUmumMasterConsignment->save();

                        //save product sub master category coa consignment Inventory
                        $coaConsignment = Coa::model()->findByPk($ciDetail->product->productSubMasterCategory->coaConsignmentInventory->id);
                        $getCoaConsignment = $coaConsignment->code;
                        $coaConsignmentWithCode = Coa::model()->findByAttributes(array('code' => $getCoaConsignment));
                        $jurnalUmumConsignment = new JurnalUmum;
                        $jurnalUmumConsignment->kode_transaksi = $consignment->consignment_in_number;
                        $jurnalUmumConsignment->tanggal_transaksi = $consignment->date_posting;
                        $jurnalUmumConsignment->coa_id = $coaConsignmentWithCode->id;
                        $jurnalUmumConsignment->branch_id = $consignment->receive_branch;
                        $jurnalUmumConsignment->total = $ciDetail->total_price;
                        $jurnalUmumConsignment->debet_kredit = 'D';
                        $jurnalUmumConsignment->tanggal_posting = date('Y-m-d');
                        $jurnalUmumConsignment->transaction_subject = $consignment->supplier->name;
                        $jurnalUmumConsignment->is_coa_category = 0;
                        $jurnalUmumConsignment->transaction_type = 'CSI';
                        $jurnalUmumConsignment->save();

                        //save product sub master category coa consignment Inventory
//                        $coaPersediaan = Coa::model()->findByPk($ciDetail->product->productSubMasterCategory->coa_persediaan_barang_dagang);
//                        $jurnalUmumPersediaan = new JurnalUmum;
//                        $jurnalUmumPersediaan->kode_transaksi = $consignment->consignment_in_number;
//                        $jurnalUmumPersediaan->tanggal_transaksi = $consignment->date_posting;
//                        $jurnalUmumPersediaan->coa_id = $coaPersediaan->id;
//                        $jurnalUmumPersediaan->branch_id = $consignment->receive_branch;
//                        $jurnalUmumPersediaan->total = $ciDetail->total_price;
//                        $jurnalUmumPersediaan->debet_kredit = 'D';
//                        $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
//                        $jurnalUmumPersediaan->transaction_subject = $consignment->supplier->name;
//                        $jurnalUmumPersediaan->is_coa_category = 0;
//                        $jurnalUmumPersediaan->transaction_type = 'CSI';
//                        $jurnalUmumPersediaan->save();
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
