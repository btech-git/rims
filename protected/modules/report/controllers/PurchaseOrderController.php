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
            if (!(Yii::app()->user->checkAccess('purchaseOrderReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $purchaseOrder = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchaseOrderSummary = new PurchaseOrderSummary($purchaseOrder->search());
        $purchaseOrderSummary->setupLoading();
        $purchaseOrderSummary->setupPaging($pageSize, $currentPage);
        $purchaseOrderSummary->setupSorting();
        $purchaseOrderSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchaseOrderSummary, $branchId, $purchaseOrderSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderSummary' => $purchaseOrderSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($purchaseOrderSummary, $branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Purchase Order');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Purchase Order');

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);
        $worksheet->getColumnDimension('I')->setAutoSize(true);
        $worksheet->getColumnDimension('J')->setAutoSize(true);
        $worksheet->getColumnDimension('K')->setAutoSize(true);
        $worksheet->getColumnDimension('L')->setAutoSize(true);
        $worksheet->getColumnDimension('M')->setAutoSize(true);
        $worksheet->getColumnDimension('N')->setAutoSize(true);

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');

        $worksheet->getStyle('A1:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Purchase Order');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Purchase #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Status');
        $worksheet->setCellValue('D5', 'Type');
        $worksheet->setCellValue('E5', 'Supplier');
        $worksheet->setCellValue('F5', 'Payment Type');
        $worksheet->setCellValue('G5', 'Tanggal Terima');
        $worksheet->setCellValue('H5', 'Admin ');
        $worksheet->setCellValue('I5', 'Branch');
        $worksheet->setCellValue('J5', 'Approval By');
        $worksheet->setCellValue('K5', 'Total Price');
        $worksheet->setCellValue('L5', 'Payment');
        $worksheet->setCellValue('M5', 'Remaining');
        $worksheet->setCellValue('N5', 'Product');
        $worksheet->setCellValue('O5', 'Retail Price');
        $worksheet->setCellValue('P5', 'Unit Price');
        $worksheet->setCellValue('Q5', 'Quantity');
        $worksheet->setCellValue('R5', 'Total Quantity');
        $worksheet->setCellValue('S5', 'Discount');
        $worksheet->setCellValue('T5', 'Total Price');

        $worksheet->getStyle('A5:T5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->transactionPurchaseOrderDetails as $detail) {
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->purchase_order_no));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->purchase_order_date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'status_document')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($header->getPurchaseStatus($header->purchase_type)));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($header->payment_type));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'estimate_date_arrival')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'mainBranch.name')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'approval.username')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'total_price')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'payment_amount')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($header, 'payment_left')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'retail_price')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'unit_price')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'total_quantity')));
                $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($detail, 'discount')));
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($detail, 'total_price')));

                $counter++;
            }
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Purchase Order.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
