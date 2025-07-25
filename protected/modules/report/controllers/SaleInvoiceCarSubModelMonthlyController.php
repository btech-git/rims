<?php

class SaleInvoiceCarSubModelMonthlyController extends Controller {

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
        
        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        
        $invoiceVehicleInfo = array();
        $invoiceVehicleData = InvoiceHeader::getSaleInvoiceCarSubModelMonthlyData($year, $month, $branchId, $carMake, $carModel);
        foreach ($invoiceVehicleData as $invoiceVehicleItem) {
            $invoiceVehicleInfo[$invoiceVehicleItem['car_sub_model_id']]['car_sub_model_id'] = $invoiceVehicleItem['car_sub_model_id'];
            $invoiceVehicleInfo[$invoiceVehicleItem['car_sub_model_id']]['car_model_name'] = $invoiceVehicleItem['car_model_name'];
            $invoiceVehicleInfo[$invoiceVehicleItem['car_sub_model_id']]['car_make_name'] = $invoiceVehicleItem['car_make_name'];
            $invoiceVehicleInfo[$invoiceVehicleItem['car_sub_model_id']]['car_sub_model_name'] = $invoiceVehicleItem['car_sub_model_name'];
            $invoiceVehicleInfo[$invoiceVehicleItem['car_sub_model_id']]['totals'][$invoiceVehicleItem['transaction_date']] = $invoiceVehicleItem['total_quantity_vehicle'];
        }

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($invoiceVehicleInfo, $year, $month);
        }

        $this->render('summary', array(
            'yearList' => $yearList,
            'year' => $year,
            'month' => $month,
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
    
    protected function saveToExcel($invoiceVehicleInfo, $yearMonth) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penjualan Bulanan Kendaraan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Bulanan Kendaraan');

        $worksheet->mergeCells('A2:AI2');
        $worksheet->mergeCells('A3:AI3');
        $worksheet->mergeCells('A4:AI4');
        
        $worksheet->getStyle('A1:AI4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AI4')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor');
        $worksheet->setCellValue('A3', 'Laporan Penjualan Bulanan Kendaraan');
        $worksheet->setCellValue('A4', Yii::app()->dateFormatter->format('MMMM yyyy', $yearMonth));

        $worksheet->getStyle("A6:AI6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:AI6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AI6')->getFont()->setBold(true);

        $worksheet->setCellValue("A6", 'No');
        $worksheet->setCellValue("B6", 'Car Make');
        $worksheet->setCellValue("C6", 'Car Model');
        $worksheet->setCellValue("D6", 'Car Type');
        $dateNumList = range(1, 31);
        $columnCounter = 'E';
        foreach ($dateNumList as $dateNum) {
            $worksheet->setCellValue("{$columnCounter}6", $dateNum);
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
            foreach ($dateNumList as $dateNum) {
                $transactionDate = $yearMonth . '-' . str_pad($dateNum, 2, '0', STR_PAD_LEFT);
                $total = isset($invoiceVehicleCarSubModelInfo['totals'][$transactionDate]) ? $invoiceVehicleCarSubModelInfo['totals'][$transactionDate] : '';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $total);
                $totalSum += $total; 
                if (!isset($groupTotalSums[$dateNum])) {
                    $groupTotalSums[$dateNum] = 0;
                }
                $groupTotalSums[$dateNum] += $total;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $totalSum);
            $columnCounter++;
            $counter++;
            $autoNumber++;
        }
            
        $worksheet->setCellValue("D{$counter}", 'Total');
        $grandTotal = 0;
        $footerCounter = 'E';
        foreach ($dateNumList as $dateNum) {
            if (!isset($groupTotalSums[$dateNum])) {
                $groupTotalSums[$dateNum] = 0;
            }
            $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($groupTotalSums[$dateNum]));
            $grandTotal += $groupTotalSums[$dateNum];
            $footerCounter++;
        }
        $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($grandTotal));
        $counter++;

        for ($col = 'A'; $col !== 'AG'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_bulanan_kendaraan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}