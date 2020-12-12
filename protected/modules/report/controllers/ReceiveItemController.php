<?php

class ReceiveItemController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockAdjustmentReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $receiveItemSummary = new ReceiveItemSummary($receiveItem->search());
        $receiveItemSummary->setupLoading();
        $receiveItemSummary->setupPaging($pageSize, $currentPage);
        $receiveItemSummary->setupSorting();
        $receiveItemSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receiveItemSummary, $branchId, $receiveItemSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
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

    protected function saveToExcel($receiveItemSummary, $branchId, $dataProvider, array $options = array()) {

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penerimaan Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penerimaan Barang');

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

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');

        $worksheet->getStyle('A1:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Penerimaan Barang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:P5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Penerimaan #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Tanggal Tiba');
        $worksheet->setCellValue('D5', 'Penerima');
        $worksheet->setCellValue('E5', 'Cabang');
        $worksheet->setCellValue('F5', 'Request Type');
        $worksheet->setCellValue('G5', 'Supplier');
        $worksheet->setCellValue('H5', 'PO #');
        $worksheet->setCellValue('I5', 'Transfer #');
        $worksheet->setCellValue('J5', 'Consignment #');
        $worksheet->setCellValue('K5', 'SJ #');
        $worksheet->setCellValue('L5', 'Movement Out #');
        $worksheet->setCellValue('M5', 'Product');
        $worksheet->setCellValue('N5', 'Quantity Request');
        $worksheet->setCellValue('O5', 'Quantity Receive');
        $worksheet->setCellValue('P5', 'Memo');

        $worksheet->getStyle('A5:P5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->transactionReceiveItemDetails as $detail) {
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->receive_item_no));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->receive_item_date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'arrival_date')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'recipientBranch.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'request_type')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'purchaseOrder. purchase_order_no')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'transferRequest.transfer_request_no')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'consignmentIn.consignment_in_number')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'deliveryOrder.delivery_order_no')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'movementOut.movement_out_no')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'qty_request')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'qty_received')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'note')));

                $counter++;
            }
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Penerimaan Barang.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
