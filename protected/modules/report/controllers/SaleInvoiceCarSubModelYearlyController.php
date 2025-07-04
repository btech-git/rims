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

        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');
        $worksheet->mergeCells('A4:P4');
        
        $worksheet->getStyle('A1:P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P4')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor');
        $worksheet->setCellValue('A3', 'Laporan Penjualan Tahunan Kendaraan');
        $worksheet->setCellValue('A4', $year);

        $worksheet->getStyle("A6:P6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:P6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:P6')->getFont()->setBold(true);

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
        
        $columnCounter = 'D';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::encode($monthList[$month]));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Total');
        $counter = 8;

        $groupTotalSums = array();
        foreach ($invoiceVehicleInfo as $invoiceVehicleCarSubModelInfo) {
            $worksheet->setCellValue("A{$counter}", $invoiceVehicleCarSubModelInfo['car_make_name']);
            $worksheet->setCellValue("B{$counter}", $invoiceVehicleCarSubModelInfo['car_model_name']);
            $worksheet->setCellValue("C{$counter}", $invoiceVehicleCarSubModelInfo['car_sub_model_name']);
            $totalSum = 0;
            $columnCounter = 'D';
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
        }
        
        $worksheet->setCellValue("A{$counter}", 'Total');
        $grandTotal = 0;
        $footerCounter = 'D';
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