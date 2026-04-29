<?php

class WorkOrderController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('workOrderView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'adminOutstanding') {
            if (!(Yii::app()->user->checkAccess('outstandingWorkOrderView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('workOrderView') || Yii::app()->user->checkAccess('outstandingWorkOrderView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $details = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $model->registration_transaction_id));
        $this->render('view', array(
            'model' => $model,
            'details' => $details,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new WorkOrder;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['WorkOrder'])) {
            $model->attributes = $_POST['WorkOrder'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['WorkOrder'])) {
            $model->attributes = $_POST['WorkOrder'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('WorkOrder');
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));
        $detailTabs = array();
        $limit = 5000;

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMakeId = (isset($_GET['CarMakeId'])) ? $_GET['CarMakeId'] : '';
        $carModelId = (isset($_GET['CarModelId'])) ? $_GET['CarModelId'] : '';
        $workOrderNumber = (isset($_GET['WorkOrderNumber'])) ? $_GET['WorkOrderNumber'] : '';
        $transactionStatus = (isset($_GET['TransactionStatus'])) ? $_GET['TransactionStatus'] : '';
        $repairType = (isset($_GET['RepairType'])) ? $_GET['RepairType'] : '';

        foreach ($branches as $branch) {
            $activeWorkOrderData = RegistrationTransaction::getActiveWorkOrderData($branch->id, $limit, $startDate, $endDate, $plateNumber, $carMakeId, $carModelId, $workOrderNumber, $transactionStatus, $repairType);
            $tabContent = $this->renderPartial('_viewWorkOrder', array(
                'activeWorkOrderData' => $activeWorkOrderData,
            ), true);
            $detailTabs[$branch->name] = array('content' => $tabContent);
        }
        
        $activeAllBranchWorkOrderData = RegistrationTransaction::getActiveAllBranchWorkOrderData($limit, $startDate, $endDate, $plateNumber, $carMakeId, $carModelId, $workOrderNumber, $transactionStatus, $repairType);
        $detailTabs['All'] = array('content' => $this->renderPartial('_viewAllBranchWorkOrder', array(
            'activeAllBranchWorkOrderData' => $activeAllBranchWorkOrderData,
        ), true));
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($activeAllBranchWorkOrderData, $startDate, $endDate);
        }

        $this->render('admin', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'plateNumber' => $plateNumber,
            'carMakeId' => $carMakeId,
            'carModelId' => $carModelId,
            'workOrderNumber' => $workOrderNumber,
            'transactionStatus' => $transactionStatus,
            'repairType' => $repairType,
            'detailTabs' => $detailTabs,
        ));
    }

    protected function saveToExcel($activeAllBranchWorkOrderData, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Work Order');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Work Order');

        $worksheet->mergeCells('A1:R1');
        $worksheet->mergeCells('A2:R2');
        $worksheet->mergeCells('A3:R3');

        $worksheet->getStyle('A1:R5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:R5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Work Order');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:R5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Vehicle ID');
        $worksheet->setCellValue('B5', 'Plate #');
        $worksheet->setCellValue('C5', 'Kendaraan');
        $worksheet->setCellValue('D5', 'Warna');
        $worksheet->setCellValue('E5', 'RG #');
        $worksheet->setCellValue('F5', 'Tanggal RG');
        $worksheet->setCellValue('G5', 'Customer');
        $worksheet->setCellValue('H5', 'SPK Customer #');
        $worksheet->setCellValue('I5', 'SL #');
        $worksheet->setCellValue('J5', 'WO #');
        $worksheet->setCellValue('K5', 'Tanggal WO');
        $worksheet->setCellValue('L5', 'Movement Out #');
        $worksheet->setCellValue('M5', 'Invoice #');
        $worksheet->setCellValue('N5', 'Services');
        $worksheet->setCellValue('O5', 'Repair Type');
        $worksheet->setCellValue('P5', 'Problem');
        $worksheet->setCellValue('Q5', 'User');
        $worksheet->setCellValue('R5', 'WO Status');

        $worksheet->getStyle('A5:R5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach (array_reverse($activeAllBranchWorkOrderData) as $activeWorkOrderItem) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($activeWorkOrderItem['id']);
            $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $activeWorkOrderItem['id']));

            $worksheet->setCellValue("A{$counter}", $activeWorkOrderItem['vehicle_id']);
            $worksheet->setCellValue("B{$counter}", $activeWorkOrderItem['plate_number']);
            $worksheet->setCellValue("C{$counter}", $activeWorkOrderItem['car_make'] . ' - ' . $activeWorkOrderItem['car_model'] . ' - ' . $activeWorkOrderItem['car_sub_model']);
            $worksheet->setCellValue("D{$counter}", $activeWorkOrderItem['color']);
            $worksheet->setCellValue("E{$counter}", $activeWorkOrderItem['transaction_number']);
            $worksheet->setCellValue("F{$counter}", $activeWorkOrderItem['transaction_date']);
            $worksheet->setCellValue("G{$counter}", $activeWorkOrderItem['customer_name']);
            $worksheet->setCellValue("H{$counter}", $activeWorkOrderItem['customer_work_order_number']);
            $worksheet->setCellValue("I{$counter}", $activeWorkOrderItem['sales_order_number']);
            $worksheet->setCellValue("J{$counter}", $activeWorkOrderItem['work_order_number']);
            $worksheet->setCellValue("K{$counter}", $activeWorkOrderItem['work_order_date']);
            $worksheet->setCellValue("L{$counter}", $registrationTransaction->getMovementOuts());
            $worksheet->setCellValue("M{$counter}", CHtml::value($invoiceHeader, 'invoice_number'));
            $worksheet->setCellValue("N{$counter}", $registrationTransaction->getServices());
            $worksheet->setCellValue("O{$counter}", $activeWorkOrderItem['repair_type']);
            $worksheet->setCellValue("P{$counter}", $activeWorkOrderItem['problem']);
            $worksheet->setCellValue("Q{$counter}", $activeWorkOrderItem['username']);
            $worksheet->setCellValue("R{$counter}", $activeWorkOrderItem['status']);

            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="work_order.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

    public function actionAdminOutstanding() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));
        $detailTabs = array();
        $limit = 5000;

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMakeId = (isset($_GET['CarMakeId'])) ? $_GET['CarMakeId'] : '';
        $carModelId = (isset($_GET['CarModelId'])) ? $_GET['CarModelId'] : '';
        $workOrderNumber = (isset($_GET['WorkOrderNumber'])) ? $_GET['WorkOrderNumber'] : '';
        $transactionStatus = (isset($_GET['TransactionStatus'])) ? $_GET['TransactionStatus'] : '';
        $repairType = (isset($_GET['RepairType'])) ? $_GET['RepairType'] : '';

        foreach ($branches as $branch) {
            $outstandingWorkOrderData = RegistrationTransaction::getOutstandingWorkOrderData($branch->id, $limit, $startDate, $endDate, $plateNumber, $carMakeId, $carModelId, $workOrderNumber, $transactionStatus, $repairType);
            $tabContent = $this->renderPartial('_adminOutstanding', array(
                'outstandingWorkOrderData' => $outstandingWorkOrderData,
            ), true);
            $detailTabs[$branch->name] = array('content' => $tabContent);
        }
        
        $outstandingAllBranchWorkOrderData = RegistrationTransaction::getOutstandingAllBranchWorkOrderData($limit, $startDate, $endDate, $plateNumber, $carMakeId, $carModelId, $workOrderNumber, $transactionStatus, $repairType);
        $detailTabs['All'] = array('content' => $this->renderPartial('_adminAllBranchOutstanding', array(
            'outstandingAllBranchWorkOrderData' => $outstandingAllBranchWorkOrderData,
        ), true));
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcelOutstanding'])) {
            $this->saveToExcelOutstanding($outstandingAllBranchWorkOrderData, $startDate, $endDate);
        }

        $this->render('adminOutstanding', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'plateNumber' => $plateNumber,
            'carMakeId' => $carMakeId,
            'carModelId' => $carModelId,
            'workOrderNumber' => $workOrderNumber,
            'transactionStatus' => $transactionStatus,
            'repairType' => $repairType,
            'detailTabs' => $detailTabs,
        ));
    }
    
    protected function saveToExcelOutstanding($outstandingAllBranchWorkOrderData, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('WO Outstanding');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('WO Outstanding');

        $worksheet->mergeCells('A1:R1');
        $worksheet->mergeCells('A2:R2');
        $worksheet->mergeCells('A3:R3');

        $worksheet->getStyle('A1:R5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:R5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Outstanding Work Order (Pending Invoices)');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:R5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Vehicle ID');
        $worksheet->setCellValue('B5', 'Plate #');
        $worksheet->setCellValue('C5', 'Kendaraan');
        $worksheet->setCellValue('D5', 'Warna');
        $worksheet->setCellValue('E5', 'RG #');
        $worksheet->setCellValue('F5', 'Tanggal RG');
        $worksheet->setCellValue('G5', 'Customer');
        $worksheet->setCellValue('H5', 'SPK Customer #');
        $worksheet->setCellValue('I5', 'SL #');
        $worksheet->setCellValue('J5', 'WO #');
        $worksheet->setCellValue('K5', 'Tanggal WO');
        $worksheet->setCellValue('L5', 'Movement Out #');
        $worksheet->setCellValue('M5', 'Invoice #');
        $worksheet->setCellValue('N5', 'Services');
        $worksheet->setCellValue('O5', 'Repair Type');
        $worksheet->setCellValue('P5', 'Problem');
        $worksheet->setCellValue('Q5', 'User');
        $worksheet->setCellValue('R5', 'WO Status');

        $worksheet->getStyle('A5:R5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach (array_reverse($outstandingAllBranchWorkOrderData) as $outstandingWorkOrderItem) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($outstandingWorkOrderItem['id']);
            $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $outstandingWorkOrderItem['id']));

            $worksheet->setCellValue("A{$counter}", $outstandingWorkOrderItem['vehicle_id']);
            $worksheet->setCellValue("B{$counter}", $outstandingWorkOrderItem['plate_number']);
            $worksheet->setCellValue("C{$counter}", $outstandingWorkOrderItem['car_make'] . ' - ' . $outstandingWorkOrderItem['car_model'] . ' - ' . $outstandingWorkOrderItem['car_sub_model']);
            $worksheet->setCellValue("D{$counter}", $outstandingWorkOrderItem['color']);
            $worksheet->setCellValue("E{$counter}", $outstandingWorkOrderItem['transaction_number']);
            $worksheet->setCellValue("F{$counter}", $outstandingWorkOrderItem['transaction_date']);
            $worksheet->setCellValue("G{$counter}", $outstandingWorkOrderItem['customer_name']);
            $worksheet->setCellValue("H{$counter}", $outstandingWorkOrderItem['customer_work_order_number']);
            $worksheet->setCellValue("I{$counter}", $outstandingWorkOrderItem['sales_order_number']);
            $worksheet->setCellValue("J{$counter}", $outstandingWorkOrderItem['work_order_number']);
            $worksheet->setCellValue("K{$counter}", $outstandingWorkOrderItem['work_order_date']);
            $worksheet->setCellValue("L{$counter}", $registrationTransaction->getMovementOuts());
            $worksheet->setCellValue("M{$counter}", CHtml::value($invoiceHeader, 'invoice_number'));
            $worksheet->setCellValue("N{$counter}", $registrationTransaction->getServices());
            $worksheet->setCellValue("O{$counter}", $outstandingWorkOrderItem['repair_type']);
            $worksheet->setCellValue("P{$counter}", $outstandingWorkOrderItem['problem']);
            $worksheet->setCellValue("Q{$counter}", $outstandingWorkOrderItem['username']);
            $worksheet->setCellValue("R{$counter}", $outstandingWorkOrderItem['status']);

            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="work_order_outstanding.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

    public function actionAjaxHtmlUpdateCarModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RegistrationTransaction('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['RegistrationTransaction'])) {
                $model->attributes = $_GET['RegistrationTransaction'];
            }

            $carMakeId = isset($_GET['RegistrationTransaction']['car_make_code']) ? $_GET['RegistrationTransaction']['car_make_code'] : '';
//            $carModelId = isset($_GET['CarModelId']) ? $_GET['CarModelId'] : '';

            $this->renderPartial('_carModelSelect', array(
                'model' => $model,
                'carMakeId' => $carMakeId,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return WorkOrder the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = WorkOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param WorkOrder $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'work-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
