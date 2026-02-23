<?php

class YearlyMultipleVehicleSaleTransactionController extends Controller {

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
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        
        $yearlyMultipleVehicleSaleReport = InvoiceHeader::getMultipleVehicleSaleReport($startDate, $endDate, $branchId, $customerName, $plateNumber, $customerType);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyMultipleVehicleSaleReport, $startDate, $endDate, $branchId);
        }
        
        $this->render('summary', array(
            'yearlyMultipleVehicleSaleReport' => $yearlyMultipleVehicleSaleReport,
            'branchId' => $branchId,
            'customerName' => $customerName,
            'plateNumber' => $plateNumber,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerType' => $customerType,
        ));
    }
    
    public function actionTransactionInfo($vehicleId, $branchId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceHeader::model()->searchByVehicleSaleTransactionInfo($vehicleId, $branchId, $startDate, $endDate, $page);
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToTransactionInfoExcel($dataProvider, $vehicleId, $branchId, $startDate, $endDate);
        }

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'vehicleId' => $vehicleId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($yearlyMultipleVehicleSaleReport, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Kendaraan Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Kendaraan Tahunan');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');

        $worksheet->getStyle('A1:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Penjualan per Kendaraan Customer Tahunan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->getStyle('A5:O5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Vehicle ID');
        $worksheet->setCellValue('C5', 'Plate #');
        $worksheet->setCellValue('D5', 'Kendaraan');
        $worksheet->setCellValue('E5', 'Warna');
        $worksheet->setCellValue('F5', 'KM');
        $worksheet->setCellValue('G5', 'Customer ID');
        $worksheet->setCellValue('H5', 'Name');
        $worksheet->setCellValue('I5', 'Phone');
        $worksheet->setCellValue('J5', '# of Invoice');
        $worksheet->setCellValue('K5', 'Total Invoice (Rp)');
        $worksheet->setCellValue('L5', 'Total Parts (Rp)');
        $worksheet->setCellValue('M5', 'Total Jasa (Rp)');
        $worksheet->setCellValue('N5', 'Date 1st Invoice');
        $worksheet->setCellValue('O5', 'Duration from 1st invoice');
        $worksheet->getStyle('A5:O5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($yearlyMultipleVehicleSaleReport as $i => $dataItem) {
            $worksheet->getStyle("K{$counter}:M{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $invoiceHeader = InvoiceHeader::model()->find(array(
                'condition' => 't.vehicle_id = :vehicle_id AND t.user_id_cancelled IS NULL', 
                'params' => array(':vehicle_id' => $dataItem['vehicle_id']),
                'order' => 't.invoice_date ASC',
            ));
            $startSeconds = strtotime($invoiceHeader->invoice_date);
            $endSeconds = strtotime($endDate);
            $secondsDiff = $endSeconds - $startSeconds;
            $daysDiff = round($secondsDiff / (60 * 60 * 24));

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItem['vehicle_id']);
            $worksheet->setCellValue("C{$counter}", $dataItem['plate_number']);
            $worksheet->setCellValue("D{$counter}", $dataItem['car_make'] . ' - ' . $dataItem['car_model'] . ' - ' . $dataItem['car_sub_model']);
            $worksheet->setCellValue("E{$counter}", $dataItem['color_name']);
            $worksheet->setCellValue("F{$counter}", $dataItem['mileage']);
            $worksheet->setCellValue("G{$counter}", $dataItem['customer_id']);
            $worksheet->setCellValue("H{$counter}", $dataItem['customer_name']);
            $worksheet->setCellValue("I{$counter}", $dataItem['customer_phone']);
            $worksheet->setCellValue("J{$counter}", $dataItem['invoice_quantity']);
            $worksheet->setCellValue("K{$counter}", $dataItem['grand_total']);
            $worksheet->setCellValue("L{$counter}", $dataItem['total_product']);
            $worksheet->setCellValue("M{$counter}", $dataItem['total_service']);
            $worksheet->setCellValue("N{$counter}", CHtml::value($invoiceHeader, 'invoice_date'));
            $worksheet->setCellValue("O{$counter}", $daysDiff);

            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_per_kendaraan_customer_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToTransactionInfoExcel($dataProvider, $vehicleId, $branchId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();
        
        $branch = Branch::model()->findByPk($branchId);
        $vehicle = Vehicle::model()->findByPk($vehicleId);

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Kendaraan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Kendaraan ');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');

        $worksheet->getStyle('A1:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Transaksi Penjualan ' . CHtml::value($vehicle, 'plate_number') . ' - ' . CHtml::value($vehicle, 'carMake.name') . ' - ' . CHtml::value($vehicle, 'carModel.name') . ' - ' . CHtml::value($vehicle, 'carSubModel.name'));
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->getStyle('A5:O5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Date Last Invoice');
        $worksheet->setCellValue('C5', 'KM');
        $worksheet->setCellValue('D5', 'WO #');
        $worksheet->setCellValue('E5', 'Last Service list');
        $worksheet->setCellValue('F5', 'Last Parts List');
        $worksheet->setCellValue('G5', 'Invoice #');
        $worksheet->setCellValue('H5', 'Invoice Amount (Rp)');
        $worksheet->setCellValue('I5', 'Total Jasa (Rp)');
        $worksheet->setCellValue('J5', 'Total Parts (Rp)');
        $worksheet->setCellValue('K5', 'VSC #');
        $worksheet->setCellValue('L5', 'Note');
        $worksheet->setCellValue('M5', 'Salesman');
        $worksheet->setCellValue('N5', 'Mechanic');
        $worksheet->setCellValue('O5', 'Asuransi');
        $worksheet->getStyle('A5:O5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($dataProvider->data as $i => $header) {
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'registrationTransaction.vehicle_mileage'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'registrationTransaction.work_order_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'serviceLists'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'service_price'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'product_price'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'registrationTransaction.note'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdAssignMechanic.name'));
            $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'insuranceCompany.name'));

            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincian_penjualan_kendaraan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}