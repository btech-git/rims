<?php

class MonthlyTireCustomerSaleTransactionController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'check' || 
            $filterChain->action->id === 'detail'
        ) {
            if (!(Yii::app()->user->checkAccess('saleTireDailyReport'))) {
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
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $productSubCategoryId = isset($_GET['ProductSubCategoryId']) ? $_GET['ProductSubCategoryId'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $month = $monthNow;
            $year = $yearNow;
            $customerName = '';
            $productSubCategoryId = '';
        }
        
        $productSubCategoryIds = array();
        if (empty($productSubCategoryId)) {
            array_push($productSubCategoryIds, 442, 443, 444);
        } else {
            $productSubCategoryIds[] = intval($productSubCategoryId);
        }
        
        $monthlyTireCustomerSaleTransactionReport = InvoiceDetail::getMonthlyTireCustomerSaleTransactionReport($year, $month, $customerName, $productSubCategoryIds);
        
        $monthlyTireCustomerSaleTransactionReportData = array();
        foreach ($monthlyTireCustomerSaleTransactionReport as $monthlyTireCustomerSaleTransactionReportItem) {
            $monthlyTireCustomerSaleTransactionReportData[$monthlyTireCustomerSaleTransactionReportItem['customer_id']]['customer_name'] = $monthlyTireCustomerSaleTransactionReportItem['customer_name'];
            $monthlyTireCustomerSaleTransactionReportData[$monthlyTireCustomerSaleTransactionReportItem['customer_id']][$monthlyTireCustomerSaleTransactionReportItem['branch_id']] = $monthlyTireCustomerSaleTransactionReportItem['sale_quantity'];
        }
        
        $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($monthlyTireCustomerSaleTransactionReportData, $branches, $year, $month);
        }

        $this->render('summary', array(
            'yearList' => $yearList,
            'year' => $year,
            'yearNow' => $yearNow,
            'month' => $month,
            'branches' => $branches,
            'customerName' => $customerName,
            'productSubCategoryId' => $productSubCategoryId,
            'monthlyTireCustomerSaleTransactionReportData' => $monthlyTireCustomerSaleTransactionReportData,
        ));
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    public function actionTransactionInfo($productId, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceDetail::model()->searchByTransactionInfo($productId, $startDate, $endDate, $branchId, $page);
        $product = Product::model()->findByPk($productId);
        $branch = Branch::model()->findByPk($branchId);
        
        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'product' => $product,
            'branch' => $branch,
        ));
    }

    protected function saveToExcel($monthlyTireCustomerSaleTransactionReportData, $branches, $year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Ban Contract Service');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Ban Contract Service');

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Penjualan Ban Contract Service');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' - ' . $year);

        $columnHeader = 'C';
        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Name');
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnHeader}5", CHtml::value($branch, 'code'));
            $columnHeader++;
        }
        $worksheet->setCellValue("{$columnHeader}5", 'Total');

        $worksheet->mergeCells("A1:{$columnHeader}1");
        $worksheet->mergeCells("A2:{$columnHeader}2");
        $worksheet->mergeCells("A3:{$columnHeader}3");
        
        $worksheet->getStyle("A1:{$columnHeader}5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:{$columnHeader}5")->getFont()->setBold(true);
        $worksheet->getStyle("A5:{$columnHeader}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$columnHeader}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        
        $groupTotalSums = array();
        foreach ($monthlyTireCustomerSaleTransactionReportData as $customerId => $dataItem) {
            $totalQuantity = 0;
            $column = 'C'; 
            
            $worksheet->setCellValue("A{$counter}", $customerId);
            $worksheet->setCellValue("B{$counter}", $dataItem['customer_name']);
            
            foreach ($branches as $branch) {
                $saleQuantity = isset($dataItem[$branch->id]) ? $dataItem[$branch->id] : 0;
                $worksheet->setCellValue("{$column}{$counter}", $saleQuantity);
                $column++;

                $totalQuantity += $saleQuantity;
                if (!isset($groupTotalSums[$branch->id])) {
                    $groupTotalSums[$branch->id] = 0;
                }
                $groupTotalSums[$branch->id] += $saleQuantity;
            }
            
            $worksheet->setCellValue("{$column}{$counter}", $totalQuantity);
            $counter++;
        }
        
        $worksheet->setCellValue("G{$counter}", 'Total');
        $grandTotal = 0;
        $footerCounter = 'C';
        foreach ($branches as $branch) {
            if (!isset($groupTotalSums[$branch->id])) {
                $groupTotalSums[$branch->id] = 0;
            }
            $worksheet->setCellValue("{$footerCounter}{$counter}", $groupTotalSums[$branch->id]);
            $grandTotal += $groupTotalSums[$branch->id];
            $footerCounter++;
        }
        $worksheet->setCellValue("{$footerCounter}{$counter}", $grandTotal);
        
        $worksheet->getStyle("A{$counter}:{$footerCounter}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:{$footerCounter}{$counter}")->getFont()->setBold(true);
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_ban_contract_service.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
