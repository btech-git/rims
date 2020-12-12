<?php

class SentRequestController extends Controller {

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

        $sentRequest = Search::bind(new TransactionSentRequest('search'), isset($_GET['TransactionSentRequest']) ? $_GET['TransactionSentRequest'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $sentRequestSummary = new SentRequestSummary($sentRequest->search());
        $sentRequestSummary->setupLoading();
        $sentRequestSummary->setupPaging($pageSize, $currentPage);
        $sentRequestSummary->setupSorting();
        $sentRequestSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($sentRequestSummary, $branchId, $sentRequestSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'sentRequest' => $sentRequest,
            'sentRequestSummary' => $sentRequestSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($sentRequestSummary, $branchId, $dataProvider, array $options = array()) {

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Sent Request');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Sent Request');

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
        $worksheet->setCellValue('A2', 'Laporan Sent Request');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Sent Request #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Status');
        $worksheet->setCellValue('D5', 'Tanggal Tiba');
        $worksheet->setCellValue('E5', 'Tujuan');
        $worksheet->setCellValue('F5', 'Admin ');
        $worksheet->setCellValue('G5', 'Branch');
        $worksheet->setCellValue('H5', 'Approval By');
        $worksheet->setCellValue('I5', 'Product');
        $worksheet->setCellValue('J5', 'Quantity');
        $worksheet->setCellValue('K5', 'Unit Price');

        $worksheet->getStyle('A5:K5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->transactionSentRequestDetails as $detail) {
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->sent_request_no));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->sent_request_date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'status_document')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($header->estimate_arrival_date));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'destinationBranch.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'requesterBranch.name')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'approval.username')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'unit_price')));

                $counter++;
            }
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Sent Request.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
