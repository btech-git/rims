<?php

class FinancialForecastController extends Controller {

    public $layout = '//layouts/column1';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionSummary() {
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        $transactionDate = isset($_GET['TransactionDate']) ? $_GET['TransactionDate'] : date('Y-m-d');
        
        $coaBank = Search::bind(new Coa(), isset($_GET['Coa']) ? $_GET['Coa'] : '');
        $coaBankDataProvider = $coaBank->search();
        $coaBankDataProvider->criteria->compare('t.coa_id', 2);

        $payableTransaction = Search::bind(new TransactionPurchaseOrder(), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : '');
        $payableTransactionDataProvider = $payableTransaction->search();
        $payableTransactionDataProvider->criteria->addCondition('t.payment_left > 0 AND t.status_document = "Approved"');
        
        $receivableTransaction = Search::bind(new InvoiceHeader(), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $receivableTransactionDataProvider = $receivableTransaction->search();
        $receivableTransactionDataProvider->criteria->addCondition('t.payment_left > 0 AND t.status <> "CANCELLED"');
        
        $this->render('summary', array(
            'transactionDate' => $transactionDate,
            'coaBank' => $coaBank,
            'coaBankDataProvider' => $coaBankDataProvider,
            'payableTransaction' => $payableTransaction,
            'payableTransactionDataProvider' => $payableTransactionDataProvider,
            'receivableTransaction' => $receivableTransaction,
            'receivableTransactionDataProvider' => $receivableTransactionDataProvider,
        ));
    }
    
    public function actionUpdateDueDate($id) {
        $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($id);
        
        if (isset($_POST['TransactionPurchaseOrder'])) {
            $purchaseOrder->attributes = $_POST['TransactionPurchaseOrder'];
            
            if ($purchaseOrder->save(Yii::app()->db)) {
                echo CHtml::script('window.opener.location.reload(false); window.close();');
                Yii::app()->end();
            }
        }

        $this->render('update', array(
            'purchaseOrder' => $purchaseOrder,
        ));
    }
}
