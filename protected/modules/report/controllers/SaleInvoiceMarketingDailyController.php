<?php

class SaleInvoiceMarketingDailyController extends Controller {

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
        
        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $saleInvoiceSummary = new SaleInvoiceMarketingDailySummary($invoiceHeader->search());
        $saleInvoiceSummary->setupLoading();
        $saleInvoiceSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $saleInvoiceSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleInvoiceSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'invoiceHeader' => $invoiceHeader,
            'saleInvoiceSummary' => $saleInvoiceSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }
    
    protected function saveToExcel($saleInvoiceSummary, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Kinerja Front Office');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Kinerja Front Office');

        $worksheet->mergeCells('A1:AA1');
        $worksheet->mergeCells('A2:AA2');
        $worksheet->mergeCells('A3:AA3');
        $worksheet->mergeCells('A4:AA4');
        
        $worksheet->getStyle('A1:AA3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AA3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Kinerja Front Office');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:AA5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AA5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AA5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Nama');
        $worksheet->setCellValue('B5', 'Level');
        $worksheet->setCellValue('C5', 'Location');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Phone');
        $worksheet->setCellValue('F5', 'Birthday');
        $worksheet->setCellValue('G5', 'Type');
        $worksheet->setCellValue('H5', 'New/Repeat');
        $worksheet->setCellValue('I5', 'Plat #');
        $worksheet->setCellValue('J5', 'Vehicle');
        $worksheet->setCellValue('K5', 'Color');
        $worksheet->setCellValue('L5', 'Invoice #');
        $worksheet->setCellValue('M5', 'Amount (Rp)');
        $worksheet->setCellValue('N5', 'Date');
        $worksheet->setCellValue('O5', 'Time');
        $worksheet->setCellValue('P5', 'Vehicle System Check #');
        $worksheet->setCellValue('Q5', 'Date');
        $worksheet->setCellValue('R5', 'Service List');
        $worksheet->setCellValue('S5', 'Service Amount (Rp)');
        $worksheet->setCellValue('T5', 'Parts List');
        $worksheet->setCellValue('U5', 'Parts Amount (Rp)');
        $worksheet->setCellValue('V5', 'Ban List');
        $worksheet->setCellValue('W5', 'Ban Amount (Rp)');
        $worksheet->setCellValue('X5', 'Oli List');
        $worksheet->setCellValue('Y5', 'Oli Amount (Rp)');
        $worksheet->setCellValue('Z5', 'Aksesoris');
        $worksheet->setCellValue('AA5', 'Aksesoris Amount (Rp)');

        $counter = 7;

        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.level.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'branch.code'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.mobile_phone'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.birthdate'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'customer.customer_type'));
            $worksheet->setCellValue("H{$counter}", $header->is_new_customer == 0 ? 'Repeat' : 'New');
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'vehicle.color.name'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("O{$counter}", substr(CHtml::value($header, 'created_datetime'), -1, 8));
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'registrationTransaction.transaction_number'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'registrationTransaction.transaction_date'));
            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'serviceLists'));
            $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'service_price'));
            $worksheet->setCellValue("T{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("U{$counter}", CHtml::value($header, 'product_price'));
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:AA{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="kinerja_front_office.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}