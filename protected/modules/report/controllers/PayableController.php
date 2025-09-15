<?php

class PayableController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('supplierPayableReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->pagination->pageVar = 'page_dialog';

        $payableSummary = new PayableSummary($supplier->searchByPayableReport());
        $payableSummary->setupLoading();
        $payableSummary->setupPaging($pageSize, $currentPage);
        $payableSummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
            'supplierId' => $supplierId,
        );
        $payableSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($payableSummary, $endDate, $branchId);
        }

        $this->render('summary', array(
            'payableSummary' => $payableSummary,
            'supplier'=>$supplier,
            'supplierDataProvider'=>$supplierDataProvider,
            'supplierId' => $supplierId,
            'branchId' => $branchId,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
        ));
    }

    public function actionAjaxJsonSupplier() {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['SupplierId'])) ? $_POST['SupplierId'] : '';
            $supplier = Supplier::model()->findByPk($supplierId);

            $object = array(
                'supplier_id' => CHtml::value($supplier, 'id'),
                'supplier_name' => CHtml::value($supplier, 'name'),
                'supplier_code' => CHtml::value($supplier, 'code'),
                'supplier_mobile_phone' => CHtml::value($supplier, 'mobile_phone'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseORder/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'WOE') {
            $model = WorkOrderExpenseHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/workOrderExpense/show', 'id' => $model->id));
        }

    }
    
    protected function saveToExcel($payableSummary, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Hutang Supplier');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Hutang Supplier');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');

        $worksheet->getStyle('A1:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Hutang Supplier');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:I5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:I5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:I5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Company');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'PO #');
        $worksheet->setCellValue('E5', 'Tanggal');
        $worksheet->setCellValue('F5', 'Invoice #');
        $worksheet->setCellValue('G5', 'Grand Total');
        $worksheet->setCellValue('H5', 'Payment');
        $worksheet->setCellValue('I5', 'Remaining');

        $counter = 7;
        
        foreach ($payableSummary->dataProvider->data as $header) {
            $payableData = $header->getPayableReport($endDate, $branchId);
            $payableWorkOrderExpenseData = $header->getPayableWorkOrderExpenseReport($endDate, $branchId);
            
            foreach ($payableData as $payableRow) {
                $purchase = $payableRow['total_price'];
                $paymentAmount = $payableRow['amount'];
                $paymentLeft = $payableRow['remaining'];

                $worksheet->setCellValue("A{$counter}", $header->code);
                $worksheet->setCellValue("B{$counter}", $header->company);
                $worksheet->setCellValue("C{$counter}", $header->name);
                $worksheet->setCellValue("D{$counter}", $payableRow['purchase_order_no']);
                $worksheet->setCellValue("E{$counter}", $payableRow['purchase_order_date']);
                $worksheet->setCellValue("F{$counter}", $payableRow['invoice_number']);
                $worksheet->setCellValue("G{$counter}", $purchase);
                $worksheet->setCellValue("H{$counter}", $paymentAmount);
                $worksheet->setCellValue("I{$counter}", $paymentLeft);

                $counter++;
            }
            
            foreach ($payableWorkOrderExpenseData as $payableRow) {
                $purchase = $payableRow['total_price'];
                $paymentAmount = $payableRow['amount'];
                $paymentLeft = $payableRow['remaining'];

                $worksheet->setCellValue("A{$counter}", $header->code);
                $worksheet->setCellValue("B{$counter}", $header->company);
                $worksheet->setCellValue("C{$counter}", $header->name);
                $worksheet->setCellValue("D{$counter}", $payableRow['registration_number']);
                $worksheet->setCellValue("E{$counter}", $payableRow['transaction_date']);
                $worksheet->setCellValue("F{$counter}", $payableRow['transaction_number']);
                $worksheet->setCellValue("G{$counter}", $purchase);
                $worksheet->setCellValue("H{$counter}", $paymentAmount);
                $worksheet->setCellValue("I{$counter}", $paymentLeft);

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
        header('Content-Disposition: attachment;filename="Laporan Hutang Supplier.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
