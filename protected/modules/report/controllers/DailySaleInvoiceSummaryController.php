<?php

class DailySaleInvoiceSummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
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
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $saleInvoiceSummary = new DailySaleInvoiceSummary($invoiceHeader->search());
        $saleInvoiceSummary->setupLoading();
        $saleInvoiceSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerType' => $customerType,
            'plateNumber' => $plateNumber,
        );
        $saleInvoiceSummary->setupFilter($filters);

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleInvoiceSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'invoiceHeader' => $invoiceHeader,
            'saleInvoiceSummary' => $saleInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerType' => $customerType,
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'plateNumber' => $plateNumber,
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

    protected function saveToExcel($saleInvoiceSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Faktur Penjualan Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Penjualan Harian');

        $worksheet->mergeCells('A1:V1');
        $worksheet->mergeCells('A2:V2');
        $worksheet->mergeCells('A3:V3');
       
        $worksheet->getStyle('A1:V5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:V5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Faktur Penjualan Harian (Rincian & Detail)');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:V5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:V5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Faktur #');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Plat #');
        $worksheet->setCellValue('F5', 'Kendaraan');
        $worksheet->setCellValue('G5', 'Asuransi');
        $worksheet->setCellValue('H5', 'Amount');
        $worksheet->setCellValue('I5', 'Parts (Rp)');
        $worksheet->setCellValue('J5', 'Jasa (Rp)');
        $worksheet->setCellValue('K5', 'DPP Parts');
        $worksheet->setCellValue('L5', 'DPP Jasa');
        $worksheet->setCellValue('M5', 'Total DPP');
        $worksheet->setCellValue('N5', 'Ppn');
        $worksheet->setCellValue('O5', 'Pph');
        $worksheet->setCellValue('P5', 'Total');
        $worksheet->setCellValue('Q5', 'WO #');
        $worksheet->setCellValue('R5', 'SPK Customer #');
        $worksheet->setCellValue('S5', 'Faktur Pajak #');
        $worksheet->setCellValue('T5', 'FP DPP');
        $worksheet->setCellValue('U5', 'FP PPn');
        $worksheet->setCellValue('V5', 'Bupot #');

        $counter = 6;

        $grandTotalSubAfterTax = '0.00';
        $grandTotalProductPriceAfterTax = '0.00';
        $grandTotalServicePriceAfterTax = '0.00';
        $grandTotalProductPrice = '0.00';
        $grandTotalServicePrice = '0.00';
        $grandTotalSubTotal = '0.00';
        $grandTotalPpnTotal = '0.00';
        $grandTotalPphTotal = '0.00';
        $grandTotalPrice = '0.00';
        
        foreach ($saleInvoiceSummary->dataProvider->data as $i => $header) {
            $subTotalAfterTax = CHtml::value($header, 'subTotalAfterTax'); 
            $productPriceAfterTax = CHtml::value($header, 'productPriceAfterTax');
            $servicePriceAfterTax = CHtml::value($header, 'servicePriceAfterTax');
            $productPrice = CHtml::value($header, 'product_price'); 
            $servicePrice = CHtml::value($header, 'service_price');
            $subTotal = CHtml::value($header, 'subTotal');
            $ppnTotal = CHtml::value($header, 'ppn_total'); 
            $pphTotal = CHtml::value($header, 'pph_total');
            $totalPrice = CHtml::value($header, 'total_price');
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'insuranceCompany.name'));
            $worksheet->setCellValue("H{$counter}", $subTotalAfterTax);
            $worksheet->setCellValue("I{$counter}", $productPriceAfterTax);
            $worksheet->setCellValue("J{$counter}", $servicePriceAfterTax);
            $worksheet->setCellValue("K{$counter}", $productPrice);
            $worksheet->setCellValue("L{$counter}", $servicePrice);
            $worksheet->setCellValue("M{$counter}", $subTotal);
            $worksheet->setCellValue("N{$counter}", $ppnTotal);
            $worksheet->setCellValue("O{$counter}", $pphTotal);
            $worksheet->setCellValue("P{$counter}", $totalPrice);
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'registrationTransaction.work_order_number'));
            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'registrationTransaction.customer_work_order_number'));
            $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'transaction_tax_number'));
            $worksheet->setCellValue("T{$counter}", CHtml::value($header, 'grand_total_coretax'));
            $worksheet->setCellValue("U{$counter}", CHtml::value($header, 'tax_amount_coretax'));
            $worksheet->setCellValue("V{$counter}", CHtml::value($header, 'coretax_receipt_number'));
            
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

        $worksheet->getStyle("A{$counter}:V{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:V{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("F{$counter}", 'Total');
        $worksheet->setCellValue("G{$counter}", 'Rp');
        $worksheet->setCellValue("H{$counter}", $grandTotalSubAfterTax);
        $worksheet->setCellValue("I{$counter}", $grandTotalProductPriceAfterTax);
        $worksheet->setCellValue("J{$counter}", $grandTotalServicePriceAfterTax);
        $worksheet->setCellValue("K{$counter}", $grandTotalProductPrice);
        $worksheet->setCellValue("L{$counter}", $grandTotalServicePrice);
        $worksheet->setCellValue("M{$counter}", $grandTotalSubTotal);
        $worksheet->setCellValue("N{$counter}", $grandTotalPpnTotal);
        $worksheet->setCellValue("O{$counter}", $grandTotalPphTotal);
        $worksheet->setCellValue("P{$counter}", $grandTotalPrice);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=faktur_penjualan_ppn_$endDate.xls");
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
