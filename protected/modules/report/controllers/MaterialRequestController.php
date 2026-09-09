<?php

class MaterialRequestController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('materialRequestReport') )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $materialRequestHeader = Search::bind(new MaterialRequestHeader('search'), isset($_GET['MaterialRequestHeader']) ? $_GET['MaterialRequestHeader'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $materialRequestSummary = new MaterialRequestSummary($materialRequestHeader->search());
        $materialRequestSummary->setupLoading();
        $materialRequestSummary->setupPaging($pageSize, $currentPage);
        $materialRequestSummary->setupSorting();
        $materialRequestSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($materialRequestSummary->dataProvider, $branchId, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'materialRequestHeader' => $materialRequestHeader,
            'materialRequestSummary' => $materialRequestSummary,
            'branchId' => $branchId,
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
        $documentProperties->setTitle('Laporan Material Request');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Material Request');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Material Request');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Permintaan #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Status Doc');
        $worksheet->setCellValue('D5', 'Note');
        $worksheet->setCellValue('E5', 'Admin');
        $worksheet->setCellValue('F5', 'Status Movement');
        $worksheet->setCellValue('G5', 'Product');
        $worksheet->setCellValue('H5', 'Quantity');
        $worksheet->setCellValue('I5', 'Quantity Movement');
        $worksheet->setCellValue('J5', 'Quantity Sisa');
        $worksheet->setCellValue('K5', 'Satuan');
        $worksheet->setCellValue('L5', 'Movement Out #');
        $worksheet->setCellValue('M5', 'Tanggal');

        $worksheet->getStyle('A5:M5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($dataProvider->data as $header) {
            foreach ($header->materialRequestDetails as $detail) {
                $worksheet->getStyle("I{$counter}:K{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transaction_number'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'transaction_date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'status_document'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'note'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'user.username'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'status'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($detail, 'product.name'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($detail, 'quantity'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail, 'quantity_movement_out'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'quantity_remaining'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'unit.name'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'movementOutNumber'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'movementOutDate'));

                $counter++;
            }
        }

        ob_end_clean();

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_material_request.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
