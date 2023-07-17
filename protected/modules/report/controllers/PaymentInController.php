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

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $paymentInSummary = new PaymentInSummary($paymentIn->search());
        $paymentInSummary->setupLoading();
        $paymentInSummary->setupPaging($pageSize, $currentPage);
        $paymentInSummary->setupSorting();
        $paymentInSummary->setupFilter($startDate, $endDate, $branchId, $customerType);

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
            $this->saveToExcel($paymentInSummary, $branchId, $paymentInSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'paymentIn' => $paymentIn,
            'paymentInSummary' => $paymentInSummary,
            'customerId' => $customerId,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'customerType' => $customerType,
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

    protected function saveToExcel($paymentInSummary, $branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Payment In');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Payment In');

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);
        $worksheet->getColumnDimension('I')->setAutoSize(true);
        $worksheet->getColumnDimension('J')->setAutoSize(true);

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Payment In');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Payment #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Amount');
        $worksheet->setCellValue('D5', 'Note');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Vehicle');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Payment Type');
        $worksheet->setCellValue('I5', 'Branch');
        $worksheet->setCellValue('J5', 'Admin');

        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $totalPayment = 0.00;
        foreach ($dataProvider->data as $header) {
            $paymentAmount = CHtml::value($header, 'payment_amount');
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->payment_number));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->payment_date));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($paymentAmount));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'notes')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'paymentType.name')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));

            $counter++;
            $totalPayment += $paymentAmount;
        }
        
        $worksheet->getStyle("B{$counter}:D{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("C{$counter}", CHtml::encode($totalPayment));        

        for ($col = 'A'; $col !== 'L'; $col++) {
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
