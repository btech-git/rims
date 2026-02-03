<?php

class ReceivableDetailController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('receivableReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

//        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $accountDataProvider = $account->search();
        $accountDataProvider->criteria->compare('t.is_approved', 1);
        $accountDataProvider->criteria->compare('t.coa_sub_category_id', 8);
//        $accountDataProvider->criteria->addCondition("t.name NOT LIKE '%Asuransi%'");
        $accountDataProvider->pagination->pageVar = 'page_dialog';

        $receivableDetailSummary = new ReceivableDetailSummary($account->search());
        $receivableDetailSummary->setupLoading();
        $receivableDetailSummary->setupPaging($pageSize, $currentPage);
        $receivableDetailSummary->setupSorting();
        $receivableDetailSummary->setupFilter($endDate, $branchId, $coaId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableDetailSummary->dataProvider, array(
                'endDate' => $endDate, 
                'branchId' => $branchId,
            ));
        }
        
        $this->render('summary', array(
            'account' => $account,
            'accountDataProvider' => $accountDataProvider,
            'branchId' => $branchId,
            'receivableDetailSummary' => $receivableDetailSummary,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
            'coaId' => $coaId,
        ));
    }

    public function actionAjaxJsonCoa() {
        if (Yii::app()->request->isAjaxRequest) {
            $coaId = (isset($_POST['Coa']['id'])) ? $_POST['Coa']['id'] : '';
            $coa = Coa::model()->findByPk($coaId);

            $object = array(
                'coa_name' => CHtml::value($coa, 'combinationName'),
                'coa_code' => CHtml::value($coa, 'code'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($receivableDetailSummary, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];
        $branchId = $options['branchId']; 
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Detail');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');

        $worksheet->getStyle('A1:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Piutang Customer Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:F5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Transaksi #');
        $worksheet->setCellValue('C5', 'Keterangan');
        $worksheet->setCellValue('D5', 'Debit');
        $worksheet->setCellValue('E5', 'Kredit');
        $worksheet->setCellValue('F5', 'Saldo');

        $worksheet->getStyle('A5:F5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;

        foreach ($receivableDetailSummary->data as $header) {
//            $receivableAmount = $header->getReceivableAmount();
//            if ($receivableAmount !== 0) {
                $worksheet->mergeCells("A{$counter}:B{$counter}");
                $worksheet->mergeCells("C{$counter}:E{$counter}");
                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'code'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'name'));
                $saldo = 0; //$header->getBeginningBalanceReceivable($startDate);
                $worksheet->setCellValue("F{$counter}", $saldo);
                
                $counter++;
                
                $receivableData = $header->getReceivableDetailReport($endDate, $options['branchId']);
                
                foreach ($receivableData as $receivableRow) {
                    $transactionNumber = $receivableRow['kode_transaksi'];
                    $amount = $receivableRow['amount'];
                    if ($receivableRow['transaction_type'] == 'D') {
                        $saldo += $amount;
                    } else {
                        $saldo -= $amount;
                    }
                    
                    $worksheet->setCellValue("A{$counter}", $receivableRow['tanggal_transaksi']);
                    $worksheet->setCellValue("B{$counter}", $transactionNumber);
                    $worksheet->setCellValue("C{$counter}", $receivableRow['remark']);
                    $worksheet->setCellValue("D{$counter}", $receivableRow['transaction_type'] == 'D' ? $amount : 0);
                    $worksheet->setCellValue("E{$counter}", $receivableRow['transaction_type'] == 'K' ? $amount : 0);
                    $worksheet->setCellValue("F{$counter}", $saldo);
                    
                    $counter++;
                }
                
//                $worksheet->mergeCells("A{$counter}:F{$counter}");
//                $worksheet->setCellValue("A{$counter}", "Total Penambahan");
//                $worksheet->setCellValue("G{$counter}", $positiveAmount));
                $counter++;
//                
//                $worksheet->mergeCells("A{$counter}:F{$counter}");
//                $worksheet->setCellValue("A{$counter}", "Total Penurunan");
//                $worksheet->setCellValue("G{$counter}", $negativeAmount));
//                $counter++;
//                
//                $worksheet->mergeCells("A{$counter}:F{$counter}");
//                $worksheet->setCellValue("A{$counter}", "Perubahan Bersih");
//                $worksheet->setCellValue("G{$counter}", $saldo));
//                $counter++; $counter++;
                
//            }
        }
            
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_customer_detail.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/show', 'id' => $model->id));
        }
    }
}