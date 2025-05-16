<?php

class CompanySaleByProductCategoryServiceTypeController extends Controller {

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

        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        
        $saleReportByProductCategory = InvoiceHeader::getCompanySaleReportByProductCategory($year, $month);
        $saleReportByServiceType = InvoiceHeader::getCompanySaleReportByServiceType($year, $month);
        $saleReportSummary = InvoiceHeader::getCompanySaleReportSummary($year, $month);
        
        $saleReportData = array();
        foreach ($saleReportByProductCategory as $saleReportItem) {
            if (!isset($saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']])) {
                $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']] = array();
            }
            $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']]['product'][$saleReportItem['product_master_category_id']] = $saleReportItem['total_price'];
        }
        foreach ($saleReportByServiceType as $saleReportItem) {
            if (!isset($saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']])) {
                $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']] = array();
            }
            $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']]['service'][$saleReportItem['service_category_id']] = $saleReportItem['total_price'];
        }
        foreach ($saleReportSummary as $saleReportItem) {
            if (!isset($saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']])) {
                $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']] = array();
            }
            $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']]['ppn_total'] = $saleReportItem['ppn_total'];
            $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']]['pph_total'] = $saleReportItem['pph_total'];
            $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']]['total_price'] = $saleReportItem['total_price'];
            $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']]['total_product'] = $saleReportItem['total_product'];
            $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']]['total_service'] = $saleReportItem['total_service'];
            $saleReportData[$saleReportItem['company_id']][$saleReportItem['branch_id']]['total_discount'] = $saleReportItem['total_discount'];
        }
        
        $productMasterCategoryList = ProductMasterCategory::model()->findAllByAttributes(array('status' => 'Active'));
        $serviceCategoryList = ServiceCategory::model()->findAllByAttributes(array('status' => 'Active'));
        
        $branchList = Branch::model()->findAllByAttributes(array('status' => 'Active'));
        $companyList = Company::model()->findAllByAttributes(array('id' => array(2, 7, 8)));
        
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
            'branchList' => $branchList,
            'month' => $month,
            'year' => $year,
            'yearList' => $yearList,
            'monthList' => $monthList,
            'productMasterCategoryList' => $productMasterCategoryList,
            'serviceCategoryList' => $serviceCategoryList,
            ));
        }

        $this->render('summary', array(
            'branchList' => $branchList,
            'month' => $month,
            'year' => $year,
            'yearList' => $yearList,
            'monthList' => $monthList,
            'saleReportData' => $saleReportData,
            'productMasterCategoryList' => $productMasterCategoryList,
            'serviceCategoryList' => $serviceCategoryList,
            'companyList' => $companyList,
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
        $documentProperties->setTitle('Penjualan Product Service Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Product Service Summary');

        $branchList = $options['branchList'];
        $monthList = $options['monthList'];
        $yearList = $options['yearList'];
        $month = $options['month'];
        $year = $options['year'];
        $productMasterCategoryList = $options['productMasterCategoryList'];
        $serviceCategoryList = $options['serviceCategoryList'];

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        $worksheet->mergeCells('A5:Z5');

        $worksheet->getStyle('A1:AZ6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AZ6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Penjualan Service Type + Product Category Summary');
        $worksheet->setCellValue('A3', $monthList[$month] . ' ' . $year);

        
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
        $productAmountSubTotals = array();
        $serviceAmountSubTotals = array();
        
        $productAmountSumSubTotal = '0.00';
        $serviceAmountSumSubTotal = '0.00';
        $amountSubTotal = '0.00';

        $totalDiscountSubTotal = '0.00';
        $ppnTotalSubTotal = '0.00';
        $pphTotalSubTotal = '0.00';
        $totalPriceSubTotal = '0.00';
        $totalProductSubTotal = '0.00';
        $totalServiceSubTotal = '0.00';
        foreach ($branchList as $branchItem) {
            $worksheet->setCellValue("A{$rowCounter}", CHtml::value($branchItem, 'code'));
            $worksheet->getStyle("A{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $columnCounter = 'B';
            
            $productAmountSum = '0.00';
            foreach ($productMasterCategoryList as $productMasterCategoryItem) {
                $productAmount = '0.00';
                if (isset($saleReportData[$branchItem->company->id][$branchItem->id]['product'][$productMasterCategoryItem->id])) {
                    $productAmount = $saleReportData[$branchItem->company->id][$branchItem->id]['product'][$productMasterCategoryItem->id];
                }
                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $productAmount);
                $productAmountSum += $productAmount;
                if (!isset($productAmountSubTotals[$productMasterCategoryItem->id])) {
                    $productAmountSubTotals[$productMasterCategoryItem->id] = '0.00';
                }
                $productAmountSubTotals[$productMasterCategoryItem->id] += $productAmount;
                $columnCounter++;
            }
            
            $serviceAmountSum = '0.00';
            foreach ($serviceCategoryList as $serviceCategoryItem) {
                $serviceAmount = '0.00';
                if (isset($saleReportData[$branchItem->company->id][$branchItem->id]['service'][$serviceCategoryItem->id])) {
                    $serviceAmount = $saleReportData[$branchItem->company->id][$branchItem->id]['service'][$serviceCategoryItem->id];
                }

                $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $serviceAmount);
                $serviceAmountSum += $serviceAmount;
                if (!isset($serviceAmountSubTotals[$serviceCategoryItem->id])) {
                    $serviceAmountSubTotals[$serviceCategoryItem->id] = '0.00';
                }
                $serviceAmountSubTotals[$serviceCategoryItem->id] += $serviceAmount;
                $columnCounter++;
            }
            
            $amountSum = $productAmountSum + $serviceAmountSum; 
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $productAmountSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $serviceAmountSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $amountSum);
            $columnCounter++;
            
            $productAmountSumSubTotal += $productAmountSum;
            $serviceAmountSumSubTotal += $serviceAmountSum;
            $amountSubTotal += $amountSum;

            $totalDiscount = '0.00';
            if (isset($saleReportData[$branchItem->company->id][$branchItem->id]['total_discount'])) {
                $totalDiscount = $saleReportData[$branchItem->company->id][$branchItem->id]['total_discount'];
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalDiscount);
            $totalDiscountSubTotal += $totalDiscount;
            $columnCounter++;

            $ppnTotal = '0.00';
            if (isset($saleReportData[$branchItem->company->id][$branchItem->id]['ppn_total'])) {
                $ppnTotal = $saleReportData[$branchItem->company->id][$branchItem->id]['ppn_total'];
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $ppnTotal);
            $ppnTotalSubTotal += $ppnTotal;
            $columnCounter++;
            
            $pphTotal = '0.00';
            if (isset($saleReportData[$branchItem->company->id][$branchItem->id]['pph_total'])) {
                $pphTotal = $saleReportData[$branchItem->company->id][$branchItem->id]['pph_total'];
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $pphTotal);
            $pphTotalSubTotal += $pphTotal;
            $columnCounter++;
            
            $totalPrice = '0.00';
            if (isset($saleReportData[$branchItem->company->id][$branchItem->id]['total_price'])) {
                $totalPrice = $saleReportData[$branchItem->company->id][$branchItem->id]['total_price'];
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalPrice);
            $totalPriceSubTotal += $totalPrice;
            $columnCounter++;
            
            $totalProduct = '0.00';
            if (isset($saleReportData[$branchItem->company->id][$branchItem->id]['total_product'])){
                $totalProduct = $saleReportData[$branchItem->company->id][$branchItem->id]['total_product'];
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalProduct);
            $totalProductSubTotal += $totalProduct;
            $columnCounter++;
            
            $totalService = '0.00';
            if (isset($saleReportData[$branchItem->company->id][$branchItem->id]['total_service'])) {
                $totalService = $saleReportData[$branchItem->company->id][$branchItem->id]['total_service'];
            }
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalService);
            $totalServiceSubTotal += $totalService;
            $columnCounter++;
            
            $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $rowCounter++;
        }
        
        $columnCounter = 'B';
        foreach ($productMasterCategoryList as $productMasterCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $productAmountSubTotals[$productMasterCategoryItem->id]);
            $columnCounter++;
        }
        foreach ($serviceCategoryList as $serviceCategoryItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $serviceAmountSubTotals[$serviceCategoryItem->id]);
            $columnCounter++;           
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $productAmountSumSubTotal);
        $columnCounter++;  
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $serviceAmountSumSubTotal);
        $columnCounter++;  
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $amountSubTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalDiscountSubTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $ppnTotalSubTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $pphTotalSubTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalPriceSubTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalProductSubTotal);
        $columnCounter++;   
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $totalServiceSubTotal);
        $columnCounter++;   
        $worksheet->getStyle("A{$rowCounter}:{$columnCounter}{$rowCounter}")->getFont()->setBold(true);
        $worksheet->getStyle("B{$rowCounter}:{$columnCounter}{$rowCounter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $rowCounter++;$rowCounter++;$rowCounter++;
        
        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setWidth(15);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan Service Product Summary.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
