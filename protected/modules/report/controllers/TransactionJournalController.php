<?php

class TransactionJournalController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('accountingReport')) || !(Yii::app()->user->checkAccess('financeReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $jurnalUmum = Search::bind(new JurnalUmum('search'), isset($_GET['JurnalUmum']) ? $_GET['JurnalUmum'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $companyId = (isset($_GET['CompanyId'])) ? $_GET['CompanyId'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
//        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : '';
//        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 50000;
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $jurnalUmumSummary = new TransactionJournalSummary($jurnalUmum->search());
        $jurnalUmumSummary->setupLoading();
        $jurnalUmumSummary->setupPaging($pageSize, $currentPage);
        $jurnalUmumSummary->setupSorting();
        $jurnalUmumSummary->setupFilter($startDate, $endDate, $branchId, $companyId);

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $accountDataProvider = $account->search();
        $accountDataProvider->criteria->compare('t.is_approved', 1);

        if (isset($_GET['SaveExcel'])) {
          $this->saveToExcel($jurnalUmumSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }
        
        $this->render('summary', array(
            'jurnalUmum' => $jurnalUmum,
            'jurnalUmumSummary' => $jurnalUmumSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'companyId' => $companyId,
            'branchId' => $branchId,
            'account' => $account,
            'accountDataProvider' => $accountDataProvider,
            'currentSort' => $currentSort,
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

    protected function saveToExcel($dataProvider, array $options = array()) {
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Laporan Jurnal Umum');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Jurnal Umum');

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');

        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'PT. Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Jurnal Umum');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Kode Transaksi');
        $worksheet->setCellValue('D5', 'Kode COA');
        $worksheet->setCellValue('E5', 'Nama COA');
        $worksheet->setCellValue('F5', 'Debit');
        $worksheet->setCellValue('G5', 'Kredit');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7; 
        $lastId = ''; 
        $totalDebit = 0; 
        $totalCredit = 0; 
        $index = 0; 
        $journalRefs = array();
        
        foreach ($dataProvider->data as $header) {
            if ($lastId !== $header->kode_transaksi) {
                if ($index > 0) {
                    foreach ($journalRefs as $journalRef) {
                        
                        $worksheet->mergeCells("A{$counter}:B{$counter}");
                        $worksheet->mergeCells("C{$counter}:E{$counter}");
                        $worksheet->setCellValue("A{$counter}", CHtml::encode($journalRef['code']));
                        $worksheet->setCellValue("C{$counter}", $journalRef['name']);
                        $worksheet->setCellValue("F{$counter}", CHtml::encode($journalRef['debit']));
                        $worksheet->setCellValue("G{$counter}", CHtml::encode($journalRef['credit']));
                        $counter++;
                    }

                    $worksheet->mergeCells("A{$counter}:E{$counter}");
                    $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
                    $worksheet->setCellValue("A{$counter}", 'TOTAL');
                    $worksheet->setCellValue("F{$counter}", $totalDebit);
                    $worksheet->setCellValue("G{$counter}", $totalCredit);
                    $counter++;$counter++;
                }
                
                $journalRefs = array(); $totalDebit = 0; $totalCredit = 0;
                $worksheet->mergeCells("D{$counter}:G{$counter}");
                $worksheet->setCellValue("A{$counter}", CHtml::encode(++$index));
                $worksheet->setCellValue("B{$counter}", $header->tanggal_transaksi);
                $worksheet->setCellValue("C{$counter}", $header->kode_transaksi);
                $worksheet->setCellValue("D{$counter}", $header->transaction_subject);

                $counter++;
            }

            $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0;
            $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0;
            
            if (!isset($journalRefs[$header->branchAccountId])) {
                $journalRefs[$header->branchAccountId] = array('debit' => 0, 'credit' => 0);
            }
            
            $journalRefs[$header->branchAccountId]['code'] = $header->branchAccountCode;
            $journalRefs[$header->branchAccountId]['name'] = htmlspecialchars_decode($header->branchAccountName);
            $journalRefs[$header->branchAccountId]['debit'] += $amountDebit;
            $journalRefs[$header->branchAccountId]['credit'] += $amountCredit;
            
            $totalDebit += $amountDebit;
            $totalCredit += $amountCredit;
            $lastId = $header->kode_transaksi;
        }
        
        foreach ($journalRefs as $journalRef) {
            
            $worksheet->mergeCells("A{$counter}:B{$counter}");
            $worksheet->mergeCells("C{$counter}:E{$counter}");
            $worksheet->setCellValue("A{$counter}", CHtml::encode($journalRef['code']));
            $worksheet->setCellValue("C{$counter}", $journalRef['name']);
            $worksheet->setCellValue("F{$counter}", CHtml::encode($journalRef['debit']));
            $worksheet->setCellValue("G{$counter}", CHtml::encode($journalRef['credit']));
            $counter++;
        }

        $worksheet->mergeCells("A{$counter}:E{$counter}");
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("F{$counter}", $totalDebit);
        $worksheet->setCellValue("G{$counter}", $totalCredit);
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'G'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Jurnal Umum.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RG') {
            $model = RegistrationTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            if ($model->repair_type == 'GR') {
                $this->redirect(array('/frontDesk/generalRepairRegistration/view', 'id' => $model->id));
            } else {
                $this->redirect(array('/frontDesk/bodyRepairRegistration/view', 'id' => $model->id));                
            }
        } else if ($codeNumberConstant === 'DO') {
            $model = TransactionDeliveryOrder::model()->findByAttributes(array('delivery_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionDeliveryOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RCI') {
            $model = TransactionReceiveItem::model()->findByAttributes(array('receive_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReceiveItem/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CASH') {
            $model = CashTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/transaction/cashTransaction/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CSI') {
            $model = ConsignmentInHeader::model()->findByAttributes(array('consignment_in_number' => $codeNumber));
            $this->redirect(array('/transaction/consignmentInHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CSO') {
            $model = ConsignmentOutHeader::model()->findByAttributes(array('consignment_out_no' => $codeNumber));
            $this->redirect(array('/transaction/consignmentOutHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MO') {
            $model = MovementOutHeader::model()->findByAttributes(array('movement_out_no' => $codeNumber));
            $this->redirect(array('/transaction/movementOutHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MI') {
            $model = MovementInHeader::model()->findByAttributes(array('movement_in_number' => $codeNumber));
            $this->redirect(array('/transaction/movementInHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/accounting/paymentOut/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RTI') {
            $model = TransactionReturnItem::model()->findByAttributes(array('return_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReturnItem/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'TR') {
            $model = TransactionTransferRequest::model()->findByAttributes(array('transfer_request_no' => $codeNumber));
            $this->redirect(array('/transaction/transferRequest/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'SR') {
            $model = TransactionSentRequest::model()->findByAttributes(array('sent_request_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionSentRequest/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'JAD') {
            $model = JournalAdjustmentHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/journalAdjustment/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'SA') {
            $model = StockAdjustmentHeader::model()->findByAttributes(array('stock_adjustment_number' => $codeNumber));
            $this->redirect(array('/frontDest/adjustment/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'DAS') {
            $model = AssetDepreciation::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/view', 'id' => $model->asset_purchase_id));
        } else if ($codeNumberConstant === 'SAS') {
            $model = AssetSale::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/view', 'id' => $model->asset_purchase_id));
        } else if ($codeNumberConstant === 'PAS') {
            $model = AssetPurchase::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetManagement/view', 'id' => $model->id));
        }
    }
}
