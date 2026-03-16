<?php

class OutstandingSaleRetailController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleRetailReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : null;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : null;
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
            $customerId = null;
            $plateNumber = '';
            $branchId = null;
            $pageSize = '';
            $currentPage = '';
            $currentSort = '';
        }
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $outstandingSaleRetailSummary = new OutstandingSaleRetailSummary($registrationTransaction->searchReport());
        $outstandingSaleRetailSummary->setupLoading();
        $outstandingSaleRetailSummary->setupPaging($pageSize, $currentPage);
        $outstandingSaleRetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'customerId' => $customerId,
            'plateNumber' => $plateNumber,
        );
        $outstandingSaleRetailSummary->setupFilter($filters);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($outstandingSaleRetailSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'registrationTransaction' => $registrationTransaction,
            'outstandingSaleRetailSummary' => $outstandingSaleRetailSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
            'customerId' => $customerId,
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'plateNumber' => $plateNumber,
        ));
    }

    public function actionAjaxJsonCustomer() {
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

    protected function saveToExcel($outstandingSaleRetailSummary, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Outstanding Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Outstanding Penjualan');

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');
        
        $worksheet->getStyle('A1:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Outstanding Penjualan');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:N5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:N5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'RG #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Vehicle');
        $worksheet->setCellValue('F5', 'Plat #');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'WO #');
        $worksheet->setCellValue('I5', 'SO #');
        $worksheet->setCellValue('J5', 'Movement #');
        $worksheet->setCellValue('K5', 'Parts (Rp)');
        $worksheet->setCellValue('L5', 'Jasa (Rp)');
        $worksheet->setCellValue('M5', 'Total (Rp)');
        $worksheet->setCellValue('N5', 'User Input');

        $counter = 6;

        foreach ($outstandingSaleRetailSummary->dataProvider->data as $i => $header) {
            $movementOutHeaders = $header->movementOutHeaders;
            $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'transaction_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'transaction_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'work_order_number'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'sales_order_number'));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'total_product_price'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'total_service_price'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'grand_total'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'user.username'));
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="outstanding_sale_retail.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
