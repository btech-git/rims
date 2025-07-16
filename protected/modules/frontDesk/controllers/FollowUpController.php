<?php

class FollowUpController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'viewInvoices'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate')) || !(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionAdminSales() {

        $invoiceStartDate = (isset($_GET['InvoiceStartDate'])) ? $_GET['InvoiceStartDate'] : date('Y-m-d');
        $invoiceEndDate = (isset($_GET['InvoiceEndDate'])) ? $_GET['InvoiceEndDate'] : date('Y-m-d');
        $warrantyStartDate = (isset($_GET['WarrantyStartDate'])) ? $_GET['WarrantyStartDate'] : '';
        $warrantyEndDate = (isset($_GET['WarrantyEndDate'])) ? $_GET['WarrantyEndDate'] : '';
        $followUpStartDate = (isset($_GET['FollowUpStartDate'])) ? $_GET['FollowUpStartDate'] : '';
        $followUpEndDate = (isset($_GET['FollowUpEndDate'])) ? $_GET['FollowUpEndDate'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $carSubModel = (isset($_GET['CarSubModel'])) ? $_GET['CarSubModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $model = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $dataProvider = $model->searchByFollowUp();

        if (!empty($warrantyStartDate) && !empty($warrantyEndDate)) {
            $dataProvider->criteria->addBetweenCondition('t.warranty_date', $warrantyStartDate, $warrantyEndDate);
        }
        
        if (!empty($followUpStartDate) && !empty($followUpEndDate)) {
            $dataProvider->criteria->addBetweenCondition('t.follow_up_date', $followUpStartDate, $followUpEndDate);
        }
        
        if (!empty($plateNumber)) {
            $dataProvider->criteria->addCondition('vehicle.plate_number LIKE :plate_number');
            $dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }
        
        if (!empty($carMake)) {
            $dataProvider->criteria->addCondition('vehicle.car_make_id = :car_make_id');
            $dataProvider->criteria->params[':car_make_id'] = $carMake;
        }
        
        if (!empty($carModel)) {
            $dataProvider->criteria->addCondition('vehicle.car_model_id = :car_model_id');
            $dataProvider->criteria->params[':car_model_id'] = $carModel;
        }
        
        if (!empty($customerName)) {
            $dataProvider->criteria->addCondition('customer.name LIKE :name');
            $dataProvider->criteria->params[':name'] = "%{$customerName}%";
        }
        
        $dataProvider->criteria->addBetweenCondition('t.invoice_date', $invoiceStartDate, $invoiceEndDate);
        $dataProvider->criteria->addCondition("t.status IN ('PAID', 'CLEAR')");

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('adminSales'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcelCustomerFollowUp($dataProvider);
        }

        $this->render('adminSales', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'plateNumber' => $plateNumber,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'carSubModel' => $carSubModel,
            'customerName' => $customerName,
            'invoiceStartDate' => $invoiceStartDate,
            'invoiceEndDate' => $invoiceEndDate,
            'warrantyStartDate' => $warrantyStartDate,
            'warrantyEndDate' => $warrantyEndDate,
            'followUpStartDate' => $followUpStartDate,
            'followUpEndDate' => $followUpEndDate,
        ));
    }
    
    public function actionAjaxHtmlUpdateCarModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
            $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';

            $this->renderPartial('_carModelSelect', array(
                'carMake' => $carMake,
                'carModel' => $carModel,
            ));
        }
    }
    
    public function actionAjaxHtmlUpdateCarSubModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
            $carSubModel = (isset($_GET['CarSubModel'])) ? $_GET['CarSubModel'] : '';

            $this->renderPartial('_carSubModelSelect', array(
                'carModel' => $carModel,
                'carSubModel' => $carSubModel,
            ));
        }
    }
    
    protected function saveToExcelCustomerFollowUp($dataProvider) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Customer Follow Up');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Customer Follow Up');

        $worksheet->mergeCells('A1:U1');
        $worksheet->mergeCells('A2:U2');
        $worksheet->getStyle('A1:U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:U3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Customer Follow Up');
        
        $worksheet->getStyle('A3:U3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A3', 'No');
        $worksheet->setCellValue('B3', 'Customer');
        $worksheet->setCellValue('C3', 'HP');
        $worksheet->setCellValue('D3', 'Plat #');
        $worksheet->setCellValue('E3', 'Car Make');
        $worksheet->setCellValue('F3', 'Car Model');
        $worksheet->setCellValue('G3', 'Car Sub Model');
        $worksheet->setCellValue('H3', 'Color');
        $worksheet->setCellValue('I3', 'Vehicle System Check # (Last)');
        $worksheet->setCellValue('J3', 'Last KM');
        $worksheet->setCellValue('K3', 'Invoice #');
        $worksheet->setCellValue('L3', 'Invoice Last Date');
        $worksheet->setCellValue('M3', 'Last Service List');
        $worksheet->setCellValue('N3', 'Last Parts List');
        $worksheet->setCellValue('O3', 'Frontliner(s)');
        $worksheet->setCellValue('P3', 'Mechanic(s)');
        $worksheet->setCellValue('Q3', 'Warranty Date (3days)');
        $worksheet->setCellValue('R3', 'Follow up Date (3 Months)');
        $worksheet->setCellValue('S3', 'Days since Last Service (hari)');
        $worksheet->setCellValue('T3', 'Notes');
        $worksheet->setCellValue('U3', 'Follow up Status');

        $worksheet->getStyle('A3:U3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 5;
        foreach ($dataProvider->data as $i => $header) {

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.mobile_phone'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.carMake.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.carModel.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'vehicle.color.name'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'registrationTransaction.vehicle_mileage'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'registrationTransaction.services'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'registrationTransaction.products'));
            $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name'));
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'registrationTransaction.employeeIdAssignMechanic.name'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'warrantyFollowUpDate'));
            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'serviceFollowUpDate'));
            $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'lastInvoiceDaysNumber'));
            $worksheet->setCellValue("T{$counter}", CHtml::value($header, 'note'));
            $worksheet->setCellValue("U{$counter}", CHtml::value($header, 'registrationTransaction.feedback'));

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
        header('Content-Disposition: attachment;filename="customer_follow_up.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    public function actionAdminService() {

        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $model = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $dataProvider = $model->searchByFollowUp();
        $dataProvider->criteria->addCondition("t.status IN ('PAID', 'CLEAR') AND t.branch_id = :branch_id");
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        
        if (!empty($plateNumber)) {
            $dataProvider->criteria->addCondition('vehicle.plate_number LIKE :plate_number');
            $dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }
        
        if (!empty($carMake)) {
            $dataProvider->criteria->addCondition('vehicle.car_make_id = :car_make_id');
            $dataProvider->criteria->params[':car_make_id'] = $carMake;
        }
        
        if (!empty($carModel)) {
            $dataProvider->criteria->addCondition('vehicle.car_model_id = :car_model_id');
            $dataProvider->criteria->params[':car_model_id'] = $carModel;
        }
        
        if (!empty($customerName)) {
            $dataProvider->criteria->addCondition('customer.name LIKE :name');
            $dataProvider->criteria->params[':name'] = "%{$customerName}%";
        }
        
        $followUpDate = date('Y-m-d', strtotime('-6 months', strtotime(date('Y-m-d')))); 
        $dataProvider->criteria->addCondition('t.invoice_date >= :follow_up_date');
        $dataProvider->criteria->params[':follow_up_date'] = $followUpDate;

        $this->render('adminService', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'plateNumber' => $plateNumber,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'customerName' => $customerName,
        ));
    }
    public function actionUpdateFeedback($id) {
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);

        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
//            'is_body_repair' => 0
        ));
        
        if (isset($_POST['Submit'])) {
            $registrationTransaction->feedback = $_POST['RegistrationTransaction']['feedback'];
            $registrationTransaction->feedback = $_POST['RegistrationTransaction']['note'];
            $registrationTransaction->update(array('feedback', 'note'));
            
            $this->redirect(array('adminSales'));
        }

        $this->render('updateFeedback', array(
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'products' => $products,
            'services' => $services,
        ));
    }
    
    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $jurnalUmum = new JurnalUmum('search');

        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $yearMonth = (isset($_GET['YearMonth'])) ? $_GET['YearMonth'] : date('Y-m');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $balanceSheetSummary = new BalanceSheetSummary($jurnalUmum->search());
        $balanceSheetSummary->setupLoading();
        $balanceSheetSummary->setupPaging(1000, 1);
        $balanceSheetSummary->setupSorting();
        $balanceSheetSummary->setupFilter($yearMonth, $coaId, $branchId);

        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($balanceSheetSummary, $coaId, $yearMonth, $branchId);
        }

        $this->render('jurnalTransaction', array(
            'jurnalUmum' => $jurnalUmum,
            'balanceSheetSummary' => $balanceSheetSummary,
            'yearMonth' => $yearMonth,
            'coaId' => $coaId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcelTransactionJournal($balanceSheetSummary, $coaId, $yearMonth, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $branch = Branch::model()->findbyPk($branchId);
        $coa = Coa::model()->findByPk($coaId);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Balance Sheet Transaction');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Balance Sheet Transaction');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        $worksheet->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Transaction Detail - ' . empty($branchId) ? 'All Branch' : $branch->code);
        $worksheet->setCellValue('A2', $coa->code . ' - ' . $coa->name);
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('MMMM yyyy', strtotime($yearMonth)));
        
        $worksheet->getStyle('A5:G5')->getBorders()->gettOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Kode Transaksi');
        $worksheet->setCellValue('D5', 'Keterangan');
        $worksheet->setCellValue('E5', 'Memo');
        $worksheet->setCellValue('F5', 'Debit');
        $worksheet->setCellValue('G5', 'Kredit');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7; 
        
        $totalDebit = '0.00'; 
        $totalCredit = '0.00'; 
        foreach ($balanceSheetSummary->dataProvider->data as $i => $header) {
            $debitAmount = $header->debet_kredit == 'D' ? $header->total : 0;
            $creditAmount = $header->debet_kredit == 'K' ? $header->total : 0;

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $header->tanggal_transaksi);
            $worksheet->setCellValue("C{$counter}", $header->kode_transaksi);
            $worksheet->setCellValue("D{$counter}", $header->transaction_subject);
            $worksheet->setCellValue("E{$counter}", $header->transaction_type);
            $worksheet->setCellValue("F{$counter}", $debitAmount);
            $worksheet->setCellValue("G{$counter}", $creditAmount);

            $totalDebit += $debitAmount;
            $totalCredit += $creditAmount;

            $counter++;

        }
        
        $worksheet->mergeCells("A{$counter}:E{$counter}");
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("F{$counter}", $totalDebit);
        $worksheet->setCellValue("G{$counter}", $totalCredit);
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="balance_sheet_transaction.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}