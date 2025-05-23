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
//        list($leftPart,, ) = explode('/', $codeNumber);
//        list(, $codeNumberConstant) = explode('.', $leftPart);

        $model = TransactionReceiveItem::model()->findByAttributes(array('invoice_number' => $codeNumber));
        $this->redirect(array('/transaction/transactionReceiveItem/showInvoice', 'id' => $model->id));

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

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');

        $worksheet->getStyle('A1:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A2', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A3', 'Laporan Hutang Supplier');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:E5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:E6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:E6')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Company');
        $worksheet->setCellValue('C5', 'Name');

        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'PO #');
        $worksheet->setCellValue('C6', 'Grand Total');
        $worksheet->setCellValue('D6', 'Payment');
        $worksheet->setCellValue('E6', 'Remaining');

        $counter = 8;
        
        foreach ($payableSummary->dataProvider->data as $header) {
            
            $payableData = $header->getPayableReport($endDate, $branchId);
            $totalPurchase = 0.00;
            $totalPayment = 0.00;
            $totalPayable = 0.00;
            foreach ($payableData as $payableRow) {
                $purchase = $payableRow['total_price'];
                $paymentAmount = $payableRow['amount'];
                $paymentLeft = $payableRow['remaining'];

                $worksheet->setCellValue("A{$counter}", $header->code);
                $worksheet->setCellValue("B{$counter}", $header->company);
                $worksheet->setCellValue("C{$counter}", $header->name);
                $worksheet->setCellValue("D{$counter}", $payableRow['purchase_order_date']);
                $worksheet->setCellValue("E{$counter}", $payableRow['invoice_number']);
                $worksheet->setCellValue("F{$counter}", $purchase);
                $worksheet->setCellValue("G{$counter}", $paymentAmount);
                $worksheet->setCellValue("H{$counter}", $paymentLeft);

                $counter++;
                
                $totalPurchase += $purchase;
                $totalPayment += $paymentAmount;
                $totalPayable += $paymentLeft;
            }
            
            $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);

//            $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//            $worksheet->getStyle("A{$counter}:E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//            $worksheet->mergeCells("A{$counter}:B{$counter}");
//            $worksheet->setCellValue("A{$counter}", 'Total');
//            $worksheet->setCellValue("C{$counter}", $totalPurchase);
//            $worksheet->setCellValue("D{$counter}", $totalPayment);
//            $worksheet->setCellValue("E{$counter}", $totalPayable);
//
//            $counter++;$counter++;
        }

        for ($col = 'A'; $col !== 'F'; $col++) {
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
