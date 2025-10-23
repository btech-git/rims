<?php

class CustomerTopSaleTransactionController extends Controller {

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
        
        $yearNow = date('Y');
        
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        
        $customerCompanyTopSaleReport = InvoiceHeader::getCustomerCompanyTopSaleReport($year, $branchId);
        $customerIndividualTopSaleReport = InvoiceHeader::getCustomerIndividualTopSaleReport($year, $branchId);
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($customerCompanyTopSaleReport, $customerIndividualTopSaleReport, $year, $branchId);
        }
        
        $this->render('summary', array(
            'customerCompanyTopSaleReport' => $customerCompanyTopSaleReport,
            'customerIndividualTopSaleReport' => $customerIndividualTopSaleReport,
            'yearList' => $yearList,
            'year' => $year,
            'branchId' => $branchId,
        ));
    }
    
    protected function saveToExcel($customerCompanyTopSaleReport, $customerIndividualTopSaleReport, $year, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Customer Terbaik');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Customer Terbaik');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');

        $worksheet->getStyle('A1:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Customer Terbaik ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A3', 'Periode: ' . $year);
        
        $worksheet->mergeCells('A5:E5');
        $worksheet->getStyle('A5:E5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Company');
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'ID');
        $worksheet->setCellValue('C6', 'Name');
        $worksheet->setCellValue('D6', 'Quantity');
        $worksheet->setCellValue('E6', 'Total');
        $worksheet->getStyle('A6:E6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($customerCompanyTopSaleReport as $i => $dataItemCompany) {
                $worksheet->getStyle("D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $worksheet->getStyle("E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", $i + 1);
                $worksheet->setCellValue("B{$counter}", $dataItemCompany['customer_id']);
                $worksheet->setCellValue("C{$counter}", $dataItemCompany['customer_name']);
                $worksheet->setCellValue("D{$counter}", $dataItemCompany['quantity_invoice']);
                $worksheet->setCellValue("E{$counter}", $dataItemCompany['total_price']);
                
                $counter++;
        }
        $counter++;

        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->mergeCells("A{$counter}:E{$counter}");
        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'Individual');
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;
        foreach ($customerIndividualTopSaleReport as $i => $dataItemIndividual) {
                $worksheet->getStyle("D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $worksheet->getStyle("E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", $i + 1);
                $worksheet->setCellValue("B{$counter}", $dataItemIndividual['customer_id']);
                $worksheet->setCellValue("C{$counter}", $dataItemIndividual['customer_name']);
                $worksheet->setCellValue("D{$counter}", $dataItemIndividual['quantity_invoice']);
                $worksheet->setCellValue("E{$counter}", $dataItemIndividual['total_price']);
                
                $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_customer_terbaik.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}