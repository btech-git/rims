<?php

class MonthlyProductSaleController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('monthlyProductSaleReport') )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';
        $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = isset($_GET['SubBrandSeriesId']) ? $_GET['SubBrandSeriesId'] : '';
        $masterCategoryId = isset($_GET['MasterCategoryId']) ? $_GET['MasterCategoryId'] : '';
        $subMasterCategoryId = isset($_GET['SubMasterCategoryId']) ? $_GET['SubMasterCategoryId'] : '';
        $subCategoryId = isset($_GET['SubCategoryId']) ? $_GET['SubCategoryId'] : '';

        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = $year . '-' . $month . '-1';
        $endDate = $year . '-' . $month . '-' . $numberOfDays;
        
        $monthlyProductSaleData = InvoiceHeader::getMonthlyProductSaleData($startDate, $endDate, $branchId, $brandId, $subBrandId, $subBrandSeriesId, $masterCategoryId, $subMasterCategoryId, $subCategoryId);
        
        $productSaleData = array();
        foreach ($monthlyProductSaleData as $monthlyProductSaleItem) {
            $productSaleData[$monthlyProductSaleItem['product_id']]['product_name'] = $monthlyProductSaleItem['product_name'];
            $productSaleData[$monthlyProductSaleItem['product_id']][$monthlyProductSaleItem['invoice_date']]['total_quantity'] = $monthlyProductSaleItem['total_quantity'];
            $productSaleData[$monthlyProductSaleItem['product_id']][$monthlyProductSaleItem['invoice_date']]['total_price'] = $monthlyProductSaleItem['total_price'];
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
            $this->saveToExcel($productSaleData, array(
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
            'branchId' => $branchId,
            'monthList' => $monthList,
            ));
        }

        $this->render('summary', array(
            'branchId' => $branchId,
            'month' => $month,
            'year' => $year,
            'yearList' => $yearList,
            'numberOfDays' => $numberOfDays,
            'productSaleData' => $productSaleData,
            'monthList' => $monthList,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'masterCategoryId' => $masterCategoryId,
            'subMasterCategoryId' => $subMasterCategoryId,
            'subCategoryId' => $subCategoryId,
        ));
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';

            $this->renderPartial('_productSubBrandSelect', array(
                'brandId' => $brandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'subBrandId' => $subBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $masterCategoryId = isset($_GET['MasterCategoryId']) ? $_GET['MasterCategoryId'] : '';

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'masterCategoryId' => $masterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subMasterCategoryId = isset($_GET['SubMasterCategoryId']) ? $_GET['SubMasterCategoryId'] : '';

            $this->renderPartial('_productSubCategorySelect', array(
                'subMasterCategoryId' => $subMasterCategoryId,
            ));
        }
    }

    protected function saveToExcel($productSaleData, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Parts Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Parts Bulanan');

        $branchId = $options['branchId'];
        $monthList = $options['monthList'];
        $month = $options['month'];
        $year = $options['year'];
        $numberOfDays = $options['numberOfDays'];

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');

        $worksheet->getStyle('A1:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Penjualan Parts Bulanan');
        $worksheet->setCellValue('A3', $monthList[$month] . ' ' . $year);
        
        $columnCounter = 'B';
        $mergeColumnCounter = 'C';
        foreach ($productSaleData as $productSaleItem) {
            $worksheet->mergeCells("{$columnCounter}5:{$mergeColumnCounter}5");
            $worksheet->setCellValue("{$columnCounter}5", $productSaleItem['product_name']);
            $columnCounter++;$columnCounter++;
            $mergeColumnCounter++;$mergeColumnCounter++;
        }
        $worksheet->mergeCells("{$columnCounter}5:{$mergeColumnCounter}5");
        $worksheet->setCellValue("{$columnCounter}5", 'Total');
        $columnCounter = 'B';
        foreach ($productSaleData as $productSaleItem) {
            $worksheet->setCellValue("{$columnCounter}6", 'Quantity');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Price');
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Quantity');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Price');
        $columnCounter++;
        
        $rowCounter = 8;
        $footerQuantities = array();
        $footerPrices = array();
        for ($n = 1; $n <= $numberOfDays; $n++) {
            $worksheet->setCellValue("A{$rowCounter}", $n);
            $quantitySum = '0.00';
            $priceSum = '0.00';
            $columnCounter = 'B';
            foreach ($productSaleData as $productId => $productSaleItem) {
                $day = str_pad($n, 2, '0', STR_PAD_LEFT);
                $date = $year . '-' . $month . '-' . $day;
                $quantity = isset($productSaleItem[$date]['total_quantity']) ? $productSaleItem[$date]['total_quantity'] : '';
                $price = isset($productSaleItem[$date]['total_price']) ? $productSaleItem[$date]['total_price'] : '';
                if (isset($productSaleItem[$date])) {
                    $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $quantity);
                }
                $columnCounter++;
                if (isset($productSaleItem[$date])) {
                    $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $price);
                }
                $columnCounter++;
                $quantitySum += $quantity;
                $priceSum += $price;
                if (!isset($footerQuantities[$productId])) {
                    $footerQuantities[$productId] = '0.00';
                }
                if (!isset($footerPrices[$productId])) {
                    $footerPrices[$productId] = '0.00';
                }
                $footerQuantities[$productId] += $quantity;
                $footerPrices[$productId] += $price;
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
        $columnCounter = 'B';
        foreach ($productSaleData as $productId => $productSaleItem) {
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $footerQuantities[$productId]);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $footerPrices[$productId]);
            $columnCounter++;
            $footerQuantitiesSum += $footerQuantities[$productId];
            $footerPricesSum += $footerPrices[$productId]; 
        }
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $footerQuantitiesSum);
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$rowCounter}", $footerPricesSum);
        $columnCounter++;
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setWidth(15);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Parts Bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
