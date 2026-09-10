<?php

class TransferRequestController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('transferRequestReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transferRequest = Search::bind(new TransactionTransferRequest('search'), isset($_GET['TransactionTransferRequest']) ? $_GET['TransactionTransferRequest'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $transferRequestSummary = new TransferRequestSummary($transferRequest->search());
        $transferRequestSummary->setupLoading();
        $transferRequestSummary->setupPaging($pageSize, $currentPage);
        $transferRequestSummary->setupSorting();
        $transferRequestSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transferRequestSummary, $branchId, $transferRequestSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'transferRequest' => $transferRequest,
            'transferRequestSummary' => $transferRequestSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($transferRequestSummary, $branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Transfer Request');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transfer Request');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Transfer Request');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Transfer Request #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Status');
        $worksheet->setCellValue('D5', 'Tanggal Tiba');
        $worksheet->setCellValue('E5', 'Tujuan');
        $worksheet->setCellValue('F5', 'User Request ');
        $worksheet->setCellValue('G5', 'Approval By');
        $worksheet->setCellValue('H5', 'Parts');
        $worksheet->setCellValue('I5', 'Memo');
        $worksheet->setCellValue('J5', 'Quantity');
        $worksheet->setCellValue('K5', 'Satuan');
        $worksheet->setCellValue('L5', 'Unit Price');
        $worksheet->setCellValue('M5', 'Total');

        $worksheet->getStyle('A5:M5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $totalQuantity = '0.00';
        $totalAmount = '0.00';
        
        foreach ($dataProvider->data as $header) {
            foreach ($header->transactionTransferRequestDetails as $detail) {
                $quantity = CHtml::value($detail, 'quantity');
                $amount = CHtml::value($detail, 'amount');
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transfer_request_no'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'transfer_request_date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'status_document'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'estimate_arrival_date'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'destinationBranch.name'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'user.username'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'approval.username'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($detail, 'product.name'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail, 'memo'));
                $worksheet->setCellValue("J{$counter}", $quantity);
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'unit.name'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'unit_price'));
                $worksheet->setCellValue("M{$counter}", $amount);

                $totalQuantity += $quantity;
                $totalAmount += $amount;
                $counter++;
            }
        }

        $worksheet->getStyle("A{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:M{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("I{$counter}", 'TOTAL');
        $worksheet->setCellValue("J{$counter}", $totalQuantity);
        $worksheet->setCellValue("M{$counter}", $totalAmount);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Transfer Request.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
