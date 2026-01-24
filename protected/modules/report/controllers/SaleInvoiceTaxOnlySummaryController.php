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

        $worksheet->mergeCells('A1:T1');
        $worksheet->mergeCells('A2:T2');
        $worksheet->mergeCells('A3:T3');
       
        $worksheet->getStyle('A1:T5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:T5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Faktur Penjualan PPn');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:T5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:T5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Faktur #');
        $worksheet->setCellValue('C5', 'Customer');
        $worksheet->setCellValue('D5', 'Plat #');
        $worksheet->setCellValue('E5', 'Kendaraan');
        $worksheet->setCellValue('F5', 'Asuransi');
        $worksheet->setCellValue('G5', 'Amount');
        $worksheet->setCellValue('H5', 'Parts (Rp)');
        $worksheet->setCellValue('I5', 'Jasa (Rp)');
        $worksheet->setCellValue('J5', 'DPP Parts');
        $worksheet->setCellValue('K5', 'DPP Jasa');
        $worksheet->setCellValue('L5', 'Total DPP');
        $worksheet->setCellValue('M5', 'Ppn');
        $worksheet->setCellValue('N5', 'Pph');
        $worksheet->setCellValue('O5', 'Total');
        $worksheet->setCellValue('P5', 'SPK #');
        $worksheet->setCellValue('Q5', 'Faktur Pajak #');
        $worksheet->setCellValue('R5', 'FP DPP');
        $worksheet->setCellValue('S5', 'FP PPn');
        $worksheet->setCellValue('T5', 'Bupot #');

        $counter = 7;

        $grandTotalSubAfterTax = '0.00';
        $grandTotalProductPriceAfterTax = '0.00';
        $grandTotalServicePriceAfterTax = '0.00';
        $grandTotalProductPrice = '0.00';
        $grandTotalServicePrice = '0.00';
        $grandTotalSubTotal = '0.00';
        $grandTotalPpnTotal = '0.00';
        $grandTotalPphTotal = '0.00';
        $grandTotalPrice = '0.00';
        
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
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'insuranceCompany.name'));
            $worksheet->setCellValue("G{$counter}", $subTotalAfterTax);
            $worksheet->setCellValue("H{$counter}", $productPriceAfterTax);
            $worksheet->setCellValue("I{$counter}", $servicePriceAfterTax);
            $worksheet->setCellValue("J{$counter}", $productPrice);
            $worksheet->setCellValue("K{$counter}", $servicePrice);
            $worksheet->setCellValue("L{$counter}", $subTotal);
            $worksheet->setCellValue("M{$counter}", $ppnTotal);
            $worksheet->setCellValue("N{$counter}", $pphTotal);
            $worksheet->setCellValue("O{$counter}", $totalPrice);
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'registrationTransaction.work_order_number'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'transaction_tax_number'));
            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'grand_total_coretax'));
            $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'tax_amount_coretax'));
            $worksheet->setCellValue("T{$counter}", CHtml::value($header, 'coretax_receipt_number'));
            
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

        $worksheet->getStyle("A{$counter}:T{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:T{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("D{$counter}:T{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("E{$counter}", 'Total');
        $worksheet->setCellValue("F{$counter}", 'Rp');
        $worksheet->setCellValue("G{$counter}", $grandTotalSubAfterTax);
        $worksheet->setCellValue("H{$counter}", $grandTotalProductPriceAfterTax);
        $worksheet->setCellValue("I{$counter}", $grandTotalServicePriceAfterTax);
        $worksheet->setCellValue("J{$counter}", $grandTotalProductPrice);
        $worksheet->setCellValue("K{$counter}", $grandTotalServicePrice);
        $worksheet->setCellValue("L{$counter}", $grandTotalSubTotal);
        $worksheet->setCellValue("M{$counter}", $grandTotalPpnTotal);
        $worksheet->setCellValue("N{$counter}", $grandTotalPphTotal);
        $worksheet->setCellValue("O{$counter}", $grandTotalPrice);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=laporan_faktur_penjualan_ppn_$endDate.xls");
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
