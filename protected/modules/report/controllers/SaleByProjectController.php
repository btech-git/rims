<?php

class SaleByProjectController extends Controller {

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

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->criteria->compare('t.customer_type', 'Company');
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $customerData = Customer::model()->findByPk($customer->id);

        $saleRetailSummary = new SaleByProjectSummary($customer->search());
        $saleRetailSummary->setupLoading();
        $saleRetailSummary->setupPaging($pageSize, $currentPage);
        $saleRetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $saleRetailSummary->setupFilter($filters);

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
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'currentSort' => $currentSort,
            'customerData' => $customerData,
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

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');

        $worksheet->getStyle('A1:L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan Project' . CHtml::encode(CHtml::value($customerData, 'name')));
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Customer');
        $worksheet->setCellValue('B5', 'COA');
        $worksheet->setCellValue('C5', 'Penjualan #');
        $worksheet->setCellValue('D5', 'Tanggal');
        $worksheet->setCellValue('E5', 'Vehicle');
        $worksheet->setCellValue('F5', 'Parts/Jasa');
        $worksheet->setCellValue('G5', 'Quantity');
        $worksheet->setCellValue('H5', 'Harga');
        $worksheet->setCellValue('I5', 'HPP');
        $worksheet->setCellValue('J5', 'COGS');
        $worksheet->setCellValue('K5', 'Total Sales');
        $worksheet->setCellValue('L5', 'Total COGS');

        $worksheet->getStyle('A6:L6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

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
                    $profit = $unitPrice - $cogs;
                    $grandTotal = $saleReportRow['total_price'];
                    $totalCogs = $cogs * $quantity;
                    $worksheet->getStyle("G{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'coa.name')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode($saleReportRow['invoice_number']));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($saleReportRow['invoice_date']));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode($saleReportRow['plate_number']));
                    if (empty($saleReportRow['product'])) {
                        $worksheet->setCellValue("F{$counter}", CHtml::encode($saleReportRow['service']));
                    } else {
                        $worksheet->setCellValue("F{$counter}", CHtml::encode($saleReportRow['product']));
                    }
                    $worksheet->setCellValue("G{$counter}", $quantity);
                    $worksheet->setCellValue("H{$counter}", $unitPrice);
                    $worksheet->setCellValue("I{$counter}", $cogs);
                    $worksheet->setCellValue("J{$counter}", $profit);
                    $worksheet->setCellValue("K{$counter}", $grandTotal);
                    $worksheet->setCellValue("L{$counter}", $totalCogs);
                    $counter++;
                    
                    $grandTotalSale += $grandTotal;
                    $grandTotalCogs += $totalCogs;
                }
//                $worksheet->getStyle("I{$counter}:K{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//                $worksheet->getStyle("I{$counter}:K{$counter}")->getFont()->setBold(true);
//
//                $worksheet->setCellValue("L{$counter}", 'TOTAL');
//                $worksheet->setCellValue("M{$counter}", CHtml::encode($totalSale));
//                $grandTotalSale += $totalSale;
//                $counter++;$counter++;
            }
        }
        $worksheet->getStyle("A{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:L{$counter}")->getFont()->setBold(true);

        $worksheet->setCellValue("J{$counter}", 'TOTAL');
        $worksheet->setCellValue("K{$counter}", CHtml::encode($grandTotalSale));
        $worksheet->setCellValue("L{$counter}", CHtml::encode($grandTotalCogs));

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
