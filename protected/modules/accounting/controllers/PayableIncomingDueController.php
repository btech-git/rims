<?php

class PayableIncomingDueController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'index') {
            if (!(Yii::app()->user->checkAccess('payableDueReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $supplierPaymentTerm = (isset($_GET['SupplierPaymentTerm'])) ? $_GET['SupplierPaymentTerm'] : '';
        $startDueDate = (isset($_GET['StartDueDate'])) ? $_GET['StartDueDate'] : '';
        $endDueDate = (isset($_GET['EndDueDate'])) ? $_GET['EndDueDate'] : '';
        
        $payableIncomingDueDate = TransactionReceiveItem::getPayableIncomingDueDate($supplierName, $startDate, $endDate, $supplierPaymentTerm, $startDueDate, $endDueDate);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($payableIncomingDueDate);
        }
        
        $this->render('index', array(
            'payableIncomingDueDate' => $payableIncomingDueDate,
            'supplierName' => $supplierName,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierPaymentTerm' => $supplierPaymentTerm,
            'startDueDate' => $startDueDate,
            'endDueDate' => $endDueDate,
        ));
    }
    
    protected function saveToExcel($receivableIncomingDueDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Hutang Jatuh Tempo');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Hutang Jatuh Tempo');

        $worksheet->mergeCells("A1:M1");
        $worksheet->mergeCells("A2:M2");
        $worksheet->mergeCells("A3:M3");
        
        $worksheet->getStyle("A1:M5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:M5")->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR');
        $worksheet->setCellValue('A2', 'Hutang Jatuh Tempo');

        $worksheet->getStyle("A5:M5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("A5", 'No');
        $worksheet->setCellValue("B5", 'Invoice #');
        $worksheet->setCellValue("C5", 'Tanggal Invoice');
        $worksheet->setCellValue("D5", 'Jatuh Tempo');
        $worksheet->setCellValue("E5", 'TOP (hari)');
        $worksheet->setCellValue("F5", 'PO #');
        $worksheet->setCellValue("G5", 'Tanggal PO');
        $worksheet->setCellValue("H5", 'Payment #');
        $worksheet->setCellValue("I5", 'Tanggal Payment');
        $worksheet->setCellValue("J5", 'Supplier');
        $worksheet->setCellValue("K5", 'Total');
        $worksheet->setCellValue("L5", 'Payment');
        $worksheet->setCellValue("M5", 'Remaining');
        
        $worksheet->getStyle("A5:M5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        
        foreach($receivableIncomingDueDate as $i => $dataItem) {
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItem['invoice_number']);
            $worksheet->setCellValue("C{$counter}", $dataItem['invoice_date']);
            $worksheet->setCellValue("D{$counter}", $dataItem['invoice_due_date']);
            $worksheet->setCellValue("E{$counter}", $dataItem['tenor']);
            $worksheet->setCellValue("F{$counter}", $dataItem['purchase_order_no']);
            $worksheet->setCellValue("G{$counter}", $dataItem['purchase_order_date']);
            $worksheet->setCellValue("H{$counter}", $dataItem['payment_number']);
            $worksheet->setCellValue("I{$counter}", $dataItem['payment_date']);
            $worksheet->setCellValue("J{$counter}", $dataItem['supplier']);
            $worksheet->setCellValue("K{$counter}", $dataItem['invoice_grand_total']);
            $worksheet->setCellValue("L{$counter}", $dataItem['payment']);
            $worksheet->setCellValue("M{$counter}", $dataItem['remaining']);
            
            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="hutang_jatuh_tempo.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}