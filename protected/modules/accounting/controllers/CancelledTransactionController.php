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
//        $generalRepairDataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
//        $generalRepairDataProvider->criteria->addCondition('t.repair_type = "GR" AND t.status = "CANCELLED!!!"');

        $bodyRepairDataProvider = $registrationTransaction->search();
//        $bodyRepairDataProvider->criteria->order = 't.transaction_date DESC';
//        $bodyRepairDataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
//        $bodyRepairDataProvider->criteria->addCondition('t.repair_type = "BR" AND t.status = "CANCELLED!!!"');

//        if (!empty($branchId)) {
//            $generalRepairDataProvider->criteria->addCondition('t.branch_id = :branch_id');
//            $generalRepairDataProvider->criteria->params[':branch_id'] = $branchId;
//
//            $bodyRepairDataProvider->criteria->addCondition('t.branch_id = :branch_id');
//            $bodyRepairDataProvider->criteria->params[':branch_id'] = $branchId;
//        }

        $this->render('index', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'generalRepairDataProvider' => $generalRepairDataProvider,
            'bodyRepairDataProvider' => $bodyRepairDataProvider,
        ));
    }
}
