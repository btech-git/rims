<?php

class DeliveryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('deliveryReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $deliveryOrder = Search::bind(new TransactionDeliveryOrder('search'), isset($_GET['TransactionDeliveryOrder']) ? $_GET['TransactionDeliveryOrder'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $deliveryOrderSummary = new DeliverySummary($deliveryOrder->search());
        $deliveryOrderSummary->setupLoading();
        $deliveryOrderSummary->setupPaging($pageSize, $currentPage);
        $deliveryOrderSummary->setupSorting();
        $deliveryOrderSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($branchId, $deliveryOrderSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'deliveryOrder' => $deliveryOrder,
            'deliveryOrderSummary' => $deliveryOrderSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Pengiriman Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pengiriman Barang');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');
        $worksheet->getStyle('A1:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Pengiriman Barang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Delivery #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Type');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Reference #');
        $worksheet->setCellValue('F5', 'ETA');
        $worksheet->setCellValue('G5', 'Tujuan');
        $worksheet->setCellValue('H5', 'Pengirim');
        $worksheet->setCellValue('I5', 'Product');
        $worksheet->setCellValue('J5', 'Quantity Request');
        $worksheet->setCellValue('K5', 'Quantity Kirim');
        $worksheet->setCellValue('L5', 'Quantity Movement');
        $worksheet->setCellValue('M5', 'Memo');

        $worksheet->getStyle('A5:M5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->transactionDeliveryOrderDetails as $detail) {
                $referenceNumber = ''; 
                if (!empty($header->sales_order_id)) { 
                    $referenceNumber = CHtml::value($header, 'saleOrder.sale_order_no');
                } elseif (!empty($header->sent_request_id)) {
                    $referenceNumber = CHtml::value($header, 'sentRequest.sent_request_no');                
                } elseif (!empty($header->consignment_out_id)) {
                    $referenceNumber = CHtml::value($header, 'consignmentOut.consignment_out_no');                
                } elseif (!empty($header->transfer_request_id)) {
                    $referenceNumber = CHtml::value($header, 'transferRequest.transfer_request_no');                
                } else {
                    $referenceNumber = 'N/A';                
                }
                $productName = CHtml::value($detail, 'product.manufacturer_code') . ' - ' . CHtml::value($detail, 'product.name') . ' - ' . CHtml::value($detail, 'product.brand.name') . ' - ' .
                        CHtml::value($detail, 'product.subBrand.name') . ' - ' . CHtml::value($detail, 'product.subBrandSeries.name') . ' - ' . CHtml::value($detail, 'product.productMasterCategory.name') . ' - ' .
                        CHtml::value($detail, 'product.productSubMasterCategory.name') . ' - ' . CHtml::value($detail, 'product.productSubCategory.name');
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'delivery_order_no'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'delivery_date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'request_type'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
                $worksheet->setCellValue("E{$counter}", $referenceNumber);
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'estimate_arrival_date'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'destinationBranch.code'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'sender.username'));
                $worksheet->setCellValue("I{$counter}", $productName);
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'quantity_request'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'quantity_delivery'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'quantity_movement'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'note'));

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'P'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_pengiriman_barang.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
