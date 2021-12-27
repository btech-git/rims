<?php

class FinancialForecastController extends Controller {

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

        $currentMonth = date('m');
        $currentYear = date('Y');
        
        $monthStart = isset($_GET['MonthStart']) ? $_GET['MonthStart'] : $currentMonth;
        $monthEnd = isset($_GET['MonthEnd']) ? $_GET['MonthEnd'] : $currentMonth;
        $yearStart = isset($_GET['YearStart']) ? $_GET['YearStart'] : $currentYear;
        $yearEnd = isset($_GET['YearEnd']) ? $_GET['YearEnd'] : $currentYear;
        
        $companyId = (isset($_GET['CompanyId'])) ? $_GET['CompanyId'] : '';
        $numberOfPeriod = (isset($_GET['NumberOfPeriod'])) ? $_GET['NumberOfPeriod'] : '1';
        
        $coas = Coa::model()->findAllByAttributes(array('coa_id' => '2'));

        $payableTransaction = Search::bind(new TransactionPurchaseOrder(), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : '');
        $payableTransactionDataProvider = $payableTransaction->search();
        $payableTransactionDataProvider->criteria->addCondition('t.payment_left > 0 AND t.status_document = "Approved"');
        
        $receivableTransaction = Search::bind(new InvoiceHeader(), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $receivableTransactionDataProvider = $receivableTransaction->search();
        $receivableTransactionDataProvider->criteria->addCondition('t.payment_left > 0 AND t.status <> "CANCELLED"');
        
//        $year = date('Y');
//        $month = date('m');
//        $numberOfDays = 0;
//        for ($i = 0; $i < (int) $numberOfPeriod; $i++) {
//            $month = $month === 1 ? 12 : $month - 1;
//            $year = $month === 12 ? $year - 1 : $year;
//            $numberOfDaysinMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//            $numberOfDays += $numberOfDaysinMonth;
//        }
//        $dateNow = date('Y-m-d');
//        $datePrevious = date('Y-m-d', strtotime($dateNow . ' -' . $numberOfDays . ' days'));
        
        $numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd);
        $datePrevious = $yearStart . '-' . $monthStart . '-01';
        $dateNow = $yearEnd . '-' . $monthEnd . '-' . str_pad($numberOfDaysInMonth, 2, '0', STR_PAD_LEFT);
        $yearList = array();
        for ($y = $currentYear - 4; $y <= $currentYear; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_POST['Approve'])) {
            $coaId = $_POST['ForecastApprovalCoaId'];
            $transactionDate = $_POST['ForecastApprovalTransactionDate'];
            $debitReceivableAmount = $_POST['ForecastApprovalDebitReceivableAmount'];
            $debitJournalAmount = $_POST['ForecastApprovalDebitJournalAmount'];
            $creditPayableAmount = $_POST['ForecastApprovalCreditPayableAmount'];
            $creditJournalAmount = $_POST['ForecastApprovalCreditJournalAmount'];
            $saldo = $_POST['ForecastApprovalSaldo'];
                    
            $financialForecastApproval = new FinancialForecastApproval();
            $financialForecastApproval->date_transaction = $transactionDate;
            $financialForecastApproval->debit_receivable = $debitReceivableAmount;
            $financialForecastApproval->debit_journal = $debitJournalAmount;
            $financialForecastApproval->credit_payable = $creditPayableAmount;
            $financialForecastApproval->credit_journal = $creditJournalAmount;
            $financialForecastApproval->total_amount = $saldo;
            $financialForecastApproval->coa_id = $coaId;
            $financialForecastApproval->date_approval = date('Y-m-d');
            $financialForecastApproval->time_approval = date('H:i:s');
            $financialForecastApproval->user_id_approval = Yii::app()->user->id;
            $financialForecastApproval->image_filetype = pathinfo($_FILES['ForecastApprovalUploadImage']['name'], PATHINFO_EXTENSION);
            if ($financialForecastApproval->save()) {
                move_uploaded_file($_FILES['ForecastApprovalUploadImage']['tmp_name'], Yii::app()->basePath . '/../images/' . $financialForecastApproval->id . '.' . $financialForecastApproval->image_filetype);
            }
        }
        
        $this->render('summary', array(
            'coas' => $coas,
            'companyId' => $companyId,
            'dateNow' => $dateNow,
            'datePrevious' => $datePrevious,
            'numberOfPeriod' => $numberOfPeriod,
            'payableTransaction' => $payableTransaction,
            'payableTransactionDataProvider' => $payableTransactionDataProvider,
            'receivableTransaction' => $receivableTransaction,
            'receivableTransactionDataProvider' => $receivableTransactionDataProvider,
            'monthStart' => $monthStart,
            'monthEnd' => $monthEnd,
            'yearStart' => $yearStart,
            'yearEnd' => $yearEnd,
            'yearList' => $yearList,
        ));
    }

    public function actionTransaction($transactionDate, $coaId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $coa = Coa::model()->findByPk($coaId);

        $this->render('transaction', array(
            'transactionDate' => $transactionDate,
            'coa' => $coa,
        ));
    }

//    public function actionApproval($transactionDate, $coaId) {
//        set_time_limit(0);
//        ini_set('memory_limit', '1024M');
//
//        $coa = Coa::model()->findByPk($coaId);
//
//        $this->render('approval', array(
//            'transactionDate' => $transactionDate,
//            'coa' => $coa,
//        ));
//    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/updateEstimateDate', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/updateEstimateDate', 'id' => $model->id));
        }
    }

    public function actionAjaxHtmlUpdateCompanyBankSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $companyId = isset($_GET['CompanyId']) ? $_GET['CompanyId'] : 0;
            $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';

            $this->renderPartial('_companyBankSelect', array(
                'companyId' => $companyId,
                'coaId' => $coaId,
            ), false, true);
        }
    }

    public function actionAjaxJsonForecastDataView($coaId, $transactionDate) {
        if (Yii::app()->request->isAjaxRequest) {
            $forecastApproval = FinancialForecastApproval::model()->findByAttributes(array('coa_id' => $coaId, 'date_transaction' => $transactionDate));

            $debitReceivable = Yii::app()->numberFormatter->format('#,##0', $forecastApproval->debit_receivable);
            $debitJournal = Yii::app()->numberFormatter->format('#,##0', $forecastApproval->debit_journal);
            $creditPayable = Yii::app()->numberFormatter->format('#,##0', $forecastApproval->credit_payable);
            $creditJournal = Yii::app()->numberFormatter->format('#,##0', $forecastApproval->credit_journal);
            $totalAmount = Yii::app()->numberFormatter->format('#,##0', $forecastApproval->total_amount);
            $dateTransaction = Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($forecastApproval->date_transaction));
            $imageFiletype = $forecastApproval->image_filetype;
            $forecastApprovalId = $forecastApproval->id;
            
            echo CJSON::encode(array(
                'debitReceivable' => $debitReceivable,
                'debitJournal' => $debitJournal,
                'creditPayable' => $creditPayable,
                'creditJournal' => $creditJournal,
                'totalAmount' => $totalAmount,
                'dateTransaction' => $dateTransaction,
                'imageFiletype' => $imageFiletype,
                'forecastApprovalId' => $forecastApprovalId,
            ));
        }
    }

//    protected function saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId) {
//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
//        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
//        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);
//
//        spl_autoload_unregister(array('YiiBase', 'autoload'));
//        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
//        spl_autoload_register(array('YiiBase', 'autoload'));
//
//        $objPHPExcel = new PHPExcel();
//
//        $documentProperties = $objPHPExcel->getProperties();
//        $documentProperties->setCreator('Lanusa');
//        $documentProperties->setTitle('Laporan Balance Sheet');
//
//        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
//        $worksheet->setTitle('Laporan Balance Sheet');
//
//        $worksheet->mergeCells('A1:B1');
//        $worksheet->mergeCells('A2:B2');
//        $worksheet->mergeCells('A3:B3');
//        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);
//
//        $branch = Branch::model()->findByPk($branchId);
//        $worksheet->setCellValue('A1', CHtml::encode(($branch === null) ? '' : $branch->name));
//        $worksheet->setCellValue('A2', 'Laporan Balance Sheet');
//        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);
//
//
//        $counter = 6;
//
//
//        foreach ($accountCategoryTypes as $accountCategoryType) {
//            $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
//            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryType, 'name')));
//
//            $counter++;
//
//            foreach ($accountCategoryType->accountCategories as $accountCategory) {
//                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
//                $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategory->getBalanceTotal($startDate, $endDate, $branchId)));
//                $counter++;
//            }
//
//            $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//            $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//            $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryType, 'name')));
//            $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryType->getBalanceTotal($startDate, $endDate, $branchId)));
//
//            $counter++;
//            $counter++;
//        }
//
//
//
//        for ($col = 'A'; $col !== 'H'; $col++) {
//            $objPHPExcel->getActiveSheet()
//                    ->getColumnDimension($col)
//                    ->setAutoSize(true);
//        }
//
//        header('Content-Type: application/xlsx');
//        header('Content-Disposition: attachment;filename="Laporan Balance Sheet.xlsx"');
//        header('Cache-Control: max-age=0');
//
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//        $objWriter->save('php://output');
//
//        Yii::app()->end();
//    }
}