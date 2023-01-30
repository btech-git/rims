<?php

class SaleRetailProductController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleOrderReport')) || !(Yii::app()->user->checkAccess('saleInvoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationProduct = Search::bind(new RegistrationProduct('search'), isset($_GET['RegistrationProduct']) ? $_GET['RegistrationProduct'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $productName = (isset($_GET['ProductName'])) ? $_GET['ProductName'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleRetailSummary = new SaleRetailProductSummary($registrationProduct->search());
        $saleRetailSummary->setupLoading();
        $saleRetailSummary->setupPaging($pageSize, $currentPage);
        $saleRetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'customerName' => $customerName,
            'productName' => $productName,
        );
        $saleRetailSummary->setupFilter($filters);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailSummary, $branchId, $saleRetailSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'registrationProduct' => $registrationProduct,
            'saleRetailSummary' => $saleRetailSummary,
            'branchId' => $branchId,
            'customerName' => $customerName,
            'productName' => $productName,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($saleRetailSummary, $branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penjualan Retail Product');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Retail Product');

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
        $worksheet->getColumnDimension('K')->setAutoSize(true);
        $worksheet->getColumnDimension('L')->setAutoSize(true);
        $worksheet->getColumnDimension('M')->setAutoSize(true);
        $worksheet->getColumnDimension('N')->setAutoSize(true);
        $worksheet->getColumnDimension('O')->setAutoSize(true);
        $worksheet->getColumnDimension('P')->setAutoSize(true);
        $worksheet->getColumnDimension('Q')->setAutoSize(true);

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');

        $worksheet->getStyle('A1:Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Penjualan Retail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:Q5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Penjualan #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Customer');
        $worksheet->setCellValue('D5', 'Vehicle');
        $worksheet->setCellValue('EA5', 'KM');
        $worksheet->setCellValue('F5', 'Grand Total');
        $worksheet->setCellValue('G5', 'Note');
        $worksheet->setCellValue('H5', 'Branch');
        $worksheet->setCellValue('I5', 'Admin');
        $worksheet->setCellValue('J5', 'Product');
        $worksheet->setCellValue('K5', 'Quantity');
        $worksheet->setCellValue('L5', 'Retail Price');
        $worksheet->setCellValue('M5', 'HPP');
        $worksheet->setCellValue('N5', 'Selling Price');
        $worksheet->setCellValue('O5', 'Discount');
        $worksheet->setCellValue('P5', 'Total');
        $worksheet->setCellValue('Q5', 'Memo');

        $worksheet->getStyle('A5:Q5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->registrationTransaction->transaction_number));
    //            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->registrationTransaction->transaction_date));
    //            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.customer.name')));
    //            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.vehicle.plate_number')));
    //            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.vehicle_mileage')));
    //            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.grand_total')));
    //            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.note')));
    //            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.branch.name')));
    //            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.user.username')));
    //            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'product.name')));
    //            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'quantity')));
    //            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'retail_price')));
    //            $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($header, 'hpp')));
    //            $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($header, 'sale_price')));
    //            $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header, 'discount')));
    //            $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($header, 'total_price')));
    //            $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($header, 'note')));

            $counter++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Retail Product.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
