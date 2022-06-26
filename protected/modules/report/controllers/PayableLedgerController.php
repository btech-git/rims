<?php

class PayableLedgerController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('allAccountingReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';

        $payableLedgerSummary = new PayableLedgerSummary($supplier->searchByPayable($startDate));
        $payableLedgerSummary->setupLoading();
        $payableLedgerSummary->setupPaging($pageSize, $currentPage);
        $payableLedgerSummary->setupSorting();
        $filters = array(
            'supplierName' => $supplierName,
        );
        $payableLedgerSummary->setupFilter($filters);
        
//        $supplier->unsetAttributes();  // clear any default values
//        if (isset($_GET['Supplier'])) {
//            $supplier->attributes = $_GET['Supplier'];
//        }
//        $supplierCriteria = new CDbCriteria;
//        $supplierCriteria->compare('t.name', $supplier->name, true);
//        $supplierCriteria->compare('t.company', $supplier->company, true);
//        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
//            'criteria' => $supplierCriteria,
//            'sort' => array(
//                "defaultOrder" => "t.status ASC, t.name ASC",
//            ),
//        ));

        $this->render('summary', array(
            'supplier' => $supplier,
            'supplierName' => $supplierName,
//            'supplierDataProvider' => $supplierDataProvider,
            'payableLedgerSummary' => $payableLedgerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonSupplier() {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = Supplier::model()->findByPk($_POST['Supplier']['id']);
            
            $object = array(
                'supplier_company' => $supplier->company,
                'supplier_name' => $supplier->name,
                'supplier_address' => $supplier->address,
            );
            echo CJSON::encode($object);
        }
    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentOut/view', 'id' => $model->id));
        }
    }
}