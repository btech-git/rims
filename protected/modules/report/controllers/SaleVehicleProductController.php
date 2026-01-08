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
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleVehicleProductSummary, $saleInvoiceVehicleReportData, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
                'branchId' => $branchId,
            ));
        }
        
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

    protected function saveToExcel($saleVehicleProductSummary, $saleInvoiceVehicleReportData, array $options = array()) {
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
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Penjualan per Kendaraan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Kendaraan');
        $worksheet->setCellValue('C5', 'Penjualan #');
        $worksheet->setCellValue('D5', 'Tanggal');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Plat #');
        $worksheet->setCellValue('G5', 'Asuransi');
        $worksheet->setCellValue('H5', 'Barang');
        $worksheet->setCellValue('I5', 'Jasa');
        $worksheet->setCellValue('J5', 'Ppn');
        $worksheet->setCellValue('K5', 'Pph');
        $worksheet->setCellValue('L5', 'Total');

        $worksheet->getStyle('A6:L6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        
        foreach ($saleVehicleProductSummary->dataProvider->data as $carSubModel) {
            $totalSale = '0.00';
            foreach ($saleInvoiceVehicleReportData[$carSubModel->id] as $i => $saleInvoiceVehicleReportItem) {
                $grandTotal = $saleInvoiceVehicleReportItem['total_price'];
                $worksheet->getStyle("H{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", $i + 1);
                $worksheet->setCellValue("B{$counter}", CHtml::value($carSubModel, 'carMake.name') . ' - ' . CHtml::value($carSubModel, 'carModel.name') . ' - ' . CHtml::value($carSubModel, 'name'));
                $worksheet->setCellValue("C{$counter}", $saleInvoiceVehicleReportItem['invoice_number']);
                $worksheet->setCellValue("D{$counter}", $saleInvoiceVehicleReportItem['invoice_date']);
                $worksheet->setCellValue("E{$counter}", $saleInvoiceVehicleReportItem['customer_name']);
                $worksheet->setCellValue("F{$counter}", $saleInvoiceVehicleReportItem['plate_number']);
                $worksheet->setCellValue("G{$counter}", $saleInvoiceVehicleReportItem['insurance_company']);
                $worksheet->setCellValue("H{$counter}", $saleInvoiceVehicleReportItem['product_price']);
                $worksheet->setCellValue("I{$counter}", $saleInvoiceVehicleReportItem['service_price']);
                $worksheet->setCellValue("J{$counter}", $saleInvoiceVehicleReportItem['ppn_total']);
                $worksheet->setCellValue("K{$counter}", $saleInvoiceVehicleReportItem['pph_total']);
                $worksheet->setCellValue("L{$counter}", $grandTotal);

                $counter++;
                $totalSale += $grandTotal;
            }

            $worksheet->getStyle("H{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("H{$counter}:L{$counter}")->getFont()->setBold(true);

            $worksheet->setCellValue("K{$counter}", 'TOTAL');
            $worksheet->setCellValue("L{$counter}", $totalSale);
            $counter++;$counter++;
        }
        
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