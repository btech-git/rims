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
        
        $paymentInByTypeList = PaymentIn::getPaymentByTypeList($month, $year, $branchId);
        $paymentOutByTypeList = PaymentOut::getPaymentByTypeList($month, $year, $branchId);
        
        $paymentTypeIdList = array();
        foreach ($paymentTypes as $paymentType) {
            $paymentTypeIdList[] = $paymentType->id;
        }
        
        $paymentInList = array();
        $lastPaymentInDate = '';
        foreach ($paymentInByTypeList as $paymentInByTypeRow) {
            if ($lastPaymentInDate !== $paymentInByTypeRow['payment_date']) {
                $paymentInList[$paymentInByTypeRow['payment_date']][0] = $paymentInByTypeRow['payment_date'];
                foreach ($paymentTypeIdList as $paymentTypeId) {
                    $paymentInList[$paymentInByTypeRow['payment_date']][$paymentTypeId] = '0.00';
                }
            }
            $paymentInList[$paymentInByTypeRow['payment_date']][$paymentInByTypeRow['payment_type_id']] = $paymentInByTypeRow['total_amount'];
            $lastPaymentInDate = $paymentInByTypeRow['payment_date'];
        }

        
        $paymentOutList = array();
        $lastPaymentOutDate = '';
        foreach ($paymentOutByTypeList as $paymentOutByTypeRow) {
            if ($lastPaymentOutDate !== $paymentOutByTypeRow['payment_date']) {
                $paymentOutList[$paymentOutByTypeRow['payment_date']][0] = $paymentOutByTypeRow['payment_date'];
                foreach ($paymentTypeIdList as $paymentTypeId) {
                    $paymentOutList[$paymentOutByTypeRow['payment_date']][$paymentTypeId] = '0.00';
                }
            }
            $paymentOutList[$paymentOutByTypeRow['payment_date']][$paymentOutByTypeRow['payment_type_id']] = $paymentOutByTypeRow['total_amount'];
            $lastPaymentOutDate = $paymentOutByTypeRow['payment_date'];
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
            'paymentOutList' => $paymentOutList,
            'yearList' => $yearList,
            'paymentTypes' => $paymentTypes,
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
            'branchId' => $branchId,
        ));
    }
}