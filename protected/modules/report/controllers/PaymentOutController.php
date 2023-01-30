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
            if (!(Yii::app()->user->checkAccess('paymentOutReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $paymentOut = Search::bind(new PaymentOut('search'), isset($_GET['PaymentOut']) ? $_GET['PaymentOut'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $paymentOutSummary = new PaymentOutSummary($paymentOut->search());
        $paymentOutSummary->setupLoading();
        $paymentOutSummary->setupPaging($pageSize, $currentPage);
        $paymentOutSummary->setupSorting();
        $paymentOutSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($paymentOutSummary, $branchId, $paymentOutSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'paymentOut' => $paymentOut,
            'paymentOutSummary' => $paymentOutSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($paymentOutSummary, $branchId, $dataProvider, array $options = array()) {
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

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);
        $worksheet->getColumnDimension('I')->setAutoSize(true);
        $worksheet->getColumnDimension('J')->setAutoSize(true);
        $worksheet->getColumnDimension('K')->setAutoSize(true);

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Payment Out');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Payment #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Amount');
        $worksheet->setCellValue('D5', 'Note');
        $worksheet->setCellValue('E5', 'Supplier');
        $worksheet->setCellValue('F5', 'PO #');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Payment Type');
        $worksheet->setCellValue('I5', 'Bank');
        $worksheet->setCellValue('J5', 'Branch');
        $worksheet->setCellValue('K5', 'Admin');

        $worksheet->getStyle('A5:K5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->payment_number));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->payment_date));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'payment_amount')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'notes')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'purchaseOrder.purchase_order_no')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'paymentType.name')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'companyBank.name')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));

            $counter++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Payment Out.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
