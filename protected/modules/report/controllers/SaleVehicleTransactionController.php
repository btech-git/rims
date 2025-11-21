<?php

class SaleVehicleTransactionController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleCustomerReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : array());
        $vehicleDataProvider = $vehicle->search();
        $vehicleDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $vehicleId = (isset($_GET['VehicleId'])) ? $_GET['VehicleId'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        
        $vehicleSaleReport = InvoiceHeader::getVehicleSaleReport($startDate, $endDate, $vehicleId, $branchId);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($vehicleSaleReport, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
                'customerId' => $vehicleId,
            ));
        }

        $this->render('summary', array(
            'vehicleSaleReport' => $vehicleSaleReport,
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'vehicleId' => $vehicleId,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $vehicleId = (isset($_POST['Customer']['id'])) ? $_POST['Customer']['id'] : '';
            $vehicle = Customer::model()->findByPk($vehicleId);

            $object = array(
                'customer_name' => CHtml::value($vehicle, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($vehicleSaleReport, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        $vehicleId = $options['customerId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Rincian Penjualan per Pelanggan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Penjualan per Pelanggan');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Rincian Penjualan per Pelanggan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Customer');
        $worksheet->setCellValue('C5', 'Type');
        $worksheet->setCellValue('D5', 'Penjualan #');
        $worksheet->setCellValue('E5', 'Tanggal');
        $worksheet->setCellValue('F5', 'Vehicle');
        $worksheet->setCellValue('G5', 'Barang');
        $worksheet->setCellValue('H5', 'Jasa');
        $worksheet->setCellValue('I5', 'Ppn');
        $worksheet->setCellValue('J5', 'Pph');
        $worksheet->setCellValue('K5', 'Total');

        $worksheet->getStyle('A5:K5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        $grandTotalSale = '0.00';
        
        foreach ($vehicleSaleReport as $i => $dataItem) {
            $saleReportData = InvoiceHeader::model()->findAll(array(
                'condition' => 'customer_id = :customer_id AND invoice_date BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':customer_id' => $dataItem['customer_id'],
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ),
            ));
            if (!empty($saleReportData)) {
                foreach ($saleReportData as $saleReportRow) {
                    $grandTotal = CHtml::value($saleReportRow, 'total_price'); 
                    $worksheet->getStyle("G{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", $dataItem['customer_id']);
                    $worksheet->setCellValue("B{$counter}", $dataItem['customer_name']);
                    $worksheet->setCellValue("C{$counter}", $dataItem['customer_type']);
                    $worksheet->setCellValue("D{$counter}", CHtml::value($saleReportRow, 'invoice_number'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($saleReportRow, 'invoice_date'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($saleReportRow, 'vehicle.plate_number'));
                    $worksheet->setCellValue("G{$counter}", CHtml::value($saleReportRow, 'product_price'));
                    $worksheet->setCellValue("H{$counter}", CHtml::value($saleReportRow, 'service_price'));
                    $worksheet->setCellValue("I{$counter}", CHtml::value($saleReportRow, 'ppn_total'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($saleReportRow, 'pph_total'));
                    $worksheet->setCellValue("K{$counter}", $grandTotal);
                    $counter++;
                    
//                    $totalSale += $grandTotal;
                }
//                $worksheet->getStyle("I{$counter}:K{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//                $worksheet->getStyle("I{$counter}:K{$counter}")->getFont()->setBold(true);
//
//                $worksheet->setCellValue("L{$counter}", 'TOTAL');
//                $worksheet->setCellValue("M{$counter}", CHtml::encode($totalSale));
//                $grandTotalSale += $totalSale;
//                $counter++;$counter++;
            }
        }
        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);

        $worksheet->setCellValue("L{$counter}", 'TOTAL PENJUALAN');
        $worksheet->setCellValue("M{$counter}", CHtml::encode($grandTotalSale));

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rincian Penjualan per Pelanggan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
