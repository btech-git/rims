<?php

class CancelledTransactionController extends Controller {

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
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $generalRepairDataProvider = $registrationTransaction->search();
        $generalRepairDataProvider->criteria->order = 't.transaction_date DESC';
        $generalRepairDataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        $generalRepairDataProvider->criteria->addCondition('t.repair_type = "GR" AND t.status = "CANCELLED!!!"');

        $bodyRepairDataProvider = $registrationTransaction->search();
        $bodyRepairDataProvider->criteria->order = 't.transaction_date DESC';
        $bodyRepairDataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        $bodyRepairDataProvider->criteria->addCondition('t.repair_type = "BR" AND t.status = "CANCELLED!!!"');

        $purchaseOrder = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : '');
        $purchaseOrderDataProvider = $purchaseOrder->search();
        $purchaseOrderDataProvider->criteria->order = 't.purchase_order_date DESC';
        $purchaseOrderDataProvider->criteria->addBetweenCondition('t.purchase_order_date', $startDate, $endDate);
        $purchaseOrderDataProvider->criteria->addCondition('t.status_document = "CANCELLED!!!"');

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $invoiceHeaderDataProvider = $invoiceHeader->search();
        $invoiceHeaderDataProvider->criteria->order = 't.invoice_date DESC';
        $invoiceHeaderDataProvider->criteria->addBetweenCondition('t.invoice_date', $startDate, $endDate);
        $invoiceHeaderDataProvider->criteria->addCondition('t.status = "CANCELLED!!!"');

        $paymentIn = Search::bind(new PaymentIn('search'), isset($_GET['PaymentIn']) ? $_GET['PaymentIn'] : '');
        $paymentInDataProvider = $paymentIn->search();
        $paymentInDataProvider->criteria->order = 't.payment_date DESC';
        $paymentInDataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        $paymentInDataProvider->criteria->addCondition('t.status = "CANCELLED!!!"');

        $paymentOut = Search::bind(new PaymentOut('search'), isset($_GET['PaymentOut']) ? $_GET['PaymentOut'] : '');
        $paymentOutDataProvider = $paymentOut->search();
        $paymentOutDataProvider->criteria->order = 't.payment_date DESC';
        $paymentOutDataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        $paymentOutDataProvider->criteria->addCondition('t.status = "CANCELLED!!!"');

        $cashTransaction = Search::bind(new CashTransaction('search'), isset($_GET['CashTransaction']) ? $_GET['CashTransaction'] : '');
        $cashTransactionDataProvider = $cashTransaction->search();
        $cashTransactionDataProvider->criteria->order = 't.transaction_date DESC';
        $cashTransactionDataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        $cashTransactionDataProvider->criteria->addCondition('t.status = "CANCELLED!!!"');

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : '');
        $receiveItemDataProvider = $receiveItem->search();
        $receiveItemDataProvider->criteria->order = 't.receive_item_date DESC';
        $receiveItemDataProvider->criteria->addBetweenCondition('t.receive_item_date', $startDate, $endDate);
        $receiveItemDataProvider->criteria->addCondition('t.user_id_cancelled IS NOT null');

        $movementOut = Search::bind(new MovementOutHeader('search'), isset($_GET['MovementOutHeader']) ? $_GET['MovementOutHeader'] : '');
        $movementOutDataProvider = $movementOut->search();
        $movementOutDataProvider->criteria->order = 't.date_posting DESC';
        $movementOutDataProvider->criteria->addBetweenCondition('t.date_posting', $startDate, $endDate);
        $movementOutDataProvider->criteria->addCondition('t.status = "CANCELLED!!!"');

        $movementIn = Search::bind(new MovementInHeader('search'), isset($_GET['MovementInHeader']) ? $_GET['MovementInHeader'] : '');
        $movementInDataProvider = $movementIn->search();
        $movementInDataProvider->criteria->order = 't.date_posting DESC';
        $movementInDataProvider->criteria->addBetweenCondition('t.date_posting', $startDate, $endDate);
        $movementInDataProvider->criteria->addCondition('t.status = "CANCELLED!!!"');

        if (!empty($branchId)) {
            $generalRepairDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $generalRepairDataProvider->criteria->params[':branch_id'] = $branchId;

            $bodyRepairDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $bodyRepairDataProvider->criteria->params[':branch_id'] = $branchId;
            
            $purchaseOrderDataProvider->criteria->addCondition('t.main_branch_id = :branch_id');
            $purchaseOrderDataProvider->criteria->params[':branch_id'] = $branchId;

            $invoiceHeaderDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $invoiceHeaderDataProvider->criteria->params[':branch_id'] = $branchId;
            
            $paymentInDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $paymentInDataProvider->criteria->params[':branch_id'] = $branchId;

            $paymentOutDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $paymentOutDataProvider->criteria->params[':branch_id'] = $branchId;
            
            $cashTransactionDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $cashTransactionDataProvider->criteria->params[':branch_id'] = $branchId;

            $receiveItemDataProvider->criteria->addCondition('t.recipient_branch_id = :branch_id');
            $receiveItemDataProvider->criteria->params[':branch_id'] = $branchId;
            
            $movementOutDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $movementOutDataProvider->criteria->params[':branch_id'] = $branchId;

            $movementInDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $movementInDataProvider->criteria->params[':branch_id'] = $branchId;
        }

        $this->render('index', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'registrationTransaction' => $registrationTransaction,
            'generalRepairDataProvider' => $generalRepairDataProvider,
            'bodyRepairDataProvider' => $bodyRepairDataProvider,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
            'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
            'paymentInDataProvider' => $paymentInDataProvider,
            'paymentOutDataProvider' => $paymentOutDataProvider,
            'cashTransactionDataProvider' => $cashTransactionDataProvider,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'movementOutDataProvider' => $movementOutDataProvider,
            'movementInDataProvider' => $movementInDataProvider,
        ));
    }
}
