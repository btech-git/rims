<?php

class YearlyMultipleCustomerSaleTransactionController extends Controller {

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
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        
        $yearlyMultipleCustomerCompanySaleReport = InvoiceHeader::getCustomerCompanyTopSaleReport($startDate, $endDate, $customerName, $customerType, $branchId);
        $yearlyMultipleCustomerIndividualSaleReport = InvoiceHeader::getCustomerIndividualTopSaleReport($startDate, $endDate, $customerName, $customerType, $branchId);
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyMultipleCustomerCompanySaleReport, $yearlyMultipleCustomerIndividualSaleReport, $year, $branchId);
        }
        
        $this->render('summary', array(
            'yearlyMultipleCustomerCompanySaleReport' => $yearlyMultipleCustomerCompanySaleReport,
            'yearlyMultipleCustomerIndividualSaleReport' => $yearlyMultipleCustomerIndividualSaleReport,
            'yearList' => $yearList,
            'year' => $year,
            'branchId' => $branchId,
        ));
    }
    
    protected function saveToExcel($yearlyMultipleCustomerCompanySaleReport, $yearlyMultipleCustomerIndividualSaleReport, $year, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Customer Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Customer Tahunan');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Customer Tahunan ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A3', 'Periode: ' . $year);
        
        $worksheet->mergeCells('A5:K5');
        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Company');
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'ID');
        $worksheet->setCellValue('C6', 'Type');
        $worksheet->setCellValue('D6', 'Name');
        $worksheet->setCellValue('E6', 'Phone');
        $worksheet->setCellValue('F6', '# of Invoice');
        $worksheet->setCellValue('G6', 'Total Invoice (Rp)');
        $worksheet->setCellValue('H6', 'Total Parts (Rp)');
        $worksheet->setCellValue('I6', 'Total Jasa (Rp)');
        $worksheet->setCellValue('J6', 'Date 1st Invoice');
        $worksheet->setCellValue('K6', 'Duration from 1st invoice');
        $worksheet->getStyle('A6:K6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($yearlyMultipleCustomerCompanySaleReport as $i => $dataItemCompany) {
                $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", $i + 1);
                $worksheet->setCellValue("B{$counter}", $dataItemCompany['customer_id']);
                $worksheet->setCellValue("C{$counter}", $dataItemCompany['customer_type']);
                $worksheet->setCellValue("D{$counter}", $dataItemCompany['customer_name']);
                $worksheet->setCellValue("E{$counter}", $dataItemCompany['customer_phone']);
                $worksheet->setCellValue("F{$counter}", $dataItemCompany['invoice_quantity']);
                $worksheet->setCellValue("G{$counter}", $dataItemCompany['grand_total']);
                $worksheet->setCellValue("H{$counter}", $dataItemCompany['total_product']);
                $worksheet->setCellValue("I{$counter}", $dataItemCompany['total_service']);
                
                $counter++;
        }
        $counter++;

        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->mergeCells("A{$counter}:K{$counter}");
        $worksheet->getStyle("A{$counter}:K{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'Individual');
        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;
        foreach ($yearlyMultipleCustomerIndividualSaleReport as $i => $dataItemIndividual) {
                $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", $i + 1);
                $worksheet->setCellValue("B{$counter}", $dataItemIndividual['customer_id']);
                $worksheet->setCellValue("C{$counter}", $dataItemIndividual['customer_type']);
                $worksheet->setCellValue("D{$counter}", $dataItemIndividual['customer_name']);
                $worksheet->setCellValue("E{$counter}", $dataItemIndividual['customer_phone']);
                $worksheet->setCellValue("F{$counter}", $dataItemIndividual['invoice_quantity']);
                $worksheet->setCellValue("G{$counter}", $dataItemIndividual['grand_total']);
                $worksheet->setCellValue("H{$counter}", $dataItemIndividual['total_product']);
                $worksheet->setCellValue("I{$counter}", $dataItemIndividual['total_service']);
                
                $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_customer_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}