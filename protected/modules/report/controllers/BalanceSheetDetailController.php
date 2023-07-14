<?php

class BalanceSheetDetailController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('standardBalanceSheetReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $dateNow = date('Y-m-d');
//        list($yearNow, , ) = explode('-', $dateNow);
//        $dateStart = $yearNow . '-01-01';
//        $dateStart = '2022-01-01';

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : $dateNow;
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : $dateNow;

        $accountCategoryAssets = CoaCategory::model()->findAll(array('condition' => 't.id = 12'));
        $accountCategoryLiabilitiesEquities = CoaCategory::model()->findAll(array('condition' => 't.id = 13'));
        $accountProfitLossPrevious = Coa::model()->findByPk(1475);
        $accountProfitLoss = Coa::model()->findByPk(1476);
        $accountCategoryTypes = CoaCategory::model()->findAll(array('condition' => 't.id BETWEEN 6 AND 10'));

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'accountCategoryAssets' => $accountCategoryAssets,
            'accountCategoryLiabilitiesEquities' => $accountCategoryLiabilitiesEquities,
            'accountProfitLoss' => $accountProfitLoss,
            'accountProfitLossPrevious' => $accountProfitLossPrevious,
            'accountCategoryTypes' => $accountCategoryTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $coa = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());

        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $balanceSheetSummary = new BalanceSheetSummary($coa->searchByTransactionJournal());
        $balanceSheetSummary->setupLoading();
        $balanceSheetSummary->setupPaging(1000, 1);
        $balanceSheetSummary->setupSorting();
        $balanceSheetSummary->setupFilter($startDate, $endDate, $coaId, $branchId);

        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($balanceSheetSummary, $coaId, $startDate, $endDate, $branchId);
        }

        $this->render('jurnalTransaction', array(
            'coa' => $coa,
            'balanceSheetSummary' => $balanceSheetSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaId' => $coaId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($startDate, $endDate, $branchId) {
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

        $accountCategoryAssets = CoaCategory::model()->findAll(array('condition' => 't.id IN (12)'), array('order' => 'code'));
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
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')) . ' - ' . CHtml::encode(CHtml::value($accountCategory, 'name')));

                        $counter++;

                        $coas = Coa::model()->findAllByAttributes(array(
                            'coa_sub_category_id' => $accountCategory->id, 
                            'is_approved' => 1, 
                            'coa_id' => null
                        ), array('order' => 'code'));
                        foreach ($coas as $coa) {
                            $accountGroupBalance = (empty($coa->coaIds)) ? $coa->getBalanceSheetBalance($startDate, $endDate, $branchId) : 10;
                            if ((int) $accountGroupBalance !== 0) {
                                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($coa, 'code')) . ' - ' . CHtml::encode(CHtml::value($coa, 'name')));
                                $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                if (empty($coa->coaIds)) {
                                    $worksheet->setCellValue("B{$counter}", CHtml::encode($accountGroupBalance));
                                }

                                $counter++;

                                $coaSubs = Coa::model()->findAllByAttributes(array('is_approved' => 1, 'coa_id' => $coa->id));
                                if (!empty($coaSubs)) {
                                    $accountGroupBalance = 0;
                                    foreach ($coaSubs as $account) {
                                        $accountBalance = $account->getBalanceSheetBalance($startDate, $endDate, $branchId);
                                        if ((int)$accountBalance !== 0) {
                                            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($account, 'code')) . ' - ' . CHtml::encode(CHtml::value($account, 'name')));
                                            $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                            $worksheet->setCellValue("B{$counter}", CHtml::encode($accountBalance));
                                            $accountGroupBalance += $accountBalance;

                                            $counter++;

                                        }
                                    }
                                    
                                $worksheet->getStyle("B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($coa, 'name')));
                                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountGroupBalance));

                                $counter++;
                                }
                                $accountCategoryBalance += $accountGroupBalance;
                            }
                        }
                        
                        $worksheet->getStyle("B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $worksheet->setCellValue("A{$counter}", 'Total ' . CHtml::encode(CHtml::value($accountCategory, 'name')));
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
        
        $accountCategoryLiabilitiesEquities = CoaCategory::model()->findAll(array('condition' => 't.id IN (13)'), array('order' => 'code'));
        $accountCategoryLiabilityEquityBalance = 0.00;
        foreach ($accountCategoryLiabilitiesEquities as $accountCategoryLiabilitiesEquity) {
            $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryLiabilitiesEquity, 'name')));

            $counter++;

            $accountCategoryPrimarys = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryLiabilitiesEquity->id), array('order' => 'code'));
            foreach ($accountCategoryPrimarys as $accountCategoryPrimary) {
                $accountCategoryPrimaryBalance = 0.00;
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')));
                
                $counter++;

                if ($accountCategoryPrimary->id == 5) {
                    $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code'));
                    foreach ($coaSubCategoryCodes as $accountCategory) {
                        $accountCategoryBalance = 0.00;
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')) . ' - ' . CHtml::encode(CHtml::value($accountCategory, 'name')));

                        $counter++;

                        $coas = Coa::model()->findAllByAttributes(array(
                            'coa_sub_category_id' => $accountCategory->id, 
                            'is_approved' => 1, 
                            'coa_id' => null
                        ), array('order' => 'code'));
                        foreach ($coas as $account) {
                            $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId);
                            if ((int) $accountBalance !== 0) {
                                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($account, 'code')) . ' - ' . CHtml::encode(CHtml::value($account, 'name')));
                                $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountBalance));

                                $counter++;

                            }
                            
                            $accountCategoryBalance += $accountBalance;
                        }
                        
                        $worksheet->getStyle("B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $worksheet->setCellValue("A{$counter}", 'Total ' . CHtml::encode(CHtml::value($accountCategory, 'name')));
                        $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryBalance));
                        $counter++;

                        $accountCategoryPrimaryBalance += $accountCategoryBalance;
                    }

                } else {
                    $accountCategorySubs = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code'));
                    foreach ($accountCategorySubs as $accountCategorySub) {
                        $accountCategorySubBalance = 0.00;
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategorySub, 'name')));

                        $counter++;

                        if ($accountCategorySub->id == 3) {
                            $coaCategorySecondaries = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code'));
                            foreach ($coaCategorySecondaries as $coaCategorySecondary) {
                                $accountCategorySecondaryBalance = 0.00;
                                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($coaCategorySecondary, 'code')) . ' - ' . CHtml::encode(CHtml::value($coaCategorySecondary, 'name')));

                                $counter++;

                                $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $coaCategorySecondary->id), array('order' => 'code'));

                                foreach ($coaSubCategoryCodes as $accountCategory) {
                                    $accountCategoryBalance = 0.00;
                                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')) . ' - ' . CHtml::encode(CHtml::value($accountCategory, 'name')));
                                    $counter++;

                                    $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1));
                                    foreach ($coas as $account) {
                                        $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId);
                                        if ((int)$accountBalance !== 0) {
                                            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($account, 'code')) . ' - ' . CHtml::encode(CHtml::value($account, 'name')));
                                            $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                            $worksheet->setCellValue("B{$counter}", CHtml::encode($accountBalance));

                                            $counter++;
                                        }
                                        $accountCategoryBalance += $accountBalance;
                                    }

                                    $worksheet->getStyle("B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                    $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                    $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategory, 'name')));
                                    $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryBalance));

                                    $counter++;
                                    $accountCategorySecondaryBalance += $accountCategoryBalance;
                                }

                                $worksheet->getStyle("B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $worksheet->setCellValue("A{$counter}", 'Total ' . CHtml::encode(CHtml::value($coaCategorySecondary, 'name')));
                                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategorySecondaryBalance));
                                $counter++;

                                $accountCategorySubBalance += $accountCategorySecondaryBalance;
                            }
                        } else {
                            $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code'));
                            foreach ($coaSubCategoryCodes as $accountCategory) {
                                $accountCategoryBalance = 0.00;
                                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')) . ' - ' . CHtml::encode(CHtml::value($accountCategory, 'name')));

                                $counter++;

                                $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1));
                                foreach ($coas as $account) {
                                    $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId);
                                    //if ((int)$accountBalance !== 0) {
                                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($account, 'code')) . ' - ' . CHtml::encode(CHtml::value($account, 'name')));
                                        $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                        $worksheet->setCellValue("B{$counter}", CHtml::encode($accountBalance));

                                        $counter++;
                                    //}
                                    $accountCategoryBalance += $accountBalance;
                                }

                                $worksheet->getStyle("B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategory, 'name')));
                                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryBalance));
                                $counter++;

                                $accountCategorySubBalance += $accountCategoryBalance;
                            }
                        }

                        $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                        $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategorySub, 'name')));
                        $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategorySubBalance));

                        $accountCategoryPrimaryBalance += $accountCategorySubBalance;
                        $counter++;
                    }
                }
                
                $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryPrimaryBalance));

                $accountCategoryLiabilityEquityBalance += $accountCategoryPrimaryBalance;
                $counter++;
            }

            $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryLiabilitiesEquity, 'name')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryLiabilityEquityBalance));

            $counter++;
        }

        for ($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Balance Sheet Standar.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelTransactionJournal($balanceSheetSummary, $coaId, $startDate, $endDate) {
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
        $documentProperties->setTitle('Balance Sheet Journal');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Balance Sheet Journal');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');
        $worksheet->getStyle('A1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F5')->getFont()->setBold(true);

        $coa = Coa::model()->findByPk($coaId);
        $worksheet->setCellValue('A1', 'Balance Sheet Journal');
        $worksheet->setCellValue('A2', CHtml::encode(CHtml::value($coa, 'codeName')));
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);
        
        $worksheet->setCellValue('A5', 'Transaksi #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Description');
        $worksheet->setCellValue('D5', 'Memo');
        $worksheet->setCellValue('E5', 'Debet');
        $worksheet->setCellValue('F5', 'Kredit');
        $counter = 7;

        foreach ($balanceSheetSummary->dataProvider->data as $header) {
            foreach ($header->jurnalUmums as $i=>$detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($detail, 'kode_transaksi')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($detail, 'tanggal_transaksi')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($detail, 'transaction_subject')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($detail, 'transaction_type')));
                $worksheet->setCellValue("E{$counter}", $detail->debet_kredit == "D" ? CHtml::encode(CHtml::value($detail, 'total')) : 0);
                $worksheet->setCellValue("F{$counter}", $detail->debet_kredit == "K" ? CHtml::encode(CHtml::value($detail, 'total')) : 0);

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Balance Sheet Journal.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
