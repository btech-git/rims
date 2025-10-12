<?php

class VehicleStatusController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'index') {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        $vehicle = new Vehicle('search');
        $vehicle->unsetAttributes();  // clear any default values

        $startDateIn = (isset($_GET['StartDateIn'])) ? $_GET['StartDateIn'] : date('Y-m-d');
        $endDateIn = (isset($_GET['EndDateIn'])) ? $_GET['EndDateIn'] : date('Y-m-d');
        $startDateProcess = (isset($_GET['StartDateProcess'])) ? $_GET['StartDateProcess'] : date('Y-m-d');
        $endDateProcess = (isset($_GET['EndDateProcess'])) ? $_GET['EndDateProcess'] : date('Y-m-d');
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        
        $vehicleEntryDataprovider = $vehicle->searchByEntryStatusLocation($customerName);
        $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog_entry';
        $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleEntryDataprovider->criteria->addBetweenCondition('DATE(t.entry_datetime)', $startDateIn, $endDateIn);
        
        $vehicleProcessDataprovider = $vehicle->searchByProcessStatusLocation($customerName);
        $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog_process';
        $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleProcessDataprovider->criteria->addBetweenCondition('DATE(t.start_service_datetime)', $startDateProcess, $endDateProcess);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($vehicleEntryDataprovider, $vehicleProcessDataprovider, $startDateIn, $endDateIn, $startDateProcess, $endDateProcess);
        }

        $this->render('index', array(
            'vehicle' => $vehicle,
            'plateNumber' => $plateNumber,
            'customerName' => $customerName,
            'startDateIn' => $startDateIn,
            'endDateIn' => $endDateIn,
            'startDateProcess' => $startDateProcess,
            'endDateProcess' => $endDateProcess,
            'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
            'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
        ));
    }
    
//    public function actionAjaxHtmlUpdateVehicleEntryDataTable() {
//        if (Yii::app()->request->isAjaxRequest) {
//            
//            $vehicle = new Vehicle('search');
//            $vehicle->unsetAttributes();  // clear any default values
//            
//            $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
//            $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
//            $startDateIn = (isset($_GET['StartDateIn'])) ? $_GET['StartDateIn'] : date('Y-m-d');
//            $endDateIn = (isset($_GET['EndDateIn'])) ? $_GET['EndDateIn'] : date('Y-m-d');
//
//            $vehicleEntryDataprovider = $vehicle->searchByEntryStatusLocation($customerName);
//            $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog';
//            $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
//            $vehicleEntryDataprovider->criteria->addBetweenCondition('DATE(t.entry_datetime)', $startDateIn, $endDateIn);
//        
//            $this->renderPartial('_vehicleEntry', array(
//                'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
//                'startDateIn' => $startDateIn,
//                'endDateIn' => $endDateIn,
//            ));
//        }
//    }
//
//    public function actionAjaxHtmlUpdateVehicleStatusDataTable() {
//        if (Yii::app()->request->isAjaxRequest) {
//
//            $vehicle = new Vehicle('search');
//            $vehicle->unsetAttributes();  // clear any default values
//
//            $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
//            $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
//            $startDateProcess = (isset($_GET['StartDateProcess'])) ? $_GET['StartDateProcess'] : date('Y-m-d');
//            $endDateProcess = (isset($_GET['EndDateProcess'])) ? $_GET['EndDateProcess'] : date('Y-m-d');
//
//            $vehicleProcessDataprovider = $vehicle->searchByProcessStatusLocation($customerName);
//            $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog';
//            $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
//            $vehicleProcessDataprovider->criteria->addBetweenCondition('DATE(t.start_service_datetime)', $startDateProcess, $endDateProcess);
//        
//            $this->renderPartial('_vehicleProcess', array(
//                'startDateProcess' => $startDateProcess,
//                'endDateProcess' => $endDateProcess,
//                'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
//            ));
//        }
//    }
    
    public function actionUpdateToProgress($id) {
        $model = Vehicle::model()->findByPk($id);
        $oldVehiclePositionTimer = VehiclePositionTimer::model()->find(array(
            'order' => ' id DESC',
            'condition' => "t.vehicle_id = :vehicle_id AND t.entry_date IS NOT NULL AND t.process_date IS NULL AND t.exit_date IS NULL",
            'params' => array(':vehicle_id' => $id)
        ));
        
        if (!empty($model) && !empty($oldVehiclePositionTimer)) {
            $model->status_location = 'On-Progress';
            $model->start_service_datetime = date('Y-m-d H:i:s');
            $model->start_service_user_id = Yii::app()->user->id;
            $model->update(array('status_location', 'start_service_datetime', 'start_service_user_id')); 

            $vehiclePositionTimer = $oldVehiclePositionTimer;
            $vehiclePositionTimer->process_date = date('Y-m-d');
            $vehiclePositionTimer->process_time = date('H:i:s');
            $vehiclePositionTimer->exit_date = null;
            $vehiclePositionTimer->exit_time = null;
            $vehiclePositionTimer->save();
        }

        $this->redirect(array('index'));
    }
    
    public function actionUpdateToExit($id) {
        $vehicle = new Vehicle('search');
        $vehicle->unsetAttributes();  // clear any default values

        $startDateIn = (isset($_GET['StartDateIn'])) ? $_GET['StartDateIn'] : date('Y-m-d');
        $endDateIn = (isset($_GET['EndDateIn'])) ? $_GET['EndDateIn'] : date('Y-m-d');
        $startDateProcess = (isset($_GET['StartDateProcess'])) ? $_GET['StartDateProcess'] : date('Y-m-d');
        $endDateProcess = (isset($_GET['EndDateProcess'])) ? $_GET['EndDateProcess'] : date('Y-m-d');
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        
        $vehicleEntryDataprovider = $vehicle->searchByEntryStatusLocation($customerName);
        $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog';
        $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleEntryDataprovider->criteria->addBetweenCondition('DATE(t.entry_datetime)', $startDateIn, $endDateIn);
        
        $vehicleProcessDataprovider = $vehicle->searchByProcessStatusLocation($customerName);
        $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog';
        $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleProcessDataprovider->criteria->addBetweenCondition('DATE(t.start_service_datetime)', $startDateProcess, $endDateProcess);

        $model = Vehicle::model()->findByPk($id);
        $oldVehiclePositionTimer = VehiclePositionTimer::model()->find(array(
            'order' => ' id DESC',
            'condition' => "t.vehicle_id = :vehicle_id AND t.entry_date IS NOT NULL AND t.process_date IS NOT NULL AND t.exit_date IS NULL",
            'params' => array(':vehicle_id' => $id)
        ));

        
        if (!empty($model) && !empty($oldVehiclePositionTimer)) {
            $model->status_location = 'Keluar Lokasi';
            $model->exit_datetime = date('Y-m-d H:i:s');
            $model->exit_user_id = Yii::app()->user->id;
            $model->update(array('status_location', 'exit_datetime', 'exit_user_id')); 
            
            $vehiclePositionTimer = $oldVehiclePositionTimer;
            $vehiclePositionTimer->exit_date = date('Y-m-d');
            $vehiclePositionTimer->exit_time = date('H:i:s');
            $vehiclePositionTimer->save();
        }
            
        $this->render('index', array(
            'vehicle' => $vehicle,
            'customerName' => $customerName,
            'plateNumber' => $plateNumber,
            'startDateIn' => $startDateIn,
            'endDateIn' => $endDateIn,
            'startDateProcess' => $startDateProcess,
            'endDateProcess' => $endDateProcess,
            'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
            'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
        ));
    }

    protected function saveToExcel($vehicleEntryDataprovider, $vehicleProcessDataprovider, $startDateIn, $endDateIn, $startDateProcess, $endDateProcess) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Data Mobil Masuk Bengkel');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Data Mobil Masuk Bengkel');

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');

        $worksheet->getStyle('A1:P6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Data Mobil Masuk Bengkel');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDateIn)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDateIn)));

        $worksheet->getStyle('A5:P5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', '#');
        $worksheet->setCellValue('B5', 'Tanggal Masuk');
        $worksheet->setCellValue('C5', 'Plat #');
        $worksheet->setCellValue('D5', 'Kendaraan');
        $worksheet->setCellValue('E5', 'Warna');
        $worksheet->setCellValue('F5', 'Customer');
        $worksheet->setCellValue('G5', 'KM');
        $worksheet->setCellValue('H5', 'Registration #');
        $worksheet->setCellValue('I5', 'Tanggal');
        $worksheet->setCellValue('J5', 'WO #');
        $worksheet->setCellValue('K5', 'SL #');
        $worksheet->setCellValue('L5', 'Invoice #');
        $worksheet->setCellValue('M5', 'Payment #');
        $worksheet->setCellValue('N5', 'Status');
        $worksheet->setCellValue('O5', 'Lokasi');
        $worksheet->setCellValue('P5', 'User Entry');

        $worksheet->getStyle('A6:P6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        
        foreach ($vehicleEntryDataprovider->data as $i => $data) {
            $registrationTransaction = RegistrationTransaction::model()->find(array(
                'condition' => 'vehicle_id = :vehicle_id AND DATE(transaction_date) BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':vehicle_id' => $data->id,
                    ':start_date' => $startDateIn,
                    ':end_date' => $endDateIn,
                ),
            ));
            if (!empty($registrationTransaction)) {
                $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $registrationTransaction->id));
            }
            if (!empty($invoiceHeader) && !empty($registrationTransaction)) {
                $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('invoice_header_id' => $invoiceHeader->id));
            }
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($data, 'entry_datetime'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($data, 'plate_number'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($data, 'carMake.name') . ' - ' . CHtml::value($data, 'carModel.name') . ' - ' . CHtml::value($data, 'carSubModel.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($data, 'color.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($data, 'customer.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($registrationTransaction, 'vehicle_mileage'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($registrationTransaction, 'transaction_number'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($registrationTransaction, 'transaction_date'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($registrationTransaction, 'work_order_number'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($registrationTransaction, 'sales_order_number'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($invoiceHeader, 'invoice_number'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($paymentInDetail, 'paymentIn.payment_number'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($registrationTransaction, 'status'));
            $worksheet->setCellValue("O{$counter}", CHtml::value($data, 'status_location'));
            $worksheet->setCellValue("P{$counter}", CHtml::value($data, 'entryUser.username'));

            $counter++;
        }
        $counter++;

        $worksheet->mergeCells("A{$counter}:P{$counter}");
        $worksheet->getStyle("A{$counter}:P{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:P{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'Data Mobil Dalam Proses');
        $counter++;
        $worksheet->mergeCells("A{$counter}:P{$counter}");
        $worksheet->getStyle("A{$counter}:P{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:P{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDateProcess)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDateProcess)));
      
        $counter++;
        $worksheet->getStyle("A{$counter}:P{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:P{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:P{$counter}")->getFont()->setBold(true);

        $worksheet->setCellValue("A{$counter}", '#');
        $worksheet->setCellValue("B{$counter}", 'Plat #');
        $worksheet->setCellValue("C{$counter}", 'Kendaraan');
        $worksheet->setCellValue("D{$counter}", 'Warna');
        $worksheet->setCellValue("E{$counter}", 'Customer');
        $worksheet->setCellValue("F{$counter}", 'KM');
        $worksheet->setCellValue("G{$counter}", 'Registration #');
        $worksheet->setCellValue("H{$counter}", 'Tanggal');
        $worksheet->setCellValue("I{$counter}", 'WO #');
        $worksheet->setCellValue("J{$counter}", 'SL #');
        $worksheet->setCellValue("K{$counter}", 'Invoice #');
        $worksheet->setCellValue("L{$counter}", 'Payment #');
        $worksheet->setCellValue("M{$counter}", 'Status');
        $worksheet->setCellValue("N{$counter}", 'Lokasi');
        $counter++;

        $worksheet->getStyle("A{$counter}:P{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($vehicleProcessDataprovider->data as $i => $data) {
            $registrationTransaction = RegistrationTransaction::model()->find(array(
                'condition' => 'vehicle_id = :vehicle_id AND DATE(transaction_date) BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':vehicle_id' => $data->id,
                    ':start_date' => $startDateIn,
                    ':end_date' => $endDateIn,
                ),
            ));
            if (!empty($registrationTransaction)) {
                $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $registrationTransaction->id));
            }
            if (!empty($invoiceHeader) && !empty($registrationTransaction)) {
                $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('invoice_header_id' => $invoiceHeader->id));
            }
            $worksheet->getStyle("F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($data, 'plate_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($data, 'carMake.name') . ' - ' . CHtml::value($data, 'carModel.name') . ' - ' . CHtml::value($data, 'carSubModel.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($data, 'color.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($data, 'customer.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($registrationTransaction, 'vehicle_mileage'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($registrationTransaction, 'transaction_number'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($registrationTransaction, 'transaction_date'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($registrationTransaction, 'work_order_number'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($registrationTransaction, 'sales_order_number'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($invoiceHeader, 'invoice_number'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($paymentInDetail, 'paymentIn.payment_number'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($registrationTransaction, 'status'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($data, 'status_location'));

            $counter++;
        }

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="data_kendaraan_dalam_bengkel.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}