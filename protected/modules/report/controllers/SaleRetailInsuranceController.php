<?php

class SaleRetailInsuranceController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleCustomerSummaryReport'))) {
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
        $taxValue = (isset($_GET['TaxValue'])) ? $_GET['TaxValue'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $insuranceId = (isset($_GET['InsuranceId'])) ? $_GET['InsuranceId'] : '';

        $insuranceSaleReport = InsuranceCompany::getInsuranceSaleReport($startDate, $endDate, $insuranceId, $branchId, $taxValue);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($insuranceSaleReport, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
                'branchId' => $branchId,
                'taxValue' => $taxValue,
                'insuranceId' => $insuranceId,
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

    public function actionTransactionInfo($insuranceId, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceHeader::model()->searchByInsuranceTransactionInfo($insuranceId, $startDate, $endDate, $branchId, $page);
        $insuranceCompany = InsuranceCompany::model()->findByPk($insuranceId);
        $branch = Branch::model()->findByPk($branchId);
        
        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'insuranceCompany' => $insuranceCompany,
            'branch' => $branch,
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
        $taxValue = $options['taxValue']; 
        $insuranceId = $options['insuranceId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan per Asuransi');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan per Asuransi');

        $worksheet->mergeCells('A1:D1');
        $worksheet->mergeCells('A2:D2');
        $worksheet->mergeCells('A3:D3');

        $worksheet->getStyle('A1:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:D5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan per Asuransi Summary');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Asuransi');
        $worksheet->setCellValue('C5', 'Akun');
        $worksheet->setCellValue('D5', 'Total Sales');

        $worksheet->getStyle('A5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        
        $totalSale = '0.00';
        foreach ($insuranceSaleReport as $i => $dataItem) {
            $grandTotal = CHtml::encode($dataItem['grand_total']);
            $worksheet->getStyle("D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $dataItem['insurance_company_id']);
            $worksheet->setCellValue("B{$counter}", $dataItem['insurance_name']);
            $worksheet->setCellValue("C{$counter}", $dataItem['coa_name']);
            $worksheet->setCellValue("D{$counter}", $grandTotal);

            $counter++;
            
            $totalSale += $grandTotal;
        }

        $worksheet->getStyle("A{$counter}:D{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:D{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $worksheet->setCellValue("B{$counter}", 'Total');
        $worksheet->setCellValue("C{$counter}", 'Rp');
        $worksheet->setCellValue("D{$counter}", $totalSale);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_per_asuransi_summary.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
