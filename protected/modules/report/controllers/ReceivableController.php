<?php

class ReceivableController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('customerReceivableReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $coa = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $coaDataProvider = $coa->search();
        $coaDataProvider->pagination->pageVar = 'page_dialog';
        $coaDataProvider->criteria->addCondition("t.coa_category_id = 15 AND t.coa_sub_category_id = 8 AND (t.name NOT LIKE '%Asuransi%' OR t.name NOT LIKE '%Insurance%')");

        $receivableSummary = new ReceivableSummary($coa->searchByTransactionJournal());
        $receivableSummary->setupLoading();
        $receivableSummary->setupPaging($pageSize, $currentPage);
        $receivableSummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
            'coaId' => $coaId,
        );
        $receivableSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableSummary, $endDate, $branchId);
        }

        $this->render('summary', array(
            'coa' => $coa,
            'coaDataProvider'=> $coaDataProvider,
            'coaId' => $coaId,
            'branchId' => $branchId,
            'endDate' => $endDate,
            'receivableSummary' => $receivableSummary,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $coaId = (isset($_POST['CoaId'])) ? $_POST['CoaId'] : '';
            $coa = Coa::model()->findByPk($coaId);

            $object = array(
                'customer_id' => CHtml::value($coa, 'id'),
                'customer_name' => CHtml::value($coa, 'name'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($receivableSummary, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Faktur Belum Lunas Customer');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Belum Lunas Customer');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        $worksheet->mergeCells('A4:G4');
        
        $worksheet->getStyle('A1:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G4')->getFont()->setBold(true);
        $worksheet->setCellValue('A2', 'Raperind Motor ');
        $worksheet->setCellValue('A3', 'Faktur Belum Lunas Customer');
        $worksheet->setCellValue('A4', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A6:G6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A7:G7")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:G7')->getFont()->setBold(true);
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('A5', 'Name');
        $worksheet->setCellValue('B5', 'Saldo Awal');
        
        $worksheet->setCellValue('A6', 'Faktur #');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Memo');
        $worksheet->setCellValue('D6', 'Debit');
        $worksheet->setCellValue('E6', 'Credit');
        $worksheet->setCellValue('F6', 'Balance');
        $counter = 9;

        foreach ($receivableSummary->dataProvider->data as $header) {
            $beginningBalance = CHtml::value($header, 'beginningBalanceReceivableDetail');
            $worksheet->setCellValue("A{$counter}", $header->code);
            $worksheet->setCellValue("B{$counter}", $header->name);
            $worksheet->setCellValue("C{$counter}", $beginningBalance);

            $counter++;
            
            $receivableData = $header->getReceivableInvoiceReport($endDate, $branchId);
            $totalRevenue = 0.00;
            $totalPayment = 0.00;
            $totalReceivable = 0.00;
            $currentBalance = $beginningBalance;
            foreach ($receivableData as $receivableRow) {
                $debitAmount = $receivableRow['debit'];
                $creditAmount = $receivableRow['credit'];
                $currentBalance += $debitAmount - $creditAmount;
                
                $worksheet->setCellValue("A{$counter}", $receivableRow['kode_transaksi']);
                $worksheet->setCellValue("B{$counter}", $receivableRow['tanggal_transaksi']);
                $worksheet->setCellValue("C{$counter}", $receivableRow['remark']);
                $worksheet->setCellValue("D{$counter}", $debitAmount);
                $worksheet->setCellValue("E{$counter}", $creditAmount);
                $worksheet->setCellValue("F{$counter}", $currentBalance);
                
                $counter++;
                
                $totalRevenue += $debitAmount;
                $totalPayment += $creditAmount;
                $totalReceivable += $currentBalance;
            }
            
            $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);

            $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->mergeCells("A{$counter}:D{$counter}");
            $worksheet->setCellValue("A{$counter}", 'Total');
            $worksheet->setCellValue("E{$counter}", $totalRevenue);
            $worksheet->setCellValue("F{$counter}", $totalPayment);
            $worksheet->setCellValue("G{$counter}", $totalReceivable);

            $counter++;$counter++;
        }

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Faktur Belum Lunas Customer.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
