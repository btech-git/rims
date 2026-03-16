<?php

class OutstandingPurchaseOrderController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleRetailReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $purchaseOrder = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : null;
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
            $supplierId = null;
            $branchId = null;
            $pageSize = '';
            $currentPage = '';
            $currentSort = '';
        }
        
        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->pagination->pageVar = 'page_dialog';

        $outstandingPurchaseOrderSummary = new OutstandingPurchaseOrderSummary($purchaseOrder->search());
        $outstandingPurchaseOrderSummary->setupLoading();
        $outstandingPurchaseOrderSummary->setupPaging($pageSize, $currentPage);
        $outstandingPurchaseOrderSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'supplierId' => $supplierId,
        );
        $outstandingPurchaseOrderSummary->setupFilter($filters);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($outstandingPurchaseOrderSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'purchaseOrder' => $purchaseOrder,
            'outstandingPurchaseOrderSummary' => $outstandingPurchaseOrderSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
            'supplierId' => $supplierId,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
        ));
    }

    public function actionAjaxJsonSupplier() {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['SupplierId'])) ? $_POST['SupplierId'] : '';
            $supplier = Supplier::model()->findByPk($supplierId);

            $object = array(
                'supplier_id' => CHtml::value($supplier, 'id'),
                'supplier_name' => CHtml::value($supplier, 'company'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($outstandingPurchaseOrderSummary, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Outstanding Registration');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Outstanding Registration');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        
        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Outstanding Registration Transaction');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:J5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:J5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'PO #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Supplier');
        $worksheet->setCellValue('E5', 'Type');
        $worksheet->setCellValue('F5', 'Status');
        $worksheet->setCellValue('G5', 'Total (Rp)');
        $worksheet->setCellValue('H5', 'Receive #');
        $worksheet->setCellValue('I5', 'Invoice #');
        $worksheet->setCellValue('J5', 'Payment #');

        $counter = 6;

        foreach ($outstandingPurchaseOrderSummary->dataProvider->data as $i => $header) {
            $receiveItems = $header->transactionReceiveItems;
            $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems);
            $invoiceCodeNumbers = array_map(function($receiveItem) { return $receiveItem->invoice_number; }, $receiveItems);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'purchase_order_no'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'purchase_order_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'supplier.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'purchase_type'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'status_document'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(implode(', ', $receiveItemCodeNumbers)));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(implode(', ', $invoiceCodeNumbers)));
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="outstanding_purchase_order.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
