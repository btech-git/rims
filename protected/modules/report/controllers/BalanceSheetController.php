<?php

class BalanceSheetController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('summaryBalanceSheetReport')))
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

        $accountCategoryAssets = CoaCategory::model()->findAll(array('condition' => 't.id IN (12)'));
        $accountCategoryLiabilitiesEquities = CoaCategory::model()->findAll(array('condition' => 't.id IN (13)'));
        $accountProfitLossPrevious = Coa::model()->findByPk(1475);
        $accountProfitLoss = Coa::model()->findByPk(1476);
        $accountCategoryTypes = CoaCategory::model()->findAll(array('condition' => 't.id BETWEEN 6 AND 10'));

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($accountCategoryAssets, $accountCategoryLiabilitiesEquities, $startDate, $endDate, $branchId);
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

    protected function saveToExcel($accountCategoryAssets, $accountCategoryLiabilitiesEquities, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        ob_start();

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Balance Sheet Induk');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Balance Sheet Induk');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Laporan Balance Sheet Induk');
        $worksheet->setCellValue('A2', $startDateString . ' - ' . $endDateString);

        $counter = 5;

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
//                            if ((int) $accountGroupBalance !== 0) {
                                if (!empty($coaSubs)) {
                                    $accountGroupBalance = 0;
                                    foreach ($coaSubs as $account) {
                                        $accountBalance = $account->getBalanceSheetBalance($startDate, $endDate, $branchId);
                                        $accountGroupBalance += $accountBalance;
                                    }
                                }
//                            }
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
                        $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved'));
                        foreach ($coas as $account) {
                            $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId);
                            $accountCategoryBalance += $accountBalance;
                        }
                        
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')));
                        $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
                        $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryBalance));
                        $accountCategoryPrimaryBalance += $accountCategoryBalance;
                        
                        $counter++;

                    }
                } else {
                    $accountCategorySubs = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryPrimary->id), array('order' => 'code'));
                    foreach ($accountCategorySubs as $accountCategorySub) {
                        $accountCategorySubBalance = 0.00;
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
                        
                        $counter++;
                        
                        if ($accountCategorySub->id == 3) {
                            $coaCategorySecondaries = CoaCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code'));
                            foreach ($coaCategorySecondaries as $coaCategorySecondary) {
                                $accountCategorySecondaryBalance = 0.00;
                                $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $coaCategorySecondary->id), array('order' => 'code'));
                                foreach ($coaSubCategoryCodes as $accountCategory) {
                                    $accountCategoryBalance = 0.00;
                                    $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved'));
                                    foreach ($coas as $account) {
                                        $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId); 
                                        $accountCategoryBalance += $accountBalance;
                                    }
                                    
                                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')));
                                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
                                    $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryBalance));
                        
                                    $counter++;
                                    
                                    $accountCategorySecondaryBalance += $accountCategoryBalance; 
                                }
                                
                                $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($coaCategorySecondary, 'name')));
                                $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategorySecondaryBalance));

                                $counter++;

                                $accountCategorySubBalance += $accountCategorySecondaryBalance;
                            }
                        } else {
                            $coaSubCategoryCodes = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategorySub->id), array('order' => 'code'));
                            foreach ($coaSubCategoryCodes as $accountCategory) {
                                $accountCategoryBalance = 0.00; 
                                $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'status' => 'Approved'));
                                foreach ($coas as $account) {
                                    $accountBalance = $account->getBalanceTotal($startDate, $endDate, $branchId);
                                    $accountCategoryBalance += $accountBalance;
                                }
                                
                                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')));
                                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
                                $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryBalance));

                                $counter++;

                                $accountCategorySubBalance += $accountCategoryBalance;
                            }
                        }

                        $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategorySub, 'name')));
                        $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategorySubBalance));

                        $counter++;
                        
                        $accountCategoryPrimaryBalance += $accountCategorySubBalance;

                    }
                }

                $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryPrimary, 'name')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryPrimaryBalance));

                $counter++;

                $accountCategoryLiabilityEquityBalance += $accountCategoryPrimaryBalance;
            }
                
            $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryLiabilitiesEquity, 'name')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryLiabilityEquityBalance));

            $counter++;
        }

        for ($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Balance Sheet Induk.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}