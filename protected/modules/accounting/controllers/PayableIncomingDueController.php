<?php

class PayableIncomingDueController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('dailySaleAllMechanicReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $payableIncomingDueDate = TransactionReceiveItem::getPayableIncomingDueDate();
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($payableIncomingDueDate);
        }
        
        $this->render('index', array(
            'payableIncomingDueDate' => $payableIncomingDueDate,
        ));
    }
}