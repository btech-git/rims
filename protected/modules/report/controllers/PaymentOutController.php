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

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');

        $worksheet->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Payment Out');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Payment #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Amount');
        $worksheet->setCellValue('D5', 'Note');
        $worksheet->setCellValue('E5', 'Supplier');
        $worksheet->setCellValue('F5', 'PO #');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Payment Type');
        $worksheet->setCellValue('I5', 'Bank Asal');
        $worksheet->setCellValue('J5', 'Bank Tujuan');
        $worksheet->setCellValue('K5', 'Branch');
        $worksheet->setCellValue('L5', 'Admin');

        $worksheet->getStyle('A5:L5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $totalPayment = 0.00;
        foreach ($dataProvider->data as $header) {
            $paymentAmount = CHtml::value($header, 'payment_amount');
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->payment_number));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->payment_date));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($paymentAmount));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'notes')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'purchaseOrder.purchase_order_no')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'paymentType.name')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'bank.name')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'companyBank.bank.name')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));

            $counter++; $counter++;
            $totalPayment += $paymentAmount;
        }
        
        $worksheet->getStyle("B{$counter}:D{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("C{$counter}", CHtml::encode($totalPayment));        

        for ($col = 'A'; $col !== 'L'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Payment Out.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
