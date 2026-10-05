<?php

class SaleInvoiceOwnRiskController extends Controller {

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

        $saleInvoiceInsuranceOwnRisk = Search::bind(new SaleInvoiceInsuranceOwnRisk('search'), isset($_GET['SaleInvoiceInsuranceOwnRisk']) ? $_GET['SaleInvoiceInsuranceOwnRisk'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $customerId = isset($_GET['SaleInvoiceInsuranceOwnRisk']['customer_id']) ? $_GET['SaleInvoiceInsuranceOwnRisk']['customer_id'] : null;
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        $vehicleId = (isset($_GET['VehicleId'])) ? $_GET['VehicleId'] : '';
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 'id DESC', 'limit' => 100));

        $saleInvoiceOwnRiskSummary = new SaleInvoiceOwnRiskSummary($saleInvoiceInsuranceOwnRisk->searchByReport());
        $saleInvoiceOwnRiskSummary->setupLoading();
        $saleInvoiceOwnRiskSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceOwnRiskSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'vehicleId' => $vehicleId,
            'customerId' => $customerId,
            'customerType' => $customerType,
            'branchId' => $branchId,
        );
        $saleInvoiceOwnRiskSummary->setupFilter($filters);

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleInvoiceOwnRiskSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'saleInvoiceInsuranceOwnRisk' => $saleInvoiceInsuranceOwnRisk,
            'saleInvoiceOwnRiskSummary' => $saleInvoiceOwnRiskSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'vehicleId' => $vehicleId,
            'customerId' => $customerId,
            'customerType' => $customerType,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'vehicles' => $vehicles,
            'branchId' => $branchId,
        ));
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['SaleInvoiceInsuranceOwnRisk']['customer_id'])) ? $_POST['SaleInvoiceInsuranceOwnRisk']['customer_id'] : '';
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
            $customerId = isset($_GET['SaleInvoiceInsuranceOwnRisk']['customer_id']) ? $_GET['SaleInvoiceInsuranceOwnRisk']['customer_id'] : 0;
            $vehicleId = isset($_GET['VehicleId']) ? $_GET['VehicleId'] : '';
            $vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 'id DESC', 'limit' => 100));

            $this->renderPartial('_vehicleList', array(
                'vehicles' => $vehicles,
                'vehicleId' => $vehicleId,
            ));
        }
    }

    public function reportGrandTotal($dataProvider) {
        $grandTotal = '0.00';

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->total_price;
        }

        return $grandTotal;
    }

    public function reportTotalPayment($dataProvider) {
        $grandTotal = '0.00';

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->payment_amount;
        }

        return $grandTotal;
    }

    public function reportTotalRemaining($dataProvider) {
        $grandTotal = '0.00';

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->payment_left;
        }

        return $grandTotal;
    }

    protected function saveToExcel($saleInvoiceOwnRiskSummary, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Faktur Penjualan Asuransi OR');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Penjualan Asuransi OR');

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');
        
        $worksheet->getStyle('A1:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Faktur Penjualan Asuransi OR');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:P5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:P5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Faktur #');
        $worksheet->setCellValue('C5', 'RG #');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Plat #');
        $worksheet->setCellValue('F5', 'Kendaraan');
        $worksheet->setCellValue('G5', 'Asuransi');
        $worksheet->setCellValue('H5', 'Status');
        $worksheet->setCellValue('I5', 'Memo');
        $worksheet->setCellValue('J5', 'Total');
        $worksheet->setCellValue('K5', 'Payment');
        $worksheet->setCellValue('L5', 'Remaining');
        $worksheet->setCellValue('M5', 'Payment #');
        $worksheet->setCellValue('N5', 'Tanggal');
        $worksheet->setCellValue('O5', 'Own Risk');
        $worksheet->setCellValue('P5', 'Memo');

        $counter = 6;

        $totalInvoice = '0.00';
        $totalPaymentAmount = '0.00';
        $totalPaymentLeft = '0.00';
        $totalPaymentSum = '0.00';
        
        foreach ($saleInvoiceOwnRiskSummary->dataProvider->data as $header) {
            $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('sale_invoice_insurance_own_risk_id' => $header->id));
            $invoiceAmount = CHtml::value($header, 'amount_invoice');
            $paymentAmount = CHtml::value($header, 'amount_payment');
            $paymentLeft = CHtml::value($header, 'payment_remaining');
            $amount = CHtml::value($paymentInDetail, 'own_risk_amount');
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transaction_date'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'transaction_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'registrationTransaction.transaction_number'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'insuranceCompany.name'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'note'));
            $worksheet->setCellValue("J{$counter}", $invoiceAmount);
            $worksheet->setCellValue("K{$counter}", $paymentAmount);
            $worksheet->setCellValue("L{$counter}", $paymentLeft);
            $worksheet->setCellValue("M{$counter}", CHtml::value($paymentInDetail, 'paymentIn.payment_number'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($paymentInDetail, 'paymentIn.payment_date'));
            $worksheet->setCellValue("O{$counter}", $amount);
            $worksheet->setCellValue("P{$counter}", CHtml::value($paymentInDetail, 'memo'));

            $totalInvoice += $invoiceAmount;
            $totalPaymentAmount += $paymentAmount;
            $totalPaymentLeft += $paymentLeft;
            $totalPaymentSum += $amount;
            
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:P{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:P{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("H{$counter}", 'Total');
        $worksheet->setCellValue("I{$counter}", 'Rp');
        $worksheet->setCellValue("J{$counter}", $totalInvoice);
        $worksheet->setCellValue("K{$counter}", $totalPaymentAmount);
        $worksheet->setCellValue("L{$counter}", $totalPaymentLeft);
        $worksheet->setCellValue("O{$counter}", $totalPaymentSum);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="faktur_penjualan_asuransi_or.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}