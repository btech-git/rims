<?php

class YearlyMultipleInsuranceSaleTransactionController extends Controller {

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
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $insuranceId = (isset($_GET['InsuranceId'])) ? $_GET['InsuranceId'] : '';
        
        $yearlyMultipleInsuranceSaleReport = InvoiceHeader::getInsuranceTopSaleReport($startDate, $endDate, $insuranceId, $branchId);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyMultipleInsuranceSaleReport, $startDate, $endDate, $branchId);
        }
        
        $this->render('summary', array(
            'yearlyMultipleInsuranceSaleReport' => $yearlyMultipleInsuranceSaleReport,
            'branchId' => $branchId,
            'insuranceId' => $insuranceId,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionTransactionInfo($insuranceId, $branchId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceHeader::model()->searchByInsuranceSaleTransactionInfo($insuranceId, $branchId, $startDate, $endDate, $page);
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToTransactionInfoExcel($dataProvider, $insuranceId, $branchId, $startDate, $endDate);
        }

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'insuranceId' => $insuranceId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($yearlyMultipleInsuranceSaleReport, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Asuransi Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Asuransi Tahunan');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Penjualan Asuransi Tahunan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'ID');
        $worksheet->setCellValue('C5', 'Asuransi');
        $worksheet->setCellValue('D5', 'Akun');
        $worksheet->setCellValue('E5', '# of Invoice');
        $worksheet->setCellValue('F5', 'Total Invoice (Rp)');
        $worksheet->setCellValue('G5', 'Total Parts (Rp)');
        $worksheet->setCellValue('H5', 'Total Jasa (Rp)');
        $worksheet->setCellValue('I5', 'Date 1st Invoice');
        $worksheet->setCellValue('J5', 'Duration from 1st invoice');
        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($yearlyMultipleInsuranceSaleReport as $i => $dataItemCompany) {
            $invoiceHeader = InvoiceHeader::model()->find(array(
                'condition' => 't.insurance_company_id = :insurance_company_id AND t.user_id_cancelled IS NULL', 
                'params' => array(':insurance_company_id' => $dataItemCompany['insurance_company_id']),
                'order' => 't.invoice_date ASC',
            ));
            $startSeconds = strtotime($invoiceHeader->invoice_date);
            $endSeconds = strtotime($endDate);
            $secondsDiff = $endSeconds - $startSeconds;
            $daysDiff = round($secondsDiff / (60 * 60 * 24));

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItemCompany['insurance_company_id']);
            $worksheet->setCellValue("C{$counter}", $dataItemCompany['insurance_name']);
            $worksheet->setCellValue("D{$counter}", $dataItemCompany['coa_name']);
            $worksheet->setCellValue("E{$counter}", $dataItemCompany['invoice_quantity']);
            $worksheet->setCellValue("F{$counter}", $dataItemCompany['grand_total']);
            $worksheet->setCellValue("G{$counter}", $dataItemCompany['total_product']);
            $worksheet->setCellValue("H{$counter}", $dataItemCompany['total_service']);
            $worksheet->setCellValue("I{$counter}", CHtml::value($invoiceHeader, 'invoice_date'));
            $worksheet->setCellValue("J{$counter}", $daysDiff);

            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_asuransi_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToTransactionInfoExcel($dataProvider, $insuranceId, $branchId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();
        
        $branch = Branch::model()->findByPk($branchId);
        $insuranceCompany = InsuranceCompany::model()->findByPk($insuranceId);

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Asuransi');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Asuransi ');

        $worksheet->mergeCells('A1:R1');
        $worksheet->mergeCells('A2:R2');
        $worksheet->mergeCells('A3:R3');

        $worksheet->getStyle('A1:R5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:R5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Transaksi Penjualan ' . CHtml::value($insuranceCompany, 'name'));
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->getStyle('A5:R5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'ID');
        $worksheet->setCellValue('C5', 'Date Last Invoice');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Vehicle ID');
        $worksheet->setCellValue('F5', 'Plate #');
        $worksheet->setCellValue('G5', 'Kendaraan');
        $worksheet->setCellValue('H5', 'Warna');
        $worksheet->setCellValue('I5', 'KM');
        $worksheet->setCellValue('J5', 'WO #');
        $worksheet->setCellValue('K5', 'Last Service list');
        $worksheet->setCellValue('L5', 'Last Parts List');
        $worksheet->setCellValue('M5', 'Invoice #');
        $worksheet->setCellValue('N5', 'Invoice Amount (Rp)');
        $worksheet->setCellValue('O5', 'VSC #');
        $worksheet->setCellValue('P5', 'Note');
        $worksheet->setCellValue('Q5', 'Salesman');
        $worksheet->setCellValue('R5', 'Mechanic');
        $worksheet->getStyle('A5:R5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($dataProvider->data as $i => $header) {
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'customer_id'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle_id'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'vehicle.color.name'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'registrationTransaction.vehicle_mileage'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'registrationTransaction.work_order_number'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'serviceLists'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'registrationTransaction.note'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name'));
            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdAssignMechanic.name'));

            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_asuransi.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}