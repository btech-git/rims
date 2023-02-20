<?php

class TransactionReceiveItemController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('receiveItemCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('receiveItemEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('receiveItemCreate')) || !(Yii::app()->user->checkAccess('receiveItemEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $recieveDetails = TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id' => $id));
        
        if (isset($_POST['Process'])) {
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->receive_item_no,
                'branch_id' => $model->recipient_branch_id,
            ));

            $transactionType = 'RCI';
            $postingDate = date('Y-m-d');
            $transactionCode = $model->receive_item_no;
            $transactionDate = $model->receive_item_date;
            $branchId = $model->recipient_branch_id;
            $transactionSubject = $model->note;

            $journalReferences = array();

            foreach($recieveDetails as $detail) {
                if ($detail->qty_received > 0) {
                    $value = $detail->qty_received * $detail->purchaseOrderDetail->unit_price;
                    $coaId = $detail->product->productSubMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $value;
                }
            }

            $totalJournal = 0;
            foreach ($journalReferences as $coaId => $journalReference) {
                $jurnalUmumPersediaan = new JurnalUmum();
                $jurnalUmumPersediaan->kode_transaksi = $transactionCode;
                $jurnalUmumPersediaan->tanggal_transaksi = $transactionDate;
                $jurnalUmumPersediaan->coa_id = $coaId;
                $jurnalUmumPersediaan->branch_id = $branchId;
                $jurnalUmumPersediaan->total = array_sum($journalReference['values']);
                $jurnalUmumPersediaan->debet_kredit = $journalReference['debet_kredit'];
                $jurnalUmumPersediaan->tanggal_posting = $postingDate;
                $jurnalUmumPersediaan->transaction_subject = $transactionSubject;
                $jurnalUmumPersediaan->is_coa_category = $journalReference['is_coa_category'];
                $jurnalUmumPersediaan->transaction_type = $transactionType;
                $jurnalUmumPersediaan->save();

                $totalJournal += array_sum($journalReference['values']);
            }

            if ($model->request_type == 'Purchase Order' && $totalJournal > 0) {
                $coaOutstanding = Coa::model()->findByPk($model->supplier->coaOutstandingOrder->id);
                $jurnalUmumOutstanding = new JurnalUmum();
                $jurnalUmumOutstanding->kode_transaksi = $model->receive_item_no;
                $jurnalUmumOutstanding->tanggal_transaksi = $model->receive_item_date;
                $jurnalUmumOutstanding->coa_id = $coaOutstanding->id;
                $jurnalUmumOutstanding->branch_id = $model->recipient_branch_id;
                $jurnalUmumOutstanding->total = $totalJournal;
                $jurnalUmumOutstanding->debet_kredit = 'K';
                $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstanding->transaction_subject = $transactionSubject;
                $jurnalUmumOutstanding->is_coa_category = 0;
                $jurnalUmumOutstanding->transaction_type = 'RCI';
                $jurnalUmumOutstanding->save();
            }
        }
        
        $this->render('view', array(
            'model' => $model,
            'recieveDetails' => $recieveDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($transactionId, $movementType) {
        
        $receiveItem = $this->instantiate(null);
        $receiveItem->header->receive_item_date = date('Y-m-d');
        $receiveItem->header->arrival_date = date('Y-m-d');
        $receiveItem->header->created_datetime = date('Y-m-d H:i:s');
        $receiveItem->header->user_id_receive = Yii::app()->user->id;
        $receiveItem->header->user_id_invoice = null;
//        $receiveItem->header->recipient_branch_id = $receiveItem->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $receiveItem->header->recipient_branch_id;
        $this->performAjaxValidation($receiveItem->header);

        $branches = Branch::model()->findAll();
        
        if ($movementType == 1) {
            $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($transactionId);
            $receiveItem->header->purchase_order_id = $transactionId;
            $receiveItem->header->transfer_request_id = null;
            $receiveItem->header->consignment_in_id = null;
            $receiveItem->header->delivery_order_id = null;
            $receiveItem->header->movement_out_id = null;
            $receiveItem->header->supplier_id = $purchaseOrder->supplier_id;
            $receiveItem->header->request_type = 'Purchase Order';
            $receiveItem->header->destination_branch = null;
            $receiveItem->header->estimate_arrival_date = date('Y-m-d');
            $receiveItem->header->request_date = $purchaseOrder->purchase_order_date;
            
        } else if ($movementType == 2) {
            $deliveryOrder = TransactionDeliveryOrder::model()->findByPk($transactionId);
            $receiveItem->header->purchase_order_id = null;
            $receiveItem->header->transfer_request_id = null;
            $receiveItem->header->consignment_in_id = null;
            $receiveItem->header->delivery_order_id = $transactionId;
            $receiveItem->header->movement_out_id = null;
            $receiveItem->header->supplier_id = null;
            $receiveItem->header->request_type = 'Internal Delivery Order';
            $receiveItem->header->destination_branch = $deliveryOrder->destination_branch;
            $receiveItem->header->estimate_arrival_date = $deliveryOrder->estimate_arrival_date;
            $receiveItem->header->request_date = $deliveryOrder->delivery_date;
            
        }  else if ($movementType == 3) {
            $consignmentIn = ConsignmentInHeader::model()->findByPk($transactionId);
            $receiveItem->header->purchase_order_id = null;
            $receiveItem->header->transfer_request_id = null;
            $receiveItem->header->consignment_in_id = $transactionId;
            $receiveItem->header->delivery_order_id = null;
            $receiveItem->header->movement_out_id = null;
            $receiveItem->header->supplier_id = $consignmentIn->supplier_id;
            $receiveItem->header->request_type = 'Consignment In';
            $receiveItem->header->destination_branch = null;
            $receiveItem->header->estimate_arrival_date = date('Y-m-d');
            $receiveItem->header->request_date = $consignmentIn->date_posting;
            
        }  else if ($movementType == 4) {
            $movementOut = MovementOutHeader::model()->findByPk($transactionId);
            $receiveItem->header->purchase_order_id = null;
            $receiveItem->header->transfer_request_id = null;
            $receiveItem->header->consignment_in_id = null;
            $receiveItem->header->delivery_order_id = null;
            $receiveItem->header->movement_out_id = $transactionId;
            $receiveItem->header->supplier_id = null;
            $receiveItem->header->request_type = 'Movement Out';
            $receiveItem->header->destination_branch = null;
            $receiveItem->header->estimate_arrival_date = date('Y-m-d');
            $receiveItem->header->request_date = $movementOut->date_posting;
            
        } else {
            $this->redirect(array('admin'));
        }
        
        $receiveItem->addDetails($transactionId, $movementType);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['TransactionReceiveItem'])) {
            $this->loadState($receiveItem);
            $receiveItem->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($receiveItem->header->receive_item_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($receiveItem->header->receive_item_date)), $receiveItem->header->recipient_branch_id);

            if ($receiveItem->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $receiveItem->header->id));
            }
        }

        $this->render('create', array(
            'receiveItem' => $receiveItem,
            'branches' => $branches,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $receiveItem = $this->instantiate($id);
        $this->performAjaxValidation($receiveItem->header);

        $branches = Branch::model()->findAll();
        
        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionReceiveItem'])) {
            
            $this->loadState($receiveItem);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $receiveItem->header->receive_item_no,
                'branch_id' => $receiveItem->header->recipient_branch_id,
            ));

            $receiveItem->header->setCodeNumberByRevision('receive_item_no');
            
            if ($receiveItem->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $receiveItem->header->id));
            }
        }

        $this->render('update', array(
            'receiveItem' => $receiveItem,
            'branches' => $branches,
        ));
    }
    
    public function actionAddInvoice($id) {
        $receiveItem = $this->loadModel($id);
        $receiveItem->invoice_date = date('Y-m-d');
        $receiveItem->invoice_date_created = date('Y-m-d');
        $receiveItem->invoice_time_created = date('H:i:s');
        $receiveItem->user_id_invoice = Yii::app()->user->id;
        $this->performAjaxValidation($receiveItem);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionReceiveItem'])) {
            $receiveItem->attributes = $_POST['TransactionReceiveItem'];
            
            if ($receiveItem->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $receiveItem->id));
            }
        }

        $this->render('addInvoice', array(
            'receiveItem' => $receiveItem,
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
        $dataProvider = new CActiveDataProvider('TransactionReceiveItem');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TransactionReceiveItem('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionReceiveItem']))
            $model->attributes = $_GET['TransactionReceiveItem'];

        $dataProvider = $model->search();
        $dataProvider->criteria->addInCondition('recipient_branch_id', Yii::app()->user->branch_ids);
        $dataProvider->criteria->together = true;
        $dataProvider->criteria->with = array(
            'supplier',
            'recipientBranch',
            'purchaseOrder',
        );
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.receive_item_date, 1, 10)', $startDate, $endDate);

        $delivery = new TransactionDeliveryOrder('search');
        $delivery->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionDeliveryOrder'])) {
            $delivery->attributes = $_GET['TransactionDeliveryOrder'];
        }
        
        $deliveryDataProvider = $delivery->searchByReceive();

        $purchase = new TransactionPurchaseOrder('search');
        $purchase->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionPurchaseOrder']))
            $purchase->attributes = $_GET['TransactionPurchaseOrder'];
        
        $purchaseDataProvider = $purchase->searchByReceive();
        $purchaseDataProvider->criteria->addCondition("t.purchase_order_date > '2021-12-31'");

        $consignment = new ConsignmentInHeader('search');
        $consignment->unsetAttributes();  // clear any default values
        if (isset($_GET['ConsignmentInHeader']))
            $consignment->attributes = $_GET['ConsignmentInHeader'];

        $consignmentCriteria = new CDbCriteria;
        $consignmentCriteria->compare('consignment_in_number', $consignment->consignment_in_number . '%', true, 'AND', false);
        $consignmentCriteria->addCondition("status_document = 'Approved'");
        $consignmentCriteria->order = 't.date_posting DESC';
        $consignmentDataProvider = new CActiveDataProvider('ConsignmentInHeader', array(
            'criteria' => $consignmentCriteria,
        ));
        $consignmentDataProvider->criteria->addCondition("t.date_posting > '2021-12-31'");

        $movement = new MovementOutHeader('search');
        $movement->unsetAttributes();  // clear any default values
        if (isset($_GET['MovementOutHeader']))
            $movement->attributes = $_GET['MovementOutHeader'];

        $movementCriteria = new CDbCriteria;
        $movementCriteria->compare('movement_out_no', $movement->movement_out_no, true);
        $movementCriteria->addCondition("status != 'Draft' AND status != 'Rejected' AND status != 'Revised'");
        $movementCriteria->order = 't.date_posting DESC';
        $movementDataProvider = new CActiveDataProvider('MovementOutHeader', array(
            'criteria' => $movementCriteria,
        ));
        $movementDataProvider->criteria->addCondition("t.date_posting > '2021-12-31'");

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'purchase' => $purchase,
            'purchaseDataProvider' => $purchaseDataProvider,
            'consignment' => $consignment,
            'consignmentDataProvider' => $consignmentDataProvider,
            'delivery' => $delivery,
            'deliveryDataProvider' => $deliveryDataProvider,
            'movement' => $movement,
            'movementDataProvider' => $movementDataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionReceiveItem the loaded model
     * @throws CHttpException
     */
    public function actionAjaxPurchase($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier_name = "";
            $purchase = TransactionPurchaseOrder::model()->findByPk($id);
            if ($purchase->supplier_id != "") {
                $supplier = Supplier::model()->findByPk($purchase->supplier_id);
                $supplier_name = $supplier->name;
            }

            $purchaseApproval = TransactionPurchaseOrderApproval::model()->findByAttributes(array('purchase_order_id' => $id));

            $object = array(
                'id' => $purchase->id,
                'no' => $purchase->purchase_order_no,
                'date' => $purchase->purchase_order_date,
                'eta' => $purchase->estimate_date_arrival,
                'note' => $purchaseApproval->note,
                'supplier' => $purchase->supplier_id,
                'supplier_name' => $supplier_name,
                'coa' => $supplier->coa != "" ? $supplier->coa->id : "",
                'coa_name' => $supplier->coa != "" ? $supplier->coa->name : "",
                'payment_type' => $purchase->payment_type,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxTransfer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch_name = "";
            $transfer = TransactionTransferRequest::model()->findByPk($id);
            if ($transfer->destination_branch_id != "") {
                $branch = Branch::model()->findByPk($transfer->destination_branch_id);
                $branch_name = $branch->name;
            }

            $object = array(
                'id' => $transfer->id,
                'no' => $transfer->transfer_request_no,
                'date' => $transfer->transfer_request_date,
                'eta' => $transfer->estimate_arrival_date,
                'branch' => $transfer->destination_branch_id,
                'branch_name' => $branch_name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxDelivery($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch_name = "";
            $delivery = TransactionDeliveryOrder::model()->findByPk($id);
            if ($delivery->destination_branch != "") {
                $branch = Branch::model()->findByPk($delivery->destination_branch);
                $branch_name = $branch->name;
            }

            $object = array(
                'id' => $delivery->id,
                'no' => $delivery->delivery_order_no,
                'date' => $delivery->delivery_date,
                'eta' => $delivery->estimate_arrival_date,
                'branch' => $delivery->destination_branch,
                'branch_name' => $branch_name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxConsignment($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier_name = "";
            $consigment = ConsignmentInHeader::model()->findByPk($id);
            if ($consigment->supplier_id != "") {
                $supplier = Supplier::model()->findByPk($consigment->supplier_id);
                $supplier_name = $supplier->name;
            }


            $object = array(
                'id' => $consigment->id,
                'no' => $consigment->consignment_in_number,
                'date' => $consigment->date_posting,
                'eta' => $consigment->date_arrival,
                'supplier' => $consigment->supplier_id,
                'supplier_name' => $supplier_name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = Supplier::model()->findByPk($id);

            $object = array(
                'id' => $supplier->id,
                'name' => $supplier->name,
                    //'email'=> $supplier->email,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);
            //$requestType =$receiveItem->header->request_type;
            $total = 0;
            $totalItems = 0;
            // if($requestType == 'Request for Purchase'){
            // 	foreach ($receiveItem->details as $key => $detail) {
            // 		$totalItems += $detail->total;
            // 		$total += $detail->subtotal;_quantity;
            // 	}
            // } else if($requestType == 'Request for Transfer'){
            // 	foreach ($receiveItem->transferDetails as $key => $transferDetail) {
            // 		$totalItems += $transferDetail->quantity;	
            // 	}
            // }
            foreach ($receiveItem->details as $key => $detail) {
                $totalItems += $detail->quantity;
                $total += $detail->unit_price;
            }
            $object = array('total' => $total, 'totalItems' => $totalItems);
            echo CJSON::encode($object);
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $requestType, $requestId) {
        if (Yii::app()->request->isAjaxRequest) {

            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);

            $receiveItem->addDetail($requestType, $requestId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('receiveItem' => $receiveItem
                    ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetailRequest($id) {
        if (Yii::app()->request->isAjaxRequest) {
            
            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);

            $receiveItem->removeDetailAt();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detail', array('receiveItem' => $receiveItem), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);

            $receiveItem->removeDetail($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detail', array('receiveItem' => $receiveItem), false, true);
        }
    }

    public function actionAjaxJsonGrandTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);

            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $receiveItem->grandTotalAfterRounding));

            echo CJSON::encode(array(
                'grandTotal' => $grandTotal,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $receiveItem = new ReceiveItems(new TransactionReceiveItem(), array());
        } else {
            $receiveItemModel = $this->loadModel($id);
            $receiveItem = new ReceiveItems($receiveItemModel, $receiveItemModel->transactionReceiveItemDetails);
        }
        return $receiveItem;
    }

    public function loadState($receiveItem) {
        if (isset($_POST['TransactionReceiveItem'])) {
            $receiveItem->header->attributes = $_POST['TransactionReceiveItem'];
        }

        if (isset($_POST['TransactionReceiveItemDetail'])) {
            foreach ($_POST['TransactionReceiveItemDetail'] as $i => $item) {
                if (isset($receiveItem->details[$i])) {
                    $receiveItem->details[$i]->attributes = $item;
                } else {
                    $detail = new TransactionReceiveItemDetail();
                    $detail->attributes = $item;
                    $receiveItem->details[] = $detail;
                }
            }
            if (count($_POST['TransactionReceiveItemDetail']) < count($receiveItem->details))
                array_splice($receiveItem->details, $i + 1);
        }
        else {
            $receiveItem->details = array();
        }
    }

    public function loadModel($id) {
        $model = TransactionReceiveItem::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionReceiveItem $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-receive-item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
