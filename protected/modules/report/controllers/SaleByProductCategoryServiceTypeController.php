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
            if (!(Yii::app()->user->checkAccess('saleServiceProductCategoryReport') )) {
                $this->redirect(array('/site/login'));
            }
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
            $saleReportSummaryData[$key]['total_discount'] = $saleReportItem['total_discount'];
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
            'saleReportSummaryData' => $saleReportSummaryData,
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
        $serviceCategoryList = $options['serviceCategoryList'];
        $saleReportSummaryData = $options['saleReportSummaryData'];

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        $worksheet->mergeCells('A5:Z5');

        $worksheet->getStyle('A1:AZ6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AZ6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan Service Type + Product Category');
        $worksheet->setCellValue('A3', $monthList[$month] . ' ' . $year);

        $worksheet->setCellValue('A5', 'Penjualan Retail');
        
        $worksheet->setCellValue('A6', 'Tanggal');
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::value($productMasterCategoryItem, 'name'));
            $columnCounter++;
        }
        foreach ($serviceCategoryList as $serviceCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::value($serviceCategoryItem, 'name'));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}6", 'DPP');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'PPn');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'PPh');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Total');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Qty Product');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Qty Service');
        $columnCounter++;
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounter}6")->getFont()->setBold(true);
        $worksheet->getStyle("A6:{$columnCounter}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $rowCounter = 8;
        $dppSums = array();
        $ppnTotalSum = '0.00';
        $pphTotalSum = '0.00';
        $totalPriceSum = '0.00';
        $totalProductSum = '0.00';
        $totalServiceSum = '0.00';
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $day = str_pad($n, 2, '0', STR_PAD_LEFT);
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $worksheet->getStyle("A{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $dppSum = '0.00';
            $columnCounter = 'B';
            foreach ($productMasterCategoryList as $productMasterCategoryItem) {
                $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id;
                $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dpp));
                $dppSum += $dpp;
                if (!isset($dppSums['p' . $productMasterCategoryItem->id])) {
                    $dppSums['p' . $productMasterCategoryItem->id] = '0.00';
                }
                $dppSums['p' . $productMasterCategoryItem->id] += $dpp;
                $columnCounter++;
            }
            foreach ($serviceCategoryList as $serviceCategoryItem) {
                $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|s|' . $serviceCategoryItem->id;
                $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; 
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dpp));
                $dppSum += $dpp;
                if (!isset($dppSums['s' . $serviceCategoryItem->id])) {
                    $dppSums['s' . $serviceCategoryItem->id] = '0.00';
                }
                $dppSums['s' . $serviceCategoryItem->id] += $dpp;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dppSum));
            $columnCounter++;
            $key = 'Individual|' . $year . '-' . $month . '-' . $day;
            $ppnTotal = isset($saleReportSummaryData[$key]['ppn_total']) ? $saleReportSummaryData[$key]['ppn_total'] : ''; 
            $pphTotal = isset($saleReportSummaryData[$key]['pph_total']) ? $saleReportSummaryData[$key]['pph_total'] : ''; 
            $totalPrice = isset($saleReportSummaryData[$key]['total_price']) ? $saleReportSummaryData[$key]['total_price'] : '';
            $totalProduct = isset($saleReportSummaryData[$key]['total_product']) ? $saleReportSummaryData[$key]['total_product'] : '';
            $totalService = isset($saleReportSummaryData[$key]['total_service']) ? $saleReportSummaryData[$key]['total_service'] : '';
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $ppnTotal));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $pphTotal));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPrice));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalProduct));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalService));
            $columnCounter++;
            $ppnTotalSum += $ppnTotal;
            $pphTotalSum += $pphTotal;
            $totalPriceSum += $totalPrice;
            $totalProductSum += $totalProduct;
            $totalServiceSum += $totalService;
            $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $rowCounter++;
        }
        
        $columnCounter = 'B';
        $dppSumTotal = '0.00';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dppSums['p' . $productMasterCategoryItem->id]));
            $dppSumTotal += $dppSums['p' . $productMasterCategoryItem->id];
            $columnCounter++;
        }
        foreach ($serviceCategoryList as $serviceCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dppSums['s' . $serviceCategoryItem->id]));
            $dppSumTotal += $dppSums['s' . $serviceCategoryItem->id];
            $columnCounter++;           
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dppSumTotal));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $ppnTotalSum));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $pphTotalSum));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalProductSum));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSum));
        $columnCounter++;   
        $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $rowCounter++;$rowCounter++;$rowCounter++;
        
        $worksheet->mergeCells("A{$rowCounter}:{$columnCounter}{$rowCounter}");
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
        foreach ($serviceCategoryList as $serviceCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", CHtml::value($serviceCategoryItem, 'name'));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'DPP');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'PPn');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'PPh');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'Total');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'Qty Product');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'Qty Service');
        $columnCounter++;   
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $rowCounter++;

        $dppSums = array();
        $ppnTotalSum = '0.00';
        $pphTotalSum = '0.00';
        $totalPriceSum = '0.00';
        $totalProductSum = '0.00';
        $totalServiceSum = '0.00';
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $day = str_pad($n, 2, '0', STR_PAD_LEFT);
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $worksheet->getStyle("A{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $dppSum = '0.00';
            $columnCounter = 'B';
            foreach ($productMasterCategoryList as $productMasterCategoryItem) {
                $key = 'Company|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id;
                $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dpp));
                $dppSum += $dpp;
                if (!isset($dppSums['p' . $productMasterCategoryItem->id])) {
                    $dppSums['p' . $productMasterCategoryItem->id] = '0.00';
                }
                $dppSums['p' . $productMasterCategoryItem->id] += $dpp;
                $columnCounter++;
            }
            foreach ($serviceCategoryList as $serviceCategoryItem) {
                $key = 'Company|' . $year . '-' . $month . '-' . $day . '|s|' . $serviceCategoryItem->id;
                $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; 
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dpp));
                $dppSum += $dpp;
                if (!isset($dppSums['s' . $serviceCategoryItem->id])) {
                    $dppSums['s' . $serviceCategoryItem->id] = '0.00';
                }
                $dppSums['s' . $serviceCategoryItem->id] += $dpp;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dppSum));
            $columnCounter++;
            $key = 'Company|' . $year . '-' . $month . '-' . $day;
            $ppnTotal = isset($saleReportSummaryData[$key]['ppn_total']) ? $saleReportSummaryData[$key]['ppn_total'] : ''; 
            $pphTotal = isset($saleReportSummaryData[$key]['pph_total']) ? $saleReportSummaryData[$key]['pph_total'] : ''; 
            $totalPrice = isset($saleReportSummaryData[$key]['total_price']) ? $saleReportSummaryData[$key]['total_price'] : '';
            $totalProduct = isset($saleReportSummaryData[$key]['total_product']) ? $saleReportSummaryData[$key]['total_product'] : '';
            $totalService = isset($saleReportSummaryData[$key]['total_service']) ? $saleReportSummaryData[$key]['total_service'] : '';
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $ppnTotal));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $pphTotal));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPrice));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalProduct));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalService));
            $columnCounter++;
            $ppnTotalSum += $ppnTotal;
            $pphTotalSum += $pphTotal;
            $totalPriceSum += $totalPrice;
            $totalProductSum += $totalProduct;
            $totalServiceSum += $totalService;
            $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $rowCounter++;
        }
        
        $dppSumTotal = '0.00';
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dppSums['p' . $productMasterCategoryItem->id]));
            $dppSumTotal += $dppSums['p' . $productMasterCategoryItem->id];
            $columnCounter++;
        }
        foreach ($serviceCategoryList as $serviceCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dppSums['s' . $serviceCategoryItem->id]));
            $dppSumTotal += $dppSums['s' . $serviceCategoryItem->id];
            $columnCounter++;           
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $dppSumTotal));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $ppnTotalSum));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $pphTotalSum));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalProductSum));
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSum));
        $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setWidth(15);
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
