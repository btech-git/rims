<?php

class PaymentOutController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('salePaymentCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('salePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'ajaxHtmlResetPayment' || $filterChain->action->id === 'ajaxHtmlRemovePayment' || $filterChain->action->id === 'ajaxHtmlAddAccount' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxJsonSaleReceipt' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('salePaymentCreate') || Yii::app()->user->checkAccess('salePaymentEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionPurchaseOrderList() {

        $purchaseOrder = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : array());
        $purchaseOrderDataProvider = $purchaseOrder->searchForPaymentOut();
        $purchaseOrderDataProvider->criteria->with = array('supplier');
        $purchaseOrderDataProvider->criteria->order = 't.purchase_order_date DESC';

        $supplierName = isset($_GET['SupplierName']) ? $_GET['SupplierName'] : '';
        if (!empty($supplierName)) {
            $purchaseOrderDataProvider->criteria->addCondition('supplier.name LIKE :supplier_name');
            $purchaseOrderDataProvider->criteria->params[':supplier_name'] = "%{$supplierName}%";
        }

        $this->render('purchaseOrderList', array(
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
            'supplierName' => $supplierName,
        ));
    }

    public function actionCreate($purchaseOrderId) {
        $paymentOut = $this->instantiate(null);
        $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($purchaseOrderId);

        $paymentOut->header->user_id = Yii::app()->user->id;
        $paymentOut->header->payment_date = date('Y-m-d');
        $paymentOut->header->purchase_order_id = $purchaseOrderId;
        $paymentOut->header->supplier_id = $purchaseOrder->supplier_id;
        $paymentOut->header->status = 'Draft';
        $paymentOut->header->branch_id = Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id;
        $paymentOut->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentOut->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentOut->header->payment_date)), $paymentOut->header->branch_id);

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        if (!empty($purchaseOrderId)) {
            $receiveItemDataProvider->criteria->addCondition("t.purchase_order_id = :purchase_order_id");
            $receiveItemDataProvider->criteria->params[':purchase_order_id'] = $purchaseOrderId;
        }
        
        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['Submit'])) {
            $this->loadState($paymentOut);

            if ($paymentOut->save(Yii::app()->db)) {                
                $this->redirect(array('view', 'id' => $paymentOut->header->id));
            }
        }

        $this->render('create', array(
            'paymentOut' => $paymentOut,
            'purchaseOrder' => $purchaseOrder,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $paymentOut = $this->instantiate($id);
        $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($paymentOut->header->purchase_order_id);

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        if (!empty($paymentOut->purchase_order_id)) {
            $receiveItemDataProvider->criteria->addCondition("t.purchase_order_id = :purchase_order_id");
            $receiveItemDataProvider->criteria->params[':purchase_order_id'] = $paymentOut->purchase_order_id;
        }

        if (isset($_POST['Submit'])) {
            $this->loadState($paymentOut);

            if ($paymentOut->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $paymentOut->header->id));
        }

        $this->render('update', array(
            'paymentOut' => $paymentOut,
            'purchaseOrder' => $purchaseOrder,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
        ));
    }

    public function actionView($id) {
        $paymentOut = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('payment_out_id', $paymentOut->id);
        $detailsDataProvider = new CActiveDataProvider('PaymentOutDetail', array(
            'criteria' => $criteria,
        ));

        $postImages = PaymentOutImages::model()->findAllByAttributes(array(
            'payment_out_id' => $paymentOut->id,
            'is_inactive' => $paymentOut::STATUS_ACTIVE
        ));
        
        $this->render('view', array(
            'paymentOut' => $paymentOut,
            'detailsDataProvider' => $detailsDataProvider,
            'postImages' => $postImages,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $paymentOut = $this->instantiate($id);
            if ($paymentOut !== null) {
                foreach ($this->details as $detail) {
                    $receiveItemHeader = SaleInvoiceHeader::model()->findByPk($detail->sale_invoice_header_id);
                    $receiveItemHeader->total_payment = 0.00;
                    $valid = $receiveItemHeader->update(array('total_payment')) && $valid;
                }

                $paymentOut->delete(Yii::app()->db);

                Yii::app()->user->setFlash('message', 'Delete Successful');
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAdmin() {
        $paymentOut = Search::bind(new PaymentOut('search'), isset($_GET['PaymentOut']) ? $_GET['PaymentOut'] : array());
        $supplierName = isset($_GET['SupplierName']) ? $_GET['SupplierName'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $paymentOut->search();
        $dataProvider->criteria->with = array(
            'supplier',
        );

        if (!empty($supplierName)) {
            $dataProvider->criteria->addCondition("supplier.name LIKE :supplier_name");
            $dataProvider->criteria->params[':supplier_name'] = "%{$supplierName}%";
        }

        $dataProvider->criteria->order = 't.id DESC';

        $purchaseOrder = new TransactionPurchaseOrder('search');
        $purchaseOrder->unsetAttributes();
        
        if (isset($_GET['TransactionPurchaseOrder'])) {
            $purchaseOrder->attributes = $_GET['TransactionPurchaseOrder'];
        }
        
        $purchaseOrderCriteria = new CDbCriteria;
        $purchaseOrderCriteria->addCondition('t.payment_status != "PAID"');
        $purchaseOrderCriteria->addCondition('t.status_document = "Approved"');
        $purchaseOrderCriteria->compare('purchase_order_no', $purchaseOrder->purchase_order_no, true);
        $purchaseOrderCriteria->compare('purchase_order_date', $purchaseOrder->purchase_order_date, true);
        $purchaseOrderCriteria->compare('total_price', $purchaseOrder->total_price, true);
        $purchaseOrderCriteria->together = true;
        $purchaseOrderCriteria->with = array('supplier');
        $purchaseOrderCriteria->compare('supplier.name', $purchaseOrder->supplier_name, true);
        $purchaseOrderDataProvider = new CActiveDataProvider('TransactionPurchaseOrder', array(
            'criteria' => $purchaseOrderCriteria,
            'sort' => array(
                'defaultOrder' => 'purchase_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));

        $this->render('admin', array(
            'paymentOut' => $paymentOut,
            'dataProvider' => $dataProvider,
            'supplierName' => $supplierName,
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
        ));
    }

    public function actionAjaxHtmlAddInvoices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentOut = $this->instantiate($id);
            $this->loadState($paymentOut);

            if (isset($_POST['selectedIds'])) {
                $invoices = array();
                $invoices = $_POST['selectedIds'];

                foreach ($invoices as $invoice)
                    $paymentOut->addInvoice($invoice);
            }

            $this->renderPartial('_detail', array(
                'paymentOut' => $paymentOut,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentOut = $this->instantiate($id);
            $this->loadState($paymentOut);

            $paymentOut->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'paymentOut' => $paymentOut,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $paymentOut = new PaymentOutComponent(new PaymentOut(), array(), new PaymentOutImages());
        else {
            $paymentOutHeader = $this->loadModel($id);
            $paymentOut = new PaymentOutComponent($paymentOutHeader, $paymentOutHeader->paymentOutDetails, $paymentOutHeader->paymentOutImages);
        }

        return $paymentOut;
    }

    public function loadModel($id) {
        $model = PaymentOut::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function loadState(&$paymentOut) {
        if (isset($_POST['PaymentOut'])) {
            $paymentOut->header->attributes = $_POST['PaymentOut'];
        }
        
        if (isset($_POST['PaymentOutDetail'])) {
            foreach ($_POST['PaymentOutDetail'] as $i => $item) {
                if (isset($paymentOut->details[$i]))
                    $paymentOut->details[$i]->attributes = $item;
                else {
                    $detail = new PaymentOutDetail();
                    $detail->attributes = $item;
                    $paymentOut->details[] = $detail;
                }
            }
            if (count($_POST['PaymentOutDetail']) < count($paymentOut->details))
                array_splice($paymentOut->details, $i + 1);
        } else
            $paymentOut->details = array();
        
        $paymentOut->header->images = CUploadedFile::getInstances($paymentOut->header, 'images');
    }
}