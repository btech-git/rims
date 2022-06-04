<?php

class ReceivableLedgerController extends Controller {

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

        $customer = new Customer('search');
//        $customer->unsetAttributes();  // clear any default values
//        if (isset($_GET['Customer'])) {
//            $customer->attributes = $_GET['Customer'];
//        }
//        $customerCriteria = new CDbCriteria;
//        $customerCriteria->compare('t.name', $customer->name, true);
//        $customerCriteria->compare('t.customer_type', $customer->customer_type, true);
//        $customerDataProvider = new CActiveDataProvider('Customer', array(
//            'criteria' => $customerCriteria,
//            'sort' => array(
//                "defaultOrder" => "t.status ASC, t.name ASC",
//            ),
//        ));

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $receivableLedgerSummary = new ReceivableLedgerSummary($customer->searchByReceivable());
        $receivableLedgerSummary->setupLoading();
        $receivableLedgerSummary->setupPaging($pageSize, $currentPage);
        $receivableLedgerSummary->setupSorting();
        $filters = array(
            'customerName' => $customerName,
            'endDate' => $endDate,
        );
        $receivableLedgerSummary->setupFilter($filters);
        
        $this->render('summary', array(
            'customer' => $customer,
            'customerName' => $customerName,
            'receivableLedgerSummary' => $receivableLedgerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customer = Customer::model()->findByPk($_POST['Customer']['id']);
            
            $object = array(
                'customer_type' => $customer->customer_type,
                'customer_name' => $customer->name,
                'customer_address' => $customer->address,
            );
            echo CJSON::encode($object);
        }
    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/view', 'id' => $model->id));
        }
    }
}