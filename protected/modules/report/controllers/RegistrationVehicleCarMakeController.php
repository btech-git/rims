<?php

class RegistrationVehicleCarMakeController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('workOrderVehicleCarMakeReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $yearMonthNow = date('Y-m');

        $yearMonth = (isset($_GET['YearMonth'])) ? $_GET['YearMonth'] : $yearMonthNow;
        
        $registrationVehicleInfo = array();
        $registrationVehicleData = RegistrationTransaction::getTotalQuantityVehicleCarMakeData($yearMonth);
        foreach ($registrationVehicleData as $registrationVehicleItem) {
            $registrationVehicleInfo[$registrationVehicleItem['car_make_id']]['name'] = $registrationVehicleItem['car_make_name'];
            $registrationVehicleInfo[$registrationVehicleItem['car_make_id']]['car_models'][$registrationVehicleItem['car_model_id']]['name'] = $registrationVehicleItem['car_model_name'];
            $registrationVehicleInfo[$registrationVehicleItem['car_make_id']]['car_models'][$registrationVehicleItem['car_model_id']]['totals'][$registrationVehicleItem['transaction_date']] = $registrationVehicleItem['total_quantity_vehicle'];
        }

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($registrationServiceInfo, $yearMonth);
//        }

        $this->render('summary', array(
            'yearMonthNow' => $yearMonthNow,
            'yearMonth' => $yearMonth,
            'registrationVehicleInfo' => $registrationVehicleInfo,
        ));
    }
    protected function saveToExcel($registrationServiceInfo, $yearMonth) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penyelesaian Pesanan per Pekerjaan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penyelesaian per Pekerjaan');

        $worksheet->mergeCells('A2:AI2');
        $worksheet->mergeCells('A3:AI3');
        $worksheet->mergeCells('A4:AI4');
        
        $worksheet->getStyle('A1:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G4')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor');
        $worksheet->setCellValue('A3', 'Laporan Penyelesaian Pesanan per Pekerjaan');
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
        foreach ($registrationServiceInfo as $registrationServiceItem) {
            $worksheet->setCellValue("A{$counter}", $registrationServiceItem['code']);
            $totalSum = 0;
            $columnCounter = 'B';
            foreach ($dateNumList as $dateNum) {
                $transactionDate = $yearMonth . '-' . str_pad($dateNum, 2, '0', STR_PAD_LEFT);
                $total = isset($registrationServiceItem['totals'][$transactionDate]) ? $registrationServiceItem['totals'][$transactionDate] : '';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $total);
                $totalSum += $total; 
                if (!isset($footerTotalSums[$dateNum])) {
                    $footerTotalSums[$dateNum] = 0;
                }
                $footerTotalSums[$dateNum] += $total;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $totalSum);
            $counter++;
        }
        
        $worksheet->setCellValue("A{$counter}", 'Total');
        $grandTotal = 0;
        $footerCounter = 'B';
        foreach ($dateNumList as $dateNum) {
            if (!isset($footerTotalSums[$dateNum])) {
                $footerTotalSums[$dateNum] = 0;
            }
            $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($footerTotalSums[$dateNum]));
            $grandTotal += $footerTotalSums[$dateNum];
            $footerCounter++;
        }
        $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($grandTotal));

        for ($col = 'A'; $col !== 'AI'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penyelesaian per Pekerjaan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}