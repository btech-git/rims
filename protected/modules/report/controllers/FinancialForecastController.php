<?php

class FinancialForecastController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('financialForecastReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $companyId = (isset($_GET['CompanyId'])) ? $_GET['CompanyId'] : '';
        $numberOfPeriod = (isset($_GET['NumberOfPeriod'])) ? $_GET['NumberOfPeriod'] : '1';
        
        $companyBanks = CompanyBank::model()->findAllByAttributes(array('company_id' => '2'));

        $year = date('Y');
        $month = date('m');
        $numberOfDays = 0;
        for ($i = 0; $i < (int) $numberOfPeriod; $i++) {
//            $month = $month === 1 ? 12 : $month - 1;
            $year = $month === 12 ? $year - 1 : $year;
            $numberOfDaysinMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $numberOfDays += $numberOfDaysinMonth;
        }
        $dateNow = date('Y-m-d');
        $dateNext = date('Y-m-d', strtotime($dateNow . ' +' . $numberOfDays . ' days'));
        $datePrevious = date('Y-m-d', strtotime($dateNow . ' -' . $numberOfDays . ' days'));
        
        if (isset($_POST['Approve'])) {
            list($coaId, $transactionDate, $debitReceivableAmount, $debitJournalAmount, $creditPayableAmount, $creditJournalAmount, $saldo) = explode('|', $_POST['Approve']);
        
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
            $valid = $financialForecastApproval->save();
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($companyBanks, $dateNow, $dateNext, $datePrevious);
        }

        $this->render('summary', array(
            'companyBanks' => $companyBanks,
            'companyId' => $companyId,
            'dateNow' => $dateNow,
            'dateNext' => $dateNext,
            'datePrevious' => $datePrevious,
            'numberOfPeriod' => $numberOfPeriod,
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

    public function actionReceivablePayable() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $payableTransaction = Search::bind(new TransactionReceiveItem(), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : '');
        $payableTransactionDataProvider = $payableTransaction->search();
        $payableTransactionDataProvider->criteria->addCondition('purchaseOrder.payment_left > 0 AND purchaseOrder.status_document = "Approved"');
        
        $receivableTransaction = Search::bind(new InvoiceHeader(), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $receivableTransactionDataProvider = $receivableTransaction->search();
        $receivableTransactionDataProvider->criteria->addCondition('t.payment_left > 0 AND t.status <> "CANCELLED"');
        
        $this->render('receivablePayable', array(
            'payableTransaction' => $payableTransaction,
            'payableTransactionDataProvider' => $payableTransactionDataProvider,
            'receivableTransaction' => $receivableTransaction,
            'receivableTransactionDataProvider' => $receivableTransactionDataProvider,
        ));
    }

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

    protected function saveToExcel($companyBanks, $dateNow, $dateNext, $datePrevious) {
        $coas = array();
        foreach ($companyBanks as $companyBank) {
            $coas[] = Coa::model()->findByPk($companyBank->coa_id);
        }
        $coaIds = array();
        foreach ($coas as $coa) {
            $coaIds[] = $coa->id;
        }
        $forecastApprovalCriteria = new CDbCriteria();
        $forecastApprovalCriteria->addBetweenCondition('date_transaction', $datePrevious, $dateNext);
        $forecastApprovalCriteria->addInCondition('coa_id', $coaIds);
        $forecastApprovalList = FinancialForecastApproval::model()->findAll($forecastApprovalCriteria);
        $forecastApprovalReference = array();
        foreach ($forecastApprovalList as $forecastApprovalItem) {
            $forecastApprovalReference[$forecastApprovalItem->coa_id][$forecastApprovalItem->date_transaction] = true;
        }

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Summary Kas Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Summary Kas Harian');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Summary Kas Harian');
        $worksheet->setCellValue('A3', CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($dateNow))));

        $counter = 5;

        foreach ($coas as $coa) {
            $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("A{$counter}", 'Bank');
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($coa, 'code')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($coa, 'name')));
            $saldo = $coa->getBalanceTotal($datePrevious, $dateNext, null);
            $worksheet->setCellValue("D{$counter}", CHtml::encode($saldo));

            $counter++;

            $worksheet->setCellValue("A{$counter}", 'Tanggal');
            $worksheet->setCellValue("B{$counter}", 'Debit Rcvb');
            $worksheet->setCellValue("C{$counter}", 'Debit All');
            $worksheet->setCellValue("D{$counter}", 'Kredit Pay');
            $worksheet->setCellValue("E{$counter}", 'Kredit All');
            $worksheet->setCellValue("F{$counter}", 'Saldo');
            
            $counter++;

            $forecastData = $coa->getFinancialForecastReport($datePrevious, $dateNext);
            foreach ($forecastData as $forecastRow) {
                $debitReceivableAmount = $forecastRow['total_receivable_debit'];
                $debitJournalAmount = $forecastRow['total_journal_debit'];
                $creditPayableAmount = $forecastRow['total_payable_credit'];
                $creditJournalAmount = $forecastRow['total_journal_credit'];
                $saldo += $debitReceivableAmount + $debitJournalAmount - $creditPayableAmount - $creditJournalAmount;
                
                $worksheet->setCellValue("A{$counter}", CHtml::encode($forecastRow['transaction_date']));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($debitReceivableAmount));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($debitJournalAmount));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($creditPayableAmount));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($creditJournalAmount));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($saldo));
                $counter++;
            }
        }



        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="summary_kas_harian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}