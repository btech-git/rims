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
            if (!(Yii::app()->user->checkAccess('customerReceivableReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());

        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleInvoiceSummary = new ReceivableSummary($invoiceHeader->search());
        $saleInvoiceSummary->setupLoading();
        $saleInvoiceSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSummary->setupSorting();
        $filters = array(
            'plateNumber' => $plateNumber,
            'customerType' => $customerType,
        );
        $saleInvoiceSummary->setupFilter($filters);

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->criteria->addCondition('t.customer_type = "Company" '); 

        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcel($saleInvoiceSummary);
        }

        $this->render('summary', array(
            'invoiceHeader' => $invoiceHeader,
            'saleInvoiceSummary' => $saleInvoiceSummary,
            'currentSort' => $currentSort,
            'plateNumber' => $plateNumber,
            'customerType' => $customerType,
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
        ));
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['InvoiceHeader']['customer_id'])) ? $_POST['InvoiceHeader']['customer_id'] : '';
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

    public function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->total_price;

        return $grandTotal;
    }

    public function reportTotalPayment($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->payment_amount;

        return $grandTotal;
    }

    public function reportTotalRemaining($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->payment_left;

        return $grandTotal;
    }

    protected function saveToExcel($saleInvoiceSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Piutang Customer');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Piutang Customer');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        $worksheet->mergeCells('A4:J4');
        $worksheet->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Piutang Customer');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->getStyle("A6:J6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A7:J7")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:J6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Faktur #');
        $worksheet->setCellValue('C6', 'Jatuh Tempo');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Vehicle');
        $worksheet->setCellValue('F6', 'Branch');
        $worksheet->setCellValue('G6', 'Status');
        $worksheet->setCellValue('H6', 'Grand Total');
        $worksheet->setCellValue('I6', 'Payment');
        $worksheet->setCellValue('J6', 'Remaining');

        $worksheet->getStyle('A7:J7')->getFont()->setBold(true);
        $worksheet->setCellValue('A7', 'Tanggal Bayar');
        $worksheet->setCellValue('B7', 'Payment In #');
        $worksheet->setCellValue('C7', 'Payment Type');
        $worksheet->setCellValue('D7', 'Jumlah (Rp)');
        $worksheet->setCellValue('E7', 'Notes');
        $counter = 9;

        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->invoice_date);
            $worksheet->setCellValue("B{$counter}", $header->invoice_number);
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'due_date')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'branch.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'total_price')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'payment_amount')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'payment_left')));

            $counter++;
            
            foreach ($header->paymentIns as $detail) {
                $worksheet->setCellValue("A{$counter}", $detail->payment_date);
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($detail, 'payment_number')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($detail, 'paymentType.name')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($detail, 'payment_amount')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'notes')));
                
            }
        }

        $worksheet->getStyle("A{$counter}:Y{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:Y{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("S{$counter}:X{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("P{$counter}:V{$counter}");
        $worksheet->setCellValue("P{$counter}", 'Total Penjualan');
        $worksheet->setCellValue("W{$counter}", 'Rp');
        $worksheet->setCellValue("X{$counter}", $this->reportGrandTotal($saleInvoiceSummary->dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'X'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        // We'll be outputting an excel file
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Piutang Customer.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
