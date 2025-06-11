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
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('cashDailyApprovalReport') || !(Yii::app()->user->checkAccess('cashDailySummaryReport')))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionSummary() {
        $userId = Yii::app()->user->id;
        $userBranch = UserBranch::model()->findAllByAttributes(array('users_id' => $userId));
        $transactionDate = isset($_GET['TransactionDate']) ? $_GET['TransactionDate'] : date('Y-m-d');
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $totalDaily = isset($_GET['TotalDaily']) ? $_GET['TotalDaily'] : 0.00;
        $paymentTypes = PaymentType::model()->findAll(); 
        
        $branchConditionSql = '';
        $params = array(
            ':payment_date' => $transactionDate,
        );
        if (!empty($userBranch)) {
            $branchConditionSql = " AND pi.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :user_id)";
            $params[':user_id'] = $userId;
        }
        
        $sql = "SELECT pi.branch_id, pi.payment_type_id, b.name as branch_name, pt.name as payment_type_name, COALESCE(SUM(pi.payment_amount), 0) as total_amount
                FROM " . PaymentIn::model()->tableName() . " pi
                INNER JOIN " . PaymentType::model()->tableName() . " pt ON pt.id = pi.payment_type_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = pi.branch_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = pi.customer_id
                WHERE pi.payment_date = :payment_date AND c.customer_type = 'Individual' AND pi.status IN ('CLEAR', 'Approved')" . $branchConditionSql . "
                GROUP BY pi.branch_id, pi.payment_type_id
                ORDER BY pi.branch_id, pi.payment_type_id";
        
        $paymentInRetailResultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        $paymentInWholesale = Search::bind(new PaymentIn(), isset($_GET['PaymentIn']) ? $_GET['PaymentIn'] : '');
        $paymentInWholesaleDataProvider = $paymentInWholesale->searchByDailyCashReport();
        $paymentInWholesaleDataProvider->criteria->compare('t.payment_date', $transactionDate);
        $paymentInWholesaleDataProvider->criteria->compare('t.branch_id', $branchId);

        $paymentOut = Search::bind(new PaymentOut(), isset($_GET['PaymentOut']) ? $_GET['PaymentOut'] : '');
        $paymentOutDataProvider = $paymentOut->searchByDailyCashReport();
        $paymentOutDataProvider->criteria->compare('t.payment_date', $transactionDate);
        $paymentOutDataProvider->criteria->compare('t.branch_id', $branchId);

        $cashTransaction = Search::bind(new CashTransaction(), isset($_GET['CashTransaction']) ? $_GET['CashTransaction'] : '');
        
        $cashTransactionInDataProvider = $cashTransaction->searchByDailyCashReport();
        $cashTransactionInDataProvider->criteria->compare('t.transaction_date', $transactionDate);
        $cashTransactionInDataProvider->criteria->addCondition('t.transaction_type = "In"');
        $cashTransactionInDataProvider->criteria->compare('t.branch_id', $branchId);
        
        $cashTransactionOutDataProvider = $cashTransaction->searchByDailyCashReport();
        $cashTransactionOutDataProvider->criteria->compare('t.transaction_date', $transactionDate);
        $cashTransactionOutDataProvider->criteria->addCondition('t.transaction_type = "Out"');
        $cashTransactionOutDataProvider->criteria->compare('t.branch_id', $branchId);
        
        $saleOrder = Search::bind(new TransactionSalesOrder('search'), isset($_GET['TransactionSalesOrder']) ? $_GET['TransactionSalesOrder'] : '');
        $saleOrderDataProvider = $saleOrder->searchByDailyCashReport();
        $saleOrderDataProvider->criteria->compare('t.sale_order_date', $transactionDate);
        $saleOrderDataProvider->criteria->compare('t.requester_branch_id', $branchId);
        
        $transactionJournal = Search::bind(new JurnalUmum('search'), isset($_GET['JurnalUmum']) ? $_GET['JurnalUmum'] : '');
        $transactionJournalDataProvider = $transactionJournal->searchByDailyCashReport();
        $transactionJournalDataProvider->criteria->compare('t.tanggal_transaksi', $transactionDate,true);
        $transactionJournalDataProvider->criteria->compare('t.branch_id', $branchId);
        
        $retailTransactionHead = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $retailTransactionHeadDataProvider = $retailTransactionHead->searchByDailyCashReport();
        $retailTransactionHeadDataProvider->criteria->compare('t.transaction_date', $transactionDate,true);
        $retailTransactionHeadDataProvider->criteria->compare('t.branch_id', 6);
        $retailTransactionHeadDataProvider->criteria->addCondition('customer.customer_type = "Individual"');
        
        $retailTransaction1 = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $retailTransaction1DataProvider = $retailTransaction1->searchByDailyCashReport();
        $retailTransaction1DataProvider->criteria->compare('t.transaction_date', $transactionDate,true);
        $retailTransaction1DataProvider->criteria->compare('t.branch_id', 1);
        $retailTransaction1DataProvider->criteria->addCondition('customer.customer_type = "Individual"');
        
        $retailTransaction2 = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $retailTransaction2DataProvider = $retailTransaction2->searchByDailyCashReport();
        $retailTransaction2DataProvider->criteria->compare('t.transaction_date', $transactionDate,true);
        $retailTransaction2DataProvider->criteria->compare('t.branch_id', 7);
        $retailTransaction2DataProvider->criteria->addCondition('customer.customer_type = "Individual"');
        
        $retailTransaction4 = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $retailTransaction4DataProvider = $retailTransaction4->searchByDailyCashReport();
        $retailTransaction4DataProvider->criteria->compare('t.transaction_date', $transactionDate,true);
        $retailTransaction4DataProvider->criteria->compare('t.branch_id', 2);
        $retailTransaction4DataProvider->criteria->addCondition('customer.customer_type = "Individual"');
        
        $retailTransaction5 = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $retailTransaction5DataProvider = $retailTransaction5->searchByDailyCashReport();
        $retailTransaction5DataProvider->criteria->compare('t.transaction_date', $transactionDate,true);
        $retailTransaction5DataProvider->criteria->compare('t.branch_id', 3);
        $retailTransaction5DataProvider->criteria->addCondition('customer.customer_type = "Individual"');
        
        $retailTransaction6 = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $retailTransaction6DataProvider = $retailTransaction6->searchByDailyCashReport();
        $retailTransaction6DataProvider->criteria->compare('t.transaction_date', $transactionDate,true);
        $retailTransaction6DataProvider->criteria->compare('t.branch_id', 4);
        $retailTransaction6DataProvider->criteria->addCondition('customer.customer_type = "Individual"');
        
        $retailTransaction8 = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $retailTransaction8DataProvider = $retailTransaction8->searchByDailyCashReport();
        $retailTransaction8DataProvider->criteria->compare('t.transaction_date', $transactionDate,true);
        $retailTransaction8DataProvider->criteria->compare('t.branch_id', 5);
        $retailTransaction8DataProvider->criteria->addCondition('customer.customer_type = "Individual"');
        
        $wholesaleTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $wholesaleTransactionDataProvider = $wholesaleTransaction->searchByDailyCashReport();
        $wholesaleTransactionDataProvider->criteria->compare('t.transaction_date', $transactionDate,true);
        $wholesaleTransactionDataProvider->criteria->compare('t.branch_id', $branchId);
        $wholesaleTransactionDataProvider->criteria->addCondition('customer.customer_type = "Company"');
        
        $purchaseOrder = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : '');
        $purchaseOrderDataProvider = $purchaseOrder->searchByDailyCashReport();
        $purchaseOrderDataProvider->criteria->compare('t.purchase_order_date', $transactionDate,true);
        $purchaseOrderDataProvider->criteria->compare('t.main_branch_id', $branchId);
        
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

        $registrationTransactionIndividualCashDailySummary = InvoiceHeader::getIndividualCashDailySummary($transactionDate);
        $registrationTransactionCompanyCashDailySummary = InvoiceHeader::getCompanyCashDailySummary($transactionDate);
        $saleOrderCashDailySummary = TransactionSalesOrder::getCashDailySummary($transactionDate);
        
        $branches = Branch::model()->findAll(array(
            'condition' => "t.id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :user_id)", 
            'params' => array(':user_id' => $userId),
            'order' => 't.name ASC',
        ));
        
        $cashDailySummary = array();
        foreach ($registrationTransactionIndividualCashDailySummary as $registrationTransactionIndividualCashDailyItem) {
            $cashDailySummary['retail'][$registrationTransactionIndividualCashDailyItem['branch_id']] = $registrationTransactionIndividualCashDailyItem['grand_total'];
        }
        foreach ($registrationTransactionCompanyCashDailySummary as $registrationTransactionCompanyCashDailyItem) {
            $cashDailySummary['wholesale'][$registrationTransactionCompanyCashDailyItem['branch_id']] = $registrationTransactionCompanyCashDailyItem['grand_total'];
        }
        foreach ($saleOrderCashDailySummary as $saleOrderCashDailyItem) {
            $cashDailySummary['saleorder'][$saleOrderCashDailyItem['branch_id']] = $saleOrderCashDailyItem['grand_total'];
        }
        
        $existingDate = CashDailyApproval::model()->findByAttributes(array('transaction_date' => $transactionDate));
        if (isset($_GET['Approve'])) {
            $branchId = $_GET['Approve'];
            $cashDailyApproval = new CashDailyApproval;
            $cashDailyApproval->transaction_date = $transactionDate;
            $cashDailyApproval->amount = $totalDaily;
            $cashDailyApproval->user_id = Yii::app()->user->id;
            $cashDailyApproval->approval_date = date('Y-m-d');
            $cashDailyApproval->approval_time = date('H:i:s');
            $cashDailyApproval->branch_id = $branchId;

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
            'saleOrder' => $saleOrder,
            'saleOrderDataProvider' => $saleOrderDataProvider,
            'retailTransactionHead' => $retailTransactionHead,
            'retailTransactionHeadDataProvider' => $retailTransactionHeadDataProvider,
            'retailTransaction1' => $retailTransaction1,
            'retailTransaction1DataProvider' => $retailTransaction1DataProvider,
            'retailTransaction2' => $retailTransaction2,
            'retailTransaction2DataProvider' => $retailTransaction2DataProvider,
            'retailTransaction4' => $retailTransaction4,
            'retailTransaction4DataProvider' => $retailTransaction4DataProvider,
            'retailTransaction5' => $retailTransaction5,
            'retailTransaction5DataProvider' => $retailTransaction5DataProvider,
            'retailTransaction6' => $retailTransaction6,
            'retailTransaction6DataProvider' => $retailTransaction6DataProvider,
            'retailTransaction8' => $retailTransaction8,
            'retailTransaction8DataProvider' => $retailTransaction8DataProvider,
            'wholesaleTransaction' => $wholesaleTransaction,
            'wholesaleTransactionDataProvider' => $wholesaleTransactionDataProvider,
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
            'transactionJournal' => $transactionJournal,
            'transactionJournalDataProvider' => $transactionJournalDataProvider,
            'cashDailySummary' => $cashDailySummary,
            'branches' => $branches,
        ));
    }
    
//    public function actionApprovalBranch($branchId, $transactionDate, $totalPerBranch) {
//        
//        $cashDailyApproval = new CashDailyApproval;
//        $cashDailyApproval->transaction_date = $transactionDate;
//        $cashDailyApproval->amount = $totalPerBranch;
//        $cashDailyApproval->user_id = Yii::app()->user->id;
//        $cashDailyApproval->approval_date = date('Y-m-d');
//        $cashDailyApproval->approval_time = date('H:i:s');
//        $cashDailyApproval->branch_id = $branchId;
//
//        if ($cashDailyApproval->save(Yii::app()->db)) {                
//            $this->redirect(array('summary'));
//        }
//    }

    protected function reportGrandTotalRetailTransaction($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->grand_total;
        }

        return $grandTotal;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
//    public function actionCreate($transactionDate) {
//        
//        $cashDaily = new CashDailySummary();
//        $cashDaily->transaction_date = $transactionDate;
////        $cashDaily->branch_id = $branchId;
////        $cashDaily->payment_type_id = $paymentTypeId;
//        $cashDaily->user_id = Yii::app()->user->id;
//
//        $sql = "SELECT COALESCE(SUM(p.payment_amount), 0) as total_amount
//                FROM " . PaymentIn::model()->tableName() . " p 
//                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = p.customer_id
//                WHERE p.payment_date = :payment_date AND c.customer_type = 'Individual'";
//        
//        $paymentInRetailAmount = Yii::app()->db->createCommand($sql)->queryScalar(array(
//            ':payment_date' => $transactionDate,
////            ':branch_id' => $branchId,
////            ':payment_type_id' => $paymentTypeId,
//        ));
//        
//        $cashDaily->amount = $paymentInRetailAmount;
//        
//        $model = new PaymentIn('search');
//        $model->unsetAttributes();  // clear any default values
//
//        $dataProvider = $model->searchByRetailCashDailyReport();
//        $dataProvider->criteria->with = array('customer');
//        $dataProvider->criteria->compare('customer.customer_type', 'Individual');   
//        $dataProvider->criteria->compare('t.payment_date', $transactionDate, true);
////        $dataProvider->criteria->compare('t.branch_id', $branchId);
////        $dataProvider->criteria->compare('t.payment_type_id', $paymentTypeId);
//            
//        if (isset($_POST['CashDailySummary'])) {
//            $cashDaily->attributes = $_POST['CashDailySummary'];
//            $cashDaily->images = CUploadedFile::getInstances($cashDaily, 'images');
//            
//            if ($cashDaily->save(Yii::app()->db)) {
//                foreach ($cashDaily->images as $file) {
//                    $contentImage = new CashDailyImages;
//                    $contentImage->cash_daily_summary_id = $cashDaily->id;
//                    $contentImage->extension = $file->extensionName;
//                    $contentImage->save(false);
//
//                    $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashDaily/' . $contentImage->filename;
//                    $file->saveAs($originalPath);
//                }
//
////                echo CHtml::script('window.opener.location.reload(false); window.close();');
////                Yii::app()->end();
//                $this->redirect(array('summary'));
//            } 
//        }
//
//        $this->render('create', array(
//            'cashDaily' => $cashDaily,
//            'dataProvider' => $dataProvider,
//        ));
//    }

    public function actionApproval($transactionDate, $branchId) {
        
        $cashDaily = new CashDailySummary();
        $cashDaily->transaction_date = $transactionDate;
        $cashDaily->branch_id = $branchId;
        $cashDaily->user_id = Yii::app()->user->id;
        $cashDaily->input_datetime = date('Y-m-d H:i:s');

        $sql = "SELECT COALESCE(SUM(payment_amount), 0) as total_amount
                FROM " . PaymentIn::model()->tableName() . " p
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = p.customer_id
                WHERE payment_date = :payment_date AND branch_id = :branch_id AND c.customer_type = 'Individual' AND p.status IN ('CLEAR', 'Approved')";
        
        $paymentInRetailAmount = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':payment_date' => $transactionDate,
            ':branch_id' => $branchId,
        ));
        
        $cashDaily->amount = $paymentInRetailAmount;
        
        $paymentIns = PaymentIn::model()->findAll(array(
            'condition' => "payment_date = :transaction_date AND branch_id = :branch_id AND status IN ('CLEAR', 'Approved')",
            'params' => array(
                ':transaction_date' => $transactionDate, 
                ':branch_id' => $branchId, 
            )
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

                $this->redirect(array('summary'));
            } 
        }
        
        $cashDailyApproval = CashDailySummary::model()->findByAttributes(array(
            'transaction_date' => $transactionDate, 
            'branch_id' => $branchId
        ));

        $this->render('approval', array(
            'cashDaily' => $cashDaily,
            'paymentIns' => $paymentIns,
            'cashDailyApproval' => $cashDailyApproval,
        ));
    }

    public function actionShowTransactionDetailByTypeBranchDate($transactionDate, $branchId, $paymentTypeId) {
        
        $cashDaily = new CashDailySummary();
        $cashDaily->transaction_date = $transactionDate;
        $cashDaily->branch_id = $branchId;
        $cashDaily->payment_type_id = $paymentTypeId;
        $cashDaily->user_id = Yii::app()->user->id;
        $cashDaily->input_datetime = date('Y-m-d H:i:s');

        $sql = "SELECT COALESCE(SUM(payment_amount), 0) as total_amount
                FROM " . PaymentIn::model()->tableName() . " p
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = p.customer_id
                WHERE payment_date = :payment_date AND branch_id = :branch_id AND payment_type_id = :payment_type_id AND c.customer_type = 'Individual'";
        
        $paymentInRetailAmount = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':payment_date' => $transactionDate,
            ':branch_id' => $branchId,
            ':payment_type_id' => $paymentTypeId,
        ));
        
        $cashDaily->amount = $paymentInRetailAmount;
        
        $model = new PaymentIn('search');
        $model->unsetAttributes();  // clear any default values

        $dataProvider = $model->searchByRetailCashDailyReport();
        $dataProvider->criteria->with = array('customer');
        $dataProvider->criteria->compare('customer.customer_type', 'Individual');   
        $dataProvider->criteria->compare('t.payment_date', $transactionDate, true);
        $dataProvider->criteria->compare('t.branch_id', $branchId);
        $dataProvider->criteria->compare('t.payment_type_id', $paymentTypeId);
            
        $this->render('show', array(
            'cashDaily' => $cashDaily,
            'dataProvider' => $dataProvider,
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

//    public function actionAdmin() {
//        $model = new CashDailyApproval();
//        
//        $monthNow = date('m');
//        $yearNow = date('Y');
//        
//        $monthStart = isset($_GET['MonthStart']) ? $_GET['MonthStart'] : $monthNow;
//        $monthEnd = isset($_GET['MonthEnd']) ? $_GET['MonthEnd'] : $monthNow;
//        $yearStart = isset($_GET['YearStart']) ? $_GET['YearStart'] : $yearNow;
//        $yearEnd = isset($_GET['YearEnd']) ? $_GET['YearEnd'] : $yearNow;
//        
//        $approvalList = $model->getApprovalList($monthStart, $yearStart, $monthEnd, $yearEnd);
//        
//        $approvalsRefs = array();
//        foreach ($approvalList as $approval) {
//            $approvalsRefs[$approval['transaction_date']] = array();
//            $approvalsRefs[$approval['transaction_date']][0] = $approval['username'];
//            $approvalsRefs[$approval['transaction_date']][1] = $approval['approval_date'];
//            $approvalsRefs[$approval['transaction_date']][2] = $approval['amount'];
//        }
//        
//        $monthYearLimit = $yearEnd * 12 + $monthEnd;
//        
//        $approvals = array();
//        $index = 0;
//        
//        $currentMonth = $monthStart;
//        $currentYear = $yearStart;
//        while ($currentYear * 12 + $currentMonth <= $monthYearLimit) {
//            $numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
//            for ($d = 0; $d < $numberOfDaysInMonth; $d++) {
//                $currentDate = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $d + 1);
//                $approvals[$index] = array();
//                $approvals[$index]['transaction_date'] = $currentDate;
//                $approvals[$index]['transaction_day_of_week'] = date('l', strtotime($currentDate));
//                $approvals[$index]['username'] = isset($approvalsRefs[$currentDate][0]) ? $approvalsRefs[$currentDate][0] : '';
//                $approvals[$index]['approval_date'] = isset($approvalsRefs[$currentDate][1]) ? $approvalsRefs[$currentDate][1] : '';
//                $approvals[$index]['amount'] = isset($approvalsRefs[$currentDate][2]) ? $approvalsRefs[$currentDate][2] : '0.00';
//                $index++;
//            }
//            if ((int) $currentMonth < 12) {
//                $currentMonth++;
//            } else {
//                $currentMonth = 1;
//                $currentYear++;
//            }
//        }
//        
//        $yearList = array();
//        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
//            $yearList[$y] = $y;
//        }
//        
//        $this->render('admin', array(
//            'approvals' => $approvals,
//            'monthStart' => $monthStart,
//            'monthEnd' => $monthEnd,
//            'yearStart' => $yearStart,
//            'yearEnd' => $yearEnd,
//            'yearList' => $yearList,
//        ));
//    }

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
            $approvalsRefs[$approval['transaction_date']][3] = $approval['input_datetime'];
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
                $approvals[$index]['input_datetime'] = isset($approvalsRefs[$currentDate][3]) ? $approvalsRefs[$currentDate][3] : '';
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

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RG') {
            $model = RegistrationTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            if ($model->repair_type == 'GR') {
                $this->redirect(array('/frontDesk/generalRepairRegistration/show', 'id' => $model->id));
            } else {
                $this->redirect(array('/frontDesk/bodyRepairRegistration/show', 'id' => $model->id));                
            }
        } else if ($codeNumberConstant === 'DO') {
            $model = TransactionDeliveryOrder::model()->findByAttributes(array('delivery_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionDeliveryOrder/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RCI') {
            $model = TransactionReceiveItem::model()->findByAttributes(array('receive_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReceiveItem/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CASH') {
            $model = CashTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/transaction/cashTransaction/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CSI') {
            $model = ConsignmentInHeader::model()->findByAttributes(array('consignment_in_number' => $codeNumber));
            $this->redirect(array('/transaction/consignmentInHeader/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CSO') {
            $model = ConsignmentOutHeader::model()->findByAttributes(array('consignment_out_no' => $codeNumber));
            $this->redirect(array('/transaction/consignmentOutHeader/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MO') {
            $model = MovementOutHeader::model()->findByAttributes(array('movement_out_no' => $codeNumber));
            $this->redirect(array('/transaction/movementOutHeader/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MI') {
            $model = MovementInHeader::model()->findByAttributes(array('movement_in_number' => $codeNumber));
            $this->redirect(array('/transaction/movementInHeader/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/accounting/paymentOut/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RTI') {
            $model = TransactionReturnItem::model()->findByAttributes(array('return_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReturnItem/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'TR') {
            $model = TransactionTransferRequest::model()->findByAttributes(array('transfer_request_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionTransferRequest/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'SR') {
            $model = TransactionSentRequest::model()->findByAttributes(array('sent_request_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionSentRequest/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'JAD') {
            $model = JournalAdjustmentHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/journalAdjustment/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'SA') {
            $model = StockAdjustmentHeader::model()->findByAttributes(array('stock_adjustment_number' => $codeNumber));
            $this->redirect(array('/frontDest/adjustment/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'DAS') {
            $model = AssetDepreciation::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/show', 'id' => $model->asset_purchase_id));
        } else if ($codeNumberConstant === 'SAS') {
            $model = AssetSale::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/show', 'id' => $model->asset_purchase_id));
        } else if ($codeNumberConstant === 'PAS') {
            $model = AssetPurchase::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/show', 'id' => $model->id));
        }
        
    }
}
