<?php

class PurchaseSummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseSupplierSummaryReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchaseSummary = new PurchaseSummary($supplier->search());
        $purchaseSummary->setupLoading();
        $purchaseSummary->setupPaging($pageSize, $currentPage);
        $purchaseSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $purchaseSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchaseSummary->dataProvider, $startDate, $endDate);
        }

        $this->render('summary', array(
            'supplier'=>$supplier,
            'supplierDataProvider'=>$supplierDataProvider,
            'purchaseSummary' => $purchaseSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = Supplier::model()->findByPk($id);

            $object = array(
                'supplier_name' => CHtml::value($supplier, 'company'),
                'supplier_code' => CHtml::value($supplier, 'code'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($dataProvider, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Pembelian per Pemasok');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pembelian per Pemasok');

        $worksheet->mergeCells('A1:D1');
        $worksheet->mergeCells('A2:D2');
        $worksheet->mergeCells('A3:D3');
        $worksheet->mergeCells('A4:D4');
        
        $worksheet->getStyle('A1:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:D3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Pembelian per Pemasok');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A6:D5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:D5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:D5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Company');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Total Purchase');

        $counter = 7;

        $totalPurchase = 0.00;
        foreach ($dataProvider->data as $header) {
            $grandTotal = $header->getTotalPurchase($startDate, $endDate);
            $worksheet->setCellValue("A{$counter}", $header->code);
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'company')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->setCellValue("D{$counter}", $grandTotal);

            $counter++;
            
            $totalPurchase += $grandTotal;
        }

        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:D{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("A{$counter}", 'Total Pembelian');
        $worksheet->setCellValue("C{$counter}", 'Rp');
        $worksheet->setCellValue("D{$counter}", $totalPurchase);

        $counter++;

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian per Pemasok.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
