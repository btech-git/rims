<?php

class GeneralLedgerController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('accounting')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
		ini_set('memory_limit', '1024M');
        
        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $number = (isset($_GET['Number'])) ? $_GET['Number'] : '';
        $accountId = (isset($_GET['AccountId'])) ? $_GET['AccountId'] : '';

        $accounts = Coa::model()->findAll(array(
            'order' => 'code ASC',
        ));

        $generalLedgerSummary = new GeneralLedgerSummary($account->search());
        $generalLedgerSummary->setupLoading($startDate, $endDate, $accountId);
        $generalLedgerSummary->setupPaging($pageSize, $currentPage);
        $generalLedgerSummary->setupSorting();
        $generalLedgerSummary->setupFilter($startDate, $endDate, $accountId);
        $generalLedgerSummary->getSaldo($startDate);

//        if (isset($_GET['SaveExcel']))
//            $this->saveToExcel($generalLedgerSummary, $generalLedgerSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));

        $this->render('summary', array(
            'account' => $account,
            'generalLedgerSummary' => $generalLedgerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'number' => $number,
            'accounts' => $accounts,
            'accountId' => $accountId,
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->amountPaid;

        return $grandTotal;
    }

//    public function actionAjaxHtmlAccount() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $startAccount = (isset($_GET['StartAccount'])) ? $_GET['StartAccount'] : '';
//            $endAccount = (isset($_GET['EndAccount'])) ? $_GET['EndAccount'] : '';
//
//            $accounts = Account::model()->findAllByAttributes(
//                array(
//                    'branch_id' => $_POST['BranchId'],
//                ), array(
//                    'order' => 'code ASC',
//                )
//            );
//
//            $account = Search::bind(new Account('search'), isset($_GET['Account']) ? $_GET['Account'] : array());
//
//            $this->renderPartial('_account', array(
//                'account' => $account,
//                'accounts' => $accounts,
//                'startAccount' => $startAccount,
//                'endAccount' => $endAccount,
//            ));
//        }
//    }

    protected function saveToExcel($generalLedgerSummary, $dataProvider, array $options = array()) {
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Karya Tirta Perkasa');
        $documentProperties->setTitle('Laporan Buku Besar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Buku Besar');

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);


        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G6')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Laporan Buku Besar');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Akun');
        $worksheet->mergeCells('A5:D5');
        $worksheet->setCellValue('E5', 'Total Debit');
        $worksheet->setCellValue('F5', 'Total Kredit');
        $worksheet->setCellValue('G5', 'Saldo Akhir');

        $worksheet->setCellValue('A6', 'Transaksi');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Description');
        $worksheet->setCellValue('D6', 'Memo');
        $worksheet->setCellValue('E6', 'Debit');
        $worksheet->setCellValue('F6', 'Kredit');
        $worksheet->setCellValue('G6', 'Saldo');

        $worksheet->getStyle('A6:G6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;

        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'code')) . '-' . CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->mergeCells("A{$counter}:D{$counter}");
            $worksheet->setCellValue("E{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getEndDebitLedger($header->id, $options['startDate'], $options['endDate']))));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getEndCreditLedger($header->id, $options['startDate'], $options['endDate']))));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getEndBalanceLedger($header->id, $options['endDate']))));
            $counter++;$counter++;

            $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->mergeCells("A{$counter}:F{$counter}");
            $worksheet->setCellValue("A{$counter}", 'SALDO AWAL');
            $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getBeginningBalanceLedger($header->id, $options['startDate']))));
            $counter++;$counter++;


            foreach ($header->accountJournals as $detail) {
                $worksheet->getStyle("A{$counter}:D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($detail, 'transaction_number')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($detail->date))));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($detail, 'transaction_subject')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($detail, 'note')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->debit)));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->credit)));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->currentSaldo)));

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'G'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Buku Besar.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}