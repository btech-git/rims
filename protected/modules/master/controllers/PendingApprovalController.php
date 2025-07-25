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
            if (!(Yii::app()->user->checkAccess('masterApprovalView'))) {
                $this->redirect(array('/site/login'));
            }
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

        $productMasterCategory = Search::bind(new ProductMasterCategory('search'), isset($_GET['ProductMasterCategory']) ? $_GET['ProductMasterCategory'] : '');
        $productMasterCategoryDataProvider = $productMasterCategory->search();
        $productMasterCategoryDataProvider->criteria->addCondition('t.is_approved = 0 AND t.is_rejected = 0');

        $productSubMasterCategory = Search::bind(new ProductSubMasterCategory('search'), isset($_GET['ProductSubMasterCategory']) ? $_GET['ProductSubMasterCategory'] : '');
        $productSubMasterCategoryDataProvider = $productSubMasterCategory->search();
        $productSubMasterCategoryDataProvider->criteria->addCondition('t.is_approved = 0 AND t.is_rejected = 0');

        $productSubCategory = Search::bind(new ProductSubCategory('search'), isset($_GET['ProductSubCategory']) ? $_GET['ProductSubCategory'] : '');
        $productSubCategoryDataProvider = $productSubCategory->search();
        $productSubCategoryDataProvider->criteria->addCondition('t.is_approved = 0 AND t.is_rejected = 0');

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $serviceDataProvider = $service->search();
        $serviceDataProvider->criteria->addCondition('t.is_approved = 0');

        $serviceCategory = Search::bind(new ServiceCategory('search'), isset($_GET['ServiceCategory']) ? $_GET['ServiceCategory'] : '');
        $serviceCategoryDataProvider = $serviceCategory->search();
        $serviceCategoryDataProvider->criteria->addCondition('t.is_approved = 0 AND t.is_rejected = 0');

        $serviceType = Search::bind(new ServiceType('search'), isset($_GET['ServiceType']) ? $_GET['ServiceType'] : '');
        $serviceTypeDataProvider = $serviceType->search();
        $serviceTypeDataProvider->criteria->addCondition('t.is_approved = 0 AND t.is_rejected = 0');

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
            'productMasterCategory' => $productMasterCategory,
            'productMasterCategoryDataProvider' => $productMasterCategoryDataProvider,
            'productSubMasterCategory' => $productSubMasterCategory,
            'productSubMasterCategoryDataProvider' => $productSubMasterCategoryDataProvider,
            'productSubCategory' => $productSubCategory,
            'productSubCategoryDataProvider' => $productSubCategoryDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'serviceCategory' => $serviceCategory,
            'serviceCategoryDataProvider' => $serviceCategoryDataProvider,
            'serviceType' => $serviceType,
            'serviceTypeDataProvider' => $serviceTypeDataProvider,
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
        $coa->date_approval = date('Y-m-d');
        $coa->time_approval = date('H:i:s');
        $coa->user_id_approval = Yii::app()->user->id;

        if ($coa->update(array('is_approved', 'status', 'date_approval', 'time_approval', 'user_id_approval'))) {
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
        $service->is_rejected = 0;
        $service->user_id_approval = Yii::app()->user->id;
        $service->date_approval = date('Y-m-d');
        $service->time_approval = date('H:i:s');

        if ($customer->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionCustomerReject($customerId) {
        $customer = Coa::model()->findByPk($customerId);
        $customer->status = 'Reject';
        $customer->is_approved = 0;
        $customer->is_rejected = 1;
        $customer->user_id_reject = Yii::app()->user->id;
        $customer->date_reject = date('Y-m-d');
        $customer->time_reject = date('H:i:s');

        if ($customer->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductApproval($productId) {
        $product = Product::model()->findByPk($productId);
        $product->status = 'Active';
        $product->is_approved = 1;
        $product->is_rejected = 0;
        $product->user_id_approval = Yii::app()->user->id;
        $product->date_approval = date('Y-m-d');
        $product->time_approval = date('H:i:s');

        if ($product->save(false)) {
            $warehouses = Warehouse::model()->findAllByAttributes(array('status' => 'Active', 'is_approved' => 1)); 
            foreach ($warehouses as $warehouse) {
                $inventory = new Inventory();
                $inventory->product_id = $productId;
                $inventory->warehouse_id = $warehouse->id;
                $inventory->total_stock = 0;
                $inventory->minimal_stock = 0;
                $inventory->status = 'Active';
                $inventory->category = NULL;
                $inventory->inventory_result = NULL;
                
                $inventory->save();
            }
            
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductReject($productId) {
        $product = Product::model()->findByPk($productId);
        $product->status = 'Reject';
        $product->is_approved = 0;
        $product->is_rejected = 1;
        $product->user_id_reject = Yii::app()->user->id;
        $product->date_reject = date('Y-m-d');
        $product->time_reject = date('H:i:s');

        if ($product->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductMasterCategoryApproval($productMasterCategoryId) {
        $productMasterCategory = ProductMasterCategory::model()->findByPk($productMasterCategoryId);
        $productMasterCategory->is_approved = 1;
        $productMasterCategory->user_id_approval = Yii::app()->user->id;
        $productMasterCategory->date_time_approval = date('Y-m-d H:i:s');
        $productMasterCategory->is_rejected = 0;
        $productMasterCategory->user_id_reject = null;
        $productMasterCategory->date_time_reject = null;

        if ($productMasterCategory->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductMasterCategoryReject($productMasterCategoryId) {
        $productMasterCategory = ProductMasterCategory::model()->findByPk($productMasterCategoryId);
        $productMasterCategory->status = 'Reject';
        $productMasterCategory->is_approved = 0;
        $productMasterCategory->user_id_approval = null;
        $productMasterCategory->date_time_approval = null;
        $productMasterCategory->is_rejected = 1;
        $productMasterCategory->user_id_reject = Yii::app()->user->id;
        $productMasterCategory->date_time_reject = date('Y-m-d H:i:s');

        if ($productMasterCategory->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductSubMasterCategoryApproval($productSubMasterCategoryId) {
        $productSubMasterCategory = ProductSubMasterCategory::model()->findByPk($productSubMasterCategoryId);
        $productSubMasterCategory->is_approved = 1;
        $productSubMasterCategory->user_id_approval = Yii::app()->user->id;
        $productSubMasterCategory->date_time_approval = date('Y-m-d H:i:s');
        $productSubMasterCategory->is_rejected = 0;
        $productSubMasterCategory->user_id_reject = null;
        $productSubMasterCategory->date_time_reject = null;

        if ($productSubMasterCategory->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductSubMasterCategoryReject($productSubMasterCategoryId) {
        $productSubMasterCategory = ProductSubMasterCategory::model()->findByPk($productSubMasterCategoryId);
        $productSubMasterCategory->status = 'Reject';
        $productSubMasterCategory->is_approved = 0;
        $productSubMasterCategory->user_id_approval = null;
        $productSubMasterCategory->date_time_approval = null;
        $productSubMasterCategory->is_rejected = 1;
        $productSubMasterCategory->user_id_reject = Yii::app()->user->id;
        $productSubMasterCategory->date_time_reject = date('Y-m-d H:i:s');

        if ($productSubMasterCategory->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductSubCategoryApproval($productSubCategoryId) {
        $productSubCategory = ProductSubCategory::model()->findByPk($productSubCategoryId);
        $productSubCategory->is_approved = 1;
        $productSubCategory->user_id_approval = Yii::app()->user->id;
        $productSubCategory->date_time_approval = date('Y-m-d H:i:s');
        $productSubCategory->is_rejected = 0;
        $productSubCategory->user_id_reject = null;
        $productSubCategory->date_time_reject = null;

        if ($productSubCategory->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProductSubCategoryReject($productSubCategoryId) {
        $productSubCategory = ProductSubCategory::model()->findByPk($productSubCategoryId);
        $productSubCategory->status = 'Reject';
        $productSubCategory->is_approved = 0;
        $productSubCategory->user_id_approval = null;
        $productSubCategory->date_time_approval = null;
        $productSubCategory->is_rejected = 1;
        $productSubCategory->user_id_reject = Yii::app()->user->id;
        $productSubCategory->date_time_reject = date('Y-m-d H:i:s');

        if ($productSubCategory->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionServiceApproval($serviceId) {
        $service = Service::model()->findByPk($serviceId);
        $service->status = 'Active';
        $service->is_approved = 1;
        $service->is_rejected = 0;
        $service->user_id_approval = Yii::app()->user->id;
        $service->date_approval = date('Y-m-d');
        $service->time_approval = date('H:i:s');

        if ($service->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionServiceReject($serviceId) {
        $service = Service::model()->findByPk($serviceId);
        $service->status = 'Reject';
        $service->is_approved = 0;
        $service->is_rejected = 1;
        $service->user_id_reject = Yii::app()->user->id;
        $service->date_reject = date('Y-m-d');
        $service->time_reject = date('H:i:s');

        if ($service->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionServiceTypeApproval($serviceTypeId) {
        $serviceType = ServiceType::model()->findByPk($serviceTypeId);
        $serviceType->status = 'Active';
        $serviceType->is_approved = 1;
        $serviceType->user_id_approval = Yii::app()->user->id;
        $serviceType->date_time_approval = date('Y-m-d H:i:s');
        $serviceType->is_rejected = 0;
        $serviceType->user_id_reject = null;
        $serviceType->date_time_reject = null;

        if ($serviceType->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionServiceTypeReject($serviceTypeId) {
        $serviceType = ServiceType::model()->findByPk($serviceTypeId);
        $serviceType->status = 'Reject';
        $serviceType->is_approved = 0;
        $serviceType->user_id_approval = null;
        $serviceType->date_time_approval = null;
        $serviceType->is_rejected = 1;
        $serviceType->user_id_reject = Yii::app()->user->id;
        $serviceType->date_time_reject = date('Y-m-d H:i:s');

        if ($serviceType->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionServiceCategoryApproval($serviceCategoryId) {
        $serviceCategory = ServiceCategory::model()->findByPk($serviceCategoryId);
        $serviceCategory->status = 'Active';
        $serviceCategory->is_approved = 1;
        $serviceCategory->user_id_approval = Yii::app()->user->id;
        $serviceCategory->date_time_approval = date('Y-m-d H:i:s');
        $serviceCategory->is_rejected = 0;
        $serviceCategory->user_id_reject = null;
        $serviceCategory->date_time_reject = null;

        if ($serviceCategory->save(false)) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionServiceCategoryReject($serviceCategoryId) {
        $serviceCategory = ServiceCategory::model()->findByPk($serviceCategoryId);
        $serviceCategory->status = 'Reject';
        $serviceCategory->is_approved = 0;
        $serviceCategory->user_id_approval = null;
        $serviceCategory->date_time_approval = null;
        $serviceCategory->is_rejected = 1;
        $serviceCategory->user_id_reject = Yii::app()->user->id;
        $serviceCategory->date_time_reject = date('Y-m-d H:i:s');

        if ($serviceCategory->save(false)) {
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
    
    public function actionAjaxApproveAllService($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $services = Service::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($services as $service) {
                $service->is_approved = 1;
                $service->user_id_approval = Yii::app()->user->id;
                $service->date_approval = date('Y-m-d');
                $service->time_approval = date('H:i:s');
                
                $valid = $valid && $service->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxRejectAllService($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $services = Service::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($services as $service) {
                $service->is_rejected = 1;
                $service->user_id_reject = Yii::app()->user->id;
                $service->date_reject = date('Y-m-d');
                $service->time_reject = date('H:i:s');
                
                $valid = $valid && $service->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxApproveAllServiceCategory($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $serviceCategories = ServiceCategory::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($serviceCategories as $serviceCategory) {
                $serviceCategory->is_approved = 1;
                $serviceCategory->user_id_approval = Yii::app()->user->id;
                $serviceCategory->date_time_approval = date('Y-m-d H:i:s');
                $serviceCategory->is_rejected = 0;
                $serviceCategory->user_id_reject = null;
                $serviceCategory->date_time_reject = null;
                
                $valid = $valid && $serviceCategory->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxRejectAllServiceCategory($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $serviceCategories = ServiceCategory::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($serviceCategories as $serviceCategory) {
                $serviceCategory->is_approved = 0;
                $serviceCategory->user_id_approval = null;
                $serviceCategory->date_time_approval = null;
                $serviceCategory->is_rejected = 1;
                $serviceCategory->user_id_reject = Yii::app()->user->id;
                $serviceCategory->date_time_reject = date('Y-m-d H:i:s');
                
                $valid = $valid && $serviceCategory->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxApproveAllServiceType($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $serviceTypes = ServiceType::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($serviceTypes as $serviceType) {
                $serviceType->is_approved = 1;
                $serviceType->user_id_approval = Yii::app()->user->id;
                $serviceType->date_time_approval = date('Y-m-d H:i:s');
                $serviceType->is_rejected = 0;
                $serviceType->user_id_reject = null;
                $serviceType->date_time_reject = null;
                
                $valid = $valid && $serviceType->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxRejectAllServiceType($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $serviceTypes = ServiceType::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($serviceTypes as $serviceType) {
                $serviceType->is_approved = 0;
                $serviceType->user_id_approval = null;
                $serviceType->date_time_approval = null;
                $serviceType->is_rejected = 1;
                $serviceType->user_id_reject = Yii::app()->user->id;
                $serviceType->date_time_reject = date('Y-m-d H:i:s');
                
                $valid = $valid && $serviceType->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxApproveAllProduct($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $products = Product::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($products as $product) {
                $product->is_approved = 1;
                $product->user_id_approval = Yii::app()->user->id;
                $product->date_approval = date('Y-m-d');
                $product->time_approval = date('H:i:s');
                
                $valid = $valid && $product->save(false);
                
                if ($valid) {
                    $warehouses = Warehouse::model()->findAllByAttributes(array('status' => 'Active', 'is_approved' => 1)); 
                    foreach ($warehouses as $warehouse) {
                        $inventory = new Inventory();
                        $inventory->product_id = $product->id;
                        $inventory->warehouse_id = $warehouse->id;
                        $inventory->total_stock = 0;
                        $inventory->minimal_stock = 0;
                        $inventory->status = 'Active';
                        $inventory->category = NULL;
                        $inventory->inventory_result = NULL;

                        $inventory->save();
                    }
                }
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxRejectAllProduct($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $products = Product::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            foreach ($products as $product) {
                $product->is_rejected = 1;
                $product->user_id_reject = Yii::app()->user->id;
                $product->date_reject = date('Y-m-d');
                $product->time_reject = date('H:i:s');
                $valid = $valid && $product->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxApproveAllProductMasterCategory($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategories = ProductMasterCategory::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($productMasterCategories as $productMasterCategory) {
                $productMasterCategory->is_approved = 1;
                $productMasterCategory->user_id_approval = Yii::app()->user->id;
                $productMasterCategory->date_time_approval = date('Y-m-d H:i:s');
                $productMasterCategory->is_rejected = 0;
                $productMasterCategory->user_id_reject = null;
                $productMasterCategory->date_time_reject = null;
                
                $valid = $valid && $productMasterCategory->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxRejectAllProductMasterCategory($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategories = ProductMasterCategory::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($productMasterCategories as $productMasterCategory) {
                $productMasterCategory->is_approved = 0;
                $productMasterCategory->user_id_approval = null;
                $productMasterCategory->date_time_approval = null;
                $productMasterCategory->is_rejected = 1;
                $productMasterCategory->user_id_reject = Yii::app()->user->id;
                $productMasterCategory->date_time_reject = date('Y-m-d H:i:s');
                
                $valid = $valid && $productMasterCategory->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
   
    public function actionAjaxApproveAllProductSubMasterCategory($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategories = ProductSubMasterCategory::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($productSubMasterCategories as $productSubMasterCategory) {
                $productSubMasterCategory->is_approved = 1;
                $productSubMasterCategory->user_id_approval = Yii::app()->user->id;
                $productSubMasterCategory->date_time_approval = date('Y-m-d H:i:s');
                $productSubMasterCategory->is_rejected = 0;
                $productSubMasterCategory->user_id_reject = null;
                $productSubMasterCategory->date_time_reject = null;
                
                $valid = $valid && $productSubMasterCategory->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxRejectAllProductSubMasterCategory($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategories = ProductSubMasterCategory::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($productSubMasterCategories as $productSubMasterCategory) {
                $productSubMasterCategory->is_approved = 0;
                $productSubMasterCategory->user_id_approval = null;
                $productSubMasterCategory->date_time_approval = null;
                $productSubMasterCategory->is_rejected = 1;
                $productSubMasterCategory->user_id_reject = Yii::app()->user->id;
                $productSubMasterCategory->date_time_reject = date('Y-m-d H:i:s');
                
                $valid = $valid && $productSubMasterCategory->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxApproveAllProductSubCategory($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $productSubCategories = ProductSubCategory::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($productSubCategories as $productSubCategory) {
                $productSubCategory->is_approved = 1;
                $productSubCategory->user_id_approval = Yii::app()->user->id;
                $productSubCategory->date_time_approval = date('Y-m-d H:i:s');
                $productSubCategory->is_rejected = 0;
                $productSubCategory->user_id_reject = null;
                $productSubCategory->date_time_reject = null;
                
                $valid = $valid && $productSubCategory->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxRejectAllProductSubCategory($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $productSubCategories = ProductSubCategory::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            
            foreach ($productSubCategories as $productSubCategory) {
                $productSubCategory->is_approved = 0;
                $productSubCategory->user_id_approval = null;
                $productSubCategory->date_time_approval = null;
                $productSubCategory->is_rejected = 1;
                $productSubCategory->user_id_reject = Yii::app()->user->id;
                $productSubCategory->date_time_reject = date('Y-m-d H:i:s');
                
                $valid = $valid && $productSubCategory->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxApproveAllCustomer($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $customers = Customer::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            foreach ($customers as $customer) {
                $customer->is_approved = 1;
                $customer->user_id_approval = Yii::app()->user->id;
                $customer->date_approval = date('Y-m-d');
                $customer->time_approval = date('H:i:s');
                $valid = $valid && $customer->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
    
    public function actionAjaxRejectAllCustomer($ids) {

        if (Yii::app()->request->isAjaxRequest) {
            $customers = Customer::model()->findAllByAttributes(array('id' => explode(',', $ids)));
            $valid = true;
            foreach ($customers as $customer) {
                $customer->is_rejected = 1;
                $customer->user_id_reject = Yii::app()->user->id;
                $customer->date_reject = date('Y-m-d');
                $customer->time_reject = date('H:i:s');
                $valid = $valid && $customer->save(false);
            }

            $object = array(
                'status' => $valid ? 'OK' : 'Not OK',
            );

            echo CJSON::encode($object);
        }
    }
}
