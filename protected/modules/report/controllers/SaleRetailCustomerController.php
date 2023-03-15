<?php

class SaleRetailCustomerController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleCustomerSummaryReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $saleRetail = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $repairType = (isset($_GET['RepairType'])) ? $_GET['RepairType'] : '';
        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleRetailSummary = new SaleRetailSummary($saleRetail->search());
        $saleRetailSummary->setupLoading();
        $saleRetailSummary->setupPaging($pageSize, $currentPage);
        $saleRetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'customerId' => $customerId,
            'repairType' => $repairType,
        );
        $saleRetailSummary->setupFilter($filters);

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }
        
        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('t.name', $customer->name, true);
        $customerCriteria->compare('t.email', $customer->email, true);
        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailSummary->dataProvider, $branchId, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'saleRetail' => $saleRetail,
            'saleRetailSummary' => $saleRetailSummary,
            'branchId' => $branchId,
            'customerId' => $customerId,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'repairType' => $repairType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($dataProvider, $branchId, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penjualan Retail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Retail');

        $worksheet->mergeCells('A1:AD1');
        $worksheet->mergeCells('A2:AD2');
        $worksheet->mergeCells('A3:AD3');

        $worksheet->getStyle('A1:AD6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AD6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Penjualan Retail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:AD5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Penjualan #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Jenis');
        $worksheet->setCellValue('D5', 'Problem');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Vehicle');
        $worksheet->setCellValue('G5', 'Qty Quick Service');
        $worksheet->setCellValue('H5', 'Price Quick Service');
        $worksheet->setCellValue('I5', 'Qty Service');
        $worksheet->setCellValue('J5', 'Price Service');
        $worksheet->setCellValue('K5', 'Disc Service');
        $worksheet->setCellValue('L5', 'Total Service');
        $worksheet->setCellValue('M5', 'Qty Product');
        $worksheet->setCellValue('N5', 'Price Product');
        $worksheet->setCellValue('O5', 'Disc Product');
        $worksheet->setCellValue('P5', 'Total Product');
        $worksheet->setCellValue('Q5', 'Insurance');
        $worksheet->setCellValue('R5', 'WO #');
        $worksheet->setCellValue('S5', 'WO Date');
        $worksheet->setCellValue('T5', 'Status Doc');
        $worksheet->setCellValue('U5', 'Status Payment');
        $worksheet->setCellValue('V5', 'Status Service');
        $worksheet->setCellValue('W5', 'Sub Total');
        $worksheet->setCellValue('X5', 'PPN');
        $worksheet->setCellValue('Y5', 'PPH');
        $worksheet->setCellValue('Z5', 'Grand Total');
        $worksheet->setCellValue('AA5', 'KM');
        $worksheet->setCellValue('AB5', 'Note');
        $worksheet->setCellValue('AC5', 'Branch');
        $worksheet->setCellValue('AD5', 'Admin');

        $worksheet->getStyle('A6:AD6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->transaction_number));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->transaction_date));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'repair_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'problem')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'total_quickservice')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'total_quickservice_price')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'total_service')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'subtotal_service')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'discount_service')));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'total_service_price')));
            $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($header, 'total_product')));
            $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($header, 'subtotal_product')));
            $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header, 'discount_product')));
            $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($header, 'total_product_price')));
            $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($header, 'insuranceCompany.name')));
            $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($header, 'work_order_number')));
            $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($header, 'work_order_date')));
            $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($header, 'payment_status')));
            $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($header, 'service_status')));
            $worksheet->setCellValue("W{$counter}", CHtml::encode(CHtml::value($header, 'subtotal')));
            $worksheet->setCellValue("X{$counter}", CHtml::encode(CHtml::value($header, 'ppn_price')));
            $worksheet->setCellValue("Y{$counter}", CHtml::encode(CHtml::value($header, 'pph_price')));
            $worksheet->setCellValue("Z{$counter}", CHtml::encode(CHtml::value($header, 'grand_total')));
            $worksheet->setCellValue("AA{$counter}", CHtml::encode(CHtml::value($header, 'vehicle_mileage')));
            $worksheet->setCellValue("AB{$counter}", CHtml::encode(CHtml::value($header, 'note')));
            $worksheet->setCellValue("AC{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
            $worksheet->setCellValue("AD{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));

            $counter++;
            
        }

        $worksheet->getStyle("A{$counter}:AD{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:AD{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("A{$counter}:X{$counter}");
        $worksheet->setCellValue("A{$counter}", 'Total');
        $worksheet->setCellValue("Y{$counter}", 'Rp');
        $worksheet->setCellValue("Z{$counter}", $this->reportGrandTotal($dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'AD'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Retail.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    public function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->grand_total;
        }

        return $grandTotal;
    }

}
