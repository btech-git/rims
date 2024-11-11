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

//        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $accountDataProvider = $account->search();
        $accountDataProvider->criteria->compare('t.is_approved', 1);
        $accountDataProvider->criteria->compare('t.coa_sub_category_id', 15);
        $accountDataProvider->pagination->pageVar = 'page_dialog';

        $payableLedgerSummary = new PayableLedgerSummary($account->search());
        $payableLedgerSummary->setupLoading();
        $payableLedgerSummary->setupPaging($pageSize, $currentPage);
        $payableLedgerSummary->setupSorting();
        $payableLedgerSummary->setupFilter($coaId);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($payableLedgerSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }
        
        $this->render('summary', array(
            'account' => $account,
            'accountDataProvider' => $accountDataProvider,
            'branchId' => $branchId,
            'payableLedgerSummary' => $payableLedgerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
            'coaId' => $coaId,
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

    public function actionAjaxHtmlUpdateSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $categoryId = isset($_GET['Coa']['coa_category_id']) ? $_GET['Coa']['coa_category_id'] : 0;

            $this->renderPartial('_subCategorySelect', array(
                'categoryId' => $categoryId,
            ), false, true);
        }
    }

    protected function saveToExcel($payableLedgerSummary, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];
        $branchId = $options['branchId']; 
        
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

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Buku Besar Pembantu Hutang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Jenis Transaksi');
        $worksheet->setCellValue('C5', 'Transaksi #');
        $worksheet->setCellValue('D5', 'Keterangan');
        $worksheet->setCellValue('E5', 'Debit');
        $worksheet->setCellValue('F5', 'Kredit');
        $worksheet->setCellValue('G5', 'Saldo');

        $worksheet->getStyle('A6:G6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;

        foreach ($payableLedgerSummary->data as $header) {
            $payableAmount = $header->getPayableAmount();
            if ($payableAmount !== 0) {
                $worksheet->mergeCells("A{$counter}:B{$counter}");
                $worksheet->mergeCells("C{$counter}:E{$counter}");
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'code')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                $saldo = $header->getBeginningBalancePayable($startDate);
                $worksheet->setCellValue("F{$counter}", CHtml::encode($saldo));
                
                $counter++;
                
                $payableData = $header->getPayableLedgerReport($startDate, $endDate, $options['branchId']);
                $positiveAmount = 0; 
                $negativeAmount = 0;
                
                foreach ($payableData as $payableRow) {
                    $purchaseAmount = $payableRow['purchase_amount'];
                    $paymentAmount = $payableRow['payment_amount'];
                    $amount = $payableRow['amount'];
                    if ($payableRow['transaction_type'] == 'K') {
                        $saldo += $amount;
                    } else {
                        $saldo -= $amount;
                    }
                    
                    $worksheet->setCellValue("A{$counter}", CHtml::encode($payableRow['tanggal_transaksi']));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($payableRow['transaction_type']));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode($payableRow['kode_transaksi']));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($payableRow['remark']));
                    $worksheet->setCellValue("E{$counter}", $payableRow['transaction_type'] == 'D' ? CHtml::encode($amount) : 0);
                    $worksheet->setCellValue("F{$counter}", $payableRow['transaction_type'] == 'K' ? CHtml::encode($amount) : 0);
                    $worksheet->setCellValue("G{$counter}", CHtml::encode($saldo));
                    
                    $positiveAmount += $purchaseAmount;
                    $negativeAmount += $paymentAmount; 
                    
                    $counter++;
                }
                
                $worksheet->mergeCells("A{$counter}:F{$counter}");
                $worksheet->setCellValue("A{$counter}", "Total Penambahan");
                $worksheet->setCellValue("G{$counter}", CHtml::encode($negativeAmount));
                $counter++;
                
                $worksheet->mergeCells("A{$counter}:F{$counter}");
                $worksheet->setCellValue("A{$counter}", "Total Penurunan");
                $worksheet->setCellValue("G{$counter}", CHtml::encode($positiveAmount));
                $counter++;
                
                $worksheet->mergeCells("A{$counter}:F{$counter}");
                $worksheet->setCellValue("A{$counter}", "Perubahan Bersih");
                $worksheet->setCellValue("G{$counter}", CHtml::encode($saldo));
                $counter++; $counter++;
                
            }
        }
            
        for ($col = 'A'; $col !== 'L'; $col++) {
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
        } else if ($codeNumberConstant === 'DO') {
            $model = TransactionDeliveryOrder::model()->findByAttributes(array('delivery_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionDeliveryOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RCI') {
            $model = TransactionReceiveItem::model()->findByAttributes(array('receive_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReceiveItem/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CASH') {
            $model = CashTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/transaction/cashTransaction/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MO') {
            $model = MovementOutHeader::model()->findByAttributes(array('movement_out_no' => $codeNumber));
            $this->redirect(array('/transaction/movementOutHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/accounting/paymentOut/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RTO') {
            $model = TransactionReturnOrder::model()->findByAttributes(array('return_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReturnOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'WOE') {
            $model = WorkOrderExpenseHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/workOrderExpense/view', 'id' => $model->id));
        } 
    }
}