<?php

class SaleRetailInsuranceDetailController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
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

        $insuranceCompany = Search::bind(new InsuranceCompany('search'), isset($_GET['InsuranceCompany']) ? $_GET['InsuranceCompany'] : array());
        $insuranceDataProvider = $insuranceCompany->search();
        $insuranceDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $insuranceId = (isset($_GET['InsuranceId'])) ? $_GET['InsuranceId'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $taxValue = (isset($_GET['TaxValue'])) ? $_GET['TaxValue'] : '';
        
        $insuranceSaleReport = InsuranceCompany::getInsuranceSaleReport($startDate, $endDate, $insuranceId, $branchId, $taxValue);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($insuranceSaleReport, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'insuranceSaleReport' => $insuranceSaleReport,
            'insuranceCompany' => $insuranceCompany,
            'insuranceDataProvider' => $insuranceDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'taxValue' => $taxValue,
            'branchId' => $branchId,
            'insuranceId' => $insuranceId,
        ));
    }

    protected function saveToExcel($insuranceSaleReport, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Rincian Penjualan per Asuransi');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Penjualan per Asuransi');

        $worksheet->mergeCells('A1:S1');
        $worksheet->mergeCells('A2:S2');
        $worksheet->mergeCells('A3:S3');

        $worksheet->getStyle('A1:S5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Rincian Penjualan per Asuransi');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:S5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'ID');
        $worksheet->setCellValue('C5', 'Asuransi');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Date Last Invoice');
        $worksheet->setCellValue('F5', 'Vehicle ID');
        $worksheet->setCellValue('G5', 'Plate #');
        $worksheet->setCellValue('H5', 'Kendaraan');
        $worksheet->setCellValue('I5', 'Warna');
        $worksheet->setCellValue('J5', 'Odometer');
        $worksheet->setCellValue('K5', 'WO #');
        $worksheet->setCellValue('L5', 'Last Service');
        $worksheet->setCellValue('M5', 'Last Parts');
        $worksheet->setCellValue('N5', 'Invoice #');
        $worksheet->setCellValue('O5', 'Invoice Total');
        $worksheet->setCellValue('P5', 'VSC #');
        $worksheet->setCellValue('Q5', 'Note from WO');
        $worksheet->setCellValue('R5', 'Salesman');
        $worksheet->setCellValue('S5', 'Mechanic');

        $worksheet->getStyle('A5:S5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        
        foreach ($insuranceSaleReport as $dataItem) {
            $saleReportData = InvoiceHeader::model()->findAll(array(
                'condition' => 'insurance_company_id = :insurance_company_id AND invoice_date BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':insurance_company_id' => $dataItem['insurance_company_id'],
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ),
            ));
            if (!empty($saleReportData)) {
                foreach ($saleReportData as $i => $saleReportRow) {
                    $grandTotal = CHtml::value($saleReportRow, 'total_price'); 
                    $worksheet->getStyle("N{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", $i + 1);
                    $worksheet->setCellValue("B{$counter}", $dataItem['insurance_company_id']);
                    $worksheet->setCellValue("C{$counter}", $dataItem['insurance_name']);
                    $worksheet->setCellValue("D{$counter}", CHtml::value($saleReportRow, 'customer.name'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($saleReportRow, 'vehicle_id'));
                    $worksheet->setCellValue("G{$counter}", CHtml::value($saleReportRow, 'vehicle.plate_number'));
                    $worksheet->setCellValue("H{$counter}", CHtml::value($saleReportRow, 'vehicle.carMake.name') . ' - ' . CHtml::value($saleReportRow, 'vehicle.carModel.name') . ' - ' . CHtml::value($saleReportRow, 'vehicle.carSubModel.name'));
                    $worksheet->setCellValue("I{$counter}", CHtml::value($saleReportRow, 'vehicle.color.name'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.vehicle_mileage'));
                    $worksheet->setCellValue("K{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.work_order_number'));
                    $worksheet->setCellValue("N{$counter}", CHtml::value($saleReportRow, 'invoice_number'));
                    $worksheet->setCellValue("O{$counter}", $grandTotal);
                    $worksheet->setCellValue("Q{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.note'));
                    $worksheet->setCellValue("R{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.employeeIdSalesPerson.name'));
                    $worksheet->setCellValue("S{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.employeeIdAssignMechanic.name'));
                    $counter++;
                }
            }
        }
        $worksheet->getStyle("A{$counter}:S{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincian_penjualan_per_asuransi.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
