<?php

class FinancialForecastController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('allAccountingReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $companyId = (isset($_GET['CompanyId'])) ? $_GET['CompanyId'] : '';
        $numberOfPeriod = (isset($_GET['NumberOfPeriod'])) ? $_GET['NumberOfPeriod'] : '1';
        
        $companyBanks = CompanyBank::model()->findAllByAttributes(array('company_id' => $companyId));

        $payableTransaction = Search::bind(new TransactionPurchaseOrder(), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : '');
        $payableTransactionDataProvider = $payableTransaction->search();
        $payableTransactionDataProvider->criteria->addCondition('t.payment_left > 0 AND t.status_document = "Approved"');
        
        $receivableTransaction = Search::bind(new InvoiceHeader(), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $receivableTransactionDataProvider = $receivableTransaction->search();
        $receivableTransactionDataProvider->criteria->addCondition('t.payment_left > 0 AND t.status <> "CANCELLED"');
        
        $year = date('Y');
        $month = date('m');
        $numberOfDays = 0;
        for ($i = 0; $i < (int) $numberOfPeriod; $i++) {
            $month = $month === 1 ? 12 : $month - 1;
            $year = $month === 12 ? $year - 1 : $year;
            $numberOfDaysinMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $numberOfDays += $numberOfDaysinMonth;
        }
        $dateNow = date('Y-m-d');
        $datePrevious = date('Y-m-d', strtotime($dateNow . ' -' . $numberOfDays . ' days'));
        
        $this->render('summary', array(
            'companyBanks' => $companyBanks,
            'companyId' => $companyId,
            'datePrevious' => $datePrevious,
            'numberOfPeriod' => $numberOfPeriod,
            'payableTransaction' => $payableTransaction,
            'payableTransactionDataProvider' => $payableTransactionDataProvider,
            'receivableTransaction' => $receivableTransaction,
            'receivableTransactionDataProvider' => $receivableTransactionDataProvider,
        ));
    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/updateEstimateDate', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/updateEstimateDate', 'id' => $model->id));
        }
    }

    public function actionAjaxHtmlUpdateCompanyBankSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $companyId = isset($_GET['CompanyId']) ? $_GET['CompanyId'] : 0;
            $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';

            $this->renderPartial('_companyBankSelect', array(
                'companyId' => $companyId,
                'coaId' => $coaId,
            ), false, true);
        }
    }

//    protected function saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId) {
//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
//        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
//        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);
//
//        spl_autoload_unregister(array('YiiBase', 'autoload'));
//        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
//        spl_autoload_register(array('YiiBase', 'autoload'));
//
//        $objPHPExcel = new PHPExcel();
//
//        $documentProperties = $objPHPExcel->getProperties();
//        $documentProperties->setCreator('Lanusa');
//        $documentProperties->setTitle('Laporan Balance Sheet');
//
//        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
//        $worksheet->setTitle('Laporan Balance Sheet');
//
//        $worksheet->mergeCells('A1:B1');
//        $worksheet->mergeCells('A2:B2');
//        $worksheet->mergeCells('A3:B3');
//        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);
//
//        $branch = Branch::model()->findByPk($branchId);
//        $worksheet->setCellValue('A1', CHtml::encode(($branch === null) ? '' : $branch->name));
//        $worksheet->setCellValue('A2', 'Laporan Balance Sheet');
//        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);
//
//
//        $counter = 6;
//
//
//        foreach ($accountCategoryTypes as $accountCategoryType) {
//            $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
//            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryType, 'name')));
//
//            $counter++;
//
//            foreach ($accountCategoryType->accountCategories as $accountCategory) {
//                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
//                $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategory->getBalanceTotal($startDate, $endDate, $branchId)));
//                $counter++;
//            }
//
//            $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//            $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//            $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryType, 'name')));
//            $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryType->getBalanceTotal($startDate, $endDate, $branchId)));
//
//            $counter++;
//            $counter++;
//        }
//
//
//
//        for ($col = 'A'; $col !== 'H'; $col++) {
//            $objPHPExcel->getActiveSheet()
//                    ->getColumnDimension($col)
//                    ->setAutoSize(true);
//        }
//
//        header('Content-Type: application/xlsx');
//        header('Content-Disposition: attachment;filename="Laporan Balance Sheet.xlsx"');
//        header('Cache-Control: max-age=0');
//
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//        $objWriter->save('php://output');
//
//        Yii::app()->end();
//    }
}