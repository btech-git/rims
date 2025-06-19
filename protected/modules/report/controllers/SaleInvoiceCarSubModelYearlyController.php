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
            $invoiceVehicleInfo[$yearlySaleSummaryItem['car_sub_model_id']]['car_sub_model_name'] = $yearlySaleSummaryItem['car_sub_model_id'];
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
    
    protected function saveToExcel($registrationVehicleInfo, $yearMonth) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penyelesaian Pesanan per Kendaraan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penyelesaian per Kendaraan');

        $worksheet->mergeCells('A2:AI2');
        $worksheet->mergeCells('A3:AI3');
        $worksheet->mergeCells('A4:AI4');
        
        $worksheet->getStyle('A1:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G4')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor');
        $worksheet->setCellValue('A3', 'Laporan Penyelesaian Pesanan per Kendaraan');
        $worksheet->setCellValue('A4', Yii::app()->dateFormatter->format('MMMM yyyy', $yearMonth));

        $worksheet->getStyle("A6:G6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:G6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:G6')->getFont()->setBold(true);

        $dateNumList = range(1, 31);
        $columnCounter = 'B';
        foreach ($dateNumList as $dateNum) {
            $worksheet->setCellValue("{$columnCounter}6", $dateNum);
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Total');
        $counter = 8;

        $footerTotalSums = array();
        foreach ($registrationVehicleInfo as $registrationVehicleCarMakeInfo) {
            $groupTotalSums = array();
            $worksheet->setCellValue("A{$counter}", $registrationVehicleCarMakeInfo['name']);
            $counter++;
            foreach ($registrationVehicleCarMakeInfo['car_models'] as $registrationVehicleCarModelInfo) {
                $worksheet->setCellValue("A{$counter}", $registrationVehicleCarModelInfo['name']);
                $totalSum = 0;
                $columnCounter = 'B';
                foreach ($dateNumList as $dateNum) {
                    $transactionDate = $yearMonth . '-' . str_pad($dateNum, 2, '0', STR_PAD_LEFT);
                    $total = isset($registrationVehicleCarModelInfo['totals'][$transactionDate]) ? $registrationVehicleCarModelInfo['totals'][$transactionDate] : '';
                    $worksheet->setCellValue("{$columnCounter}{$counter}", $total);
                    $totalSum += $total; 
                    if (!isset($groupTotalSums[$dateNum])) {
                        $groupTotalSums[$dateNum] = 0;
                    }
                    $groupTotalSums[$dateNum] += $total;
                    $columnCounter++;
                }
                $worksheet->setCellValue("{$columnCounter}{$counter}", $totalSum);
                $counter++;
            }
            
            $worksheet->setCellValue("A{$counter}", 'Total');
            $groupSubTotal = 0;
            $footerCounter = 'B';
            foreach ($dateNumList as $dateNum) {
                if (!isset($footerTotalSums[$dateNum])) {
                    $footerTotalSums[$dateNum] = 0;
                }
                $footerTotalSums[$dateNum] += $groupTotalSums[$dateNum];
                $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($groupTotalSums[$dateNum]));
                $groupSubTotal += $groupTotalSums[$dateNum];
                $footerCounter++;
            }
            $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($groupSubTotal));
            $counter++;

        }
        
        $worksheet->setCellValue("A{$counter}", 'Grand Total');
        $grandTotal = 0;
        $footerCounter = 'B';
        foreach ($dateNumList as $dateNum) {
            $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($footerTotalSums[$dateNum]));
            $grandTotal += $footerTotalSums[$dateNum];
            $footerCounter++;
        }
        $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($grandTotal));

        for ($col = 'A'; $col !== 'CC'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penyelesaian per Kendaraan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}