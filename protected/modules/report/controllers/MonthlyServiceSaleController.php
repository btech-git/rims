<?php

class MonthlyServiceSaleController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('monthlyServiceSaleReport') )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $serviceTypeId = (isset($_GET['ServiceTypeId'])) ? $_GET['ServiceTypeId'] : '';
        $serviceCategoryId = (isset($_GET['ServiceCategoryId'])) ? $_GET['ServiceCategoryId'] : '';

        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = $year . '-' . $month . '-1';
        $endDate = $year . '-' . $month . '-' . $numberOfDays;
        
        $monthlyServiceSaleData = InvoiceHeader::getMonthlyServiceSaleData($startDate, $endDate, $branchId, $serviceTypeId, $serviceCategoryId);
        
        $serviceSaleData = array();
        foreach ($monthlyServiceSaleData as $monthlyServiceSaleItem) {
            $serviceSaleData[$monthlyServiceSaleItem['service_id']]['service_name'] = $monthlyServiceSaleItem['service_name'];
            $serviceSaleData[$monthlyServiceSaleItem['service_id']][$monthlyServiceSaleItem['invoice_date']]['total_quantity'] = $monthlyServiceSaleItem['total_quantity'];
            $serviceSaleData[$monthlyServiceSaleItem['service_id']][$monthlyServiceSaleItem['invoice_date']]['total_price'] = $monthlyServiceSaleItem['total_price'];
        }
                
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $monthList =  array(
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        );

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($serviceSaleData, array(
            'branchId' => $branchId,
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
            'monthList' => $monthList,
            ));
        }

        $this->render('summary', array(
            'branchId' => $branchId,
            'month' => $month,
            'year' => $year,
            'yearList' => $yearList,
            'numberOfDays' => $numberOfDays,
            'serviceSaleData' => $serviceSaleData,
            'monthList' => $monthList,
            'serviceTypeId' => $serviceTypeId,
            'serviceCategoryId' => $serviceCategoryId,
        ));
    }

    public function actionAjaxHtmlUpdateServiceCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $serviceTypeId = isset($_GET['ServiceTypeId']) ? $_GET['ServiceTypeId'] : 0;
            $serviceCategoryId = isset($_GET['ServiceCategoryId']) ? $_GET['ServiceCategoryId'] : 0;

            $this->renderPartial('_serviceCategorySelect', array(
                'serviceTypeId' => $serviceTypeId,
                'serviceCategoryId' => $serviceCategoryId,
            ));
        }
    }

    protected function saveToExcel($serviceSaleData, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Jasa Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Jasa Bulanan');

        $branchId = $options['branchId'];
        $monthList = $options['monthList'];
        $month = $options['month'];
        $year = $options['year'];
        $numberOfDays = $options['numberOfDays'];

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Penjualan Jasa Bulanan');
        $worksheet->setCellValue('A3', $monthList[$month] . ' ' . $year);

        $columnHeaderCounter = 'B';
        $mergeColumnCounter = 'C';
        foreach ($serviceSaleData as $serviceSaleItem) {
            $worksheet->mergeCells("{$columnHeaderCounter}5:{$mergeColumnCounter}5");
            $worksheet->setCellValue("{$columnHeaderCounter}5", $serviceSaleItem['service_name']);
            $columnHeaderCounter++;$columnHeaderCounter++;$mergeColumnCounter++;$mergeColumnCounter++;
        }
        $worksheet->mergeCells("{$columnHeaderCounter}5:{$mergeColumnCounter}5");
        $worksheet->setCellValue("{$columnHeaderCounter}5", 'Total');
        
        $columnSubHeaderCounter = 'B';
        foreach ($serviceSaleData as $serviceSaleItem) {
            $worksheet->setCellValue("{$columnSubHeaderCounter}6", 'Quantity');
            $columnSubHeaderCounter++;
            $worksheet->setCellValue("{$columnSubHeaderCounter}6", 'Price');
            $columnSubHeaderCounter++;
        }
        $worksheet->setCellValue("{$columnSubHeaderCounter}6", 'Quantity');
        $columnSubHeaderCounter++;
        $worksheet->setCellValue("{$columnSubHeaderCounter}6", 'Price');
        
        $worksheet->getStyle("A5:{$columnSubHeaderCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnSubHeaderCounter}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A1:{$columnSubHeaderCounter}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:{$columnSubHeaderCounter}6")->getFont()->setBold(true);
        
        $rowCounter = 7;
        $footerQuantities = array();
        $footerPrices = array();
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $quantitySum = '0.00';
            $priceSum = '0.00';
            $columnCounter = 'B';
            foreach ($serviceSaleData as $serviceId => $serviceSaleItem) {
                $day = str_pad($n, 2, '0', STR_PAD_LEFT);
                $date = $year . '-' . $month . '-' . $day;
                $quantity = isset($serviceSaleItem[$date]['total_quantity']) ? $serviceSaleItem[$date]['total_quantity'] : '';
                $price = isset($serviceSaleItem[$date]['total_price']) ? $serviceSaleItem[$date]['total_price'] : '';
                if (isset($serviceSaleItem[$date])) {
                    $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $quantity);
                }
                $columnCounter++;
                if (isset($serviceSaleItem[$date])) {
                    $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $price);
                }
                $columnCounter++;
                $quantitySum += $quantity;
                $priceSum += $price;
                if (!isset($footerQuantities[$serviceId])) {
                    $footerQuantities[$serviceId] = '0.00';
                }
                if (!isset($footerPrices[$serviceId])) {
                    $footerPrices[$serviceId] = '0.00';
                }
                $footerQuantities[$serviceId] += $quantity;
                $footerPrices[$serviceId] += $price;
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $quantitySum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $priceSum);
            $columnCounter++;
            $rowCounter++;
        }
        $worksheet->setCellValue("A{$rowCounter}", 'Total');
        $footerQuantitiesSum = '0.00';
        $footerPricesSum = '0.00';
        $columnFooterCounter = 'B';
        foreach ($serviceSaleData as $serviceId => $serviceSaleItem) {
            $worksheet->setCellValue("{$columnFooterCounter}{$rowCounter}", $footerQuantities[$serviceId]);
            $columnFooterCounter++;
            $worksheet->setCellValue("{$columnFooterCounter}{$rowCounter}", $footerPrices[$serviceId]);
            $columnFooterCounter++;
            $footerQuantitiesSum += $footerQuantities[$serviceId];
            $footerPricesSum += $footerPrices[$serviceId]; 
        }
        $worksheet->setCellValue("{$columnFooterCounter}{$rowCounter}", $footerQuantitiesSum);
        $columnFooterCounter++;
        $worksheet->setCellValue("{$columnFooterCounter}{$rowCounter}", $footerPricesSum);
        
        $worksheet->getStyle("A{$rowCounter}:{$columnFooterCounter}{$rowCounter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$rowCounter}:{$columnFooterCounter}{$rowCounter}")->getFont()->setBold(true);
        
        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setWidth(15);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_jasa_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
