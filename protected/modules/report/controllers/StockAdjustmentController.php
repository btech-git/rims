<?php

class StockAdjustmentController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $stockAdjustmentHeader = Search::bind(new StockAdjustmentHeader('search'), isset($_GET['StockAdjustmentHeader']) ? $_GET['StockAdjustmentHeader'] : array());
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $stockAdjustmentSummary = new StockAdjustmentSummary($stockAdjustmentHeader->search());
        $stockAdjustmentSummary->setupLoading();
        $stockAdjustmentSummary->setupPaging($pageSize, $currentPage);
        $stockAdjustmentSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $stockAdjustmentSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($stockAdjustmentSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'stockAdjustmentSummary' => $stockAdjustmentSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penyesuaian Stok Gudang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penyesuaian Stok Gudang');

        $worksheet->mergeCells('A1:T1');
        $worksheet->mergeCells('A2:T2');
        $worksheet->mergeCells('A3:T3');

        $worksheet->getStyle('A1:T6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:T6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Penyesuaian Stok Gudang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:T5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Penyesuaian #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Tipe');
        $worksheet->setCellValue('D5', 'Cabang');
        $worksheet->setCellValue('E5', 'Tujuan');
        $worksheet->setCellValue('F5', 'Status');
        $worksheet->setCellValue('G5', 'Catatan');
        $worksheet->setCellValue('H5', 'Pembuat');
        $worksheet->setCellValue('I5', 'Supervisor');
        $worksheet->setCellValue('J5', 'Tanggal Input');
        $worksheet->setCellValue('K5', 'Code');
        $worksheet->setCellValue('L5', 'Name');
        $worksheet->setCellValue('M5', 'Brand');
        $worksheet->setCellValue('N5', 'Stok Asal');
        $worksheet->setCellValue('O5', 'Penyesuaian Asal');
        $worksheet->setCellValue('P5', 'Selisih Asal');
        $worksheet->setCellValue('Q5', 'Stok Tujuan');
        $worksheet->setCellValue('R5', 'Penyesuaian Tujuan');
        $worksheet->setCellValue('S5', 'Selisih Tujuan');
        $worksheet->setCellValue('T5', 'Memo');

        $worksheet->getStyle('A6:T6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $grandTotalSale = '0.00';
        
        foreach ($dataProvider->data as $header) {
            foreach ($header->stockAdjustmentDetails as $detail) {
                $worksheet->getStyle("N{$counter}:S{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'stock_adjustment_number')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'date_posting')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'transaction_type')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'branchIdDestination.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'status')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'supervisor.username')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'created_datetime')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'product.brand.name')) . ' - ' . CHtml::encode(CHtml::value($detail, 'product.subBrand.name')) . ' - ' . CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_current')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_adjustment')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'quantityDifference')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_current_destination')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_adjustment_destination')));
                $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($detail, 'quantityDifferenceDestination')));
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($detail, 'memo')));
                $counter++;

            }
        }
        $worksheet->getStyle("A{$counter}:T{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:T{$counter}")->getFont()->setBold(true);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Penyesuaian Stok Gudang.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
