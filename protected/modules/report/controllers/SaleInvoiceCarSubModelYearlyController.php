<?php

class SaleInvoiceCarSubModelYearlyController extends Controller {

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
        
        $yearNow = date('Y');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        
        $invoiceVehicleInfo = array();
        $yearlySaleSummary = InvoiceHeader::getSaleInvoiceCarSubModelYearlyData($year, $branchId, $carMake, $carModel);
        foreach ($yearlySaleSummary as $yearlySaleSummaryItem) {
            $monthValue = intval(substr($yearlySaleSummaryItem['year_month_value'], 4, 2));
            $invoiceVehicleInfo[$yearlySaleSummaryItem['car_sub_model_id']]['car_sub_model_id'] = $yearlySaleSummaryItem['car_sub_model_id'];
            $invoiceVehicleInfo[$yearlySaleSummaryItem['car_sub_model_id']]['car_model_name'] = $yearlySaleSummaryItem['car_model_name'];
            $invoiceVehicleInfo[$yearlySaleSummaryItem['car_sub_model_id']]['car_make_name'] = $yearlySaleSummaryItem['car_make_name'];
            $invoiceVehicleInfo[$yearlySaleSummaryItem['car_sub_model_id']]['car_sub_model_name'] = $yearlySaleSummaryItem['car_sub_model_name'];
            $invoiceVehicleInfo[$yearlySaleSummaryItem['car_sub_model_id']]['totals'][$monthValue] = $yearlySaleSummaryItem['total_quantity_vehicle'];
        }

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($invoiceVehicleInfo, $year);
        }

        $this->render('summary', array(
            'yearList' => $yearList,
            'year' => $year,
            'branchId' => $branchId,
            'invoiceVehicleInfo' => $invoiceVehicleInfo,
            'carMake' => $carMake,
            'carModel' => $carModel,
        ));
    }
    
    public function actionTransactionInfo($carSubModelId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceHeader::model()->searchByTransactionInfo($carSubModelId, $startDate, $endDate, $page);
        $carSubModel = VehicleCarSubModel::model()->findByPk($carSubModelId);
        
        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'carSubModel' => $carSubModel,
        ));
    }

    public function actionAjaxHtmlUpdateCarModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
            $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';

            $this->renderPartial('_carModelSelect', array(
                'carMake' => $carMake,
                'carModel' => $carModel,
            ));
        }
    }
    
    protected function saveToExcel($invoiceVehicleInfo, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penjualan Tahunan Kendaraan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Tahunan Kendaraan');

        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');
        $worksheet->mergeCells('A4:Q4');
        
        $worksheet->getStyle('A1:Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q4')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor');
        $worksheet->setCellValue('A3', 'Laporan Penjualan Tahunan Kendaraan');
        $worksheet->setCellValue('A4', $year);

        $worksheet->getStyle("A6:Q6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:Q6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:Q6')->getFont()->setBold(true);

        $monthList = array(
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        );
        
        $worksheet->setCellValue("A6", 'No');
        $worksheet->setCellValue("B6", 'Car Make');
        $worksheet->setCellValue("C6", 'Car Model');
        $worksheet->setCellValue("D6", 'Car Type');
        $columnCounter = 'E';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::encode($monthList[$month]));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Total');
        $counter = 8;

        $groupTotalSums = array();
        $autoNumber = 1;
        foreach ($invoiceVehicleInfo as $invoiceVehicleCarSubModelInfo) {
            $worksheet->setCellValue("A{$counter}", $autoNumber);
            $worksheet->setCellValue("B{$counter}", $invoiceVehicleCarSubModelInfo['car_make_name']);
            $worksheet->setCellValue("C{$counter}", $invoiceVehicleCarSubModelInfo['car_model_name']);
            $worksheet->setCellValue("D{$counter}", $invoiceVehicleCarSubModelInfo['car_sub_model_name']);
            $totalSum = 0;
            $columnCounter = 'E';
            for ($month = 1; $month <= 12; $month++) {
                $total = isset($invoiceVehicleCarSubModelInfo['totals'][$month]) ? $invoiceVehicleCarSubModelInfo['totals'][$month] : '';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $total);
                $totalSum += $total; 
                if (!isset($groupTotalSums[$month])) {
                    $groupTotalSums[$month] = 0;
                }
                $groupTotalSums[$month] += $total;
                $columnCounter++;
            }
            
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($totalSum));
            $counter++;
            $autoNumber++;
        }
        
        $worksheet->setCellValue("D{$counter}", 'Total');
        $grandTotal = 0;
        $footerCounter = 'E';
        for ($month = 1; $month <= 12; $month++) {
            if (!isset($groupTotalSums[$month])) {
                $groupTotalSums[$month] = 0;
            }
            $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($groupTotalSums[$month]));
            $grandTotal += $groupTotalSums[$month];
            $footerCounter++;
        }
        $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($grandTotal));

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_tahunan_kendaraan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}