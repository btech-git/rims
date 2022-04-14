<?php

class PendingApprovalController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('accountingHead')) || !(Yii::app()->user->checkAccess('financeHead')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionIndex() {

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');

        $coa = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : '');
        $coaDataProvider = $coa->searchByPendingApproval();
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : '');
        $customerDataProvider = $customer->search();
        $customerDataProvider->criteria->addCondition('t.is_approved = 0');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : '');
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->criteria->addCondition('t.is_approved = 0');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $productDataProvider = $product->search();
        $productDataProvider->criteria->addCondition('t.is_approved = 0');

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $serviceDataProvider = $service->search();
        $serviceDataProvider->criteria->addCondition('t.is_approved = 0');

        $warehouse = Search::bind(new Warehouse('search'), isset($_GET['Warehouse']) ? $_GET['Warehouse'] : '');
        $warehouseDataProvider = $warehouse->search();
        $warehouseDataProvider->criteria->addCondition('t.is_approved = 0');

        $carMake = Search::bind(new VehicleCarMake('search'), isset($_GET['VehicleCarMake']) ? $_GET['VehicleCarMake'] : '');
        $carMakeDataProvider = $carMake->search();
        $carMakeDataProvider->criteria->addCondition('t.is_approved = 0');

        $carModel = Search::bind(new VehicleCarModel('search'), isset($_GET['VehicleCarModel']) ? $_GET['VehicleCarModel'] : '');
        $carModelDataProvider = $carModel->search();
        $carModelDataProvider->criteria->addCondition('t.is_approved = 0');

        $carSubModel = Search::bind(new VehicleCarSubModel('search'), isset($_GET['VehicleCarSubModel']) ? $_GET['VehicleCarSubModel'] : '');
        $carSubModelDataProvider = $carSubModel->search();
        $carSubModelDataProvider->criteria->addCondition('t.is_approved = 0');

        $this->render('index', array(
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'warehouse' => $warehouse,
            'warehouseDataProvider' => $warehouseDataProvider,
            'carMake' => $carMake,
            'carMakeDataProvider' => $carMakeDataProvider,
            'carModel' => $carModel,
            'carModelDataProvider' => $carModelDataProvider,
            'carSubModel' => $carSubModel,
            'carSubModelDataProvider' => $carSubModelDataProvider,
        ));
    }
    
    public function actionCoaApproval($coaId) {
        $coa = Coa::model()->findByPk($coaId);
        $coa->status = 'Approved';
        $coa->is_approved = 1;

        if ($coa->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionCoaReject($coaId) {
        $coa = Coa::model()->findByPk($coaId);
        $coa->status = 'Reject';
        $coa->is_approved = 2;

        if ($coa->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionMakeApproval($makeId) {
        $vehicleCarMake = VehicleCarMake::model()->findByPk($makeId);
        $vehicleCarMake->status = 'Active';
        $vehicleCarMake->is_approved = 1;

        if ($vehicleCarMake->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionMakeReject($makeId) {
        $vehicleCarMake = VehicleCarMake::model()->findByPk($makeId);
        $vehicleCarMake->status = 'Reject';
        $vehicleCarMake->is_approved = 2;

        if ($vehicleCarMake->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionModelApproval($modelId) {
        $vehicleCarModel = VehicleCarModel::model()->findByPk($modelId);
        $vehicleCarModel->status = 'Active';
        $vehicleCarModel->is_approved = 1;

        if ($vehicleCarModel->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionModelReject($modelId) {
        $vehicleCarModel = VehicleCarModel::model()->findByPk($modelId);
        $vehicleCarModel->status = 'Reject';
        $vehicleCarModel->is_approved = 2;

        if ($vehicleCarModel->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionSubModelApproval($subModelId) {
        $vehicleCarSubModel = VehicleCarSubModel::model()->findByPk($subModelId);
        $vehicleCarSubModel->is_approved = 1;

        if ($vehicleCarSubModel->update(array('is_approved'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionSubModelReject($subModelId) {
        $vehicleCarSubModel = Coa::model()->findByPk($subModelId);
        $vehicleCarSubModel->is_approved = 2;

        if ($vehicleCarSubModel->update(array('is_approved'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionCustomerApproval($customerId) {
        $customer = Customer::model()->findByPk($customerId);
        $customer->status = 'Active';
        $customer->is_approved = 1;

        if ($customer->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionCustomerReject($customerId) {
        $customer = Coa::model()->findByPk($customerId);
        $customer->status = 'Reject';
        $customer->is_approved = 2;

        if ($customer->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductApproval($productId) {
        $product = Product::model()->findByPk($productId);
        $product->status = 'Active';
        $product->is_approved = 1;

        if ($product->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductReject($productId) {
        $product = Product::model()->findByPk($productId);
        $product->status = 'Reject';
        $product->is_approved = 2;

        if ($product->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionServiceApproval($serviceId) {
        $service = Service::model()->findByPk($serviceId);
        $service->status = 'Active';
        $service->is_approved = 1;

        if ($service->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionServiceReject($serviceId) {
        $service = Service::model()->findByPk($serviceId);
        $service->status = 'Reject';
        $service->is_approved = 2;

        if ($service->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionSupplierApproval($supplierId) {
        $supplier = Supplier::model()->findByPk($supplierId);
        $supplier->status = 'Active';
        $supplier->is_approved = 1;

        if ($supplier->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionSupplierReject($supplierId) {
        $supplier = Supplier::model()->findByPk($supplierId);
        $supplier->status = 'Reject';
        $supplier->is_approved = 2;

        if ($supplier->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionWarehouseApproval($warehouseId) {
        $warehouse = Warehouse::model()->findByPk($warehouseId);
        $warehouse->status = 'Active';
        $warehouse->is_approved = 1;

        if ($warehouse->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionWarehouseReject($warehouseId) {
        $warehouse = Warehouse::model()->findByPk($warehouseId);
        $warehouse->status = 'Reject';
        $warehouse->is_approved = 2;

        if ($warehouse->update(array('is_approved', 'status'))) {
            $this->redirect(array('index'));
        }
    }
}
