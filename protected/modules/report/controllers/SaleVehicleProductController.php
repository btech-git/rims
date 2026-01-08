<?php

class SaleVehicleProductController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleVehicleReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $carMakeId = (isset($_GET['CarMakeId'])) ? $_GET['CarMakeId'] : '';
        $carModelId = (isset($_GET['CarModelId'])) ? $_GET['CarModelId'] : '';
        $carSubModelId = (isset($_GET['CarSubModelId'])) ? $_GET['CarSubModelId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        if (isset($_GET['ResetFilter'])) {
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
            $branchId = '';
            $carMakeId = '';
            $carModelId = '';
            $carSubModelId = '';
            $pageSize = '';
            $currentPage = '';
            $currentSort = '';

        }
        
        $carSubModel = Search::bind(new VehicleCarSubModel('search'), isset($_GET['VehicleCarSubModel']) ? $_GET['VehicleCarSubModel'] : array());
        
        $saleVehicleProductSummary = new SaleVehicleProductSummary($carSubModel->search());
        $saleVehicleProductSummary->setupLoading();
        $saleVehicleProductSummary->setupPaging($pageSize, $currentPage);
        $saleVehicleProductSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'carMakeId' => $carMakeId,
            'carModelId' => $carModelId,
            'carSubModelId' => $carSubModelId,
        );
        $saleVehicleProductSummary->setupFilter($filters);
        
        $carSubModelIds = array_map(function($carSubModel) { return $carSubModel->id; }, $saleVehicleProductSummary->dataProvider->data);
        $saleInvoiceVehicleReport = InvoiceHeader::getSaleInvoiceVehicleReport($startDate, $endDate, $branchId, $carSubModelIds);
        
        $saleInvoiceVehicleReportData = array();
        foreach ($saleInvoiceVehicleReport as $saleInvoiceVehicleReportItem) {
            if (!isset($saleInvoiceVehicleReportData[$saleInvoiceVehicleReportItem['car_sub_model_id']])) {
                $saleInvoiceVehicleReportData[$saleInvoiceVehicleReportItem['car_sub_model_id']] = array();
            }
            $saleInvoiceVehicleReportData[$saleInvoiceVehicleReportItem['car_sub_model_id']][] = $saleInvoiceVehicleReportItem;
        }
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($saleInvoiceVehicleReportData, array(
//                'startDate' => $startDate, 
//                'endDate' => $endDate, 
//                'branchId' => $branchId,
//            ));
//        }
        
        $this->render('summary', array(
            'saleVehicleProductSummary' => $saleVehicleProductSummary,
            'saleInvoiceVehicleReportData' => $saleInvoiceVehicleReportData,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'carMakeId' => $carMakeId,
            'carModelId' => $carModelId,
            'carSubModelId' => $carSubModelId,
            'currentSort' => $currentSort,
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
        ));
    }
    
    public function actionAjaxHtmlUpdateCarModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $carMakeId = (isset($_GET['CarMakeId'])) ? $_GET['CarMakeId'] : '';
            $carModelId = (isset($_GET['CarModelId'])) ? $_GET['CarModelId'] : '';

            $this->renderPartial('_carModelSelect', array(
                'carMakeId' => $carMakeId,
                'carModelId' => $carModelId,
            ));
        }
    }
    
    public function actionAjaxHtmlUpdateCarSubModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $carModelId = (isset($_GET['CarModelId'])) ? $_GET['CarModelId'] : '';
            $carSubModelId = (isset($_GET['CarSubModelId'])) ? $_GET['CarSubModelId'] : '';

            $this->renderPartial('_carSubModelSelect', array(
                'carModelId' => $carModelId,
                'carSubModelId' => $carSubModelId,
            ));
        }
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

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');

        $worksheet->getStyle('A1:N6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan per Kendaraan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Name');
        $worksheet->setCellValue('C5', 'Penjualan #');
        $worksheet->setCellValue('D5', 'Tanggal');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Plat #');
        $worksheet->setCellValue('G5', 'Asuransi');
        $worksheet->setCellValue('H5', 'Barang');
        $worksheet->setCellValue('I5', 'Disc Barang');
        $worksheet->setCellValue('J5', 'Jasa');
        $worksheet->setCellValue('K5', 'Disc Jasa');
        $worksheet->setCellValue('L5', 'Ppn');
        $worksheet->setCellValue('M5', 'Pph');
        $worksheet->setCellValue('N5', 'Total');

        $worksheet->getStyle('A5:N5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

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
                $worksheet->setCellValue("F{$counter}", CHtml::encode($saleRetailVehicleRow['plate_number']));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($saleRetailVehicleRow['insurance_name']));
                $worksheet->setCellValue("H{$counter}", CHtml::encode($saleRetailVehicleRow['product_price']));
                $worksheet->setCellValue("I{$counter}", CHtml::encode($discountProduct));
                $worksheet->setCellValue("J{$counter}", CHtml::encode($saleRetailVehicleRow['service_price']));
                $worksheet->setCellValue("K{$counter}", CHtml::encode($discountService));
                $worksheet->setCellValue("L{$counter}", CHtml::encode($saleRetailVehicleRow['ppn_total']));
                $worksheet->setCellValue("M{$counter}", CHtml::encode($saleRetailVehicleRow['pph_total']));
                $worksheet->setCellValue("N{$counter}", CHtml::encode($grandTotal));

                $counter++;
                $totalSale += $grandTotal;
            }

            $worksheet->getStyle("J{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("J{$counter}:N{$counter}")->getFont()->setBold(true);

            $worksheet->setCellValue("M{$counter}", 'TOTAL');
            $worksheet->setCellValue("N{$counter}", CHtml::encode($totalSale));
            $grandTotalSale += $totalSale;
            $counter++;$counter++;

        }
        
        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("M{$counter}", 'TOTAL PENJUALAN');
        $worksheet->setCellValue("N{$counter}", CHtml::encode($grandTotalSale));

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_per_kendaraan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}