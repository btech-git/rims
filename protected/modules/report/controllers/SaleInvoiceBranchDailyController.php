<?php

class SaleInvoiceBranchDailyController extends Controller {

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
        
        $saleInvoiceSummary = new SaleInvoiceBranchDailySummary($invoiceHeader->search());
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

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Kinerja Cabang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Kinerja Cabang');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');
        
        $worksheet->getStyle('A1:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Kinerja Cabang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:AI5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AI5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:AI5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Cabang');
        $worksheet->setCellValue('C5', 'Front');
        $worksheet->setCellValue('D5', 'Level');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Phone');
        $worksheet->setCellValue('G5', 'Birthday');
        $worksheet->setCellValue('H5', 'Type');
        $worksheet->setCellValue('I5', 'New/Repeat');
        $worksheet->setCellValue('J5', 'Plat #');
        $worksheet->setCellValue('K5', 'Vehicle');
        $worksheet->setCellValue('L5', 'Color');
        $worksheet->setCellValue('M5', 'Waktu Masuk');
        $worksheet->setCellValue('N5', 'Waktu Keluar');
        $worksheet->setCellValue('O5', 'Redo? Doc # (WO# - R)');
        $worksheet->setCellValue('P5', 'WO #');
        $worksheet->setCellValue('Q5', 'WO Date');
        $worksheet->setCellValue('R5', 'WO Time');
        $worksheet->setCellValue('S5', 'Mechanic');
        $worksheet->setCellValue('T5', 'Invoice #');
        $worksheet->setCellValue('U5', 'Invoice Amount (Rp)');
        $worksheet->setCellValue('V5', 'Invoice Date');
        $worksheet->setCellValue('W5', 'Invoice Time');
        $worksheet->setCellValue('X5', 'Vehicle System Check #');
        $worksheet->setCellValue('Y5', 'VSC Date');
        $worksheet->setCellValue('Z5', 'Service List');
        $worksheet->setCellValue('AA5', 'Service Amount (Rp)');
        $worksheet->setCellValue('AB5', 'Parts List');
        $worksheet->setCellValue('AC5', 'Parts Amount (Rp)');
        $worksheet->setCellValue('AD5', 'Ban List');
        $worksheet->setCellValue('AE5', 'Ban Amount (Rp)');
        $worksheet->setCellValue('AF5', 'Oli List');
        $worksheet->setCellValue('AG5', 'Oli Amount (Rp)');
        $worksheet->setCellValue('AH5', 'Aksesoris');
        $worksheet->setCellValue('AI5', 'Aksesoris Amount (Rp)');

        $counter = 7;

        foreach ($saleInvoiceSummary->dataProvider->data as $i => $header) {
            
            $vehiclePositionTimer = VehiclePositionTimer::model()->find(array(
                'order' => ' id DESC',
                'condition' => "t.vehicle_id = :vehicle_id AND t.entry_date IS NOT NULL AND t.process_date IS NULL AND t.exit_date IS NULL",
                'params' => array(':vehicle_id' => $header->vehicle_id)
            ));
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'branch.code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.level.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.mobile_phone'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'customer.birthdate'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'customer.customer_type'));
            $worksheet->setCellValue("I{$counter}", $header->is_new_customer == 0 ? 'Repeat' : 'New');
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'vehicle.color.name'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($vehiclePositionTimer, 'entry_time'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($vehiclePositionTimer, 'exit_time'));
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'registrationTransaction.work_order_number'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'registrationTransaction.work_order_date'));
            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'registrationTransaction.work_order_time'));
            $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'employeeIdAssignMechanic.name'));
            $worksheet->setCellValue("T{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("U{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("V{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("W{$counter}", substr(CHtml::value($header, 'created_datetime'), -1, 8));
            $worksheet->setCellValue("Z{$counter}", CHtml::value($header, 'serviceLists'));
            $worksheet->setCellValue("AA{$counter}", CHtml::value($header, 'service_price'));
            $worksheet->setCellValue("AB{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("AC{$counter}", CHtml::value($header, 'product_price'));
            $worksheet->setCellValue("AD{$counter}", CHtml::value($header, 'productTireLists'));
            $worksheet->setCellValue("AE{$counter}", CHtml::value($header, 'productTireAmount'));
            $worksheet->setCellValue("AF{$counter}", CHtml::value($header, 'productOilLists'));
            $worksheet->setCellValue("AG{$counter}", CHtml::value($header, 'productOilAmount'));
            $worksheet->setCellValue("AH{$counter}", CHtml::value($header, 'productAccessoriesLists'));
            $worksheet->setCellValue("AI{$counter}", CHtml::value($header, 'productAccessoriesAmount'));
            $counter++;
        }

        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="kinerja_cabang_harian.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}