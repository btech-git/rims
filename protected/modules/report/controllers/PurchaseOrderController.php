<?php

class PurchaseOrderController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseSupplierReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->pagination->pageVar = 'page_dialog';
        $supplierDataProvider->criteria->compare('t.status', 'Active');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $purchasePerSupplierSummary = new PurchasePerSupplierSummary($supplier->search());
        $purchasePerSupplierSummary->setupLoading();
        $purchasePerSupplierSummary->setupPaging($pageSize, $currentPage);
        $purchasePerSupplierSummary->setupSorting();
        $purchasePerSupplierSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchasePerSupplierSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate, 'branchId' => $branchId));
        }

        $this->render('summary', array(
            'purchasePerSupplierSummary' => $purchasePerSupplierSummary,
            'supplier'=>$supplier,
            'supplierDataProvider'=>$supplierDataProvider,
            'supplierId' => $supplierId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
        ));
    }

    public function actionAjaxJsonSupplier() {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['Supplier']['id'])) ? $_POST['Supplier']['id'] : '';
            $supplier = Supplier::model()->findByPk($supplierId);

            $object = array(
                'supplier_name' => CHtml::value($supplier, 'company'),
                'supplier_code' => CHtml::value($supplier, 'code'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Rincian Pembelian per Supplier');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Pembelian per Supplier');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        
        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Rincian Pembelian per Supplier');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Company');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Transaction #');
        $worksheet->setCellValue('E5', 'Tanggal');
        $worksheet->setCellValue('F5', 'Payment');
        $worksheet->setCellValue('G5', 'Type');
        $worksheet->setCellValue('H5', 'Parts');
        $worksheet->setCellValue('I5', 'Status');
        $worksheet->setCellValue('J5', 'Total Price');

        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($dataProvider->data as $header) {
            $purchaseOrderData = $header->getPurchasePerSupplierReport($startDate, $endDate, $branchId);
            $workOrderExpenseData = $header->getWorkOrderExpensePerSupplierReport($startDate, $endDate, $branchId);
            $totalPurchase = '0.00';
            $totalWorkOrderExpense = '0.00';
            
            if (!empty($purchaseOrderData)) {
                foreach ($purchaseOrderData as $purchaseOrderItem) {
                    $totalPrice = $purchaseOrderItem['total_price'];
                    $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($purchaseOrderItem['id']);

                    $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'code'));
                    $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'company'));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'name'));
                    $worksheet->setCellValue("D{$counter}", $purchaseOrderItem['purchase_order_no']);
                    $worksheet->setCellValue("E{$counter}", $purchaseOrderItem['purchase_order_date']);
                    $worksheet->setCellValue("F{$counter}", $purchaseOrderItem['payment_type']);
                    $worksheet->setCellValue("G{$counter}", $purchaseOrder->getPurchaseStatus($purchaseOrder->purchase_type));
                    $worksheet->setCellValue("H{$counter}", $purchaseOrder->getProductLists());
                    $worksheet->setCellValue("I{$counter}", $purchaseOrderItem['payment_status']);
                    $worksheet->setCellValue("J{$counter}", $totalPrice);
                    $totalPurchase += $totalPrice;

                    $counter++;
                }
            }
            
            if (!empty($workOrderExpenseData)) {
                foreach ($workOrderExpenseData as $workOrderExpenseItem) {
                    $totalPrice = $workOrderExpenseItem['grand_total'];

                    $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'code'));
                    $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'company'));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'name'));
                    $worksheet->setCellValue("D{$counter}", $workOrderExpenseItem['transaction_number']);
                    $worksheet->setCellValue("E{$counter}", $workOrderExpenseItem['transaction_date']);
                    $worksheet->setCellValue("F{$counter}", $workOrderExpenseItem['registration_number']);
                    $worksheet->setCellValue("G{$counter}", $workOrderExpenseItem['registration_date']);
                    $worksheet->setCellValue("H{$counter}", $workOrderExpenseItem['plate_number']);
                    $worksheet->setCellValue("I{$counter}", $workOrderExpenseItem['status']);
                    $worksheet->setCellValue("J{$counter}", $totalPrice);
                    $totalWorkOrderExpense += $totalPrice;

                    $counter++;
                }
            }
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincian_pembelian_per_supplier.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
