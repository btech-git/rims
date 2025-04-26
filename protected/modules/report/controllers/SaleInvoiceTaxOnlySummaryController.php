<?php

class SaleInvoiceTaxOnlySummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleTaxReport'))) {
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
        $worksheet->setCellValue('C6', 'Customer');
        $worksheet->setCellValue('D6', 'Amount');
        $worksheet->setCellValue('E6', 'Parts (Rp)');
        $worksheet->setCellValue('F6', 'Jasa (Rp)');
        $worksheet->setCellValue('G6', 'DPP Parts');
        $worksheet->setCellValue('H6', 'DPP Jasa');
        $worksheet->setCellValue('I6', 'Total DPP');
        $worksheet->setCellValue('J6', 'Ppn');
        $worksheet->setCellValue('K6', 'Pph');
        $worksheet->setCellValue('L6', 'Total');
        $worksheet->setCellValue('M6', 'SPK #');
        $worksheet->setCellValue('N6', 'Faktur Pajak #');
        $worksheet->setCellValue('O6', 'FP Amount');
        $worksheet->setCellValue('P6', 'Bupot #');

        $counter = 7;

        $grandTotalSubAfterTax = 0;
        $grandTotalProductPriceAfterTax = 0;
        $grandTotalServicePriceAfterTax = 0;
        $grandTotalProductPrice = 0;
        $grandTotalServicePrice = 0;
        $grandTotalSubTotal = 0;
        $grandTotalPpnTotal = 0;
        $grandTotalPphTotal = 0;
        $grandTotalPrice = 0;
        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            $subTotalAfterTax = CHtml::value($header, 'subTotalAfterTax'); 
            $productPriceAfterTax = CHtml::value($header, 'productPriceAfterTax');
            $servicePriceAfterTax = CHtml::value($header, 'servicePriceAfterTax');
            $productPrice = CHtml::value($header, 'product_price'); 
            $servicePrice = CHtml::value($header, 'service_price');
            $subTotal = CHtml::value($header, 'subTotal');
            $ppnTotal = CHtml::value($header, 'ppn_total'); 
            $pphTotal = CHtml::value($header, 'pph_total');
            $totalPrice = CHtml::value($header, 'total_price');
            
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'invoice_date')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'invoice_number')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode($subTotalAfterTax));
            $worksheet->setCellValue("E{$counter}", CHtml::encode($productPriceAfterTax));
            $worksheet->setCellValue("F{$counter}", CHtml::encode($servicePriceAfterTax));
            $worksheet->setCellValue("G{$counter}", CHtml::encode($productPrice));
            $worksheet->setCellValue("H{$counter}", CHtml::encode($servicePrice));
            $worksheet->setCellValue("I{$counter}", CHtml::encode($subTotal));
            $worksheet->setCellValue("J{$counter}", CHtml::encode($ppnTotal));
            $worksheet->setCellValue("K{$counter}", CHtml::encode($pphTotal));
            $worksheet->setCellValue("L{$counter}", CHtml::encode($totalPrice));
            $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.work_order_number')));
            
            $grandTotalSubAfterTax += $subTotalAfterTax;
            $grandTotalProductPriceAfterTax += $productPriceAfterTax;
            $grandTotalServicePriceAfterTax += $servicePriceAfterTax;
            $grandTotalProductPrice += $productPrice;
            $grandTotalServicePrice += $servicePrice;
            $grandTotalSubTotal += $subTotal;
            $grandTotalPpnTotal += $ppnTotal;
            $grandTotalPphTotal += $pphTotal;
            $grandTotalPrice += $totalPrice;
            
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:M{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("D{$counter}:M{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("B{$counter}", 'Total');
        $worksheet->setCellValue("C{$counter}", 'Rp');
        $worksheet->setCellValue("D{$counter}", $grandTotalSubAfterTax);
        $worksheet->setCellValue("E{$counter}", $grandTotalProductPriceAfterTax);
        $worksheet->setCellValue("F{$counter}", $grandTotalServicePriceAfterTax);
        $worksheet->setCellValue("G{$counter}", $grandTotalProductPrice);
        $worksheet->setCellValue("H{$counter}", $grandTotalServicePrice);
        $worksheet->setCellValue("I{$counter}", $grandTotalSubTotal);
        $worksheet->setCellValue("J{$counter}", $grandTotalPpnTotal);
        $worksheet->setCellValue("K{$counter}", $grandTotalPphTotal);
        $worksheet->setCellValue("L{$counter}", $grandTotalPrice);

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
