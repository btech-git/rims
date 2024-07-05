<?php

class ReceivableTransactionController extends Controller {

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

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $insuranceCompanyId = (isset($_GET['InsuranceCompanyId'])) ? $_GET['InsuranceCompanyId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $insuranceCompany = Search::bind(new InsuranceCompany('search'), isset($_GET['InsuranceCompany']) ? $_GET['InsuranceCompany'] : array());
        $insuranceCompanyDataProvider = $insuranceCompany->search();

        $receivableSummary = new ReceivableTransactionSummary($customer->searchByReceivableTransactionReport($startDate, $endDate, $branchId, $insuranceCompanyId, $customerType, $plateNumber));
        $receivableSummary->setupLoading();
        $receivableSummary->setupPaging($pageSize, $currentPage);
        $receivableSummary->setupSorting();
        $receivableSummary->setupFilter($customerId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableSummary, $startDate, $endDate, $branchId, $insuranceCompanyId, $plateNumber);
        }

        $this->render('summary', array(
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'customerId' => $customerId,
            'plateNumber' => $plateNumber,
            'branchId' => $branchId,
            'insuranceCompany'=>$insuranceCompany,
            'insuranceCompanyDataProvider'=>$insuranceCompanyDataProvider,
            'insuranceCompanyId' => $insuranceCompanyId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerType' => $customerType,
            'receivableSummary' => $receivableSummary,
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
                'customer_type' => CHtml::value($customer, 'customer_type'),
                'customer_mobile_phone' => CHtml::value($customer, 'mobile_phone'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonInsuranceCompany() {
        if (Yii::app()->request->isAjaxRequest) {
            $insuranceCompanyId = (isset($_POST['InsuranceCompanyId'])) ? $_POST['InsuranceCompanyId'] : '';
            $insuranceCompany = InsuranceCompany::model()->findByPk($insuranceCompanyId);

            $object = array(
                'insurance_name' => CHtml::value($insuranceCompany, 'name'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($receivableSummary, $startDate, $endDate, $branchId, $insuranceCompanyId, $plateNumber) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Piutang Customer');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Piutang Customer');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        
        $worksheet->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J3')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor');
        $worksheet->setCellValue('A3', 'Laporan Piutang Customer');
        $worksheet->setCellValue('A3', 'Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:J5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:J6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:J6')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Name');
        $worksheet->setCellValue('B5', 'Type');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Faktur #');
        $worksheet->setCellValue('E5', 'Jatuh Tempo');
        $worksheet->setCellValue('F5', 'Vehicle');
        $worksheet->setCellValue('G5', 'Grand Total');
        $worksheet->setCellValue('H5', 'Payment');
        $worksheet->setCellValue('I5', 'Remaining');
        $worksheet->setCellValue('J5', 'Insurance');
        $counter = 8;

        foreach ($receivableSummary->dataProvider->data as $header) {

            $receivableData = $header->getReceivableReport($startDate, $endDate, $branchId, $insuranceCompanyId, $plateNumber);
            $totalRevenue = 0.00;
            $totalPayment = 0.00;
            $totalReceivable = 0.00;
            foreach ($receivableData as $receivableRow) {
                $revenue = $receivableRow['total_price'];
                $paymentAmount = $receivableRow['payment_amount'];
                $paymentLeft = $receivableRow['payment_left'];
                
                $worksheet->setCellValue("A{$counter}", $header->name);
                $worksheet->setCellValue("B{$counter}", $header->customer_type);
                $worksheet->setCellValue("C{$counter}", $receivableRow['invoice_date']);
                $worksheet->setCellValue("D{$counter}", CHtml::encode($receivableRow['invoice_number']));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($receivableRow['due_date']));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($receivableRow['vehicle']));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($revenue));
                $worksheet->setCellValue("H{$counter}", CHtml::encode($paymentAmount));
                $worksheet->setCellValue("I{$counter}", CHtml::encode($paymentLeft));
                $worksheet->setCellValue("J{$counter}", CHtml::encode($receivableRow['insurance_name']));
                
                $counter++;
            
                $totalRevenue += $revenue;
                $totalPayment += $paymentAmount;
                $totalReceivable += $paymentLeft;
            }
            
            $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);

            $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->mergeCells("A{$counter}:F{$counter}");
            $worksheet->setCellValue("A{$counter}", 'Total');
            $worksheet->setCellValue("G{$counter}", $totalRevenue);
            $worksheet->setCellValue("H{$counter}", $totalPayment);
            $worksheet->setCellValue("I{$counter}", $totalReceivable);

            $counter++;$counter++;
        }

        for ($col = 'A'; $col !== 'L'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Piutang Customer.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
