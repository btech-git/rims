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
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleRetailSummary = new SaleRetailSummary($customerDataProvider);
        $saleRetailSummary->setupLoading();
        $saleRetailSummary->setupPaging($pageSize, $currentPage);
        $saleRetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $saleRetailSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'saleRetailSummary' => $saleRetailSummary,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
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
        $documentProperties->setTitle('Rincian Penjualan per Pelanggan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Penjualan per Pelanggan');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:M6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Rincian Penjualan per Pelanggan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Customer');
        $worksheet->setCellValue('B5', 'Type');
        $worksheet->setCellValue('C5', 'Penjualan #');
        $worksheet->setCellValue('D5', 'Tanggal');
        $worksheet->setCellValue('E5', 'Jenis');
        $worksheet->setCellValue('F5', 'Vehicle');
        $worksheet->setCellValue('G5', 'Barang');
        $worksheet->setCellValue('H5', 'Disc Barang');
        $worksheet->setCellValue('I5', 'Jasa');
        $worksheet->setCellValue('J5', 'Disc Jasa');
        $worksheet->setCellValue('K5', 'Ppn');
        $worksheet->setCellValue('L5', 'Pph');
        $worksheet->setCellValue('M5', 'Total');

        $worksheet->getStyle('A6:M6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        $grandTotalSale = '0.00';
        
        foreach ($dataProvider->data as $header) {
            $saleReportData = $header->getSaleReport($startDate, $endDate, $branchId);
            if (!empty($saleReportData)) {
                $totalSale = 0.00;
                foreach ($saleReportData as $saleReportRow) {
                    $invoiceHeader = InvoiceHeader::model()->findByPk($saleReportRow['id']);
                    $discountProduct = $invoiceHeader->getTotalDiscountProduct();
                    $discountService = $invoiceHeader->getTotalDiscountService();
                    $grandTotal = $saleReportRow['total_price'];
                    $worksheet->getStyle("G{$counter}:I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'customer_type')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode($saleReportRow['invoice_number']));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($saleReportRow['invoice_date']));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode($saleReportRow['plate_number']));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode($saleReportRow['product_price']));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode($discountProduct));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode($saleReportRow['service_price']));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode($discountService));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode($saleReportRow['ppn_total']));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode($saleReportRow['pph_total']));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode($grandTotal));
                    $counter++;
                    
                    $totalSale += $grandTotal + $discountProduct + $discountService;
                }
                $worksheet->getStyle("J{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $worksheet->getStyle("J{$counter}:N{$counter}")->getFont()->setBold(true);

                $worksheet->setCellValue("L{$counter}", 'TOTAL');
                $worksheet->setCellValue("N{$counter}", CHtml::encode($totalSale));
                $grandTotalSale += $totalSale;
                $counter++;$counter++;
            }
        }
        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);

        $worksheet->setCellValue("L{$counter}", 'TOTAL PENJUALAN');
        $worksheet->setCellValue("N{$counter}", CHtml::encode($grandTotalSale));

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rincian Penjualan per Pelanggan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
