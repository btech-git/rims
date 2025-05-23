<?php

class PaymentInController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('paymentInReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $paymentIn = Search::bind(new PaymentIn('search'), isset($_GET['PaymentIn']) ? $_GET['PaymentIn'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';
        $customerType = isset($_GET['CustomerType']) ? $_GET['CustomerType'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $paymentInSummary = new PaymentInSummary($paymentIn->search());
        $paymentInSummary->setupLoading();
        $paymentInSummary->setupPaging($pageSize, $currentPage);
        $paymentInSummary->setupSorting();
        $paymentInSummary->setupFilter($startDate, $endDate, $branchId, $customerType, $plateNumber);

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }
        
        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('t.name', $customer->name, true);
        $customerCriteria->compare('t.email', $customer->email, true);
        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($paymentInSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'paymentIn' => $paymentIn,
            'paymentInSummary' => $paymentInSummary,
            'customerId' => $customerId,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'customerType' => $customerType,
            'plateNumber' => $plateNumber,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_name' => CHtml::value($customer, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
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
        $documentProperties->setTitle('Laporan Payment In');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Payment In');

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');

        $worksheet->getStyle('A1:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Payment In');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:P5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Payment #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Customer');
        $worksheet->setCellValue('D5', 'Status');
        $worksheet->setCellValue('E5', 'Payment Type');
        $worksheet->setCellValue('F5', 'Note');
        $worksheet->setCellValue('G5', 'Admin');
        $worksheet->setCellValue('H5', 'Invoice #');
        $worksheet->setCellValue('I5', 'Tanggal');
        $worksheet->setCellValue('J5', 'Kendaraan');
        $worksheet->setCellValue('K5', 'Jumlah');
        $worksheet->setCellValue('L5', 'Pph 23');
        $worksheet->setCellValue('M5', 'Total');
        $worksheet->setCellValue('N5', 'Memo');

        $worksheet->getStyle('A5:P5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $totalPayment = 0.00;
        foreach ($dataProvider->data as $header) {
            foreach ($header->paymentInDetails as $detail) {
                $paymentAmount = CHtml::value($detail, 'totalAmount');

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->payment_number));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->payment_date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'status')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'paymentType.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'notes')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_date')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'invoiceHeader.vehicle.plate_number')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'amount')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'tax_service_amount')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode($paymentAmount));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'memo')));

                $counter++;
                $totalPayment += $paymentAmount;
            }
        }
        
        $worksheet->getStyle("J{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("M{$counter}", CHtml::encode($totalPayment));        

        for ($col = 'A'; $col !== 'P'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Payment In.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
