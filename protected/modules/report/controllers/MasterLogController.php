<?php

class MasterLogController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $masterLog = Search::bind(new MasterLog('search'), isset($_GET['MasterLog']) ? $_GET['MasterLog'] : array());
        $masterLogDataProvider = $masterLog->search();
        $masterLogDataProvider->criteria->addCondition("log_date BETWEEN :start_date AND :end_date");
        $masterLogDataProvider->criteria->params[':start_date'] = $startDate;
        $masterLogDataProvider->criteria->params[':end_date'] = $endDate;
        $masterLogDataProvider->pagination->pageSize = 500;
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($masterLogDataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'masterLog' => $masterLog,
            'masterLogDataProvider' => $masterLogDataProvider,
        ));
    }

    public function actionSummaryPayload($id) {
        $masterLog = MasterLog::model()->findByPk($id);
        $newData = json_decode($masterLog->new_data, true);
        
        $tableName = trim($masterLog->table_name, '{}');
        $modelName = str_replace('_', '', ucwords($tableName, '_'));
        
        $className = $modelName . 'LogData';
        $fileName = Yii::app()->basePath . '/components/logData/master/' . $className . '.php';
        if (file_exists($fileName)) {
            $payload = $className::make($newData);
        } else {
            $payload = $newData;
        }
        
        $this->renderPartial('_summaryPayload', array(
            'payload' => $payload,
        ));
    }
    
    protected function saveToExcel($masterLogDataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $startDate = $options['startDate'];
        $endDate = $options['endDate'];
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Master Log');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Master Log');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');

        $worksheet->getStyle('A1:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Master Log');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:F5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Name');
        $worksheet->setCellValue('B5', 'Log Date');
        $worksheet->setCellValue('C5', 'Log Time');
        $worksheet->setCellValue('D5', 'Username');
        $worksheet->setCellValue('E5', 'Controller');
        $worksheet->setCellValue('F5', 'Action Name');

        $worksheet->getStyle('A5:F5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($masterLogDataProvider->data as $masterLogRow) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($masterLogRow, 'name'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($masterLogRow, 'log_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($masterLogRow, 'log_time'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($masterLogRow, 'username'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($masterLogRow, 'controller_class'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($masterLogRow, 'action_name'));

            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="master_log.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
