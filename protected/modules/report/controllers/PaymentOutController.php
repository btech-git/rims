<?php

class PaymentOutController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('paymentOutReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $paymentOut = Search::bind(new PaymentOut('search'), isset($_GET['PaymentOut']) ? $_GET['PaymentOut'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $paymentType = isset($_GET['PaymentType']) ? $_GET['PaymentType'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $supplierId = isset($_GET['SupplierId']) ? $_GET['SupplierId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $paymentOutSummary = new PaymentOutSummary($paymentOut->search());
        $paymentOutSummary->setupLoading();
        $paymentOutSummary->setupPaging($pageSize, $currentPage);
        $paymentOutSummary->setupSorting();
        $paymentOutSummary->setupFilter($startDate, $endDate, $branchId, $paymentType, $supplierId);

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Supplier'])) {
            $supplier->attributes = $_GET['Supplier'];
        }
        
        $supplierCriteria = new CDbCriteria;
        $supplierCriteria->compare('t.name', $supplier->name, true);
        $supplierCriteria->compare('t.company', $supplier->company, true);
        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($paymentOutSummary->dataProvider, $branchId, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'paymentOut' => $paymentOut,
            'paymentOutSummary' => $paymentOutSummary,
            'branchId' => $branchId,
            'supplierId' => $supplierId,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'paymentType' => $paymentType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonSupplier() {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['SupplierId'])) ? $_POST['SupplierId'] : '';
            $supplier = Supplier::model()->findByPk($supplierId);

            $object = array(
                'supplier_name' => CHtml::value($supplier, 'company'),
            );
            
            echo CJSON::encode($object);
        }
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
        $documentProperties->setTitle('Laporan Payment Out');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Payment Out');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Payment Out');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Payment #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Supplier');
        $worksheet->setCellValue('D5', 'Invoice #');
        $worksheet->setCellValue('E5', 'Status');
        $worksheet->setCellValue('F5', 'Payment Type');
        $worksheet->setCellValue('G5', 'Note');
        $worksheet->setCellValue('H5', 'Bank Asal');
        $worksheet->setCellValue('I5', 'Bank Tujuan');
        $worksheet->setCellValue('J5', 'Admin');
        $worksheet->setCellValue('K5', 'Memo');
        $worksheet->setCellValue('L5', 'Total Invoice');
        $worksheet->setCellValue('M5', 'Payment Amount');

        $worksheet->getStyle('A5:M5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->payOutDetails as $detail) {
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'payment_number'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'payment_date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'supplier.name'));
                $worksheet->setCellValue("D{$counter}", empty($detail->receive_item_id) ? CHtml::value($detail, 'workOrderExpenseHeader.transaction_number') : CHtml::value($detail, 'receiveItem.invoice_number'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'paymentType.name'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'notes'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'bank.name'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'companyBank.bank.name'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'user.username'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'memo'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'total_invoice'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'amount'));

                $counter++;
            }
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_payment_out.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
