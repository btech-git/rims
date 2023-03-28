<?php

class PayableLedgerController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('payableJournalReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';

        $payableLedgerSummary = new PayableLedgerSummary($supplier->searchByPayable($startDate));
        $payableLedgerSummary->setupLoading();
        $payableLedgerSummary->setupPaging($pageSize, $currentPage);
        $payableLedgerSummary->setupSorting();
        $filters = array(
            'supplierName' => $supplierName,
        );
        $payableLedgerSummary->setupFilter($filters);
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($payableLedgerSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }
        
        $this->render('summary', array(
            'supplier' => $supplier,
            'supplierName' => $supplierName,
            'payableLedgerSummary' => $payableLedgerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonSupplier() {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = Supplier::model()->findByPk($_POST['Supplier']['id']);
            
            $object = array(
                'supplier_company' => $supplier->company,
                'supplier_name' => $supplier->name,
                'supplier_address' => $supplier->address,
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($payableLedgerSummary, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Buku Besar Pembantu Hutang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Buku Besar Pembantu Hutang');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G6')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Buku Besar Pembantu Hutang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Jenis Transaksi');
        $worksheet->setCellValue('C5', 'Transaksi #');
        $worksheet->setCellValue('D5', 'Keterangan');
        $worksheet->setCellValue('E5', 'Nilai');
        $worksheet->setCellValue('F5', 'Saldo');

        $worksheet->getStyle('A6:G6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;

        foreach ($payableLedgerSummary->data as $header) {
            $saldo = $header->getBeginningBalancePayable($startDate);
            if ($saldo > 0.00) {
                $worksheet->mergeCells("A{$counter}:B{$counter}");
                $worksheet->mergeCells("C{$counter}:E{$counter}");
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'id')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($saldo));
                
                $counter++;
                
                $payableData = $header->getPayableLedgerReport($startDate, $endDate);
                $positiveAmount = 0; 
                $negativeAmount = 0;
                
                foreach ($payableData as $payableRow) {
                    $purchaseAmount = $payableRow['purchase_amount'];
                    $paymentAmount = $payableRow['payment_amount'];
                    $amount = $payableRow['amount'];
                    $saldo += $amount;
                    
                    $worksheet->setCellValue("A{$counter}", CHtml::encode($payableRow['transaction_date']));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($payableRow['transaction_type']));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode($payableRow['transaction_number']));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($payableRow['remark']));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode($amount));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode($saldo));
                    
                    $positiveAmount += $purchaseAmount;
                    $negativeAmount += $paymentAmount; 
                    
                    $counter++;
                }
                
                $worksheet->mergeCells("A{$counter}:E{$counter}");
                $worksheet->setCellValue("A{$counter}", "Total Penambahan");
                $worksheet->setCellValue("F{$counter}", CHtml::encode($positiveAmount));
                $counter++;
                
                $worksheet->mergeCells("A{$counter}:E{$counter}");
                $worksheet->setCellValue("A{$counter}", "Total Penurunan");
                $worksheet->setCellValue("F{$counter}", CHtml::encode($negativeAmount));
                $counter++;
                
                $worksheet->mergeCells("A{$counter}:E{$counter}");
                $worksheet->setCellValue("A{$counter}", "Perubahan Bersih");
                $worksheet->setCellValue("F{$counter}", CHtml::encode($saldo));
                $counter++; $counter++;
                
            }
        }
            
        for ($col = 'A'; $col !== 'G'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Buku Besar Pembantu Hutang.xls"');
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