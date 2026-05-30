<?php

class SiteController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        $filterChain->run();
    }

    public function actionIndex() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        }
        
        $this->render('index');
    }
    
    public function actionAjaxJsonSearchAnswer() {
        $searchAsk = isset($_POST['SearchAsk']) ? $_POST['SearchAsk'] : '';
        
        $searchAnswer = '';
        if ($searchAsk === 'abc') {
            $searchAnswer = '123';
        } else if ($searchAsk === 'def') {
            $searchAnswer = '456';
        } else if ($searchAsk === 'ghi') {
            $searchAnswer = '789';
        } else if ($searchAsk !== '') {
            $searchAnswer= 'Invalid!';
        }
        
        echo CJSON::encode(array(
            'searchAsk' => $searchAsk,
            'searchAnswer' => $searchAnswer,
        ));
    }
    
    public function actionMarketing() {
        $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : '');
        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : '';
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';

        $endDate = date('Y-m-d');
        $vehicleDataProvider = $vehicle->searchByDashboard();
        $productDataProvider = $product->searchByDashboard();
        $customerDataProvider = $customer->searchByDashboard();
        $serviceDataProvider = $service->searchByDashboard();
        $followUpDataProvider = $vehicle->searchByMarketingFollowUp();
        $followUpDataProvider->criteria->compare('t.plate_number', $plateNumber, true);
        $followUpDataProvider->criteria->compare('customer.name', $customerName, true);
        $followUpDataProvider->criteria->addCondition("DATEDIFF(CURDATE(), (
            SELECT MAX(i.invoice_date)
            FROM " . InvoiceHeader::model()->tableName() . " i
            WHERE t.id = i.vehicle_id AND i.invoice_date > '2023-12-31'
        )) > 180");
        $followUpDataProvider->criteria->addCondition("(
            SELECT COUNT(*)
            FROM " . InvoiceHeader::model()->tableName() . " i
            WHERE t.id = i.vehicle_id AND i.invoice_date > '2023-12-31'
        ) > 3");
        $followUpDataProvider->pagination->pageVar = 'page_follow_up';
        
        $branches = Branch::model()->findAll();

        $vehicleDataProvider->criteria->with = array(
            'customer',
        );

        if (isset($_GET['Vehicle'])) {
            $vehicle->attributes = $_GET['Vehicle'];
        }

        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }
        
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('marketing'));
        }
        
        if (isset($_GET['ExportProductExcel'])) {
            $this->saveToExcelProduct($productDataProvider);
        }
         
        if (isset($_GET['ExportServiceExcel'])) {
            $this->saveToExcelService($serviceDataProvider);
        }
        
        $this->render('marketing', array(
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'product' => $product, 
            'productDataProvider' => $productDataProvider, 
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'followUpDataProvider' => $followUpDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
            'plateNumber' => $plateNumber,
            'customerName' => $customerName,
        ));
    }
        
    public function actionShowCustomer($id) {
        $model = Customer::model()->findByPk($id);
        $vehicleDetails = Vehicle::model()->findAllByAttributes(array('customer_id' => $id), array('limit' => 100, 'order' => 'id DESC'));
        $rateDetails = CustomerServiceRate::model()->findAllByAttributes(array('customer_id' => $id));
        $invoiceHeaders = InvoiceHeader::model()->findAllByAttributes(array('customer_id' => $model->id, 'user_id_cancelled' => null), array('limit' => 100, 'order' => 't.id DESC'));
        
        $this->render('showCustomer', array(
            'model' => $model,
            'vehicleDetails' => $vehicleDetails,
            'rateDetails' => $rateDetails,
            'invoiceHeaders' => $invoiceHeaders,
        ));
    }

    public function actionShowProduct($id) {
        $model = Product::model()->findByPk($id);
        $invoiceDetails = InvoiceDetail::model()->findAllByAttributes(array('product_id' => $model->id), array('limit' => 100, 'order' => 't.id DESC'));
        
        $this->render('showProduct', array(
            'model' => $model,
            'invoiceDetails' => $invoiceDetails,
        ));
    }

    public function actionShowService($id) {
        $model = Service::model()->findByPk($id);
        $serviceEquipments = ServiceEquipment::model()->findAllByAttributes(array('service_id' => $id));
        $complements = ServiceComplement::model()->findAllByAttributes(array('service_id' => $id));
        $invoiceDetails = InvoiceDetail::model()->findAllByAttributes(array('service_id' => $model->id), array('limit' => 100, 'order' => 't.id DESC'));
        
        $this->render('showService', array(
            'model' => $model,
            'serviceEquipments' => $serviceEquipments,
            'complements' => $complements,
            'invoiceDetails' => $invoiceDetails,
        ));
    }

    public function actionShowVehicle($id) {
        $model = Vehicle::model()->findByPk($id);
        $invoiceHeaders = InvoiceHeader::model()->findAllByAttributes(array('vehicle_id' => $model->id, 'user_id_cancelled' => null), array('limit' => 100, 'order' => 't.id DESC'));
        
        $this->render('showVehicle', array(
            'model' => $model,
            'invoiceHeaders' => $invoiceHeaders,
        ));
    }

    public function actionAjaxHtmlUpdateProductStockTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
            $endDate = date('Y-m-d');
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
            $productDataProvider = $product->search(); //ByStockCheck($pageNumber, $endDate, '<>');
            $branches = Branch::model()->findAll();

            $this->renderPartial('_productStockTable', array(
                'productDataProvider' => $productDataProvider,
                'branches' => $branches,
                'endDate' => $endDate,
            ));
        }
    }

    public function actionAjaxHtmlUpdateServiceTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
            $serviceDataProvider = $service->searchByDashboard();

            $this->renderPartial('_serviceTable', array(
                'serviceDataProvider' => $serviceDataProvider,
            ));
        }
    }

    public function actionAjaxHtmlUpdateCarModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
            $carMakeId = isset($_GET['Vehicle']['car_make_id']) ? $_GET['Vehicle']['car_make_id'] : 0;

            $this->renderPartial('_carModelSelect', array(
                'vehicle' => $vehicle,
                'carMakeId' => $carMakeId,
            ));
        }
    }
    
    public function actionAjaxHtmlUpdateCarSubModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
            $carModelId = isset($_GET['Vehicle']['car_model_id']) ? $_GET['Vehicle']['car_model_id'] : 0;

            $this->renderPartial('_carSubModelSelect', array(
                'vehicle' => $vehicle,
                'carModelId' => $carModelId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error' . $error['code'], $error);
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the setting page
     */
    public function actionSetting() {

        $this->render('settings');
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(array('index'));
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
    
    protected function saveToExcelProduct($dataProvider) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Data Parts');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Data Parts');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Data Parts');

        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Brand');
        $worksheet->setCellValue('E5', 'Category');
        $worksheet->setCellValue('F5', 'Description');
        $worksheet->setCellValue('G5', 'Production Year');
        $worksheet->setCellValue('H5', 'Ukuran Ban');
        $worksheet->setCellValue('I5', 'SAE');
        $worksheet->setCellValue('J5', 'Min Stok');

        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'id'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'manufacturer_code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'brand.name') . ' - ' . CHtml::value($header, 'subBrand.name') . ' - ' . CHtml::value($header, 'subBrandSeries.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'productMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubCategory.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'description'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'production_year'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'tireSize.tireName'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'oilSae.oilName'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'minimum_stock'));

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
        header('Content-Disposition: attachment;filename="data_parts.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelService($dataProvider) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Data Service');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Data Service');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');

        $worksheet->getStyle('A1:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Data Service');

        $worksheet->getStyle('A5:F5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('E5', 'Category');
        $worksheet->setCellValue('D5', 'Type');
        $worksheet->setCellValue('F5', 'Description');

        $worksheet->getStyle('A5:F5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'id'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'manufacturer_code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'serviceCategory.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'serviceType.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'description'));

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
        header('Content-Disposition: attachment;filename="data_services.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}