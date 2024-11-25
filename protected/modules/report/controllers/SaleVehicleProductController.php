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
        $documentProperties->setTitle('Penjualan per Kendaraan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan per Kendaraan');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');

        $worksheet->getStyle('A1:L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan per Kendaraan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Name');
        $worksheet->setCellValue('C5', 'Penjualan #');
        $worksheet->setCellValue('D5', 'Tanggal');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Barang');
        $worksheet->setCellValue('G5', 'Disc Barang');
        $worksheet->setCellValue('H5', 'Jasa');
        $worksheet->setCellValue('I5', 'Disc Jasa');
        $worksheet->setCellValue('J5', 'Ppn');
        $worksheet->setCellValue('K5', 'Pph');
        $worksheet->setCellValue('L5', 'Total');

        $worksheet->getStyle('A6:L6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $grandTotalSale = 0.00;
        foreach ($dataProvider->data as $header) {
            $totalSale = 0.00;
            $saleRetailVehicleData = $header->getSaleVehicleReport($startDate, $endDate, $branchId);

            foreach ($saleRetailVehicleData as $saleRetailVehicleRow) {
                $invoiceHeader = InvoiceHeader::model()->findByPk($saleRetailVehicleRow['id']);
                $discountProduct = $invoiceHeader->getTotalDiscountProduct();
                $discountService = $invoiceHeader->getTotalDiscountService();
                $grandTotal = $saleRetailVehicleRow['total_price'];
                
                $worksheet->getStyle("H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'id')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($saleRetailVehicleRow['invoice_number']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($saleRetailVehicleRow['invoice_date']));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($saleRetailVehicleRow['customer']));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($saleRetailVehicleRow['product_price']));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($discountProduct));
                $worksheet->setCellValue("H{$counter}", CHtml::encode($saleRetailVehicleRow['service_price']));
                $worksheet->setCellValue("I{$counter}", CHtml::encode($discountService));
                $worksheet->setCellValue("J{$counter}", CHtml::encode($saleRetailVehicleRow['ppn_total']));
                $worksheet->setCellValue("K{$counter}", CHtml::encode($saleRetailVehicleRow['pph_total']));
                $worksheet->setCellValue("L{$counter}", CHtml::encode($grandTotal));

                $counter++;
                $totalSale += $grandTotal;
            }

            $worksheet->getStyle("J{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("J{$counter}:M{$counter}")->getFont()->setBold(true);

            $worksheet->setCellValue("K{$counter}", 'TOTAL');
            $worksheet->setCellValue("M{$counter}", CHtml::encode($totalSale));
            $grandTotalSale += $totalSale;
            $counter++;$counter++;

        }
        
        $worksheet->getStyle("A{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:M{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("K{$counter}", 'TOTAL PENJUALAN');
        $worksheet->setCellValue("M{$counter}", CHtml::encode($grandTotalSale));

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan per Kendaraan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}