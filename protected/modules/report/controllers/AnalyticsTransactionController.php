<?php

class AnalyticsTransactionController extends Controller {

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
        
        $count = 0;
        $branchId = User::model()->findByPk(Yii::app()->user->getId())->branch_id;
        $date = date_create(date('d-m-Y'));
        date_sub($date, date_interval_create_from_date_string("7 days"));

        if (!empty($branchId)) {
            $requestCriteria = new CDbCriteria;
            $requestCriteria->addCondition(" main_branch_id = " . $branchId . " AND DATE(request_order_date) >= (NOW() - INTERVAL 7 DAY)");
            $requestOrder = TransactionRequestOrder::model()->findAll($requestCriteria);
            $purchaseCriteria = new CDbCriteria;
            $purchaseCriteria->addCondition(" main_branch_id = " . $branchId . " AND DATE(purchase_order_date) >= (NOW() - INTERVAL 7 DAY)");
            $purchase = TransactionPurchaseOrder::model()->findAll($purchaseCriteria);

            $salesCriteria = new CDbCriteria;
            $salesCriteria->addCondition(" requester_branch_id = " . $branchId . " AND DATE(sale_order_date) >= (NOW() - INTERVAL 7 DAY)");
            $sales = TransactionSalesOrder::model()->findAll($salesCriteria);

            $transferCriteria = new CDbCriteria;
            $transferCriteria->addCondition(" destination_branch_id = " . $branchId . " AND DATE(transfer_request_date) >= (NOW() - INTERVAL 7 DAY)");
            $transfer = TransactionTransferRequest::model()->findAll($transferCriteria);

            $sentCriteria = new CDbCriteria;
            $sentCriteria->addCondition(" destination_branch_id = " . $branchId . " AND DATE(sent_request_date) >= (NOW() - INTERVAL 7 DAY)");
            $sent = TransactionSentRequest::model()->findAll($sentCriteria);

            $consignmentCriteria = new CDbCriteria;
            $consignmentCriteria->addCondition(" branch_id = " . $branchId . " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
            $consignment = ConsignmentOutHeader::model()->findAll($consignmentCriteria);

            $consignmentInCriteria = new CDbCriteria;
            $consignmentInCriteria->addCondition(" receive_branch = " . $branchId . " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
            $consignmentIn = ConsignmentInHeader::model()->findAll($consignmentInCriteria);

            $movementCriteria = new CDbCriteria;
            $movementCriteria->addCondition(" branch_id = " . $branchId . " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
            $movement = MovementOutHeader::model()->findAll($movementCriteria);

            $movementInCriteria = new CDbCriteria;
            $movementInCriteria->addCondition(" branch_id = " . $branchId . " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
            $movementIn = MovementInHeader::model()->findAll($movementInCriteria);

        }
            
        $totalReceivables = InvoiceHeader::totalReceivables();
        $totalPayables = TransactionReceiveItem::totalPayables();
        
        $resultSet = RegistrationTransaction::graphSale();
        $records = array();
        $year = intval(date('Y'));
        $month = intval(date('m'));
        for ($i = 0; $i < 12; $i++) {
            $records[$year][$month] = 0;
            $month--;
            if ($month <= 0) {
                $month += 12;
                $year--;
            }
        }
        foreach ($resultSet as $item) {
            $month = intval($item['month']);
            $year = intval($item['year']);
            if (isset($records[$year][$month])) {
                $records[$year][$month] = doubleval($item['grand_total']);
            }
        }
        $rows = array();
        foreach ($records as $y => $record) {
            foreach ($record as $m => $value) {
                $month = date("M", mktime(0, 0, 0, $m));
                $year = substr($y, 2);
                $rows[] = array($month . " " . $year, $value);
            }
        }
        $dataSale = array_merge(array(array('Monthly', 'Sales')), array_reverse($rows));

        $resultSetBranch = JurnalUmum::graphSalePerBranch();
        $branchRows = array();
        foreach ($resultSetBranch as $item) {
            $branchRows[] = array($item['branch_name'], doubleval($item['total']));
        }
        $dataSalePerBranch = array_merge(array(array('Branch', 'Sales')), $branchRows);

        $resultSetIncomeExpense = JurnalUmum::graphIncomeExpense();
        $incomeExpenseRecords = array();
        $incomeExpenseYear = intval(date('Y'));
        $incomeExpenseMonth = intval(date('m'));
        for ($i = 0; $i < 12; $i++) {
            $incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth] = 0;
            $incomeExpenseMonth--;
            if ($incomeExpenseMonth <= 0) {
                $incomeExpenseMonth += 12;
                $incomeExpenseYear--;
            }
        }
        foreach ($resultSetIncomeExpense as $item) {
            $incomeExpenseMonth = intval($item['month']);
            $incomeExpenseYear = intval($item['year']);
            if (isset($incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth])) {
                $incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth] = array(doubleval($item['debit']), doubleval($item['kredit']));
            }
        }
        $incomeExpenseRows = array();
        foreach ($incomeExpenseRecords as $y => $record) {
            foreach ($record as $m => $value) {
                $incomeExpenseMonth = date("M", mktime(0, 0, 0, $m));
                $incomeExpenseYear = substr($y, 2);
                $incomeExpenseRows[] = array_merge(array($incomeExpenseMonth . " " . $incomeExpenseYear), $value);
            }
        }
        $dataIncomeExpense = array_merge(array(array('Monthly', 'Income', 'Expense')), array_reverse($incomeExpenseRows));

        $this->render('summary', array(
            'dataSale' => $dataSale,
            'dataSalePerBranch' => $dataSalePerBranch,
            'dataIncomeExpense' => $dataIncomeExpense,
            'totalReceivables' => $totalReceivables,
            'totalPayables' => $totalPayables,
            'requestOrder' => $requestOrder,
            'purchase' => $purchase,
            'sales' => $sales,
            'transfer' => $transfer,
            'sent' => $sent,
            'consignment' => $consignment,
            'consignmentIn' => $consignmentIn,
            'movement' => $movement,
            'movementIn' => $movementIn,
            'count' => $count,
        ));
    }

    protected function saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Balance Sheet Standar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Balance Sheet Standar');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Laporan Balance Sheet Standar');
        $worksheet->setCellValue('A2', $startDateString . ' - ' . $endDateString);

        $counter = 5;

        $accountCategoryAssets = CoaCategory::model()->findAll(array('condition' => 't.id IN (12)'));
        $accountCategoryAssetBalance = 0.00;
        foreach ($accountCategoryAssets as $accountCategoryAsset) {
            $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryAsset, 'name')));

            $counter++;

            $accountCategoryPrimarys = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryAsset->id), array('order' => 'code'));
            foreach ($accountCategoryPrimarys as $accountCategoryPrimary) {
                $accountCategoryPrimaryBalance = 0.00;
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')));
                
                $counter++;

                $accountCategorySubs = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code'));
                foreach ($accountCategorySubs as $accountCategorySub) {
                    $accountCategorySubBalance = 0.00;
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategorySub, 'name')));
                    
                    $counter++;

                    $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code'));
                    foreach ($coaSubCategoryCodes as $accountCategory) {
                        $accountCategoryBalance = 0.00;
                        $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1, 'coa_id' => null));
                        foreach ($coas as $coa) {
                            $accountGroupBalance = $coa->getBalanceSheetBalance($startDate, $endDate, $branchId);
                            $coaSubs = Coa::model()->findAllByAttributes(array('is_approved' => 1, 'coa_id' => $coa->id));
                            if ((int) $accountGroupBalance !== 0) {
                                if (!empty($coaSubs)) {
                                    $accountGroupBalance = 0;
                                    foreach ($coaSubs as $account) {
                                        $accountBalance = $account->getBalanceSheetBalance($startDate, $endDate, $branchId);
                                        $accountGroupBalance += $accountBalance;
                                    }
                                }
                            }
                            $accountCategoryBalance += $accountGroupBalance;
                        }
                        
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')) . ' - ' . CHtml::encode(CHtml::value($accountCategory, 'name')));
                        $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryBalance));
                        $counter++;
                        
                        $accountCategorySubBalance += $accountCategoryBalance;
                    }
                    
                    $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                    $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategorySub, 'name')));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategorySubBalance));

                    $accountCategoryPrimaryBalance += $accountCategorySubBalance;
                    $counter++;
                }
                
                $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryPrimaryBalance));

                $accountCategoryAssetBalance += $accountCategoryPrimaryBalance;
                $counter++;
            }

            $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryAsset, 'name')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryAssetBalance));

            $counter++;
        }

        for ($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Balance Sheet Standar.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}