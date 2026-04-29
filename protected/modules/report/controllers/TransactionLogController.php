<?php

class TransactionLogController extends Controller {

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

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $startLogDate = (isset($_GET['StartLogDate'])) ? $_GET['StartLogDate'] : '';
        $endLogDate = (isset($_GET['EndLogDate'])) ? $_GET['EndLogDate'] : '';
        
        $transactionLog = Search::bind(new TransactionLog('search'), isset($_GET['TransactionLog']) ? $_GET['TransactionLog'] : array());
        $transactionLogDataProvider = $transactionLog->search();
        
        if (!empty($startDate && $endDate)) {
            $transactionLogDataProvider->criteria->addCondition("transaction_date BETWEEN :start_date AND :end_date");
            $transactionLogDataProvider->criteria->params[':start_date'] = $startDate;
            $transactionLogDataProvider->criteria->params[':end_date'] = $endDate;
        }
        
        if (!empty($startLogDate && $endLogDate)) {
            $transactionLogDataProvider->criteria->addCondition("log_date BETWEEN :start_log_date AND :end_log_date");
            $transactionLogDataProvider->criteria->params[':start_log_date'] = $startLogDate;
            $transactionLogDataProvider->criteria->params[':end_log_date'] = $endLogDate;
        }
        $transactionLogDataProvider->pagination->pageSize = 500;
        $transactionLogDataProvider->criteria->order = 't.transaction_date ASC, t.log_time ASC';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionLogDataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'startLogDate' => $startLogDate,
            'endLogDate' => $endLogDate,
            'transactionLog' => $transactionLog,
            'transactionLogDataProvider' => $transactionLogDataProvider,
        ));
    }

    public function actionSummaryPayload($id) {
        $transactionLog = TransactionLog::model()->findByPk($id);
        $newData = json_decode($transactionLog->new_data, true);
        
        $tableName = trim($transactionLog->table_name, '{}');
        $modelName = str_replace('_', '', ucwords($tableName, '_'));
        
        $className = $modelName . 'LogData';
        $fileName = Yii::app()->basePath . '/components/logData/transaction/' . $className . '.php';
        if (file_exists($fileName)) {
            $payload = $className::make($newData);
        } else {
            $payload = $newData;
        }
        
        $this->renderPartial('_summaryPayload', array(
            'payload' => $payload,
        ));
    }
    
    protected function saveToExcel($transactionLogDataProvider, array $options = array()) {
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
        $documentProperties->setTitle('Transaction Log');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaction Log');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Transaction Log');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Transaction #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Log Date');
        $worksheet->setCellValue('D5', 'Log Time');
        $worksheet->setCellValue('E5', 'Username');
        $worksheet->setCellValue('F5', 'Transaction Type');
        $worksheet->setCellValue('G5', 'Action Type');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($transactionLogDataProvider->data as $transactionLogRow) {
            list(, $controllerClass) = explode('/', CHtml::value($transactionLogRow, 'controller_class')); 
            $worksheet->setCellValue("A{$counter}", CHtml::value($transactionLogRow, 'transaction_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($transactionLogRow, 'transaction_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($transactionLogRow, 'log_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($transactionLogRow, 'log_time'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($transactionLogRow, 'username'));
            $worksheet->setCellValue("F{$counter}", ucfirst($controllerClass));
            $worksheet->setCellValue("G{$counter}", CHtml::value($transactionLogRow, 'action_type'));

            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaction_log.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
