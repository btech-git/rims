<?php

class ReceiveItemController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('receiveItemReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $receiveItemSummary = new ReceiveItemSummary($receiveItem->search());
        $receiveItemSummary->setupLoading();
        $receiveItemSummary->setupPaging($pageSize, $currentPage);
        $receiveItemSummary->setupSorting();
        $receiveItemSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($branchId, $receiveItemSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'receiveItem' => $receiveItem,
            'receiveItemSummary' => $receiveItemSummary,
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
        $documentProperties->setTitle('Laporan Penerimaan Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penerimaan Barang');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');
        $worksheet->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Penerimaan Barang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Penerimaan #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'ETA');
        $worksheet->setCellValue('D5', 'Type');
        $worksheet->setCellValue('E5', 'Reference #');
        $worksheet->setCellValue('F5', 'Supplier');
        $worksheet->setCellValue('G5', 'Tujuan');
        $worksheet->setCellValue('H5', 'Product');
        $worksheet->setCellValue('I5', 'Quantity Request');
        $worksheet->setCellValue('J5', 'Quantity Receive');
        $worksheet->setCellValue('K5', 'Quantity Movement');
        $worksheet->setCellValue('L5', 'Memo');

        $worksheet->getStyle('A5:L5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->transactionReceiveItemDetails as $detail) {
                $referenceNumber = ''; 
                if (!empty($header->purchase_order_id)) { 
                    $referenceNumber = CHtml::value($header, 'purchaseOrder.purchase_order_no');
                } elseif (!empty($header->transfer_request_id)) {
                    $referenceNumber = CHtml::value($header, 'transferRequest.transfer_request_no');                
                } elseif (!empty($header->consignment_in_id)) {
                    $referenceNumber = CHtml::value($header, 'consignmentIn.consignment_in_no');                
                } elseif (!empty($header->delivery_order_id)) {
                    $referenceNumber = CHtml::value($header, 'deliveryOrder.delivery_order_no');                
                } else {
                    $referenceNumber = 'N/A';                
                }
                $productName = CHtml::value($detail, 'product.manufacturer_code') . ' - ' . CHtml::value($detail, 'product.name') . ' - ' . CHtml::value($detail, 'product.brand.name') . ' - ' .
                        CHtml::value($detail, 'product.subBrand.name') . ' - ' . CHtml::value($detail, 'product.subBrandSeries.name') . ' - ' . CHtml::value($detail, 'product.productMasterCategory.name') . ' - ' .
                        CHtml::value($detail, 'product.productSubMasterCategory.name') . ' - ' . CHtml::value($detail, 'product.productSubCategory.name');
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'receive_item_no'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'receive_item_date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'arrival_date'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'request_type'));
                $worksheet->setCellValue("E{$counter}", $referenceNumber);
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'supplier.name'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'destinationBranch.code'));
                $worksheet->setCellValue("H{$counter}", $productName);
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail, 'qty_request'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'qty_received'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'quantity_movement'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'note'));

                $counter++;
            }
        }
        
        for ($col = 'A'; $col !== 'P'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_penerimaan_barang.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
