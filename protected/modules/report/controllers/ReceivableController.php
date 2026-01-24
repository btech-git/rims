<?php

class ReceivableController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('customerReceivableReport'))) {
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
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        if (isset($_GET['ResetFilter'])) {
            $pageSize = '';
            $currentPage = '';
            $currentSort = '';
            $branchId = '';
            $plateNumber = '';
            $customerId = '';
            $endDate = date('Y-m-d');
        }
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';
        
        $receivableSummary = new ReceivableSummary($customer->search());
        $receivableSummary->setupLoading();
        $receivableSummary->setupPaging($pageSize, $currentPage);
        $receivableSummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
            'plateNumber' => $plateNumber,
            'customerId' => $customerId,
        );
        $receivableSummary->setupFilter($filters);
        
        $customerIds = array_map(function($customer) { return $customer->id; }, $receivableSummary->dataProvider->data);
        $receivableReport = InvoiceHeader::getReceivableReport($endDate, $branchId, $plateNumber, $customerIds);
        $invoiceHeaderIds = array_map(function($receivableReportItem) { return $receivableReportItem['id']; }, $receivableReport);
        $receivablePaymentReport = PaymentInDetail::getReceivablePaymentReport($endDate, $invoiceHeaderIds);
        
        $receivableReportData = array();
        foreach ($receivableReport as $receivableReportItem) {
            if (!isset($receivableReportData[$receivableReportItem['customer_id']])) {
                $receivableReportData[$receivableReportItem['customer_id']] = array();
            }
            $receivableReportData[$receivableReportItem['customer_id']][] = $receivableReportItem;
        }
        
        $receivablePaymentReportData = array();
        foreach ($receivablePaymentReport as $receivablePaymentReportItem) {
            $receivablePaymentReportData[$receivablePaymentReportItem['invoice_header_id']] = $receivablePaymentReportItem['payment_amount'];
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableSummary, $receivableReportData, $receivablePaymentReportData, $endDate, $branchId);
        }

        $this->render('summary', array(
            'receivableSummary' => $receivableSummary,
            'receivableReportData' => $receivableReportData,
            'receivablePaymentReportData' => $receivablePaymentReportData,
            'plateNumber' => $plateNumber,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'customerId' => $customerId,
            'branchId' => $branchId,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($receivableSummary, $receivableReportData, $receivablePaymentReportData, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Faktur Belum Lunas Customer');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Belum Lunas Customer');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        
        $worksheet->getStyle('A1:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G6')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Faktur Belum Lunas Customer');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:G5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:G6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'Name');
        $worksheet->setCellValue('B5', 'Type');
        $worksheet->setCellValue('C5', 'Note');

        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Jatuh Tempo');
        $worksheet->setCellValue('C6', 'Faktur #');
        $worksheet->setCellValue('D6', 'Vehicle');
        $worksheet->setCellValue('E6', 'Grand Total');
        $worksheet->setCellValue('F6', 'Payment');
        $worksheet->setCellValue('G6', 'Remaining');
        $counter = 8;

        foreach ($receivableSummary->dataProvider->data as $customer) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($customer, 'name'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($customer, 'customer_type'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($customer, 'note'));
            $counter++;
            
            $totalRevenue = '0.00';
            $totalPayment = '0.00';
            $totalReceivable = '0.00';
            foreach ($receivableReportData[$customer->id] as $receivableReportItem) {
                $revenue = $receivableReportItem['total_price'];
                $paymentAmount = isset($receivablePaymentReportData[$receivableReportItem['id']]) ? $receivablePaymentReportData[$receivableReportItem['id']] : '0.00';
                $paymentLeft = $revenue - $paymentAmount;
                
                $worksheet->setCellValue("A{$counter}", $receivableReportItem['invoice_date']);
                $worksheet->setCellValue("C{$counter}", $receivableReportItem['due_date']);
                $worksheet->setCellValue("B{$counter}", $receivableReportItem['invoice_number']);
                $worksheet->setCellValue("D{$counter}", $receivableReportItem['plate_number']);
                $worksheet->setCellValue("E{$counter}", $revenue);
                $worksheet->setCellValue("F{$counter}", $paymentAmount);
                $worksheet->setCellValue("G{$counter}", $paymentLeft);
                
                $counter++;
            
                $totalRevenue += $revenue;
                $totalPayment += $paymentAmount;
                $totalReceivable += $paymentLeft;
            }
            
            $worksheet->getStyle("A{$counter}:{$counter}")->getFont()->setBold(true);

            $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->mergeCells("A{$counter}:D{$counter}");
            
            $worksheet->setCellValue("A{$counter}", 'Total');
            $worksheet->setCellValue("E{$counter}", $totalRevenue);
            $worksheet->setCellValue("F{$counter}", $totalPayment);
            $worksheet->setCellValue("G{$counter}", $totalReceivable);

            $counter++;$counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Faktur Belum Lunas Customer.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
