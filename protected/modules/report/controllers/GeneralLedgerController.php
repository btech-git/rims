<?php

class GeneralLedgerController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('generalLedgerReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
//        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $accountIds = (isset($_GET['AccountIds'])) ? $_GET['AccountIds'] : '';
        
        $accountIdList = $accountIds === '' ? array() : explode(',', $accountIds);

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $accountDataProvider = $account->search();
        $accountDataProvider->criteria->compare('t.is_approved', 1);
        $accountDataProvider->pagination->pageVar = 'page_dialog';

        $generalLedgerSummary = new GeneralLedgerSummary($account->search());
        $generalLedgerSummary->setupLoading();
        $generalLedgerSummary->setupPaging($pageSize, $currentPage);
        $generalLedgerSummary->setupSorting();
        $generalLedgerSummary->setupFilter($accountIdList, $startDate, $endDate, $branchId);
        
        $coaIds = array_map(function($coa) { return $coa->id; }, $generalLedgerSummary->dataProvider->data);
        
        $ledgerBeginningBalances = JurnalUmum::getLedgerBeginningBalances($coaIds, $startDate, $branchId);
        $ledgerBeginningBalanceData = array();
        foreach ($ledgerBeginningBalances as $ledgerBeginningBalance) {
            $ledgerBeginningBalanceData[$ledgerBeginningBalance['coa_id']] = $ledgerBeginningBalance['beginning_balance'];
        }
        
        $generalLedgerReport = JurnalUmum::getGeneralLedgerReport($coaIds, $startDate, $endDate, $branchId);
        $generalLedgerReportData = array();
        foreach ($generalLedgerReport as $generalLedgerReportItem) {
            $generalLedgerReportData[$generalLedgerReportItem['coa_id']][] = $generalLedgerReportItem;
        }

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($generalLedgerSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
                'branchId' => $branchId,
            ));
        }
        
        $this->render('summary', array(
            'account' => $account,
            'generalLedgerSummary' => $generalLedgerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'accountIds' => $accountIds,
            'branchId' => $branchId,
            'accountDataProvider' => $accountDataProvider,
            'currentSort' => $currentSort,
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
            'ledgerBeginningBalanceData' => $ledgerBeginningBalanceData,
            'generalLedgerReportData' => $generalLedgerReportData,
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->amountPaid;
        }

        return $grandTotal;
    }

    public function actionAjaxJsonCoa() {
        if (Yii::app()->request->isAjaxRequest) {
            $coaId = (isset($_POST['Coa']['id'])) ? $_POST['Coa']['id'] : '';
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

//    public function actionAjaxHtmlUpdateCoaSubCategorySelect() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $coaCategoryId = isset($_GET['Coa']['coa_category_id']) ? $_GET['Coa']['coa_category_id'] : 0;
//
//            $this->renderPartial('_coaSubCategorySelect', array(
//                'coaCategoryId' => $coaCategoryId,
//            ));
//        }
//    }

//    public function actionAjaxHtmlAccount() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $startAccount = (isset($_GET['StartAccount'])) ? $_GET['StartAccount'] : '';
//            $endAccount = (isset($_GET['EndAccount'])) ? $_GET['EndAccount'] : '';
//
//            $accounts = Account::model()->findAllByAttributes(array(
//                'branch_id' => $_POST['BranchId'],
//            ), array(
//                'order' => 'code ASC',
//            ));
//
//            $account = Search::bind(new Account('search'), isset($_GET['Account']) ? $_GET['Account'] : array());
//
//            $this->renderPartial('_account', array(
//                'account' => $account,
//                'accounts' => $accounts,
//                'startAccount' => $startAccount,
//                'endAccount' => $endAccount,
//            ));
//        }
//    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];
        $branchId = (empty($options['branchId'])) ? '' : $options['branchId'];
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Laporan Buku Besar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Buku Besar');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G6')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Laporan Buku Besar');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'COA Code');
        $worksheet->setCellValue('B5', 'COA Name');
        $worksheet->mergeCells('B5:D5');
        $worksheet->setCellValue('E5', 'Total Debit');
        $worksheet->setCellValue('F5', 'Total Kredit');
        $worksheet->setCellValue('G5', 'Saldo Akhir');

        $worksheet->setCellValue('A6', 'Transaksi');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Description');
        $worksheet->setCellValue('D6', 'Memo');
        $worksheet->setCellValue('E6', 'Debit');
        $worksheet->setCellValue('F6', 'Kredit');
        $worksheet->setCellValue('G6', 'Saldo');

        $worksheet->getStyle('A6:G6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;

        foreach ($dataProvider->data as $header) {
            $beginningBalance = $header->getBeginningBalanceLedger($startDate);
            $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'code')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->mergeCells("B{$counter}:D{$counter}");
            $counter++;$counter++;

            $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->mergeCells("A{$counter}:F{$counter}");
            $worksheet->setCellValue("A{$counter}", 'SALDO AWAL');
            $worksheet->setCellValue("G{$counter}", CHtml::encode($beginningBalance));
            $counter++;$counter++;

            $generalLedgerData = $header->getGeneralLedgerReport($startDate, $endDate, $branchId);
            $totalDebit = 0; 
            $totalCredit = 0;
            $accountBalance = $beginningBalance;
            foreach ($generalLedgerData as $generalLedgerRow) {
                $worksheet->getStyle("A{$counter}:D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $debitAmount = $generalLedgerRow['debet_kredit'] == 'D' ? $generalLedgerRow['total'] : 0;
                $creditAmount = $generalLedgerRow['debet_kredit'] == 'K' ? $generalLedgerRow['total'] : 0;
                $accountBalance += $debitAmount - $creditAmount;
                $worksheet->setCellValue("A{$counter}", CHtml::encode($generalLedgerRow['kode_transaksi']));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($generalLedgerRow['tanggal_transaksi']))));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($generalLedgerRow['transaction_subject']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($generalLedgerRow['transaction_type']));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($debitAmount));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($creditAmount));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($accountBalance));

                $totalDebit += $debitAmount;
                $totalCredit += $creditAmount;
                $counter++;
            }
                                
            $worksheet->getStyle("D{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("D{$counter}:F{$counter}")->getFont()->setBold(true);
            
            $worksheet->setCellValue("D{$counter}", 'TOTAL');
            $worksheet->setCellValue("E{$counter}", CHtml::encode($totalDebit));
            $worksheet->setCellValue("F{$counter}", CHtml::encode($totalCredit));
            $counter++;
            $counter++;
        }

        for ($col = 'A'; $col !== 'P'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Buku Besar.xls"');
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
        } else if ($codeNumberConstant === 'WOE') {
            $model = WorkOrderExpenseHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/workOrderExpense/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/show', 'id' => $model->id));
        }
    }
}