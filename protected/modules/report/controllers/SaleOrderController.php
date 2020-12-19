<?php

class SaleOrderController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleOrderReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $saleOrder = Search::bind(new TransactionSalesOrder('search'), isset($_GET['TransactionSalesOrder']) ? $_GET['TransactionSalesOrder'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleOrderSummary = new SaleOrderSummary($saleOrder->search());
        $saleOrderSummary->setupLoading();
        $saleOrderSummary->setupPaging($pageSize, $currentPage);
        $saleOrderSummary->setupSorting();
        $saleOrderSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleOrderSummary, $branchId, $saleOrderSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'saleOrder' => $saleOrder,
            'saleOrderSummary' => $saleOrderSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($saleOrderSummary, $branchId, $dataProvider, array $options = array()) {

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Sale Order');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Sale Order');

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
        $worksheet->getColumnDimension('O')->setAutoSize(true);
        $worksheet->getColumnDimension('P')->setAutoSize(true);
        $worksheet->getColumnDimension('Q')->setAutoSize(true);

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');

        $worksheet->getStyle('A1:Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Sale Order');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:Q5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Sale #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Status');
        $worksheet->setCellValue('D5', 'Payment Type');
        $worksheet->setCellValue('E5', 'Tanggal Kirim');
        $worksheet->setCellValue('F5', 'Customer');
        $worksheet->setCellValue('G5', 'Sub Total');
        $worksheet->setCellValue('H5', 'Discount ');
        $worksheet->setCellValue('I5', 'PPN');
        $worksheet->setCellValue('J5', 'Total Price');
        $worksheet->setCellValue('K5', 'Note');
        $worksheet->setCellValue('L5', 'Product');
        $worksheet->setCellValue('M5', 'Quantity');
        $worksheet->setCellValue('N5', 'Retail Price');
        $worksheet->setCellValue('O5', 'Unit Price');
        $worksheet->setCellValue('P5', 'Discount');
        $worksheet->setCellValue('Q5', 'Total Price');

        $worksheet->getStyle('A5:Q5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->transactionSalesOrderDetails as $detail) {
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->sale_order_no));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->sale_order_date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'status_document')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($header->payment_type));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'estimate_arrival_date')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($header->customer->name));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'subtotal')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'discount')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'ppn_price')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'total_price')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'retail_price')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'unit_price')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'discount')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'total_price')));

                $counter++;
            }
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Sale Order.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
