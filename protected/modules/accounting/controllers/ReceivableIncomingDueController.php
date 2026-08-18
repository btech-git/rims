<?php

class ReceivableIncomingDueController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'index') {
            if (!(Yii::app()->user->checkAccess('receivableDueReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $customerPaymentTerm = (isset($_GET['CustomerPaymentTerm'])) ? $_GET['CustomerPaymentTerm'] : '';
        $startDueDate = (isset($_GET['StartDueDate'])) ? $_GET['StartDueDate'] : '';
        $endDueDate = (isset($_GET['EndDueDate'])) ? $_GET['EndDueDate'] : '';
        
        $receivableIncomingDueDate = InvoiceHeader::getReceivableIncomingDueDate($customerName, $startDate, $endDate, $customerPaymentTerm, $startDueDate, $endDueDate);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableIncomingDueDate);
        }
        
        $this->render('index', array(
            'receivableIncomingDueDate' => $receivableIncomingDueDate,
            'customerName' => $customerName,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerPaymentTerm' => $customerPaymentTerm,
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
        $documentProperties->setTitle('Piutang Jatuh Tempo');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Jatuh Tempo');

        $worksheet->mergeCells("A1:L1");
        $worksheet->mergeCells("A2:L2");
        $worksheet->mergeCells("A3:L3");
        
        $worksheet->getStyle("A1:L5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:L5")->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR');
        $worksheet->setCellValue('A2', 'Piutang Jatuh Tempo');

        $worksheet->getStyle("A5:L5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("A5", 'No');
        $worksheet->setCellValue("B5", 'Invoice #');
        $worksheet->setCellValue("C5", 'Tanggal');
        $worksheet->setCellValue("D5", 'Jatuh Tempo');
        $worksheet->setCellValue("E5", 'TOP (hari)');
        $worksheet->setCellValue("F5", 'Payment #');
        $worksheet->setCellValue("G5", 'Tanggal Payment');
        $worksheet->setCellValue("H5", 'Customer');
        $worksheet->setCellValue("I5", 'Plat #');
        $worksheet->setCellValue("J5", 'Total');
        $worksheet->setCellValue("K5", 'Payment');
        $worksheet->setCellValue("L5", 'Remaining');
        
        $worksheet->getStyle("A5:L5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        
        foreach($receivableIncomingDueDate as $i => $dataItem) {
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItem['invoice_number']);
            $worksheet->setCellValue("C{$counter}", $dataItem['invoice_date']);
            $worksheet->setCellValue("D{$counter}", $dataItem['due_date']);
            $worksheet->setCellValue("E{$counter}", $dataItem['tenor']);
            $worksheet->setCellValue("F{$counter}", $dataItem['payment_number']);
            $worksheet->setCellValue("G{$counter}", $dataItem['payment_date']);
            $worksheet->setCellValue("H{$counter}", $dataItem['customer']);
            $worksheet->setCellValue("I{$counter}", $dataItem['plate_number']);
            $worksheet->setCellValue("J{$counter}", $dataItem['total_price']);
            $worksheet->setCellValue("K{$counter}", $dataItem['payment_amount']);
            $worksheet->setCellValue("L{$counter}", $dataItem['payment_left']);
            
            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_jatuh_tempo.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}