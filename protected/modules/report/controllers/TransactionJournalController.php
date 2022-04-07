<?php

class TransactionJournalController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('accountingReport')) || !(Yii::app()->user->checkAccess('financeReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $jurnalUmum = Search::bind(new JurnalUmum('search'), isset($_GET['JurnalUmum']) ? $_GET['JurnalUmum'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $companyId = (isset($_GET['CompanyId'])) ? $_GET['CompanyId'] : '';
//        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
//        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : '';
//        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 1000;
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $jurnalUmumSummary = new TransactionJournalSummary($jurnalUmum->search());
        $jurnalUmumSummary->setupLoading();
        $jurnalUmumSummary->setupPaging($pageSize, $currentPage);
        $jurnalUmumSummary->setupSorting();
        $jurnalUmumSummary->setupFilter($startDate, $endDate);

        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values

        if (isset($_GET['Coa'])) {
            $coa->attributes = $_GET['Coa'];
        }

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("t.status = 'Approved' AND t.coa_id IS NOT NULL");
        $coaCriteria->compare('t.code', $coa->code, true);
        $coaCriteria->compare('t.name', $coa->name, true);
        $coaCriteria->compare('t.coa_category_id', $coa->coa_category_id);
        $coaCriteria->compare('t.coa_sub_category_id', $coa->coa_sub_category_id);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        if (isset($_GET['SaveExcel'])) {
          $this->saveToExcel($jurnalUmumSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }
        
        $this->render('summary', array(
            'jurnalUmum' => $jurnalUmum,
            'jurnalUmumSummary' => $jurnalUmumSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'companyId' => $companyId,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Laporan Jurnal Umum');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Jurnal Umum');

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');

        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'PT. Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Jurnal Umum');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Kode Transaksi');
        $worksheet->setCellValue('D5', 'Kode COA');
        $worksheet->setCellValue('E5', 'Nama COA');
        $worksheet->setCellValue('F5', 'Debit');
        $worksheet->setCellValue('G5', 'Kredit');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7; $lastId = ''; $nomor = 1;
        foreach ($dataProvider->data as $header) {
            if ($lastId !== $header->kode_transaksi) {
                $totalDebit = 0; $totalCredit = 0; $index = 1;
                $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $header->kode_transaksi, 'is_coa_category' => 0));
                $totalTransaction = count($transactions); 
                
                $worksheet->mergeCells("D{$counter}:G{$counter}");
                $worksheet->setCellValue("A{$counter}", $nomor);
                $worksheet->setCellValue("B{$counter}", $header->tanggal_transaksi);
                $worksheet->setCellValue("C{$counter}", $header->kode_transaksi);
                $worksheet->setCellValue("D{$counter}", $header->transaction_subject);

                $counter++; $nomor++;
            }

            $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0;
            $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0;
            
            $worksheet->mergeCells("A{$counter}:B{$counter}");
            $worksheet->mergeCells("C{$counter}:E{$counter}");
            $worksheet->setCellValue("A{$counter}", $header->branchAccountCode);
            $worksheet->setCellValue("C{$counter}", $header->branchAccountName);
            $worksheet->setCellValue("F{$counter}", $amountDebit);
            $worksheet->setCellValue("G{$counter}", $amountCredit);
            $counter++;
            
            $totalDebit += $amountDebit;
            $totalCredit += $amountCredit;
            
            if ($index == $totalTransaction) {
                $worksheet->mergeCells("A{$counter}:E{$counter}");
                $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
                $worksheet->setCellValue("A{$counter}", 'TOTAL');
                $worksheet->setCellValue("F{$counter}", $totalDebit);
                $worksheet->setCellValue("G{$counter}", $totalCredit);
                $counter++;$counter++;
            }
            $index++;
            $lastId = $header->kode_transaksi; 
        }
        
        for ($col = 'A'; $col !== 'G'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Jurnal Umum.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
