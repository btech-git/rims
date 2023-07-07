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

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $insuranceCompany = Search::bind(new InsuranceCompany('search'), isset($_GET['InsuranceCompany']) ? $_GET['InsuranceCompany'] : array());
        $insuranceCompanyDataProvider = $insuranceCompany->search();

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $insuranceCompanyId = (isset($_GET['InsuranceCompanyId'])) ? $_GET['InsuranceCompanyId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $receivableSummary = new ReceivableSummary($customer->search());
        $receivableSummary->setupLoading();
        $receivableSummary->setupPaging($pageSize, $currentPage);
        $receivableSummary->setupSorting();
        $receivableSummary->setupFilter($customerId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableSummary, $endDate, $branchId);
        }

        $this->render('summary', array(
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'customerId' => $customerId,
            'branchId' => $branchId,
            'insuranceCompany'=>$insuranceCompany,
            'insuranceCompanyDataProvider'=>$insuranceCompanyDataProvider,
            'insuranceCompanyId' => $insuranceCompanyId,
            'endDate' => $endDate,
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

    protected function saveToExcel($receivableSummary, $endDate, $branchId) {
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

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        
        $worksheet->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G3')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor');
        $worksheet->setCellValue('A3', 'Laporan Piutang Customer');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:G5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:G6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:G6')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Name');
        $worksheet->setCellValue('B5', 'Type');

        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Faktur #');
        $worksheet->setCellValue('C6', 'Jatuh Tempo');
        $worksheet->setCellValue('D6', 'Vehicle');
        $worksheet->setCellValue('E6', 'Grand Total');
        $worksheet->setCellValue('F6', 'Payment');
        $worksheet->setCellValue('G6', 'Remaining');
        $worksheet->setCellValue('H6', 'Insurance');
        $counter = 8;

        foreach ($receivableSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->name);
            $worksheet->setCellValue("B{$counter}", $header->customer_type);

            $counter++;
            
            $receivableData = $header->getReceivableReport($endDate, $branchId, $insuranceCompanyId);
            $totalRevenue = 0.00;
            $totalPayment = 0.00;
            $totalReceivable = 0.00;
            foreach ($receivableData as $receivableRow) {
                $revenue = $receivableRow['total_price'];
                $paymentAmount = $receivableRow['payment_amount'];
                $paymentLeft = $receivableRow['payment_left'];
                
                $worksheet->setCellValue("A{$counter}", $receivableRow['invoice_date']);
                $worksheet->setCellValue("B{$counter}", CHtml::encode($receivableRow['invoice_number']));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($receivableRow['due_date']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($receivableRow['vehicle']));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($revenue));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($paymentAmount));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($paymentLeft));
                $worksheet->setCellValue("H{$counter}", CHtml::encode($receivableRow['insurance_name']));
                
                $counter++;
            
                $totalRevenue += $revenue;
                $totalPayment += $paymentAmount;
                $totalReceivable += $paymentLeft;
            }
            
            $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);

            $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->mergeCells("A{$counter}:D{$counter}");
            $worksheet->setCellValue("A{$counter}", 'Total');
            $worksheet->setCellValue("E{$counter}", $totalRevenue);
            $worksheet->setCellValue("F{$counter}", $totalPayment);
            $worksheet->setCellValue("G{$counter}", $totalReceivable);

            $counter++;$counter++;
        }

        for ($col = 'A'; $col !== 'H'; $col++) {
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
