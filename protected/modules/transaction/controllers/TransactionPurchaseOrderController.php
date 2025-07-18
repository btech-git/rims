<?php

class TransactionPurchaseOrderController extends Controller {

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
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('purchaseOrderCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('purchaseOrderEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('purchaseOrderApproval') || Yii::app()->user->checkAccess('purchaseOrderSupervisor'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'outstanding' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('purchaseOrderCreate') || Yii::app()->user->checkAccess('purchaseOrderEdit') || Yii::app()->user->checkAccess('purchaseOrderView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $purchaseOrder = $this->loadModel($id);
        $purchaseOrderDetails = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $id));

        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $purchaseOrder->purchase_order_no,
            ));
            
            $jurnalUmumHutang = new JurnalUmum;
            $jurnalUmumHutang->kode_transaksi = $purchaseOrder->purchase_order_no;
            $jurnalUmumHutang->tanggal_transaksi = $purchaseOrder->purchase_order_date;
            $jurnalUmumHutang->coa_id = $purchaseOrder->supplier->coa_id;
            $jurnalUmumHutang->branch_id = $purchaseOrder->main_branch_id;
            $jurnalUmumHutang->total = round($purchaseOrder->subtotal, 2) + round($purchaseOrder->ppn_price, 2);
            $jurnalUmumHutang->debet_kredit = 'K';
            $jurnalUmumHutang->tanggal_posting = date('Y-m-d');
            $jurnalUmumHutang->transaction_subject = $purchaseOrder->supplier->name;
            $jurnalUmumHutang->is_coa_category = 0;
            $jurnalUmumHutang->transaction_type = 'PO';
            $jurnalUmumHutang->save();

            if ($purchaseOrder->ppn_price > 0.00) {
                $coaPpn = Coa::model()->findByAttributes(array('code' => '143.00.001'));
                $jurnalUmumPpn = new JurnalUmum;
                $jurnalUmumPpn->kode_transaksi = $purchaseOrder->purchase_order_no;
                $jurnalUmumPpn->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                $jurnalUmumPpn->coa_id = $coaPpn->id;
                $jurnalUmumPpn->branch_id = $purchaseOrder->main_branch_id;
                $jurnalUmumPpn->total = round($purchaseOrder->ppn_price, 2);
                $jurnalUmumPpn->debet_kredit = 'D';
                $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
                $jurnalUmumPpn->transaction_subject = $purchaseOrder->supplier->name;
                $jurnalUmumPpn->is_coa_category = 0;
                $jurnalUmumPpn->transaction_type = 'PO';
                $jurnalUmumPpn->save();
            }

            $jurnalUmumOutstanding = new JurnalUmum;
            $jurnalUmumOutstanding->kode_transaksi = $purchaseOrder->purchase_order_no;
            $jurnalUmumOutstanding->tanggal_transaksi = $purchaseOrder->purchase_order_date;
            $jurnalUmumOutstanding->coa_id = $purchaseOrder->supplier->coa_outstanding_order;
            $jurnalUmumOutstanding->branch_id = $purchaseOrder->main_branch_id;
            $jurnalUmumOutstanding->total = round($purchaseOrder->subtotal, 2);
            $jurnalUmumOutstanding->debet_kredit = 'D';
            $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
            $jurnalUmumOutstanding->transaction_subject = $purchaseOrder->supplier->name;
            $jurnalUmumOutstanding->is_coa_category = 0;
            $jurnalUmumOutstanding->transaction_type = 'PO';
            $jurnalUmumOutstanding->save();

            $this->redirect(array('view', 'id' => $id));
        }

        $this->render('view', array(
            'model' => $purchaseOrder,
            'purchaseOrderDetails' => $purchaseOrderDetails,
        ));
    }

    public function actionShow($id) {
        $purchaseOrder = $this->loadModel($id);
        $purchaseOrderDetails = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $id));

        $this->render('show', array(
            'model' => $purchaseOrder,
            'purchaseOrderDetails' => $purchaseOrderDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $purchaseOrder = $this->instantiate(null, 'create');
        $purchaseOrder->header->main_branch_id = Yii::app()->user->branch_id;
        $purchaseOrder->header->coa_bank_id_estimate = 7;
//        $purchaseOrder->header->purchase_order_date = date('Y-m-d H:i:s');
        $purchaseOrderDate = isset($_POST['PurchaseOrderDate']) ? $_POST['PurchaseOrderDate'] : date('Y-m-d');
        $purchaseOrderHour = isset($_POST['PurchaseOrderHour']) ? $_POST['PurchaseOrderHour'] : date('H');
        $purchaseOrderMinute = isset($_POST['PurchaseOrderMinute']) ? $_POST['PurchaseOrderMinute'] : date('i');
        $this->performAjaxValidation($purchaseOrder->header);

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }
        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('t.name', $supplier->name, true);
        $supplierCriteria->compare('t.company', $supplier->company, true);
        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
            'sort' => array(
                "defaultOrder" => "t.status ASC, t.name ASC",
            ),
        ));

        $registrationTransaction = new RegistrationTransaction('search');
        $registrationTransaction->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_GET['RegistrationTransaction'];
        }
        $registrationTransactionCriteria = new CDbCriteria;
        $registrationTransactionCriteria->compare('t.transaction_number', $registrationTransaction->transaction_number, true);
        $registrationTransactionCriteria->together = 'true';
        $registrationTransactionCriteria->with = array(
            'vehicle', 
            'customer', 
        );
        $registrationTransactionCriteria->compare('vehicle.plate_number', $registrationTransaction->plate_number, true);
        $registrationTransactionCriteria->compare('customer.name', $registrationTransaction->customer_name, true);

        $registrationTransactionCriteria->addCondition("NOT EXISTS (
            SELECT i.registration_transaction_id
            FROM " . TransactionPurchaseOrder::model()->tableName() . " i
            WHERE t.id = i.registration_transaction_id
        ) AND t.work_order_number IS NOT NULL AND t.total_product_price > 0 AND t.status NOT LIKE '%CANCELLED%' AND t.transaction_date > '2022-12-31'");

        $registrationTransactionDataProvider = new CActiveDataProvider('RegistrationTransaction', array(
            'criteria' => $registrationTransactionCriteria,
            'sort' => array(
                "defaultOrder" => "t.work_order_number DESC, t.transaction_date DESC",
            ),
        ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.id', $product->id);
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);
        $productCriteria->compare('t.status', 'Active');
        
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
            'sort' => array(
                "defaultOrder" => "t.status ASC, t.name ASC",
            ),
        ));

        $price = new ProductPrice('search');
        $price->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductPrice'])) {
            $price->attributes = $_GET['ProductPrice'];
        }
        $priceDataProvider = $price->search();

        $destinationBranch = Search::bind(new Branch('search'), isset($_GET['Branch']) ? $_GET['Branch'] : array());
        $destinationBranchDataProvider = $destinationBranch->search();

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionPurchaseOrder']) && IdempotentManager::check()) {
            $this->loadState($purchaseOrder);
            $purchaseOrder->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($purchaseOrder->header->purchase_order_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($purchaseOrder->header->purchase_order_date)), $purchaseOrder->header->main_branch_id);
            $purchaseOrder->header->payment_date_estimate = date('Y-m-d');
            $purchaseOrder->header->created_datetime = date('Y-m-d H:i:s');
            $purchaseOrder->header->purchase_order_date = "{$purchaseOrderDate} {$purchaseOrderHour}:{$purchaseOrderMinute}:00";
            
            if ($purchaseOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $purchaseOrder->header->id));
            }
        }

        $this->render('create', array(
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDate' => $purchaseOrderDate,
            'purchaseOrderHour' => $purchaseOrderHour,
            'purchaseOrderMinute' => $purchaseOrderMinute,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'price' => $price,
            'priceDataProvider' => $priceDataProvider,
            'destinationBranchDataProvider' => $destinationBranchDataProvider,
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        
        $purchaseOrder = $this->instantiate($id, 'update');
        $this->performAjaxValidation($purchaseOrder->header);
        $purchaseOrder->header->status_document = 'Draft';
        $purchaseOrder->header->user_id_updated = Yii::app()->user->id;
        $purchaseOrder->header->updated_datetime = date('Y-m-d H:i:s');
        
        list($orderDate, $orderTime) = explode(' ', $purchaseOrder->header->purchase_order_date);
        list($orderHour, $orderMinute, ) = explode(':', $orderTime);
        
        $purchaseOrderDate = isset($_POST['PurchaseOrderDate']) ? $_POST['PurchaseOrderDate'] : $orderDate;
        $purchaseOrderHour = isset($_POST['PurchaseOrderHour']) ? $_POST['PurchaseOrderHour'] : $orderHour;
        $purchaseOrderMinute = isset($_POST['PurchaseOrderMinute']) ? $_POST['PurchaseOrderMinute'] : $orderMinute;

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }
        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('t.name', $supplier->name, true);
        $supplierCriteria->compare('t.company', $supplier->company, true);
        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
            'sort' => array(
                "defaultOrder" => "t.status ASC, t.name ASC",
            ),
        ));

        $registrationTransaction = new RegistrationTransaction('search');
        $registrationTransaction->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_GET['RegistrationTransaction'];
        }
        $registrationTransactionCriteria = new CDbCriteria;
        $registrationTransactionCriteria->compare('t.transaction_number', $registrationTransaction->transaction_number, true);
        $registrationTransactionCriteria->together = 'true';
        $registrationTransactionCriteria->with = array(
            'vehicle', 
            'customer', 
        );
        $registrationTransactionCriteria->compare('vehicle.plate_number', $registrationTransaction->plate_number, true);
        $registrationTransactionCriteria->compare('customer.name', $registrationTransaction->customer_name, true);

        $registrationTransactionCriteria->addCondition("NOT EXISTS (
            SELECT i.registration_transaction_id
            FROM " . TransactionPurchaseOrder::model()->tableName() . " i
            WHERE t.id = i.registration_transaction_id
        ) AND t.work_order_number IS NOT NULL AND t.total_product_price > 0 AND t.status NOT LIKE '%CANCELLED%' AND t.transaction_date > '2022-12-31'");

        $registrationTransactionDataProvider = new CActiveDataProvider('RegistrationTransaction', array(
            'criteria' => $registrationTransactionCriteria,
            'sort' => array(
                "defaultOrder" => "t.work_order_number DESC, t.transaction_date DESC",
            ),
        ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.id', $product->id);
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
            'sort' => array(
                "defaultOrder" => "t.status ASC, t.name ASC",
            ),
        ));

        $price = new ProductPrice('search');
        $price->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductPrice'])) {
            $price->attributes = $_GET['ProductPrice'];
        }
        $priceDataProvider = $price->search();

        $destinationBranch = Search::bind(new Branch('search'), isset($_GET['Branch']) ? $_GET['Branch'] : array());
        $destinationBranchDataProvider = $destinationBranch->search();

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionPurchaseOrder']) && IdempotentManager::check()) {
            $this->loadState($purchaseOrder);
            
            $purchaseOrder->header->purchase_order_date = "{$purchaseOrderDate} {$purchaseOrderHour}:{$purchaseOrderMinute}:00";
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $purchaseOrder->header->purchase_order_no,
            ));
        
            $purchaseOrder->header->setCodeNumberByRevision('purchase_order_no');
            
            if ($purchaseOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $purchaseOrder->header->id));
            }
        }

        $this->render('update', array(
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDate' => $purchaseOrderDate,
            'purchaseOrderHour' => $purchaseOrderHour,
            'purchaseOrderMinute' => $purchaseOrderMinute,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'price' => $price,
            'priceDataProvider' => $priceDataProvider,
            'destinationBranchDataProvider' => $destinationBranchDataProvider,
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
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
        $dataProvider = new CActiveDataProvider('TransactionPurchaseOrder');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPdf($id) {
        $po = TransactionPurchaseOrder::model()->find('id=:id', array(':id' => $id));
        $supplier = Supplier::model()->find('id=:id', array(':id' => $po->supplier_id));
        $branch = Branch::model()->find('id=:id', array(':id' => $po->main_branch_id));
        $po_detail = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $id));
        $approval = TransactionPurchaseOrderApproval::model()->findByAttributes(array('purchase_order_id' => $id), array('order' => 't.id DESC'));
        
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, 'L');
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->SetTitle('PO Raperind');
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'po' => $po, 
            'supplier' => $supplier, 
            'branch' => $branch, 
            'po_detail' => $po_detail,
            'approval' => $approval,
        ), true));
        $mPDF1->Output('PO ' . $po->purchase_order_no . '.pdf', 'I');
    }

    /**
     * Manages all models
     */
    public function actionAdmin() {
        $model = new TransactionPurchaseOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionPurchaseOrder'])) {
            $model->attributes = $_GET['TransactionPurchaseOrder'];
        }

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        $dataProvider = $model->search();
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.main_branch_id = :main_branch_id');
            $dataProvider->criteria->params[':main_branch_id'] = Yii::app()->user->branch_id;
        }
        $dataProvider->criteria->together = true;
        $dataProvider->criteria->with = array(
            'supplier',
            'mainBranch',
        );
        
        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.purchase_order_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
//            'request' => $request,
//            'requestDataProvider' => $requestDataProvider,
        ));
    }

    public function actionAjaxGetSubtotal(
    $step, $disc1type, $disc1nom, $disc2type, $disc2nom, $disc3type, $disc3nom, $disc4type, $disc4nom, $disc5type, $disc5nom, $quantity, $retail
    ) {
        $price = $quantity * $retail;
        $discount = 0;
        $subtotal1 = 0;
        $subtotal2 = 0;
        $subtotal3 = 0;
        $subtotal4 = 0;
        $subtotal5 = 0;
        $subtotal = 0;
        $newquantity = 0;
        $totalquantity = 0;
        $newPrice = 0;


        switch ($step) {
            case 1:
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        //$retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal1 / $quantity;
                $subtotal = $subtotal1;
                break;

            case 2:
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        //$retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc2type == 1) {
                    $discount = ($subtotal1 * $disc2nom / 100);
                    $subtotal2 = $subtotal1 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc2type == 2) {
                        $subtotal2 = $subtotal1 - $disc2nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc2nom;
                        //$retail = $subtotal1 / $newquantity;
                        $subtotal2 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal2 / $quantity;
                $subtotal = $subtotal2;
                break;
            case 3:
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        //$retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc2type == 1) {
                    $discount = ($subtotal1 * $disc2nom / 100);
                    $subtotal2 = $subtotal1 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc2type == 2) {
                        $subtotal2 = $subtotal1 - $disc2nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc2nom;
                        //$retail = $subtotal1 / $newquantity;
                        $subtotal2 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc3type == 1) {
                    $discount = ($subtotal2 * $disc3nom / 100);
                    $subtotal3 = $subtotal2 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc3type == 2) {
                        $subtotal3 = $subtotal2 - $disc3nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc3nom;
                        //$retail = $subtotal2 / $newquantity;
                        $subtotal3 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal3 / $quantity;
                $subtotal = $subtotal3;
                break;
            case 4:
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        //$retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc2type == 1) {
                    $discount = ($subtotal1 * $disc2nom / 100);
                    $subtotal2 = $subtotal1 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc2type == 2) {
                        $subtotal2 = $subtotal1 - $disc2nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc2nom;
                        //$retail = $subtotal1 / $newquantity;
                        $subtotal2 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc3type == 1) {
                    $discount = ($subtotal2 * $disc3nom / 100);
                    $subtotal3 = $subtotal2 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc3type == 2) {
                        $subtotal3 = $subtotal2 - $disc3nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc3nom;
                        //$retail = $subtotal2 / $newquantity;
                        $subtotal3 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                if ($disc4type == 1) {
                    $discount = ($subtotal3 * $disc4nom / 100);
                    $subtotal4 = $subtotal3 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc4type == 2) {
                        $subtotal4 = $subtotal3 - $disc4nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc4nom;
                        //$retail = $subtotal3 / $newquantity;
                        $subtotal4 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal4 / $quantity;
                $subtotal = $subtotal4;
                break;
            case 5 :
                if ($disc1type == 1) {
                    $discount = ($price * $disc1nom / 100);
                    $subtotal1 = $price - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc1type == 2) {
                        $subtotal1 = $price - $disc1nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc1nom;
                        //$retail = $price / $newquantity;
                        $subtotal1 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc2type == 1) {
                    $discount = ($subtotal1 * $disc2nom / 100);
                    $subtotal2 = $subtotal1 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc2type == 2) {
                        $subtotal2 = $subtotal1 - $disc2nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc2nom;
                        //$retail = $subtotal1 / $newquantity;
                        $subtotal2 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }

                if ($disc3type == 1) {
                    $discount = ($subtotal2 * $disc3nom / 100);
                    $subtotal3 = $subtotal2 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc3type == 2) {
                        $subtotal3 = $subtotal2 - $disc3nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc3nom;
                        //$retail = $subtotal2 / $newquantity;
                        $subtotal3 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                if ($disc4type == 1) {
                    $discount = ($subtotal3 * $disc4nom / 100);
                    $subtotal4 = $subtotal3 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc4type == 2) {
                        $subtotal4 = $subtotal3 - $disc4nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc4nom;
                        //$retail = $subtotal3 / $newquantity;
                        $subtotal4 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                if ($disc5type == 1) {
                    $discount = ($subtotal4 * $disc5nom / 100);
                    $subtotal5 = $subtotal4 - $discount;
                    $totalquantity = $quantity;
                } else {
                    if ($disc5type == 2) {
                        $subtotal5 = $subtotal4 - $disc5nom;
                        $totalquantity = $quantity;
                    } else {
                        $newquantity = $quantity + $disc5nom;
                        //$retail = $subtotal4 / $newquantity;
                        $subtotal5 = $retail * $quantity;
                        $totalquantity = $newquantity;
                    }
                }
                $newPrice = $subtotal5 / $quantity;
                $subtotal = $subtotal5;
                break;

            default:
                $subtotal = $quantity * $price;
                $newPrice = $subtotal / $quantity;
                $totalquantity = $quantity;
                break;
        }
        $object = array(
            'step' => $step,
            'disc1type' => $disc1type,
            'disc1nom' => $disc1nom,
            'disc2type' => $disc2type,
            'disc2nom' => $disc2nom,
            'subtotal' => $subtotal,
            'subtotal1' => $subtotal1,
            'subtotal2' => $subtotal2,
            'subtotal3' => $subtotal3,
            'subtotal4' => $subtotal4,
            'subtotal5' => $subtotal5,
            'retail' => $retail,
            'newPrice' => $newPrice,
            'totalquantity' => $totalquantity,
        );

        echo CJSON::encode($object);
    }

    public function actionAjaxGetTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseOrder = $this->instantiate($id, '');
            $this->loadState($purchaseOrder);
            $total = 0;
            $totalItems = 0;
            $priceBeforeDisc = $discount = $subtotal = $ppn = 0;
            
            $getPpn = $_POST['TransactionPurchaseOrder']['ppn'];
            foreach ($purchaseOrder->details as $key => $detail) {
                $totalItems += $detail->total_quantity;
                $priceBeforeDisc += $detail->subtotal;
                $discount += $detail->discount;
            }

            $subtotal = $priceBeforeDisc - $discount;
            if ($getPpn == 1) {
                $ppn = $subtotal * 0.1;
            }

            $total = $subtotal + $ppn;
            $object = array(
                'priceBeforeDisc' => intval($priceBeforeDisc),
                'discount' => $discount,
                'subtotal' => intval($subtotal),
                'total' => intval($total),
                'ppn' => intval($ppn),
                'totalItems' => $totalItems
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxCountAmount($discountType, $discountAmount, $retail, $quantity) {
        $price = $quantity * $retail;
        $discount = 0;

        $subtotal = 0;
        $newquantity = 0;
        $totalquantity = 0;
        $newPrice = 0;
        switch ($discountType) {
            case 1:
                $discount = ($price * $discountAmount / 100);
                $subtotal = $price - $discount;
                $totalquantity = $quantity;
                break;
            case 2:
                $subtotal = $price - $discountAmount;
                $totalquantity = $quantity;
                break;
            case 3:
                $newquantity = $quantity + $discountAmount;
                // $retail = $price / $newquantity;
                // $subtotal= $retail * $quantity;
                $subtotal = $price;
                $totalquantity = $newquantity;
                break;
        }
        $newPrice = $subtotal / $quantity;
        $discountAmount = $price - $subtotal;
        $object = array(
            'subtotal' => $subtotal,
            'totalquantity' => $totalquantity,
            'newPrice' => $newPrice,
            'discountAmount' => $discountAmount,
            'price' => $price,
        );
        echo CJSON::encode($object);
    }

    public function actionAjaxCountAmountStep($discountType, $discountAmount, $retail, $quantity, $price) {

        $discount = 0;
        $oriPrice = $retail * $quantity;
        $subtotal = 0;
        $newquantity = 0;
        $totalquantity = 0;
        $newPrice = 0;
        switch ($discountType) {
            case 1:
                $discount = ($price * $discountAmount / 100);
                $subtotal = $price - $discount;
                $totalquantity = $quantity;
                break;
            case 2:
                $subtotal = $price - $discountAmount;
                $totalquantity = $quantity;
                break;
            case 3:
                $newquantity = $quantity + $discountAmount;
                // $retail = $price / $newquantity;
                // $subtotal= $retail * $quantity;
                $subtotal = $price;
                $totalquantity = $newquantity;
                break;
        }
        $newPrice = $subtotal / $quantity;
        $discountAmount = $oriPrice - $subtotal;
        $object = array(
            'subtotal' => $subtotal,
            'totalquantity' => $totalquantity,
            'newPrice' => $newPrice,
            'discountAmount' => $discountAmount,
            'oriPrice' => $oriPrice,
        );
        echo CJSON::encode($object);
    }

    public function actionAjaxCountTotal($totalquantity, $totalprice) {
        $unitprice = $totalprice / $totalquantity;
        //$unitprice = 20/5;
        $object = array('unitprice' => $unitprice);
        echo CJSON::encode($object);
    }

    public function actionAjaxCountTotalNonDiscount($totalquantity, $totalprice) {
        $price = $totalprice * $totalquantity;
        $unitprice = $totalprice;
        $object = array('unitprice' => $unitprice, 'price' => $price);
        echo CJSON::encode($object);
    }

    public function actionUpdateStatus($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['TransactionPurchaseOrder'])) {
            $model->approved_status = $_POST['TransactionPurchaseOrder']['approved_status'];
            $model->approved_by = $_POST['TransactionPurchaseOrder']['approved_by'];
            $model->decline_memo = $_POST['TransactionPurchaseOrder']['decline_memo'];


            if ($model->update(array('approved_status', 'approved_by', 'decline_memo'))) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('updateStatus', array(
            'model' => $model,
        ));
    }

    public function actionUpdateApproval($headerId) {
//        $dbTransaction = Yii::app()->db->beginTransaction();
//        try {
            $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($headerId);
            $historis = TransactionPurchaseOrderApproval::model()->findAllByAttributes(array('purchase_order_id' => $headerId));
            $model = new TransactionPurchaseOrderApproval;
            $model->date = date('Y-m-d H:i:s');

            if (isset($_POST['TransactionPurchaseOrderApproval'])) {
                $model->attributes = $_POST['TransactionPurchaseOrderApproval'];
                
                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $purchaseOrder->purchase_order_no,
                    'branch_id' => $purchaseOrder->main_branch_id,
                ));

//                if ($purchaseOrder->status_document != $model->approval_type) {
                
                    if ($model->save()) {
                        $purchaseOrder->status_document = $model->approval_type;
                        if ($model->approval_type == 'Approved') {
                            $purchaseOrder->approved_id = $model->supervisor_id;

                            foreach ($purchaseOrder->transactionPurchaseOrderDetails as $poDetail) {
                                $getAll = ProductPrice::model()->findAllByAttributes(array(
                                    'product_id' => $poDetail->product_id,
                                    'supplier_id' => $purchaseOrder->supplier_id
                                ));
                                $totalQuantity = 0;
                                $totalPrice = 0;
                                $average = 0;
                                if (count($getAll) > 0) {
                                    foreach ($getAll as $key => $getOne) {
                                        $totalQuantity += $getOne->quantity;
                                        $totalPrice += $getOne->hpp;
                                    }
                                    $average = ($totalPrice + $poDetail->unit_price) / ($totalQuantity + $poDetail->quantity);
                                } else {
                                    $average = $poDetail->unit_price;
                                }

                                $productPrice = new ProductPrice;
                                $productPrice->supplier_id = $purchaseOrder->supplier_id;
                                $productPrice->product_id = $poDetail->product_id;
                                $productPrice->purchase_price = $poDetail->unit_price * $poDetail->quantity;
                                $productPrice->purchase_date = $purchaseOrder->purchase_order_date;
                                $productPrice->hpp = $poDetail->unit_price;
                                $productPrice->quantity = $poDetail->quantity;
                                $productPrice->hpp_average = $average;

                                if ($productPrice->save()) {
                                    $product = Product::model()->findByPk($poDetail->product_id);
                                    $product->hpp = $product->getAverageCogs();
                                    $product->save();
                                }
                            }
                        }
                        $purchaseOrder->update(array('status_document', 'approved_id'));
                        
                        $jurnalUmumHutang = new JurnalUmum;
                        $jurnalUmumHutang->kode_transaksi = $purchaseOrder->purchase_order_no;
                        $jurnalUmumHutang->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                        $jurnalUmumHutang->coa_id = $purchaseOrder->supplier->coa_id;
                        $jurnalUmumHutang->branch_id = $purchaseOrder->main_branch_id;
                        $jurnalUmumHutang->total = round($purchaseOrder->subtotal, 2) + round($purchaseOrder->ppn_price, 2);
                        $jurnalUmumHutang->debet_kredit = 'K';
                        $jurnalUmumHutang->tanggal_posting = date('Y-m-d');
                        $jurnalUmumHutang->transaction_subject = $purchaseOrder->supplier->name;
                        $jurnalUmumHutang->is_coa_category = 0;
                        $jurnalUmumHutang->transaction_type = 'PO';
                        $jurnalUmumHutang->save();

                        if ($purchaseOrder->ppn_price > 0.00) {
                            $coaPpn = Coa::model()->findByAttributes(array('code' => '143.00.001'));
                            $jurnalUmumPpn = new JurnalUmum;
                            $jurnalUmumPpn->kode_transaksi = $purchaseOrder->purchase_order_no;
                            $jurnalUmumPpn->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                            $jurnalUmumPpn->coa_id = $coaPpn->id;
                            $jurnalUmumPpn->branch_id = $purchaseOrder->main_branch_id;
                            $jurnalUmumPpn->total = round($purchaseOrder->ppn_price, 2);
                            $jurnalUmumPpn->debet_kredit = 'D';
                            $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
                            $jurnalUmumPpn->transaction_subject = $purchaseOrder->supplier->name;
                            $jurnalUmumPpn->is_coa_category = 0;
                            $jurnalUmumPpn->transaction_type = 'PO';
                            $jurnalUmumPpn->save();
                        }

                        $jurnalUmumOutstanding = new JurnalUmum;
                        $jurnalUmumOutstanding->kode_transaksi = $purchaseOrder->purchase_order_no;
                        $jurnalUmumOutstanding->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                        $jurnalUmumOutstanding->coa_id = $purchaseOrder->supplier->coa_outstanding_order;
                        $jurnalUmumOutstanding->branch_id = $purchaseOrder->main_branch_id;
                        $jurnalUmumOutstanding->total = round($purchaseOrder->subtotal, 2);
                        $jurnalUmumOutstanding->debet_kredit = 'D';
                        $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
                        $jurnalUmumOutstanding->transaction_subject = $purchaseOrder->supplier->name;
                        $jurnalUmumOutstanding->is_coa_category = 0;
                        $jurnalUmumOutstanding->transaction_type = 'PO';
                        $jurnalUmumOutstanding->save();

                        $this->saveTransactionLog('approval', $purchaseOrder);
        
                        $this->redirect(array('view', 'id' => $headerId));
                    }
//                }
            }
//        } catch (Exception $e) {
//            $dbTransaction->rollback();
//            $this->header->addError('error', $e->getMessage());
//        }

        $this->render('updateApproval', array(
            'model' => $model,
            'purchaseOrder' => $purchaseOrder,
            'historis' => $historis,
        ));
    }

    public function saveTransactionLog($actionType, $purchaseOrder) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $purchaseOrder->purchase_order_no;
        $transactionLog->transaction_date = $purchaseOrder->purchase_order_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $purchaseOrder->tableName();
        $transactionLog->table_id = $purchaseOrder->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $purchaseOrder->attributes;
        
        if ($actionType === 'approval') {
            $newData['transactionPurchaseOrderApprovals'] = array();
            foreach($purchaseOrder->transactionPurchaseOrderApprovals as $detail) {
                $newData['transactionPurchaseOrderApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['transactionPurchaseOrderDetails'] = array();
            foreach($purchaseOrder->transactionPurchaseOrderDetails as $detail) {
                $newData['transactionPurchaseOrderDetails'][] = $detail->attributes;
            }            
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        
        $paymentOut = PaymentOut::model()->findByAttributes(array('purchase_order_id' => $id, 'user_id_cancelled' => null));
        $receiveItem = TransactionReceiveItem::model()->findByAttributes(array('purchase_order_id' => $id, 'user_id_cancelled' => null));
        
        if (empty($receiveItem) && empty($paymentOut)) {
            $model->status_document = 'CANCELLED!!!';
            $model->total_quantity = 0; 
            $model->subtotal = 0;
            $model->total_price = 0;
            $model->payment_amount = 0;
            $model->payment_left = 0;
            $model->payment_status = 'CANCELLED!!!';
            $model->cancelled_datetime = date('Y-m-d H:i:s');
            $model->user_id_cancelled = Yii::app()->user->id;
            $model->update(array('status_document', 'total_quantity', 'subtotal', 'total_price', 'payment_amount', 'payment_left', 'payment_status', 'cancelled_datetime', 'user_id_cancelled'));

            JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
                ':kode_transaksi' => $model->purchase_order_no,
            ));

            $this->saveTransactionLog('cancel', $model);
        
            Yii::app()->user->setFlash('message', 'Transaction is successfully cancelled');
        } else {
            Yii::app()->user->setFlash('message', 'Transaction cannot be cancelled. Check related transactions!');
            $this->redirect(array('view', 'id' => $id));
        }

        $this->redirect(array('admin'));
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

    public function instantiate($id, $actionType) {
        if (empty($id)) {
            $purchaseOrder = new PurchaseOrders($actionType, new TransactionPurchaseOrder(), array(), array());
        } else {
            $purchaseOrderModel = $this->loadModel($id);
            $purchaseOrder = new PurchaseOrders($actionType, $purchaseOrderModel, $purchaseOrderModel->transactionPurchaseOrderDetails, $purchaseOrderModel->transactionPurchaseOrderDestinationBranches);
        }
        return $purchaseOrder;
    }

    public function loadState($purchaseOrder) {
        if (isset($_POST['TransactionPurchaseOrder'])) {
            $purchaseOrder->header->attributes = $_POST['TransactionPurchaseOrder'];
        }

        if (isset($_POST['TransactionPurchaseOrderDetail'])) {
            foreach ($_POST['TransactionPurchaseOrderDetail'] as $i => $item) {
                if (isset($purchaseOrder->details[$i])) {
                    $purchaseOrder->details[$i]->attributes = $item;
                } else {
                    $detail = new TransactionPurchaseOrderDetail();
                    $detail->attributes = $item;
                    $purchaseOrder->details[] = $detail;
                }
            }
            if (count($_POST['TransactionPurchaseOrderDetail']) < count($purchaseOrder->details)) {
                array_splice($purchaseOrder->details, $i + 1);
            }
        } else {
            $purchaseOrder->details = array();
        }
        
        if (isset($_POST['TransactionPurchaseOrderDestinationBranch'])) {
            foreach ($_POST['TransactionPurchaseOrderDestinationBranch'] as $i => $item) {
                if (isset($purchaseOrder->detailBranches[$i])) {
                    $purchaseOrder->detailBranches[$i]->attributes = $item;
                } else {
                    $detail = new TransactionPurchaseOrderDestinationBranch();
                    $detail->attributes = $item;
                    $purchaseOrder->detailBranches[] = $detail;
                }
            }
            if (count($_POST['TransactionPurchaseOrderDestinationBranch']) < count($purchaseOrder->detailBranches)) {
                array_splice($purchaseOrder->detailBranches, $i + 1);
            }
        } else {
            $purchaseOrder->detailBranches = array();
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseOrder = $this->instantiate($id, '');
            $this->loadState($purchaseOrder);

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_supplier.name', $product->product_supplier, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));

            $purchaseOrder->addDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailPurchaseOrder', array(
                'purchaseOrder' => $purchaseOrder,
                'product' => $product,
                'productDataProvider' => $productDataProvider,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $purchaseOrder = $this->instantiate($id, '');
            $this->loadState($purchaseOrder);

            $purchaseOrder->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPurchaseOrder', array(
                'purchaseOrder' => $purchaseOrder,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetailSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $purchaseOrder = $this->instantiate($id, '');
            $this->loadState($purchaseOrder);

            $purchaseOrder->removeDetailSupplier();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailPurchaseOrder', array(
                'purchaseOrder' => $purchaseOrder,
            ));
        }
    }

    public function actionAjaxAddRequestDetail($productId) {
        $purchaseOrderDetails = TransactionRequestOrderDetail::model()->findAllByAttributes(array('product_id' => $productId));
        $this->renderPartial('_detailRequest', array('requestOrderDetails' => $purchaseOrderDetails), false, true);
    }

    public function actionAjaxHtmlAddFormDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $form = new PurchaseOrderForm;

            $this->renderPartial('_formDetail', array(
                'form' => $form,
                'details' => $form->details,
            ), false, true);
        }
    }

    public function actionAjaxSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $supplier = Supplier::model()->findByPk($id);
            $tanggal = empty($_POST['TransactionPurchaseOrder']['purchase_order_date']) ? date('Y-m-d') : $_POST['TransactionPurchaseOrder']['purchase_order_date'];
            $tenor = empty($supplier->tenor) ? 30 : $supplier->tenor;
            $tanggal_jatuh_tempo = date('Y-m-d', strtotime($tanggal . '+' . $tenor . ' days'));
            $coa = $supplier->coa_id != "" ? $supplier->coa_id : '';
            $paymentEstimation = $coa == "" ? $tanggal : $tanggal_jatuh_tempo;
            $deliveryEstimation = $tanggal_jatuh_tempo;

            $object = array(
                'id' => $supplier->id,
                'code' => $supplier->code,
                'name' => $supplier->company,
                'paymentEstimation' => $paymentEstimation,
                'deliveryEstimation' => $deliveryEstimation,
                'coa' => $coa,
                'coa_name' => $supplier->coa ? $supplier->coa->name : '',
                'tenor' => $tenor,
                'estimate_payment_date_label' => CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($tanggal_jatuh_tempo))),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxRegistrationTransaction($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = RegistrationTransaction::model()->findByPk($id);

            $object = array(
                'work_order_number' => $registrationTransaction->work_order_number,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);
            $productUnit = ProductUnit::model()->findByAttributes(array(
                'product_id' => $product->id,
                'unit_type' => 'Main'
            ));

            $object = array(
                'name' => $product->name,
                'retail_price' => $product->retail_price,
                'unit' => $productUnit->id,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxPrice($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $price = ProductPrice::model()->findByPk($id);

            $object = array(
                'price' => $price->purchase_price,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonDateChanged($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseOrder = $this->instantiate($id, '');
            $this->loadState($purchaseOrder);

            $date = $_POST['TransactionPurchaseOrder']['purchase_order_date'];
            $dueDays = $purchaseOrder->header->supplier->tenor;
            $dueDate = date('Y-m-d', strtotime("+{$dueDays} days", strtotime($date)));

            $object = array(
                'estimate_payment_date_formatted' => CHtml::encode(Yii::app()->dateFormatter->format('yyyy-MM-dd', strtotime($dueDate))),
                'estimate_payment_date_label' => CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($dueDate))),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddDestinationBranches($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseOrder = $this->instantiate($id, '');
            $this->loadState($purchaseOrder);

            if (isset($_POST['selectedIds'])) {
                $branches = array();
                $branches = $_POST['selectedIds'];

                foreach ($branches as $branch) {
                    $purchaseOrder->addBranch($branch);
                }
            }

            $this->renderPartial('_destinationBranch', array(
                'purchaseOrder' => $purchaseOrder,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionPurchaseOrder the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = TransactionPurchaseOrder::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionPurchaseOrder $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-purchase-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxGetCompanyBank() {
        $branch = Branch::model()->findByPk($_POST['TransactionPurchaseOrder']['main_branch_id']);
        $company = Company::model()->findByPk($branch->company_id);
        if ($company == null) {
            echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
        } else {
            $data = CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id), array('order' => 'account_name'));
            if (count($data) > 0) {
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
                foreach ($data as $value => $name) {
                    echo CHtml::tag('option', array('value' => $name->id), CHtml::encode($name->bank->name . " " . $name->account_no . " a/n " . $name->account_name), true);
                }
            } else {
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
            }
        }
    }

    public function actionAjaxGetCoa() {
        $companyBank = CompanyBank::model()->findByPk($_POST['TransactionPurchaseOrder']['company_bank_id']);
        $coa = $companyBank->coa_id != "" ? $companyBank->coa_id : '';
        $coa_name = $companyBank->coa != "" ? $companyBank->coa->name : '';
        $object = array('coa' => $coa, 'coa_name' => $coa_name);
        echo CJSON::encode($object);
    }

    public function actionOutstanding() {
        $outstandings = TransactionPurchaseOrder::model()->findAllByAttributes(array('payment_type' => 'Credit'));
        $this->render('outstanding', array(
            'outstandings' => $outstandings,
        ));
    }

    public function actionAjaxGetDate($type) {
        if ($type == "Cash") {
            $tanggal = date('Y-m-d');
        } else {
            $supplier = Supplier::model()->findByPk($_POST['TransactionPurchaseOrder']['supplier_id']);
            $payment = empty($_POST['TransactionPurchaseOrder']['purchase_order_date']) ? date('Y-m-d') : $_POST['TransactionPurchaseOrder']['purchase_order_date'];
            $tenor = empty($supplier->tenor) ? 30 : $supplier->tenor;
            $tanggal_jatuh_tempo = date('Y-m-d', strtotime($payment . '+' . $tenor . ' days'));
            $tanggal = $tanggal_jatuh_tempo;
        }
        $object = array('tanggal' => $tanggal, 'type' => $type);
        echo CJSON::encode($object);
    }

    public function actionAjaxJsonTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseOrder = $this->instantiate($id, '');
            $this->loadState($purchaseOrder);
            $purchaseOrder->setSummaryValues();
            
            $subTotalBeforeDiscountFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->subTotalBeforeDiscount));
            $subTotalDiscountFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->subTotalDiscount));
            $subTotalFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->subTotal));
            $totalQuantityFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchaseOrder->totalQuantity));
            $taxValueFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->taxAmount));
            $grandTotalFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrder->grandTotal));
            
            $detailFormattedValues = array();
            foreach ($purchaseOrder->details as $detail) {
                $detailFormattedValue = array();
                $detailFormattedValue['discount1Amount'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->discount1Amount));
                $detailFormattedValue['discount2Amount'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->discount2Amount));
                $detailFormattedValue['discount3Amount'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->discount3Amount));
                $detailFormattedValue['discount4Amount'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->discount4Amount));
                $detailFormattedValue['discount5Amount'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->discount5Amount));
                $detailFormattedValue['unitPriceAfterDiscount1'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unitPriceAfterDiscount1));
                $detailFormattedValue['unitPriceAfterDiscount2'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unitPriceAfterDiscount2));
                $detailFormattedValue['unitPriceAfterDiscount3'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unitPriceAfterDiscount3));
                $detailFormattedValue['unitPriceAfterDiscount4'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unitPriceAfterDiscount4));
                $detailFormattedValue['unitPriceAfterDiscount5'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unitPriceAfterDiscount5));
                $detailFormattedValue['unit_price'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unit_price));
                $detailFormattedValue['total_price'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total_price));
                $detailFormattedValue['tax_amount'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->tax_amount));
                $detailFormattedValue['price_before_tax'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->price_before_tax));
                $detailFormattedValue['total_before_tax'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total_before_tax));
                $detailFormattedValue['total_quantity'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total_quantity));
                $detailFormattedValue['discount'] = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->discount));
                $detailFormattedValues[] = $detailFormattedValue;
            }

            echo CJSON::encode(array(
                'detailFormattedValues' => $detailFormattedValues,
                'subTotalBeforeDiscountFormatted' => $subTotalBeforeDiscountFormatted,
                'subTotalDiscountFormatted' => $subTotalDiscountFormatted,
                'subTotalFormatted' => $subTotalFormatted,
                'totalQuantityFormatted' => $totalQuantityFormatted,
                'grandTotalFormatted' => $grandTotalFormatted,
                'taxValueFormatted' => $taxValueFormatted,
            ));
        }
    }

    public function actionPpn($id, $ppn_type) {
        $model = $this->loadModel($id);

        if ($ppn_type == 1) {
            $model->ppn = 1;
            $model->total_price = $model->subtotal * 1.1;
            $model->ppn_price = $model->subtotal * 0.1;

            if ($model->update(array('ppn', 'total_price', 'ppn_price'))) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        } else {
            $model->ppn = 2;
            $model->total_price = $model->subtotal;
            $model->ppn_price = 0;

            if ($model->update(array('ppn', 'total_price', 'ppn_price'))) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
    }

    public function actionlaporanPembelian() {
        $this->pageTitle = "RIMS - Laporan Pembelian";

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');
        $company = (isset($_GET['company'])) ? $_GET['company'] : '';
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $supplier_id = (isset($_GET['supplier_id'])) ? $_GET['supplier_id'] : '';
        $supplier_name = (isset($_GET['supplier_name'])) ? $_GET['supplier_name'] : '';
        $paymentType = (isset($_GET['payment_type'])) ? $_GET['payment_type'] : '';

        $criteria = new CDbCriteria;

        if ($company != "") {
            $branches = Branch::model()->findAllByAttributes(array('company_id' => $company));
            $arrBranch = array();
            foreach ($branches as $key => $branchId) {
                $arrBranch[] = $branchId->id;
            }
            if ($branch != "") {
                $criteria->addCondition("main_branch_id = " . $branch);
            } else {
                $criteria->addInCondition('main_branch_id', $arrBranch);
            }
        } else {
            if ($branch != "") {
                $criteria->addCondition("main_branch_id = " . $branch);
            }
        }
        if ($paymentType != "") {
            $criteria->addCondition("payment_type = '" . $paymentType . "'");
        }
        if ($supplier_id != "") {
            $criteria->addCondition("supplier_id = '" . $supplier_id . "'");
        }
        $criteria->addBetweenCondition('t.purchase_order_date', $tanggal_mulai, $tanggal_sampai);
        $transactions = TransactionPurchaseOrder::model()->findAll($criteria);

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }

        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('code', $supplier->code . '%', true, 'AND', false);
        $supplierCriteria->compare('name', $supplier->name, true);

        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

        if (isset($_GET['SaveExcel'])) {
            $this->getXlsReport($transactions, $tanggal_mulai, $tanggal_sampai, $branch);
        }
        
        $this->render('laporanPembelian', array(
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'transactions' => $transactions,
            'branch' => $branch,
            'company' => $company,
            'supplier_id' => $supplier_id,
            'supplier_name' => $supplier_name,
            'paymentType' => $paymentType,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
        ));
    }

    public function getXlsReport($transactions, $tanggal_mulai, $tanggal_sampai, $branch) {

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("BloomingTech")
                ->setLastModifiedBy("RIMS")
                ->setTitle("Laporan Pembelian " . date('d-m-Y'))
                ->setSubject("Laporan Pembelian")
                ->setDescription("Export Data Laporan Pembelian.")
                ->setKeywords("Laporan Pembelian Data")
                ->setCategory("Export Laporan Pembelian");

        // style for horizontal vertical center
//        $styleHorizontalVertivalCenter = array(
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
//            )
//        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
//        $styleLeftVertivalCenterBold = array(
//            'font' => array(
//                'bold' => true,
//            ),
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
//            )
//        );
//        $styleHorizontalCenter = array(
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//            )
//        );
//        $styleVerticalCenter = array(
//            'alignment' => array(
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
//            )
//        );

        $styleBold = array(
            'font' => array(
                'bold' => true,
            )
        );

        // style color red
//        $styleColorRED = array(
//            'font' => array(
//                'color' => array('rgb' => 'FF0000'),
//                'bold' => true,
//            ),
//        );

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'PT RATU PERDANA INDAH JAYA')
        ->setCellValue('A3', 'Laporan Pembelian')
        ->setCellValue('A4', 'PERIODE (' . $tanggal_mulai . '-' . $tanggal_sampai . ')')
        ->setCellValue('A6', 'TANGGAL')
        ->setCellValue('B6', 'NO DOKUMEN')
        ->setCellValue('C6', 'T/K')
        ->setCellValue('D6', 'SUPPLIER')
        ->setCellValue('H6', 'SUBTOTAL')
        ->setCellValue('I6', 'DISCOUNT')
        ->setCellValue('P6', 'PPN')
        ->setCellValue('Q6', 'TOTAL')
        ->setCellValue('A7', 'PRODUCT CODE')
        ->setCellValue('B7', 'PRODUCT NAME')
        ->setCellValue('C7', 'PRODUCT MASTER CATEGORY')
        ->setCellValue('D7', 'PRODUCT SUB MASTER CATEGORY')
        ->setCellValue('E7', 'PRODUCT SUB CATEGORY')
        ->setCellValue('F7', 'QUANTITY')
        ->setCellValue('G7', 'UNIT PRICE')
        ->setCellValue('H7', 'BRUTTO')
        ->setCellValue('I7', 'DISCOUNTS')
        ->setCellValue('N7', 'DISCOUNT PRICE')
        ->setCellValue('O7', 'NETTO')
        ->setCellValue('P7', 'BIAYA')
        ->setCellValue('Q7', 'TOTAL');



        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:S2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:S3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:S4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I7:M7');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A2:S2')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A3:S3')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A4:S4')->applyFromArray($styleHorizontalVertivalCenterBold);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);

        $startrow = 8;
        $grandPbd = $grandDisc = $grandPpn = $grandSubtotal = $grandTotal = 0;
        foreach ($transactions as $key => $transaction) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $transaction->purchase_order_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $transaction->purchase_order_no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $transaction->supplier->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $transaction->payment_type);
            $startrow = $startrow + 1;
            foreach ($transaction->transactionPurchaseOrderDetails as $key => $transactionDetail) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $transactionDetail->product->code);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $transactionDetail->product->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $transactionDetail->product->productMasterCategory->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $transactionDetail->product->productSubMasterCategory->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, $transactionDetail->product->productSubCategory->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, $transactionDetail->quantity);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, number_format($transactionDetail->unit_price, 2));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($transactionDetail->quantity * $transactionDetail->unit_price, 2));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, ($transactionDetail->discount1_type == 1 ? $transactionDetail->discount1_nominal . ' %' : (($transactionDetail->discount1_type == 2) ? $transactionDetail->discount1_nominal : (($transactionDetail->discount1_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount1_nominal : '-'))));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, ($transactionDetail->discount2_type == 1 ? $transactionDetail->discount2_nominal . ' %' : (($transactionDetail->discount2_type == 2) ? $transactionDetail->discount2_nominal : (($transactionDetail->discount2_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount2_nominal : '-'))));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow, ($transactionDetail->discount3_type == 1 ? $transactionDetail->discount3_nominal . ' %' : (($transactionDetail->discount3_type == 2) ? $transactionDetail->discount3_nominal : (($transactionDetail->discount3_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount3_nominal : '-'))));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startrow, ($transactionDetail->discount4_type == 1 ? $transactionDetail->discount4_nominal . ' %' : (($transactionDetail->discount4_type == 2) ? $transactionDetail->discount4_nominal : (($transactionDetail->discount4_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount4_nominal : '-'))));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $startrow, ($transactionDetail->discount5_type == 1 ? $transactionDetail->discount5_nominal . ' %' : (($transactionDetail->discount5_type == 2) ? $transactionDetail->discount5_nominal : (($transactionDetail->discount5_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount5_nominal : '-'))));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow, number_format($transactionDetail->discount, 2));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $startrow, number_format($transactionDetail->total_price, 2));
                $startrow++;
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, "SUBTOTAL");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($transaction->price_before_discount, 2));

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow, number_format($transaction->discount, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $startrow, number_format($transaction->ppn_price, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $startrow, number_format($transaction->total_price, 2));
            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->getStyle("G" . ($startrow) . ":Q" . ($startrow))->applyFromArray($styleBold);
            $grandPbd += $transaction->price_before_discount;
            $grandDisc += $transaction->discount;
            $grandPpn += $transaction->ppn_price;
            $grandSubtotal += $transaction->subtotal;
            $grandTotal += $transaction->total_price;
            $startrow++;
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, "GRAND TOTAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($grandPbd, 2));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow, number_format($grandDisc, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $startrow, number_format($grandPpn, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $startrow, number_format($grandTotal, 2));
//        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle("G" . ($startrow) . ":Q" . ($startrow))->applyFromArray($styleBold);
//        $objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('LAPORAN PEMBELIAN');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        // Save a xls file
        $filename = 'laporan_pembelian_data_' . date("Y-m-d");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function actionlaporanOutstanding() {
        $this->pageTitle = "RIMS - Laporan Outstanding";

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');
        $due_mulai = (isset($_GET['due_mulai'])) ? $_GET['due_mulai'] : '';
        $due_sampai = (isset($_GET['due_sampai'])) ? $_GET['due_sampai'] : '';
        $company = (isset($_GET['company'])) ? $_GET['company'] : '';
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $supplier_id = (isset($_GET['supplier_id'])) ? $_GET['supplier_id'] : '';
        $supplier_name = (isset($_GET['supplier_name'])) ? $_GET['supplier_name'] : '';
        $paymentType = (isset($_GET['PaymentType'])) ? $_GET['PaymentType'] : '';

        $criteria = new CDbCriteria;
        
        $criteria->with = array('transaction_po');
        if ($supplier_name != "") {
            $criteria->with = array('transaction_po' => array('together' => true, 'with' => array('supplier')));
            //$criteria->compare('supplier.id', $->supplier_id, true);
            $criteria->addCondition("supplier_id = '" . $supplier_id . "'");
        }
        
        if (!empty($paymentType)) {
            $criteria->addCondition("transaction_po.payment_type = '" . $paymentType . "'");
        }
        
        if ($company != "") {
            $branches = Branch::model()->findAllByAttributes(array('company_id' => $company));
            $arrBranch = array();
            foreach ($branches as $key => $branchId) {
                $arrBranch[] = $branchId->id;
            }
            if ($branch != "") {
                $criteria->addCondition("transaction_po.main_branch_id = " . $branch);
            } else {
                $criteria->addInCondition('transaction_po.main_branch_id', $arrBranch);
            }
        } else {
            if ($branch != "") {
                $criteria->addCondition("transaction_po.main_branch_id = " . $branch);
            }
        }
        
        $criteria->addBetweenCondition('transaction_po.purchase_order_date', $tanggal_mulai, $tanggal_sampai);
        $criteria->addBetweenCondition('t.due_date', $due_mulai, $due_sampai);
        $criteria->addCondition("type_forecasting = 'po'");
        $transactions = ForecastingPo::model()->findAll($criteria);

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }

        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('code', $supplier->code . '%', true, 'AND', false);
        $supplierCriteria->compare('name', $supplier->name, true);

        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

        if (isset($_GET['SaveExcel'])) {
            $this->getXlsOutstanding($transactions, $tanggal_mulai, $tanggal_sampai);
        }
        
        $this->render('laporanOutstanding', array(
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'due_mulai' => $due_mulai,
            'due_sampai' => $due_sampai,
            'transactions' => $transactions,
            'branch' => $branch,
            'company' => $company,
            'paymentType' => $paymentType,
            'supplier_id' => $supplier_id,
            'supplier_name' => $supplier_name,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
        ));
    }

    public function getXlsOutstanding($transactions, $tanggal_mulai, $tanggal_sampai) {
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
        ->setLastModifiedBy("RIMS")
        ->setTitle("Laporan Outstanding Pembelian Data " . date('d-m-Y'))
        ->setSubject("Outstanding Pembelian")
        ->setDescription("Export Data Outstanding Pembelian.")
        ->setKeywords("Outstanding Pembelian Data")
        ->setCategory("Export Outstanding Pembelian");

        // style for horizontal vertical center
        $styleHorizontalVertivalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $styleBold = array(
            'font' => array(
                'bold' => true,
            )
        );

        // style color red
        $styleColorRED = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
                'bold' => true,
            ),
        );
        $styleBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $styleSize = array(
            'font' => array(
                'size' => 11,
                'name' => 'calibri',
            )
        );
        $BStyle = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                )
            )
        );

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'PT RATU PERDANA INDAH JAYA')
        ->setCellValue('A3', 'Outstanding Pembelian')
        ->setCellValue('A4', 'PERIODE (' . $tanggal_mulai . '-' . $tanggal_sampai . ')')
        ->setCellValue('B7', 'NAMA SUPPLIER')
        ->setCellValue('C7', 'TGL PEMBELIAN')
        ->setCellValue('D7', 'TGL JATUH TEMPO')
        ->setCellValue('E7', 'NO DOKUMEN')
        ->setCellValue('F7', 'KODE BARANG')
        ->setCellValue('G7', 'TOTAL PEMBELIAN')
        ->setCellValue('H7', 'PPN')
        ->setCellValue('I7', 'DISKON')
        ->setCellValue('J7', 'TOTAL BAYAR')
        ->setCellValue('K7', 'TOTAL HUTANG')
        ->setCellValue('L7', 'TGL BAYAR')
        ->setCellValue('M7', 'NO PELUNASAN')
        ->setCellValue('N7', 'KODE BANK');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:N2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:N3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:N4');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A2:J2')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A3:J3')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A4:J4')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A7:N7')->applyFromArray($styleBold);
        $sheet->getStyle('B7:N7')->applyFromArray($styleBorder);
        $sheet->getStyle('B7:N7')->applyFromArray($styleSize);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);

        $startrow = 8;
        $totalDebet = $totalKredit = 0;
        $totalPembelian = $ppn = $discount = $bayar = $hutang = 0;
        foreach ($transactions as $key => $transaction) {
            $po = TransactionPurchaseOrder::model()->findByPk($transaction->transaction_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $po->supplier->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $po->purchase_order_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $transaction->due_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, $po->purchase_order_no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, "");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, number_format($po->subtotal, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($po->ppn_price, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, number_format($po->discount, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, number_format($transaction->realization_balance, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow, number_format($po->total_price, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startrow, $transaction->realization_date);
            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->getStyle("B" . ($startrow) . ":N" . ($startrow))->applyFromArray($styleBorder);
            $sheet->getStyle("B" . ($startrow) . ":N" . ($startrow))->applyFromArray($styleSize);

            $totalPembelian += $po->subtotal;
            $ppn += $po->ppn_price;
            $discount += $po->discount;
            $bayar += $transaction->realization_balance;
            $hutang += $po->total_price;

            $startrow++;
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, "TOTAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, number_format($totalPembelian, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($ppn, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, number_format($discount, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, number_format($bayar, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow, number_format($hutang, 2));
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle("F" . ($startrow) . ":K" . ($startrow))->applyFromArray($styleBold);
        $sheet->getStyle("F" . ($startrow) . ":K" . ($startrow))->applyFromArray($BStyle);
        $sheet->getStyle("B" . ($startrow) . ":N" . ($startrow))->applyFromArray($styleSize);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startrow, $totalDebet);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow, $totalKredit);
        // die();
        $objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('OUTSTANDING PEMBELIAN');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        // Save a xls file
        $filename = 'outstanding_pembelian_data_' . date("Y-m-d");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function actionAjaxGetBranch() {
        $data = Branch::model()->findAllByAttributes(array('company_id' => $_POST['company']));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '-- All Branch --', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            $data = Branch::model()->findAll();
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            echo CHtml::tag('option', array('value' => ''), '-- All Branch --', true);
        }
    }

    public function actionAjaxGetAllBranch() {
        $data = Branch::model()->findAll();
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        echo CHtml::tag('option', array('value' => ''), '-- All Branch --', true);
    }

    public function actionUpdateEstimateDate($id) {
        $model = $this->loadModel($id);
        $details = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $id));
        $payments = PaymentOut::model()->findAllByAttributes(array('purchase_order_id' => $id));
        
        if (isset($_POST['Update'])) {
            $model->payment_date_estimate = $_POST['TransactionPurchaseOrder']['payment_date_estimate'];
            $model->coa_bank_id_estimate = $_POST['TransactionPurchaseOrder']['coa_bank_id_estimate'];
            $model->update(array('coa_bank_id_estimate', 'payment_date_estimate'));

            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('updateEstimateDate', array(
            'model' => $model,
            'details' => $details,
            'payments' => $payments,
        ));
    }
}
