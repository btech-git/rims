<?php

class PaymentInController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('paymentInReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $paymentIn = Search::bind(new PaymentIn('search'), isset($_GET['PaymentIn']) ? $_GET['PaymentIn'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $paymentInSummary = new PaymentInSummary($paymentIn->search());
        $paymentInSummary->setupLoading();
        $paymentInSummary->setupPaging($pageSize, $currentPage);
        $paymentInSummary->setupSorting();
        $paymentInSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($paymentInSummary, $branchId, $paymentInSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'paymentIn' => $paymentIn,
            'paymentInSummary' => $paymentInSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($paymentInSummary, $branchId, $dataProvider, array $options = array()) {

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Payment In');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Payment In');

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

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Payment In');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Payment #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Amount');
        $worksheet->setCellValue('D5', 'Note');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Vehicle');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Payment Type');
        $worksheet->setCellValue('I5', 'Branch');
        $worksheet->setCellValue('J5', 'Admin');

        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->payment_number));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->payment_date));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'payment_amount')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'notes')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'paymentType.name')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));

            $counter++;
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Payment In.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
