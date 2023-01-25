<?php

class MechanicPerformanceController extends Controller {

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

        $registrationService = Search::bind(new RegistrationService('search'), isset($_GET['RegistrationService']) ? $_GET['RegistrationService'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $mechanicName = (isset($_GET['MechanicName'])) ? $_GET['MechanicName'] : '';
        $serviceName = (isset($_GET['ServiceName'])) ? $_GET['ServiceName'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $mechanicPerformanceSummary = new MechanicPerformanceSummary($registrationService->search());
        $mechanicPerformanceSummary->setupLoading();
        $mechanicPerformanceSummary->setupPaging($pageSize, $currentPage);
        $mechanicPerformanceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'mechanicName' => $mechanicName,
            'serviceName' => $serviceName,
        );
        $mechanicPerformanceSummary->setupFilter($filters);

//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($mechanicPerformanceSummary, $branchId, $mechanicPerformanceSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
//        }

        $this->render('summary', array(
            'registrationService' => $registrationService,
            'mechanicPerformanceSummary' => $mechanicPerformanceSummary,
            'branchId' => $branchId,
            'mechanicName' => $mechanicName,
            'serviceName' => $serviceName,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($mechanicPerformanceSummary, $branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penjualan Retail Service');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Retail Service');

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

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');

        $worksheet->getStyle('A1:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Penjualan Retail Service');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Penjualan #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Customer');
        $worksheet->setCellValue('D5', 'Vehicle');
        $worksheet->setCellValue('EA5', 'KM');
        $worksheet->setCellValue('F5', 'Grand Total');
        $worksheet->setCellValue('G5', 'Note');
        $worksheet->setCellValue('H5', 'Branch');
        $worksheet->setCellValue('I5', 'Admin');
        $worksheet->setCellValue('J5', 'Service');
        $worksheet->setCellValue('K5', 'Claim');
        $worksheet->setCellValue('L5', 'Price');
        $worksheet->setCellValue('M5', 'Discount');
        $worksheet->setCellValue('N5', 'Total');

        $worksheet->getStyle('A5:N5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->registrationServices as $detail) {
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->transaction_number));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->transaction_date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'vehicle_mileage')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'grand_total')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'service.name')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'claim')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'price')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'discount_price')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'total_price')));

                $counter++;
            }
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Retail Service.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
