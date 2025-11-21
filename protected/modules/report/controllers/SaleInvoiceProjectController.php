<?php

class SaleInvoiceProjectController extends Controller {

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

        $customerData = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customerData->search();
        $customerDataProvider->criteria->compare('t.customer_type', 'Company');
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $saleRetailSummary = new SaleByProjectSummary($customerData->search());
        $saleRetailSummary->setupLoading();
        $saleRetailSummary->setupPaging($pageSize, $currentPage);
        $saleRetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $saleRetailSummary->setupFilter($filters);

        $customerIds = array_map(function($customer) { return $customer->id; }, $saleRetailSummary->dataProvider->data);
        
        $saleProjectReport = InvoiceHeader::getSaleByProjectReport($customerIds, $startDate, $endDate, $branchId);
        $saleProjectReportData = array();
        foreach ($saleProjectReport as $saleProjectReportItem) {
            $saleProjectReportData[$saleProjectReportItem['customer_id']][] = $saleProjectReportItem;
        }

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
                'customerData' => $customerData,
            ));
        }

        $this->render('summary', array(
            'saleRetailSummary' => $saleRetailSummary,
            'saleProjectReportData' => $saleProjectReportData,
            'customerData' => $customerData,
            'customerDataProvider' => $customerDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['Customer']['id'])) ? $_POST['Customer']['id'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_name' => CHtml::value($customer, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        $customerData = $options['customerData']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Project');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Project');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:M6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan Project' . CHtml::encode(CHtml::value($customerData, 'name')));
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Customer');
        $worksheet->setCellValue('B5', 'COA');
        $worksheet->setCellValue('C5', 'Penjualan #');
        $worksheet->setCellValue('D5', 'Tanggal');
        $worksheet->setCellValue('E5', 'Vehicle');
        $worksheet->setCellValue('F5', 'Type');
        $worksheet->setCellValue('G5', 'ID');
        $worksheet->setCellValue('H5', 'Item');
        $worksheet->setCellValue('I5', 'Quantity');
        $worksheet->setCellValue('J5', 'Harga');
        $worksheet->setCellValue('K5', 'HPP');
        $worksheet->setCellValue('L5', 'COGS');
        $worksheet->setCellValue('M5', 'Total Sales');

        $worksheet->getStyle('A6:M6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        $grandTotalSale = '0.00';
        $grandTotalCogs = '0.00';
        
        foreach ($dataProvider->data as $header) {
            $saleReportData = $header->getSaleByProjectReport($startDate, $endDate, $branchId);
            if (!empty($saleReportData)) {
                foreach ($saleReportData as $saleReportRow) {
                    $quantity = CHtml::encode($saleReportRow['quantity']);
                    $unitPrice = $saleReportRow['unit_price'];
                    $cogs = $saleReportRow['hpp'];
                    $grandTotal = $saleReportRow['total_price'];
                    $totalCogs = $cogs * $quantity;
                    $worksheet->getStyle("G{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'coa.name')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode($saleReportRow['invoice_number']));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($saleReportRow['invoice_date']));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode($saleReportRow['plate_number']));
                    if (empty($saleReportRow['product'])) {
                        $worksheet->setCellValue("F{$counter}", 'Jasa');
                        $worksheet->setCellValue("G{$counter}", CHtml::encode($saleReportRow['service_id']));
                        $worksheet->setCellValue("H{$counter}", CHtml::encode($saleReportRow['service']));
                    } else {
                        $worksheet->setCellValue("F{$counter}", 'Parts');
                        $worksheet->setCellValue("G{$counter}", CHtml::encode($saleReportRow['product_id']));
                        $worksheet->setCellValue("H{$counter}", CHtml::encode($saleReportRow['product']));
                    }
                    $worksheet->setCellValue("I{$counter}", $quantity);
                    $worksheet->setCellValue("J{$counter}", $unitPrice);
                    $worksheet->setCellValue("K{$counter}", $cogs);
                    $worksheet->setCellValue("L{$counter}", $totalCogs);
                    $worksheet->setCellValue("M{$counter}", $grandTotal);
                    $counter++;
                    
                    $grandTotalSale += $grandTotal;
                    $grandTotalCogs += $totalCogs;
                }
            }
        }
        $worksheet->getStyle("A{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:M{$counter}")->getFont()->setBold(true);

        $worksheet->setCellValue("K{$counter}", 'TOTAL');
        $worksheet->setCellValue("L{$counter}", CHtml::encode($grandTotalCogs));
        $worksheet->setCellValue("M{$counter}", CHtml::encode($grandTotalSale));

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan Project.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
