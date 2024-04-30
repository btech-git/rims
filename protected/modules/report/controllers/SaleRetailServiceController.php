<?php

class SaleRetailServiceController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleServiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : array());
        $serviceDataProvider = $service->search();
        $serviceDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
//        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
//        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

//        $saleRetailServiceSummary = new SaleRetailServiceSummary($service->search());
//        $saleRetailServiceSummary->setupLoading();
//        $saleRetailServiceSummary->setupPaging($pageSize, $currentPage);
//        $saleRetailServiceSummary->setupSorting();
//        $filters = array(
//            'startDate' => $startDate,
//            'endDate' => $endDate,
//        );
//        $saleRetailServiceSummary->setupFilter($filters);
        $saleRetailServiceReport = $service->getSaleRetailServiceReport($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailServiceReport, array('startDate' => $startDate, 'endDate' => $endDate, $branchId));
        }

        $this->render('summary', array(
            'saleRetailServiceReport' => $saleRetailServiceReport,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
//            'pageSize' => $pageSize,
//            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
        ));
    }

    public function actionAjaxJsonService() {
        if (Yii::app()->request->isAjaxRequest) {
            $serviceId = (isset($_POST['Service']['id'])) ? $_POST['Service']['id'] : '';
            $service = Service::model()->findByPk($serviceId);

            $object = array(
                'service_name' => CHtml::value($service, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($saleRetailServiceReport, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $startDate = $options['startDate'];
        $endDate = $options['endDate'];
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Retail Service');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Retail Service');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');

        $worksheet->getStyle('A1:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E5')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Penjualan Retail Service');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:E5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Type');
        $worksheet->setCellValue('C5', 'Category');
        $worksheet->setCellValue('D5', 'Name');
        $worksheet->setCellValue('E5', 'Quantity');
        $worksheet->setCellValue('E5', 'Amount');

        $worksheet->getStyle('A5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $totalSale = 0.00;
        $grandTotalQuantity = 0;
        foreach ($saleRetailServiceReport as $saleRetailServiceItem) {
            $grandTotal = $saleRetailServiceItem['total'];
            $totalQuantity = $saleRetailServiceItem['total_quantity'];
            $worksheet->getStyle("E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $saleRetailServiceItem['code']);
            $worksheet->setCellValue("B{$counter}", $saleRetailServiceItem['type']);
            $worksheet->setCellValue("C{$counter}", $saleRetailServiceItem['category']);
            $worksheet->setCellValue("D{$counter}", $saleRetailServiceItem['name']);
            $worksheet->setCellValue("E{$counter}", CHtml::encode($grandTotal));
            $worksheet->setCellValue("E{$counter}", CHtml::encode($totalQuantity));

            $counter++;
            $totalSale += $grandTotal;
            $grandTotalQuantity += $totalQuantity;
        }

        $worksheet->setCellValue("D{$counter}", 'TOTAL');
        $worksheet->setCellValue("E{$counter}", CHtml::encode($totalSale));
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'F'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan Retail Service.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
