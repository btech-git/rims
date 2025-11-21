<?php

class SaleRetailController extends Controller {

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
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $taxValue = (isset($_GET['TaxValue'])) ? $_GET['TaxValue'] : '';
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        
        $customerSaleReport = InvoiceHeader::getCustomerSaleReport($startDate, $endDate, $customerId, $branchId, $taxValue, $customerType);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($customerSaleReport, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
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
            'customerType' => $customerType,
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
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Rincian Penjualan per Pelanggan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Penjualan per Pelanggan');

        $worksheet->mergeCells('A1:R1');
        $worksheet->mergeCells('A2:R2');
        $worksheet->mergeCells('A3:R3');

        $worksheet->getStyle('A1:R5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:R5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Rincian Penjualan per Customer');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:R5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'ID');
        $worksheet->setCellValue('C5', 'Customer');
        $worksheet->setCellValue('D5', 'Date Last Invoice');
        $worksheet->setCellValue('E5', 'Vehicle ID');
        $worksheet->setCellValue('F5', 'Plate #');
        $worksheet->setCellValue('G5', 'Kendaraan');
        $worksheet->setCellValue('H5', 'Warna');
        $worksheet->setCellValue('I5', 'Odometer');
        $worksheet->setCellValue('J5', 'WO #');
        $worksheet->setCellValue('K5', 'Last Service');
        $worksheet->setCellValue('L5', 'Last Parts');
        $worksheet->setCellValue('M5', 'Invoice #');
        $worksheet->setCellValue('N5', 'Invoice Total');
        $worksheet->setCellValue('O5', 'VSC #');
        $worksheet->setCellValue('P5', 'Note from WO');
        $worksheet->setCellValue('Q5', 'Salesman');
        $worksheet->setCellValue('R5', 'Mechanic');

        $worksheet->getStyle('A5:R5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        
        foreach ($customerSaleReport as $dataItem) {
            $saleReportData = InvoiceHeader::model()->findAll(array(
                'condition' => 'customer_id = :customer_id AND invoice_date BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':customer_id' => $dataItem['customer_id'],
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ),
            ));
            if (!empty($saleReportData)) {
                foreach ($saleReportData as $i => $saleReportRow) {
                    $grandTotal = CHtml::value($saleReportRow, 'total_price'); 
                    $worksheet->getStyle("N{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", $i + 1);
                    $worksheet->setCellValue("B{$counter}", $dataItem['customer_id']);
                    $worksheet->setCellValue("C{$counter}", $dataItem['customer_name']);
                    $worksheet->setCellValue("E{$counter}", CHtml::value($saleReportRow, 'vehicle_id'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($saleReportRow, 'vehicle.plate_number'));
                    $worksheet->setCellValue("G{$counter}", CHtml::value($saleReportRow, 'vehicle.carMake.name') . CHtml::value($saleReportRow, 'vehicle.carModel.name') . CHtml::value($saleReportRow, 'vehicle.carSubModel.name'));
                    $worksheet->setCellValue("H{$counter}", CHtml::value($saleReportRow, 'vehicle.colors.name'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.work_order_number'));
                    $worksheet->setCellValue("M{$counter}", CHtml::value($saleReportRow, 'invoice_number'));
                    $worksheet->setCellValue("N{$counter}", $grandTotal);
                    $worksheet->setCellValue("P{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.note'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.employeeIdSalesPerson.name'));
                    $worksheet->setCellValue("R{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.employeeIdAssignMechanic.name'));
                    $counter++;
                }
            }
        }
        $worksheet->getStyle("A{$counter}:R{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincian_penjualan_per_customer.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
