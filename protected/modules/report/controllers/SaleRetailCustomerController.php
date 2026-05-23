<?php

class SaleRetailCustomerController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleCustomerReport'))) {
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
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $taxValue = (isset($_GET['TaxValue'])) ? $_GET['TaxValue'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : 'Company';

        $customerSaleReport = Customer::getCustomerSaleReport($startDate, $endDate, $customerId, $branchId, $taxValue, $customerType);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($customerSaleReport, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
                'branchId' => $branchId,
                'taxValue' => $taxValue,
                'customerId' => $customerId,
            ));
        }

        $this->render('summary', array(
            'customerSaleReport' => $customerSaleReport,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'taxValue' => $taxValue,
            'branchId' => $branchId,
            'customerId' => $customerId,
        ));
    }

    public function actionTransactionInfo($customerId, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceHeader::model()->searchByCustomerTransactionInfo($customerId, $startDate, $endDate, $branchId, $page);
        $customer = Customer::model()->findByPk($customerId);
        $branch = Branch::model()->findByPk($branchId);
        
        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionInfo(array(
                'dataProvider' => $dataProvider,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'branchId' => $branchId,
                'customerId' => $customerId,
            ));
        }

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customer' => $customer,
            'branch' => $branch,
            'customerId' => $customerId,
            'branchId' => $branchId,
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

    protected function saveToExcel($customerSaleReport, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        $taxValue = $options['taxValue']; 
//        $customerId = $options['customerId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan per Pelanggan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan per Pelanggan');

        $worksheet->mergeCells('A1:D1');
        $worksheet->mergeCells('A2:D2');
        $worksheet->mergeCells('A3:D3');

        $worksheet->getStyle('A1:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:D6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Penjualan per Pelanggan Summary');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Customer');
        $worksheet->setCellValue('C5', 'Type');
        $worksheet->setCellValue('D5', 'Total Sales');

        $worksheet->getStyle('A6:D6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        
        $totalIndividual = Customer::getTotalSaleIndividual($startDate, $endDate, $branchId, $taxValue);
        $worksheet->setCellValue("B{$counter}", 'Individual');
        $worksheet->setCellValue("D{$counter}", $totalIndividual);
            
        $counter++;
            
        $totalSale = 0.00;
        foreach ($customerSaleReport as $i => $dataItem) {
            $grandTotal = $dataItem['grand_total'];
            $worksheet->getStyle("D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $dataItem['customer_id']);
            $worksheet->setCellValue("B{$counter}", $dataItem['customer_name']);
            $worksheet->setCellValue("C{$counter}", $dataItem['customer_type']);
            $worksheet->setCellValue("D{$counter}", $grandTotal);

            $counter++;
            
            $totalSale += $grandTotal;
        }

        $worksheet->getStyle("A{$counter}:D{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:D{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("B{$counter}", 'Total');
        $worksheet->setCellValue("C{$counter}", 'Rp');
        $worksheet->setCellValue("D{$counter}", $totalSale + $totalIndividual);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_per_pelanggan_summary.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelTransactionInfo(array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $dataProvider = $options['dataProvider'];
        $startDate = $options['startDate'];
        $endDate = $options['endDate'];
        $branchId = $options['branchId'];
        $customerId = $options['customerId'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Penjualan Pelanggan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Penjualan  Pelanggan');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $customer = Customer::model()->findByPk($customerId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'code'));
        $worksheet->setCellValue('A2', 'Transaksi Penjualan Customer ' . CHtml::value($customer, 'name'));
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Invoice #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Asuransi');
        $worksheet->setCellValue('D5', 'Plat #');
        $worksheet->setCellValue('E5', 'Vehicle');
        $worksheet->setCellValue('F5', 'Parts (Rp)');
        $worksheet->setCellValue('G5', 'Jasa (Rp)');
        $worksheet->setCellValue('H5', 'Total (Rp)');
        $worksheet->setCellValue('I5', 'Pembayaran (Rp)');
        $worksheet->setCellValue('J5', 'Sisa (Rp)');
        $worksheet->setCellValue('K5', 'Status');

        $worksheet->getStyle('A5:K5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $grandTotal = '0.00';
        
        foreach ($dataProvider->data as $header) {
            $totalPrice = CHtml::value($header, 'total_price');

            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("B{$counter}", $header->invoice_date);
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'insuranceCompany.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'product_price'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'service_price'));
            $worksheet->setCellValue("H{$counter}", $totalPrice);
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'payment_amount'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'payment_left'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'status'));

            $counter++;
            
            $grandTotal += $totalPrice;
        }

        $worksheet->getStyle("A{$counter}:K{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue("F{$counter}", 'Total');
        $worksheet->setCellValue("G{$counter}", 'Rp');
        $worksheet->setCellValue("H{$counter}", $grandTotal);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_penjualan_pelanggan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
