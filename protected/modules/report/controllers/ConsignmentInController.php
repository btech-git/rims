<?php

class ConsignmentInController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('consignmentInReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $consignmentInHeader = Search::bind(new ConsignmentInHeader('search'), isset($_GET['ConsignmentInHeader']) ? $_GET['ConsignmentInHeader'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $consignmentInSummary = new ConsignmentInSummary($consignmentInHeader->search());
        $consignmentInSummary->setupLoading();
        $consignmentInSummary->setupPaging($pageSize, $currentPage);
        $consignmentInSummary->setupSorting();
        $consignmentInSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($consignmentInSummary, $branchId, $consignmentInSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'consignmentInHeader' => $consignmentInHeader,
            'consignmentInSummary' => $consignmentInSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($consignmentInSummary, $branchId, $dataProvider, array $options = array()) {

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Consignment In');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Consignment In');

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
        $worksheet->setCellValue('A2', 'Laporan Consignment In');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Consignment In #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Tanggal Terima');
        $worksheet->setCellValue('D5', 'Supplier');
        $worksheet->setCellValue('E5', 'Branch');
        $worksheet->setCellValue('F5', 'Admin');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Product');
        $worksheet->setCellValue('I5', 'Quantity');
        $worksheet->setCellValue('J5', 'Quantity Receive');
        $worksheet->setCellValue('K5', 'Quantity Remaining');
        $worksheet->setCellValue('L5', 'Price');
        $worksheet->setCellValue('M5', 'Total');
        $worksheet->setCellValue('N5', 'Note');

        $worksheet->getStyle('A5:N5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->consignmentInDetails as $detail) {
                $worksheet->getStyle("E{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->consignment_in_number));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->date_posting));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'date_arrival')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'receiveBranch.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'status_document')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'qty_received')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'qty_request_left')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'price')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'total_price')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'note')));

                $counter++;
            }
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Consignment In.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
