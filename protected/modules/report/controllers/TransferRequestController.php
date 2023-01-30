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
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

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

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Transfer Request');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Transfer Request #');
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
            foreach ($header->transactionTransferRequestDetails as $detail) {
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->transfer_request_no));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->transfer_request_date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'status_document')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'estimate_date_arrival')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'destinationBranch.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'mainBranch.name')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'approval.username')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'unit_price')));

                $counter++;
            }
        }

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Transfer Request.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
