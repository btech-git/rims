<?php

class ReceivableCustomerController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('receivableReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $receivableSummary = new ReceivableCustomerSummary($customer->search());
        $receivableSummary->setupLoading();
        $receivableSummary->setupPaging($pageSize, $currentPage);
        $receivableSummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $receivableSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableSummary, $endDate, $branchId);
        }

        $this->render('summary', array(
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'customerId' => $customerId,
            'branchId' => $branchId,
            'endDate' => $endDate,
            'receivableSummary' => $receivableSummary,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
        ));
    }

    public function actionTransactionInfo($customerId, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = AppParam::BEGINNING_TRANSACTION_DATE;
        $dataProvider = InvoiceHeader::model()->searchByReport();
        $dataProvider->criteria->addBetweenCondition('t.invoice_date', $startDate, $endDate);
        $dataProvider->criteria->compare('t.customer_id', $customerId);
        $dataProvider->criteria->addCondition("t.user_id_cancelled IS NULL");
        
        $customer = Customer::model()->findByPk($customerId);
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToExcelDetailTransaction($dataProvider, $endDate, $customer);
        }

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'endDate' => $endDate,
            'customer' => $customer,
            'customerId' => $customerId,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_type' => CHtml::value($customer, 'customer_type'),
                'customer_mobile_phone' => CHtml::value($customer, 'mobile_phone'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($receivableSummary, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Summary');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');
        
        $worksheet->getStyle('A1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A2', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A3', 'Piutang Customer Summary');
        $worksheet->setCellValue('A4', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A6:H6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A7:H7")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:H7')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Name');
        $worksheet->setCellValue('B6', 'Type');
        $worksheet->setCellValue('C6', 'Grand Total');
        $worksheet->setCellValue('D6', 'Payment');
        $worksheet->setCellValue('E6', 'Remaining');
        $counter = 9;

        $totalRevenue = 0.00;
        $totalPayment = 0.00;
        $totalReceivable = 0.00;
        $totalReceivableIndividual = Customer::getTotalReceivableIndividual($endDate, $branchId);
        $totalPaymentIndividual = Customer::getTotalPaymentIndividual($endDate, $branchId);
        $totalRemainingIndividual = Customer::getTotalRemainingIndividual($endDate, $branchId);
        $worksheet->mergeCells("A{$counter}:B{$counter}");
        $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Individual');
        $worksheet->setCellValue("C{$counter}", $totalReceivableIndividual);
        $worksheet->setCellValue("D{$counter}", $totalPaymentIndividual);
        $worksheet->setCellValue("E{$counter}", $totalRemainingIndividual);

        $counter++;

        foreach ($receivableSummary->dataProvider->data as $header) {
            $receivableData = $header->getReceivableCustomerReport($endDate, $branchId);
            foreach ($receivableData as $receivableRow) {
                $revenue = $receivableRow['total_price'];
                $paymentAmount = $receivableRow['payment_amount'];
                $paymentLeft = $receivableRow['payment_left'];
                
                $worksheet->setCellValue("A{$counter}", $header->name);
                $worksheet->setCellValue("B{$counter}", $header->customer_type);
                $worksheet->setCellValue("C{$counter}", $revenue);
                $worksheet->setCellValue("D{$counter}", $paymentAmount);
                $worksheet->setCellValue("E{$counter}", $paymentLeft);
                
                $counter++;
            
                $totalRevenue += $revenue;
                $totalPayment += $paymentAmount;
                $totalReceivable += $paymentLeft;
            }
        }
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("A{$counter}:B{$counter}");
        $worksheet->setCellValue("A{$counter}", 'Total');
        $worksheet->setCellValue("C{$counter}", $totalRevenue + $totalReceivableIndividual);
        $worksheet->setCellValue("D{$counter}", $totalPayment + $totalPaymentIndividual);
        $worksheet->setCellValue("E{$counter}", $totalReceivable + $totalRemainingIndividual);

        $counter++;$counter++;

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_customer_summary.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

    protected function saveToExcelDetailTransaction($dataProvider, $endDate, $customer) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Detail');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');
        
        $worksheet->getStyle('A1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H3')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor');
        $worksheet->setCellValue('A3', 'Piutang Customer ' . CHtml::value($customer, 'name'));
        $worksheet->setCellValue('A4', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A6:H6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A7:H7")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:H7')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Invoice #');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Jatuh Tempo');
        $worksheet->setCellValue('D6', 'Plat #');
        $worksheet->setCellValue('E6', 'Kendaraan');
        $worksheet->setCellValue('F6', 'Total');
        $worksheet->setCellValue('G6', 'Payment');
        $worksheet->setCellValue('H6', 'Remaining');
        
        $counter = 9;

        $totalPriceSum = '0.00';
        $paymentTotalSum = '0.00';
        $paymentLeftSum = '0.00'; 

        foreach ($dataProvider->data as $header) {
            $totalPrice = CHtml::value($header, 'total_price'); 
            $paymentTotal = CHtml::value($header, 'payment_amount');
            $paymentLeft = CHtml::value($header, 'payment_left');
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'due_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' ' . CHtml::value($header, 'vehicle.carModel.name') . ' ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("F{$counter}", $totalPrice);
            $worksheet->setCellValue("G{$counter}", $paymentTotal);
            $worksheet->setCellValue("H{$counter}", $paymentLeft);
            
            $totalPriceSum += $totalPrice;
            $paymentTotalSum += $paymentTotal;
            $paymentLeftSum += $paymentLeft;

            $counter++;
        }
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("A{$counter}:E{$counter}");
        
        $worksheet->setCellValue("A{$counter}", 'Total');
        $worksheet->setCellValue("F{$counter}", $totalPriceSum);
        $worksheet->setCellValue("G{$counter}", $paymentTotalSum);
        $worksheet->setCellValue("H{$counter}", $paymentLeftSum);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_customer_detail.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
