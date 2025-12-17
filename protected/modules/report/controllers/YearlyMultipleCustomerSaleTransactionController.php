<?php

class YearlyMultipleCustomerSaleTransactionController extends Controller {

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
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        
        $yearlyMultipleCustomerCompanySaleReport = InvoiceHeader::getCustomerCompanyTopSaleReport($startDate, $endDate, $customerName, $branchId);
        $yearlyMultipleCustomerIndividualSaleReport = InvoiceHeader::getCustomerIndividualTopSaleReport($startDate, $endDate, $customerName, $branchId);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyMultipleCustomerCompanySaleReport, $yearlyMultipleCustomerIndividualSaleReport, $startDate, $endDate, $branchId);
        }
        
        $this->render('summary', array(
            'yearlyMultipleCustomerCompanySaleReport' => $yearlyMultipleCustomerCompanySaleReport,
            'yearlyMultipleCustomerIndividualSaleReport' => $yearlyMultipleCustomerIndividualSaleReport,
            'branchId' => $branchId,
            'customerName' => $customerName,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionTransactionInfo($customerId, $branchId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceHeader::model()->searchByCustomerSaleTransactionInfo($customerId, $branchId, $startDate, $endDate, $page);
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToTransactionInfoExcel($dataProvider, $customerId, $branchId, $startDate, $endDate);
        }

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerId' => $customerId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($yearlyMultipleCustomerCompanySaleReport, $yearlyMultipleCustomerIndividualSaleReport, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Customer Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Customer Tahunan');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Customer Tahunan ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->mergeCells('A5:K5');
        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Company');
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'ID');
        $worksheet->setCellValue('C6', 'Type');
        $worksheet->setCellValue('D6', 'Name');
        $worksheet->setCellValue('E6', 'Phone');
        $worksheet->setCellValue('F6', '# of Invoice');
        $worksheet->setCellValue('G6', 'Total Invoice (Rp)');
        $worksheet->setCellValue('H6', 'Total Parts (Rp)');
        $worksheet->setCellValue('I6', 'Total Jasa (Rp)');
        $worksheet->setCellValue('J6', 'Date 1st Invoice');
        $worksheet->setCellValue('K6', 'Duration from 1st invoice');
        $worksheet->getStyle('A6:K6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($yearlyMultipleCustomerCompanySaleReport as $i => $dataItemCompany) {
            $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $invoiceHeader = InvoiceHeader::model()->find(array(
                'condition' => 't.customer_id = :customer_id AND t.user_id_cancelled IS NULL', 
                'params' => array(':customer_id' => $dataItemCompany['customer_id']),
                'order' => 't.invoice_date ASC',
            ));
            $startSeconds = strtotime($invoiceHeader->invoice_date);
            $endSeconds = strtotime($endDate);
            $secondsDiff = $endSeconds - $startSeconds;
            $daysDiff = round($secondsDiff / (60 * 60 * 24));

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItemCompany['customer_id']);
            $worksheet->setCellValue("C{$counter}", $dataItemCompany['customer_type']);
            $worksheet->setCellValue("D{$counter}", $dataItemCompany['customer_name']);
            $worksheet->setCellValue("E{$counter}", $dataItemCompany['customer_phone']);
            $worksheet->setCellValue("F{$counter}", $dataItemCompany['invoice_quantity']);
            $worksheet->setCellValue("G{$counter}", $dataItemCompany['grand_total']);
            $worksheet->setCellValue("H{$counter}", $dataItemCompany['total_product']);
            $worksheet->setCellValue("I{$counter}", $dataItemCompany['total_service']);
            $worksheet->setCellValue("J{$counter}", CHtml::value($invoiceHeader, 'invoice_date'));
            $worksheet->setCellValue("K{$counter}", $daysDiff);

            $counter++;
        }
        $counter++;

        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->mergeCells("A{$counter}:K{$counter}");
        $worksheet->getStyle("A{$counter}:K{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'Individual');
        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;
        foreach ($yearlyMultipleCustomerIndividualSaleReport as $i => $dataItemIndividual) {
            $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $invoiceHeader = InvoiceHeader::model()->find(array(
                'condition' => 't.customer_id = :customer_id AND t.user_id_cancelled IS NULL', 
                'params' => array(':customer_id' => $dataItemIndividual['customer_id']),
                'order' => 't.invoice_date ASC',
            ));
            $startSeconds = strtotime($invoiceHeader->invoice_date);
            $endSeconds = strtotime($endDate);
            $secondsDiff = $endSeconds - $startSeconds;
            $daysDiff = round($secondsDiff / (60 * 60 * 24));

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItemIndividual['customer_id']);
            $worksheet->setCellValue("C{$counter}", $dataItemIndividual['customer_type']);
            $worksheet->setCellValue("D{$counter}", $dataItemIndividual['customer_name']);
            $worksheet->setCellValue("E{$counter}", $dataItemIndividual['customer_phone']);
            $worksheet->setCellValue("F{$counter}", $dataItemIndividual['invoice_quantity']);
            $worksheet->setCellValue("G{$counter}", $dataItemIndividual['grand_total']);
            $worksheet->setCellValue("H{$counter}", $dataItemIndividual['total_product']);
            $worksheet->setCellValue("I{$counter}", $dataItemIndividual['total_service']);
            $worksheet->setCellValue("J{$counter}", CHtml::value($invoiceHeader, 'invoice_date'));
            $worksheet->setCellValue("K{$counter}", $daysDiff);

            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_customer_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToTransactionInfoExcel($dataProvider, $customerId, $branchId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();
        
        $branch = Branch::model()->findByPk($branchId);
        $customer = Customer::model()->findByPk($customerId);

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Customer');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Customer ');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');

        $worksheet->getStyle('A1:Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Transaksi Penjualan ' . CHtml::value($customer, 'name'));
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->getStyle('A5:Q5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'ID');
        $worksheet->setCellValue('C5', 'Date Last Invoice');
        $worksheet->setCellValue('D5', 'Vehicle ID');
        $worksheet->setCellValue('E5', 'Plate #');
        $worksheet->setCellValue('F5', 'Kendaraan');
        $worksheet->setCellValue('G5', 'Warna');
        $worksheet->setCellValue('H5', 'KM');
        $worksheet->setCellValue('I5', 'WO #');
        $worksheet->setCellValue('J5', 'Last Service list');
        $worksheet->setCellValue('K5', 'Last Parts List');
        $worksheet->setCellValue('L5', 'Invoice #');
        $worksheet->setCellValue('M5', 'Invoice Amount (Rp)');
        $worksheet->setCellValue('N5', 'VSC #');
        $worksheet->setCellValue('O5', 'Note');
        $worksheet->setCellValue('P5', 'Salesman');
        $worksheet->setCellValue('Q5', 'Mechanic');
        $worksheet->getStyle('A6:Q6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $i => $header) {
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'customer_id'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle_id'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'vehicle.color.name'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'registrationTransaction.vehicle_mileage'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'registrationTransaction.work_order_number'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'serviceLists'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'registrationTransaction.note'));
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdAssignMechanic.name'));

            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_customer.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}