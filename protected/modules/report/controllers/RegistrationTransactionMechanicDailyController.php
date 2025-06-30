<?php

class RegistrationTransactionMechanicDailyController extends Controller {

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
        
        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : array());

        $transactionDate = (isset($_GET['TransactionDate'])) ? $_GET['TransactionDate'] : date('Y-m-d');
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $registrationTransactionSummary = new RegistrationTransactionMechanicDailySummary($registrationTransaction->search());
        $registrationTransactionSummary->setupLoading();
        $registrationTransactionSummary->setupPaging($pageSize, $currentPage);
        $registrationTransactionSummary->setupSorting();
        $filters = array(
            'transactionDate' => $transactionDate,
        );
        $registrationTransactionSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($registrationTransactionSummary, $transactionDate, $branchId);
        }

        $this->render('summary', array(
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionSummary' => $registrationTransactionSummary,
            'branchId' => $branchId,
            'transactionDate' => $transactionDate,
            'currentSort' => $currentSort,
        ));
    }
    
    protected function saveToExcel($registrationTransactionSummary, $transactionDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $transactionDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Kinerja Mekanik');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Kinerja Mekanik');

        $worksheet->mergeCells('A1:X1');
        $worksheet->mergeCells('A2:X2');
        $worksheet->mergeCells('A3:X3');
        
        $worksheet->getStyle('A1:X3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:X3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Kinerja Mekanik');
        $worksheet->setCellValue('A3', $transactionDateFormatted);

        $worksheet->getStyle("A5:X5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:X5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:X5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Nama');
        $worksheet->setCellValue('B5', 'Level');
        $worksheet->setCellValue('C5', 'Location');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Type');
        $worksheet->setCellValue('F5', 'New/Repeat');
        $worksheet->setCellValue('G5', 'Plat #');
        $worksheet->setCellValue('H5', 'Vehicle');
        $worksheet->setCellValue('I5', 'Color');
        $worksheet->setCellValue('J5', 'Jam Masuk');
        $worksheet->setCellValue('K5', 'Jam Keluar');
        $worksheet->setCellValue('L5', 'WO - R #');
        $worksheet->setCellValue('M5', 'WO #');
        $worksheet->setCellValue('N5', 'Date');
        $worksheet->setCellValue('O5', 'Time');
        $worksheet->setCellValue('P5', 'Vehicle System Check #');
        $worksheet->setCellValue('Q5', 'Date');
        $worksheet->setCellValue('R5', 'Service List');
        $worksheet->setCellValue('S5', 'Standard Service Time');
        $worksheet->setCellValue('T5', 'Total Service Time');
        $worksheet->setCellValue('U5', 'Service Amount (Rp)');
        $worksheet->setCellValue('V5', 'Parts List');
        $worksheet->setCellValue('W5', 'Ban List');
        $worksheet->setCellValue('X5', 'Oli List');

        $counter = 7;

        foreach ($registrationTransactionSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'employeeIdAssignMechanic.name'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'employeeIdAssignMechanic.level.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'branch.code'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.customer_type'));
            $worksheet->setCellValue("F{$counter}", $header->is_new_customer == 0 ? 'Repeat' : 'New');
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'vehicle.color.name'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'vehicle_entry_datetime'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'vehicle_exit_datetime'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'work_order_number'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'work_order_date'));
            $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'work_order_time'));
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'transaction_number'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'transaction_date'));
            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'services'));
            $worksheet->setCellValue("U{$counter}", CHtml::value($header, 'total_service_price'));
            $worksheet->setCellValue("V{$counter}", CHtml::value($header, 'producs'));
//            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'service_price'));
//            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'service_price'));
//            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'service_price'));
//            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'service_price'));
//            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'service_price'));
//            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'service_price'));
            $counter++;
        }

//        $worksheet->getStyle("A{$counter}:U{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:AA{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $worksheet->getStyle("H{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//        $worksheet->setCellValue("F{$counter}", 'Total');
//        $worksheet->setCellValue("G{$counter}", 'Rp');
//        $worksheet->setCellValue("H{$counter}", $grandTotalSale);
//        $worksheet->setCellValue("I{$counter}", $grandTotalPayment);
//        $worksheet->setCellValue("J{$counter}", $grandTotalRemaining);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="kinerja_mekanik.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}