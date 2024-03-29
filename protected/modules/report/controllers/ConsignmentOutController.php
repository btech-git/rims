<?php

class ConsignmentOutController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('consignmentOutReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $consignmentOutHeader = Search::bind(new ConsignmentOutHeader('search'), isset($_GET['ConsignmentOutHeader']) ? $_GET['ConsignmentOutHeader'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $consignmentOutSummary = new ConsignmentOutSummary($consignmentOutHeader->search());
        $consignmentOutSummary->setupLoading();
        $consignmentOutSummary->setupPaging($pageSize, $currentPage);
        $consignmentOutSummary->setupSorting();
        $consignmentOutSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($consignmentOutSummary, $branchId, $consignmentOutSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'consignmentOutHeader' => $consignmentOutHeader,
            'consignmentOutSummary' => $consignmentOutSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($consignmentOutSummary, $branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Consignment Out');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Consignment Out');

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
        $worksheet->setCellValue('A2', 'Laporan Consignment Out');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Consignment Out #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Tanggal Kirim');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Branch');
        $worksheet->setCellValue('F5', 'Admin');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Product');
        $worksheet->setCellValue('I5', 'Quantity');
        $worksheet->setCellValue('J5', 'Quantity Kirim');
        $worksheet->setCellValue('K5', 'Quantity Remaining');
        $worksheet->setCellValue('L5', 'Price');
        $worksheet->setCellValue('M5', 'Total');

        $worksheet->getStyle('A5:N5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->consignmentOutDetails as $detail) {
                $worksheet->getStyle("E{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->consignment_out_no));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->date_posting));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'delivery_date')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'status')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'qty_sent')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'qty_request_left')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'sale_price')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'total_price')));

                $counter++;
            }
        }

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Consignment Out.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
