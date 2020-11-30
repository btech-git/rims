<?php

class MovementOutController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockAdjustmentReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $movementOutHeader = Search::bind(new MovementOutHeader('search'), isset($_GET['MovementOutHeader']) ? $_GET['MovementOutHeader'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $movementOutSummary = new MovementOutSummary($movementOutHeader->search());
        $movementOutSummary->setupLoading();
        $movementOutSummary->setupPaging($pageSize, $currentPage);
        $movementOutSummary->setupSorting();
        $movementOutSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($movementOutSummary, $branchId, $movementOutSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'movementOutHeader' => $movementOutHeader,
            'movementOutSummary' => $movementOutSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($movementOutSummary, $branchId, $dataProvider, array $options = array()) {

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Movement Out');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Movement Out');

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
        $worksheet->getColumnDimension('L')->setAutoSize(true);
        $worksheet->getColumnDimension('M')->setAutoSize(true);
        $worksheet->getColumnDimension('N')->setAutoSize(true);

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');

        $worksheet->getStyle('A1:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Movement Out');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Movement #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Delivery #');
        $worksheet->setCellValue('D5', 'Return #');
        $worksheet->setCellValue('E5', 'Registration #');
        $worksheet->setCellValue('F5', 'Material Request #');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Type');
        $worksheet->setCellValue('I5', 'Branch');
        $worksheet->setCellValue('J5', 'Admin');
        $worksheet->setCellValue('K5', 'Product');
        $worksheet->setCellValue('L5', 'Quantity');
        $worksheet->setCellValue('M5', 'Quantity Transaction');
        $worksheet->setCellValue('N5', 'Warehouse');

        $worksheet->getStyle('A5:N5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->movementOutDetails as $detail) {
                $worksheet->getStyle("I{$counter}:N{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->movement_out_no));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->date_posting));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'deliveryOrder.delivery_order_no')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'returnOrder.return_order_no')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.transaction_number')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'materialRequest.transaction_number')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'status')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'movementTypeChar')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_transaction')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'warehouse.name')));

                $counter++;
            }
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Movement Out.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
