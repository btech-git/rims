<?php

class WorkOrderReworkController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleTaxReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $workOrderReworkSummary = new WorkOrderReworkSummary($registrationTransaction->searchReport());
        $workOrderReworkSummary->setupLoading();
        $workOrderReworkSummary->setupPaging($pageSize, $currentPage);
        $workOrderReworkSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerType' => $customerType,
            'plateNumber' => $plateNumber,
            'branchId' => $branchId,
        );
        $workOrderReworkSummary->setupFilter($filters);

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($workOrderReworkSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'registrationTransaction' => $registrationTransaction,
            'workOrderReworkSummary' => $workOrderReworkSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerType' => $customerType,
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'plateNumber' => $plateNumber,
            'branchId' => $branchId,
            'pageSize' => $pageSize,
        ));
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['InvoiceHeader']['customer_id'])) ? $_POST['InvoiceHeader']['customer_id'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_type' => CHtml::value($customer, 'customer_type'),
                'customer_mobile_phone' => CHtml::value($customer, 'mobile_phone'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlUpdateVehicleList() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = isset($_GET['InvoiceHeader']['customer_id']) ? $_GET['InvoiceHeader']['customer_id'] : 0;
            $vehicleId = isset($_GET['VehicleId']) ? $_GET['VehicleId'] : '';
            $vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 'id DESC', 'limit' => 100));

            $this->renderPartial('_vehicleList', array(
                'vehicles' => $vehicles,
                'vehicleId' => $vehicleId,
            ));
        }
    }

    protected function saveToExcel($workOrderReworkSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('WO Re-work');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('WO Re-work');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');
       
        $worksheet->getStyle('A1:Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Work Order Re-work');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:Q5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:Q5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Rework #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'WO #');
        $worksheet->setCellValue('E5', 'SPK Customer #');
        $worksheet->setCellValue('F5', 'Customer');
        $worksheet->setCellValue('G5', 'Plat #');
        $worksheet->setCellValue('H5', 'Kendaraan');
        $worksheet->setCellValue('I5', 'Asuransi');
        $worksheet->setCellValue('J5', 'KM');
        $worksheet->setCellValue('K5', 'Keluhan');
        $worksheet->setCellValue('L5', 'Problem');
        $worksheet->setCellValue('M5', 'Parts');
        $worksheet->setCellValue('N5', 'DPP Parts');
        $worksheet->setCellValue('O5', 'Jasa');
        $worksheet->setCellValue('P5', 'DPP Jasa');
        $worksheet->setCellValue('Q5', 'Total DPP');

        $counter = 6;

        foreach ($workOrderReworkSummary->dataProvider->data as $i => $header) {
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'rework_transaction_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'rework_transaction_date') . ' ' . CHtml::value($header, 'rework_transaction_time'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'work_order_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer_work_order_number'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'insuranceCompany.name'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'vehicle_mileage'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'customer_request_note'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'problem'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'products'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'subtotal_product'));
            $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'services'));
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'subtotal_service'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'grand_total'));

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
        header("Content-Disposition: attachment;filename=work_order_rework.xls");
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
