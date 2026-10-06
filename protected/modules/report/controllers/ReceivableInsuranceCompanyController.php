<?php

class ReceivableInsuranceCompanyController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('insuranceUnpaidInvoiceReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $insuranceCompanyId = (isset($_GET['InsuranceCompanyId'])) ? $_GET['InsuranceCompanyId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $insuranceCompany = Search::bind(new InsuranceCompany('search'), isset($_GET['InsuranceCompany']) ? $_GET['InsuranceCompany'] : array());
        $insuranceCompanyDataProvider = $insuranceCompany->search();
        $insuranceCompanyDataProvider->pagination->pageVar = 'page_dialog';

        $receivableSummary = new ReceivableInsuranceCompanySummary($insuranceCompany->search());
        $receivableSummary->setupLoading();
        $receivableSummary->setupPaging($pageSize, $currentPage);
        $receivableSummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
            'plateNumber' => $plateNumber,
            'insuranceCompanyId' => $insuranceCompanyId,
        );
        $receivableSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableSummary, $endDate, $branchId, $plateNumber);
        }

        $this->render('summary', array(
            'branchId' => $branchId,
            'plateNumber' => $plateNumber,
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

    protected function saveToExcel($receivableSummary, $endDate, $branchId, $plateNumber) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Faktur Belum Lunas Asuransi');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Belum Lunas Asuransi');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        
        $worksheet->getStyle('A1:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J6')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Faktur Belum Lunas Asuransi');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:J5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:J6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Name');
        $worksheet->setCellValue('B5', 'COA');

        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Faktur #');
        $worksheet->setCellValue('C6', 'Jatuh Tempo');
        $worksheet->setCellValue('D6', 'Umur (hari)');
        $worksheet->setCellValue('E6', 'Customer');
        $worksheet->setCellValue('F6', 'Kendaraan');
        $worksheet->setCellValue('G6', 'Plat #');
        $worksheet->setCellValue('H6', 'Grand Total');
        $worksheet->setCellValue('I6', 'Payment');
        $worksheet->setCellValue('J6', 'Remaining');
        
        $counter = 7;

        foreach ($receivableSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->name);
            $worksheet->setCellValue("B{$counter}", $header->coa->name);

            $counter++;
            
            $receivableData = $header->getReceivableReport($endDate, $branchId, $plateNumber);
            $totalRevenue = '0.00';
            $totalPayment = '0.00';
            $totalReceivable = '0.00';
            foreach ($receivableData as $receivableRow) {
                $revenue = $receivableRow['total_price'];
                $paymentAmount = $receivableRow['amount'];
                $paymentLeft = $receivableRow['remaining'];
                $outstandingDays = date_diff(date_create($receivableRow['invoice_date']), date_create(date('Y-m-d')));
                
                $worksheet->setCellValue("A{$counter}", $receivableRow['invoice_date']);
                $worksheet->setCellValue("B{$counter}", $receivableRow['invoice_number']);
                $worksheet->setCellValue("C{$counter}", $receivableRow['due_date']);
                $worksheet->setCellValue("D{$counter}", $outstandingDays->format("%a days"));
                $worksheet->setCellValue("E{$counter}", $receivableRow['customer_name']);
                $worksheet->setCellValue("F{$counter}", $receivableRow['plate_number']);
                $worksheet->setCellValue("G{$counter}", $receivableRow['car_make'] . ' - ' . $receivableRow['car_model'] . ' - ' . $receivableRow['car_sub_model']);
                $worksheet->setCellValue("H{$counter}", $revenue);
                $worksheet->setCellValue("I{$counter}", $paymentAmount);
                $worksheet->setCellValue("J{$counter}", $paymentLeft);
                
                $totalRevenue += $revenue;
                $totalPayment += $paymentAmount;
                $totalReceivable += $paymentLeft;
                
                $counter++;
            }
            
            $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
            $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            
            $worksheet->mergeCells("A{$counter}:G{$counter}");
            
            $worksheet->setCellValue("A{$counter}", 'Total');
            $worksheet->setCellValue("H{$counter}", $totalRevenue);
            $worksheet->setCellValue("I{$counter}", $totalPayment);
            $worksheet->setCellValue("J{$counter}", $totalReceivable);

            $counter++;$counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="faktur_belum_lunas_asuransi.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
