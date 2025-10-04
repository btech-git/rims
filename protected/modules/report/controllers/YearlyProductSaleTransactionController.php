<?php

class YearlyProductSaleTransactionController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('customerReceivableReport'))) {
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
        $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : '';
        $productCode = isset($_GET['ProductCode']) ? $_GET['ProductCode'] : '';
        $productName = isset($_GET['ProductName']) ? $_GET['ProductName'] : '';
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $masterCategoryId = (isset($_GET['MasterCategoryId'])) ? $_GET['MasterCategoryId'] : '';
        $subCategoryId = (isset($_GET['SubCategoryId'])) ? $_GET['SubCategoryId'] : '';
        $subMasterCategoryId = (isset($_GET['SubMasterCategoryId'])) ? $_GET['SubMasterCategoryId'] : '';
        
        $yearlyProductSaleTransactionReportData = array();
        $yearlyProductSaleTransactionReport = InvoiceDetail::getYearlyProductSaleTransactionReport($year, $productId, $productCode, $productName, $branchId, $brandId, $subBrandId, $subBrandSeriesId, $masterCategoryId, $subCategoryId, $subMasterCategoryId);
        foreach ($yearlyProductSaleTransactionReport as $reportItem) {
            $monthValue = intval($reportItem['invoice_month']);
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['product_id'] = $reportItem['product_id'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['product_name'] = $reportItem['product_name'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['product_code'] = $reportItem['product_code'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['brand_name'] = $reportItem['brand_name'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['sub_brand_name'] = $reportItem['sub_brand_name'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['sub_brand_series_name'] = $reportItem['sub_brand_series_name'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['master_category_name'] = $reportItem['master_category_name'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['sub_category_name'] = $reportItem['sub_category_name'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['sub_master_category_name'] = $reportItem['sub_master_category_name'];
            $yearlyProductSaleTransactionReportData[$reportItem['product_id']]['totals'][$monthValue] = $reportItem['total_quantity'];
        }

        
        $productIds = array_map(function($reportItem) { return $reportItem['product_id']; }, $yearlyProductSaleTransactionReport);
        
        $inventoryCurrentStocks = InventoryDetail::getInventoryCurrentStocks($productIds, $branchId);
        
        $inventoryCurrentStockData = array();
        foreach ($inventoryCurrentStocks as $inventoryCurrentStockItem) {
            $inventoryCurrentStockData[$inventoryCurrentStockItem['product_id']] = $inventoryCurrentStockItem['total_stock'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($yearlyCustomerReceivableReportData, $year);
//        }
        
        $this->render('summary', array(
            'yearlyProductSaleTransactionReportData' => $yearlyProductSaleTransactionReportData,
            'inventoryCurrentStockData' => $inventoryCurrentStockData,
            'yearList' => $yearList,
            'year' => $year,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'branchId' => $branchId,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'masterCategoryId' => $masterCategoryId,
            'subCategoryId' => $subCategoryId,
            'subMasterCategoryId' => $subMasterCategoryId,
        ));
    }
    
    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';
            $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';

            $this->renderPartial('_productSubBrandSelect', array(
                'brandId' => $brandId,
                'subBrandId' => $subBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';
            $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'subBrandId' => $subBrandId,
                'subBrandSeriesId' => $subBrandSeriesId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $masterCategoryId = isset($_GET['MasterCategoryId']) ? $_GET['MasterCategoryId'] : '';
            $subMasterCategoryId = isset($_GET['SubMasterCategoryId']) ? $_GET['SubMasterCategoryId'] : '';

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'masterCategoryId' => $masterCategoryId,
                'subMasterCategoryId' => $subMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subMasterCategoryId = isset($_GET['SubMasterCategoryId']) ? $_GET['SubMasterCategoryId'] : '';
            $subCategoryId = isset($_GET['SubCategoryId']) ? $_GET['SubCategoryId'] : '';

            $this->renderPartial('_productSubCategorySelect', array(
                'subMasterCategoryId' => $subMasterCategoryId,
                'subCategoryId' => $subCategoryId,
            ));
        }
    }

    protected function saveToExcel($yearlyCustomerReceivableReportData, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
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
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Tahunan');

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        $worksheet->getStyle('A1:AZ6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AZ6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Piutang Customer Tahunan');
        $worksheet->setCellValue('A3', 'Periode Tahun: ' . $year);
        
        $columnCounterStart = 'C';
        $columnCounterEnd = 'E';
        
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->mergeCells("{$columnCounterStart}5:{$columnCounterEnd}5");
            $worksheet->setCellValue("{$columnCounterStart}5", $monthList[$month]);
            ++$columnCounterStart; ++$columnCounterStart; ++$columnCounterStart;
            ++$columnCounterEnd; ++$columnCounterEnd; ++$columnCounterEnd;
        }
        $worksheet->mergeCells("{$columnCounterStart}5:{$columnCounterEnd}5");
        $worksheet->setCellValue("{$columnCounterStart}5", 'TOTAL');
        
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Customer');
        $columnCounter = 'C';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}6", 'Invoice Amount');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Outstanding');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Pelunasan');
            $columnCounter++;
            
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Invoice Amount');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Outstanding');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Pelunasan');
        $columnCounter++;
        
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        $ordinal = 0;
        $invoiceTotalSums = array(); 
        $invoiceOutstandingSums = array();
        $invoicePaymentSums = array();
        
        foreach ($yearlyCustomerReceivableReportData as $customerId => $yearlyCustomerReceivableReportDataItem) {
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", $yearlyCustomerReceivableReportDataItem['customer_name']);
            
            $invoiceTotalSum = 0;
            $invoiceOutstandingSum = 0;
            $invoicePaymentSum = 0; 
            $columnCounter = 'C';
            
            for ($month = 1; $month <= 12; $month++) {
                $invoiceTotal = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_total']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_total'] : '';
                $invoiceOutstanding = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_outstanding']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_outstanding'] : '';
                $invoicePayment = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_payment']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_payment'] : '';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotal);
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceOutstanding);
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoicePayment);
                $columnCounter++;
                
                $invoiceTotalSum += $invoiceTotal;
                $invoiceOutstandingSum += $invoiceOutstanding;
                $invoicePaymentSum += $invoicePayment;
                
                if (!isset($invoiceTotalSums[$month])) {
                    $invoiceTotalSums[$month] = 0;
                }
                $invoiceTotalSums[$month] += $invoiceTotal;
                
                if (!isset($invoiceOutstandingSums[$month])) {
                    $invoiceOutstandingSums[$month] = 0;
                }
                $invoiceOutstandingSums[$month] += $invoiceOutstanding;
                
                if (!isset($invoicePaymentSums[$month])) {
                    $invoicePaymentSums[$month] = 0;
                }
                $invoicePaymentSums[$month] += $invoicePayment;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceOutstandingSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoicePaymentSum);
            $columnCounter++;
            
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:AM{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:AM{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("B{$counter}", 'TOTAL');
        
        $grandTotalInvoice = 0;
        $grandTotalOutstanding = 0;
        $grandTotalPayment = 0;
        
        $columnCounter = 'C';
        for ($month = 1; $month <= 12; $month++) {
            if (!isset($invoiceTotalSums[$month])) {
                $invoiceTotalSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSums[$month]);
            $columnCounter++;
            
            if (!isset($invoiceOutstandingSums[$month])) {
                $invoiceOutstandingSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceOutstandingSums[$month]);
            $columnCounter++;
            
            if (!isset($invoicePaymentSums[$month])) {
                $invoicePaymentSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoicePaymentSums[$month]);
            $columnCounter++;
            
            $grandTotalInvoice += $invoiceTotalSums[$month];
            $grandTotalOutstanding += $invoiceOutstandingSums[$month];
            $grandTotalPayment += $invoicePaymentSums[$month];
        }
        
        $worksheet->setCellValue("{$columnCounter}{$counter}", $grandTotalInvoice);
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$counter}", $grandTotalOutstanding);
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$counter}", $grandTotalPayment);
        $columnCounter++;

        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_customer_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}