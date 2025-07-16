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

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');
        $worksheet->mergeCells('A4:M4');
        
        $worksheet->getStyle('A1:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Kinerja Front Office');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:AB5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AB5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:AB5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Nama');
        $worksheet->setCellValue('C5', 'Level');
        $worksheet->setCellValue('D5', 'Location');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Phone');
        $worksheet->setCellValue('G5', 'Birthday');
        $worksheet->setCellValue('H5', 'Type');
        $worksheet->setCellValue('I5', 'New/Repeat');
        $worksheet->setCellValue('J5', 'Plat #');
        $worksheet->setCellValue('K5', 'Vehicle');
        $worksheet->setCellValue('L5', 'Color');
        $worksheet->setCellValue('M5', 'Invoice #');
        $worksheet->setCellValue('N5', 'Amount (Rp)');
        $worksheet->setCellValue('O5', 'Date');
        $worksheet->setCellValue('P5', 'Time');
        $worksheet->setCellValue('Q5', 'Vehicle System Check #');
        $worksheet->setCellValue('R5', 'Date');
        $worksheet->setCellValue('S5', 'Service List');
        $worksheet->setCellValue('T5', 'Service Amount (Rp)');
        $worksheet->setCellValue('U5', 'Parts List');
        $worksheet->setCellValue('V5', 'Parts Amount (Rp)');
        $worksheet->setCellValue('W5', 'Ban List');
        $worksheet->setCellValue('X5', 'Ban Amount (Rp)');
        $worksheet->setCellValue('Y5', 'Oli List');
        $worksheet->setCellValue('Z5', 'Oli Amount (Rp)');
        $worksheet->setCellValue('AA5', 'Aksesoris');
        $worksheet->setCellValue('AB5', 'Aksesoris Amount (Rp)');

        $counter = 7;

        foreach ($saleInvoiceSummary->dataProvider->data as $i => $header) {
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.level.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'branch.code'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.mobile_phone'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'customer.birthdate'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'customer.customer_type'));
            $worksheet->setCellValue("I{$counter}", $header->is_new_customer == 0 ? 'Repeat' : 'New');
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'vehicle.color.name'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("P{$counter}", substr(CHtml::value($header, 'created_datetime'), -1, 8));
//            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'registrationTransaction.transaction_number'));
//            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'registrationTransaction.transaction_date'));
            $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'serviceLists'));
            $worksheet->setCellValue("T{$counter}", CHtml::value($header, 'service_price'));
            $worksheet->setCellValue("U{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("V{$counter}", CHtml::value($header, 'product_price'));
            $worksheet->setCellValue("W{$counter}", CHtml::value($header, 'productTireLists'));
            $worksheet->setCellValue("X{$counter}", CHtml::value($header, 'productTireAmount'));
            $worksheet->setCellValue("Y{$counter}", CHtml::value($header, 'productOilLists'));
            $worksheet->setCellValue("Z{$counter}", CHtml::value($header, 'productOilAmount'));
            $worksheet->setCellValue("AA{$counter}", CHtml::value($header, 'productAccessoriesLists'));
            $worksheet->setCellValue("AB{$counter}", CHtml::value($header, 'productAccessoriesAmount'));
            $counter++;
        }

        for ($col = 'A'; $col !== 'AZ'; $col++) {
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