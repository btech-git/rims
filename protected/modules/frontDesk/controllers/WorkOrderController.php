<?php

class WorkOrderController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'view' 
        ) {
            if (!(Yii::app()->user->checkAccess('workOrderApproval'))) {
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
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($activeWorkOrderData, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('admin', array(
            'activeWorkOrderData' => $activeWorkOrderData,
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

    protected function saveToExcel($activeWorkOrderData, array $options = array()) {
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

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');

        $worksheet->getStyle('A1:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Work Order');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:P5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Vehicle ID');
        $worksheet->setCellValue('B5', 'Plate #');
        $worksheet->setCellValue('C5', 'Date');
        $worksheet->setCellValue('D5', 'Vehicle Model');
        $worksheet->setCellValue('E5', 'Color');
        $worksheet->setCellValue('F5', 'RG #');
        $worksheet->setCellValue('G5', 'SL #');
        $worksheet->setCellValue('H5', 'WO #');
        $worksheet->setCellValue('I5', 'Tanggal WO');
        $worksheet->setCellValue('J5', 'Movement Out #');
        $worksheet->setCellValue('K5', 'Invoice #');
        $worksheet->setCellValue('L5', 'Services');
        $worksheet->setCellValue('M5', 'Repair Type');
        $worksheet->setCellValue('N5', 'Problem');
        $worksheet->setCellValue('O5', 'User');
        $worksheet->setCellValue('P5', 'WO Status');

        $worksheet->getStyle('A5:P5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach (array_reverse($activeWorkOrderData) as $activeWorkOrderItem) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($activeWorkOrderItem['id']);
            $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $activeWorkOrderItem['id']));
            $worksheet->setCellValue("A{$counter}", $activeWorkOrderItem['vehicle_id']);
            $worksheet->setCellValue("B{$counter}", $activeWorkOrderItem['plate_number']);
            $worksheet->setCellValue("C{$counter}", $activeWorkOrderItem['transaction_date']);
            $worksheet->setCellValue("D{$counter}", $activeWorkOrderItem['car_make'] . ' - ' . $activeWorkOrderItem['car_model'] . ' - ' . $activeWorkOrderItem['car_sub_model']);
            $worksheet->setCellValue("E{$counter}", $activeWorkOrderItem['color']);
            $worksheet->setCellValue("F{$counter}", $activeWorkOrderItem['transaction_number']);
            $worksheet->setCellValue("G{$counter}", $activeWorkOrderItem['sales_order_number']);
            $worksheet->setCellValue("H{$counter}", $activeWorkOrderItem['work_order_number']);
            $worksheet->setCellValue("I{$counter}", $activeWorkOrderItem['work_order_date']);
            $worksheet->setCellValue("J{$counter}", $registrationTransaction->getMovementOuts());
            $worksheet->setCellValue("K{$counter}", CHtml::value($invoiceHeader, 'invoice_number'));
            $worksheet->setCellValue("L{$counter}", $registrationTransaction->getServices());
            $worksheet->setCellValue("M{$counter}", $activeWorkOrderItem['repair_type']);
            $worksheet->setCellValue("N{$counter}", $activeWorkOrderItem['problem']);
            $worksheet->setCellValue("O{$counter}", $activeWorkOrderItem['username']);
            $worksheet->setCellValue("P{$counter}", $activeWorkOrderItem['status']);

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

        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 50;
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';

        $workOrderSummary = new WorkOrderSummary($model->search());
        $workOrderSummary->setupLoading();
        $workOrderSummary->setupPaging($pageSize, $currentPage);
        $workOrderSummary->setupSorting();
        $workOrderSummary->setupFilterOutstanding($startDate, $endDate);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcelOutstanding'])) {
            $this->saveToExcelOutstanding($workOrderSummary->dataProvider);
        }

        $this->render('adminOutstanding', array(
            'model' => $model,
            'workOrderSummary' => $workOrderSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    protected function saveToExcelOutstanding($dataProvider) {
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

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');

        $worksheet->getStyle('A1:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'WO Outstanding (pending invoices)');

        $worksheet->getStyle('A4:N4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A4', 'Vehicle ID');
        $worksheet->setCellValue('B4', 'Plate #');
        $worksheet->setCellValue('C4', 'Date');
        $worksheet->setCellValue('D4', 'Vehicle Model');
        $worksheet->setCellValue('E4', 'Color');
        $worksheet->setCellValue('F4', 'WO #');
        $worksheet->setCellValue('G4', 'Tanggal WO');
        $worksheet->setCellValue('H4', 'Invoice #');
        $worksheet->setCellValue('I4', 'Services');
        $worksheet->setCellValue('J4', 'Repair Type');
        $worksheet->setCellValue('K4', 'Problem');
        $worksheet->setCellValue('L4', 'User');
        $worksheet->setCellValue('M4', 'WO Status');

        $worksheet->getStyle('A4:N4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'vehicle_id'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'transaction_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' ' . CHtml::value($header, 'vehicle.carModel.name'));
            $worksheet->setCellValue("E{$counter}", $header->vehicle->getColor($header->vehicle,"color_id"));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'work_order_number'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'work_order_date'));
            $worksheet->setCellValue("H{$counter}", $header->getInvoice($header));
            $worksheet->setCellValue("I{$counter}", $header->getServices());
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'repair_type'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'problem'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'user.username'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'status'));

            $counter++;
        }

        for ($col = 'A'; $col !== 'P'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="wo_outstanding.xls"');
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
