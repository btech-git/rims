<?php

class TransactionJournalController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('transactionJournalReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $pageSize = 500;
        
        $transactionJournalReport = JurnalUmum::getTransactionJournalReport($startDate, $endDate, $transactionType, $branchId, $coaId, $currentPage, $pageSize);
        $transactionJournalCount = JurnalUmum::getTransactionJournalCount($startDate, $endDate, $transactionType, $branchId, $coaId);
        
        $transactionJournalReportTransactionCodes = array_map(function($transactionJournalReportItem) { return $transactionJournalReportItem['kode_transaksi']; }, $transactionJournalReport);
        $transactionJournalItems = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $transactionJournalReportTransactionCodes, 'is_coa_category' => 0));
        $transactionJournalReportData = array();
        foreach ($transactionJournalItems as $transactionJournalItem) {
            if (!isset($transactionJournalReportData[$transactionJournalItem->kode_transaksi])) {
                $transactionJournalReportData[$transactionJournalItem->kode_transaksi] = array();
            }
            $transactionJournalReportData[$transactionJournalItem->kode_transaksi][] = $transactionJournalItem;
        }
        
        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $accountDataProvider = $account->search();
        $accountDataProvider->criteria->compare('t.is_approved', 1);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalReport, $transactionJournalReportData, array(
                'transactionJournalCount' => $transactionJournalCount,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'transactionType' => $transactionType,
                'branchId' => $branchId,
                'coaId' => $coaId,
                'account' => $account,
                'accountDataProvider' => $accountDataProvider,
                'currentPage' => $currentPage,
                'pageSize' => $pageSize,
            ));
        }
        
        $this->render('summary', array(
            'transactionJournalReport' => $transactionJournalReport,
            'transactionJournalReportData' => $transactionJournalReportData,
            'transactionJournalCount' => $transactionJournalCount,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionType' => $transactionType,
            'branchId' => $branchId,
            'coaId' => $coaId,
            'account' => $account,
            'accountDataProvider' => $accountDataProvider,
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
        ));
    }

    public function actionBalanceErrorSummary() {
        
        $balanceErrorReport = JurnalUmum::getBalanceErrorReport();
        
        $this->render('balanceErrorSummary', array(
            'balanceErrorReport' => $balanceErrorReport,
        ));
    }
    
    public function actionAjaxJsonCoa() {
        if (Yii::app()->request->isAjaxRequest) {
            $coaId = (isset($_POST['JurnalUmum']['coa_id'])) ? $_POST['JurnalUmum']['coa_id'] : '';
            $coa = Coa::model()->findByPk($coaId);

            $object = array(
                'coa_name' => CHtml::value($coa, 'combinationName'),
                'coa_code' => CHtml::value($coa, 'code'),
            );
            
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlUpdateSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $categoryId = isset($_GET['Coa']['coa_category_id']) ? $_GET['Coa']['coa_category_id'] : 0;

            $this->renderPartial('_subCategorySelect', array(
                'categoryId' => $categoryId,
            ), false, true);
        }
    }

    public function actionAjaxHtmlUpdateBranchSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $companyId = isset($_GET['CompanyId']) ? $_GET['CompanyId'] : 0;
            $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : 0;

            $this->renderPartial('_branchSelect', array(
                'companyId' => $companyId,
                'branchId' => $branchId,
            ));
        }
    }

    protected function saveToExcel($transactionJournalReport, $transactionJournalReportData, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Jurnal Umum');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Jurnal Umum');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');

        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Jurnal Umum');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Kode Transaksi');
        $worksheet->setCellValue('D5', 'Keterangan');
        $worksheet->setCellValue('E5', 'Kode COA');
        $worksheet->setCellValue('F5', 'Nama COA');
        $worksheet->setCellValue('G5', 'Debit');
        $worksheet->setCellValue('H5', 'Kredit');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7; 
        
        foreach ($transactionJournalReport as $i => $header) {
            $totalDebit = 0; 
            $totalCredit = 0; 
            foreach ($transactionJournalReportData[$header['kode_transaksi']] as $transactionJournalItemData) {
                $debitAmount = $transactionJournalItemData->debet_kredit == 'D' ? $transactionJournalItemData->total : 0;
                $creditAmount = $transactionJournalItemData->debet_kredit == 'K' ? $transactionJournalItemData->total : 0;
                
                $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header['transaction_date']));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($header['kode_transaksi']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($header['transaction_subject']));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($transactionJournalItemData, 'coa.code')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($transactionJournalItemData, 'coa.name')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($debitAmount));
                $worksheet->setCellValue("H{$counter}", CHtml::encode($creditAmount));
                
                $totalDebit += $debitAmount;
                $totalCredit += $creditAmount;
                
                $counter++;
            }
            $worksheet->mergeCells("A{$counter}:F{$counter}");
            $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("A{$counter}", 'TOTAL');
            $worksheet->setCellValue("G{$counter}", $totalDebit);
            $worksheet->setCellValue("H{$counter}", $totalCredit);
            $counter++;$counter++;

        }

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="jurnal_umum.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
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
            $this->redirect(array('/transaction/transferRequest/show', 'id' => $model->id));
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
            $model = AssetDepreciationHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/viewDepreciation', 'id' => $model->id));
        } else if ($codeNumberConstant === 'SAS') {
            $model = AssetSale::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/viewSale', 'id' => $model->id));
        } else if ($codeNumberConstant === 'PAS') {
            $model = AssetPurchase::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'WOE') {
            $model = WorkOrderExpenseHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/workOrderExpense/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RTO') {
            $model = TransactionReturnOrder::model()->findByAttributes(array('return_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReturnOrder/show', 'id' => $model->id));
        }
    }
}
