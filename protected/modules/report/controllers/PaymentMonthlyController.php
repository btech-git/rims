<?php

class PaymentMonthlyController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director') )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        
        $paymentTypes = PaymentType::model()->findAll();
        
        $paymentByTypeList = PaymentIn::getPaymentByTypeList($month, $year, $branchId);
        
        $paymentTypeIdList = array();
        foreach ($paymentTypes as $paymentType) {
            $paymentTypeIdList[] = $paymentType->id;
        }
        
        $paymentInList = array();
        $lastPaymentDate = '';
        foreach ($paymentByTypeList as $paymentByTypeRow) {
            if ($lastPaymentDate !== $paymentByTypeRow['payment_date']) {
                $paymentInList[$paymentByTypeRow['payment_date']][0] = $paymentByTypeRow['payment_type'];
                foreach ($paymentTypeIdList as $paymentTypeId) {
                    $paymentInList[$paymentByTypeRow['payment_date']][$paymentTypeId] = '0.00';
                }
            }
            $paymentInList[$paymentByTypeRow['payment_date']][$paymentByTypeRow['payment_type_id']] = $paymentByTypeRow['total_amount'];
            $lastPaymentDate = $paymentByTypeRow['payment_date'];
        }

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($cashTransactionSummary, $branchId, $cashTransactionSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
//        }

        $this->render('summary', array(
            'paymentInList' => $paymentInList,
            'yearList' => $yearList,
            'paymentTypes' => $paymentTypes,
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
            'branchId' => $branchId,
        ));
    }
}