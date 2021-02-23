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
        $jurnalUmum = Search::bind(new JurnalUmum('search'), isset($_GET['JurnalUmum']) ? $_GET['JurnalUmum'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $companyId = (isset($_GET['CompanyId'])) ? $_GET['CompanyId'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : '';
        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $jurnalUmumSummary = new TransactionJournalSummary($jurnalUmum->search());
        $jurnalUmumSummary->setupLoading();
        $jurnalUmumSummary->setupPaging($pageSize, $currentPage);
        $jurnalUmumSummary->setupSorting();
        $jurnalUmumSummary->setupFilter($startDate, $endDate, $companyId, $branchId, $transactionType, $coaId);

        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values

        if (isset($_GET['Coa'])) {
            $coa->attributes = $_GET['Coa'];
        }

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_category_id != 0 AND coa_id != 0");
        $coaCriteria->compare('code', $coa->code, true);
        $coaCriteria->compare('name', $coa->name, true);
        $coaCriteria->compare('coa_category_id', $coa->coa_category_id);
        $coaCriteria->compare('coa_sub_category_id', $coa->coa_sub_category_id, true);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        /* if (isset($_GET['SaveExcel']))
          $this->saveToExcel($saleSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate)); */

        $this->render('summary', array(
            'jurnalUmum' => $jurnalUmum,
            'jurnalUmumSummary' => $jurnalUmumSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'companyId' => $companyId,
            'branchId' => $branchId,
            'transactionType' => $transactionType,
            'coaId' => $coaId,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        $saleSummary = new SaleSummary($dataProvider);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Ovela');
        $documentProperties->setTitle('Laporan Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan');

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

        $worksheet->setCellValue('A1', 'Ovela');
        $worksheet->setCellValue('A2', 'Penjualan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->setCellValue('A5', 'Nomor Penjualan');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Catatan');
        $worksheet->setCellValue('D5', 'Gudang');
        $worksheet->setCellValue('E5', 'Customer');

        $worksheet->getStyle('A5:H5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A6', 'Nama Produk');
        $worksheet->setCellValue('B6', 'Jumlah');
        $worksheet->setCellValue('C6', 'Jumlah Paket');
        $worksheet->setCellValue('D6', 'Transaction Type');
        $worksheet->setCellValue('E6', 'Harga Satuan');
        $worksheet->setCellValue('F6', '+/-(%)Referral');
        $worksheet->setCellValue('G6', '+/-(%) General');
        $worksheet->setCellValue('H6', 'Total');

        $counter = 8;
        foreach ($dataProvider->data as $header) {
            $followUpHeader = $header->followUpHeader(array(
                'scopes' => 'resetScope',
                'with' => array(
                    'customer:resetScope',
                ),
            ));
            $worksheet->setCellValue("A{$counter}", $header->getCodeNumber(SaleHeader::CN_CONSTANT));
            $worksheet->setCellValue("B{$counter}", Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date)));
            $worksheet->setCellValue("C{$counter}", $header->note);
            $worksheet->setCellValue("D{$counter}", $header->warehouse->name);
            $worksheet->setCellValue("E{$counter}", $followUpHeader->customer->full_name);

            $counter++;

            foreach ($header->saleDetails as $detail) {
                $detailProduct = $detail->product(array('scopes' => 'resetScope', 'with' => array('medicine:resetScope', 'treatment:resetScope')));
                $worksheet->getStyle("E{$counter}:H{$counter}")->getNumberFormat()->setFormatCode('#,##0');

                $worksheet->setCellValue("A{$counter}", ($detailProduct->medicine === null) ? $detailProduct->treatment->name : $detailProduct->medicine->name);
                $worksheet->setCellValue("B{$counter}", $detail->quantity);
                $worksheet->setCellValue("C{$counter}", $detail->quantity_package);
                $worksheet->setCellValue("D{$counter}", $detail->transactionType);
                $worksheet->setCellValue("E{$counter}", $detail->unit_price);
                $worksheet->setCellValue("F{$counter}", $detail->referral_discount);
                $worksheet->setCellValue("G{$counter}", $detail->general_discount);
                $worksheet->setCellValue("H{$counter}", $detail->total);

                $counter++;
            }

            $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $worksheet->getStyle("C{$counter}")->getFont()->setBold(true);
            $worksheet->getStyle("H{$counter}")->getNumberFormat()->setFormatCode('#,##0.00');
            $worksheet->setCellValue("C{$counter}", 'SUB TOTAL');
            $worksheet->setCellValue("H{$counter}", $header->subTotal);

            $counter++;

            $worksheet->getStyle("C{$counter}")->getFont()->setBold(true);
            $worksheet->getStyle("H{$counter}")->getNumberFormat()->setFormatCode('#,##0.00');
            $worksheet->setCellValue("C{$counter}", 'ADDITIONAL CHARGE');
            $worksheet->setCellValue("H{$counter}", $header->additional_charge);

            $counter++;

            $worksheet->getStyle("C{$counter}")->getFont()->setBold(true);
            $worksheet->getStyle("H{$counter}")->getNumberFormat()->setFormatCode('#,##0.00');
            $worksheet->setCellValue("C{$counter}", 'SHIPPING FEE');
            $worksheet->setCellValue("H{$counter}", $header->shipping_fee);

            $counter++;

            $worksheet->getStyle("C{$counter}")->getFont()->setBold(true);
            $worksheet->getStyle("H{$counter}")->getNumberFormat()->setFormatCode('#,##0.00');
            $worksheet->setCellValue("C{$counter}", 'GRAND TOTAL');
            $worksheet->setCellValue("H{$counter}", $header->grandTotal);

            $counter++;
        }
        $worksheet->getStyle("C{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("H{$counter}")->getNumberFormat()->setFormatCode('#,##0.00');
        $worksheet->setCellValue("C{$counter}", 'TOTAL PENJUALAN');
        $worksheet->setCellValue("H{$counter}", $saleSummary->grandTotal);


        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="penjualan.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

}
