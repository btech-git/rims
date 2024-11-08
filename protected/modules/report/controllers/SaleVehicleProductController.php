<?php

class SaleVehicleProductController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('generalLedgerReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $carMake = Search::bind(new VehicleCarMake('search'), isset($_GET['VehicleCarMake']) ? $_GET['VehicleCarMake'] : array());
        $carMakeDataProvider = $carMake->search();
        $carMakeDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $saleVehicleProductSummary = new SaleVehicleProductSummary($carMake->search());
        $saleVehicleProductSummary->setupLoading();
        $saleVehicleProductSummary->setupPaging($pageSize, $currentPage);
        $saleVehicleProductSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $saleVehicleProductSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleVehicleProductSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
                'branchId' => $branchId,
            ));
        }
        
        $this->render('summary', array(
            'carMake' => $carMake,
            'carMakeDataProvider' => $carMakeDataProvider,
            'saleVehicleProductSummary' => $saleVehicleProductSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'currentSort' => $currentSort,
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
        ));
    }
    
    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $startDate = $options['startDate'];
        $endDate = $options['endDate'];
        $branchId = $options['branchId'];
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Product per Kendaraan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Product per Kendaraan');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');

        $worksheet->getStyle('A1:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I6')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Penjualan Product per Kendaraan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:I5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Name');

        $worksheet->setCellValue('A6', 'Penjualan #');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Customer');
        $worksheet->setCellValue('D6', 'Kode Barang');
        $worksheet->setCellValue('E6', 'Nama Barang');
        $worksheet->setCellValue('F6', 'Quantity');
        $worksheet->setCellValue('G6', 'Harga');
        $worksheet->setCellValue('H6', 'Total');

        $worksheet->getStyle('A6:I6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'id')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'name')));

            $counter++;
            
            $saleRetailData = $header->getSaleVehicleProductReport($startDate, $endDate, $branchId);
            $totalSale = 0.00;
            foreach ($saleRetailData as $saleRetailRow) {
                $total = $saleRetailRow['total_price'];
                
                $worksheet->getStyle("I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($saleRetailRow['transaction_number']));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($saleRetailRow['transaction_date']));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($saleRetailRow['customer']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($saleRetailRow['code']));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($saleRetailRow['name']));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($saleRetailRow['quantity']));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($saleRetailRow['sale_price']));
                $worksheet->setCellValue("H{$counter}", CHtml::encode($total));

                $counter++;
                $totalSale += $total;

            }

            $worksheet->getStyle("G{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

            $worksheet->setCellValue("G{$counter}", 'TOTAL');
            $worksheet->setCellValue("H{$counter}", CHtml::encode($totalSale));
            $counter++;$counter++;

        }
        
        for ($col = 'A'; $col !== 'I'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan Product per Kendaraan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}