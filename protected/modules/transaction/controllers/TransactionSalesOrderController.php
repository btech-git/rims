<?php

class TransactionSalesOrderController extends Controller {

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
                $filterChain->action->id === 'generateInvoice' ||
                $filterChain->action->id === 'index' ||
                $filterChain->action->id === 'update' ||
                $filterChain->action->id === 'updateApproval' ||
                $filterChain->action->id === 'view' ||
                $filterChain->action->id === 'showProduct'
                
        ) {
            if (!(Yii::app()->user->checkAccess('saleOrderCreate')) || !(Yii::app()->user->checkAccess('saleOrderEdit'))) {
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
        $salesOrderDetails = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $id));

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'salesOrderDetails' => $salesOrderDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        // $model=new TransactionSalesOrder;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['TransactionSalesOrder']))
        // {
        // 	$model->attributes=$_POST['TransactionSalesOrder'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('create',array(
        // 	'model'=>$model,
        // ));

        $salesOrder = $this->instantiate(null);
        $salesOrder->header->requester_branch_id = $salesOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $salesOrder->header->requester_branch_id;
//        $salesOrder->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($salesOrder->header->sale_order_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($salesOrder->header->sale_order_date)), $salesOrder->header->requester_branch_id);
        $this->performAjaxValidation($salesOrder->header);

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Customer']))
            $customer->attributes = $_GET['Customer'];
        
        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email, true);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $product->attributes = $_GET['Product'];

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.id', $product->id, true);
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('t.production_year', $product->production_year, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionSalesOrder'])) {
            $this->loadState($salesOrder);
            $salesOrder->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($salesOrder->header->sale_order_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($salesOrder->header->sale_order_date)), $salesOrder->header->requester_branch_id);
            
            if ($salesOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $salesOrder->header->id));
            }
        }

        $this->render('create', array(
            'salesOrder' => $salesOrder,
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
        // $model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['TransactionSalesOrder']))
        // {
        // 	$model->attributes=$_POST['TransactionSalesOrder'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('update',array(
        // 	'model'=>$model,
        // ));

        $salesOrder = $this->instantiate($id);
        $salesOrder->header->setCodeNumberByRevision('sale_order_no');

        $this->performAjaxValidation($salesOrder->header);

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer']))
            $customer->attributes = $_GET['Customer'];
        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $product->attributes = $_GET['Product'];

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.id', $product->id, true);
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('t.production_year', $product->production_year, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);

        $productDataProvider = new CActiveDataProvider('Product', array('criteria' => $productCriteria,));

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionSalesOrder'])) {
            $this->loadState($salesOrder);

            if ($salesOrder->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $salesOrder->header->id));
        }

        $this->render('update', array(
            'salesOrder' => $salesOrder,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            // 'request'=>$request,
            // 'requestDataProvider'=>$requestDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $salesOrder = $this->instantiate($id);
            $this->loadState($salesOrder);

            $salesOrder->addDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailSalesOrder', array('salesOrder' => $salesOrder
                    ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $salesOrder = $this->instantiate($id);
            $this->loadState($salesOrder);

            //print_r(CJSON::encode($salesOrder->details));
            $salesOrder->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailSalesOrder', array('salesOrder' => $salesOrder,
                    ), false, true);
        }
    }

    public function actionAjaxCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $customer = Customer::model()->findByPk($id);
            $tanggal = empty($_POST['TransactionSalesOrder']['sale_order_date']) ? date('Y-m-d') : $_POST['TransactionSalesOrder']['sale_order_date'];
            $tenor = empty($customer->tenor) ? 30 : $customer->tenor;
            $tanggal_jatuh_tempo = date('Y-m-d', strtotime($tanggal . '+' . $tenor . ' days'));
            $coa = $customer->coa_id != "" ? $customer->coa_id : '';
            $paymentEstimation = $coa == "" ? $tanggal : $tanggal_jatuh_tempo;

            //$supplier = Supplier::model()->findByPk($productPrice->supplier_id);

            $object = array(
                'id' => $customer->id,
                'name' => $customer->name,
                'paymentEstimation' => $paymentEstimation,
                'coa' => $coa,
                'coa_name' => $customer->coa_id != "" ? $customer->coa->name : '',
                'type' => $customer->customer_type,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $salesOrder = $this->instantiate($id);
            $this->loadState($salesOrder);
            //$requestType =$salesOrder->header->request_type;
            $total = 0;
            $totalItems = 0;
            $priceBeforeDisc = $discount = $subtotal = $ppn = 0;
            // if($requestType == 'Request for Purchase'){
            // 	foreach ($salesOrder->details as $key => $detail) {
            // 		$totalItems += $detail->total;
            // 		$total += $detail->subtotal;_quantity;
            // 	}
            // } else if($requestType == 'Request for Transfer'){
            // 	foreach ($salesOrder->transferDetails as $key => $transferDetail) {
            // 		$totalItems += $transferDetail->quantity;	
            // 	}
            // }
            $getPpn = $_POST['TransactionSalesOrder']['ppn'];

            foreach ($salesOrder->details as $key => $detail) {
                $totalItems += $detail->total_quantity;
                $priceBeforeDisc = $detail->subtotal;
                $discount = $detail->discount;
                $subtotal = $detail->total_price;
                if ($getPpn == 1)
                    $ppn = $subtotal * 0.1;

                $total += $subtotal + $ppn;
            }
            $object = array(
                'priceBeforeDisc' => $priceBeforeDisc,
                'discount' => $discount,
                'subtotal' => $subtotal,
                'total' => $total,
                'ppn' => $ppn,
                'totalItems' => $totalItems);
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

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $salesOrder = $this->instantiate($id);
            $this->loadState($salesOrder);

            $discount1Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'discount1Amount')));
            $discount2Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'discount2Amount')));
            $discount3Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'discount3Amount')));
            $discount4Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'discount4Amount')));
            $discount5Nominal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'discount5Amount')));
            $priceAfterDiscount1 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'unitPriceAfterDiscount1')));
            $priceAfterDiscount2 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'unitPriceAfterDiscount2')));
            $priceAfterDiscount3 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'unitPriceAfterDiscount3')));
            $priceAfterDiscount4 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'unitPriceAfterDiscount4')));
            $priceAfterDiscount5 = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'unitPriceAfterDiscount5')));
            $unitPriceAfterDiscount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'unitPrice')));
            $totalQuantityDetail = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'totalQuantity')));
            $subTotalDetail = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'subTotal')));
            $totalDiscountDetail = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'totalDiscount')));
            $taxDetail = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $salesOrder->details[$index]->getTaxAmount($salesOrder->header->ppn)));
            $grandTotalDetail = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($salesOrder->details[$index], 'grandTotal')));
            $subTotalBeforeDiscount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $salesOrder->subTotalBeforeDiscount));
            $subTotalDiscount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $salesOrder->subTotalDiscount));
            $subTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $salesOrder->subTotal));
            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $salesOrder->totalQuantity));
            $taxValue = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $salesOrder->taxAmount));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $salesOrder->getGrandTotal()));

            echo CJSON::encode(array(
                'discount1Nominal' => $discount1Nominal,
                'discount2Nominal' => $discount2Nominal,
                'discount3Nominal' => $discount3Nominal,
                'discount4Nominal' => $discount4Nominal,
                'discount5Nominal' => $discount5Nominal,
                'priceAfterDiscount1' => $priceAfterDiscount1,
                'priceAfterDiscount2' => $priceAfterDiscount2,
                'priceAfterDiscount3' => $priceAfterDiscount3,
                'priceAfterDiscount4' => $priceAfterDiscount4,
                'priceAfterDiscount5' => $priceAfterDiscount5,
                'totalQuantityDetail' => $totalQuantityDetail,
                'unitPriceAfterDiscount' => $unitPriceAfterDiscount,
                'subTotalDetail' => $subTotalDetail,
                'totalDiscountDetail' => $totalDiscountDetail,
                'taxDetail' => $taxDetail,
                'grandTotalDetail' => $grandTotalDetail,
                'subTotalBeforeDiscount' => $subTotalBeforeDiscount,
                'subTotalDiscount' => $subTotalDiscount,
                'subTotal' => $subTotal,
                'totalQuantity' => $totalQuantity,
                'grandTotal' => $grandTotal,
                'taxValue' => $taxValue,
            ));
        }
    }

    public function actionAjaxCountTotal($totalquantity, $totalprice) {
        $unitprice = $totalprice / $totalquantity;
//		$unitprice = 20/5;
        $object = array('unitprice' => $unitprice);
        echo CJSON::encode($object);
    }

    public function actionAjaxCountTotalNonDiscount($totalquantity, $totalprice) {
        $price = $totalprice * $totalquantity;
        $unitprice = $totalprice;
        $object = array('unitprice' => $unitprice, 'price' => $price);
        echo CJSON::encode($object);
    }

    public function actionUpdateApproval($headerId) {
        $salesOrder = TransactionSalesOrder::model()->findByPk($headerId);
        //$salesOrderDetail = TransactionSalesOrderDetail::model()->findByPk($detailId);
        $historis = TransactionSalesOrderApproval::model()->findAllByAttributes(array('sales_order_id' => $headerId));
        $model = new TransactionSalesOrderApproval;
        $model->date = date('Y-m-d H:i:s');
        $branch = Branch::model()->findByPk($salesOrder->requester_branch_id);
        //$model = $this->loadModelDetail($detailId);
        if (isset($_POST['TransactionSalesOrderApproval'])) {
            $model->attributes = $_POST['TransactionSalesOrderApproval'];
            if ($model->save()) {
                $salesOrder->status_document = $model->approval_type;
                if ($model->approval_type == 'Approved') {
                    $salesOrder->approved_id = $model->supervisor_id;

                    if ($salesOrder->payment_type == "Cash") {
                        $getCoaKas = '101.00.000';
                        $coaKasWithCode = Coa::model()->findByAttributes(array('code' => $getCoaKas));
                        $jurnalUmumKas = new JurnalUmum;
                        $jurnalUmumKas->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumKas->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumKas->coa_id = $coaKasWithCode->id;
                        $jurnalUmumKas->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumKas->total = $salesOrder->total_price;
                        $jurnalUmumKas->debet_kredit = 'D';
                        $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                        $jurnalUmumKas->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumKas->is_coa_category = 0;
                        $jurnalUmumKas->transaction_type = 'SO';
                        $jurnalUmumKas->save();
                    } else {
                        $getHpp = ProductPrice::model()->findByAttributes(array('product_id' => $soDetail->product_id), array('order' => 'purchase_date DESC'));
                        //D
                        $getCoaPiutang = '105.00.000';
                        $coaPiutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPiutang));
                        $jurnalUmumPiutang = new JurnalUmum;
                        $jurnalUmumPiutang->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumPiutang->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumPiutang->coa_id = $coaPiutangWithCode->id;
                        $jurnalUmumPiutang->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumPiutang->total = $salesOrder->total_price;
                        $jurnalUmumPiutang->debet_kredit = 'D';
                        $jurnalUmumPiutang->tanggal_posting = date('Y-m-d');
                        $jurnalUmumPiutang->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumPiutang->is_coa_category = 0;
                        $jurnalUmumPiutang->transaction_type = 'SO';
                        $jurnalUmumPiutang->save();
                    }

                    if ($salesOrder->ppn_price > 0.00) {
                        $getCoaPpn = '206.00.000';
                        $coaPpnWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPpn));
                        $jurnalUmumPpn = new JurnalUmum;
                        $jurnalUmumPpn->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumPpn->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumPpn->coa_id = $coaPpnWithCode->id;
                        $jurnalUmumPpn->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumPpn->total = $salesOrder->total_price;
                        $jurnalUmumPpn->debet_kredit = 'K';
                        $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
                        $jurnalUmumPpn->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumPpn->is_coa_category = 0;
                        $jurnalUmumPpn->transaction_type = 'SO';
                        $jurnalUmumPpn->save();
                    }

                    foreach ($salesOrder->transactionSalesOrderDetails as $key => $soDetail) {
                        $getHpp = ProductPrice::model()->findByAttributes(array('product_id' => $soDetail->product_id), array('order' => 'purchase_date DESC'));
                        $hppPrice = $getHpp->hpp * $soDetail->quantity;
                        $coaMasterGroupHpp = Coa::model()->findByAttributes(array('code' => '520.00.000'));
                        $jurnalUmumMasterGroupHpp = new JurnalUmum;
                        $jurnalUmumMasterGroupHpp->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumMasterGroupHpp->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumMasterGroupHpp->coa_id = $coaMasterGroupHpp->id;
                        $jurnalUmumMasterGroupHpp->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumMasterGroupHpp->total = empty($getHpp) ? 0 : $hppPrice;
                        $jurnalUmumMasterGroupHpp->debet_kredit = 'D';
                        $jurnalUmumMasterGroupHpp->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterGroupHpp->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumMasterGroupHpp->is_coa_category = 1;
                        $jurnalUmumMasterGroupHpp->transaction_type = 'SO';
                        $jurnalUmumMasterGroupHpp->save();

                        //D
                        $coaHpp = Coa::model()->findByPk($soDetail->product->productSubMasterCategory->coaHpp->id);
                        $getCoaHpp = $coaHpp->code;
                        $coaHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHpp));

                        $jurnalUmumMasterHpp = new JurnalUmum;
                        $jurnalUmumMasterHpp->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumMasterHpp->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumMasterHpp->coa_id = $coaHppWithCode->coa_id;
                        $jurnalUmumMasterHpp->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumMasterHpp->total = empty($getHpp) ? 0 : $hppPrice;
                        $jurnalUmumMasterHpp->debet_kredit = 'D';
                        $jurnalUmumMasterHpp->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterHpp->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumMasterHpp->is_coa_category = 1;
                        $jurnalUmumMasterHpp->transaction_type = 'SO';
                        $jurnalUmumMasterHpp->save();

                        $jurnalUmumHpp = new JurnalUmum;
                        $jurnalUmumHpp->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumHpp->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumHpp->coa_id = $coaHppWithCode->id;
                        $jurnalUmumHpp->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumHpp->total = empty($getHpp) ? 0 : $hppPrice;
                        $jurnalUmumHpp->debet_kredit = 'D';
                        $jurnalUmumHpp->tanggal_posting = date('Y-m-d');
                        $jurnalUmumHpp->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumHpp->is_coa_category = 0;
                        $jurnalUmumHpp->transaction_type = 'SO';
                        $jurnalUmumHpp->save();

                        if ($soDetail->discount > 0) {
                            $coaMasterGroupDiskon = Coa::model()->findByAttributes(array('code' => '412.00.000'));
                            $jurnalUmumMasterGroupDiskon = new JurnalUmum;
                            $jurnalUmumMasterGroupDiskon->kode_transaksi = $salesOrder->sale_order_no;
                            $jurnalUmumMasterGroupDiskon->tanggal_transaksi = $salesOrder->sale_order_date;
                            $jurnalUmumMasterGroupDiskon->coa_id = $coaMasterGroupDiskon->id;
                            $jurnalUmumMasterGroupDiskon->branch_id = $salesOrder->requester_branch_id;
                            $jurnalUmumMasterGroupDiskon->total = $soDetail->discount;
                            $jurnalUmumMasterGroupDiskon->debet_kredit = 'D';
                            $jurnalUmumMasterGroupDiskon->tanggal_posting = date('Y-m-d');
                            $jurnalUmumMasterGroupDiskon->transaction_subject = $salesOrder->customer->name;
                            $jurnalUmumMasterGroupDiskon->is_coa_category = 1;
                            $jurnalUmumMasterGroupDiskon->transaction_type = 'SO';
                            $jurnalUmumMasterGroupDiskon->save();

                            $coaDiskon = Coa::model()->findByPk($soDetail->product->productSubMasterCategory->coaDiskonPenjualan->id);
                            $getCoaDiskon = $coaDiskon->code;
                            $coaDiskonWithCode = Coa::model()->findByAttributes(array('code' => $getCoaDiskon));

                            $jurnalUmumMasterDiskon = new JurnalUmum;
                            $jurnalUmumMasterDiskon->kode_transaksi = $salesOrder->sale_order_no;
                            $jurnalUmumMasterDiskon->tanggal_transaksi = $salesOrder->sale_order_date;
                            $jurnalUmumMasterDiskon->coa_id = $coaDiskonWithCode->coa_id;
                            $jurnalUmumMasterDiskon->branch_id = $salesOrder->requester_branch_id;
                            $jurnalUmumMasterDiskon->total = $soDetail->discount;
                            $jurnalUmumMasterDiskon->debet_kredit = 'D';
                            $jurnalUmumMasterDiskon->tanggal_posting = date('Y-m-d');
                            $jurnalUmumMasterDiskon->transaction_subject = $salesOrder->customer->name;
                            $jurnalUmumMasterDiskon->is_coa_category = 1;
                            $jurnalUmumMasterDiskon->transaction_type = 'SO';
                            $jurnalUmumMasterDiskon->save();

                            $jurnalUmumDiskon = new JurnalUmum;
                            $jurnalUmumDiskon->kode_transaksi = $salesOrder->sale_order_no;
                            $jurnalUmumDiskon->tanggal_transaksi = $salesOrder->sale_order_date;
                            $jurnalUmumDiskon->coa_id = $coaDiskonWithCode->id;
                            $jurnalUmumDiskon->branch_id = $salesOrder->requester_branch_id;
                            $jurnalUmumDiskon->total = $soDetail->discount;
                            $jurnalUmumDiskon->debet_kredit = 'D';
                            $jurnalUmumDiskon->tanggal_posting = date('Y-m-d');
                            $jurnalUmumDiskon->transaction_subject = $salesOrder->customer->name;
                            $jurnalUmumDiskon->is_coa_category = 0;
                            $jurnalUmumDiskon->transaction_type = 'SO';
                            $jurnalUmumDiskon->save();
                        }

                        $coaMasterGroupPenjualan = Coa::model()->findByAttributes(array('code' => '411.00.000'));
                        $jurnalUmumMasterGroupPenjualan = new JurnalUmum;
                        $jurnalUmumMasterGroupPenjualan->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumMasterGroupPenjualan->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumMasterGroupPenjualan->coa_id = $coaMasterGroupPenjualan->coa_id;
                        $jurnalUmumMasterGroupPenjualan->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumMasterGroupPenjualan->total = $soDetail->subtotal;
                        $jurnalUmumMasterGroupPenjualan->debet_kredit = 'K';
                        $jurnalUmumMasterGroupPenjualan->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterGroupPenjualan->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumMasterGroupPenjualan->is_coa_category = 1;
                        $jurnalUmumMasterGroupPenjualan->transaction_type = 'SO';
                        $jurnalUmumMasterGroupPenjualan->save();

                        $coaPenjualan = Coa::model()->findByPk($soDetail->product->productSubMasterCategory->coaPenjualanBarangDagang->id);
                        $getCoaPenjualan = $coaPenjualan->code;
                        $coaPenjualanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPenjualan));

                        $jurnalUmumMasterPenjualan = new JurnalUmum;
                        $jurnalUmumMasterPenjualan->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumMasterPenjualan->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumMasterPenjualan->coa_id = $coaPenjualanWithCode->coa_id;
                        $jurnalUmumMasterPenjualan->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumMasterPenjualan->total = $soDetail->subtotal;
                        $jurnalUmumMasterPenjualan->debet_kredit = 'K';
                        $jurnalUmumMasterPenjualan->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterPenjualan->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumMasterPenjualan->is_coa_category = 1;
                        $jurnalUmumMasterPenjualan->transaction_type = 'SO';
                        $jurnalUmumMasterPenjualan->save();

                        $jurnalUmumPenjualan = new JurnalUmum;
                        $jurnalUmumPenjualan->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumPenjualan->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumPenjualan->coa_id = $coaPenjualanWithCode->id;
                        $jurnalUmumPenjualan->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumPenjualan->total = $soDetail->subtotal;
                        $jurnalUmumPenjualan->debet_kredit = 'K';
                        $jurnalUmumPenjualan->tanggal_posting = date('Y-m-d');
                        $jurnalUmumPenjualan->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumPenjualan->is_coa_category = 0;
                        $jurnalUmumPenjualan->transaction_type = 'SO';
                        $jurnalUmumPenjualan->save();

                        $coaMasterGroupInventory = Coa::model()->findByAttributes(array('code' => '105.00.000'));
                        $jurnalUmumMasterGroupInventory = new JurnalUmum;
                        $jurnalUmumMasterGroupInventory->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumMasterGroupInventory->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumMasterGroupInventory->coa_id = $coaMasterGroupInventory->id;
                        $jurnalUmumMasterGroupInventory->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumMasterGroupInventory->total = empty($getHpp) ? 0 : $hppPrice;
                        $jurnalUmumMasterGroupInventory->debet_kredit = 'K';
                        $jurnalUmumMasterGroupInventory->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterGroupInventory->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumMasterGroupInventory->is_coa_category = 1;
                        $jurnalUmumMasterGroupInventory->transaction_type = 'SO';
                        $jurnalUmumMasterGroupInventory->save();

                        $coaInventory = Coa::model()->findByPk($soDetail->product->productSubMasterCategory->coaInventoryInTransit->id);
                        $getCoaInventory = $coaInventory->code;
                        $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));

                        $jurnalUmumMasterInventory = new JurnalUmum;
                        $jurnalUmumMasterInventory->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumMasterInventory->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumMasterInventory->coa_id = $coaInventoryWithCode->coa_id;
                        $jurnalUmumMasterInventory->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumMasterInventory->total = empty($getHpp) ? 0 : $hppPrice;
                        $jurnalUmumMasterInventory->debet_kredit = 'K';
                        $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterInventory->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumMasterInventory->is_coa_category = 1;
                        $jurnalUmumMasterInventory->transaction_type = 'SO';
                        $jurnalUmumMasterInventory->save();

                        $jurnalUmumInventory = new JurnalUmum;
                        $jurnalUmumInventory->kode_transaksi = $salesOrder->sale_order_no;
                        $jurnalUmumInventory->tanggal_transaksi = $salesOrder->sale_order_date;
                        $jurnalUmumInventory->coa_id = $coaInventoryWithCode->id;
                        $jurnalUmumInventory->branch_id = $salesOrder->requester_branch_id;
                        $jurnalUmumInventory->total = empty($getHpp) ? 0 : $hppPrice;
                        $jurnalUmumInventory->debet_kredit = 'K';
                        $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                        $jurnalUmumInventory->transaction_subject = $salesOrder->customer->name;
                        $jurnalUmumInventory->is_coa_category = 0;
                        $jurnalUmumInventory->transaction_type = 'SO';
                        $jurnalUmumInventory->save();
                    }
                }

                $salesOrder->save(false);
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'salesOrder' => $salesOrder,
            //'salesOrderDetail'=>$salesOrderDetail,
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
        $dataProvider = new CActiveDataProvider('TransactionSalesOrder');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TransactionSalesOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSalesOrder']))
            $model->attributes = $_GET['TransactionSalesOrder'];

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
     * @return TransactionSalesOrder the loaded model
     * @throws CHttpException
     */
    public function instantiate($id) {
        if (empty($id)) {
            $salesOrder = new SalesOrders(new TransactionSalesOrder(), array());
        } else {
            $salesOrderModel = $this->loadModel($id);
            $salesOrder = new SalesOrders($salesOrderModel, $salesOrderModel->transactionSalesOrderDetails);
        }
        return $salesOrder;
    }

    public function loadState($salesOrder) {
        if (isset($_POST['TransactionSalesOrder'])) {
            $salesOrder->header->attributes = $_POST['TransactionSalesOrder'];
        }

        if (isset($_POST['TransactionSalesOrderDetail'])) {
            foreach ($_POST['TransactionSalesOrderDetail'] as $i => $item) {
                if (isset($salesOrder->details[$i])) {
                    $salesOrder->details[$i]->attributes = $item;
                } else {
                    $detail = new TransactionSalesOrderDetail();
                    $detail->attributes = $item;
                    $salesOrder->details[] = $detail;
                }
            }
            if (count($_POST['TransactionSalesOrderDetail']) < count($salesOrder->details))
                array_splice($salesOrder->details, $i + 1);
        }
        else {
            $salesOrder->details = array();
        }
    }

    public function actionPdf($id) {
        $so = $this->loadModel($id);
        $detail = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $id));
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        //$stylesheet = file_get_contents(Yii::getPathOfAlias('pdfcss') . '/pdf.css');
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array('so' => $so, 'detail' => $detail), true));
        $mPDF1->Output();
    }

    public function loadModel($id) {
        $model = TransactionSalesOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionSalesOrder $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-sales-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGenerateInvoice($id) {
        $salesOrder = TransactionSalesOrder::model()->findByPK($id);
        $customer = Customer::model()->findByPk($salesOrder->customer_id);
        $invoices = InvoiceHeader::model()->findAllByAttributes(array('sales_order_id' => $salesOrder->id));
        
        foreach ($invoices as $invoice) {
            $invoice->status = "CANCELLED";
            $invoice->save(false);
        }
        
        $duedate = $customer->tenor != "" ? date('Y-m-d', strtotime("+" . $customer->tenor . " days")) : date('Y-m-d', strtotime("+1 months"));
        $invoiceHeader = InvoiceHeader::model()->findAll();
        $count = count($invoiceHeader) + 1;
        $model = new InvoiceHeader();
//		$model->invoice_number = 'INV_'.$count;
        $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->invoice_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->invoice_date)), $salesOrder->requester_branch_id);
        $model->invoice_date = date('Y-m-d');
        $model->due_date = $duedate;
        $model->payment_date_estimate = $duedate;
        $model->coa_bank_id_estimate = 7;
        $model->reference_type = 1;
        $model->sales_order_id = $id;
        $model->customer_id = $salesOrder->customer_id;
        $model->branch_id = $salesOrder->requester_branch_id;
        $model->user_id = Yii::app()->user->getId();
        $model->status = "NOT PAID";
        $model->product_price = $salesOrder->subtotal;
        $model->total_price = $salesOrder->total_price;
        $model->payment_left = $salesOrder->total_price;
        $model->ppn = $salesOrder->ppn;
        $model->ppn_total = $salesOrder->ppn_price;

        //$model->save(false);
        if ($model->save(false)) {
            $salesDetails = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $id));
            if (count($salesDetails) != 0) {
                foreach ($salesDetails as $salesDetail) {
                    $modelDetail = new InvoiceDetail();
                    $modelDetail->invoice_id = $model->id;
                    $modelDetail->product_id = $salesDetail->product_id;
                    $modelDetail->quantity = $salesDetail->quantity;
                    $modelDetail->unit_price = $salesDetail->unit_price;
                    $modelDetail->total_price = $salesDetail->total_price;
                    $modelDetail->save(false);
                }//end foreach
            } // end if count
        }// end if model save
    }

    public function actionShowProduct($productId, $branchId) {
        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $branchId));
        $this->render('showProduct', array(
            'warehouses' => $warehouses,
            'productId' => $productId,
        ));
    }

    public function actionAjaxGetCompanyBank() {
        $branch = Branch::model()->findByPk($_POST['TransactionSalesOrder']['requester_branch_id']);
        $company = Company::model()->findByPk($branch->company_id);
        if ($company == NULL) {
            echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
        } else {
            // $companyarray = [];
            // foreach ($company as $key => $value) {
            // 	$companyarray[] = (int) $value->company_id;
            // }
            $data = CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id), array('order' => 'account_name'));
            // $criteria = new CDbCriteria;
            // $criteria->addInCondition('company_id', $companyarray); 
            // $data = CompanyBank::model()->findAll($criteria);
            // var_dump($data); die("S");			// var_dump($data->); die("S");
            if (count($data) > 0) {
                // $bank = $data->bank->name;
                // $data=CHtml::listData($data,'bank_id',$data);
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
        $companyBank = CompanyBank::model()->findByPk($_POST['TransactionSalesOrder']['company_bank_id']);
        $coa = $companyBank->coa_id != "" ? $companyBank->coa_id : '';
        $coa_name = $companyBank->coa != "" ? $companyBank->coa->name : '';
        $object = array('coa' => $coa, 'coa_name' => $coa_name);
        echo CJSON::encode($object);
    }

    public function actionAjaxGetDate($type) {
        if ($type == "Cash") {
            $tanggal = date('Y-m-d');
        } else {
            $customer = Customer::model()->findByPk($_POST['TransactionSalesOrder']['customer_id']);
            $payment = empty($_POST['TransactionSalesOrder']['sale_order_date']) ? date('Y-m-d') : $_POST['TransactionSalesOrder']['sale_order_date'];
            $tenor = empty($customer->tenor) ? 30 : $customer->tenor;
            $tanggal_jatuh_tempo = date('Y-m-d', strtotime($payment . '+' . $tenor . ' days'));
            $tanggal = $tanggal_jatuh_tempo;
        }
        $object = array('tanggal' => $tanggal, 'type' => $type);
        echo CJSON::encode($object);
    }

    public function actionlaporanPenjualan() {
        $this->pageTitle = "RIMS - Laporan Penjualan";

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : '';
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : '';
        $company = (isset($_GET['company'])) ? $_GET['company'] : '';
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $customer_id = (isset($_GET['customer_id'])) ? $_GET['customer_id'] : '';
        $customer_name = (isset($_GET['customer_name'])) ? $_GET['customer_name'] : '';
        $paymentType = (isset($_GET['payment_type'])) ? $_GET['payment_type'] : '';
        $customerType = (isset($_GET['customer_type'])) ? $_GET['customer_type'] : '';

        $criteria = new CDbCriteria;
        if ($company != "") {
            $branches = Branch::model()->findAllByAttributes(array('company_id' => $company));
            $arrBranch = array();
            foreach ($branches as $key => $branchId) {
                $arrBranch[] = $branchId->id;
            }
            if ($branch != "") {
                $criteria->addCondition("requester_branch_id = " . $branch);
            } else {
                $criteria->addInCondition('requester_branch_id', $arrBranch);
            }
        } else {
            if ($branch != "") {
                $criteria->addCondition("requester_branch_id = " . $branch);
            }
        }
        if ($paymentType != "") {
            $criteria->addCondition("payment_type = '" . $paymentType . "'");
        }
        if ($customerType != "") {
            $criteria->together = true;
            $criteria->with = array('customer');
            $criteria->addCondition("customer.customer_type ='" . $customerType . "'");
        }
        if ($customer_id != "") {
            $criteria->addCondition("customer_id = '" . $customer_id . "'");
        }
        $criteria->addBetweenCondition('t.sale_order_date', $tanggal_mulai, $tanggal_sampai);
        $transactions = TransactionSalesOrder::model()->findAll($criteria);

        //$jurnals = JurnalUmum::model()->findAll($coaCriteria);
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer']))
            $customer->attributes = $_GET['Customer'];

        $customerCriteria = new CDbCriteria;

        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);


        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));
        //print_r($jurnals);

        if (isset($_GET['SaveExcel']))
            $this->getXlsReport($transactions, $tanggal_mulai, $tanggal_sampai, $branch);
        //$dataProvider=new CActiveDataProvider('JurnalUmum');
        // $model=new JurnalUmum('search');
        // $model->unsetAttributes();  // clear any default values
        // if(isset($_GET['JurnalUmum']))
        // 	$model->attributes=$_GET['JurnalUmum'];

        $this->render('laporanPenjualan', array(
            // 'dataProvider'=>$dataProvider,
            //'jurnals'=>$jurnals,
            'company' => $company,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'transactions' => $transactions,
            'branch' => $branch,
            'customer_id' => $customer_id,
            'customer_name' => $customer_name,
            'customerType' => $customerType,
            'paymentType' => $paymentType,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function getXlsReport($transactions, $tanggal_mulai, $tanggal_sampai, $branch) {

        // var_dump($customer); die();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("RIMS")
                ->setTitle("Laporan Penjualan " . date('d-m-Y'))
                ->setSubject("Laporan Penjualan")
                ->setDescription("Export Data Laporan Penjualan.")
                ->setKeywords("Laporan Penjualan Data")
                ->setCategory("Export Laporan Penjualan");

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
                // 'fill' => array(
                //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     'color' => array('rgb' => 'FF0000')
                // )
        );

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'PT RATU PERDANA INDAH JAYA')
                ->setCellValue('A3', 'Laporan Penjualan')
                ->setCellValue('A4', 'PERIODE (' . $tanggal_mulai . '-' . $tanggal_sampai . ')')
                ->setCellValue('A6', 'TANGGAL')
                ->setCellValue('B6', 'NO DOKUMEN')
                ->setCellValue('C6', 'T/K')
                ->setCellValue('D6', 'CUSTOMER')
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


        // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:S2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:S3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:S4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I7:M7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A2:S2')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A3:S3')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A4:S4')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
        //$sheet->getStyle('A7:I7')->applyFromArray($styleBold);
        // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
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

        // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        //$objPHPExcel->getActiveSheet()->freezePane('E4');

        $startrow = 8;
        $grandPbd = $grandDisc = $grandPpn = $grandSubtotal = $grandTotal = 0;
        foreach ($transactions as $key => $transaction) {

            //$phone = ($value->customerPhones !=NULL)?$this->phoneNumber($value->customerPhones):'';
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $transaction->sale_order_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $transaction->sale_order_no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $transaction->customer->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $transaction->payment_type);
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startrow, );
            //$customertype = (($value->customer_type == 'Individual')?"P":(($value->customer_type == 'Company')?"K":""));
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startrow, "");
            $startrow = $startrow + 1;
            foreach ($transaction->transactionSalesOrderDetails as $key => $transactionDetail) {
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
            // $objPHPExcel->getActiveSheet()
            //     ->getStyle('C'.$startrow)
            //     ->getNumberFormat()
            //     ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
            // $lastkode = $jurnal->kode_transaksi;
            $startrow++;
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, "GRAND TOTAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($grandPbd, 2));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow, number_format($grandDisc, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $startrow, number_format($grandPpn, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $startrow, number_format($grandTotal, 2));
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle("G" . ($startrow) . ":Q" . ($startrow))->applyFromArray($styleBold);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startrow, $totalDebet);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow, $totalKredit);
        // die();
        $objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('LAPORAN PENJUALAN');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'laporan_penjualan_data_' . date("Y-m-d");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function actionlaporanOutstanding() {
        $this->pageTitle = "RIMS - Laporan Outstanding";

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : '';
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : '';
        $due_mulai = (isset($_GET['due_mulai'])) ? $_GET['due_mulai'] : '';
        $due_sampai = (isset($_GET['due_sampai'])) ? $_GET['due_sampai'] : '';
        $company = (isset($_GET['company'])) ? $_GET['company'] : '';
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $customer_id = (isset($_GET['customer_id'])) ? $_GET['customer_id'] : '';
        $customer_name = (isset($_GET['customer_name'])) ? $_GET['customer_name'] : '';
        // $paymentType = (isset($_GET['payment_type'])) ? $_GET['payment_type'] : '';

        $criteria = new CDbCriteria;

        if ($customer_id != "") {
            $criteria->with = array('transaction_so' => array('together' => true, 'with' => array('customer')));
            $criteria->addCondition("customer_id = '" . $customer_id . "'");
        }
        //$criteria->addBetweenCondition('t.purchase_order_date', $tanggal_mulai, $tanggal_sampai);
        $criteria->with = array('transaction_so');
        $criteria->addBetweenCondition('transaction_so.sale_order_date', $tanggal_mulai, $tanggal_sampai);
        $criteria->addBetweenCondition('t.due_date', $due_mulai, $due_sampai);
        $criteria->addCondition("type_forecasting = 'so'");
        if ($company != "") {
            $branches = Branch::model()->findAllByAttributes(array('company_id' => $company));
            $arrBranch = array();
            foreach ($branches as $key => $branchId) {
                $arrBranch[] = $branchId->id;
            }
            if ($branch != "") {
                $criteria->addCondition("transaction_so.requester_branch_id = " . $branch);
            } else {
                $criteria->addInCondition('transaction_so.requester_branch_id', $arrBranch);
            }
        } else {
            if ($branch != "") {
                $criteria->addCondition("transaction_so.requester_branch_id = " . $branch);
            }
        }
        $transactions = Forecasting::model()->findAll($criteria);

        //$jurnals = JurnalUmum::model()->findAll($coaCriteria);
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer']))
            $customer->attributes = $_GET['Customer'];

        $customerCriteria = new CDbCriteria;

        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);


        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));
        //print_r($jurnals);

        if (isset($_GET['SaveExcel']))
            $this->getXlsOutstanding($transactions, $tanggal_mulai, $tanggal_sampai);
        //$dataProvider=new CActiveDataProvider('JurnalUmum');
        // $model=new JurnalUmum('search');
        // $model->unsetAttributes();  // clear any default values
        // if(isset($_GET['JurnalUmum']))
        // 	$model->attributes=$_GET['JurnalUmum'];

        $this->render('laporanOutstanding', array(
            // 'dataProvider'=>$dataProvider,
            //'jurnals'=>$jurnals,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'due_mulai' => $due_mulai,
            'due_sampai' => $due_sampai,
            'transactions' => $transactions,
            'branch' => $branch,
            'company' => $company,
            'customer_id' => $customer_id,
            'customer_name' => $customer_name,
            // 'paymentType'=>$paymentType,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function getXlsOutstanding($transactions, $tanggal_mulai, $tanggal_sampai) {
        //$lastkode = "";
        // var_dump($customer); die();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("RIMS")
                ->setTitle("Laporan Outstanding Penjualan Data " . date('d-m-Y'))
                ->setSubject("Outstanding Penjualan")
                ->setDescription("Export Data Outstanding Penjualan.")
                ->setKeywords("Outstanding Penjualan Data")
                ->setCategory("Export Outstanding Penjualan");

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
                // 'fill' => array(
                //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     'color' => array('rgb' => 'FF0000')
                // )
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
                ->setCellValue('A3', 'Outstanding Penjualan')
                ->setCellValue('A4', 'PERIODE (' . $tanggal_mulai . '-' . $tanggal_sampai . ')')
                ->setCellValue('B7', 'NAMA CUSTOMER')
                ->setCellValue('C7', 'TGL NOTA')
                ->setCellValue('D7', 'TGL JATUH TEMPO')
                ->setCellValue('E7', 'NO NOTA')
                ->setCellValue('F7', 'NO POLISI')
                ->setCellValue('G7', 'TOTAL NOTA')
                ->setCellValue('H7', 'PPH23')
                ->setCellValue('I7', 'LAIN2')
                ->setCellValue('J7', 'TOTAL BAYAR')
                ->setCellValue('K7', 'TOTAL PIUTANG')
                ->setCellValue('L7', 'TGL BAYAR')
                ->setCellValue('M7', 'NO PELUNASAN')
                ->setCellValue('N7', 'KODE BANK');


        // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:N2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:N3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:N4');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A2:J2')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A3:J3')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A4:J4')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);

        $sheet->getStyle('A7:N7')->applyFromArray($styleBold);
        $sheet->getStyle('B7:N7')->applyFromArray($styleBorder);
        $sheet->getStyle('B7:N7')->applyFromArray($styleSize);
        // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
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
        // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        //$objPHPExcel->getActiveSheet()->freezePane('E4');

        $startrow = 8;
        $totalDebet = $totalKredit = 0;
        $totalNota = $ppn = $lain = $bayar = $piutang = 0;
        foreach ($transactions as $key => $transaction) {

            //$phone = ($value->customerPhones !=NULL)?$this->phoneNumber($value->customerPhones):'';
            $so = TransactionSalesOrder::model()->findByPk($transaction->transaction_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $so->customer->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $so->sale_order_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $transaction->due_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, $so->sale_order_no);
            //$customertype = (($value->customer_type == 'Individual')?"P":(($value->customer_type == 'Company')?"K":""));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, "");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, number_format($so->subtotal, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($so->ppn_price, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, number_format($so->discount, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, number_format($transaction->realization_balance, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow, number_format($so->total_price, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startrow, $transaction->realization_date);
            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->getStyle("B" . ($startrow) . ":N" . ($startrow))->applyFromArray($styleBorder);
            $sheet->getStyle("B" . ($startrow) . ":N" . ($startrow))->applyFromArray($styleSize);

            $totalNota += $so->subtotal;
            $ppn += $so->ppn_price;
            $lain += $so->discount;
            $bayar += $transaction->realization_balance;
            $piutang += $so->total_price;

            // $objPHPExcel->getActiveSheet()->setCellValue('L'.$startrow,'see details');
            // $objPHPExcel->getActiveSheet()->getCell('L'.$startrow)->getHyperlink()->setUrl("sheet://'Historical'!A1");
            // $objPHPExcel->getActiveSheet()
            //     ->getStyle('C'.$startrow)
            //     ->getNumberFormat()
            //     ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
            // $lastkode = $jurnal->kode_transaksi;
            $startrow++;
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, "TOTAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, number_format($totalNota, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($ppn, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, number_format($lain, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, number_format($bayar, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow, number_format($piutang, 2));
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
        $objPHPExcel->getActiveSheet()->setTitle('OUTSTANDING PENJUALAN');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'outstanding_penjualan_data_' . date("Y-m-d");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

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

}
