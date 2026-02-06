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

        $worksheet->mergeCells('A1:Y1');
        $worksheet->mergeCells('A2:Y2');
        $worksheet->mergeCells('A3:Y3');

        $worksheet->getStyle('A1:Y5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Y5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Rincian Penjualan per Asuransi');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:Y5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Asuransi ID');
        $worksheet->setCellValue('C5', 'Asuransi');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Type');
        $worksheet->setCellValue('F5', 'Date Last Invoice');
        $worksheet->setCellValue('G5', 'Vehicle ID');
        $worksheet->setCellValue('H5', 'Plate #');
        $worksheet->setCellValue('I5', 'Kendaraan');
        $worksheet->setCellValue('J5', 'Warna');
        $worksheet->setCellValue('K5', 'Odometer');
        $worksheet->setCellValue('L5', 'Registration #');
        $worksheet->setCellValue('M5', 'Tanggal RG');
        $worksheet->setCellValue('N5', 'WO #');
        $worksheet->setCellValue('O5', 'Tanggal WO');
        $worksheet->setCellValue('P5', 'SO #');
        $worksheet->setCellValue('Q5', 'Tanggal SO');
        $worksheet->setCellValue('R5', 'Last Service');
        $worksheet->setCellValue('S5', 'Last Parts');
        $worksheet->setCellValue('T5', 'Invoice #');
        $worksheet->setCellValue('U5', 'Invoice Total');
        $worksheet->setCellValue('V5', 'VSC #');
        $worksheet->setCellValue('W5', 'Note from WO');
        $worksheet->setCellValue('X5', 'Salesman');
        $worksheet->setCellValue('Y5', 'Mechanic');

        $worksheet->getStyle('A5:Y5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $ordinal = 1;
        $totalSale = '0.00';
        foreach ($insuranceSaleReport as $i => $dataItem) {
            $params = array(
                ':insurance_company_id' => $dataItem['insurance_company_id'],
                ':start_date' => $startDate,
                ':end_date' => $endDate,
            );
            $branchConditionSql = '';
            if (!empty($branchId)) {
                $branchConditionSql = ' AND branch_id = :branch_id';
                $params[':branch_id'] = $branchId;
            }
            $saleReportData = InvoiceHeader::model()->findAll(array(
                'condition' => "insurance_company_id = :insurance_company_id AND invoice_date BETWEEN :start_date AND :end_date" . $branchConditionSql,
                'params' => $params,
            ));
            if (!empty($saleReportData)) {
                foreach ($saleReportData as $saleReportRow) {
                    $grandTotal = CHtml::value($saleReportRow, 'total_price'); 

                    $worksheet->setCellValue("A{$counter}", $ordinal);
                    $worksheet->setCellValue("B{$counter}", $dataItem['insurance_company_id']);
                    $worksheet->setCellValue("C{$counter}", $dataItem['insurance_name']);
                    $worksheet->setCellValue("D{$counter}", CHtml::value($saleReportRow, 'customer.name'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($saleReportRow, 'customer.customer_type'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($saleReportRow, 'invoice_date'));
                    $worksheet->setCellValue("G{$counter}", CHtml::value($saleReportRow, 'vehicle_id'));
                    $worksheet->setCellValue("H{$counter}", CHtml::value($saleReportRow, 'vehicle.plate_number'));
                    $worksheet->setCellValue("I{$counter}", CHtml::value($saleReportRow, 'vehicle.carMake.name') . ' - ' . CHtml::value($saleReportRow, 'vehicle.carModel.name') . ' - ' . CHtml::value($saleReportRow, 'vehicle.carSubModel.name'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($saleReportRow, 'vehicle.color.name'));
                    $worksheet->setCellValue("K{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.vehicle_mileage'));
                    $worksheet->setCellValue("L{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.transaction_number'));
                    $worksheet->setCellValue("M{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.transaction_date'));
                    $worksheet->setCellValue("N{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.work_order_number'));
                    $worksheet->setCellValue("O{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.work_order_date'));
                    $worksheet->setCellValue("P{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.sales_order_number'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.sales_order_date'));
                    $worksheet->setCellValue("R{$counter}", CHtml::value($saleReportRow, 'productLists'));
                    $worksheet->setCellValue("S{$counter}", CHtml::value($saleReportRow, 'serviceLists'));
                    $worksheet->setCellValue("T{$counter}", CHtml::value($saleReportRow, 'invoice_number'));
                    $worksheet->setCellValue("U{$counter}", $grandTotal);
                    $worksheet->setCellValue("W{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.note'));
                    $worksheet->setCellValue("X{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.employeeIdSalesPerson.name'));
                    $worksheet->setCellValue("Y{$counter}", CHtml::value($saleReportRow, 'registrationTransaction.employeeIdAssignMechanic.name'));
                    
                    $totalSale += $grandTotal;
                    $counter++; $ordinal++;
                }
            }
        }
        $worksheet->getStyle("A{$counter}:Y{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:Y{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("T{$counter}", 'TOTAL');
        $worksheet->setCellValue("U{$counter}", $totalSale);

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
