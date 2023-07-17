<?php

class SaleRetailController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleCustomerReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleRetailSummary = new SaleRetailSummary($customer->search());
        $saleRetailSummary->setupLoading();
        $saleRetailSummary->setupPaging($pageSize, $currentPage);
        $saleRetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $saleRetailSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'saleRetailSummary' => $saleRetailSummary,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['Customer']['id'])) ? $_POST['Customer']['id'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_name' => CHtml::value($customer, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Rincian Penjualan per Pelanggan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Penjualan per Pelanggan');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');

        $worksheet->getStyle('A1:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I6')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Rincian Penjualan per Pelanggan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:I5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Customer');
        $worksheet->setCellValue('B5', 'Type');
        $worksheet->setCellValue('C5', 'Penjualan #');
        $worksheet->setCellValue('D5', 'Tanggal');
        $worksheet->setCellValue('E5', 'Jenis');
        $worksheet->setCellValue('F5', 'Vehicle');
        $worksheet->setCellValue('G5', 'Total Jasa');
        $worksheet->setCellValue('H5', 'Total Product');
        $worksheet->setCellValue('I5', 'Grand Total');

        $worksheet->getStyle('A6:I6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($dataProvider->data as $header) {
            $totalSale = 0.00;
            $registrationTransactions = RegistrationTransaction::model()->findAll(array(
                'condition' => 'customer_id = :customer_id AND transaction_date BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':customer_id' => $header->id,
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                )
            ));
            if (!empty($registrationTransactions)) {
                foreach ($registrationTransactions as $detail) {
                    $grandTotal = CHtml::value($detail, 'grand_total');
                    $worksheet->getStyle("G{$counter}:I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'customer_type')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode($detail->transaction_number));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($detail->transaction_date));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'repair_type')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'vehicle.plate_number')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'subtotal_service')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'subtotal_product')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode($grandTotal));
                    $counter++;
                    
                    $totalSale += $grandTotal;
                }
                $worksheet->setCellValue("H{$counter}", 'TOTAL');
                $worksheet->setCellValue("I{$counter}", CHtml::encode($totalSale));
                $counter++;$counter++;
            }
        }

        for ($col = 'A'; $col !== 'I'; $col++) {
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
