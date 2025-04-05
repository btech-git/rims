<?php

class SaleByServiceMonthlyController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
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
        $categoryId = isset($_GET['CategoryId']) ? $_GET['CategoryId'] : 1;
        $typeId = isset($_GET['TypeId']) ? $_GET['TypeId'] : 1;

        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = $year . '-' . $month . '-1';
        $endDate = $year . '-' . $month . '-' . $numberOfDays;
        
        $saleReportByService = InvoiceHeader::getSaleReportByService($startDate, $endDate, $branchId, $categoryId, $typeId);
        $saleReportSummary = InvoiceHeader::getSaleReportSummaryAll($startDate, $endDate, $branchId);
        
        $salePriceReportData = array();
        $saleQuantityReportData = array();
        foreach ($saleReportByService as $saleReportItem) {
            $key = $saleReportItem['transaction_date'] . '|s|' . $saleReportItem['service_id'];
            $salePriceReportData[$key] = $saleReportItem['total_price'];
            $saleQuantityReportData[$key] = $saleReportItem['total_quantity'];
        }
        $saleReportSummaryData = array();
        foreach ($saleReportSummary as $saleReportItem) {
            $key = $saleReportItem['transaction_date'];
            $saleReportSummaryData[$key]['total_price'] = $saleReportItem['total_price'];
            $saleReportSummaryData[$key]['total_quantity'] = $saleReportItem['total_product'];
        }
        
        $categoryConditionSql = '';
        $typeConditionSql = '';
        
        $params = array();
        
        if (!empty($categoryId)) {
            $categoryConditionSql = ' AND t.service_category_id = :service_category_id';
            $params[':service_category_id'] = $categoryId;
        }

        if (!empty($typeId)) {
            $typeConditionSql = ' AND t.service_type_id = :service_type_id';
            $params[':service_type_id'] = $typeId;
        }

        $criteria = new CDbCriteria;
        $criteria->condition = "t.status = 'Active'" . $categoryConditionSql . $typeConditionSql;
        $criteria->params = $params;
        $serviceList = Service::model()->findAll($criteria);
        
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
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($saleReportData, $saleReportAllData, array(
//            'branchId' => $branchId,
//            'month' => $month,
//            'year' => $year,
//            'yearList' => $yearList,
//            'numberOfDays' => $numberOfDays,
//            'productMasterCategoryList' => $productMasterCategoryList,
//            'serviceCategoryList' => $serviceCategoryList,
//            'saleReportSummaryData' => $saleReportSummaryData,
//            'saleReportSummaryAllData' => $saleReportSummaryData,
//            'monthList' => $monthList,
//            ));
//        }

        $this->render('summary', array(
            'branchId' => $branchId,
            'categoryId' => $categoryId,
            'typeId' => $typeId,
            'month' => $month,
            'year' => $year,
            'yearList' => $yearList,
            'numberOfDays' => $numberOfDays,
            'serviceList' => $serviceList,
            'salePriceReportData' => $salePriceReportData,
            'saleQuantityReportData' => $saleQuantityReportData,
            'saleReportSummaryData' => $saleReportSummaryData,
            'monthList' => $monthList,
        ));
    }

    public function actionAjaxHtmlUpdateServiceCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $categoryId = isset($_GET['CategoryId']) ? $_GET['CategoryId'] : '';
            $typeId = isset($_GET['TypeId']) ? $_GET['TypeId'] : '';

            $this->renderPartial('_serviceCategorySelect', array(
                'categoryId' => $categoryId,
                'typeId' => $typeId,
            ));
        }
    }

    protected function saveToExcel($saleReportData, $saleReportAllData, array $options = array()) {
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
        $saleReportSummaryAllData = $options['saleReportSummaryAllData'];

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
        $worksheet->setCellValue("{$columnCounter}6", 'DPP Product');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'DPP Service');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'DPP Total');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Disc');
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
        $discountTotalSum = '0.00';
        $ppnTotalSum = '0.00';
        $pphTotalSum = '0.00';
        $totalPriceSum = '0.00';
        $totalProductSum = '0.00';
        $totalServiceSum = '0.00';
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $day = str_pad($n, 2, '0', STR_PAD_LEFT);
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $worksheet->getStyle("A{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $dppProductSum = '0.00';
            $dppServiceSum = '0.00';
            $dppSum = '0.00';
            $columnCounter = 'B';
            foreach ($productMasterCategoryList as $productMasterCategoryItem) {
                $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id;
                $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dpp);
                $dppProductSum += $dpp;
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
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dpp);
                $dppServiceSum += $dpp;
                $dppSum += $dpp;
                if (!isset($dppSums['s' . $serviceCategoryItem->id])) {
                    $dppSums['s' . $serviceCategoryItem->id] = '0.00';
                }
                $dppSums['s' . $serviceCategoryItem->id] += $dpp;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppProductSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppServiceSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSum);
            $columnCounter++;
            $key = 'Individual|' . $year . '-' . $month . '-' . $day;
            $discountTotal = isset($saleReportSummaryData[$key]['total_discount']) ? $saleReportSummaryData[$key]['total_discount'] : '';
            $ppnTotal = isset($saleReportSummaryData[$key]['ppn_total']) ? $saleReportSummaryData[$key]['ppn_total'] : ''; 
            $pphTotal = isset($saleReportSummaryData[$key]['pph_total']) ? $saleReportSummaryData[$key]['pph_total'] : ''; 
            $totalPrice = isset($saleReportSummaryData[$key]['total_price']) ? $saleReportSummaryData[$key]['total_price'] : '';
            $totalProduct = isset($saleReportSummaryData[$key]['total_product']) ? $saleReportSummaryData[$key]['total_product'] : '';
            $totalService = isset($saleReportSummaryData[$key]['total_service']) ? $saleReportSummaryData[$key]['total_service'] : '';
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $discountTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $ppnTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $pphTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalPrice);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalProduct);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalService);
            $columnCounter++;
            $discountTotalSum += $discountTotal;
            $ppnTotalSum += $ppnTotal;
            $pphTotalSum += $pphTotal;
            $totalPriceSum += $totalPrice;
            $totalProductSum += $totalProduct;
            $totalServiceSum += $totalService;
            $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $rowCounter++;
        }
        
        $columnCounter = 'B';
        $dppProductSumTotal = '0.00';
        $dppServiceSumTotal = '0.00';
        $dppSumTotal = '0.00';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSums['p' . $productMasterCategoryItem->id]);
            $dppProductSumTotal += $dppSums['p' . $productMasterCategoryItem->id];
            $dppSumTotal += $dppSums['p' . $productMasterCategoryItem->id];
            $columnCounter++;
        }
        foreach ($serviceCategoryList as $serviceCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSums['s' . $serviceCategoryItem->id]);
            $dppServiceSumTotal += $dppSums['s' . $serviceCategoryItem->id]; 
            $dppSumTotal += $dppSums['s' . $serviceCategoryItem->id];
            $columnCounter++;           
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppProductSumTotal);
        $columnCounter++;  
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppServiceSumTotal);
        $columnCounter++;  
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSumTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $discountTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $ppnTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $pphTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalPriceSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalProductSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalServiceSum);
        $columnCounter++;   
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getFont()->setBold(true);
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
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'DPP Product');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'DPP Service');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'DPP Total');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'Disc');
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
        $discountTotalSum = '0.00';
        $ppnTotalSum = '0.00';
        $pphTotalSum = '0.00';
        $totalPriceSum = '0.00';
        $totalProductSum = '0.00';
        $totalServiceSum = '0.00';
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $day = str_pad($n, 2, '0', STR_PAD_LEFT);
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $worksheet->getStyle("A{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $dppProductSum = '0.00';
            $dppServiceSum = '0.00';
            $dppSum = '0.00';
            $columnCounter = 'B';
            foreach ($productMasterCategoryList as $productMasterCategoryItem) {
                $key = 'Company|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id;
                $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dpp);
                $dppProductSum += $dpp;
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
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dpp);
                $dppServiceSum += $dpp;
                $dppSum += $dpp;
                if (!isset($dppSums['s' . $serviceCategoryItem->id])) {
                    $dppSums['s' . $serviceCategoryItem->id] = '0.00';
                }
                $dppSums['s' . $serviceCategoryItem->id] += $dpp;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppProductSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppServiceSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSum);
            $columnCounter++;
            $key = 'Company|' . $year . '-' . $month . '-' . $day;
            $discountTotal = isset($saleReportSummaryData[$key]['total_discount']) ? $saleReportSummaryData[$key]['total_discount'] : '';
            $ppnTotal = isset($saleReportSummaryData[$key]['ppn_total']) ? $saleReportSummaryData[$key]['ppn_total'] : ''; 
            $pphTotal = isset($saleReportSummaryData[$key]['pph_total']) ? $saleReportSummaryData[$key]['pph_total'] : ''; 
            $totalPrice = isset($saleReportSummaryData[$key]['total_price']) ? $saleReportSummaryData[$key]['total_price'] : '';
            $totalProduct = isset($saleReportSummaryData[$key]['total_product']) ? $saleReportSummaryData[$key]['total_product'] : '';
            $totalService = isset($saleReportSummaryData[$key]['total_service']) ? $saleReportSummaryData[$key]['total_service'] : '';
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $discountTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $ppnTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $pphTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalPrice);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalProduct);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalService);
            $columnCounter++;
            $discountTotalSum += $discountTotal;
            $ppnTotalSum += $ppnTotal;
            $pphTotalSum += $pphTotal;
            $totalPriceSum += $totalPrice;
            $totalProductSum += $totalProduct;
            $totalServiceSum += $totalService;
            $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $rowCounter++;
        }
        
        $dppProductSumTotal = '0.00';
        $dppServiceSumTotal = '0.00';
        $dppSumTotal = '0.00';
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSums['p' . $productMasterCategoryItem->id]);
            $dppProductSumTotal += $dppSums['p' . $productMasterCategoryItem->id];
            $dppSumTotal += $dppSums['p' . $productMasterCategoryItem->id];
            $columnCounter++;
        }
        foreach ($serviceCategoryList as $serviceCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSums['s' . $serviceCategoryItem->id]);
            $dppServiceSumTotal += $dppSums['s' . $serviceCategoryItem->id]; 
            $dppSumTotal += $dppSums['s' . $serviceCategoryItem->id];
            $columnCounter++;           
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppProductSumTotal);
        $columnCounter++;  
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppServiceSumTotal);
        $columnCounter++;  
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSumTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $discountTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $ppnTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $pphTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalPriceSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalProductSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalServiceSum);
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getFont()->setBold(true);
        $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $rowCounter++;$rowCounter++;$rowCounter++;
            
        $worksheet->mergeCells("A{$rowCounter}:{$columnCounter}{$rowCounter}");
        $worksheet->getStyle("A{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$rowCounter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$rowCounter}", 'Penjualan ALL');
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
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'DPP Product');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'DPP Service');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'DPP Total');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", 'Disc');
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
        $discountTotalSum = '0.00';
        $ppnTotalSum = '0.00';
        $pphTotalSum = '0.00';
        $totalPriceSum = '0.00';
        $totalProductSum = '0.00';
        $totalServiceSum = '0.00';
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $day = str_pad($n, 2, '0', STR_PAD_LEFT);
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $worksheet->getStyle("A{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $dppProductSum = '0.00';
            $dppServiceSum = '0.00';
            $dppSum = '0.00';
            $columnCounter = 'B';
            foreach ($productMasterCategoryList as $productMasterCategoryItem) {
                $key = $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id;
                $dpp = isset($saleReportAllData[$key]) ? $saleReportAllData[$key] : '';
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dpp);
                $dppProductSum += $dpp;
                $dppSum += $dpp;
                if (!isset($dppSums['p' . $productMasterCategoryItem->id])) {
                    $dppSums['p' . $productMasterCategoryItem->id] = '0.00';
                }
                $dppSums['p' . $productMasterCategoryItem->id] += $dpp;
                $columnCounter++;
            }
            foreach ($serviceCategoryList as $serviceCategoryItem) {
                $key = $year . '-' . $month . '-' . $day . '|s|' . $serviceCategoryItem->id;
                $dpp = isset($saleReportAllData[$key]) ? $saleReportAllData[$key] : ''; 
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dpp);
                $dppServiceSum += $dpp;
                $dppSum += $dpp;
                if (!isset($dppSums['s' . $serviceCategoryItem->id])) {
                    $dppSums['s' . $serviceCategoryItem->id] = '0.00';
                }
                $dppSums['s' . $serviceCategoryItem->id] += $dpp;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppProductSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppServiceSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSum);
            $columnCounter++;
            $key = $year . '-' . $month . '-' . $day;
            $discountTotal = isset($saleReportSummaryAllData[$key]['total_discount']) ? $saleReportSummaryAllData[$key]['total_discount'] : '';
            $ppnTotal = isset($saleReportSummaryAllData[$key]['ppn_total']) ? $saleReportSummaryAllData[$key]['ppn_total'] : ''; 
            $pphTotal = isset($saleReportSummaryAllData[$key]['pph_total']) ? $saleReportSummaryAllData[$key]['pph_total'] : ''; 
            $totalPrice = isset($saleReportSummaryAllData[$key]['total_price']) ? $saleReportSummaryAllData[$key]['total_price'] : '';
            $totalProduct = isset($saleReportSummaryAllData[$key]['total_product']) ? $saleReportSummaryAllData[$key]['total_product'] : '';
            $totalService = isset($saleReportSummaryAllData[$key]['total_service']) ? $saleReportSummaryAllData[$key]['total_service'] : '';
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $discountTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $ppnTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $pphTotal);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalPrice);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalProduct);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalService);
            $columnCounter++;
            $discountTotalSum += $discountTotal;
            $ppnTotalSum += $ppnTotal;
            $pphTotalSum += $pphTotal;
            $totalPriceSum += $totalPrice;
            $totalProductSum += $totalProduct;
            $totalServiceSum += $totalService;
            $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $rowCounter++;
        }
        
        $dppProductSumTotal = '0.00';
        $dppServiceSumTotal = '0.00';
        $dppSumTotal = '0.00';
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSums['p' . $productMasterCategoryItem->id]);
            $dppProductSumTotal += $dppSums['p' . $productMasterCategoryItem->id];
            $dppSumTotal += $dppSums['p' . $productMasterCategoryItem->id];
            $columnCounter++;
        }
        foreach ($serviceCategoryList as $serviceCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSums['s' . $serviceCategoryItem->id]);
            $dppServiceSumTotal += $dppSums['s' . $serviceCategoryItem->id]; 
            $dppSumTotal += $dppSums['s' . $serviceCategoryItem->id];
            $columnCounter++;           
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppProductSumTotal);
        $columnCounter++;  
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppServiceSumTotal);
        $columnCounter++;  
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $dppSumTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $discountTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $ppnTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $pphTotalSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalPriceSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalProductSum);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalServiceSum);
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getFont()->setBold(true);
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
