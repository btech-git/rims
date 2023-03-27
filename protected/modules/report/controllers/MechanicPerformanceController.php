<?php

class MechanicPerformanceController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('mechanicPerformanceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $employee = Search::bind(new Employee('search'), isset($_GET['Employee']) ? $_GET['Employee'] : array());
        $employeeDataProvider = $employee->search();

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $employeeId = (isset($_GET['EmployeeId'])) ? $_GET['EmployeeId'] : '';

        $mechanicPerformanceSummary = new MechanicPerformanceSummary($employeeDataProvider);
        $mechanicPerformanceSummary->setupLoading();
        $mechanicPerformanceSummary->setupPaging($pageSize, $currentPage);
        $mechanicPerformanceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'employeeId' => $employeeId,
        );
        $mechanicPerformanceSummary->setupFilter($filters);
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($mechanicPerformanceSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
            'mechanicPerformanceSummary' => $mechanicPerformanceSummary,
            'employeeId' => $employeeId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
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
        $documentProperties->setTitle('Laporan Mekanik');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Mekanik');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Laporan Mekanik');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Name');
        $worksheet->setCellValue('B5', 'ID Card #');
        $worksheet->setCellValue('C5', 'Divisi');
        $worksheet->setCellValue('D5', 'Position');
        $worksheet->setCellValue('E5', 'Level');
        
        $worksheet->setCellValue('A6', 'WO #');
        $worksheet->setCellValue('B6', 'Branch');
        $worksheet->setCellValue('C6', 'Service Price');
        $worksheet->setCellValue('D6', 'Product Qty');
        $worksheet->setCellValue('E6', 'Product Price');
        $worksheet->setCellValue('F6', 'Total');
        $worksheet->setCellValue('G6', 'Mulai');
        $worksheet->setCellValue('H6', 'Selesai');
        $worksheet->setCellValue('I6', 'Service Status');
        $worksheet->setCellValue('J6', 'Transaction Status');

        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'id_card')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'division.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'position.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'level.name')));

            $counter++;

            $totalSale = 0.00;
            $registrationTransactions = RegistrationTransaction::model()->findAll(array(
                'condition' => 'employee_id_assign_mechanic = :employee_id_assign_mechanic AND transaction_date BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':employee_id_assign_mechanic' => $header->id,
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                )
            ));
            if (!empty($registrationTransactions)) {
                foreach ($registrationTransactions as $detail) {
                    $grandTotal = CHtml::value($detail, 'grand_total'); 

                    $worksheet->getStyle("I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", CHtml::encode($detail->work_order_number));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($detail, 'branch.code')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($detail, 'subtotal_service')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($detail, 'total_product')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'subtotal_product')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode($grandTotal));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode($detail->work_order_date) . ' ' . CHtml::encode($detail->work_order_time));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode($detail->transaction_date_out) . ' ' . CHtml::encode($detail->transaction_time_out));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'service_status')));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'status')));

                    $counter++;
                    $totalSale += $grandTotal;
                }
            }

            $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

            $worksheet->setCellValue("E{$counter}", 'TOTAL');
            $worksheet->setCellValue("F{$counter}", CHtml::encode($totalSale));
            $counter++;$counter++;

        }

        for ($col = 'A'; $col !== 'K'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Mekanik.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
