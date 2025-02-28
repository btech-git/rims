<?php

class SaleInvoiceTaxOnlySummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleSummaryReport'))) {
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
        $customerId = isset($_GET['InvoiceHeader']['customer_id']) ? $_GET['InvoiceHeader']['customer_id'] : null;
        $branchId = isset($_GET['InvoiceHeader']['branch_id']) ? $_GET['InvoiceHeader']['branch_id'] : null;
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        $vehicleId = (isset($_GET['VehicleId'])) ? $_GET['VehicleId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 'id DESC', 'limit' => 100));

        $saleInvoiceSummary = new SaleInvoiceTaxOnlySummary($invoiceHeader->search());
        $saleInvoiceSummary->setupLoading();
        $saleInvoiceSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'vehicleId' => $vehicleId,
            'customerId' => $customerId,
            'customerType' => $customerType,
        );
        $saleInvoiceSummary->setupFilter($filters);

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleInvoiceSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'invoiceHeader' => $invoiceHeader,
            'saleInvoiceSummary' => $saleInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'vehicleId' => $vehicleId,
            'customerId' => $customerId,
            'customerType' => $customerType,
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'vehicles' => $vehicles,
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

    public function actionAjaxHtmlUpdateVehicleList() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = isset($_GET['InvoiceHeader']['customer_id']) ? $_GET['InvoiceHeader']['customer_id'] : 0;
            $vehicleId = isset($_GET['VehicleId']) ? $_GET['VehicleId'] : '';
            $vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 'id DESC', 'limit' => 100));

            $this->renderPartial('_vehicleList', array(
                'vehicles' => $vehicles,
                'vehicleId' => $vehicleId,
            ));
        }
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
        $documentProperties->setTitle('Laporan Faktur Penjualan PPn');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Faktur Penjualan PPn');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');
        $worksheet->mergeCells('A4:O4');
        
        $worksheet->getStyle('A1:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Faktur Penjualan PPn');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:O6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:O6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:O6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Faktur #');
        $worksheet->setCellValue('C6', 'Amount');
        $worksheet->setCellValue('D6', 'Parts (Rp)');
        $worksheet->setCellValue('E6', 'Jasa (Rp)');
        $worksheet->setCellValue('F6', 'DPP Parts');
        $worksheet->setCellValue('G6', 'DPP Jasa');
        $worksheet->setCellValue('H6', 'Total DPP');
        $worksheet->setCellValue('I6', 'Ppn');
        $worksheet->setCellValue('J6', 'Pph');
        $worksheet->setCellValue('K6', 'Total');
        $worksheet->setCellValue('L6', 'SPK #');
        $worksheet->setCellValue('M6', 'Faktur Pajak #');
        $worksheet->setCellValue('N6', 'FP Amount');
        $worksheet->setCellValue('O6', 'Bupot #');

        $counter = 7;

//        $grandTotalSale = 0;
//        $grandTotalPayment = 0;
//        $grandTotalRemaining = 0;
        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
//            $totalPrice = $header->total_price; 
//            $totalPayment = $header->payment_amount;
//            $totalRemaining = $header->payment_left;
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'invoice_date')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'invoice_number')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'subTotalAfterTax')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'productPriceAfterTax')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'servicePriceAfterTax')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'product_price')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'service_price')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'subTotal')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'ppn_total')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'pph_total')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'total_price')));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.work_order_number')));
//            $grandTotalSale += $totalPrice;
//            $grandTotalPayment += $totalPayment;
//            $grandTotalRemaining += $totalRemaining;
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:O{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:O{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("C{$counter}:K{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//        $worksheet->setCellValue("F{$counter}", 'Total');
//        $worksheet->setCellValue("G{$counter}", 'Rp');
//        $worksheet->setCellValue("H{$counter}", $grandTotalSale);
//        $worksheet->setCellValue("I{$counter}", $grandTotalPayment);
//        $worksheet->setCellValue("J{$counter}", $grandTotalRemaining);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Faktur Penjualan PPn.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
