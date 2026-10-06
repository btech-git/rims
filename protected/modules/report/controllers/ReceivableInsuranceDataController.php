<?php

class ReceivableInsuranceDataController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('insuranceReceivableReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $insuranceCompanyId = (isset($_GET['InsuranceCompanyId'])) ? $_GET['InsuranceCompanyId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $insuranceCompany = Search::bind(new InsuranceCompany('search'), isset($_GET['InsuranceCompany']) ? $_GET['InsuranceCompany'] : array());
        $insuranceCompanyDataProvider = $insuranceCompany->search();
        $insuranceCompanyDataProvider->pagination->pageVar = 'page_dialog';

        $receivableInsuranceDataSummary = new ReceivableInsuranceDataSummary($insuranceCompany->search());
        $receivableInsuranceDataSummary->setupLoading();
//        $receivableInsuranceDataSummary->setupPaging($pageSize, $currentPage);
        $receivableInsuranceDataSummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $receivableInsuranceDataSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableInsuranceDataSummary, $endDate, $branchId);
        }

        $this->render('summary', array(
            'insuranceCompany'=>$insuranceCompany,
            'insuranceCompanyDataProvider'=>$insuranceCompanyDataProvider,
            'receivableInsuranceDataSummary' => $receivableInsuranceDataSummary,
            'insuranceCompanyId' => $insuranceCompanyId,
            'branchId' => $branchId,
            'endDate' => $endDate,
        ));
    }

    public function actionTransactionInfo($insuranceCompanyId, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = AppParam::BEGINNING_TRANSACTION_DATE;
        $dataProvider = InvoiceHeader::model()->searchByReport();
        $dataProvider->criteria->addBetweenCondition('t.invoice_date', $startDate, $endDate);
        $dataProvider->criteria->compare('t.insurance_company_id', $insuranceCompanyId);
        $dataProvider->criteria->addCondition("t.user_id_cancelled IS NULL AND t.payment_left > 100");
        
        $insuranceCompany = InsuranceCompany::model()->findByPk($insuranceCompanyId);
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToExcelDetailTransaction($dataProvider, $endDate, $insuranceCompany);
        }

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'endDate' => $endDate,
            'insuranceCompany' => $insuranceCompany,
            'insuranceCompanyId' => $insuranceCompanyId,
        ));
    }

    protected function saveToExcel($receivableInsuranceDataSummary, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Asuransi');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Asuransi');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        
        $worksheet->getStyle('A1:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Piutang Asuransi');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:E5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:E5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:E5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Name');
        $worksheet->setCellValue('B5', 'Akun');
        $worksheet->setCellValue('C5', 'Grand Total');
        $worksheet->setCellValue('D5', 'Payment');
        $worksheet->setCellValue('E5', 'Remaining');
        $counter = 6;

        $grandTotalRevenue = '0.00';
        $grandTotalPayment = '0.00';
        $grandTotalReceivable = '0.00';
        
        foreach ($receivableInsuranceDataSummary->dataProvider->data as $header) {
            $receivableData = $header->getReceivableInsuranceReport($endDate, $branchId);
            $totalRevenue = '0.00';
            $totalPayment = '0.00';
            $totalReceivable = '0.00';

            foreach ($receivableData as $receivableRow) {
                $revenue = $receivableRow['total_price'];
                $paymentAmount = $receivableRow['payment_amount'];
                $paymentLeft = $receivableRow['payment_left'];
                $totalRevenue += $revenue;
                $totalPayment += $paymentAmount;
                $totalReceivable += $paymentLeft;
            }
                
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'name'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'coa.name'));
            $worksheet->setCellValue("C{$counter}", $totalRevenue);
            $worksheet->setCellValue("D{$counter}", $totalPayment);
            $worksheet->setCellValue("E{$counter}", $totalReceivable);

            $grandTotalRevenue += $totalRevenue;
            $grandTotalPayment += $totalPayment;
            $grandTotalReceivable += $totalReceivable;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("A{$counter}:B{$counter}");
        
        $worksheet->setCellValue("A{$counter}", 'Total');
        $worksheet->setCellValue("C{$counter}", $grandTotalRevenue);
        $worksheet->setCellValue("D{$counter}", $grandTotalPayment);
        $worksheet->setCellValue("E{$counter}", $grandTotalReceivable);

        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_asuransi.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

    protected function saveToExcelDetailTransaction($dataProvider, $endDate, $insuranceCompany) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Asuransi Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Asuransi Detail');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        
        $worksheet->getStyle('A1:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Piutang Asuransi ' . CHtml::value($insuranceCompany, 'name'));
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:I5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:I5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Invoice #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Jatuh Tempo');
        $worksheet->setCellValue('D5', 'Umur (hari)');
        $worksheet->setCellValue('E5', 'Plat #');
        $worksheet->setCellValue('F5', 'Kendaraan');
        $worksheet->setCellValue('G5', 'Total');
        $worksheet->setCellValue('H5', 'Payment');
        $worksheet->setCellValue('I5', 'Remaining');
        
        $counter = 6;

        $totalPriceSum = '0.00';
        $paymentTotalSum = '0.00';
        $paymentLeftSum = '0.00'; 

        foreach ($dataProvider->data as $header) {
            $totalPrice = CHtml::value($header, 'total_price'); 
            $paymentTotal = CHtml::value($header, 'payment_amount');
            $paymentLeft = CHtml::value($header, 'payment_left');
            $outstandingDays = date_diff(date_create($header->invoice_date), date_create(date('Y-m-d')));
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'due_date'));
            $worksheet->setCellValue("D{$counter}", $outstandingDays->format("%a days"));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("G{$counter}", $totalPrice);
            $worksheet->setCellValue("H{$counter}", $paymentTotal);
            $worksheet->setCellValue("I{$counter}", $paymentLeft);
            
            $totalPriceSum += $totalPrice;
            $paymentTotalSum += $paymentTotal;
            $paymentLeftSum += $paymentLeft;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:I{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->mergeCells("A{$counter}:F{$counter}");
        
        $worksheet->setCellValue("A{$counter}", 'Total');
        $worksheet->setCellValue("G{$counter}", $totalPriceSum);
        $worksheet->setCellValue("H{$counter}", $paymentTotalSum);
        $worksheet->setCellValue("I{$counter}", $paymentLeftSum);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_asuransi_detail.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}