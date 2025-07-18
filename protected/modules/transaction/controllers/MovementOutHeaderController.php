<?php

class MovementOutHeaderController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('movementOutCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'updateDelivered' || 
            $filterChain->action->id === 'updateStatus' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('movementOutEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('movementOutApproval') || Yii::app()->user->checkAccess('movementOutSupervisor'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('movementOutCreate') || Yii::app()->user->checkAccess('movementOutEdit') || Yii::app()->user->checkAccess('movementOutView'))) {
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
        $model = $this->loadModel($id);
        $details = MovementOutDetail::model()->findAllByAttributes(array('movement_out_header_id' => $id));
        $historis = MovementOutApproval::model()->findAllByAttributes(array('movement_out_id' => $id));
        $shippings = MovementOutShipping::model()->findAllByAttributes(array('movement_out_id' => $id));
        
        if (isset($_POST['Process']) && IdempotentManager::check() && IdempotentManager::build()->save()) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->movement_out_no,
                'branch_id' => $model->branch_id,
            ));

            $transactionType = 'MO';
            $postingDate = date('Y-m-d');
            $transactionCode = $model->movement_out_no;
            $transactionDate = $model->date_posting;
            $branchId = $model->branch_id;
            $transactionSubject = $model->getMovementType($model->movement_type);

            $journalReferences = array();
        
            foreach ($details as $movementDetail) {
                if ((int)$model->movement_type == 3) {
                    $value = $movementDetail->registrationProduct->product->hpp;
                    $coaId = $movementDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $value;
                    
                } else {
                    $quantity = $movementDetail->quantity;
                    if ($movementDetail->unit_id !== $movementDetail->product->unit_id) {
                        $conversionFactor = 1;
                        $unitConversion = UnitConversion::model()->findByAttributes(array(
                            'unit_from_id' => $movementDetail->unit_id, 
                            'unit_to_id' => $movementDetail->product->unit_id
                        ));
                        if ($unitConversion !== null) {
                            $conversionFactor = $unitConversion->multiplier;
                        } else {
                            $unitConversionFlipped = UnitConversion::model()->findByAttributes(array(
                                'unit_from_id' => $movementDetail->product->unit_id, 
                                'unit_to_id' => $movementDetail->unit_id
                            ));
                            if ($unitConversionFlipped !== null) {
                                $conversionFactor = 1 / $unitConversionFlipped->multiplier;
                            }
                        }
                        $quantity = $conversionFactor * $quantity;
                    }

                    $value = $quantity * $movementDetail->product->hpp;

                    $coaId = $movementDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $value;
                    
                }

                $coaId = $movementDetail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                $journalReferences[$coaId]['debet_kredit'] = 'K';
                $journalReferences[$coaId]['is_coa_category'] = 0;
                $journalReferences[$coaId]['values'][] = $value;
            }
                
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
            }
            
            $this->redirect(array('view', 'id' => $id));
        }

        $this->render('view', array(
            'model' => $model,
            'details' => $details,
            'historis' => $historis,
            'shippings' => $shippings,
        ));
    }

    public function actionShow($id) {
        $model = $this->loadModel($id);
        $details = MovementOutDetail::model()->findAllByAttributes(array('movement_out_header_id' => $id));
        $historis = MovementOutApproval::model()->findAllByAttributes(array('movement_out_id' => $id));
        $shippings = MovementOutShipping::model()->findAllByAttributes(array('movement_out_id' => $id));
        
        $this->render('show', array(
            'model' => $model,
            'details' => $details,
            'historis' => $historis,
            'shippings' => $shippings,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($transactionId, $movementType) {
        
        $movementOut = $this->instantiate(null, 'create');
        $movementOut->header->created_datetime = date('Y-m-d H:i:s');
        $movementOut->header->date_posting = Yii::app()->dateFormatter->format('yyyy-M-dd', strtotime($movementOut->header->date_posting)) . ' ' . date('H:i:s');
        $movementOut->header->registration_service_id = null;
        $movementOut->header->movement_type = $movementType;
        $movementOut->header->status = 'Draft';
        $movementOut->header->branch_id = Yii::app()->user->branch_id;
//        $this->performAjaxValidation($movementOut->header);

        if ($movementType == 1) {
            $deliveryOrder = TransactionDeliveryOrder::model()->findByPk($transactionId);
            $movementOut->header->delivery_order_id = $transactionId;
            $movementOut->header->return_order_id = null;
            $movementOut->header->material_request_header_id = null;
            $movementOut->header->registration_transaction_id = null;
//            $movementOut->header->branch_id = $deliveryOrder->sender_branch_id;
            
        } else if ($movementType == 2) {
            $returnOrder = TransactionReturnOrder::model()->findByPk($transactionId);
            $movementOut->header->delivery_order_id = null;
            $movementOut->header->return_order_id = $transactionId;
            $movementOut->header->material_request_header_id = null;
            $movementOut->header->registration_transaction_id = null;
//            $movementOut->header->branch_id = $returnOrder->recipient_branch_id;
            
        } else if ($movementType == 3) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($transactionId);
            $movementOut->header->delivery_order_id = null;
            $movementOut->header->return_order_id = null;
            $movementOut->header->material_request_header_id = null;
            $movementOut->header->registration_transaction_id = $transactionId;
//            $movementOut->header->branch_id = $registrationTransaction->branch_id;
        } else if ($movementType == 4) {
            $materialRequest = MaterialRequestHeader::model()->findByPk($transactionId);
            $movementOut->header->delivery_order_id = null;
            $movementOut->header->return_order_id = null;
            $movementOut->header->registration_transaction_id = null;
            $movementOut->header->material_request_header_id = $transactionId;
//            $movementOut->header->branch_id = $materialRequest->branch_id;
        } else {
            $this->redirect(array('admin'));
        }
            
//        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementOut->header->branch_id, 'status' => 'Active'));

        $movementOut->addDetails($transactionId, $movementType);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['MovementOutHeader']) && IdempotentManager::check()) {
            $this->loadState($movementOut);
            $movementOut->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($movementOut->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($movementOut->header->date_posting)), $movementOut->header->branch_id);
            
            if ($movementOut->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementOut->header->id));
            }
        }

        $this->render('create', array(
            'movementOut' => $movementOut,
//            'warehouses' => $warehouses,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $movementOut = $this->instantiate($id, 'update');
        $movementOut->header->status = 'Draft';
        $movementOut->header->updated_datetime = date('Y-m-d H:i:s');
        $movementOut->header->user_id_updated = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($movementOut->header);
//        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementOut->header->branch_id));

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['MovementOutHeader']) && IdempotentManager::check()) {
            $this->loadState($movementOut);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $movementOut->header->movement_out_no,
                'branch_id' => $movementOut->header->branch_id,
            ));

            InventoryDetail::model()->deleteAllByAttributes(array(
                'transaction_number' => $movementOut->header->movement_out_no,
            ));

            $movementOut->header->setCodeNumberByRevision('movement_out_no');
            
            if ($movementOut->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementOut->header->id));
            }
        }

        $this->render('update', array(
            'movementOut' => $movementOut,
//            'warehouses' => $warehouses,
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
        $deliveryOrders = TransactionDeliveryOrder::model()->findAll();
        $returnOrders = TransactionReturnOrder::model()->findAll();
        $retailSales = RegistrationTransaction::model()->findAll();
        $dataProvider = new CActiveDataProvider('MovementOutHeader');
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'deliveryOrders' => $deliveryOrders,
            'returnOrders' => $returnOrders,
            'retailSales' => $retailSales,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MovementOutHeader('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['MovementOutHeader'])) {
            $model->attributes = $_GET['MovementOutHeader'];
        }

        $dataProvider = $model->search();
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }

        /* Delivery Order */
        $deliveryOrder = new TransactionDeliveryOrder('search');
        $deliveryOrder->unsetAttributes();
        
        if (isset($_GET['TransactionDeliveryOrder'])) {
            $deliveryOrder->attributes = $_GET['TransactionDeliveryOrder'];
        }
        
        $deliveryOrderDataProvider = $deliveryOrder->searchByMovementOut();

        $returnOrder = Search::bind(new TransactionReturnOrder('search'), isset($_GET['TransactionReturnOrder']) ? $_GET['TransactionReturnOrder'] : array());
        $returnOrderDataProvider = $returnOrder->searchByMovementOut();

        /* Registration Transaction */
        $registrationTransaction = new RegistrationTransaction('search');
        $registrationTransaction->unsetAttributes();
        if (isset($_GET['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_GET['RegistrationTransaction'];
        }

        $registrationTransactionDataProvider = $registrationTransaction->searchByMovementOut();

        /* Registration Transaction */
        $materialRequest = new MaterialRequestHeader('search');
        $materialRequest->unsetAttributes();
        if (isset($_GET['MaterialRequestHeader'])) {
            $materialRequest->attributes = $_GET['MaterialRequestHeader'];
        }

        $materialRequestDataProvider = $materialRequest->searchByMovementOut();

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'deliveryOrder' => $deliveryOrder,
            'deliveryOrderDataProvider' => $deliveryOrderDataProvider,
            'returnOrder' => $returnOrder,
            'returnOrderDataProvider' => $returnOrderDataProvider,
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'materialRequestDataProvider' => $materialRequestDataProvider,
            'materialRequest' => $materialRequest,
        ));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        
        $receiveItem = TransactionReceiveItem::model()->findByAttributes(array('movement_out_id' => $model->id, 'user_id_cancelled' => null));
        if (empty($receiveItem)) {
            $model->status = 'CANCELLED!!!'; 
            $model->cancelled_datetime = date('Y-m-d H:i:s');
            $model->user_id_cancelled = Yii::app()->user->id;
            $model->update(array('status', 'cancelled_datetime', 'user_id_cancelled'));

            foreach($model->movementOutDetails as $detail) {
                $detail->quantity = 0;
                $detail->quantity_transaction = 0;
                $detail->quantity_receive = 0;
                $detail->quantity_receive_left = 0;
                $detail->quantity_stock = 0;
                $detail->update(array('quantity', 'quantity_transaction', 'quantity_receive', 'quantity_receive_left', 'quantity_stock'));

                if (!empty($detail->delivery_order_detail_id)) {
                    $deliveryOrderDetail = $detail->deliveryOrderDetail;
                    $deliveryOrderDetail->quantity_movement = $deliveryOrderDetail->getQuantityMovement();
                    $deliveryOrderDetail->quantity_movement_left = $deliveryOrderDetail->getQuantityMovementLeft();
                    $deliveryOrderDetail->update(array('quantity_movement', 'quantity_movement_left'));
                } elseif (!empty($detail->registration_product_id)) {
                    $registrationProduct = $detail->registrationProduct;
                    $registrationProduct->quantity_movement = $registrationProduct->getTotalMovementOutQuantity();
                    $registrationProduct->quantity_movement_left = $registrationProduct->getQuantityMovementLeft();
                    $registrationProduct->update(array('quantity_movement', 'quantity_movement_left'));
                } elseif (!empty($detail->material_request_detail_id)) {
                    $materialRequestDetail = $detail->materialRequestDetail;
                    $materialRequestDetail->quantity_movement_out = $materialRequestDetail->getTotalQuantityMovementOut();
                    $materialRequestDetail->quantity_remaining = $materialRequestDetail->getQuantityMovementLeft();
                    $materialRequestDetail->update(array('quantity_movement_out', 'quantity_remaining'));
                } else {
                    $returnOrderDetail = $detail->returnOrderDetail;
                    $returnOrderDetail->quantity_movement = $returnOrderDetail->getTotalQuantityMovementOut();
                    $returnOrderDetail->quantity_movement_left = $returnOrderDetail->getQuantityMovementLeft();
                    $returnOrderDetail->update(array('quantity_movement', 'quantity_movement_left'));                
                }
            }
            
            JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
                ':kode_transaksi' => $model->movement_out_no,
            ));

            InventoryDetail::model()->updateAll(array('stock_in' => '0.00', 'stock_out' => '0.00'), 'transaction_number = :transaction_number', array(
                ':transaction_number' => $model->movement_out_no,
            ));

            foreach ($model->movementOutDetails as $movementDetail) {
                $inventory = Inventory::model()->findByAttributes(array(
                    'product_id' => $movementDetail->product_id, 
                    'warehouse_id' => $movementDetail->warehouse_id
                ));

                $inventory->total_stock = $inventory->getTotalStockInventoryDetail($movementDetail->product_id, $movementDetail->warehouse_id);
                $inventory->update(array('total_stock'));
            }
            
            $this->saveTransactionLog('cancel', $model);
        
            Yii::app()->user->setFlash('message', 'Transaction is successfully cancelled');
        } else {
            Yii::app()->user->setFlash('message', 'Transaction cannot be cancelled. Check receive transaction!');
            $this->redirect(array('view', 'id' => $id));
        }
        
        $this->redirect(array('admin'));
    }

    public function actionPdf($id) {
        $model = $this->loadModel($id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Movement Out');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'model' => $model,
        ), true));
        $mPDF1->Output('Movement Out' . $model->movement_out_no . '.pdf', 'I');
    }

    public function actionMemo($id) {
        $model = $this->loadModel($id);
        $details = MovementOutDetail::model()->findAllByAttributes(array('movement_out_header_id' => $id));

        $this->render('memo', array(
            'model' => $model,
            'details' => $details,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MovementOutHeader the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MovementOutHeader::model()->findByPk($id);
        
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MovementOutHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'movement-out-header-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function instantiate($id, $actionType) {

        if (empty($id)) {
            $movementOut = new MovementOuts($actionType, new MovementOutHeader(), array());
        } else {
            $movementOutModel = $this->loadModel($id);
            $movementOut = new MovementOuts($actionType, $movementOutModel, $movementOutModel->movementOutDetails);
        }
        return $movementOut;
    }

    public function loadState($movementOut) {
        if (isset($_POST['MovementOutHeader'])) {
            $movementOut->header->attributes = $_POST['MovementOutHeader'];
        }

        if (isset($_POST['MovementOutDetail'])) {
            foreach ($_POST['MovementOutDetail'] as $i => $item) {
                if (isset($movementOut->details[$i])) {
                    $movementOut->details[$i]->attributes = $item;
                } else {
                    $detail = new MovementOutDetail();
                    $detail->attributes = $item;
                    $movementOut->details[] = $detail;
                }
            }
            if (count($_POST['MovementOutDetail']) < count($movementOut->details))
                array_splice($movementOut->details, $i + 1);
        } else {
            $movementOut->details = array();
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $detailId, $type) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementOut = $this->instantiate($id, '');
            $this->loadState($movementOut);

            $movementOut->addDetail($detailId, $type);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('movementOut' => $movementOut), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementOut = $this->instantiate($id, '');
            $this->loadState($movementOut);

            $movementOut->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            //Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('movementOut' => $movementOut), false, true);
        }
    }

    public function actionAjaxHtmlUpdateAllWarehouse($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementOut = $this->instantiate($id, '');
            $this->loadState($movementOut);

            $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementOut->header->branch_id));

            $this->renderPartial('_detail', array(
                'movementOut' => $movementOut,
                'warehouses' => $warehouses,
            ));
        }
    }

    public function actionAjaxDelivery($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = TransactionDeliveryOrder::model()->findByPk($id);
            $type = $requestNumber = "";

            if (count($delivery) != 0) {
                if ($delivery->request_type == "Sales Order") {
                    $type = "Sales Order";
                    $requestNumber = $delivery->salesOrder->sale_order_no;
                } elseif ($delivery->request_type == "Sent Request") {
                    $type = "Sent Request";
                    $requestNumber = $delivery->sentRequest->sent_request_no;
                } elseif ($delivery->request_type == "Consignment Out") {
                    $type = "Consignment out";
                    $requestNumber = $delivery->consignmentOut->consignment_out_no;
                }
            }
            
            $object = array(
                'id' => $delivery->id,
                'number' => $delivery->delivery_order_no,
                'type' => $type,
                'requestNumber' => $requestNumber,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateStatus($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['MovementOutHeader'])) {
            $model->status = $_POST['MovementOutHeader']['status'];
            $model->supervisor_id = $_POST['MovementOutHeader']['supervisor_id'];

            if ($model->update(array('status', 'supervisor_id')))
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('updateStatus', array(
            'model' => $model,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $movement = MovementOutHeader::model()->findByPK($headerId);
        $historis = MovementOutApproval::model()->findAllByAttributes(array('movement_out_id' => $headerId));
        $model = new MovementOutApproval;
        $model->date = date('Y-m-d H:i:s');
        $details = MovementOutDetail::model()->findAllByAttributes(array('movement_out_header_id' => $headerId));

        if (isset($_POST['MovementOutApproval']) && IdempotentManager::check() && IdempotentManager::build()->save()) {
            $model->attributes = $_POST['MovementOutApproval'];
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $movement->movement_out_no,
                'branch_id' => $movement->branch_id,
            ));

            if ($model->save()) {
                $movement->status = $model->approval_type;
                $movement->save(false);

                if ($model->approval_type == 'Approved') {
                    $transactionType = $movement->movement_type == 4 ? 'MOM' : 'MO';
                    $postingDate = date('Y-m-d');
                    $transactionCode = $movement->movement_out_no;
                    $transactionDate = $movement->date_posting;
                    $branchId = $movement->branch_id;
                    $transactionSubject = $movement->getMovementType($movement->movement_type);

                    $journalReferences = array();

                    foreach ($details as $movementDetail) {
                        $quantity = $movementDetail->quantity;
                        if ($movementDetail->unit_id !== $movementDetail->product->unit_id) {
                            $conversionFactor = 1;
                            $unitConversion = UnitConversion::model()->findByAttributes(array(
                                'unit_from_id' => $movementDetail->unit_id, 
                                'unit_to_id' => $movementDetail->product->unit_id
                            ));
                            if ($unitConversion !== null) {
                                $conversionFactor = $unitConversion->multiplier;
                            } else {
                                $unitConversionFlipped = UnitConversion::model()->findByAttributes(array(
                                    'unit_from_id' => $movementDetail->product->unit_id, 
                                    'unit_to_id' => $movementDetail->unit_id
                                ));
                                if ($unitConversionFlipped !== null) {
                                    $conversionFactor = 1 / $unitConversionFlipped->multiplier;
                                }
                            }
                            $quantity = $conversionFactor * $quantity;
                        }

                        $value = $quantity * $movementDetail->product->hpp;

                        if ((int)$movement->movement_type == 3) {
                            $coaId = $movementDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                            $journalReferences[$coaId]['debet_kredit'] = 'D';
                            $journalReferences[$coaId]['is_coa_category'] = 0;
                            $journalReferences[$coaId]['values'][] = $value;

                        } else {
                            $coaId = $movementDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                            $journalReferences[$coaId]['debet_kredit'] = 'D';
                            $journalReferences[$coaId]['is_coa_category'] = 0;
                            $journalReferences[$coaId]['values'][] = $value;
                        }

                        $coaId = $movementDetail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                        $journalReferences[$coaId]['debet_kredit'] = 'K';
                        $journalReferences[$coaId]['is_coa_category'] = 0;
                        $journalReferences[$coaId]['values'][] = $value;
                    }

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
                    }
                }

                $this->saveTransactionLog('approval', $movement);
        
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'movement' => $movement,
            'historis' => $historis,
        ));
    }

    public function saveTransactionLog($actionType, $movement) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $movement->movement_out_no;
        $transactionLog->transaction_date = $movement->date_posting;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $movement->tableName();
        $transactionLog->table_id = $movement->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $movement->attributes;
        
        if ($actionType === 'approval') {
            $newData['movementOutApprovals'] = array();
            foreach($movement->movementOutApprovals as $detail) {
                $newData['movementOutApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['movementOutDetails'] = array();
            foreach($movement->movementOutDetails as $detail) {
                $newData['movementOutDetails'][] = $detail->attributes;
            }
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionAjaxReturn($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $return = TransactionReturnOrder::model()->findByPk($id);
            $object = array(
                'id' => $return->id,
                'number' => $return->return_order_no,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxRetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $retail = RegistrationTransaction::model()->findByPk($id);
            $object = array(
                'id' => $retail->id,
                'number' => $retail->transaction_number,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxMaterialRequest($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $materialRequest = MaterialRequestHeader::model()->findByPk($id);
            $object = array(
                'id' => $materialRequest->id,
                'number' => $materialRequest->transaction_number,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateDelivered($id) {
        IdempotentManager::generate();
        $movementOut = $this->instantiate($id, '');
        
        $delivered = new MovementOutShipping();
        $delivered->movement_out_id = $id;
        $delivered->status = "Delivered";
        $delivered->date = date('Y-m-d');
        $delivered->supervisor_id = Yii::app()->user->getId();

        if (IdempotentManager::check() && IdempotentManager::build()->save()) {
            InventoryDetail::model()->deleteAllByAttributes(array(
                'transaction_number' => $movementOut->header->movement_out_no,
            ));

            if ($delivered->save()) {
                if ($movementOut->header->movement_type == 1) {
                    $notes = 'Movement Delivery Order';
                } else if ($movementOut->header->movement_type == 2) {
                    $notes = 'Movement Return Order';
                } else if ($movementOut->header->movement_type == 3) {
                    $notes = 'Sale Retail';
                } else if ($movementOut->header->movement_type == 4) {
                    $notes = 'Movement Material Request';
                } else {
                    $notes = 'Data from Movement Out';
                }
                
                foreach ($movementOut->details as $movementDetail) {
                    $inventory = Inventory::model()->findByAttributes(array(
                        'product_id' => $movementDetail->product_id, 
                        'warehouse_id' => $movementDetail->warehouse_id
                    ));
                    
                    $quantity = $movementDetail->quantity;
                    if ($movementDetail->unit_id !== $movementDetail->product->unit_id) {
                        $conversionFactor = 1;
                        $unitConversion = UnitConversion::model()->findByAttributes(array(
                            'unit_from_id' => $movementDetail->unit_id, 
                            'unit_to_id' => $movementDetail->product->unit_id
                        ));
                        if ($unitConversion !== null) {
                            $conversionFactor = $unitConversion->multiplier;
                        } else {
                            $unitConversionFlipped = UnitConversion::model()->findByAttributes(array(
                                'unit_from_id' => $movementDetail->product->unit_id, 
                                'unit_to_id' => $movementDetail->unit_id
                            ));
                            if ($unitConversionFlipped !== null) {
                                $conversionFactor = 1 / $unitConversionFlipped->multiplier;
                            }
                        }
                        $quantity = $conversionFactor * $quantity;
                    }

                    if (empty($inventory)) {
                        $insertInventory = new Inventory();
                        $insertInventory->product_id = $movementDetail->product_id;
                        $insertInventory->warehouse_id = $movementDetail->warehouse_id;
                        $insertInventory->minimal_stock = 0;
                        $insertInventory->total_stock = $quantity * -1;
                        $insertInventory->status = 'Active';
                        $insertInventory->save();

                        $inventoryId = $insertInventory->id;
                    } else {
                        $inventory->total_stock -= $quantity;
                        $inventory->update(array('total_stock'));

                        $inventoryId = $inventory->id;

                    }

                    if (!empty($inventoryId)) {
                        $inventoryDetail = new InventoryDetail();
                        $inventoryDetail->inventory_id = $inventoryId;
                        $inventoryDetail->product_id = $movementDetail->product_id;
                        $inventoryDetail->warehouse_id = $movementDetail->warehouse_id;
                        $inventoryDetail->transaction_type = 'MVO';
                        $inventoryDetail->transaction_number = $movementOut->header->movement_out_no;
                        $inventoryDetail->transaction_date = $movementOut->header->date_posting;
                        $inventoryDetail->stock_out = $quantity * -1;
                        $inventoryDetail->notes = $notes;
                        $inventoryDetail->purchase_price = $movementDetail->product->averageCogs;
                        $inventoryDetail->transaction_time = date('H:i:s');
                        $inventoryDetail->save(false);
                    }
                    
                    $movementType = $movementOut->header->movement_type;
                    if ($movementType == 1) {
                        $criteria = new CDbCriteria;
                        $criteria->condition = "delivery_order_detail_id =" . $movementDetail->delivery_order_detail_id . " AND product_id = " . $movementDetail->product_id;
                        $mvmntDetails = MovementOutDetail::model()->findAll($criteria);

                        $quantity = 0;

                        foreach ($mvmntDetails as $mvmntDetail) {
                            $quantity += $mvmntDetail->quantity;
                        }

                        $deliveryDetail = TransactionDeliveryOrderDetail::model()->findByAttributes(array('id' => $movementDetail->delivery_order_detail_id, 'delivery_order_id' => $movementOut->header->delivery_order_id));
                        $deliveryDetail->quantity_movement_left = $deliveryDetail->quantity_delivery - $quantity;
                        $deliveryDetail->quantity_movement = $quantity;
                        $deliveryDetail->quantity_receive = 0;
                        $deliveryDetail->quantity_receive_left = $quantity;
                        $deliveryDetail->save(false);
                    } elseif ($movementType == 2) {
                        $criteria = new CDbCriteria;
                        $criteria->together = 'true';
                        $criteria->with = array('movementOutHeader');
                        $criteria->condition = "movementOutHeader.return_order_id =" . $movementOut->header->return_order_id . " AND movement_out_header_id != " . $movementOut->header->id;
                        $mvmntDetails = MovementOutDetail::model()->findAll($criteria);
                        $quantity = 0;

                        foreach ($mvmntDetails as $mvmntDetail) {
                            $quantity += $mvmntDetail->quantity;
                        }

                        $deliveryDetail = TransactionReturnOrderDetail::model()->findByAttributes(array('id' => $movementDetail->return_order_detail_id, 'return_order_id' => $movementOut->header->return_order_id));
                        $deliveryDetail->quantity_movement_left = $movementDetail->quantity_transaction - ($movementDetail->quantity + $quantity);
                        $deliveryDetail->quantity_movement = $quantity + $movementDetail->quantity;
                        $deliveryDetail->save(false);
                    } elseif ($movementType == 3) {
                        $criteria = new CDbCriteria;
                        $criteria->together = 'true';
                        $criteria->with = array('movementOutHeader');
                        $criteria->condition = "movementOutHeader.registration_transaction_id =" . $movementOut->header->registration_transaction_id . " AND movement_out_header_id != " . $movementOut->header->id;
                        $mvmntDetails = MovementOutDetail::model()->findAll($criteria);
                        $quantity = 0;

                        foreach ($mvmntDetails as $mvmntDetail) {
                            $quantity += $mvmntDetail->quantity;
                        }

                        $registrationProduct = RegistrationProduct::model()->findByAttributes(array('id' => $movementDetail->registration_product_id, 'registration_transaction_id' => $movementOut->header->registration_transaction_id));
                        $registrationProduct->quantity_movement = $registrationProduct->getTotalMovementOutQuantity();
                        $registrationProduct->quantity_movement_left = $registrationProduct->quantity - $registrationProduct->quantity_movement;
                        $registrationProduct->save(false);
                    } elseif ($movementType == 4) {
                        $materialRequestDetail = MaterialRequestDetail::model()->findByPk($movementDetail->material_request_detail_id);
                        $materialRequestDetail->quantity_movement_out = $materialRequestDetail->getTotalQuantityMovementOut();
                        $materialRequestDetail->quantity_remaining = $materialRequestDetail->quantity - $materialRequestDetail->quantity_movement_out;
                        $materialRequestDetail->update(array('quantity_movement_out', 'quantity_remaining'));

                        $materialRequestHeader = MaterialRequestHeader::model()->findByPk($materialRequestDetail->material_request_header_id);
                        $materialRequestHeader->total_quantity_movement_out = $materialRequestHeader->getTotalQuantityMovementOut();
                        $materialRequestHeader->total_quantity_remaining = $materialRequestHeader->total_quantity - $materialRequestHeader->total_quantity_movement_out;
                        $materialRequestHeader->status_progress = ($materialRequestHeader->total_quantity_remaining > 0) ? 'PARTIAL MOVEMENT' : 'COMPLETED';
                        $materialRequestHeader->update(array('total_quantity_movement_out', 'total_quantity_remaining', 'status_progress'));
                    }
                }

                $movementOut->header->status = "Finished";
                $movementOut->header->save(false);
            
            }
        }
    }
}
