<?php

class ProfitLossDetailController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('standardProfitLossReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $accountCategoryTypes = CoaCategory::model()->findAll(array('condition' => 't.id BETWEEN 6 AND 10'));

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'accountCategoryTypes' => $accountCategoryTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $jurnalUmum = new JurnalUmum('search');
        $jurnalUmum->unsetAttributes();
        
        if (isset($_GET['JurnalUmum'])) {
            $jurnalUmum->attributes = $_GET['JurnalUmum'];
        }

        $jurnalUmumDataProvider = $jurnalUmum->searchByTransactionJournal();
        $jurnalUmumDataProvider->criteria->addCondition("t.coa_id = :coa_id AND t.tanggal_transaksi BETWEEN :start_date AND :end_date");
        $jurnalUmumDataProvider->criteria->params = array(
            ':coa_id' => $coaId, 
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $jurnalUmumDataProvider->criteria->compare('t.branch_id', $branchId);            
        }
        
        $coa = Coa::model()->findByPk($coaId);
        
        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($jurnalUmumDataProvider, $coa, $startDate, $endDate);
        }

        $this->render('jurnalTransaction', array(
            'jurnalUmumDataProvider' => $jurnalUmumDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaId' => $coaId,
            'branchId' => $branchId,
            'coa' => $coa,
        ));
    }

    protected function saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Profit Loss Standar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Profit Loss Standar');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Laporan Profit Loss Standar');
        $worksheet->setCellValue('A2', CHtml::encode(($branch === null) ? '' : $branch->name));
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);

        $counter = 5;

        $profitLossAmount = 0.00;
        foreach ($accountCategoryTypes as $accountCategoryType) {
            $accountCategoryTypeBalance = 0.00;
            $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryType, 'code')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategoryType, 'name')));

            $counter++;

            $coaSubCategories = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryType->id), array('order' => 'code ASC'));
            foreach ($coaSubCategories as $accountCategory) {
                $accountCategoryBalance = 0.00;
                $worksheet->getStyle("A{$counter}:B{$counter}")->getFont()->setBold(true);
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));

                $counter++;

                $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1, 'coa_id' => null), array('order' => 'code ASC'));
                foreach ($coas as $coa) {
                    $coaBalance = (empty($coa->coaIds)) ? $coa->getProfitLossBalance($startDate, $endDate, $branchId) : 0;
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($coa, 'code')));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($coa, 'name')));
                    $worksheet->setCellValue("C{$counter}", ($coaBalance == 0) ? 0 : CHtml::encode($coaBalance));
                    $counter++;
                    
                    $accountGroupBalance = 0.00;
                    if (!empty($coa->coaIds)) {
                        foreach ($coa->coaIds as $account) {
                            $accountBalance = $account->getProfitLossBalance($startDate, $endDate, $branchId);
                            if ((int) $accountBalance !== 0) {
                                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($account, 'code')));
                                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($account, 'name')));
                                $worksheet->setCellValue("C{$counter}", CHtml::encode($accountBalance));
                                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $counter++;
                                $accountGroupBalance += $accountBalance;
                            }
                        }
                        $worksheet->setCellValue("B{$counter}", 'Total ' . CHtml::encode(CHtml::value($coa, 'name')));
                        $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $worksheet->setCellValue("C{$counter}", CHtml::encode($accountGroupBalance));
                        $counter++; $counter++;
                    }
                    $accountCategoryBalance += (empty($coa->coaIds)) ? $coaBalance : $accountGroupBalance;
                }
                $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategory, 'name')));
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryBalance));
                $counter++;$counter++;
                
                if ((int)$accountCategory->id === 28 || (int)$accountCategory->id === 30 || (int)$accountCategory->id === 31){
                     $accountCategoryTypeBalance -= $accountCategoryBalance;
                } else {
                     $accountCategoryTypeBalance += $accountCategoryBalance;
                }
            }

            $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryType, 'name')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryTypeBalance));

            $counter++;
            $counter++;
            
            if ($accountCategoryType->id == 7 || $accountCategoryType->id == 8 || $accountCategoryType->id == 10) {
                $profitLossAmount -= $accountCategoryTypeBalance;
            } else {
                $profitLossAmount += $accountCategoryTypeBalance;
            }
        }

        $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("A{$counter}", 'PROFIT / LOSS ');
        $worksheet->setCellValue("C{$counter}", CHtml::encode($profitLossAmount));

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Profit Loss Standar.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelTransactionJournal($jurnalUmumDataProvider, $coa, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Profit Loss Journal Transaction');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Profit Loss Journal Transaction');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');
        $worksheet->getStyle('A1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Profit Loss Journal Transaction');
        $worksheet->setCellValue('A2', CHtml::encode(CHtml::value($coa, 'codeName')));
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);

        $counter = 5;

        foreach ($jurnalUmumDataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'kode_transaksi')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'tanggal_transaksi')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'transaction_subject')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'transaction_type')));
            $worksheet->setCellValue("E{$counter}", $header->debet_kredit == "D" ? CHtml::encode(CHtml::value($header, 'total')) : 0);
            $worksheet->setCellValue("F{$counter}", $header->debet_kredit == "K" ? CHtml::encode(CHtml::value($header, 'total')) : 0);

            $counter++;
        }

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Profit Loss Journal Transaction.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
