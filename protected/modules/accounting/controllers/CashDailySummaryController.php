<?php

class CashDailySummaryController extends Controller {

    public $layout = '//layouts/column1';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $transactionDate = isset($_GET['TransactionDate']) ? $_GET['TransactionDate'] : date('Y-m-d');
        $paymentTypes = PaymentType::model()->findAll(); 
        
        $branchConditionSql = '';
        $params = array(
            ':payment_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $branchConditionSql = ' AND pi.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT pi.branch_id, pi.payment_type_id, b.name as branch_name, pt.name as payment_type_name, COALESCE(SUM(payment_amount), 0) as total_amount
                FROM " . PaymentIn::model()->tableName() . " pi
                INNER JOIN " . PaymentType::model()->tableName() . " pt ON pt.id = pi.payment_type_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = pi.branch_id
                WHERE pi.payment_date = :payment_date " . $branchConditionSql . "
                GROUP BY pi.branch_id, pi.payment_type_id
                ORDER BY pi.branch_id, pi.payment_type_id";
        
        $paymentInRetailResultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        $paymentInWholesale = Search::bind(new PaymentIn(), isset($_GET['PaymentIn']) ? $_GET['PaymentIn'] : '');
        $paymentInWholesaleDataProvider = $paymentInWholesale->searchByDailyCashReport();
        $paymentInWholesaleDataProvider->criteria->together = 'true';
        $paymentInWholesaleDataProvider->criteria->with = array('invoice');
        $paymentInWholesaleDataProvider->criteria->addCondition("invoice.sales_order_id IS NOT NULL");
        $paymentInWholesaleDataProvider->criteria->compare('t.payment_date', $transactionDate);
        $paymentInWholesaleDataProvider->criteria->compare('t.branch_id', $branchId);

        $paymentOut = Search::bind(new PaymentOut(), isset($_GET['PaymentOut']) ? $_GET['PaymentOut'] : '');
        $paymentOutDataProvider = $paymentOut->searchByDailyCashReport();
        $paymentOutDataProvider->criteria->compare('t.payment_date', $transactionDate);
        $paymentOutDataProvider->criteria->compare('t.branch_id', $branchId);

        $cashTransaction = Search::bind(new CashTransaction(), isset($_GET['CashTransaction']) ? $_GET['CashTransaction'] : '');
        
        $cashTransactionInDataProvider = $cashTransaction->search();
        $cashTransactionInDataProvider->criteria->compare('t.transaction_date', $transactionDate);
        $cashTransactionInDataProvider->criteria->compare('t.branch_id', $branchId);
        $cashTransactionInDataProvider->criteria->addCondition('t.transaction_type = "In" AND t.status = "Approved" ');
        
        $cashTransactionOutDataProvider = $cashTransaction->search();
        $cashTransactionOutDataProvider->criteria->compare('t.transaction_date', $transactionDate);
        $cashTransactionOutDataProvider->criteria->compare('t.branch_id', $branchId);
        $cashTransactionOutDataProvider->criteria->addCondition('t.transaction_type = "Out" AND t.status = "Approved" ');
        
        $paymentTypeIdList = array();
        foreach ($paymentTypes as $paymentType) {
            $paymentTypeIdList[] = $paymentType->id;
        }
        
        $paymentInRetailList = array();
        $lastBranchId = '';
        foreach ($paymentInRetailResultSet as $paymentInRetailRow) {
            if ($lastBranchId !== $paymentInRetailRow['branch_id']) {
                $paymentInRetailList[$paymentInRetailRow['branch_id']][0] = $paymentInRetailRow['branch_name'];
                foreach ($paymentTypeIdList as $paymentTypeId) {
                    $paymentInRetailList[$paymentInRetailRow['branch_id']][$paymentTypeId] = '0.00';
                }
            }
            $paymentInRetailList[$paymentInRetailRow['branch_id']][$paymentInRetailRow['payment_type_id']] = $paymentInRetailRow['total_amount'];
            $lastBranchId = $paymentInRetailRow['branch_id'];
        }

        if (isset($_POST['CashDailySummary'])) {
            $cashDailySummary->attributes = $_POST['CashDailySummary'];

            if ($cashDailySummary->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $cashDailySummary->id));
            }
        }

        $this->render('create', array(
            'paymentTypes' => $paymentTypes,
            'paymentInWholesale' => $paymentInWholesale,
            'paymentInWholesaleDataProvider' => $paymentInWholesaleDataProvider,
            'paymentOut' => $paymentOut,
            'paymentOutDataProvider' => $paymentOutDataProvider,
            'cashTransaction' => $cashTransaction,
            'cashTransactionInDataProvider' => $cashTransactionInDataProvider,
            'cashTransactionOutDataProvider' => $cashTransactionOutDataProvider,
            'branchId' => $branchId,
            'transactionDate' => $transactionDate,
            'paymentInRetailResultSet' => $paymentInRetailResultSet,
            'paymentInRetailList' => $paymentInRetailList,
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
        // if(isset($_POST['TransactionDeliveryOrder']))
        // {
        // 	$model->attributes=$_POST['TransactionDeliveryOrder'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('update',array(
        // 	'model'=>$model,
        // ));
        $transfer = new TransactionTransferRequest('search');
        $transfer->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionTransferRequest']))
            $transfer->attributes = $_GET['TransactionTransferRequest'];

        $transferCriteria = new CDbCriteria;
        $transferCriteria->compare('transfer_request_no', $transfer->transfer_request_no . '%', true, 'AND', false);
        $transferCriteria->addCondition("status_document = 'Approved'");
        $transferDataProvider = new CActiveDataProvider('TransactionTransferRequest', array(
            'criteria' => $transferCriteria,
        ));

        $sent = new TransactionSentRequest('search');
        $sent->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSentRequest']))
            $sent->attributes = $_GET['TransactionSentRequest'];

        $sentCriteria = new CDbCriteria;
        $sentCriteria->compare('sent_request_no', $sent->sent_request_no . '%', true, 'AND', false);
        $sentCriteria->addCondition("status_document = 'Approved'");
        $sentDataProvider = new CActiveDataProvider('TransactionSentRequest', array(
            'criteria' => $sentCriteria,
        ));
        $sales = new TransactionSalesOrder('search');
        $sales->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSalesOrder']))
            $sales->attributes = $_GET['TransactionSalesOrder'];

        $salesCriteria = new CDbCriteria;
        $salesCriteria->compare('sale_order_no', $sales->sale_order_no . '%', true, 'AND', false);
        $salesCriteria->addCondition("status_document = 'Approved'");
        $salesDataProvider = new CActiveDataProvider('TransactionSalesOrder', array(
            'criteria' => $salesCriteria,
        ));

        $consignment = new ConsignmentOutHeader('search');
        $consignment->unsetAttributes();  // clear any default values
        if (isset($_GET['ConsignmentOutHeader']))
            $consignment->attributes = $_GET['ConsignmentOutHeader'];

        $consignmentCriteria = new CDbCriteria;
        $consignmentCriteria->compare('consignment_out_no', $consignment->consignment_out_no . '%', true, 'AND', false);
        $consignmentCriteria->addCondition("status = 'Approved'");
        $consignmentDataProvider = new CActiveDataProvider('ConsignmentOutHeader', array(
            'criteria' => $consignmentCriteria,
        ));

        $deliveryOrder = $this->instantiate($id);

        $this->performAjaxValidation($deliveryOrder->header);

        if (isset($_POST['TransactionDeliveryOrder'])) {


            $this->loadState($deliveryOrder);
            if ($deliveryOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $deliveryOrder->header->id));
            } else {
                foreach ($deliveryOrder->details as $detail) {
                    //echo $detail->quantity_request;
                }
            }
        }

        $this->render('update', array(
            'deliveryOrder' => $deliveryOrder,
            'sent' => $sent,
            'sentDataProvider' => $sentDataProvider,
            'sales' => $sales,
            'salesDataProvider' => $salesDataProvider,
            'consignment' => $consignment,
            'consignmentDataProvider' => $consignmentDataProvider,
            'transfer' => $transfer,
            'transferDataProvider' => $transferDataProvider,
        ));
    }

    public function actionView($id) {
        $deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'deliveryDetails' => $deliveryDetails,
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TransactionDeliveryOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionDeliveryOrder']))
            $model->attributes = $_GET['TransactionDeliveryOrder'];

        $transfer = new TransactionTransferRequest('search');
        $transfer->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionTransferRequest']))
            $transfer->attributes = $_GET['TransactionTransferRequest'];

        $transferCriteria = new CDbCriteria;
        $transferCriteria->compare('transfer_request_no', $transfer->transfer_request_no . '%', true, 'AND', false);
        $transferCriteria->addCondition("status_document = 'Approved'");
        $transferDataProvider = new CActiveDataProvider('TransactionTransferRequest', array(
            'criteria' => $transferCriteria,
        ));

        $sent = new TransactionSentRequest('search');
        $sent->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSentRequest']))
            $sent->attributes = $_GET['TransactionSentRequest'];

        $sentCriteria = new CDbCriteria;
        $sentCriteria->compare('sent_request_no', $sent->sent_request_no . '%', true, 'AND', false);
        $sentCriteria->addCondition("status_document = 'Approved'");
        $sentDataProvider = new CActiveDataProvider('TransactionSentRequest', array(
            'criteria' => $sentCriteria,
        ));

        $sales = new TransactionSalesOrder('search');
        $sales->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSalesOrder']))
            $sales->attributes = $_GET['TransactionSalesOrder'];

        $salesCriteria = new CDbCriteria;
        $salesCriteria->compare('sale_order_no', $sales->sale_order_no . '%', true, 'AND', false);
        $salesCriteria->addCondition("status_document = 'Approved'");
        $salesDataProvider = new CActiveDataProvider('TransactionSalesOrder', array(
            'criteria' => $salesCriteria,
        ));

        $consignment = new ConsignmentOutHeader('search');
        $consignment->unsetAttributes();  // clear any default values
        if (isset($_GET['ConsignmentOutHeader']))
            $consignment->attributes = $_GET['ConsignmentOutHeader'];

        $consignmentCriteria = new CDbCriteria;
        $consignmentCriteria->compare('consignment_out_no', $consignment->consignment_out_no . '%', true, 'AND', false);
        $consignmentCriteria->addCondition("status = 'Approved'");
        $consignmentDataProvider = new CActiveDataProvider('ConsignmentOutHeader', array(
            'criteria' => $consignmentCriteria,
        ));

        $this->render('admin', array(
            'model' => $model,
            'sent' => $sent,
            'sentDataProvider' => $sentDataProvider,
            'sales' => $sales,
            'salesDataProvider' => $salesDataProvider,
            'consignment' => $consignment,
            'consignmentDataProvider' => $consignmentDataProvider,
            'transfer' => $transfer,
            'transferDataProvider' => $transferDataProvider,
        ));
    }

}
