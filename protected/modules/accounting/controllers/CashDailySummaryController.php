<?php

class CashDailySummaryController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'summary' || 
            $filterChain->action->id === 'approval' || 
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('accountingReport')) || !(Yii::app()->user->checkAccess('financeReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionSummary() {
//        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 10;
//        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $transactionDate = isset($_GET['TransactionDate']) ? $_GET['TransactionDate'] : date('Y-m-d');
        $totalDaily = isset($_GET['TotalDaily']) ? $_GET['TotalDaily'] : 0.00;
        $paymentTypes = PaymentType::model()->findAll(); 
        
        $branchConditionSql = '';
        $params = array(
            ':payment_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $branchConditionSql = ' AND pi.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT pi.branch_id, pi.payment_type_id, b.name as branch_name, pt.name as payment_type_name, COALESCE(SUM(pi.payment_amount), 0) as total_amount
                FROM " . PaymentIn::model()->tableName() . " pi
                INNER JOIN " . PaymentType::model()->tableName() . " pt ON pt.id = pi.payment_type_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = pi.branch_id
                WHERE pi.payment_date = :payment_date " . $branchConditionSql . "
                GROUP BY pi.branch_id, pi.payment_type_id
                ORDER BY pi.branch_id, pi.payment_type_id";
        
        $paymentInRetailResultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        $paymentInWholesale = Search::bind(new PaymentIn(), isset($_GET['PaymentIn']) ? $_GET['PaymentIn'] : '');
        $paymentInWholesaleDataProvider = $paymentInWholesale->searchByDailyCashReport();
        $paymentInWholesaleDataProvider->criteria->together = 'true';
        $paymentInWholesaleDataProvider->criteria->with = array('invoice');
        $paymentInWholesaleDataProvider->criteria->addCondition("invoice.sales_order_id IS NOT NULL");
        $paymentInWholesaleDataProvider->criteria->compare('t.payment_date', $transactionDate);
        $paymentInWholesaleDataProvider->criteria->compare('t.branch_id', $branchId);

        $paymentOut = Search::bind(new PaymentOut(), isset($_GET['PaymentOut']) ? $_GET['PaymentOut'] : '');
        $paymentOutDataProvider = $paymentOut->searchByDailyCashReport();
        $paymentOutDataProvider->criteria->compare('t.payment_date', $transactionDate);
        $paymentOutDataProvider->criteria->compare('t.branch_id', $branchId);

        $cashTransaction = Search::bind(new CashTransaction(), isset($_GET['CashTransaction']) ? $_GET['CashTransaction'] : '');
        
        $cashTransactionInDataProvider = $cashTransaction->search();
        $cashTransactionInDataProvider->criteria->compare('t.transaction_date', $transactionDate);
        $cashTransactionInDataProvider->criteria->compare('t.branch_id', $branchId);
        $cashTransactionInDataProvider->criteria->addCondition('t.transaction_type = "In" AND t.status = "Approved" ');
        
        $cashTransactionOutDataProvider = $cashTransaction->search();
        $cashTransactionOutDataProvider->criteria->compare('t.transaction_date', $transactionDate);
        $cashTransactionOutDataProvider->criteria->compare('t.branch_id', $branchId);
        $cashTransactionOutDataProvider->criteria->addCondition('t.transaction_type = "Out" AND t.status = "Approved" ');
        
        $paymentTypeIdList = array();
        foreach ($paymentTypes as $paymentType) {
            $paymentTypeIdList[] = $paymentType->id;
        }
        
        $paymentInRetailList = array();
        $lastBranchId = '';
        foreach ($paymentInRetailResultSet as $paymentInRetailRow) {
            if ($lastBranchId !== $paymentInRetailRow['branch_id']) {
                $paymentInRetailList[$paymentInRetailRow['branch_id']][0] = $paymentInRetailRow['branch_name'];
                foreach ($paymentTypeIdList as $paymentTypeId) {
                    $paymentInRetailList[$paymentInRetailRow['branch_id']][$paymentTypeId] = '0.00';
                }
            }
            $paymentInRetailList[$paymentInRetailRow['branch_id']][$paymentInRetailRow['payment_type_id']] = $paymentInRetailRow['total_amount'];
            $lastBranchId = $paymentInRetailRow['branch_id'];
        }

        $existingDate = CashDailyApproval::model()->findByAttributes(array('transaction_date' => $transactionDate));
        if (isset($_GET['Approve']) && empty($existingDate)) {
            $cashDailyApproval = new CashDailyApproval;
            $cashDailyApproval->transaction_date = $transactionDate;
            $cashDailyApproval->amount = $totalDaily;
            $cashDailyApproval->user_id = Yii::app()->user->id;
            $cashDailyApproval->approval_date = date('Y-m-d');
            $cashDailyApproval->approval_time = date('H:i:s');

            if ($cashDailyApproval->save(Yii::app()->db)) {                
                $this->redirect(array('summary'));
            }
        }

        $this->render('summary', array(
            'paymentTypes' => $paymentTypes,
            'paymentInWholesale' => $paymentInWholesale,
            'paymentInWholesaleDataProvider' => $paymentInWholesaleDataProvider,
            'paymentOut' => $paymentOut,
            'paymentOutDataProvider' => $paymentOutDataProvider,
            'cashTransaction' => $cashTransaction,
            'cashTransactionInDataProvider' => $cashTransactionInDataProvider,
            'cashTransactionOutDataProvider' => $cashTransactionOutDataProvider,
            'branchId' => $branchId,
            'transactionDate' => $transactionDate,
            'paymentInRetailResultSet' => $paymentInRetailResultSet,
            'paymentInRetailList' => $paymentInRetailList,
            'existingDate' => $existingDate,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCreate($transactionDate, $branchId, $paymentTypeId) {
        
        $cashDaily = new CashDailySummary();
        $cashDaily->transaction_date = $transactionDate;
        $cashDaily->branch_id = $branchId;
        $cashDaily->payment_type_id = $paymentTypeId;
        $cashDaily->user_id = Yii::app()->user->id;

        $sql = "SELECT COALESCE(SUM(payment_amount), 0) as total_amount
                FROM " . PaymentIn::model()->tableName() . "
                WHERE payment_date = :payment_date AND branch_id = :branch_id AND payment_type_id = :payment_type_id";
        
        $paymentInRetailAmount = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':payment_date' => $transactionDate,
            ':branch_id' => $branchId,
            ':payment_type_id' => $paymentTypeId,
        ));
        
        $cashDaily->amount = $paymentInRetailAmount;
        
        $paymentIns = PaymentIn::model()->findAllByAttributes(array(
            'payment_date' => $transactionDate, 
            'branch_id' => $branchId, 
            'payment_type_id' => $paymentTypeId
        ));
        
        if (isset($_POST['CashDailySummary'])) {
            $cashDaily->attributes = $_POST['CashDailySummary'];
            $cashDaily->images = CUploadedFile::getInstances($cashDaily, 'images');
            
            if ($cashDaily->save(Yii::app()->db)) {
                foreach ($cashDaily->images as $file) {
                    $contentImage = new CashDailyImages;
                    $contentImage->cash_daily_summary_id = $cashDaily->id;
                    $contentImage->extension = $file->extensionName;
                    $contentImage->save(false);

                    $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashDaily/' . $contentImage->filename;
                    $file->saveAs($originalPath);
                }

                echo CHtml::script('window.opener.location.reload(false); window.close();');
                Yii::app()->end();
            } 
        }

        $this->render('create', array(
            'cashDaily' => $cashDaily,
            'paymentIns' => $paymentIns,
        ));
    }

    public function actionApproval($transactionDate, $branchId) {
        
        $cashDaily = new CashDailySummary();
        $cashDaily->transaction_date = $transactionDate;
        $cashDaily->branch_id = $branchId;
        $cashDaily->user_id = Yii::app()->user->id;

        $sql = "SELECT COALESCE(SUM(payment_amount), 0) as total_amount
                FROM " . PaymentIn::model()->tableName() . "
                WHERE payment_date = :payment_date AND branch_id = :branch_id";
        
        $paymentInRetailAmount = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':payment_date' => $transactionDate,
            ':branch_id' => $branchId,
        ));
        
        $cashDaily->amount = $paymentInRetailAmount;
        
        $paymentIns = PaymentIn::model()->findAllByAttributes(array(
            'payment_date' => $transactionDate, 
            'branch_id' => $branchId, 
        ));
        
        if (isset($_POST['CashDailySummary'])) {
            $cashDaily->attributes = $_POST['CashDailySummary'];
            $cashDaily->images = CUploadedFile::getInstances($cashDaily, 'images');
            
            if ($cashDaily->save(Yii::app()->db)) {
                foreach ($cashDaily->images as $file) {
                    $contentImage = new CashDailyImages;
                    $contentImage->cash_daily_summary_id = $cashDaily->id;
                    $contentImage->extension = $file->extensionName;
                    $contentImage->save(false);

                    $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashDaily/' . $contentImage->filename;
                    $file->saveAs($originalPath);
                }

                echo CHtml::script('window.opener.location.reload(false); window.close();');
                Yii::app()->end();
            } 
        }

        $this->render('approval', array(
            'cashDaily' => $cashDaily,
            'paymentIns' => $paymentIns,
        ));
    }

    public function actionView($id) {
        
        $model = CashDailySummary::model()->findByPk($id);
        
        $postImages = CashDailyImages::model()->findAllByAttributes(array(
            'cash_daily_summary_id' => $id,
            'is_inactive' => 0,
        ));
        
        $this->render('view', array(
            'model' => $model,
            'postImages' => $postImages,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
//    public function actionDelete($id) {
//        $this->loadModel($id)->delete();
//
//        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//    }

    public function actionAdmin() {
        $model = new CashDailyApproval();
        
        $monthNow = date('m');
        $yearNow = date('Y');
        
        $monthStart = isset($_GET['MonthStart']) ? $_GET['MonthStart'] : $monthNow;
        $monthEnd = isset($_GET['MonthEnd']) ? $_GET['MonthEnd'] : $monthNow;
        $yearStart = isset($_GET['YearStart']) ? $_GET['YearStart'] : $yearNow;
        $yearEnd = isset($_GET['YearEnd']) ? $_GET['YearEnd'] : $yearNow;
        
        $approvalList = $model->getApprovalList($monthStart, $yearStart, $monthEnd, $yearEnd);
        
        $approvalsRefs = array();
        foreach ($approvalList as $approval) {
            $approvalsRefs[$approval['transaction_date']] = array();
            $approvalsRefs[$approval['transaction_date']][0] = $approval['username'];
            $approvalsRefs[$approval['transaction_date']][1] = $approval['approval_date'];
            $approvalsRefs[$approval['transaction_date']][2] = $approval['amount'];
        }
        
        $monthYearLimit = $yearEnd * 12 + $monthEnd;
        
        $approvals = array();
        $index = 0;
        
        $currentMonth = $monthStart;
        $currentYear = $yearStart;
        while ($currentYear * 12 + $currentMonth <= $monthYearLimit) {
            $numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
            for ($d = 0; $d < $numberOfDaysInMonth; $d++) {
                $currentDate = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $d + 1);
                $approvals[$index] = array();
                $approvals[$index]['transaction_date'] = $currentDate;
                $approvals[$index]['transaction_day_of_week'] = date('l', strtotime($currentDate));
                $approvals[$index]['username'] = isset($approvalsRefs[$currentDate][0]) ? $approvalsRefs[$currentDate][0] : '';
                $approvals[$index]['approval_date'] = isset($approvalsRefs[$currentDate][1]) ? $approvalsRefs[$currentDate][1] : '';
                $approvals[$index]['amount'] = isset($approvalsRefs[$currentDate][2]) ? $approvalsRefs[$currentDate][2] : '0.00';
                $index++;
            }
            if ((int) $currentMonth < 12) {
                $currentMonth++;
            } else {
                $currentMonth = 1;
                $currentYear++;
            }
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $this->render('admin', array(
            'approvals' => $approvals,
            'monthStart' => $monthStart,
            'monthEnd' => $monthEnd,
            'yearStart' => $yearStart,
            'yearEnd' => $yearEnd,
            'yearList' => $yearList,
        ));
    }

    public function actionIndex() {
        $model = new CashDailySummary();
        
        $monthNow = date('m');
        $yearNow = date('Y');
        
        $monthStart = isset($_GET['MonthStart']) ? $_GET['MonthStart'] : $monthNow;
        $monthEnd = isset($_GET['MonthEnd']) ? $_GET['MonthEnd'] : $monthNow;
        $yearStart = isset($_GET['YearStart']) ? $_GET['YearStart'] : $yearNow;
        $yearEnd = isset($_GET['YearEnd']) ? $_GET['YearEnd'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        
        $approvalList = $model->getApprovalList($monthStart, $yearStart, $monthEnd, $yearEnd, $branchId);
        
        $approvalsRefs = array();
        foreach ($approvalList as $approval) {
            $approvalsRefs[$approval['transaction_date']] = array();
            $approvalsRefs[$approval['transaction_date']][0] = $approval['username'];
            $approvalsRefs[$approval['transaction_date']][1] = $approval['amount'];
            $approvalsRefs[$approval['transaction_date']][2] = $approval['branch_name'];
        }
        
        $monthYearLimit = $yearEnd * 12 + $monthEnd;
        
        $approvals = array();
        $index = 0;
        
        $currentMonth = $monthStart;
        $currentYear = $yearStart;
        while ($currentYear * 12 + $currentMonth <= $monthYearLimit) {
            $numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
            for ($d = 0; $d < $numberOfDaysInMonth; $d++) {
                $currentDate = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $d + 1);
                $approvals[$index] = array();
                $approvals[$index]['transaction_date'] = $currentDate;
                $approvals[$index]['transaction_day_of_week'] = date('l', strtotime($currentDate));
                $approvals[$index]['username'] = isset($approvalsRefs[$currentDate][0]) ? $approvalsRefs[$currentDate][0] : '';
                $approvals[$index]['amount'] = isset($approvalsRefs[$currentDate][1]) ? $approvalsRefs[$currentDate][1] : '0.00';
                $approvals[$index]['branch_name'] = isset($approvalsRefs[$currentDate][2]) ? $approvalsRefs[$currentDate][2] : '';
                $index++;
            }
            if ((int) $currentMonth < 12) {
                $currentMonth++;
            } else {
                $currentMonth = 1;
                $currentYear++;
            }
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $this->render('index', array(
            'approvals' => $approvals,
            'monthStart' => $monthStart,
            'monthEnd' => $monthEnd,
            'yearStart' => $yearStart,
            'yearEnd' => $yearEnd,
            'yearList' => $yearList,
            'branchId' => $branchId,
        ));
    }
    
    public function actionRedirectTransaction($codeNumber) {

        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/accounting/paymentOut/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
        }
        
    }
}
