<?php

class SaleByProductCategoryServiceTypeController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleOrderReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = $year . '-' . $month . '-1';
        $endDate = $year . '-' . $month . '-' . $numberOfDays;
        
        $saleReportByProductCategory = InvoiceHeader::getSaleReportByProductCategory($startDate, $endDate, $branchId);
        $saleReportByServiceType = InvoiceHeader::getSaleReportByServiceType($startDate, $endDate, $branchId);
        $saleReportSummary = InvoiceHeader::getSaleReportSummary($startDate, $endDate, $branchId);
        
        $saleReportData = array();
        foreach ($saleReportByProductCategory as $saleReportItem) {
            $key = $saleReportItem['customer_type'] . '|' . $saleReportItem['transaction_date'] . '|p|' . $saleReportItem['product_master_category_id'];
            $saleReportData[$key] = $saleReportItem['total_price'];
        }
        foreach ($saleReportByServiceType as $saleReportItem) {
            $key = $saleReportItem['customer_type'] . '|' . $saleReportItem['transaction_date'] . '|s|' . $saleReportItem['service_category_id'];
            $saleReportData[$key] = $saleReportItem['total_price'];
        }
        $saleReportSummaryData = array();
        foreach ($saleReportSummary as $saleReportItem) {
            $key = $saleReportItem['customer_type'] . '|' . $saleReportItem['transaction_date'];
            $saleReportSummaryData[$key]['ppn_total'] = $saleReportItem['ppn_total'];
            $saleReportSummaryData[$key]['pph_total'] = $saleReportItem['pph_total'];
            $saleReportSummaryData[$key]['total_price'] = $saleReportItem['total_price'];
            $saleReportSummaryData[$key]['total_product'] = $saleReportItem['total_product'];
            $saleReportSummaryData[$key]['total_service'] = $saleReportItem['total_service'];
        }
        
        $productMasterCategoryList = ProductMasterCategory::model()->findAllByAttributes(array('status' => 'Active'));
        $serviceCategoryList = ServiceCategory::model()->findAllByAttributes(array('status' => 'Active'));
        
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
            $this->saveToExcel($saleReportData, array(
            'branchId' => $branchId,
            'month' => $month,
            'year' => $year,
            'yearList' => $yearList,
            'numberOfDays' => $numberOfDays,
            'saleReportData' => $saleReportData,
            'productMasterCategoryList' => $productMasterCategoryList,
            'serviceCategoryList' => $serviceCategoryList,
            'monthList' => $monthList,
            ));
        }

        $this->render('summary', array(
            'branchId' => $branchId,
            'month' => $month,
            'year' => $year,
            'yearList' => $yearList,
            'numberOfDays' => $numberOfDays,
            'saleReportData' => $saleReportData,
            'productMasterCategoryList' => $productMasterCategoryList,
            'serviceCategoryList' => $serviceCategoryList,
            'saleReportSummaryData' => $saleReportSummaryData,
            'monthList' => $monthList,
        ));
    }

    protected function saveToExcel($saleReportData, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Sale Order');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Service Product');

        $branchId = $options['branchId'];
        $monthList = $options['monthList'];
        $month = $options['month'];
        $year = $options['year'];
        $numberOfDays = $options['numberOfDays'];
        $productMasterCategoryList = $options['productMasterCategoryList'];
        $serviceTypeList = $options['serviceTypeList'];

        $worksheet->mergeCells('A1:R1');
        $worksheet->mergeCells('A2:R2');
        $worksheet->mergeCells('A3:R3');
        $worksheet->mergeCells('A5:E5');

        $worksheet->getStyle('A1:R6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:R6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A2', 'Penjualan Service Product ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A3', $monthList[$month] . ' ' . $year);

        $worksheet->setCellValue('A5', 'Penjualan Retail');
        
        $worksheet->setCellValue('A6', 'Tanggal');
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::value($productMasterCategoryItem, 'name'));
            $columnCounter++;
        }
        foreach ($serviceTypeList as $serviceTypeItem) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::value($serviceTypeItem, 'name'));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Total');
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $rowCounter = 8;
        $totalPriceSums = array();
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $day = str_pad($n, 2, '0', STR_PAD_LEFT);
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $totalPriceSum = '0.00';
            $columnCounter = 'B';
            foreach ($productMasterCategoryList as $productMasterCategoryItem) {
                $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id;
                $totalPrice = isset($saleReportData[$key]) ? $saleReportData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPrice));
                $totalPriceSum += $totalPrice;
                if (!isset($totalPriceSums[$productMasterCategoryItem->id])) {
                    $totalPriceSums[$productMasterCategoryItem->id] = '0.00';
                }
                $totalPriceSums[$productMasterCategoryItem->id] += $totalPrice;
                $columnCounter++;
            }
            foreach ($serviceTypeList as $serviceTypeItem) {
                $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|s|' . $serviceTypeItem->id;
                $totalPrice = isset($saleReportData[$key]) ? $saleReportData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPrice));
                $totalPriceSum += $totalPrice;
                if (!isset($totalPriceSums[$serviceTypeItem->id])) {
                    $totalPriceSums[$serviceTypeItem->id] = '0.00';
                }
                $totalPriceSums[$serviceTypeItem->id] += $totalPrice;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum));
            $rowCounter++;
        }
        
        $grandTotalPrice = '0.00';
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSums[$productMasterCategoryItem->id]));
            $grandTotalPrice += $totalPriceSums[$productMasterCategoryItem->id];
            $columnCounter++;
        }
        foreach ($serviceTypeList as $serviceTypeItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSums[$serviceTypeItem->id]));
            $grandTotalPrice += $totalPriceSums[$serviceTypeItem->id]; 
            $columnCounter++;           
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $grandTotalPrice));
        $rowCounter++;$rowCounter++;$rowCounter++;
        
        $worksheet->mergeCells("A{$rowCounter}:E{$rowCounter}");
        $worksheet->getStyle("A{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$rowCounter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$rowCounter}", 'Penjualan PT');
        $rowCounter++;
        
        $worksheet->setCellValue("A{$rowCounter}", 'Tanggal');
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", CHtml::value($productMasterCategoryItem, 'name'));
            $columnCounter++;
        }
        foreach ($serviceTypeList as $serviceTypeItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", CHtml::value($serviceTypeItem, 'name'));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'Total');
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $rowCounter++;

        $totalPriceSums = array();
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $day = str_pad($n, 2, '0', STR_PAD_LEFT);
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $totalPriceSum = '0.00';
            $columnCounter = 'B';
            foreach ($productMasterCategoryList as $productMasterCategoryItem) {
                $key = 'Company|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id;
                $totalPrice = isset($saleReportData[$key]) ? $saleReportData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPrice));
                $totalPriceSum += $totalPrice;
                if (!isset($totalPriceSums[$productMasterCategoryItem->id])) {
                    $totalPriceSums[$productMasterCategoryItem->id] = '0.00';
                }
                $totalPriceSums[$productMasterCategoryItem->id] += $totalPrice;
                $columnCounter++;
            }
            foreach ($serviceTypeList as $serviceTypeItem) {
                $key = 'Company|' . $year . '-' . $month . '-' . $day . '|s|' . $serviceTypeItem->id;
                $totalPrice = isset($saleReportData[$key]) ? $saleReportData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPrice));
                $totalPriceSum += $totalPrice;
                if (!isset($totalPriceSums[$serviceTypeItem->id])) {
                    $totalPriceSums[$serviceTypeItem->id] = '0.00';
                }
                $totalPriceSums[$serviceTypeItem->id] += $totalPrice;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum));
            $rowCounter++;
        }
        
        $grandTotalPrice = '0.00';
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSums[$productMasterCategoryItem->id]));
            $grandTotalPrice += $totalPriceSums[$productMasterCategoryItem->id];
            $columnCounter++;
        }
        foreach ($serviceTypeList as $serviceTypeItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSums[$serviceTypeItem->id]));
            $grandTotalPrice += $totalPriceSums[$serviceTypeItem->id]; 
            $columnCounter++;           
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $grandTotalPrice));
            
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setWidth(30);;
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan Service Product.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}