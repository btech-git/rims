<?php

class SaleRetailServiceDetailController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleServiceReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : array());
        $serviceDataProvider = $service->search();
        $serviceDataProvider->pagination->pageVar = 'page_dialog';
        $serviceDataProvider->criteria->compare('t.status', 'Active');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $serviceTypeId = (isset($_GET['ServiceTypeId'])) ? $_GET['ServiceTypeId'] : '';
        $serviceCategoryId = (isset($_GET['ServiceCategoryId'])) ? $_GET['ServiceCategoryId'] : '';
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';

        $saleRetailServiceSummary = new SaleRetailServiceSummary($service->search());
        $saleRetailServiceSummary->setupLoading();
        $saleRetailServiceSummary->setupPaging($pageSize, $currentPage);
        $saleRetailServiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'serviceTypeId' => $serviceTypeId,
            'serviceCategoryId' => $serviceCategoryId,
            'customerType' => $customerType,
        );
        $saleRetailServiceSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailServiceSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
                'branchId' => $branchId,
                'customerType' => $customerType,
            ));
        }

        $this->render('summary', array(
            'saleRetailServiceSummary' => $saleRetailServiceSummary,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
            'serviceTypeId' => $serviceTypeId,
            'serviceCategoryId' => $serviceCategoryId,
            'customerType' => $customerType,
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

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $startDate = $options['startDate'];
        $endDate = $options['endDate'];
        $branchId = $options['branchId'];
        $customerType = $options['customerType'];
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Rincian Penjualan Service');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Penjualan Service');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');

        $worksheet->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Rincian Penjualan Service');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Type');
        $worksheet->setCellValue('C5', 'Category');
        $worksheet->setCellValue('D5', 'Name');
        $worksheet->setCellValue('E5', 'Penjualan #');
        $worksheet->setCellValue('F5', 'Tanggal');
        $worksheet->setCellValue('G5', 'WO #');
        $worksheet->setCellValue('H5', 'Customer');
        $worksheet->setCellValue('I5', 'Asuransi');
        $worksheet->setCellValue('J5', 'Plat #');
        $worksheet->setCellValue('K5', 'Kendaraan');
        $worksheet->setCellValue('L5', 'Harga');

        $worksheet->getStyle('A5:L5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($dataProvider->data as $header) {
            $saleRetailData = $header->getSaleRetailServiceDetailReport($startDate, $endDate, $branchId, $customerType);
            $totalSale = '0.00';
            foreach ($saleRetailData as $saleRetailRow) {
                $total = $saleRetailRow['total_price'];
                
                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'code'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'serviceType.name'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'serviceCategory.name'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'name'));
                $worksheet->setCellValue("E{$counter}", $saleRetailRow['invoice_number']);
                $worksheet->setCellValue("F{$counter}", $saleRetailRow['invoice_date']);
                $worksheet->setCellValue("G{$counter}", $saleRetailRow['work_order_number']);
                $worksheet->setCellValue("H{$counter}", $saleRetailRow['customer']);
                $worksheet->setCellValue("I{$counter}", $saleRetailRow['insurance']);
                $worksheet->setCellValue("J{$counter}", $saleRetailRow['plate_number']);
                $worksheet->setCellValue("K{$counter}", $saleRetailRow['car_make'] . ' - ' . $saleRetailRow['car_model'] . ' - ' . $saleRetailRow['car_sub_model']);
                $worksheet->setCellValue("L{$counter}", $total);

                $counter++;
                $totalSale += $total;

            }
            $worksheet->getStyle("A{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:L{$counter}")->getFont()->setBold(true);

            $worksheet->setCellValue("K{$counter}", 'TOTAL');
            $worksheet->setCellValue("L{$counter}", $totalSale);
            $counter++;$counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincian_penjualan_service.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
