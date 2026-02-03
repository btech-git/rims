<?php

class SaleInvoiceProjectNonCogsController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director'))) {
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
        $customerDataProvider->criteria->compare('t.customer_type', 'Company');
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $saleProjectReport = InvoiceHeader::getSaleByProjectReport($startDate, $endDate, $branchId, $customerId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleProjectReport, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
                'customerId' => $customerId,
            ));
        }

        $this->render('summary', array(
            'saleProjectReport' => $saleProjectReport,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'customerId' => $customerId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'currentSort' => $currentSort,
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

    protected function saveToExcel($saleProjectReport, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        $customerId = $options['customerId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Project');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Project');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $customer = Customer::model()->findByPk($customerId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Penjualan Project' . CHtml::value($customer, 'name'));
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Penjualan #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Customer');
        $worksheet->setCellValue('D5', 'Asuransi');
        $worksheet->setCellValue('E5', 'Kendaraan');
        $worksheet->setCellValue('F5', 'Plat #');
        $worksheet->setCellValue('G5', 'WO #');
        $worksheet->setCellValue('H5', 'Type');
        $worksheet->setCellValue('I5', 'ID');
        $worksheet->setCellValue('J5', 'Item');
        $worksheet->setCellValue('K5', 'Quantity');
        $worksheet->setCellValue('L5', 'Harga');
        $worksheet->setCellValue('M5', 'Total Sales');

        $worksheet->getStyle('A5:M5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $totalSale = '0.00';
        foreach ($saleProjectReport as $i => $dataItem) {
            $quantity = $dataItem['quantity'];
            $unitPrice = $dataItem['unit_price'];
            $grandTotal = $dataItem['total_price'];
            $worksheet->getStyle("J{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $dataItem['invoice_number']);
            $worksheet->setCellValue("B{$counter}", $dataItem['invoice_date']);
            $worksheet->setCellValue("C{$counter}", $dataItem['customer_name']);
            $worksheet->setCellValue("D{$counter}", $dataItem['insurance']);
            $worksheet->setCellValue("E{$counter}", $dataItem['car_make'] . ' - ' . $dataItem['car_model'] . ' - ' . $dataItem['car_sub_model']);
            $worksheet->setCellValue("F{$counter}", $dataItem['plate_number']);
            $worksheet->setCellValue("G{$counter}", $dataItem['work_order_number']);
            if (empty($dataItem['product'])) {
                $worksheet->setCellValue("H{$counter}", 'Jasa');
                $worksheet->setCellValue("I{$counter}", $dataItem['service_id']);
                $worksheet->setCellValue("J{$counter}", $dataItem['service']);
            } else {
                $worksheet->setCellValue("H{$counter}", 'Parts');
                $worksheet->setCellValue("I{$counter}", $dataItem['product_id']);
                $worksheet->setCellValue("J{$counter}", $dataItem['product']);
            }
            $worksheet->setCellValue("K{$counter}", $quantity);
            $worksheet->setCellValue("L{$counter}", $unitPrice);
            $worksheet->setCellValue("M{$counter}", $grandTotal);
            $counter++;

            $totalSale += $grandTotal;
        }
        $worksheet->getStyle("A{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:M{$counter}")->getFont()->setBold(true);

        $worksheet->setCellValue("L{$counter}", 'TOTAL');
        $worksheet->setCellValue("M{$counter}", $totalSale);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_project.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
