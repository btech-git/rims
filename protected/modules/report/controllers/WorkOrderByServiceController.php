<?php

class WorkOrderByServiceController extends Controller {

    public $layout = '//layouts/column3';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('workOrderServiceReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

//        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values

        if (isset($_GET['Product'])) {
            $service->attributes = $_GET['Product'];
        }

        $serviceDataProvider = $service->search();

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $workOrderServiceSummary = new WorkOrderByServiceSummary($service->search());
        $workOrderServiceSummary->setupLoading();
        $workOrderServiceSummary->setupPaging($pageSize, $currentPage);
        $workOrderServiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $workOrderServiceSummary->setupFilter($filters);

//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($workOrderServiceSummary, $startDate, $endDate);
//        }

        $this->render('summary', array(
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'workOrderServiceSummary' => $workOrderServiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($workOrderServiceSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Kartu Stok Persediaan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Kartu Stok Persediaan');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        $worksheet->mergeCells('A4:I4');
        $worksheet->getStyle('A1:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Kartu Stok Persediaan');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:I6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:I6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:H6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Jenis Transaksi');
        $worksheet->setCellValue('C6', 'Transaksi #');
        $worksheet->setCellValue('D6', 'Keterangan');
        $worksheet->setCellValue('E6', 'Gudang');
        $worksheet->setCellValue('F6', 'Masuk');
        $worksheet->setCellValue('G6', 'Keluar');
        $worksheet->setCellValue('H6', 'Stok');
        $worksheet->setCellValue('I6', 'Nilai');

        $counter = 8;

        foreach ($workOrderServiceSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->name);
            $worksheet->setCellValue("B{$counter}", $header->manufacturer_code);
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'masterSubCategoryCode')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'brand.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'subBrand.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'subBrandSeries.name'));
            $worksheet->getStyle("G{$counter}")->getFont()->setBold(true);
            $saldo = $header->getBeginningStockReport($startDate); 
            $worksheet->setCellValue("G{$counter}", $header->getBeginningStockReport($startDate));
            
            $stockData = $header->getInventoryStockReport($startDate, $endDate); 
            $totalStockIn = 0;
            $totalStockOut = 0;
            
            $counter++;
            
            foreach ($stockData as $stockRow) {
                $stockIn = $stockRow['stock_in'];
                $stockOut = $stockRow['stock_out'];
                $saldo += $stockIn + $stockOut;
                $inventoryValue = $stockRow['purchase_price'] * $saldo;
                
                $worksheet->setCellValue("A{$counter}", $stockRow['transaction_date']);
                $worksheet->setCellValue("B{$counter}", $stockRow['transaction_type']);
                $worksheet->setCellValue("C{$counter}", $stockRow['transaction_number']);
                $worksheet->setCellValue("D{$counter}", $stockRow['notes']);
                $worksheet->setCellValue("E{$counter}", $stockRow['name']);
                $worksheet->setCellValue("F{$counter}", $stockIn);
                $worksheet->setCellValue("G{$counter}", $stockOut);
                $worksheet->setCellValue("H{$counter}", $saldo);
                $worksheet->setCellValue("I{$counter}", $inventoryValue);
                
                $totalStockIn += $stockIn;
                $totalStockOut += $stockOut;
                
                $counter++;
            }
            
            $worksheet->getStyle("F{$counter}:G{$counter}")->getFont()->setBold(true);

            $worksheet->setCellValue("F{$counter}", $totalStockIn);
            $worksheet->setCellValue("G{$counter}", $totalStockOut);
            $counter++;$counter++;
            
        }

//        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $worksheet->getStyle("E{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//        $worksheet->setCellValue("F{$counter}", 'Total Penjualan');
//        $worksheet->setCellValue("G{$counter}", 'Rp');
//        $worksheet->setCellValue("H{$counter}", $this->reportGrandTotal($saleInvoiceSummary->dataProvider));
//
//        $counter++;

        for ($col = 'A'; $col !== 'I'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Kartu Stok Persediaan.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}