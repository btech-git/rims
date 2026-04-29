<?php

class FixedAssetController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('fixedAssetReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $assetCategories = AssetCategory::model()->findAll();
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($assetCategories, $startDate, $endDate);
        }

        $this->render('summary', array(
            'assetCategories' => $assetCategories,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    protected function saveToExcel($assetCategories, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Aset Tetap');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Aset Tetap');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        $worksheet->getStyle('A1:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Aset Tetap');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:I5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:I5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:H5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Kode Aktiva');
        $worksheet->setCellValue('B5', 'Nama Aktiva');
        $worksheet->setCellValue('C5', 'Tanggal Pembelian');
        $worksheet->setCellValue('D5', 'Harga Perolehan');
        $worksheet->setCellValue('E5', 'Penyesuaian Tahun Ini');
        $worksheet->setCellValue('F5', 'Akumulasi Depresiasi');
        $worksheet->setCellValue('G5', 'Book Value');
        $worksheet->setCellValue('H5', 'Depresiasi Tahun Ini');

        $counter = 7;

        foreach ($assetCategories as $assetCategory) {
            $worksheet->setCellValue("A{$counter}", $assetCategory->description);
            
            $counter++;
            
            $totalPurchaseValue = 0.00;
            $totalAccumulatedValue = 0.00;
            $totalCurrentValue = 0.00;
            $totalAdjustedValue = 0.00;
            $totalYearlyValue = 0.00;

            $assetPurchases = AssetPurchase::model()->findAll(array(
                'condition' => 'asset_category_id = :asset_category_id AND transaction_date BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':asset_category_id' => $assetCategory->id,
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                )
            ));
            
            foreach ($assetPurchases as $detail) {
                $purchaseValue = CHtml::value($detail, 'purchase_value');
                $accumulatedValue = CHtml::value($detail, 'accumulated_depreciation_value');
                $currentValue = CHtml::value($detail, 'current_value');
                $adjustedValue = CHtml::value($detail, 'monthlyDepreciationAmount');
                $yearlyValue = 0.00;

                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($detail, 'assetCategory.code')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($detail, 'description')));
                $worksheet->setCellValue("C{$counter}", $detail->transaction_date);
                $worksheet->setCellValue("D{$counter}", CHtml::encode($purchaseValue));
                $worksheet->setCellValue("E{$counter}", 0);
                $worksheet->setCellValue("F{$counter}", $accumulatedValue);
                $worksheet->setCellValue("G{$counter}", $currentValue);
                $worksheet->setCellValue("H{$counter}", $adjustedValue);
                
                $totalPurchaseValue += $purchaseValue;
                $totalAccumulatedValue += $accumulatedValue;
                $totalCurrentValue += $currentValue;
                $totalAdjustedValue += $adjustedValue;
                $totalYearlyValue += 0.00;

                $counter++;
            }
            
            $worksheet->getStyle("B{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $worksheet->setCellValue("C{$counter}", 'TOTAL');
            $worksheet->setCellValue("D{$counter}", CHtml::encode($totalPurchaseValue));
            $worksheet->setCellValue("E{$counter}", CHtml::encode($totalYearlyValue));
            $worksheet->setCellValue("F{$counter}", CHtml::encode($totalAccumulatedValue));
            $worksheet->setCellValue("G{$counter}", CHtml::encode($totalCurrentValue));
            $worksheet->setCellValue("H{$counter}", CHtml::encode($totalAdjustedValue));
            
            $counter++;$counter++;
            
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Aset Tetap.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}