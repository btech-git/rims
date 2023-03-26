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
            if (!(Yii::app()->user->checkAccess('movementOutCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'updateDelivered' || 
            $filterChain->action->id === 'updateStatus' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('movementOutEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('movementOutApproval')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('movementOutCreate')) || !(Yii::app()->user->checkAccess('movementOutEdit')) || !(Yii::app()->user->checkAccess('movementOutApproval')))
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
        $details = MovementOutDetail::model()->findAllByAttributes(array('movement_out_header_id' => $id));
        $historis = MovementOutApproval::model()->findAllByAttributes(array('movement_out_id' => $id));
        $shippings = MovementOutShipping::model()->findAllByAttributes(array('movement_out_id' => $id));
        
        if (isset($_POST['Process'])) {
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
                $value = $movementDetail->quantity * $movementDetail->product->hpp;

                if ((int)$model->movement_type == 3) {
                    $coaId = $movementDetail->product->productMasterCategory->coa_outstanding_part_id;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 1;
                    $journalReferences[$coaId]['values'][] = $value;
                    $coaId = $movementDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $value;
                    
                } else {
                    $coaId = $movementDetail->product->productMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 1;
                    $journalReferences[$coaId]['values'][] = $value;
                    $coaId = $movementDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $value;
                    
                }

                $coaId = $movementDetail->product->productMasterCategory->coa_persediaan_barang_dagang;
                $journalReferences[$coaId]['debet_kredit'] = 'K';
                $journalReferences[$coaId]['is_coa_category'] = 1;
                $journalReferences[$coaId]['values'][] = $value;
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($transactionId, $movementType) {
        
        $movementOut = $this->instantiate(null);
        $movementOut->header->created_datetime = date('Y-m-d H:i:s');
        $movementOut->header->date_posting = date('Y-m-d H:i:s');
        $movementOut->header->registration_service_id = null;
        $movementOut->header->movement_type = $movementType;
        $this->performAjaxValidation($movementOut->header);

        if ($movementType == 1) {
            $deliveryOrder = TransactionDeliveryOrder::model()->findByPk($transactionId);
            $movementOut->header->delivery_order_id = $transactionId;
            $movementOut->header->return_order_id = null;
            $movementOut->header->material_request_header_id = null;
            $movementOut->header->registration_transaction_id = null;
            $movementOut->header->branch_id = $deliveryOrder->sender_branch_id;
            
        } else if ($movementType == 2) {
            $returnOrder = TransactionReturnOrder::model()->findByPk($transactionId);
            $movementOut->header->delivery_order_id = null;
            $movementOut->header->return_order_id = $transactionId;
            $movementOut->header->material_request_header_id = null;
            $movementOut->header->registration_transaction_id = null;
            $movementOut->header->branch_id = $returnOrder->recipient_branch_id;
            
        } else if ($movementType == 3) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($transactionId);
            $movementOut->header->delivery_order_id = null;
            $movementOut->header->return_order_id = null;
            $movementOut->header->material_request_header_id = null;
            $movementOut->header->registration_transaction_id = $transactionId;
            $movementOut->header->branch_id = $registrationTransaction->branch_id;
        } else if ($movementType == 4) {
            $materialRequest = MaterialRequestHeader::model()->findByPk($transactionId);
            $movementOut->header->delivery_order_id = null;
            $movementOut->header->return_order_id = null;
            $movementOut->header->registration_transaction_id = null;
            $movementOut->header->material_request_header_id = $transactionId;
            $movementOut->header->branch_id = $materialRequest->branch_id;
        } else {
            $this->redirect(array('admin'));
        }
            
        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementOut->header->branch_id));

        $movementOut->addDetails($transactionId, $movementType);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['MovementOutHeader'])) {
            $this->loadState($movementOut);
            $movementOut->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($movementOut->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($movementOut->header->date_posting)), $movementOut->header->branch_id);
            
            if ($movementOut->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementOut->header->id));
            }
        }

        $this->render('create', array(
            'movementOut' => $movementOut,
            'warehouses' => $warehouses,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $movementOut = $this->instantiate($id);
        $movementOut->header->setCodeNumberByRevision('movement_out_no');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($movementOut->header);

//        $deliveryOrder = new TransactionDeliveryOrder('search');
//        $deliveryOrder->unsetAttributes();
//        
//        if (isset($_GET['TransactionDeliveryOrder']))
//            $deliveryOrder->attributes = $_GET['TransactionDeliveryOrder'];
//        
//        $deliveryOrderCriteria = new CDbCriteria;
//        $deliveryOrderCriteria->compare('sender_branch_id', $movementOut->header->branch_id);
//        $deliveryOrderCriteria->together = 'true';
//        $deliveryOrderCriteria->with = array('senderBranch');
//        $deliveryOrderCriteria->compare('senderBranch.name', $deliveryOrder->branch_name, true);
//        $deliveryOrderCriteria->compare('delivery_order_no', $deliveryOrder->delivery_order_no, true);
//        $deliveryOrderDataProvider = new CActiveDataProvider('TransactionDeliveryOrder', array('criteria' => $deliveryOrderCriteria));
//
//        $deliveryOrderDetail = new TransactionDeliveryOrderDetail('search');
//        $deliveryOrderDetail->unsetAttributes();  // clear any default values
//        
//        if (isset($_GET['TransactionDeliveryOrderDetail']))
//            $deliveryOrderDetail->attributes = $_GET['TransactionDeliveryOrderDetail'];
//        
//        $deliveryOrderDetailCriteria = new CDbCriteria;
//        $deliveryOrderDetailCriteria->compare('delivery_order_id', $movementOut->header->delivery_order_id);
//        $deliveryOrderDetailCriteria->together = 'true';
//        $deliveryOrderDetailCriteria->with = array('product', 'deliveryOrder');
//        $deliveryOrderDetailCriteria->compare('delivery_order_id', $deliveryOrderDetail->delivery_order_id, true);
//        $deliveryOrderDetailCriteria->compare('deliveryOrder.delivery_order_no', $deliveryOrderDetail->delivery_order_no, true);
//        $deliveryOrderDetailCriteria->compare('product.name', $deliveryOrderDetail->product_name, true);
//        $deliveryOrderDetailDataProvider = new CActiveDataProvider('TransactionDeliveryOrderDetail', array(
//            'criteria' => $deliveryOrderDetailCriteria,
//        ));
//
//        /* Return Order */
//        $returnOrder = new TransactionReturnOrder('search');
//        $returnOrder->unsetAttributes();
//        
//        if (isset($_GET['TransactionReturnOrder']))
//            $returnOrder->attributes = $_GET['TransactionReturnOrder'];
//        
//        $returnOrderCriteria = new CDbCriteria;
//        $returnOrderCriteria->compare('recipient_branch_id', $returnOrder->recipient_branch_id, true);
//        $returnOrderCriteria->together = 'true';
//        $returnOrderCriteria->with = array('recipientBranch');
//        $returnOrderCriteria->compare('recipientBranch.name', $returnOrder->branch_name, true);
//        $returnOrderCriteria->compare('return_order_no', $returnOrder->return_order_no, true);
//        $returnOrderDataProvider = new CActiveDataProvider('TransactionReturnOrder', array('criteria' => $returnOrderCriteria));
//
//        $returnOrderDetail = new TransactionReturnOrderDetail('search');
//        $returnOrderDetail->unsetAttributes();  // clear any default values
//        
//        if (isset($_GET['TransactionReturnOrderDetail']))
//            $returnOrderDetail->attributes = $_GET['TransactionReturnOrderDetail'];
//        
//        $returnOrderDetailCriteria = new CDbCriteria;
//        $returnOrderDetailCriteria->together = 'true';
//        $returnOrderDetailCriteria->with = array('product', 'returnOrder');
//        $returnOrderDetailCriteria->compare('return_order_id', $returnOrderDetail->return_order_id, true);
//        $returnOrderDetailCriteria->compare('returnOrder.return_order_no', $returnOrderDetail->return_order_no, true);
//        $returnOrderDetailCriteria->compare('product.name', $returnOrderDetail->product_name, true);
//        $returnOrderDetailDataProvider = new CActiveDataProvider('TransactionReturnOrderDetail', array(
//            'criteria' => $returnOrderDetailCriteria,
//        ));
//
//        /* Registration Transaction */
//        $movementTransaction = new RegistrationTransaction('search');
//        $movementTransaction->unsetAttributes();
//        
//        if (isset($_GET['RegistrationTransaction']))
//            $movementTransaction->attributes = $_GET['RegistrationTransaction'];
//        
//        $movementTransactionCriteria = new CDbCriteria;
//        $movementTransactionCriteria->together = 'true';
//        $movementTransactionCriteria->with = array('branch');
//        $movementTransactionCriteria->compare('branch.name', $movementTransaction->branch_name, true);
//        $movementTransactionCriteria->compare('transaction_number', $movementTransaction->transaction_number, true);
//        $movementTransactionDataProvider = new CActiveDataProvider('RegistrationTransaction', array('criteria' => $movementTransactionCriteria));
//
//        $movementProduct = new RegistrationProduct('search');
//        $movementProduct->unsetAttributes();  // clear any default values
//        
//        if (isset($_GET['RegistrationProduct']))
//            $movementProduct->attributes = $_GET['RegistrationProduct'];
//        
//        $movementProductCriteria = new CDbCriteria;
//        $movementProductCriteria->together = 'true';
//        $movementProductCriteria->with = array('product', 'registrationTransaction');
//        $movementProductCriteria->compare('registrationTransaction.transaction_number', $movementProduct->transaction_number);
//        $movementProductCriteria->compare('product.name', $movementProduct->product_name, true);
//        $movementProductDataProvider = new CActiveDataProvider('RegistrationProduct', array(
//            'criteria' => $movementProductCriteria,
//        ));

        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementOut->header->branch_id));

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['MovementOutHeader'])) {
            $this->loadState($movementOut);
            
            if ($movementOut->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementOut->header->id));
            }
        }

        $this->render('update', array(
            'movementOut' => $movementOut,
            'warehouses' => $warehouses,
//            'deliveryOrder' => $deliveryOrder,
//            'deliveryOrderDataProvider' => $deliveryOrderDataProvider,
//            'deliveryOrderDetail' => $deliveryOrderDetail,
//            'deliveryOrderDetailDataProvider' => $deliveryOrderDetailDataProvider,
//            'returnOrder' => $returnOrder,
//            'returnOrderDataProvider' => $returnOrderDataProvider,
//            'returnOrderDetail' => $returnOrderDetail,
//            'returnOrderDetailDataProvider' => $returnOrderDetailDataProvider,
//            'registrationTransaction' => $movementTransaction,
//            'registrationTransactionDataProvider' => $movementTransactionDataProvider,
//            'registrationProduct' => $movementProduct,
//            'registrationProductDataProvider' => $movementProductDataProvider,
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
        
        if (isset($_GET['MovementOutHeader']))
            $model->attributes = $_GET['MovementOutHeader'];

        $dataProvider = $model->search();
        $dataProvider->criteria->addInCondition('branch_id', Yii::app()->user->branch_ids);

        /* Delivery Order */
        $deliveryOrder = new TransactionDeliveryOrder('search');
        $deliveryOrder->unsetAttributes();
        
        if (isset($_GET['TransactionDeliveryOrder'])) {
            $deliveryOrder->attributes = $_GET['TransactionDeliveryOrder'];
        }
        
        $deliveryOrderDataProvider = $deliveryOrder->searchByMovementOut();
        $deliveryOrderDataProvider->criteria->addCondition("t.delivery_date > '2021-12-31'");
        $deliveryOrderDataProvider->criteria->addInCondition('sender_branch_id', Yii::app()->user->branch_ids);

        $returnOrder = Search::bind(new TransactionReturnOrder('search'), isset($_GET['TransactionReturnOrder']) ? $_GET['TransactionReturnOrder'] : array());
        $returnOrderDataProvider = $returnOrder->searchByMovementOut();

        /* Registration Transaction */
        $registrationTransaction = new RegistrationTransaction('search');
        $registrationTransaction->unsetAttributes();
        if (isset($_GET['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_GET['RegistrationTransaction'];
        }

        $registrationTransactionDataProvider = $registrationTransaction->searchByMovementOut();
        $registrationTransactionDataProvider->criteria->addCondition('t.transaction_date > "2021-12-31"');
        $registrationTransactionDataProvider->criteria->addInCondition('branch_id', Yii::app()->user->branch_ids);

        /* Registration Transaction */
        $materialRequest = new MaterialRequestHeader('search');
        $materialRequest->unsetAttributes();
        if (isset($_GET['MaterialRequestHeader'])) {
            $materialRequest->attributes = $_GET['MaterialRequestHeader'];
        }

        $materialRequestDataProvider = $materialRequest->searchByMovementOut();
        $materialRequestDataProvider->criteria->addCondition('t.transaction_date > "2021-12-31"');
        $materialRequestDataProvider->criteria->addInCondition('branch_id', Yii::app()->user->branch_ids);

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

    public function instantiate($id) {

        if (empty($id)) {
            $movementOut = new MovementOuts(new MovementOutHeader(), array());
        } else {
            $movementOutModel = $this->loadModel($id);
            $movementOut = new MovementOuts($movementOutModel, $movementOutModel->movementOutDetails);
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
            $movementOut = $this->instantiate($id);
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
            $movementOut = $this->instantiate($id);
            $this->loadState($movementOut);

            $movementOut->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            //Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('movementOut' => $movementOut), false, true);
        }
    }

//    public function actionAjaxHtmlRemoveDetailAll($id) {
//        if (Yii::app()->request->isAjaxRequest) {
//            $movementOut = $this->instantiate($id);
//            $this->loadState($movementOut);
//
//            $movementOut->removeDetailAll();
//            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
//            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
//            $this->renderPartial('_detail', array('movementOut' => $movementOut), false, true);
//        }
//    }

    public function actionAjaxHtmlUpdateAllWarehouse($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementOut = $this->instantiate($id);
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
//        $branch = Branch::model()->findByPk($movement->branch_id);

        if (isset($_POST['MovementOutApproval'])) {
            $model->attributes = $_POST['MovementOutApproval'];
            if ($model->save()) {
                $movement->status = $model->approval_type;
                $movement->save(false);
                
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'movement' => $movement,
            'historis' => $historis,
        ));
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
        
        $movementOut = $this->instantiate($id);
        
        $delivered = new MovementOutShipping();
        $delivered->movement_out_id = $id;
        $delivered->status = "Delivered";
        $delivered->date = date('Y-m-d');
        $delivered->supervisor_id = Yii::app()->user->getId();

        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $movementOut->header->movement_out_no,
            'branch_id' => $movementOut->header->branch_id,
        ));

        $transactionType = 'MO';
        $postingDate = date('Y-m-d');
        $transactionCode = $movementOut->header->movement_out_no;
        $transactionDate = $movementOut->header->date_posting;
        $branchId = $movementOut->header->branch_id;
        $transactionSubject = $movementOut->header->getMovementType($movementOut->header->movement_type);
        
        $journalReferences = array();
        
        if ($delivered->save()) {
            
            foreach ($movementOut->details as $movementDetail) {
                $inventory = Inventory::model()->findByAttributes(array('product_id' => $movementDetail->product_id, 'warehouse_id' => $movementDetail->warehouse_id));
                
                if (empty($inventory)) {
                    $insertInventory = new Inventory();
                    $insertInventory->product_id = $movementDetail->product_id;
                    $insertInventory->warehouse_id = $movementDetail->warehouse_id;
                    $insertInventory->minimal_stock = 0;
                    $insertInventory->total_stock = $movementDetail->quantity * -1;
                    $insertInventory->status = 'Active';
                    $insertInventory->save();
                    
                    $inventoryId = $insertInventory->id;
                } else {
                    $inventory->total_stock -= $movementDetail->quantity;
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
                    $inventoryDetail->stock_out = $movementDetail->quantity * -1;
                    $inventoryDetail->notes = "Data from Movement Out";
                    $inventoryDetail->purchase_price = $movementDetail->product->averageCogs;
                    $inventoryDetail->save(false);
                }

                $value = $movementDetail->quantity * $movementDetail->product->hpp;

                if ((int)$movementOut->header->movement_type == 3) {
                    $coaId = $movementDetail->product->productMasterCategory->coa_outstanding_part_id;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 1;
                    $journalReferences[$coaId]['values'][] = $value;
                    $coaId = $movementDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $value;
                    
                } else {
                    $coaId = $movementDetail->product->productMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 1;
                    $journalReferences[$coaId]['values'][] = $value;
                    $coaId = $movementDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $value;
                    
                }

                $coaId = $movementDetail->product->productMasterCategory->coa_persediaan_barang_dagang;
                $journalReferences[$coaId]['debet_kredit'] = 'K';
                $journalReferences[$coaId]['is_coa_category'] = 1;
                $journalReferences[$coaId]['values'][] = $value;
                $coaId = $movementDetail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                $journalReferences[$coaId]['debet_kredit'] = 'K';
                $journalReferences[$coaId]['is_coa_category'] = 0;
                $journalReferences[$coaId]['values'][] = $value;

            }

            $movementOut->header->status = "Finished";
            $movementOut->header->save(false);
            
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
    } 
    
    public function actionInsertInventoryDetail() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $movementOutHeaders = MovementOutHeader::model()->findAll(array('condition' => 'date_posting > "2022-09-27"'));
        
        foreach ($movementOutHeaders as $movementOutHeader) {
            $inventoryDetails = InventoryDetail::model()->findAllByAttributes(array('transaction_number' => $movementOutHeader->movement_out_no));
            if (empty($inventoryDetails)) {
                foreach ($movementOutHeader->movementOutDetails as $movementOutDetail) {
                    $inventory = Inventory::model()->findByAttributes(array('product_id' => $movementOutDetail->product_id, 'warehouse_id' => $movementOutDetail->warehouse_id));
                    
                    if (empty($inventory)) {
                        $insertInventory = new Inventory();
                        $insertInventory->product_id = $movementOutDetail->product_id;
                        $insertInventory->warehouse_id = $movementOutDetail->warehouse_id;
                        $insertInventory->minimal_stock = 0;
                        $insertInventory->total_stock = $movementOutDetail->quantity * -1;
                        $insertInventory->status = 'Active';
                        $insertInventory->save();

                        $inventoryId = $insertInventory->id;
                    } else {
//                        $inventory->total_stock -= $movementOutDetail->quantity;
//                        $inventory->update(array('total_stock'));

                        $inventoryId = $inventory->id;

                    }

                    $inventoryDetail = new InventoryDetail();
                    $inventoryDetail->inventory_id = $inventoryId;
                    $inventoryDetail->product_id = $movementOutDetail->product_id;
                    $inventoryDetail->warehouse_id = $movementOutDetail->warehouse_id;
                    $inventoryDetail->transaction_type = 'MVO';
                    $inventoryDetail->transaction_number = $movementOutHeader->movement_out_no;
                    $inventoryDetail->transaction_date = $movementOutHeader->date_posting;
                    $inventoryDetail->stock_out = $movementOutDetail->quantity * -1;
                    $inventoryDetail->notes = "Data from Movement Out";
                    $inventoryDetail->purchase_price = $movementOutDetail->product->averageCogs;
                    $inventoryDetail->save();
                }
            }
        }
    }
}
