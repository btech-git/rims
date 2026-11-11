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
            if (!(Yii::app()->user->checkAccess('vehicleStatusView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        $registrationTransaction = new RegistrationTransaction('search');
        $registrationTransaction->unsetAttributes();  // clear any default values

        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        
        $vehicleEntryDataprovider = $registrationTransaction->searchByEntryStatusLocation();
        $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog_entry';
        $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleEntryDataprovider->criteria->compare('customer.name', $customerName, true);
        $vehicleEntryDataprovider->criteria->addCondition("t.customer_id IN (60849, 60926, 63482)");
        
        $vehicleProcessDataprovider = $registrationTransaction->searchByProcessStatusLocation();
        $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog_process';
        $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleProcessDataprovider->criteria->compare('customer.name', $customerName, true);
        $vehicleProcessDataprovider->criteria->addCondition("t.customer_id IN (60849, 60926, 63482)");

//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($vehicleEntryDataprovider, $vehicleProcessDataprovider, $startDateIn, $endDateIn, $startDateProcess, $endDateProcess);
//        }

        $this->render('index', array(
            'vehicle' => $registrationTransaction,
            'plateNumber' => $plateNumber,
            'customerName' => $customerName,
            'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
            'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
        ));
    }
    
    public function actionUpdateToProgress($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        $vehicle = Vehicle::model()->findByPk($model->vehicle_id);
        
        if (!empty($model)) {
            $model->service_status = 'On-Progress';
            $model->update(array('service_status')); 
            
            $vehicle->start_service_datetime = date('Y-m-d H:i:s');
            $vehicle->start_service_user_id = Yii::app()->user->id;
            $vehicle->update(array('start_service_datetime', 'start_service_user_id')); 
        }

        $this->redirect(array('index'));
    }
    
    public function actionUpdateToExit($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        $vehicle = Vehicle::model()->findByPk($model->vehicle_id);
        
        if (!empty($model)) {
            $model->service_status = 'Completed';
            $model->update(array('service_status')); 
            
            $vehicle->status_location = 'Keluar Lokasi';
            $vehicle->exit_datetime = date('Y-m-d H:i:s');
            $vehicle->exit_user_id = Yii::app()->user->id;
            $vehicle->update(array('status_location', 'exit_datetime', 'exit_user_id')); 
        }

        $this->redirect(array('index'));
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