<?php

class SaleRetailCustomerController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleCustomerSummaryReport'))) {
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
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $taxValue = (isset($_GET['TaxValue'])) ? $_GET['TaxValue'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $saleRetailCustomerSummary = new SaleRetailCustomerSummary($customerDataProvider);
        $saleRetailCustomerSummary->setupLoading();
        $saleRetailCustomerSummary->setupPaging($pageSize, $currentPage);
        $saleRetailCustomerSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'taxValue' => $taxValue,
            'branchId' => $branchId,
        );
        $saleRetailCustomerSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailCustomerSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate, 'branchId' => $branchId));
        }

        $this->render('summary', array(
            'saleRetailCustomerSummary' => $saleRetailCustomerSummary,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
            'taxValue' => $taxValue,
            'branchId' => $branchId,
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
        $documentProperties->setTitle('Penjualan per Pelanggan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan per Pelanggan');

        $worksheet->mergeCells('A1:D1');
        $worksheet->mergeCells('A2:D2');
        $worksheet->mergeCells('A3:D3');

        $worksheet->getStyle('A1:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:D6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan per Pelanggan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Customer');
        $worksheet->setCellValue('C5', 'Type');
        $worksheet->setCellValue('D5', 'Total Sales');

        $worksheet->getStyle('A6:D6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        
        $totalIndividual = Customer::getTotalSaleIndividual($startDate, $endDate, $branchId);
        $worksheet->setCellValue("B{$counter}", 'Individual');
        $worksheet->setCellValue("D{$counter}", CHtml::encode($totalIndividual));
            
        $counter++;
            
        $totalSale = 0.00;
        foreach ($dataProvider->data as $header) {
            $grandTotal = $header->getTotalSaleCompany($startDate, $endDate, $branchId);
            $worksheet->getStyle("D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'id')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'customer_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode($grandTotal));

            $counter++;
            
            $totalSale += $grandTotal;
        }

        $worksheet->getStyle("A{$counter}:D{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:D{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("B{$counter}", 'Total');
        $worksheet->setCellValue("C{$counter}", 'Rp');
        $worksheet->setCellValue("D{$counter}", $totalSale + $totalIndividual);

        $counter++;

        for ($col = 'A'; $col !== 'F'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan per Pelanggan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
