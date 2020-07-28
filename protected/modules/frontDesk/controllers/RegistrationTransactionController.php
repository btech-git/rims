<?php

class RegistrationTransactionController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    // public function filters()
    // {
    // 	return array(
    // 		'accessControl', // perform access control for CRUD operations
    // 		'postOnly + delete', // we only allow deletion via POST request
    // 	);
    // }

    /**f
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'admin',
                    'idleManagement',
                    'idleManagementAjaxInfo',
                    'idleManagementUpdate',
                    'idleManagementServices',
                    'idleManagementServiceUpdate',
                    'idleManagementServiceView',
                    'idleManagementStartService',
                    'idleManagementPauseService',
                    'idleManagementResumeService',
                    'idleManagementFinishService',
                    'ajaxHtmlAddEmployeeDetail',
                    'ajaxHtmlRemoveEmployeeDetail',
                    'ajaxHtmlAddSupervisorDetail',
                    'ajaxHtmlRemoveSupervisorDetail',
                    'delete',
                    'ajaxCustomer',
                    'ajaxGetCustomerPic',
                    'ajaxPic',
                    'ajaxGetCustomerVehicle',
                    'ajaxVehicle',
                    'ajaxGetServiceRate',
                    'ajaxHtmlAddQuickServiceDetail',
                    'ajaxHtmlRemoveQuickServiceDetail',
                    'ajaxEmployee',
                    'ajaxHtmlAddServiceDetail',
                    'ajaxHtmlRemoveServiceDetail',
                    'ajaxHtmlAddProductDetail',
                    'ajaxHtmlRemoveProductDetail',
                    'ajaxEstimateBilling',
                    'ajaxCountProduct',
                    'ajaxHtmlRemoveQuickServiceDetailAll',
                    'ajaxGetHistory',
                    'ajaxCheckQuickService',
                    'ajaxHtmlAddDamageDetail',
                    'ajaxHtmlRemoveDamageDetail',
                    'ajaxProduct',
                    'ajaxService',
                    'ajaxHtmlAddInsuranceDetail',
                    'ajaxHtmlRemoveInsuranceDetail',
                    'ajaxGetCity',
                    'ajaxGetCityDriver',
                    'ajaxShowPricelist',
                    'ajaxHtmlAddServiceInsuranceDetail',
                    'ajaxHtmlRemoveInsuranceDetailAll',
                    'ajaxHtmlRemoveDamageDetailAll',
                    'generateWorkOrder',
                    'ajaxHtmlAddQsServiceDetail',
                    'showRealization',
                    'ajaxHtmlUpdate',
                    'updateSpk',
                    'adminWo',
                    'viewWo',
                    'updateImages',
                    'deleteImage',
                    'deleteFeatured',
                    'cashier',
                    'billDetail',
                    'customerData',
                    'deleteImageRealization',
                    'customerWaitlist',
                    'getMaterial',
                    'vehicleData',
                    'ajaxHtmlRemoveServiceDetailAll',
                    'generateInvoice',
                    'generateSalesOrder',
                    'receive'
                ),
                'users' => array('Admin'),
            ),
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $quickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $damages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $insurances = RegistrationInsuranceData::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $registrationMemos = RegistrationMemo::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'quickServices' => $quickServices,
            'services' => $services,
            'products' => $products,
            'damages' => $damages,
            'insurances' => $insurances,
            'registrationMemos' => $registrationMemos,
        ));
    }

    public function actionViewWo($id)
    {

        $model = $this->loadModel($id);
        // if($model->repair_type == 'GR'){
        // 	$details = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$id,'is_body_repair'=>0));
        // }
        // else
        // {
        // 	$details = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$id,'is_body_repair'=>1));
        // }
        $details = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $id));


        $this->render('viewWo', array(
            'model' => $model,
            'details' => $details,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($type, $id)
    {
        // $model=new RegistrationTransaction;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);


        // if(isset($_POST['RegistrationTransaction']))
        // {
        // 	$model->attributes=$_POST['RegistrationTransaction'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        // $this->render('create',array(
        // 	'model'=>$model,
        // 	'customer'=>$customer,
        // 	'customerDataProvider'=>$customerDataProvider,
        // ));
        $data = array();
        if ($type == 1) {
            $data = Customer::model()->findByPk($id);
        } else {
            $data = Vehicle::model()->findByPk($id);
        }

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));


        $qs = new QuickService('search');
        $qs->unsetAttributes();  // clear any default values
        if (isset($_GET['QuickService'])) {
            $qs->attributes = $_GET['QuickService'];
        }

        $qsCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $qsCriteria->compare('name', $qs->name, true);
        $qsCriteria->compare('code', $qs->code, true);
        $qsCriteria->compare('rate', $qs->rate, true);

        $qsDataProvider = new CActiveDataProvider('QuickService', array(
            'criteria' => $qsCriteria,
        ));
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }

        $serviceCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');

        $serviceCriteria->compare('t.name', $service->name, true);
        $serviceCriteria->compare('t.code', $service->code, true);
        $explodeKeyword = explode(" ", $service->findkeyword);
        foreach ($explodeKeyword as $key) {
            $serviceCriteria->compare('t.code', $key, true, 'OR');
            $serviceCriteria->compare('t.name', $key, true, 'OR');
            $serviceCriteria->compare('description', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        //$serviceCriteria->compare('rate',$service->rate,true);

        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));

        $serviceArray = array();
        // $product = new Product('search');
        //     	$product->unsetAttributes();  // clear any default values
        //     	if (isset($_GET['Product']))
        //       	$product->attributes = $_GET['Product'];

        // $productCriteria = new CDbCriteria;
        // $productCriteria->compare('name',$product->name,true);
        // $productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
        // $productCriteria->together=true;
        // $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
        // $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
        // //$productCriteria->addCondition('rims_supplier_product.supplier_id'=$supplier->id);
        // $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
        // $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
        // $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
        // $productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
        // $productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
        // $productDataProvider = new CActiveDataProvider('Product', array(
        //   	'criteria'=>$productCriteria,));
        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

//        $productCriteria = new CDbCriteria;
//        $productCriteria->together = true;
//        $productCriteria->with = array('productMasterCategory', 'productSubMasterCategory', 'productSubCategory');
//        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
//        $productCriteria->compare('t.name', $product->name, true);
//        $productCriteria->compare('productMasterCategory.name', $product->product_master_category_name, true);
//        $productCriteria->compare('productSubMasterCategory.name', $product->product_sub_master_category_name, true);
//        $productCriteria->compare('productSubCategory.name', $product->product_sub_category_name, true);

        $productDataProvider = $product->search();
//        new CActiveDataProvider('Product', array(
//            'criteria' => $productCriteria,
//        ));

        $registrationTransaction = $this->instantiate(null);
        $registrationTransaction->header->branch_id = $registrationTransaction->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $registrationTransaction->header->branch_id;
        $registrationTransaction->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->transaction_date)), $registrationTransaction->header->branch_id);
        if (isset($_POST['RegistrationTransaction'])) {

            $this->loadState($registrationTransaction);
            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }

        }
        $this->render('create', array(
            //'model'=>$model,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'registrationTransaction' => $registrationTransaction,
            'qs' => $qs,
            'qsDataProvider' => $qsDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'data' => $data,
            'type' => $type,

        ));

    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //$model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // if(isset($_POST['RegistrationTransaction']))
        // {
        // 	$model->attributes=$_POST['RegistrationTransaction'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        // $this->render('update',array(
        // 	'model'=>$model,
        // ));
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        $qs = new QuickService('search');
        $qs->unsetAttributes();  // clear any default values
        if (isset($_GET['QuickService'])) {
            $qs->attributes = $_GET['QuickService'];
        }
        $qsCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $qsCriteria->compare('name', $qs->name, true);
        $qsCriteria->compare('code', $qs->code, true);
        $qsCriteria->compare('rate', $qs->rate, true);

        $qsDataProvider = new CActiveDataProvider('QuickService', array(
            'criteria' => $qsCriteria,
        ));
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }

        $serviceCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');

        $serviceCriteria->compare('t.name', $service->name, true);
        $serviceCriteria->compare('t.code', $service->code, true);
        $explodeKeyword = explode(" ", $service->findkeyword);
        foreach ($explodeKeyword as $key) {
            $serviceCriteria->compare('t.code', $key, true, 'OR');
            $serviceCriteria->compare('t.name', $key, true, 'OR');
            $serviceCriteria->compare('description', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        //$serviceCriteria->compare('rate',$service->rate,true);

        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));

        $serviceChecks = RegistrationService::model()->findAllByAttributes(array('service_id' => $id));
        $serviceArray = array();
        foreach ($serviceChecks as $key => $serviceCheck) {
            array_push($serviceArray, $serviceCheck->service_id);
        }

        // $product = new Product('search');
        //     	$product->unsetAttributes();  // clear any default values
        //     	if (isset($_GET['Product']))
        //       	$product->attributes = $_GET['Product'];

        // $productCriteria = new CDbCriteria;
        // $productCriteria->compare('name',$product->name,true);
        // $productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
        // $productCriteria->together=true;
        // $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
        // $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
        // //$productCriteria->addCondition('rims_supplier_product.supplier_id'=$supplier->id);
        // $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
        // $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
        // $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
        // $productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
        // $productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
        // $productDataProvider = new CActiveDataProvider('Product', array(
        //   	'criteria'=>$productCriteria,));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->together = true;
        $productCriteria->with = array(
            'productMasterCategory',
            'productSubMasterCategory',
            'productSubCategory',
            'brand'
        );
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('productMasterCategory.name', $product->product_master_category_name, true);
        $productCriteria->compare('productSubMasterCategory.name', $product->product_sub_master_category_name, true);
        $productCriteria->compare('productSubCategory.name', $product->product_sub_category_name, true);
        $productCriteria->compare('brand.name', $product->product_brand_name, true);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $registrationTransaction = $this->instantiate($id);
        $registrationTransaction->header->setCodeNumberByRevision('transaction_number');
        $type = "";
        $data = RegistrationTransaction::model()->findByPk($id);
        if (isset($_POST['RegistrationTransaction'])) {


            $this->loadState($registrationTransaction);
            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }
        $this->render('update', array(
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'registrationTransaction' => $registrationTransaction,
            'qs' => $qs,
            'qsDataProvider' => $qsDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'type' => $type,
            'data' => $data,
        ));

    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new RegistrationTransaction();
        $model->choice = 2;
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));
        
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $vehicle = new Vehicle('search');
        $vehicle->unsetAttributes();  // clear any default values
        if (isset($_GET['Vehicle'])) {
            $vehicle->attributes = $_GET['Vehicle'];
        }

//        $vehicleCriteria = new CDbCriteria;
//        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
//        $vehicleCriteria->compare('plate_number', $vehicle->plate_number, true);

        $vehicleDataProvider = $vehicle->search(); 
        $vehicleDataProvider->criteria->with = array('customer');

        //new CActiveDataProvider('Vehicle', array(
//            'criteria' => $vehicleCriteria,
//        ));

        if (!empty($customerCompany)) {
            $vehicleDataProvider->criteria->addCondition('customer.name LIKE :customer_company');
            $vehicleDataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }
        
        $dataProvider = new CActiveDataProvider('RegistrationTransaction');
        $this->render('index', array(
            'model' => $model,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'customerCompany' => $customerCompany,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new RegistrationTransaction('search');
        // var_dump($model); die("S");
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminTest()
    {
        $model = new RegistrationTransaction('search');
        // var_dump($model); die("S");
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $this->render('admintest', array(
            'model' => $model,
        ));
    }

    public function actionCashier()
    {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }
        
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));
        
        $this->render('cashier', array(
            'model' => $model,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionAdminWo()
    {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        // var_dump($model->getDatas()); die("S");
        $modelCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $modelCriteria->addCondition("work_order_number != ''");
        $modelDataProvider = new CActiveDataProvider('RegistrationTransaction', array(
            'criteria' => $modelCriteria,
            'sort' => array(
                'defaultOrder' => 'transaction_number',
                'attributes' => array(
                    'branch_id' => array(
                        'asc' => 'branch.name ASC',
                        'desc' => 'branch.name DESC',
                    ),
                    'customer_name' => array(
                        'asc' => 'customer.name ASC',
                        'desc' => 'customer.name DESC',
                    ),
                    'pic_name' => array(
                        'asc' => 'pic.name ASC',
                        'desc' => 'pic.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $this->render('adminWorkOrder', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
        ));
    }

    /**
     * Idle Management.
     */
    public function actionIdleManagement()
    {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $modelCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $modelCriteria->addCondition("work_order_number != ''");
        $modelCriteria->compare('status', $model->status, true);
        $modelCriteria->order = 'vehicle_id ASC, work_order_date DESC';
        $modelDataProvider = new CActiveDataProvider('RegistrationTransaction', array(
            'criteria' => $modelCriteria,
        ));
        $this->render('idle-management', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
        ));
    }

    /**
     * Idle Management.
     */
    public function actionIdleManagementAjaxInfo($registrationId, $vehicleId)
    {
        $registrationCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $registrationCriteria->addCondition("work_order_number != ''");
        //$registrationCriteria->addCondition("vehicle_id = " . $vehicleId);
        $registrationCriteria->addCondition("vehicle_id = 4");
        $registrationCriteria->order = 'work_order_date DESC';
        $registrationTransactions = RegistrationTransaction::model()->findAllByAttributes(array(),
            $registrationCriteria);
        $this->renderPartial('_idle-management-info', array(
            'registrationTransactions' => $registrationTransactions,
            //'modelDataProvider'=>$modelDataProvider,
        ), false, true);
    }

    /**
     * Idle Management Update Service.
     */
    public function actionIdleManagementUpdate($id)
    {
        $model = $this->loadModel($id);

        //Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['RegistrationTransaction'])) {
            $model->attributes = $_POST['RegistrationTransaction'];
            $model->laststatusupdate_by = Yii::app()->user->id;
            if ($model->save()) {
                $this->redirect(array('idleManagement'));
            }
        }

        $this->renderPartial('_idle-management-update', array(
            'model' => $model,
        ));
    }

    /**
     * Idle Management Services.
     */
    public function actionIdleManagementServices($registrationId)
    {
        /*$model=new RegistrationTransaction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RegistrationTransaction']))
			$model->attributes=$_GET['RegistrationTransaction'];

		$this->render('idle-management',array(
			'model'=>$model,
		));*/
        $registration = RegistrationTransaction::model()->findByPk($registrationId);

        $registrationService = new RegistrationService('search');
        $registrationService->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationService'])) {
            $registrationService->attributes = $_GET['RegistrationService'];
        }

        $registrationServiceCriteria = new CDbCriteria;


        if ($registration->repair_type == 'BR') {
            $registrationServiceCriteria->condition = 'registration_transaction_id = ' . $registrationId . ' AND is_body_repair = 1 ';
        } else {
            $registrationServiceCriteria->condition = 'registration_transaction_id = ' . $registrationId . ' AND is_body_repair = 0 ';

        }
        $registrationServiceCriteria->compare('id', $registrationService->id);
        $registrationServiceCriteria->compare('registration_transaction_id',
            $registrationService->registration_transaction_id);
        $registrationServiceCriteria->compare('service_id', $registrationService->service_id);
        $registrationServiceCriteria->compare('claim', $registrationService->claim, true);
        $registrationServiceCriteria->compare('price', $registrationService->price, true);
        $registrationServiceCriteria->compare('total_price', $registrationService->total_price, true);
        $registrationServiceCriteria->compare('discount_price', $registrationService->discount_price, true);
        $registrationServiceCriteria->compare('discount_type', $registrationService->discount_type, true);
        $registrationServiceCriteria->compare('is_quick_service', $registrationService->is_quick_service);
        $registrationServiceCriteria->compare('start', $registrationService->start, true);
        $registrationServiceCriteria->compare('end', $registrationService->end, true);
        $registrationServiceCriteria->compare('pause', $registrationService->pause, true);
        $registrationServiceCriteria->compare('resume', $registrationService->resume, true);
        $registrationServiceCriteria->compare('pause_time', $registrationService->pause_time, true);
        $registrationServiceCriteria->compare('total_time', $registrationService->total_time, true);
        $registrationServiceCriteria->compare('note', $registrationService->note, true);
        $registrationServiceCriteria->compare('is_body_repair', $registrationService->is_body_repair);
        $registrationServiceCriteria->compare('LOWER(status)', strtolower($registrationService->status), false);
        $registrationServiceCriteria->compare('start_mechanic_id', $registrationService->start_mechanic_id);
        $registrationServiceCriteria->compare('finish_mechanic_id', $registrationService->finish_mechanic_id);
        $registrationServiceCriteria->compare('pause_mechanic_id', $registrationService->pause_mechanic_id);
        $registrationServiceCriteria->compare('resume_mechanic_id', $registrationService->resume_mechanic_id);
        $registrationServiceCriteria->compare('supervisor_id', $registrationService->supervisor_id);
        $registrationServiceCriteria->compare('t.status', $registrationService->status, true);

        $registrationServiceDataProvider = new CActiveDataProvider('RegistrationService', array(
            'criteria' => $registrationServiceCriteria,
        ));


        //$model= Vehicle::model()->findAll($criteria);
        //$model->unsetAttributes();  // clear any default values
        //if(isset($_GET['Vehicle']))
        //$model->attributes=$_GET['Vehicle'];

        $this->render('idle-management-services', array(
            'registration' => $registration,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider
        ));

        /*$this->renderPartial('_idle-management-services',array(
			'registration'=>$registration,
			'registrationService'=>$registrationService,
			'registrationServiceDataProvider'=>$registrationServiceDataProvider
		), false, true);*/
    }

    /**
     * Idle Management Update Service.
     */
    public function actionIdleManagementServiceUpdate($serviceId, $registrationId)
    {
        /*$registrationService = RegistrationService::model()->findByAttributes(array('service_id'=>$serviceId));

		//Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($registrationService);

		if(isset($_POST['RegistrationService']))
		{
			$registrationService->attributes=$_POST['RegistrationService'];
			if($registrationService->save())
				$this->redirect(array('idleManagementServiceView','serviceId'=>$registrationService->service_id));
		}

		$this->render('idle-management-service-update',array(
			'registrationService'=>$registrationService,
		));*/

        $registrationService = $this->instantiateRegistrationService($_GET['registrationServiceId']);

        $employee = new Employee('search');
        $employee->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee'])) {
            $employee->attributes = $_GET['Employe'];
        }

        $employeeCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        //$employeeCriteria->condition = 'availability = "Yes"';

        $employeeDataProvider = new CActiveDataProvider('Employee', array(
            'criteria' => $employeeCriteria,
        ));

        $this->performAjaxValidation($registrationService->header);

        //$sectionArray = array();
        if (isset($_POST['RegistrationService'])) {
            $this->loadStateRegistrationService($registrationService);
            if ($registrationService->save(Yii::app()->db)) {
                $this->redirect(array('idleManagementServices', 'registrationId' => $registrationId));
                //$this->redirect(array('idleManagement'));
            } else {
                foreach ($registrationService->employeeDetails as $key => $employeeDetail) {
                    //print_r(CJSON::encode($vehicleInspectionDetail->id));
                }
            }

        }

        $this->render('idle-management-service-update', array(
            //'model'=>$model,
            'registrationService' => $registrationService,
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
            //'sectionArray'=>$sectionArray,
        ));

    }

    /**
     * Idle Management View Service.
     */
    public function actionIdleManagementServiceView($serviceId, $registrationId)
    {
        $registrationService = RegistrationService::model()->findByAttributes(array(
            'service_id' => $serviceId,
            'registration_transaction_id' => $registrationId
        ));

        $this->render('idle-management-service-view', array(
            'registrationService' => $registrationService
        ));
    }

    /**
     * Start Finish Service.
     */
    public function actionIdleManagementStartService($serviceId, $registrationId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            $registrationService->start = date('Y-m-d H:i:s');
            $registrationService->status = 'On Progress';
            $registrationService->start_mechanic_id = Yii::app()->user->id;

            /*$registrationRealization = new RegistrationRealizationProcess();
			$registrationRealization->registration_transaction_id = $registrationId;
			$registrationRealization->name = $registrationService->service->name;
			$registrationRealization->checked = 1;
			$registrationRealization->checked_by = Yii::app()->user->id;
			$registrationRealization->checked_date = date('Y-m-d');
			$registrationRealization->detail = 'On Progress';
			$registrationRealization->save();*/

            //Ada error di bagian ini
            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registrationId,
                'name' => $registrationService->service->name
            ));
            //$real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->id;
            $real->detail = 'On Progress (Update From Idle Management)';
            $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

            $registrationService->save();

            $model = $this->loadModel($registrationId);
            $model->status = 'On Progress';
            $model->save();

            //$this->redirect(array('idleManagementServices', 'registrationId' => $registrationId));
            //$this->redirect(array('idleManagement'));
        }
    }

    /**
     * Start Pause Service.
     */
    public function actionIdleManagementPauseService($serviceId, $registrationId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            $registrationService->pause = date('Y-m-d H:i:s');
            //$registrationService->pause = round(abs(strtotime(date('Y-m-d H:i:s'))-strtotime($registrationService->start)));
            $registrationService->status = 'On Progress';
            $registrationService->pause_mechanic_id = Yii::app()->user->id;
            //$registrationService->start_mechanic_id = Yii::app()->user->id;

            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registrationId,
                'service_id' => $registrationService->service_id
            ));
            //$real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->id;
            $real->detail = 'Paused (Update From Idle Management)';
            $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

            $registrationService->save();

            $model = $this->loadModel($registrationId);
            $model->status = 'Paused';
            $model->save();

            //$this->redirect(array('idleManagementServices', 'registrationId' => $registrationId));
            //$this->redirect(array('idleManagement'));
        }
    }

    /**
     * Start Resume Service.
     */
    public function actionIdleManagementResumeService($serviceId, $registrationId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            //$registrationService->pause = date('H:i:s');
            $registrationService->resume = date('Y-m-d H:i:s');
            //$pauseTime = date_create($registrationService->resume)->diff(date_create($registrationService->pause))->format('%H:%i:%s');
            /*$pauseTime = strtotime($registrationService->resume) - strtotime($registrationService->pause) + $registrationService->pause_time;
			if($registrationService->pause_time == NULL){
				$registrationService->pause_time = date_create($registrationService->resume)->diff(date_create($registrationService->pause))->format('%y-%m-%d %H:%i:%s');
			} else {
				$registrationService->pause_time = $pauseTime;
			}*/

            $registrationService->status = 'On Progress';
            $registrationService->resume_mechanic_id = Yii::app()->user->id;
            //$registrationService->start_mechanic_id = Yii::app()->user->id;

            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registrationId,
                'service_id' => $registrationService->service_id
            ));
            //$real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->id;
            $real->detail = 'On Progress (Update From Idle Management)';
            $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

            $registrationService->save();

            $connection = Yii::app()->db;
            //$sql='UPDATE rims_registration_service SET `total_time` = SEC_TO_TIME(TIME_TO_SEC(`end`)-TIME_TO_SEC(`start`)+TIME_TO_SEC(`pause_time`)) WHERE service_id=:service_id and registration_transaction_id=:registration_transaction_id';
            $sql = 'UPDATE rims_registration_service SET `pause_time` = SEC_TO_TIME(TIMESTAMPDIFF(SECOND,pause,resume)+TIME_TO_SEC(`pause_time`)) WHERE service_id=:service_id and registration_transaction_id=:registration_transaction_id';
            $command = $connection->createCommand($sql);
            $command->bindParam(":service_id", $serviceId, PDO::PARAM_STR);
            $command->bindParam(":registration_transaction_id", $registrationId, PDO::PARAM_STR);
            $command->execute();

            $model = $this->loadModel($registrationId);
            $model->status = 'On Progress';
            $model->save();

            //$this->redirect(array('idleManagementServices', 'registrationId' => $registrationId));
            //$this->redirect(array('idleManagement'));
        }
    }

    public function actionIdleManagementFinishService($serviceId, $registrationId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            /*$c = new CDbCriteria;
			$c->condition = 'service_id = ' . $serviceId . ' and registration_transaction_id = ' . $registrationId;
			RegistrationService::model()->updateAll(array('end'=>date('Y-m-d H:i:s'), 'status'=>'Finished', 'finish_mechanic_id'=>Yii::app()->user->id, 'total_time'=>'SEC_TO_TIME(TIME_TO_SEC(`end`)-TIME_TO_SEC(`start`))'), $c);*/

            /*$command = Yii::app()->db->createCommand();
			$command->update('rims_registration_service', array(
    			'end'=>date('Y-m-d H:i:s'),
    			'total_time'=>'SEC_TO_TIME(TIME_TO_SEC(`end`)-TIME_TO_SEC(`start`))'
			), 'service_id = ' . $serviceId . ' and registration_transaction_id = ' . $registrationId);*/

            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            $registrationService->end = date('Y-m-d H:i:s');
            $registrationService->status = 'Finished';
            $registrationService->finish_mechanic_id = Yii::app()->user->id;

            /*$registrationService = RegistrationService::model()->findByAttributes(array('service_id'=>$serviceId,'registration_transaction_id'=>$registrationId));
			$registrationService->end = date('Y-m-d H:i:s');
			$registrationService->status = 'Finished';
			$registrationService->finish_mechanic_id = Yii::app()->user->id;

			$diff = date_create($registrationService->end)->diff(date_create($registrationService->start))->format('%y-%m-%d %H:%i:%s');
			$sec = strtotime($registrationService->pause_time)-time();
			$registrationService->total_time = time() - strtotime($registrationService->pause_time);
			$registrationService->total_time = ($registrationService->total_time) + strtotime($registrationService->pause_time);
			$registrationService->total_time = $registrationService->getTotalTime($serviceId,$registrationId);
			*/

            $transaction = RegistrationTransaction::model()->findByPk($registrationId);

            if ($transaction->repair_type == 'GR') {
                $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                    'registration_transaction_id' => $registrationId,
                    'service_id' => $registrationService->service_id
                ));
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = Yii::app()->user->id;
                $real->detail = 'Finished (Update From Idle Management)';
                $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
            } else {
                if ($registrationService->is_body_repair == 1) {
                    $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                        'registration_transaction_id' => $registrationId,
                        'service_id' => $registrationService->service_id
                    ));
                    $real->checked = 1;
                    $real->checked_date = date('Y-m-d');
                    $real->checked_by = Yii::app()->user->id;
                    $real->detail = 'Finished (Update From Idle Management)';
                    $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
                }

            }
            /*$real = RegistrationRealizationProcess::model()->findByAttributes(array('registration_transaction_id'=>$registrationId,'name'=>$registrationService->service->name));
			$real->checked = 1;
			$real->checked_date = date('Y-m-d');
			$real->checked_by = Yii::app()->user->id;
			$real->detail = 'Finished (Update From Idle Management)';
			$real->update(array('checked','checked_by','checked_date','detail'));*/

            $registrationService->save();

            //Update Total Time using SQL Syntax
            $connection = Yii::app()->db;
            //$sql='UPDATE rims_registration_service SET `total_time` = SEC_TO_TIME(TIME_TO_SEC(`end`)-TIME_TO_SEC(`start`)+TIME_TO_SEC(`pause_time`)) WHERE service_id=:service_id and registration_transaction_id=:registration_transaction_id';
            $sql = 'UPDATE rims_registration_service SET `total_time` = SEC_TO_TIME(TIMESTAMPDIFF(SECOND,start,end)+TIME_TO_SEC(`pause_time`)) WHERE service_id=:service_id and registration_transaction_id=:registration_transaction_id';
            $command = $connection->createCommand($sql);
            $command->bindParam(":service_id", $serviceId, PDO::PARAM_STR);
            $command->bindParam(":registration_transaction_id", $registrationId, PDO::PARAM_STR);
            $command->execute();


            $criteria = new CDbCriteria();
            $criteria->condition = 'registration_transaction_id = ' . $registrationId . ' and status IN ("On Progress", "Pending", "Available")';
            $count = RegistrationService::model()->count($criteria);

            $model = $this->loadModel($registrationId);
            $model->status = $count == 0 ? 'Finished' : 'On Progress';
            $model->save();

            //$this->redirect(array('idleManagementServices', 'registrationId' => $registrationId));
            //$this->redirect(array('idleManagement'));
        }
    }

	public function actionAjaxJsonTotalService($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$registrationTransaction = $this->instantiate($id);
			$this->loadState($registrationTransaction);

			$totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityService));
			$subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalService));
			$totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountService));
//			$tax = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->calculatedTax));
			$grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalService));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
			$taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxServiceAmount));
			$grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

			echo CJSON::encode(array(
				'totalAmount' => $totalAmount,
                'totalQuantityService' => $totalQuantityService,
				'subTotalService' => $subTotalService,
				'totalDiscountService' => $totalDiscountService,
//				'tax'=>$tax,
				'grandTotalService'=>$grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'taxServiceAmount' => $taxServiceAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
			));
		}
	}

	public function actionAjaxJsonTotalProduct($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$registrationTransaction = $this->instantiate($id);
			$this->loadState($registrationTransaction);

			$totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityProduct));
			$subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalProduct));
			$totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountProduct));
//			$tax = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->calculatedTax));
			$grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalProduct));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
			$taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxServiceAmount));
			$grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

			echo CJSON::encode(array(
				'totalAmountProduct' => $totalAmountProduct,
                'totalQuantityProduct' => $totalQuantityProduct,
				'subTotalProduct' => $subTotalProduct,
				'totalDiscountProduct' => $totalDiscountProduct,
//				'tax'=>$tax,
				'grandTotalProduct'=>$grandTotalProduct,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'taxServiceAmount' => $taxServiceAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
			));
		}
	}

	public function actionAjaxJsonGrandTotal($id)
	{
		if (Yii::app()->request->isAjaxRequest) {
			$registrationTransaction = $this->instantiate($id);
			$this->loadState($registrationTransaction);

			$totalQuickServiceQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalQuickServiceQuantity));
			$subTotalQuickService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalQuickService));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityService));
			$subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalService));
			$totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountService));
			$grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalService));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxServiceAmount));
			$grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

			echo CJSON::encode(array(
                'totalQuickServiceQuantity' => $totalQuickServiceQuantity,
                'subTotalQuickService' => $subTotalQuickService,
                'totalQuantityService' => $totalQuantityService,
				'subTotalService' => $subTotalService,
				'totalDiscountService' => $totalDiscountService,
				'grandTotalService'=>$grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
				'taxItemAmount' => $taxItemAmount,
				'taxServiceAmount' => $taxServiceAmount,
				'grandTotal' => $grandTotal,
			));
		}
	}

    //Add Employee Detail
    public function actionAjaxHtmlAddEmployeeDetail($id, $employeeId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = $this->instantiateRegistrationService($id);
            $this->loadStateRegistrationService($registrationService);
            $registrationService->addEmployeeDetail($employeeId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_idle-management-update-detail-employee',
                array('registrationService' => $registrationService), false, true);
        }
    }

    //Delete Employee Detail
    public function actionAjaxHtmlRemoveEmployeeDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = $this->instantiateRegistrationService($id);
            $this->loadStateRegistrationService($registrationService);
            $registrationService->removeEmployeeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_idle-management-update-detail-employee',
                array('registrationService' => $registrationService), false, true);
        }
    }

    //Add Supervisor Detail
    public function actionAjaxHtmlAddSupervisorDetail($id, $supervisorId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = $this->instantiateRegistrationService($id);
            $this->loadStateRegistrationService($registrationService);
            $registrationService->addSupervisorDetail($supervisorId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_idle-management-update-detail-supervisor',
                array('registrationService' => $registrationService), false, true);
        }
    }

    //Delete Supervisor Detail
    public function actionAjaxHtmlRemoveSupervisorDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = $this->instantiateRegistrationService($id);
            $this->loadStateRegistrationService($registrationService);
            $registrationService->removeSupervisorDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_idle-management-update-detail-supervisor',
                array('registrationService' => $registrationService), false, true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RegistrationTransaction the loaded model
     * @throws CHttpException
     */
    public function instantiate($id)
    {
        if (empty($id)) {
            $registrationTransaction = new RegistrationTransactions(new RegistrationTransaction(), array(), array(),
                array(), array(), array());
            //print_r("test");
        } else {
            $registrationTransactionModel = $this->loadModel($id);
            $registrationTransaction = new RegistrationTransactions($registrationTransactionModel,
                $registrationTransactionModel->registrationQuickServices,
                $registrationTransactionModel->registrationServices,
                $registrationTransactionModel->registrationProducts, $registrationTransactionModel->registrationDamages,
                $registrationTransactionModel->registrationInsuranceDatas);
        }
        return $registrationTransaction;
    }

    public function loadState($registrationTransaction)
    {
        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->header->attributes = $_POST['RegistrationTransaction'];
        }
        if (isset($_POST['RegistrationQuickService'])) {
            foreach ($_POST['RegistrationQuickService'] as $i => $item) {
                if (isset($registrationTransaction->quickServiceDetails[$i])) {
                    $registrationTransaction->quickServiceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationQuickService();
                    $detail->attributes = $item;
                    $registrationTransaction->quickServiceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationQuickService']) < count($registrationTransaction->quickServiceDetails)) {
                array_splice($registrationTransaction->quickServiceDetails, $i + 1);
            }
        } else {
            $registrationTransaction->quickServiceDetails = array();
        }

        if (isset($_POST['RegistrationService'])) {
            foreach ($_POST['RegistrationService'] as $i => $item) {
                if (isset($registrationTransaction->serviceDetails[$i])) {
                    $registrationTransaction->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationService();
                    $detail->attributes = $item;
                    $registrationTransaction->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationService']) < count($registrationTransaction->serviceDetails)) {
                array_splice($registrationTransaction->serviceDetails, $i + 1);
            }
        } else {
            $registrationTransaction->serviceDetails = array();
        }

        if (isset($_POST['RegistrationProduct'])) {
            foreach ($_POST['RegistrationProduct'] as $i => $item) {
                if (isset($registrationTransaction->productDetails[$i])) {
                    $registrationTransaction->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationProduct();
                    $detail->attributes = $item;
                    $registrationTransaction->productDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationProduct']) < count($registrationTransaction->productDetails)) {
                array_splice($registrationTransaction->productDetails, $i + 1);
            }
        } else {
            $registrationTransaction->productDetails = array();
        }

        if (isset($_POST['RegistrationDamage'])) {
            foreach ($_POST['RegistrationDamage'] as $i => $item) {
                if (isset($registrationTransaction->damageDetails[$i])) {
                    $registrationTransaction->damageDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationDamage();
                    $detail->attributes = $item;
                    $registrationTransaction->damageDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationDamage']) < count($registrationTransaction->damageDetails)) {
                array_splice($registrationTransaction->damageDetails, $i + 1);
            }
        } else {
            $registrationTransaction->damageDetails = array();
        }

        if (isset($_POST['RegistrationInsuranceData'])) {
            foreach ($_POST['RegistrationInsuranceData'] as $i => $item) {
                if (isset($registrationTransaction->insuranceDetails[$i])) {
                    $registrationTransaction->insuranceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationInsuranceData();
                    $detail->attributes = $item;
                    $registrationTransaction->insuranceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationInsuranceData']) < count($registrationTransaction->insuranceDetails)) {
                array_splice($registrationTransaction->insuranceDetails, $i + 1);
            }
        } else {
            $registrationTransaction->insuranceDetails = array();
        }


    }

    public function instantiateRegistrationService($id)
    {
        if (empty($id)) {
            $registrationService = new RegistrationServices(new RegistrationService(), array(), array());
            //print_r("test");
        } else {
            //$registrationServiceModel = $this->loadModel($id);
            $registrationServiceModel = RegistrationService::model()->findByAttributes(array('id' => $id));
            $registrationService = new RegistrationServices($registrationServiceModel,
                $registrationServiceModel->registrationServiceEmployees,
                $registrationServiceModel->registrationServiceSupervisors);
        }
        return $registrationService;
    }

    public function loadStateRegistrationService($registrationService)
    {
        if (isset($_POST['RegistrationService'])) {
            $registrationService->header->attributes = $_POST['RegistrationService'];
        }
        if (isset($_POST['RegistrationServiceEmployee'])) {
            foreach ($_POST['RegistrationServiceEmployee'] as $i => $item) {
                if (isset($registrationService->employeeDetails[$i])) {
                    $registrationService->employeeDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationServiceEmployee();
                    $detail->attributes = $item;
                    $registrationService->employeeDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationServiceEmployee']) < count($registrationService->employeeDetails)) {
                array_splice($registrationService->employeeDetails, $i + 1);
            }
        } else {
            $registrationService->employeeDetails = array();
        }

        if (isset($_POST['RegistrationServiceSupervisor'])) {
            foreach ($_POST['RegistrationServiceSupervisor'] as $i => $item) {
                if (isset($registrationService->supervisorDetails[$i])) {
                    $registrationService->supervisorDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationServiceSupervisor();
                    $detail->attributes = $item;
                    $registrationService->supervisorDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationServiceSupervisor']) < count($registrationService->supervisorDetails)) {
                array_splice($registrationService->supervisorDetails, $i + 1);
            }
        } else {
            $registrationService->supervisorDetails = array();
        }
    }


    public function loadModel($id)
    {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    public function actionAjaxCustomer($id)
    {

        if (Yii::app()->request->isAjaxRequest) {
            // $invoice = $this->instantiate($id);
            // $this->loadState($invoice);

            $customer = Customer::model()->findByPk($id);

            $object = array(
                'id' => $customer->id,
                'name' => $customer->name,
                'address' => $customer->address,
                'type' => $customer->customer_type,
                'province' => $customer->province_id,
                'city' => $customer->city_id,
                'zipcode' => $customer->zipcode,
                'email' => $customer->email,
                'rate' => $customer->flat_rate,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxPic($id)
    {

        if (Yii::app()->request->isAjaxRequest) {
            // $invoice = $this->instantiate($id);
            // $this->loadState($invoice);

            $customer_pic = CustomerPic::model()->findByPk($id);

            $object = array(
                'name' => $customer_pic->name,
                'address' => $customer_pic->address,
                'province_name' => $customer_pic->province->name,
                'city_name' => $customer_pic->city->name,
                'province' => $customer_pic->province_id,
                'city' => $customer_pic->city_id,
                'zipcode' => $customer_pic->zipcode,
                'email' => $customer_pic->email,

            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxVehicle($id)
    {

        if (Yii::app()->request->isAjaxRequest) {
            // $invoice = $this->instantiate($id);
            // $this->loadState($invoice);
            $colorName = "";
            $vehicle = Vehicle::model()->findByPk($id);
            $color = Colors::model()->findByPk($vehicle->color_id);
            if (count($color) != 0) {
                $colorName = $color->name;
            }

            $object = array(
                'id' => $vehicle->id,
                'plate' => $vehicle->plate_number,
                'machine' => $vehicle->machine_number,
                'frame' => $vehicle->frame_number,
                'carMake' => $vehicle->car_make_id,
                'carModel' => $vehicle->car_model_id,
                'carSubModel' => $vehicle->car_sub_model_id,
                'carMakeName' => $vehicle->carMake->name,
                'carModelName' => $vehicle->carModel->name,
                'carSubModelName' => $vehicle->carSubModel->name,
                'colorName' => $colorName,
                'color' => $vehicle->color_id,
                'chasis' => $vehicle->chasis_code,
                'power' => $vehicle->power,
                'customer' => $vehicle->customer_id
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetCustomerPic()
    {
        $data = CustomerPic::model()->findAllByAttributes(array('customer_id' => $_POST['RegistrationTransaction']['customer_id']),
            array('order' => 'name ASC'));
        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Customer Pic--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Customer Pic--]', true);
        }
    }

    public function actionAjaxGetCustomerVehicle()
    {
        $data = Vehicle::model()->findAllByAttributes(array('customer_id' => $_POST['RegistrationTransaction']['customer_id']));
        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'plate_number');
            echo CHtml::tag('option', array('value' => ''), '[--Select Vehicle--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Vehicle--]', true);
        }
    }

    public function actionAjaxGetServiceRate()
    {
        //$datas = CustomerServiceRate::model()->findAllByAttributes(array('customer_id'=>$_POST['RegistrationTransaction']['customer_id'])));
        $this->renderPartial('_serviceException', array('customer' => $_POST['RegistrationTransaction']['customer_id']),
            false, true);
    }

    public function actionAjaxGetHistory()
    {
        //$datas = CustomerServiceRate::model()->findAllByAttributes(array('customer_id'=>$_POST['RegistrationTransaction']['customer_id'])));
        $this->renderPartial('_historyTransaction',
            array('customer' => $_POST['RegistrationTransaction']['customer_id']), false, true);
    }

    public function actionAjaxEmployee($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            //$registrationTransaction = $this->instantiate($id);
            $employee = Employee::model()->findByPk($id);
            $name = $employee->name;

            $object = array(
                //'id'=>$supplier->id,
                'name' => $name,

            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxProduct($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);

            $object = array(
                'id' => $product->id,
                'name' => $product->name,
                'retail_price' => $product->retail_price,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxService($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $service = Service::model()->findByPk($id);

            $object = array(
                'id' => $service->id,
                'name' => $service->name,
                'hour' => $service->flat_rate_hour,
            );

            echo CJSON::encode($object);
        }
    }

    /**
     * Performs the AJAX validation.
     * @param RegistrationTransaction $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-transaction-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //Add QuickService
    public function actionAjaxHtmlAddQuickServiceDetail($id, $quickServiceId)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = new Employee('search');
            $employee->unsetAttributes();  // clear any default values
            if (isset($_GET['Employee'])) {
                $employee->attributes = $_GET['Employee'];
            }

            $employeeCriteria = new CDbCriteria;
            //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
            $employeeCriteria->compare('name', $employee->name, true);


            $employeeDataProvider = new CActiveDataProvider('Employee', array(
                'criteria' => $employeeCriteria,
            ));
            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);

            $registrationTransaction->addQuickServiceDetail($quickServiceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailQuickService', array(
                'registrationTransaction' => $registrationTransaction,
                'employee' => $employee,
                'employeeDataProvider' => $employeeDataProvider
            ), false, true);
        }
    }

    public function actionAjaxHtmlAddQsServiceDetail($id, $quickServiceId)
    {
        if (Yii::app()->request->isAjaxRequest) {


            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);

            $registrationTransaction->addQsServiceDetail($quickServiceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailService', array('registrationTransaction' => $registrationTransaction), false,
                true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveQuickServiceDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeQuickServiceDetailAt($index);
            $this->renderPartial('_detailQuickService', array('registrationTransaction' => $registrationTransaction),
                false, true);
        }
    }

    public function actionAjaxHtmlRemoveQuickServiceDetailAll($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeQuickServiceAll();
            $this->renderPartial('_detailQuickService', array('registrationTransaction' => $registrationTransaction),
                false, true);
        }
    }

//Add Service
    public function actionAjaxHtmlAddServiceDetail($id, $serviceId, $customerId, $custType, $vehicleId, $repair)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = new Employee('search');
            $employee->unsetAttributes();  // clear any default values
            if (isset($_GET['Employee'])) {
                $employee->attributes = $_GET['Employee'];
            }

            $employeeCriteria = new CDbCriteria;
            //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
            $employeeCriteria->compare('name', $employee->name, true);


            $employeeDataProvider = new CActiveDataProvider('Employee', array(
                'criteria' => $employeeCriteria,
            ));
            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);

            $registrationTransaction->addServiceDetail($serviceId, $customerId, $custType, $vehicleId, $repair);
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailService', array(
                'registrationTransaction' => $registrationTransaction,
                'employee' => $employee,
                'employeeDataProvider' => $employeeDataProvider
            ), false, true);
        }
    }

    public function actionAjaxHtmlAddServiceInsuranceDetail($id, $serviceId, $insuranceId, $damageType, $repair)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = new Employee('search');
            $employee->unsetAttributes();  // clear any default values
            if (isset($_GET['Employee'])) {
                $employee->attributes = $_GET['Employee'];
            }

            $employeeCriteria = new CDbCriteria;
            //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
            $employeeCriteria->compare('name', $employee->name, true);


            $employeeDataProvider = new CActiveDataProvider('Employee', array(
                'criteria' => $employeeCriteria,
            ));
            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);

            $registrationTransaction->addServiceInsuranceDetail($serviceId, $insuranceId, $damageType, $repair);
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailService', array(
                'registrationTransaction' => $registrationTransaction,
                'employee' => $employee,
                'employeeDataProvider' => $employeeDataProvider
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveServiceDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeServiceDetailAt($index);
            $this->renderPartial('_detailService', array('registrationTransaction' => $registrationTransaction), false,
                true);
        }
    }

    public function actionAjaxHtmlRemoveServiceDetailAll($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeServiceDetailAll();
            $this->renderPartial('_detailService', array('registrationTransaction' => $registrationTransaction), false,
                true);
        }
    }

//Add Product
    public function actionAjaxHtmlAddProductDetail($id, $productId)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = new Employee('search');
            $employee->unsetAttributes();  // clear any default values
            if (isset($_GET['Employee'])) {
                $employee->attributes = $_GET['Employee'];
            }

            $employeeCriteria = new CDbCriteria;
            //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
            $employeeCriteria->compare('name', $employee->name, true);


            $employeeDataProvider = new CActiveDataProvider('Employee', array(
                'criteria' => $employeeCriteria,
            ));
            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);

            $registrationTransaction->addProductDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;

            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailProduct', array(
                'registrationTransaction' => $registrationTransaction,
                'employee' => $employee,
                'employeeDataProvider' => $employeeDataProvider
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveProductDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeProductDetailAt($index);
            $this->renderPartial('_detailProduct', array('registrationTransaction' => $registrationTransaction), false,
                true);
        }
    }

    //Add Product
    public function actionAjaxHtmlAddDamageDetail($id, $repair, $serviceId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            $service = new Service('search');
            $service->unsetAttributes();  // clear any default values
            if (isset($_GET['Service'])) {
                $service->attributes = $_GET['Service'];
            }

            $serviceCriteria = new CDbCriteria;
            //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
            $serviceCriteria->condition .= " code NOT LIKE 'BR-BW-%'";
            $serviceCriteria->compare('name', $service->name, true);
            $serviceCriteria->compare('code', $service->code, true);


            //$serviceCriteria->compare('rate',$service->rate,true);

            $serviceDataProvider = new CActiveDataProvider('Service', array(
                'criteria' => $serviceCriteria,
            ));

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->together = true;
            $productCriteria->with = array('productMasterCategory', 'productSubMasterCategory', 'productSubCategory');
            //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
            $productCriteria->compare('t.name', $product->name, true);
            $productCriteria->compare('productMasterCategory.name', $product->product_master_category_name, true);
            $productCriteria->compare('productSubMasterCategory.name', $product->product_sub_master_category_name,
                true);
            $productCriteria->compare('productSubCategory.name', $product->product_sub_category_name, true);

            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));


            $registrationTransaction->addDamageDetail($serviceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailDamage', array(
                'registrationTransaction' => $registrationTransaction,
                'service' => $service,
                'serviceDataProvider' => $serviceDataProvider,
                'product' => $product,
                'productDataProvider' => $productDataProvider
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveDamageDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {


            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeDamageDetailAt($index);
            $this->renderPartial('_detailDamage', array('registrationTransaction' => $registrationTransaction), false,
                true);
        }
    }

    public function actionAjaxHtmlRemoveDamageDetailAll($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeDamageDetailAll();
            $this->renderPartial('_detailDamage', array('registrationTransaction' => $registrationTransaction), false,
                true);
        }
    }

    //Add Insurance Data
    public function actionAjaxHtmlAddInsuranceDetail($id, $insuranceCompany)
    {
        if (Yii::app()->request->isAjaxRequest) {


            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);

            $registrationTransaction->addInsuranceDetail($insuranceCompany);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailInsurance', array('registrationTransaction' => $registrationTransaction),
                false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveInsuranceDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeInsuranceDetailAt($index);
            $this->renderPartial('_detailInsurance', array('registrationTransaction' => $registrationTransaction),
                false, true);
        }
    }

    public function actionAjaxHtmlRemoveInsuranceDetailAll($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            //print_r(CJSON::encode($salesOrder->details));
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $registrationTransaction->removeInsuranceAll();
            $this->renderPartial('_detailInsurance', array('registrationTransaction' => $registrationTransaction),
                false, true);
        }
    }

    public function actionAjaxEstimateBilling($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);
            
            $totalQs = 0;
            $totalQsPrice = 0;
            $totalService = 0;
            $subtotalService = 0;
            $discountService = 0;
            $totalServicePrice = 0;
            $totalProduct = 0;
            $subtotalProduct = 0;
            $discountProduct = 0;
            $totalProductPrice = 0;
            $grandTotal = 0;
            $jumlahPpn = $jumlahPph = $subtotal = $productPpn = $servicePpn = $qsServicePpn = $servicePph = $qsServicePph = 0;
            $ppn = $_POST['RegistrationTransaction']['ppn'];
            $pph = $_POST['RegistrationTransaction']['pph'];

            // if($requestType == 'Request for Purchase'){
            // 	foreach ($registrationTransaction->details as $key => $detail) {
            // 		$totalItems += $detail->total;
            // 		$total += $detail->subtotal;_quantity;
            // 	}
            // } else if($requestType == 'Request for Transfer'){
            // 	foreach ($registrationTransaction->transferDetails as $key => $transferDetail) {
            // 		$totalItems += $transferDetail->quantity;
            // 	}
            // }
            foreach ($registrationTransaction->quickServiceDetails as $key => $quickServiceDetail) {

                $totalQsPrice += $quickServiceDetail->price;
            }
            foreach ($registrationTransaction->serviceDetails as $key => $serviceDetail) {
                $subtotalService += $serviceDetail->price;
                $discountService += $serviceDetail->discount_price;
                $totalServicePrice += $serviceDetail->total_price;
                $totalService += $serviceDetail->quantity;

            }
            foreach ($registrationTransaction->productDetails as $key => $productDetail) {
                $subtotalProduct += $productDetail->sale_price;
                $discountProduct += $productDetail->discount;
                $totalProductPrice += $productDetail->total_price;
                $totalProduct += $productDetail->quantity;
            }
            $totalQs = count($registrationTransaction->quickServiceDetails);
            $subtotal = $totalQsPrice + $totalServicePrice + $totalProductPrice;
            if ($ppn == 1) {
                $productPpn = $totalProductPrice * 0.1;
                if ($pph == 1) {
                    $servicePph = $totalServicePrice * 0.02;
                    $qsServicePph = $totalQsPrice * 0.02;
                } else {
                    $servicePpn = $totalServicePrice * 0.1;
                    $qsServicePpn = $totalQsPrice * 0.1;

                }
                $jumlahPpn = $productPpn + $servicePpn + $qsServicePpn;
                $jumlahPph = $servicePph + $qsServicePph;


            } else {
                if ($pph == 1) {
                    $servicePph = $totalServicePrice * 0.02;
                    $qsServicePph = $totalQsPrice * 0.02;
                    $jumlahPph = $servicePph + $qsServicePph;
                }
            }
            $grandTotal = $subtotal + $jumlahPpn + $jumlahPph;
            
            $totalQsFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $totalQs));
            $totalQsPriceFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $totalQsPrice));
            $subtotalServiceFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $subtotalService));
            $discountServiceFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $discountService));
            $totalServicePriceFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $totalServicePrice));
            $subtotalProductFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $subtotalProduct));
            $discountProductFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $discountProduct));
            $totalProductPriceFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $totalProductPrice));
            $grandTotalFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $grandTotal));
            $subtotalFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $subtotal));
            $jumlahPpnFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $jumlahPpn));
            $jumlahPphFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $jumlahPph));
            $totalServiceFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $totalService));
            $totalProductFormatted = CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $totalProduct));
            
            $object = array(
                'totalQs' => $totalQs,
                'totalQsPrice' => $totalQsPrice,
                'totalService' => $totalService,
                'subtotalService' => $subtotalService,
                'discountService' => $discountService,
                'totalServicePrice' => $totalServicePrice,
                'subtotalProduct' => $subtotalProduct,
                'discountProduct' => $discountProduct,
                'totalProductPrice' => $totalProductPrice,
                'totalProduct' => $totalProduct,
                'grandTotal' => $grandTotal,
                'subtotal' => $subtotal,
                'ppn' => $jumlahPpn,
                'pph' => $jumlahPph, 
                'totalQsFormatted' => $totalQsFormatted,
                'totalQsPriceFormatted' => $totalQsPriceFormatted,
                'subtotalServiceFormatted' => $subtotalServiceFormatted,
                'discountServiceFormatted' => $discountServiceFormatted,
                'totalServicePriceFormatted' => $totalServicePriceFormatted,
                'subtotalProductFormatted' => $subtotalProductFormatted,
                'subtotalProductFormatted' => $subtotalProductFormatted,
                'discountProductFormatted' => $discountProductFormatted,
                'totalProductPriceFormatted' => $totalProductPriceFormatted,
                'grandTotalFormatted' => $grandTotalFormatted,
                'subtotalFormatted' => $subtotalFormatted,
                'jumlahPpnFormatted' => $jumlahPpnFormatted,
                'jumlahPphFormatted' => $jumlahPphFormatted,
                'totalServiceFormatted' => $totalServiceFormatted,
                'totalProductFormatted' => $totalProductFormatted,
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxCountProduct($quantity, $sale)
    {
        $total = $quantity * $sale;
        $object = array('total' => $total);
        echo CJSON::encode($object);
    }

    public function actionAjaxCheckQuickService($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id);
            $this->loadState($registrationTransaction);

            $count = count($registrationTransaction->quickServiceDetails);
            if ($count > 3) {
                $msg = 0;
            } else {
                $msg = 1;
            }

            $object = array('msg' => $msg);
            echo CJSON::encode($object);
        }

    }

    public function actionAjaxGetCity($index)
    {
        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['RegistrationInsuranceData'][$index]['insured_province_id']),
            array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);

            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }


    }

    public function actionAjaxGetCityDriver($index)
    {
        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['RegistrationInsuranceData'][$index]['driver_province_id']),
            array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);

            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    public function actionAjaxShowPricelist($index, $serviceId, $customerId, $vehicleId, $insuranceId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_price-dialog', array(
                'index' => $index,
                'customer' => $customerId,
                'service' => $serviceId,
                'vehicle' => $vehicleId,
                'insurance' => $insuranceId
            ), false, true);
        }
    }

    public function actionGenerateWorkOrder($id)
    {
        $model = RegistrationTransaction::model()->findByPk($id);

        $model->work_order_number = $model->id . mt_rand();
        $model->work_order_date = date('Y-m-d');
        $model->status = 'Processing';

        if ($model->save()) {
            if ($model->repair_type == 'BR') {
                $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                    'registration_transaction_id' => $id,
                    'name' => 'Work Order'
                ));
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Update When Generate Work Order. WorkOrder#' . $model->work_order_number;
                $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
            } else {
                $real = new RegistrationRealizationProcess();
                $real->registration_transaction_id = $model->id;
                $real->name = 'Work Order';
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Add When Generate Work Order. WorkOrder#' . $model->work_order_number;
                $real->save();
            }

            //$this->redirect(array('view', 'id' => $model->id));
            // $modelDetails = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$id));
            // print_r($modelDetails);
            // foreach ($modelDetails as $i => $modelDetail) {
            // 	$woDetail = new WorkOrderDetail();
            // 	$woDetail->work_order_id = $wo->id;
            // 	$woDetail->service_id = $modelDetail->service_id;
            // 	$woDetail->save();
            // }
        }
    }

    public function actionAjaxHtmlUpdate($id)
    {

        //$head = RegistrationTransaction::model()->findByPk($id);
        $model = RegistrationRealizationProcess::model()->findByPk($id);

        $realizationImages = RegistrationRealizationImages::model()->findAllByAttributes(array(
            'registration_realization_id' => $model->id,
            'is_inactive' => $model::STATUS_ACTIVE
        ));
        $countPostImage = count($realizationImages);
        $maxImage = 10;
        $allowedImages = $maxImage - $countPostImage;

        if (isset($_POST['RegistrationRealizationProcess'])) {
            $images = $model->images = CUploadedFile::getInstances($model, 'images');
            $model->checked = $_POST['RegistrationRealizationProcess']['checked'];
            $model->checked_by = 1;
            $model->checked_date = date('Y-m-d');
            $model->detail = $_POST['RegistrationRealizationProcess']['detail'];

            if ($model->update(array('checked', 'checked_by', 'checked_date', 'detail'))) {
                if (isset($images) && !empty($images)) {
                    foreach ($model->images as $i => $image) {
                        $realizationImage = new RegistrationRealizationImages;
                        $realizationImage->registration_realization_id = $model->id;

                        $realizationImage->extension = $image->extensionName;
                        $realizationImage->is_inactive = $model::STATUS_ACTIVE;
                        if ($realizationImage->save()) {
                            if ($model->name == 'Epoxy') {

                                $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/epoxy/' . $model->id;
                            } else {
                                $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/after_service/' . $model->id;
                            }

                            if (!file_exists($dir)) {
                                mkdir($dir, 0777, true);
                            }
                            $path = $dir . '/' . $realizationImage->filename;
                            $image->saveAs($path);
                            $picture = Yii::app()->image->load($path);
                            $picture->save();

                            $thumb = Yii::app()->image->load($path);
                            $thumb_path = $dir . '/' . $realizationImage->thumbname;
                            $thumb->save($thumb_path);

                            $square = Yii::app()->image->load($path);
                            $square_path = $dir . '/' . $realizationImage->squarename;
                            $square->save($square_path);

                        }
                        echo $image->extensionName;

                    }
                }
                $this->redirect(array('showRealization', 'id' => $model->registration_transaction_id));
            }
        }

        $this->render('updateReal', array(
            'model' => $model,
            'realizationImages' => $realizationImages,
            'allowedImages' => $allowedImages,
            //'head' => $head,
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));

    }

    public function actionShowRealization($id)
    {
        $head = RegistrationTransaction::model()->findByPk($id);
        $reals = RegistrationRealizationProcess::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $this->render('realization', array(
            'head' => $head,
            'reals' => $reals,
        ));
    }

    public function actionUpdateSpk($id)
    {

        //$head = RegistrationTransaction::model()->findByPk($id);
        $model = RegistrationInsuranceData::model()->findByPk($id);


        if (isset($_POST['RegistrationInsuranceData'])) {
            $featured_image = $model->featured_image = CUploadedFile::getInstance($model, 'featured_image');

            if (isset($featured_image) && !empty($featured_image)) {
                $model->spk_insurance = $featured_image->extensionName;

            }
            if ($model->save()) {
                $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                    'registration_transaction_id' => $model->registration_transaction_id,
                    'name' => 'SPK'
                ));
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Update When Upload SPK Image';
                $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

                if (isset($featured_image) && !empty($featured_image)) {
                    //$this->redirect(array('test'));
                    //$this->redirect(array(Yii::app()->request->scriptFile . '/images/uploads/post/' . $model->id));
                    $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/' . $model->id;
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $path = $dir . '/' . $model->Featuredname;
                    $featured_image->saveAs($path);
                    $picture = Yii::app()->image->load($path);

                    $picture->save();
                }
                $this->redirect(array('view', 'id' => $model->registration_transaction_id));
            }


        }

        $this->render('updateSpk', array(
            'model' => $model,
            //'head' => $head,
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));

    }

    public function actionUpdateImages($id)
    {
        $model = RegistrationInsuranceData::model()->findByPk($id);

        $insuranceImages = RegistrationInsuranceImages::model()->findAllByAttributes(array(
            'registration_insurance_data_id' => $model->id,
            'is_inactive' => $model::STATUS_ACTIVE
        ));
        $countPostImage = count($insuranceImages);
        $maxImage = 10;
        $allowedImages = $maxImage - $countPostImage;


        $images = $model->images = CUploadedFile::getInstances($model, 'images');
        //print_r($images);
        if (isset($images) && !empty($images)) {
            foreach ($model->images as $i => $image) {
                $insuranceImage = new RegistrationInsuranceImages;
                $insuranceImage->registration_insurance_data_id = $model->id;

                $insuranceImage->extension = $image->extensionName;
                $insuranceImage->is_inactive = $model::STATUS_ACTIVE;
                if ($insuranceImage->save()) {
                    $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $model->id;

                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $path = $dir . '/' . $insuranceImage->filename;
                    $image->saveAs($path);
                    $picture = Yii::app()->image->load($path);
                    $picture->save();

                    $thumb = Yii::app()->image->load($path);
                    $thumb_path = $dir . '/' . $insuranceImage->thumbname;
                    $thumb->save($thumb_path);

                    $square = Yii::app()->image->load($path);
                    $square_path = $dir . '/' . $insuranceImage->squarename;
                    $square->save($square_path);
                    $this->redirect(array('view', 'id' => $model->registration_transaction_id));
                }
                echo $image->extensionName;

            }
            //print_r($images);
        }

        $this->render('updateImages', array(
            'model' => $model,
            'insuranceImages' => $insuranceImages,
            'allowedImages' => $allowedImages,
            //'head' => $head,
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));
    }

    public function actionDeleteImage($id)
    {
        $model = RegistrationInsuranceImages::model()->findByPk($id);
        $model->scenario = 'delete';

        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $model->registrationInsuranceData->id . '/' . $model->filename;
        $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $model->registrationInsuranceData->id . '/' . $model->thumbname;
        $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $model->registrationInsuranceData->id . '/' . $model->squarename;

        if (file_exists($dir)) {
            unlink($dir);
        }
        if (file_exists($dir_thumb)) {
            unlink($dir_thumb);
        }
        if (file_exists($dir_square)) {
            unlink($dir_square);
        }

        $model->is_inactive = 1;
        $model->update(array('is_inactive'));

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionDeleteFeatured($id)
    {
        $model = RegistrationInsuranceData::model()->findByPk($id);
        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/' . $model->id . '/' . $model->featuredname;
        if (file_exists($dir)) {
            unlink($dir);
        }

        $model->spk_insurance = null;
        $model->update(array('spk_insurance'));
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionDeleteImageRealization($id)
    {
        $model = RegistrationRealizationImages::model()->findByPk($id);
        $model->scenario = 'delete';

        if ($model->registrationRealization->name == 'Epoxy') {
            $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/epoxy/' . $model->registrationRealization->id . '/' . $model->filename;
            $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/epoxy/' . $model->registrationRealization->id . '/' . $model->thumbname;
            $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/epoxy/' . $model->registrationRealization->id . '/' . $model->squarename;
        } else {
            $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/after_service/' . $model->registrationRealization->id . '/' . $model->filename;
            $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/after_service/' . $model->registrationRealization->id . '/' . $model->thumbname;
            $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/after_service/' . $model->registrationRealization->id . '/' . $model->squarename;
        }


        if (file_exists($dir)) {
            unlink($dir);
        }
        if (file_exists($dir_thumb)) {
            unlink($dir_thumb);
        }
        if (file_exists($dir_square)) {
            unlink($dir_square);
        }

        $model->is_inactive = 1;
        $model->update(array('is_inactive'));

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionBillDetail($registrationId)
    {
        $model = $this->loadModel($registrationId);
        //$registrationData = RegistrationTransaction::model()->findByPk($registrationId);
        $registrationServices = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $model->id,
            'is_body_repair' => 0
        ));
        $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $model->id));
        $registrationQuickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $model->id));
        
        $payment = new PaymentIn;
        $payment->branch_id = $payment->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $payment->branch_id;
        $payment->payment_date = date('Y-m-d');
        $payment->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($payment->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($payment->payment_date)), $payment->branch_id);
        // if(isset($_POST['PaymentIn']))
        // {
        // 	$payment->attributes=$_POST['PaymentIn'];
        // 	var_dump($payment);
        // 	// if($payment->save())
        // 	// 	$this->redirect(array('view','id'=>$model->id));
        // }
        if (isset($_POST['PaymentIn'])) {
            $payment->attributes = $_POST['PaymentIn'];

            // var_dump($payment->attributes); die;

            $payment->status = "CLEAR";
//            $payment->branch_id = 1;
            // var_dump($payment->branch_id); die;

            if ($payment->save(false)) {
                $criteria = new CDbCriteria;

                $criteria->condition = "invoice_id =" . $payment->invoice_id . " AND id != " . $payment->id;
                $paymentIn = PaymentIn::model()->findAll($criteria);
                // $payment = PaymentIn::model()->findAllByAttributes(array('invoice_id'=>$model->invoice_id));
                $invoiceData = InvoiceHeader::model()->findByPk($payment->invoice_id);

                if (count($paymentIn) == 0) {
                    $countTotal = $invoiceData->total_price - $payment->payment_amount;
                    $paymentTotal = $payment->payment_amount;
                } else {
                    $countTotal = $invoiceData->payment_left - $payment->payment_amount;
                    $paymentTotal = $invoiceData->payment_amount + $payment->payment_amount;
                }

                if ($countTotal != 0) {
                    $invoiceData->status = 'PARTIAL PAYMENT';
                } elseif ($countTotal == 0) {
                    $invoiceData->status = 'CLEAR';
                } else {
                    $invoiceData->status = 'NOT PAID';
                }

                $invoiceData->payment_amount = $paymentTotal;
                $invoiceData->payment_left = $countTotal;
                $invoiceData->save(false);
                $this->redirect(array('billDetail', 'registrationId' => $registrationId));
            }
        }
        
        $this->render('billDetail', array(
            'model' => $model,
            //'registrationData'=>$registrationData,
            'registrationServices' => $registrationServices,
            'registrationProducts' => $registrationProducts,
            'registrationQuickServices' => $registrationQuickServices,
            'payment' => $payment,

        ));
    }

    public function actionCustomerData($customerId)
    {
        $customer = Customer::model()->findByPk($customerId);
        $this->renderPartial('_customerData', array('customer' => $customer, false, true));
    }

    public function actionVehicleData($vehicleId)
    {
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $this->renderPartial('_vehicleData', array('vehicle' => $vehicle, false, true));
    }

    public function actionCustomerWaitlist()
    {
        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $modelDataProvider = $model->search();
        $modelDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL");

        $modelCriteria = new CDbCriteria;
        $modelCriteria->addCondition("work_order_number != ''");
        $models = RegistrationTransaction::model()->findAll($modelCriteria);

        $services = Service::model()->findAll();
        $epoxyId = $paintId = $finishId = $dempulId = $washingId = $openingId = '';
        foreach ($services as $key => $service) {
            if ($service->name == 'Epoxy') {
                $epoxyId = $service->id;
            }
            
            if ($service->name == 'Cat') {
                $paintId = $service->id;
            }
            
            if ($service->name == 'Finishing') {
                $finishId = $service->id;
            }
            
            if ($service->name == 'Dempul') {
                $dempulId = $service->id;
            }
            
            if ($service->name == 'Cuci') {
                $washingId = $service->id;
            }
            
            if ($service->name == 'Bongkar') {
                $openingId = $service->id;
            }
        }

        $tbaId = 3; //3 is service TBA
        
        $modelGR = new CDbCriteria;
        $modelGR->compare("repair_type", 'GR');
        $modelGR->addCondition("work_order_number != ''");
        if (isset($_GET['RegistrationTransaction'])) {
            $modelGR->compare('name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelGR->compare('customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelGR->compare('repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelGR->compare('branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelGR->compare('status', $_GET['RegistrationTransaction']['status'], true);
        }

        // epoxy
        $modelEpoxyCriteria = new CDbCriteria;
        $modelEpoxyCriteria->compare("service_id", $epoxyId);
        $modelEpoxyCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelEpoxyCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelEpoxyCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelEpoxyCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modelEpoxyCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modelEpoxyCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modelEpoxyCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }
        // end expoxy

        // paint
        $modelpaintCriteria = new CDbCriteria;
        $modelpaintCriteria->compare("service_id", $paintId);
        $modelpaintCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelpaintCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelpaintCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelpaintCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modelpaintCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modelpaintCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modelpaintCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelpaintCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }
        // end paint

        // finish
        $modelfinishingCriteria = new CDbCriteria;
        $modelfinishingCriteria->compare("service_id", $finishId);
        $modelfinishingCriteria->with = array(
            'registrationTransaction' => array(
                'with' => array(
                    'customer',
                    'vehicle'
                )
            ),
            'service',
            'registrationServiceEmployees'
        );
        $modelfinishingCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelfinishingCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelfinishingCriteria->compare('customer.customer_type',
                $_GET['RegistrationTransaction']['customer_type'], true);
            $modelfinishingCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modelfinishingCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            // $modelfinishingCriteria->compare('registrationTransaction.transaction_date',$_GET['RegistrationTransaction']['date_repair'],TRUE);
            $modelfinishingCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelfinishingCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }
        // end finish

        // dempul
        $modeldempulCriteria = new CDbCriteria;
        $modeldempulCriteria->compare("service_id", $dempulId);
        $modeldempulCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modeldempulCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modeldempulCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modeldempulCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modeldempulCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modeldempulCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modeldempulCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modeldempulCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }
        // end dempul

        $modelwashingCriteria = new CDbCriteria;
        $modelwashingCriteria->compare("service_id", $washingId);
        $modelwashingCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelwashingCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelwashingCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelwashingCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modelwashingCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modelwashingCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modelwashingCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelwashingCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $modelopeningCriteria = new CDbCriteria;
        $modelopeningCriteria->compare("service_id", $openingId);
        $modelopeningCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelopeningCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelopeningCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelopeningCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modelopeningCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modelopeningCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modelopeningCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelopeningCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $modeltbaCriteria = new CDbCriteria;
        $modeltbaCriteria->compare("service_id", $tbaId);
        $modeltbaCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modeltbaCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modeltbaCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modeltbaCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modeltbaCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modeltbaCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modeltbaCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modeltbaCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $modelgrCriteria = new CDbCriteria;
        $modelgrCriteria->compare("repair_type", 'GR');
        $modelgrCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelgrCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelgrCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelgrCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modelgrCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelgrCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }


        $oiltype = 4;
        $oiltypes = Service::model()->findAllByAttributes(array('service_type_id' => $oiltype));
        $arrayOil = CHtml::listData($oiltypes, 'id', function ($oiltypes) {
            return $oiltypes->id;
        });
        $modelgrOilCriteria = new CDbCriteria;
        $modelgrOilCriteria->addInCondition("service_id", $arrayOil);
        $modelgrOilCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelgrOilCriteria->together = true;
        if (isset($_GET['RegistrationTransaction'])) {
            $modelgrOilCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelgrOilCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modelgrOilCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrOilCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrOilCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelgrOilCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $wash = 5;
        $washs = Service::model()->findAllByAttributes(array('service_type_id' => $wash));
        $arrayWash = CHtml::listData($washs, 'id', function ($washs) {
            return $washs->id;
        });
        $modelgrWashCriteria = new CDbCriteria;
        $modelgrWashCriteria->addInCondition("service_id", $arrayWash);
        $modelgrWashCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelgrWashCriteria->together = true;
        if (isset($_GET['RegistrationTransaction'])) {
            $modelgrWashCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelgrWashCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'],
                true);
            $modelgrWashCriteria->compare('registrationTransaction.repair_type',
                $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrWashCriteria->compare('registrationTransaction.branch_id',
                $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrWashCriteria->addBetweenCondition('registrationTransaction.transaction_date',
                $_GET['RegistrationTransaction']['transaction_date_from'],
                $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelgrWashCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $epoxyDatas = $this->getDataProviderTimecounter($modelEpoxyCriteria);
        $paintDatas = $this->getDataProviderTimecounter($modelpaintCriteria);
        $finishingDatas = $this->getDataProviderTimecounter($modelfinishingCriteria);
        $dempulDatas = $this->getDataProviderTimecounter($modeldempulCriteria);
        $washingDatas = $this->getDataProviderTimecounter($modelwashingCriteria);
        $openingDatas = $this->getDataProviderTimecounter($modelopeningCriteria);
        $tbaDatas = $this->getDataProviderTimecounter($modeltbaCriteria);
        $grDatas = $this->getDataProviderTimecounter($modelgrCriteria);
        $grOilDatas = $this->getDataProviderTimecounter($modelgrOilCriteria);
        $grWashDatas = $this->getDataProviderTimecounter($modelgrWashCriteria);

        $this->render('customerWaitlist', array(
            'model' => $model,
            'models' => $models,
            'modelDataProvider' => $modelDataProvider,
            'epoxyDatas' => $epoxyDatas,
            'paintDatas' => $paintDatas,
            'finishingDatas' => $finishingDatas,
            'dempulDatas' => $dempulDatas,
            'washingDatas' => $washingDatas,
            'openingDatas' => $openingDatas,
            'tbaDatas' => $tbaDatas,
            'grDatas' => $grDatas,
            'grOilDatas' => $grOilDatas,
            'grWashDatas' => $grWashDatas,
        ));
    }

	public function actionAjaxHtmlUpdateWaitlistTable()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RegistrationTransaction('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['RegistrationTransaction'])) {
                $model->attributes = $_GET['RegistrationTransaction'];
            }

            $modelDataProvider = $model->search();
            $modelDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL");

            $this->renderPartial('_waitlistTable', array(
                'model' => $model,
                'modelDataProvider' => $modelDataProvider,
            ));
        }
    }
    
    public function getDataProviderTimecounter($modelCriteria)
    {
        $cri = new CActiveDataProvider('RegistrationService', array(
            'criteria' => $modelCriteria,
            'sort' => array(
                'defaultOrder' => 'registrationTransaction.vehicle_id',
                'attributes' => array(
                    'customer_name' => array(
                        'asc' => 'customer.name ASC',
                        'desc' => 'customer.name DESC',
                    ),
                    'pic_name' => array(
                        'asc' => 'pic.name ASC',
                        'desc' => 'pic.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        
        return $cri;
    }

    public function actionGetMaterial($serviceId)
    {
        $first = true;
        $rec = "";

        $materials = ServiceMaterial::model()->findAllByAttributes(array('service_id' => $serviceId));
        foreach ($materials as $material) {
            $product = Product::model()->findByPk($material->product_id);
            if ($first === true) {
                $first = false;
            } else {
                $rec .= ', ';
            }
            $rec .= $product->name;

        }
        //echo $rec;
        $object = array('rec' => $rec);
        echo CJSON::encode($object);
    }

    public function actionGenerateInvoice($id)
    {
        $registration = RegistrationTransaction::model()->findByPK($id);
        $customer = Customer::model()->findByPk($registration->customer_id);
        $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $registration->id));
        $branch = Branch::model()->findByPk($registration->branch_id);
        foreach ($invoices as $invoice) {
            $invoice->status = "CANCELLED";
            $invoice->save(false);
        }
        $days =
            // $duedate = date('Y-m-d', strtotime('+'.$days.' days'));
            // $nextmonth = date('Y-m-d',strtotime('+1 months'));
        $duedate = $customer->tenor != "" ? date('Y-m-d', strtotime("+" . $customer->tenor . " days")) : date('Y-m-d',
            strtotime("+1 months"));
        $invoiceHeader = InvoiceHeader::model()->findAll();
        $count = count($invoiceHeader) + 1;
        $model = new InvoiceHeader();
//        $model->invoice_number = 'INV_' . $count;
        $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($registration->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registration->transaction_date)), $registration->branch_id);
        $model->invoice_date = date('Y-m-d');
        $model->due_date = $duedate;
        $model->reference_type = 2;
        $model->registration_transaction_id = $id;
        $model->customer_id = $registration->customer_id;
        $model->vehicle_id = $registration->vehicle_id;
        $model->branch_id = $registration->branch_id == "" ? 1 : $registration->branch_id;
        $model->user_id = Yii::app()->user->getId();
        $model->status = "INVOICING";
        $model->total_product = $registration->total_product;
        $model->total_service = $registration->total_service;
        $model->total_quick_service = $registration->total_quickservice;
        $model->service_price = $registration->total_service_price;
        $model->product_price = $registration->total_product_price;
        $model->quick_service_price = $registration->total_quickservice_price;
        $model->total_price = $registration->grand_total;
        $model->payment_left = $registration->grand_total;
        $model->payment_amount = 0;
        $model->ppn_total = $registration->ppn_price;
        $model->pph_total = $registration->pph_price;
        $model->ppn = $registration->ppn;
        $model->pph = $registration->pph;
        //$model->save(false);
        if ($model->save(false)) {
            $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
            if (count($registrationProducts) != 0) {
                foreach ($registrationProducts as $registrationProduct) {
                    $modelDetail = new InvoiceDetail();
                    $modelDetail->invoice_id = $model->id;
                    $modelDetail->product_id = $registrationProduct->product_id;
                    $modelDetail->quantity = $registrationProduct->quantity;
                    $modelDetail->unit_price = $registrationProduct->sale_price;
                    $modelDetail->total_price = $registrationProduct->total_price;
                    $modelDetail->save(false);
                }//end foreach
            } // end if count
            $registrationServices = RegistrationService::model()->findAllByAttributes(array(
                'registration_transaction_id' => $id,
                'is_quick_service' => 0
            ));
            if (count($registrationServices) != 0) {
                foreach ($registrationServices as $registrationService) {
                    $modelDetail = new InvoiceDetail();
                    $modelDetail->invoice_id = $model->id;
                    $modelDetail->service_id = $registrationService->service_id;
                    $modelDetail->unit_price = $registrationService->price;
                    $modelDetail->total_price = $registrationService->total_price;
                    $modelDetail->save(false);
                }
            }
            $registrationQuickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $id));
            if (count($registrationQuickServices) != 0) {
                foreach ($registrationQuickServices as $registrationQuickService) {
                    $modelDetail = new InvoiceDetail();
                    $modelDetail->invoice_id = $model->id;
                    $modelDetail->quick_service_id = $registrationQuickService->quick_service_id;
                    $modelDetail->unit_price = $registrationQuickService->price;
                    $modelDetail->total_price = $registrationQuickService->price;
                    $modelDetail->save(false);
                }
            }
            
            /*SAVE TO JOURNAL*/
            $jurnalUmumPiutang = new JurnalUmum;
            $jurnalUmumPiutang->kode_transaksi = $registration->transaction_number;
            $jurnalUmumPiutang->tanggal_transaksi = $registration->transaction_date;
            $jurnalUmumPiutang->coa_id = $registration->customer->coa_id;
            $jurnalUmumPiutang->branch_id = $registration->branch_id;
            $jurnalUmumPiutang->total = $registration->grand_total;
            $jurnalUmumPiutang->debet_kredit = 'D';
            $jurnalUmumPiutang->tanggal_posting = date('Y-m-d');
            $jurnalUmumPiutang->save();

            foreach ($registration->registrationProducts as $key => $rProduct) {

//                $getCoaPiutang = $branch->coa_prefix . '.105.000';
//                $coaPiutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPiutang));

                // save product master category coa hpp
//                $coaMasterHpp = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaHpp->id);
//                $getCoaMasterHpp = $branch->coa_prefix . '.' . $coaMasterHpp->code;
//                $coaMasterHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterHpp));
//                $jurnalUmumMasterHpp = new JurnalUmum;
//                $jurnalUmumMasterHpp->kode_transaksi = $registration->transaction_number;
//                $jurnalUmumMasterHpp->tanggal_transaksi = $registration->transaction_date;
//                $jurnalUmumMasterHpp->coa_id = $coaMasterHppWithCode->id;
//                $jurnalUmumMasterHpp->branch_id = $registration->branch_id;
//                $jurnalUmumMasterHpp->total = $rProduct->quantity * $rProduct->hpp;
//                $jurnalUmumMasterHpp->debet_kredit = 'D';
//                $jurnalUmumMasterHpp->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterHpp->save();

                // save product sub master category coa hpp
                $coaHpp = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaHpp->id);
                $getCoaHpp = $branch->coa_prefix . '.' . $coaHpp->code;
                $coaHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHpp));
                $jurnalUmumHpp = new JurnalUmum;
                $jurnalUmumHpp->kode_transaksi = $registration->transaction_number;
                $jurnalUmumHpp->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumHpp->coa_id = $coaHppWithCode->id;
                $jurnalUmumHpp->branch_id = $registration->branch_id;
                $jurnalUmumHpp->total = $rProduct->quantity * $rProduct->hpp;
                $jurnalUmumHpp->debet_kredit = 'D';
                $jurnalUmumHpp->tanggal_posting = date('Y-m-d');
                $jurnalUmumHpp->save();

                // save product master coa diskon penjualan
                $coaMasterDiskon = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaDiskonPenjualan->id);
                $getCoaMasterDiskon = $branch->coa_prefix . '.' . $coaMasterDiskon->code;
                $coaMasterDiskonWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterDiskon));
                $jurnalUmumMasterDiskon = new JurnalUmum;
                $jurnalUmumMasterDiskon->kode_transaksi = $registration->transaction_number;
                $jurnalUmumMasterDiskon->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumMasterDiskon->coa_id = $coaMasterDiskonWithCode->id;
                $jurnalUmumMasterDiskon->branch_id = $registration->branch_id;
                $jurnalUmumMasterDiskon->total = $rProduct->discount;
                $jurnalUmumMasterDiskon->debet_kredit = 'D';
                $jurnalUmumMasterDiskon->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterDiskon->save();

                // save product sub master coa diskon penjualan
                $coaDiskon = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaDiskonPenjualan->id);
                $getCoaDiskon = $branch->coa_prefix . '.' . $coaDiskon->code;
                $coaDiskonWithCode = Coa::model()->findByAttributes(array('code' => $getCoaDiskon));
                $jurnalUmumDiskon = new JurnalUmum;
                $jurnalUmumDiskon->kode_transaksi = $registration->transaction_number;
                $jurnalUmumDiskon->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumDiskon->coa_id = $coaDiskonWithCode->id;
                $jurnalUmumDiskon->branch_id = $registration->branch_id;
                $jurnalUmumDiskon->total = $rProduct->discount;
                $jurnalUmumDiskon->debet_kredit = 'D';
                $jurnalUmumDiskon->tanggal_posting = date('Y-m-d');
                $jurnalUmumDiskon->save();

                //K

                //save product master category coa penjualan barang
                $coaMasterPenjualan = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaPenjualanBarangDagang->id);
                $getCoaMasterPenjualan = $branch->coa_prefix . '.' . $coaMasterPenjualan->code;
                $coaMasterPenjualanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterPenjualan));
                $jurnalUmumMasterPenjualan = new JurnalUmum;
                $jurnalUmumMasterPenjualan->kode_transaksi = $registration->transaction_number;
                $jurnalUmumMasterPenjualan->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumMasterPenjualan->coa_id = $coaMasterPenjualanWithCode->id;
                $jurnalUmumMasterPenjualan->branch_id = $registration->branch_id;
                $jurnalUmumMasterPenjualan->total = $rProduct->total_price;
                $jurnalUmumMasterPenjualan->debet_kredit = 'K';
                $jurnalUmumMasterPenjualan->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterPenjualan->save();

                //save product sub master category coa penjualan barang
                $coaPenjualan = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaPenjualanBarangDagang->id);
                $getCoaPenjualan = $branch->coa_prefix . '.' . $coaPenjualan->code;
                $coaPenjualanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPenjualan));
                $jurnalUmumPenjualan = new JurnalUmum;
                $jurnalUmumPenjualan->kode_transaksi = $registration->transaction_number;
                $jurnalUmumPenjualan->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumPenjualan->coa_id = $coaPenjualanWithCode->id;
                $jurnalUmumPenjualan->branch_id = $registration->branch_id;
                $jurnalUmumPenjualan->total = $rProduct->total_price;
                $jurnalUmumPenjualan->debet_kredit = 'K';
                $jurnalUmumPenjualan->tanggal_posting = date('Y-m-d');
                $jurnalUmumPenjualan->save();

                //save product master coa inventory
                $coaMasterInventory = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaInventoryInTransit->id);
                $getCoaMasterInventory = $branch->coa_prefix . '.' . $coaMasterInventory->code;
                $coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterInventory));
                $jurnalUmumMasterInventory = new JurnalUmum;
                $jurnalUmumMasterInventory->kode_transaksi = $registration->transaction_number;
                $jurnalUmumMasterInventory->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumMasterInventory->coa_id = $coaMasterInventoryWithCode->id;
                $jurnalUmumMasterInventory->branch_id = $registration->branch_id;
                $jurnalUmumMasterInventory->total = $rProduct->quantity * $rProduct->hpp;
                $jurnalUmumMasterInventory->debet_kredit = 'K';
                $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterInventory->save();

                //save product sub master coa inventory
                $coaInventory = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaInventoryInTransit->id);
                $getCoaInventory = $branch->coa_prefix . '.' . $coaInventory->code;
                $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
                $jurnalUmumInventory = new JurnalUmum;
                $jurnalUmumInventory->kode_transaksi = $registration->transaction_number;
                $jurnalUmumInventory->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumInventory->coa_id = $coaInventoryWithCode->id;
                $jurnalUmumInventory->branch_id = $registration->branch_id;
                $jurnalUmumInventory->total = $rProduct->quantity * $rProduct->hpp;
                $jurnalUmumInventory->debet_kredit = 'K';
                $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                $jurnalUmumInventory->save();
            }
            foreach ($registration->registrationServices as $key => $rService) {
                $price = $rService->is_quick_service == 1 ? $rService->price : $rService->total_price;
                //D
//                $getCoaPiutang = $branch->coa_prefix . '.105.000';
//                $coaPiutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPiutang));
//                $jurnalUmumPiutang = new JurnalUmum;
//                $jurnalUmumPiutang->kode_transaksi = $registration->transaction_number;
//                $jurnalUmumPiutang->tanggal_transaksi = $registration->transaction_date;
////                $jurnalUmumPiutang->coa_id = $coaPiutangWithCode->id;
//                $jurnalUmumPiutang->coa_id = $registration->customer->coa_id;
//                $jurnalUmumPiutang->branch_id = $registration->branch_id;
//                $jurnalUmumPiutang->total = $price;
//                $jurnalUmumPiutang->debet_kredit = 'D';
//                $jurnalUmumPiutang->tanggal_posting = date('Y-m-d');
//                $jurnalUmumPiutang->save();

                //K
                // save service type coa
                $coaGroupPendapatanJasa = Coa::model()->findByPk($rService->service->serviceType->coa_id);
                $getCoaGroupPendapatanJasa = $branch->coa_prefix . '.' . $coaGroupPendapatanJasa->code;
                $coaGroupPendapatanJasaWithCode = Coa::model()->findByAttributes(array('code' => $getCoaGroupPendapatanJasa));
                $jurnalUmumGroupPendapatanJasa = new JurnalUmum;
                $jurnalUmumGroupPendapatanJasa->kode_transaksi = $registration->transaction_number;
                $jurnalUmumGroupPendapatanJasa->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumGroupPendapatanJasa->coa_id = $coaGroupPendapatanJasaWithCode->id;
                $jurnalUmumGroupPendapatanJasa->branch_id = $registration->branch_id;
                $jurnalUmumGroupPendapatanJasa->total = $price;
                $jurnalUmumGroupPendapatanJasa->debet_kredit = 'K';
                $jurnalUmumGroupPendapatanJasa->tanggal_posting = date('Y-m-d');
                $jurnalUmumGroupPendapatanJasa->save();

                //save service category coa
                $coaPendapatanJasa = Coa::model()->findByPk($rService->service->serviceCategory->coa_id);
                $getCoaPendapatanJasa = $branch->coa_prefix . '.' . $coaPendapatanJasa->code;
                $coaPendapatanJasaWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPendapatanJasa));
                $jurnalUmumPendapatanJasa = new JurnalUmum;
                $jurnalUmumPendapatanJasa->kode_transaksi = $registration->transaction_number;
                $jurnalUmumPendapatanJasa->tanggal_transaksi = $registration->transaction_date;
                $jurnalUmumPendapatanJasa->coa_id = $coaPendapatanJasaWithCode->id;
                $jurnalUmumPendapatanJasa->branch_id = $registration->branch_id;
                $jurnalUmumPendapatanJasa->total = $price;
                $jurnalUmumPendapatanJasa->debet_kredit = 'K';
                $jurnalUmumPendapatanJasa->tanggal_posting = date('Y-m-d');
                $jurnalUmumPendapatanJasa->save();

            }

        }// end if model save
        if (count($invoices) > 0) {
            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registration->id,
                'name' => 'Invoice'
            ));
            if (count($real) != 0) {
                $real->checked_date = date('Y-m-d');
                $real->detail = 'ReGenerate Invoice with number #' . $model->invoice_number;
                $real->save(false);
            } else {
                $real = new RegistrationRealizationProcess();
                $real->registration_transaction_id = $registration->id;
                $real->name = 'Invoice';
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Generate Invoice with number #' . $model->invoice_number;
                $real->save();
            }

        } else {
            $real = new RegistrationRealizationProcess();
            $real->registration_transaction_id = $registration->id;
            $real->name = 'Invoice';
            $real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->getId();
            $real->detail = 'Generate Invoice with number #' . $model->invoice_number;
            $real->save();
        }

    }

    public function actionGenerateSalesOrder($id)
    {
        $model = RegistrationTransaction::model()->findByPk($id);

        $model->sales_order_number = 'RS_' . $model->id . mt_rand();
        $model->sales_order_date = date('Y-m-d');


        if ($model->save()) {

            $real = new RegistrationRealizationProcess();
            $real->registration_transaction_id = $model->id;
            $real->name = 'Sales Order';
            $real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->getId();
            $real->detail = 'Generate Sales Order with number #' . $model->sales_order_number;
            $real->save();

        }
    }

    public function actionReceive($movementOutDetailId, $registrationProductId, $quantity)
    {
        //$quantity = 0;

        $registrationProduct = RegistrationProduct::model()->findByPk($registrationProductId);
        $registration = RegistrationTransaction::model()->findByPk($registrationProduct->registration_transaction_id);
        $movementOutDetail = MovementOutDetail::model()->findByPk($movementOutDetailId);
        $movementOut = MovementOutHeader::model()->findByPk($movementOutDetail->movement_out_header_id);

        $receiveHeader = new TransactionReceiveItem();
        $receiveHeader->receive_item_no = 'RI_' . $registration->id . mt_rand();
        $receiveHeader->receive_item_date = date('Y-m-d');
        $receiveHeader->arrival_date = date('Y-m-d');
        $receiveHeader->recipient_id = Yii::app()->user->getId();
        $receiveHeader->recipient_branch_id = $registration->branch_id;
        $receiveHeader->request_type = 'Retail Sales';
        $receiveHeader->request_date = $movementOut->date_posting;
        $receiveHeader->destination_branch = $registration->branch_id;
        $receiveHeader->movement_out_id = $movementOut->id;
        if ($receiveHeader->save(false)) {
            $receiveDetail = new TransactionReceiveItemDetail();
            $receiveDetail->receive_item_id = $receiveHeader->id;
            $receiveDetail->movement_out_detail_id = $movementOutDetail->id;
            $receiveDetail->product_id = $registrationProduct->product_id;
            $receiveDetail->qty_request = $registrationProduct->quantity;
            $receiveDetail->qty_received = $quantity;
            // $receiveDetail->save(false);
            if ($receiveDetail->save(false)) {

                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('receiveItem');
                $criteria->condition = "receiveItem.movement_out_id =" . $movementOut->id . " AND receive_item_id != " . $receiveHeader->id;
                $receiveItemDetails = TransactionReceiveItemDetail::model()->findAll($criteria);

                $quantity = 0;
                //print_r($receiveItemDetails);
                foreach ($receiveItemDetails as $receiveItemDetail) {
                    $quantity += $receiveItemDetail->qty_received;

                }

                $moveOutDetail = MovementOutDetail::model()->findByAttributes(array(
                    'id' => $movementOutDetailId,
                    'movement_out_header_id' => $movementOut->id
                ));

                $moveOutDetail->quantity_receive_left = $moveOutDetail->quantity - ($receiveDetail->qty_received + $quantity);
                //$consignmentDetail->qty_request_left = 100;
                $moveOutDetail->quantity_receive = $quantity + $receiveDetail->qty_received;

                if ($moveOutDetail->save(false)) {
                    $mcriteria = new CDbCriteria;
                    $mcriteria->together = 'true';
                    $mcriteria->with = array('movementOutHeader');
                    $mcriteria->condition = "movementOutHeader.registration_transaction_id =" . $registration->id . " AND movement_out_header_id != " . $movementOut->id;
                    $moDetails = MovementOutDetail::model()->findAll($mcriteria);

                    $mquantity = 0;
                    //print_r($receiveItemDetails);
                    foreach ($moDetails as $moDetail) {
                        $mquantity += $moDetail->quantity_receive;

                    }

                    $rpDetail = RegistrationProduct::model()->findByAttributes(array(
                        'id' => $registrationProductId,
                        'registration_transaction_id' => $registration->id
                    ));

                    $rpDetail->quantity_receive_left = $rpDetail->quantity - ($movementOutDetail->quantity_receive + $mquantity);
                    //$consignmentDetail->qty_request_left = 100;
                    $rpDetail->quantity_receive = $mquantity + $movementOutDetail->quantity_receive;
                    if ($rpDetail->save(false)) {
                        $registrationRealization = new RegistrationRealizationProcess();
                        $registrationRealization->registration_transaction_id = $registration->id;
                        $registrationRealization->name = 'Receive Item';
                        $registrationRealization->checked = 1;
                        $registrationRealization->checked_by = Yii::app()->user->id;
                        $registrationRealization->checked_date = date('Y-m-d');
                        $registrationRealization->detail = 'Receive Item for Product : ' . $registrationProduct->product->name . ' from Movement Out #: ' . $movementOut->movement_out_no . ' Quantity : ' . $quantity;
                        $registrationRealization->save();
                    }
                }

            }


        }

    }

    public function actionAjaxGetCompanyBank()
    {
        $branch = Branch::model()->findByPk($_POST['PaymentIn']['branch_id']);
        $company = Company::model()->findByPk($branch->company_id);
        if ($company == null) {
            echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
        } else {
            // $companyarray = [];
            // foreach ($company as $key => $value) {
            // 	$companyarray[] = (int) $value->company_id;
            // }
            $data = CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id),
                array('order' => 'account_name'));
            // $criteria = new CDbCriteria;
            // $criteria->addInCondition('company_id', $companyarray);
            // $data = CompanyBank::model()->findAll($criteria);
            // var_dump($data); die("S");			// var_dump($data->); die("S");
            if (count($data) > 0) {
                // $bank = $data->bank->name;
                // $data=CHtml::listData($data,'bank_id',$data);
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
                foreach ($data as $value => $name) {
                    echo CHtml::tag('option', array('value' => $name->id),
                        CHtml::encode($name->bank->name . " " . $name->account_no . " a/n " . $name->account_name),
                        true);
                }
            } else {
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
            }
        }

    }

    public function actionlaporanPenjualan()
    {
        $this->pageTitle = "RIMS - Laporan Penjualan";

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : '';
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : '';
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $company = (isset($_GET['company'])) ? $_GET['company'] : '';
        $customer_id = (isset($_GET['customer_id'])) ? $_GET['customer_id'] : '';
        $customer_name = (isset($_GET['customer_name'])) ? $_GET['customer_name'] : '';
        $paymentType = (isset($_GET['payment_type'])) ? $_GET['payment_type'] : '';
        $customerType = (isset($_GET['customer_type'])) ? $_GET['customer_type'] : '';
        $service_type = (isset($_GET['service_type'])) ? $_GET['service_type'] : '';

        $criteria = new CDbCriteria;
        $criteria->together = true;
        $criteria->with = array(
            'registrationServices' => array('with' => array('service' => array('with' => array('serviceType')))),
            'customer'
        );
        if ($company != "") {
            $branches = Branch::model()->findAllByAttributes(array('company_id' => $company));
            $arrBranch = array();
            foreach ($branches as $key => $branchId) {
                $arrBranch[] = $branchId->id;
            }
            if ($branch != "") {
                $criteria->addCondition("branch_id = " . $branch);
            } else {
                $criteria->addInCondition('branch_id', $arrBranch);
            }
        } else {
            if ($branch != "") {
                $criteria->addCondition("branch_id = " . $branch);
            }
        }
        // if ($paymentType != "") {
        // 	if ($paymentType == "Cash") {
        // 		$criteria->with = array('transaction_so'=>array('together'=>true, 'with'=>array('customer')));
        // 	}
        // 	$criteria->addCondition("payment_type = '".$paymentType."'");
        // }
        // if($service_type !=""){
        // 	$criteria->addCondition("repair_type = '".$service_type."'");
        // }
        if ($customerType != "") {
            // $criteria->together = true;
            // $criteria->with = array('customer');
            $criteria->addCondition("customer.customer_type ='" . $customerType . "'");
        }
        if ($service_type != "") {
            // $criteria->together = true;
            // $criteria->with = array('registrationServices'=>array('with'=>array('service'=>array('with'=>array('serviceType')))));
            $criteria->addCondition("serviceType.id = " . $service_type);
        }


        if ($customer_id != "") {
            $criteria->addCondition("customer_id = '" . $customer_id . "'");
        }
        $criteria->addBetweenCondition('t.transaction_date', $tanggal_mulai, $tanggal_sampai);
        $transactions = RegistrationTransaction::model()->findAll($criteria);

        //$jurnals = JurnalUmum::model()->findAll($coaCriteria);
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;

        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);


        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));
        //print_r($jurnals);

        if (isset($_GET['SaveExcel'])) {
            $this->getXlsReport($transactions, $tanggal_mulai, $tanggal_sampai);
        }


        //$dataProvider=new CActiveDataProvider('JurnalUmum');
        // $model=new JurnalUmum('search');
        // $model->unsetAttributes();  // clear any default values
        // if(isset($_GET['JurnalUmum']))
        // 	$model->attributes=$_GET['JurnalUmum'];

        $this->render('laporanPenjualan', array(
            // 'dataProvider'=>$dataProvider,
            //'jurnals'=>$jurnals,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'transactions' => $transactions,
            'branch' => $branch,
            'company' => $company,
            'customer_id' => $customer_id,
            'customer_name' => $customer_name,
            'customerType' => $customerType,
            'service_type' => $service_type,
            'paymentType' => $paymentType,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));


    }

    public function getXlsReport($transactions, $tanggal_mulai, $tanggal_sampai)
    {

        // var_dump($customer); die();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
            ->setLastModifiedBy("RIMS")
            ->setTitle("Laporan Penjualan " . date('d-m-Y'))
            ->setSubject("Laporan Penjualan")
            ->setDescription("Export Data Laporan Penjualan.")
            ->setKeywords("Laporan Penjualan Data")
            ->setCategory("Export Laporan Penjualan");

        // style for horizontal vertical center
        $styleHorizontalVertivalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $styleBold = array(
            'font' => array(
                'bold' => true,
            )
        );

        // style color red
        $styleColorRED = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
                'bold' => true,
            ),
            // 'fill' => array(
            //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //     'color' => array('rgb' => 'FF0000')
            // )
        );
        $styleBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $BStyle = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                )
            )
        );

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'PT RATU PERDANA INDAH JAYA')
            ->setCellValue('A3', 'Laporan Penjualan Registration')
            ->setCellValue('A4', 'PERIODE (' . $tanggal_mulai . '-' . $tanggal_sampai . ')')
            ->setCellValue('A6', 'TANGGAL')
            ->setCellValue('B6', 'NO DOKUMEN')
            ->setCellValue('C6', 'NO WO')
            ->setCellValue('D6', 'NO POLISI')
            ->setCellValue('E6', 'CAR MAKE')
            ->setCellValue('F6', 'CAR SUB MODEL')
            ->setCellValue('G6', 'CUSTOMER')
            ->setCellValue('H6', 'T/K')
            ->setCellValue('I6', 'SUBTOTAL')
            ->setCellValue('J6', 'DISCOUNT PRODUCT')
            ->setCellValue('K6', 'DISCOUNT SERVICE')
            ->setCellValue('L6', 'PPN')
            ->setCellValue('M6', 'PPH')
            ->setCellValue('N6', 'TOTAL')
            ->setCellValue('A7', 'PRODUCT CODE')
            ->setCellValue('B7', 'PRODUCT NAME')
            ->setCellValue('C7', 'PRODUCT MASTER CATEGORY')
            ->setCellValue('D7', 'PRODUCT SUB MASTER CATEGORY')
            ->setCellValue('E7', 'PRODUCT SUB CATEGORY')
            ->setCellValue('G7', 'QUANTITY')
            ->setCellValue('H7', 'UNIT PRICE')
            ->setCellValue('I7', 'BRUTTO')
            ->setCellValue('J7', 'DISCOUNT TYPE')
            ->setCellValue('K7', 'DISCOUNT PRICE')
            ->setCellValue('L7', 'NETTO')
            ->setCellValue('M7', 'BIAYA')
            ->setCellValue('N7', 'TOTAL')
            ->setCellValue('A8', 'SERVICE CODE')
            ->setCellValue('B8', 'SERVICE NAME')
            ->setCellValue('C8', 'SERVICE CATEGORY')
            ->setCellValue('D8', 'SERVICE TYPE')
            ->setCellValue('G8', 'HOUR')
            ->setCellValue('H8', 'PRICE')
            ->setCellValue('I8', 'BRUTTO')
            ->setCellValue('J8', 'DISCOUNT TYPE')
            ->setCellValue('K8', 'DISCOUNT PRICE')
            ->setCellValue('L8', 'NETTO')
            ->setCellValue('M8', 'BIAYA')
            ->setCellValue('N8', 'TOTAL')
            ->setCellValue('A9', 'QS CODE')
            ->setCellValue('B9', 'QS NAME')
            ->setCellValue('G9', 'HOUR')
            ->setCellValue('H9', 'PRICE')
            ->setCellValue('I9', 'BRUTTO')
            ->setCellValue('L9', 'NETTO')
            ->setCellValue('M9', 'BIAYA')
            ->setCellValue('N9', 'TOTAL');


        // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:S2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:S3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:S4');

        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A2:S2')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A3:S3')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A4:S4')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A6:N6')->applyFromArray($styleBold);
        $sheet->getStyle('A7:N7')->applyFromArray($styleBold);
        $sheet->getStyle('A8:N8')->applyFromArray($styleBold);
        $sheet->getStyle('A9:N9')->applyFromArray($styleBold);
        // $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
        //$sheet->getStyle('A7:I7')->applyFromArray($styleBold);

        // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);


        // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        //$objPHPExcel->getActiveSheet()->freezePane('E4');

        $startrow = 10;
        $grandsub = $grandDiscountProduct = $grandDiscountService = $grandPpn = $grandPph = $grandTotal = 0;
        foreach ($transactions as $key => $transaction) {

            //$phone = ($value->customerPhones !=NULL)?$this->phoneNumber($value->customerPhones):'';
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $transaction->transaction_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $transaction->transaction_number);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow,
                $transaction->work_order_number == "" ? '-' : $transaction->work_order_number);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow,
                $transaction->vehicle->plate_number == "" ? '-' : $transaction->vehicle->plate_number);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow,
                $transaction->vehicle->carMake->name == "" ? '-' : $transaction->vehicle->carMake->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow,
                $transaction->vehicle->carSubModel->name == "" ? '-' : $transaction->vehicle->carSubModel->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, $transaction->customer->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow,
                number_format($transaction->subtotal, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow,
                number_format($transaction->discount_product, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow,
                number_format($transaction->discount_service, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startrow,
                number_format($transaction->ppn_price, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $startrow,
                number_format($transaction->pph_price, 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow,
                number_format($transaction->grand_total, 2));
            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->getStyle("A" . ($startrow) . ":N" . ($startrow))->applyFromArray($styleBorder);
            $sheet->getStyle("A" . ($startrow) . ":N" . ($startrow))->applyFromArray($styleBold);
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startrow, );
            //$customertype = (($value->customer_type == 'Individual')?"P":(($value->customer_type == 'Company')?"K":""));
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startrow, "");
            $startrow = $startrow + 1;
            foreach ($transaction->registrationProducts as $key => $transactionDetail) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $transactionDetail->product->code);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $transactionDetail->product->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow,
                    $transactionDetail->product->productMasterCategory->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow,
                    $transactionDetail->product->productSubMasterCategory->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow,
                    $transactionDetail->product->productSubCategory->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, "B");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, $transactionDetail->quantity);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow,
                    number_format($transactionDetail->sale_price, 2));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow,
                    number_format($transactionDetail->quantity * $transactionDetail->sale_price, 2));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, $transactionDetail->discount_type);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow,
                    number_format($transactionDetail->discount, 2));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow,
                    number_format($transactionDetail->total_price, 2));
                $startrow++;
            }

            foreach ($transaction->registrationServices as $key => $serviceDetail) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $serviceDetail->service->code);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $serviceDetail->service->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow,
                    $serviceDetail->service->serviceCategory->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow,
                    $serviceDetail->service->serviceType->name);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, "J");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, $serviceDetail->hour);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow,
                    number_format($serviceDetail->price, 2));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, $serviceDetail->discount_type);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow,
                    number_format($serviceDetail->discount_price, 2));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow,
                    number_format($serviceDetail->total_price, 2));
                $startrow++;
            }
            foreach ($transaction->registrationQuickServices as $key => $qsDetail) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $qsDetail->quickService->code);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $qsDetail->quickService->name);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, "QS");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, $qsDetail->hour);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, number_format($qsDetail->price, 2));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow, number_format($qsDetail->price, 2));
                $startrow++;
            }

            $grandsub += $transaction->subtotal;
            $grandDiscountProduct += $transaction->discount_product;
            $grandDiscountService += $transaction->discount_service;
            $grandPpn += $transaction->ppn_price;
            $grandPph += $transaction->pph_price;
            $grandTotal += $transaction->grand_total;
            // $objPHPExcel->getActiveSheet()
            //     ->getStyle('C'.$startrow)
            //     ->getNumberFormat()
            //     ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
            // $lastkode = $jurnal->kode_transaksi;
            $startrow++;
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, "GRAND TOTAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, number_format($grandsub, 2));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, number_format($grandDiscountProduct, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow, number_format($grandDiscountService, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startrow, number_format($grandPpn, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $startrow, number_format($grandPph, 2));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow, number_format($grandTotal, 2));
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle("G" . ($startrow) . ":N" . ($startrow))->applyFromArray($styleBold);
        $sheet->getStyle("G" . ($startrow) . ":N" . ($startrow))->applyFromArray($BStyle);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("G" . ($startrow) . ":H" . ($startrow));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startrow, $totalDebet);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow, $totalKredit);
        // die();
        $objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('LAPORAN PENJUALAN REGISTRATION');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'laporan_penjualan_registration_data_' . date("Y-m-d");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function actionMonthlyYearly()
    {
        $this->pageTitle = "RIMS - Monthly & Yearly Report";

        // $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : '';
        //       $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : '';
        $year = (isset($_GET['year'])) ? $_GET['year'] : date('Y');
        $month = (isset($_GET['month'])) ? $_GET['month'] : date('n');
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $type = (isset($_GET['type'])) ? $_GET['type'] : 'Yearly';

        //$month = "";
        $criteria = new CDbCriteria;
        $criteria->addCondition("YEAR(transaction_date) = " . $year);
        if ($type == "Monthly") {
            $criteria->addCondition("MONTH(transaction_date) = " . $month);
        }
        if ($branch != "") {
            $criteria->addCondition("branch_id = " . $branch);
        }
        $transactions = RegistrationTransaction::model()->findAll($criteria);


        if (isset($_GET['SaveExcel'])) {
            $this->getXlsYearlyReport($year, $branch);
        }

        if (isset($_GET['SaveExcelMonth'])) {
            $this->getXlsMonthlyReport($year, $month, $branch);
        }

        // if (isset($_GET['showYear']))
        // 	$this->showYearReport($branch,$year);
        // if (isset($_GET['showMonth']))
        // 	$this->showMonthReport($branch,$year,$month);
        //$dataProvider=new CActiveDataProvider('JurnalUmum');
        // $model=new JurnalUmum('search');
        // $model->unsetAttributes();  // clear any default values
        // if(isset($_GET['JurnalUmum']))
        // 	$model->attributes=$_GET['JurnalUmum'];


        $this->render('monthlyYearlyReport', array(
            // 'dataProvider'=>$dataProvider,
            //'jurnals'=>$jurnals,
            // 'tanggal_mulai'=>$tanggal_mulai,
            // 'tanggal_sampai'=>$tanggal_sampai,
            'transactions' => $transactions,
            'branch' => $branch,
            'year' => $year,
            'month' => $month,
            'type' => $type,
            // 'customer_id'=>$customer_id,
            // 'customer_name'=>$customer_name,
            // 'customerType'=>$customerType,
            // 'serviceType'=>$serviceType,
            // 'paymentType'=>$paymentType,
            // 'customer'=>$customer,
            // 'customerDataProvider'=>$customerDataProvider,
        ));


    }

    public function getXlsYearlyReport($year, $branch)
    {

        // var_dump($customer); die();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
            ->setLastModifiedBy("RIMS")
            ->setTitle("Monthly & Yearly Report " . date('d-m-Y'))
            ->setSubject("Monthly & Yearly Report")
            ->setDescription("Export Monthly and yearly report.")
            ->setKeywords("Monthly and yearly report")
            ->setCategory("Export Monthly and yearly report");

        // style for horizontal vertical center
        $styleHorizontalVertivalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $styleHorizontalLeft = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $styleBold = array(
            'font' => array(
                'bold' => true,
            )
        );

        // style color red
        $styleColorRED = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
                'bold' => true,
            ),
            // 'fill' => array(
            //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //     'color' => array('rgb' => 'FF0000')
            // )
        );
        $styleBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $BStyle = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                )
            )
        );
        $branchData = "";
        if ($branch != "") {
            $branchData = Branch::model()->findByPk($branch)->name;
        }

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Monthly and yearly report')
            ->setCellValue('B4', 'Year')
            ->setCellValue('B5', 'Month')
            ->setCellValue('B6', 'Branch')
            ->setCellValue('B7', 'Location')
            ->setCellValue('B10', 'Revenue')
            ->setCellValue('C11', 'Total')
            ->setCellValue('C13', 'Service')
            ->setCellValue('G13', 'Parts')
            ->setCellValue('D15', 'General Repair')
            ->setCellValue('D16', 'Body Repair')
            ->setCellValue('D17', 'TBA')
            ->setCellValue('D18', 'Oil')
            ->setCellValue('D19', 'Car Wash')
            ->setCellValue('D20', 'Sub Pekerjaan Luar')
            ->setCellValue('D21', 'Other')
            ->setCellValue('B37', 'Service Sales by Division & Employee')
            ->setCellValue('C39', 'Division')
            ->setCellValue('D39', 'Employee #')
            ->setCellValue('E39', 'Employee Name')
            ->setCellValue('F39', 'Service Sales (Rp)')
            ->setCellValue('G15', 'Spareparts')
            ->setCellValue('C4', $year)
            ->setCellValue('C5', 'January - December')
            ->setCellValue('C6', $branchData == "" ? 'All Branch' : $branchData);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A1')->applyFromArray($styleLeftVertivalCenterBold);
        $sheet->getStyle('B4')->applyFromArray($styleBold);
        $sheet->getStyle('C4')->applyFromArray($styleHorizontalLeft);

        $sheet->getStyle('B5')->applyFromArray($styleBold);
        $sheet->getStyle('B6')->applyFromArray($styleBold);
        $sheet->getStyle('B7')->applyFromArray($styleBold);
        $sheet->getStyle('B10')->applyFromArray($styleBold);
        $sheet->getStyle('C11')->applyFromArray($styleBold);
        $sheet->getStyle('C13')->applyFromArray($styleBold);
        $sheet->getStyle('G13')->applyFromArray($styleBold);
        $sheet->getStyle('H13')->applyFromArray($styleBold);
        $sheet->getStyle('B37')->applyFromArray($styleBold);
        $sheet->getStyle('C39:F39')->applyFromArray($styleBold);


        $criteria = new CDbCriteria;
        $criteria->addCondition("YEAR(transaction_date) = " . $year);
        if ($branch != "") {
            $criteria->addCondition("branch_id = " . $branch);
        }

        $transactions = RegistrationTransaction::model()->findAll($criteria);
        $serviceYear = 0;
        $generalYear = $bodyYear = $tbaYear = $oilYear = $carYear = $othersYear = 0;

        foreach ($transactions as $key => $transaction) {

            foreach ($transaction->registrationServices as $key => $service) {
                if ($service->service->service_type_id == 1) {
                    $generalYear += $service->total_price;
                } elseif ($service->service->service_type_id == 2) {
                    $bodyYear += $service->total_price;
                } elseif ($service->service->service_type_id == 3) {
                    $tbaYear += $service->total_price;
                } elseif ($service->service->service_type_id == 4) {
                    $oilYear += $service->total_price;
                } elseif ($service->service->service_type_id == 5) {
                    $carYear += $service->total_price;
                } else {
                    $othersYear += $service->total_price;
                }

            }
            $serviceYear += $transaction->total_service_price;


        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D13', $serviceYear);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E15', $generalYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E16', $bodyYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E17', $tbaYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E18', $oilYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E19', $carYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E21', $othersYear);

        $startrow = 16;
        $brands = Brand::model()->findAll();
        $totalYearProduct = 0;
        foreach ($brands as $key => $brand) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, $brand->name);
            $prodcriteria = new CDbCriteria;
            $prodcriteria->together = 'true';
            $prodcriteria->with = array('product', 'registrationTransaction');
            $prodcriteria->addCondition("product.brand_id = " . $brand->id);
            $prodcriteria->addCondition("YEAR(registrationTransaction.transaction_date) =" . $year);
            if ($branch != "") {
                $prodcriteria->addCondition("registrationTransaction.branch_id = " . $branch);
            }

            $products = RegistrationProduct::model()->findAll($prodcriteria);
            $productYear = 0;
            foreach ($products as $key => $product) {
                $productYear += $product->total_price;


            }
            $soCriteria = new CDbCriteria;
            $soCriteria->together = 'true';
            $soCriteria->with = array('product', 'salesOrder');
            $soCriteria->addCondition("product.brand_id = " . $brand->id);
            $soCriteria->addCondition("YEAR(salesOrder.sale_order_date) = " . $year);
            if ($branch != "") {
                $soCriteria->addCondition("salesOrder.requester_branch_id = " . $branch);
            }

            $soProducts = TransactionSalesOrderDetail::model()->findAll($soCriteria);
            $soYear = 0;
            foreach ($soProducts as $key => $soProduct) {
                $soYear += $soProduct->total_price;


            }
            $productAll = $productYear + $soYear;
            $totalYearProduct += $productAll;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, $productAll);
            $startrow++;
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11', $totalYearProduct + $serviceYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I13', $totalYearProduct);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I15', $totalYearProduct);

        $serviceTypes = ServiceType::model()->findAll();
        $row = 40;
        foreach ($serviceTypes as $key => $serviceType) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $serviceType->name);

            $serviceSalesCriteria = new CDbCriteria;
            $serviceSalesCriteria->together = 'true';
            $serviceSalesCriteria->with = array(
                'employee',
                'registrationService' => array(
                    'with' => array(
                        'registrationTransaction',
                        'service' => array('with' => array('serviceType'))
                    )
                )
            );
            $serviceSalesCriteria->addCondition("YEAR(registrationTransaction.transaction_date) = " . $year);
            $serviceSalesCriteria->addCondition("serviceType.id = " . $serviceType->id);
            $yearServiceSales = RegistrationServiceEmployee::model()->findAll($serviceSalesCriteria);


            $lastname = $lastDiv = $lastId = "";
            foreach ($yearServiceSales as $key => $yearServiceSale) {
                $employees = Employee::model()->findAllByAttributes(array('id' => $yearServiceSale->employee_id));
                foreach ($employees as $key => $employee) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $employee->id);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $employee->name);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row,
                        $yearServiceSale->registrationService->total_price);

                    $row++;
                }

                // echo $yearServiceSale->employee->name;
                // echo '<br>';


            }
            $row++;

        }
        // foreach ($yearServiceSales as $key => $yearServiceSale) {
        //   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,$yearServiceSale->registrationService->service->serviceType->name);
        //   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row,$yearServiceSale->employee->id);
        //   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row,$yearServiceSale->employee->name);
        //   $row++;
        //   // echo $yearServiceSale->registrationService->service->serviceType->name;

        //   // echo $yearServiceSale->employee->name; echo '<br>';
        // }

        // $regServiceEmpCriteria = new CDbCriteria;
        // $regServiceEmpCriteria->with = array('registrationTransaction','service'=>array('with'=>array('serviceType')),'registrationServiceEmployees'=>array('with'=>array('employee')));
        // $regServiceEmps = RegistrationService::model()->findAll($regServiceEmpCriteria);
        // foreach ($regServiceEmps as $key => $regServiceEmp) {
        // 	echo $regServiceEmp->registrationServiceEmployees->employee->name;
        // }

        $objPHPExcel->getActiveSheet()->setTitle('YEAR ' . $year);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        //GET MONTHLY
        for ($i = 1; $i <= 12; $i++) {
            $monthSheet = $objPHPExcel->createSheet($i);
            switch ($i) {
                case '1':
                    $bulan = "January";
                    break;
                case '2':
                    $bulan = "February";
                    break;
                case '3':
                    $bulan = "March";
                    break;
                case '4':
                    $bulan = "April";
                    break;
                case '5':
                    $bulan = "May";
                    break;
                case '6':
                    $bulan = "June";
                    break;
                case '7':
                    $bulan = "July";
                    break;
                case '8':
                    $bulan = "August";
                    break;
                case '9':
                    $bulan = "September";
                    break;
                case '10':
                    $bulan = "October";
                    break;
                case '11':
                    $bulan = "November";
                    break;

                default:
                    $bulan = "December";
                    break;
            }
            $monthSheet->setTitle($bulan);
            $monthSheet->setCellValue('A1', 'Monthly report')
                ->setCellValue('B4', 'Year')
                ->setCellValue('B5', 'Month')
                ->setCellValue('B6', 'Branch')
                ->setCellValue('B7', 'Location')
                ->setCellValue('B10', 'Revenue')
                ->setCellValue('C11', 'Total')
                ->setCellValue('C13', 'Service')
                ->setCellValue('G13', 'Parts')
                ->setCellValue('D15', 'General Repair')
                ->setCellValue('D16', 'Body Repair')
                ->setCellValue('D17', 'TBA')
                ->setCellValue('D18', 'Oil')
                ->setCellValue('D19', 'Car Wash')
                ->setCellValue('D20', 'Sub Pekerjaan Luar')
                ->setCellValue('D21', 'Other')
                ->setCellValue('B37', 'Service Sales by Division & Employee')
                ->setCellValue('C39', 'Division')
                ->setCellValue('D39', 'Employee #')
                ->setCellValue('E39', 'Employee Name')
                ->setCellValue('F39', 'Service Sales (Rp)')
                ->setCellValue('G15', 'Spareparts');

            $monthSheet->setCellValue('C4', $year);
            $monthSheet->setCellValue('C5', $bulan);

            $monthSheet->setCellValue('C6', $branchData == "" ? 'All Branch' : $branchData);


            $monthSheet->getColumnDimension('A')->setWidth(15);
            $monthSheet->getColumnDimension('B')->setWidth(15);
            $monthSheet->getColumnDimension('C')->setWidth(15);
            $monthSheet->getColumnDimension('D')->setWidth(15);
            $monthSheet->getColumnDimension('E')->setWidth(15);
            $monthSheet->getColumnDimension('F')->setWidth(15);
            $monthSheet->getColumnDimension('G')->setWidth(15);
            $monthSheet->getColumnDimension('H')->setWidth(15);
            $monthSheet->getColumnDimension('I')->setWidth(15);
            $monthSheet->getColumnDimension('J')->setWidth(15);

            $monthSheet->getStyle('A1')->applyFromArray($styleHorizontalVertivalCenterBold);
            $monthSheet->getStyle('C4')->applyFromArray($styleHorizontalLeft);
            $monthSheet->getStyle('B4')->applyFromArray($styleBold);
            $monthSheet->getStyle('B5')->applyFromArray($styleBold);
            $monthSheet->getStyle('B6')->applyFromArray($styleBold);
            $monthSheet->getStyle('B7')->applyFromArray($styleBold);
            $monthSheet->getStyle('B10')->applyFromArray($styleBold);
            $monthSheet->getStyle('C11')->applyFromArray($styleBold);
            $monthSheet->getStyle('C13')->applyFromArray($styleBold);
            $monthSheet->getStyle('G13')->applyFromArray($styleBold);
            $monthSheet->getStyle('H13')->applyFromArray($styleBold);
            $monthSheet->getStyle('B37')->applyFromArray($styleBold);
            $monthSheet->getStyle('C39:F39')->applyFromArray($styleBold);

            $criteria = new CDbCriteria;
            $criteria->addCondition("YEAR(transaction_date) = " . $year);
            $criteria->addCondition("MONTH(transaction_date) =" . $i);
            if ($branch != "") {
                $criteria->addCondition("branch_id =" . $branch);
            }


            $transactions = RegistrationTransaction::model()->findAll($criteria);
            $serviceMonth = 0;
            $generalMonth = $bodyMonth = $tbaMonth = $oilMonth = $carMonth = $othersMonth = 0;

            foreach ($transactions as $key => $transaction) {

                foreach ($transaction->registrationServices as $key => $service) {
                    if ($service->service->service_type_id == 1) {
                        $generalMonth += $service->total_price;
                    } elseif ($service->service->service_type_id == 2) {
                        $bodyMonth += $service->total_price;
                    } elseif ($service->service->service_type_id == 3) {
                        $tbaMonth += $service->total_price;
                    } elseif ($service->service->service_type_id == 4) {
                        $oilMonth += $service->total_price;
                    } elseif ($service->service->service_type_id == 5) {
                        $carMonth += $service->total_price;
                    } else {
                        $othersMonth += $service->total_price;
                    }

                }
                $serviceMonth += $transaction->total_service_price;


            }
            $monthSheet->setCellValue('D13', $serviceMonth);

            $monthSheet->setCellValue('E15', $generalMonth);
            $monthSheet->setCellValue('E16', $bodyMonth);
            $monthSheet->setCellValue('E17', $tbaMonth);
            $monthSheet->setCellValue('E18', $oilMonth);
            $monthSheet->setCellValue('E19', $carMonth);
            $monthSheet->setCellValue('E21', $othersMonth);

            $startrow = 16;
            $brands = Brand::model()->findAll();
            $totalMonthProduct = 0;
            foreach ($brands as $key => $brand) {
                $monthSheet->setCellValue('H' . $startrow, $brand->name);
                $prodcriteria = new CDbCriteria;
                $prodcriteria->together = 'true';
                $prodcriteria->with = array('product', 'registrationTransaction');
                $prodcriteria->addCondition("product.brand_id = " . $brand->id);
                $prodcriteria->addCondition("YEAR(registrationTransaction.transaction_date) = " . $year);
                $prodcriteria->addCondition("MONTH(registrationTransaction.transaction_date) = " . $i);
                if ($branch != "") {
                    $prodcriteria->addCondition("registrationTransaction.branch_id = " . $branch);
                }

                $products = RegistrationProduct::model()->findAll($prodcriteria);
                $productMonth = 0;
                foreach ($products as $key => $product) {
                    $productMonth += $product->total_price;


                }
                $soCriteria = new CDbCriteria;
                $soCriteria->together = 'true';
                $soCriteria->with = array('product', 'salesOrder');
                $soCriteria->addCondition("product.brand_id = " . $brand->id);
                $soCriteria->addCondition("YEAR(salesOrder.sale_order_date) = " . $year);
                $soCriteria->addCondition("Month(salesOrder.sale_order_date) = " . $i);
                if ($branch != "") {
                    $soCriteria->addCondition("salesOrder.requester_branch_id = " . $branch);
                }

                $soProducts = TransactionSalesOrderDetail::model()->findAll($soCriteria);
                $soMonth = 0;
                foreach ($soProducts as $key => $soProduct) {
                    $soMonth += $soProduct->total_price;


                }
                $productAll = $productMonth + $soMonth;
                $totalMonthProduct += $productAll;
                $monthSheet->setCellValue('I' . $startrow, $productAll);
                $startrow++;
            }
            $monthSheet->setCellValue('D11', $totalMonthProduct + $serviceMonth);
            $monthSheet->setCellValue('I13', $totalMonthProduct);
            $monthSheet->setCellValue('I15', $totalMonthProduct);
            //$objPHPExcel->setActiveSheetIndex($i);
            $serviceTypes = ServiceType::model()->findAll();
            $row = 40;
            foreach ($serviceTypes as $key => $serviceType) {
                $monthSheet->setCellValue('C' . $row, $serviceType->name);

                $serviceSalesCriteria = new CDbCriteria;
                $serviceSalesCriteria->together = 'true';
                $serviceSalesCriteria->with = array(
                    'employee',
                    'registrationService' => array(
                        'with' => array(
                            'registrationTransaction',
                            'service' => array('with' => array('serviceType'))
                        )
                    )
                );
                $serviceSalesCriteria->addCondition("YEAR(registrationTransaction.transaction_date) = " . $year);
                $serviceSalesCriteria->addCondition("Month(registrationTransaction.transaction_date) = " . $i);
                $serviceSalesCriteria->addCondition("serviceType.id = " . $serviceType->id);
                $monthServiceSales = RegistrationServiceEmployee::model()->findAll($serviceSalesCriteria);


                $lastname = $lastDiv = $lastId = "";
                foreach ($monthServiceSales as $key => $monthServiceSale) {
                    $employees = Employee::model()->findAllByAttributes(array('id' => $monthServiceSale->employee_id));
                    foreach ($employees as $key => $employee) {
                        $monthSheet->setCellValue('D' . $row, $employee->id);
                        $monthSheet->setCellValue('E' . $row, $employee->name);
                        $monthSheet->setCellValue('F' . $row, $monthServiceSale->registrationService->total_price);

                        $row++;
                    }

                    // echo $yearServiceSale->employee->name;
                    // echo '<br>';


                }
                $row++;

            }
        }


        // Save a xls file
        $filename = 'monthly_yearly_report_data_' . $year;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function getXlsMonthlyReport($year, $month, $branch)
    {

        // var_dump($customer); die();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
            ->setLastModifiedBy("RIMS")
            ->setTitle("Monthly Report " . date('d-m-Y'))
            ->setSubject("Monthly Report")
            ->setDescription("Export Monthly report.")
            ->setKeywords("Monthly report")
            ->setCategory("Export Monthly report");

        // style for horizontal vertical center
        $styleHorizontalVertivalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $styleHorizontalLeft = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $styleBold = array(
            'font' => array(
                'bold' => true,
            )
        );

        // style color red
        $styleColorRED = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
                'bold' => true,
            ),
            // 'fill' => array(
            //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //     'color' => array('rgb' => 'FF0000')
            // )
        );
        $styleBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $BStyle = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                )
            )
        );
        $branchData = "";
        if ($branch != "") {
            $branchData = Branch::model()->findByPk($branch)->name;
        }

        switch ($month) {
            case '1':
                $bulan = "January";
                break;
            case '2':
                $bulan = "February";
                break;
            case '3':
                $bulan = "March";
                break;
            case '4':
                $bulan = "April";
                break;
            case '5':
                $bulan = "May";
                break;
            case '6':
                $bulan = "June";
                break;
            case '7':
                $bulan = "July";
                break;
            case '8':
                $bulan = "August";
                break;
            case '9':
                $bulan = "September";
                break;
            case '10':
                $bulan = "October";
                break;
            case '11':
                $bulan = "November";
                break;

            default:
                $bulan = "December";
                break;
        }
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Monthly report')
            ->setCellValue('B4', 'Year')
            ->setCellValue('B5', 'Month')
            ->setCellValue('B6', 'Branch')
            ->setCellValue('B7', 'Location')
            ->setCellValue('B10', 'Revenue')
            ->setCellValue('C11', 'Total')
            ->setCellValue('C13', 'Service')
            ->setCellValue('G13', 'Parts')
            ->setCellValue('D15', 'General Repair')
            ->setCellValue('D16', 'Body Repair')
            ->setCellValue('D17', 'TBA')
            ->setCellValue('D18', 'Oil')
            ->setCellValue('D19', 'Car Wash')
            ->setCellValue('D20', 'Sub Pekerjaan Luar')
            ->setCellValue('D21', 'Other')
            ->setCellValue('B37', 'Service Sales by Division & Employee')
            ->setCellValue('C39', 'Division')
            ->setCellValue('D39', 'Employee #')
            ->setCellValue('E39', 'Employee Name')
            ->setCellValue('F39', 'Service Sales (Rp)')
            ->setCellValue('G15', 'Spareparts')
            ->setCellValue('C4', $year)
            ->setCellValue('C5', $bulan)
            ->setCellValue('C6', $branchData == "" ? 'All Branch' : $branchData);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A1')->applyFromArray($styleLeftVertivalCenterBold);
        $sheet->getStyle('B4')->applyFromArray($styleBold);
        $sheet->getStyle('C4')->applyFromArray($styleHorizontalLeft);

        $sheet->getStyle('B5')->applyFromArray($styleBold);
        $sheet->getStyle('B6')->applyFromArray($styleBold);
        $sheet->getStyle('B7')->applyFromArray($styleBold);
        $sheet->getStyle('B10')->applyFromArray($styleBold);
        $sheet->getStyle('C11')->applyFromArray($styleBold);
        $sheet->getStyle('C13')->applyFromArray($styleBold);
        $sheet->getStyle('G13')->applyFromArray($styleBold);
        $sheet->getStyle('H13')->applyFromArray($styleBold);
        $sheet->getStyle('B37')->applyFromArray($styleBold);
        $sheet->getStyle('C39:F39')->applyFromArray($styleBold);


        $criteria = new CDbCriteria;
        $criteria->addCondition("YEAR(transaction_date) = " . $year);
        $criteria->addCondition("MONTH(transaction_date) = " . $month);
        if ($branch != "") {
            $criteria->addCondition("branch_id = " . $branch);
        }

        $transactions = RegistrationTransaction::model()->findAll($criteria);
        $serviceYear = 0;
        $generalYear = $bodyYear = $tbaYear = $oilYear = $carYear = $othersYear = 0;

        foreach ($transactions as $key => $transaction) {

            foreach ($transaction->registrationServices as $key => $service) {
                if ($service->service->service_type_id == 1) {
                    $generalYear += $service->total_price;
                } elseif ($service->service->service_type_id == 2) {
                    $bodyYear += $service->total_price;
                } elseif ($service->service->service_type_id == 3) {
                    $tbaYear += $service->total_price;
                } elseif ($service->service->service_type_id == 4) {
                    $oilYear += $service->total_price;
                } elseif ($service->service->service_type_id == 5) {
                    $carYear += $service->total_price;
                } else {
                    $othersYear += $service->total_price;
                }

            }
            $serviceYear += $transaction->total_service_price;


        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D13', $serviceYear);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E15', $generalYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E16', $bodyYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E17', $tbaYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E18', $oilYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E19', $carYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E21', $othersYear);

        $startrow = 16;
        $brands = Brand::model()->findAll();
        $totalYearProduct = 0;
        foreach ($brands as $key => $brand) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, $brand->name);
            $prodcriteria = new CDbCriteria;
            $prodcriteria->together = 'true';
            $prodcriteria->with = array('product', 'registrationTransaction');
            $prodcriteria->addCondition("product.brand_id = " . $brand->id);
            $prodcriteria->addCondition("YEAR(registrationTransaction.transaction_date) =" . $year);
            $prodcriteria->addCondition("MONTH(registrationTransaction.transaction_date) =" . $month);
            if ($branch != "") {
                $prodcriteria->addCondition("registrationTransaction.branch_id = " . $branch);
            }

            $products = RegistrationProduct::model()->findAll($prodcriteria);
            $productYear = 0;
            foreach ($products as $key => $product) {
                $productYear += $product->total_price;


            }
            $soCriteria = new CDbCriteria;
            $soCriteria->together = 'true';
            $soCriteria->with = array('product', 'salesOrder');
            $soCriteria->addCondition("product.brand_id = " . $brand->id);
            $soCriteria->addCondition("YEAR(salesOrder.sale_order_date) = " . $year);
            $soCriteria->addCondition("MONTH(salesOrder.sale_order_date) = " . $month);
            if ($branch != "") {
                $soCriteria->addCondition("salesOrder.requester_branch_id = " . $branch);
            }

            $soProducts = TransactionSalesOrderDetail::model()->findAll($soCriteria);
            $soYear = 0;
            foreach ($soProducts as $key => $soProduct) {
                $soYear += $soProduct->total_price;


            }
            $productAll = $productYear + $soYear;
            $totalYearProduct += $productAll;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, $productAll);
            $startrow++;
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11', $totalYearProduct + $serviceYear);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I13', $totalYearProduct);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I15', $totalYearProduct);

        $serviceTypes = ServiceType::model()->findAll();
        $row = 40;
        foreach ($serviceTypes as $key => $serviceType) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $serviceType->name);

            $serviceSalesCriteria = new CDbCriteria;
            $serviceSalesCriteria->together = 'true';
            $serviceSalesCriteria->with = array(
                'employee',
                'registrationService' => array(
                    'with' => array(
                        'registrationTransaction',
                        'service' => array('with' => array('serviceType'))
                    )
                )
            );
            $serviceSalesCriteria->addCondition("YEAR(registrationTransaction.transaction_date) = " . $year);
            $serviceSalesCriteria->addCondition("Month(registrationTransaction.transaction_date) = " . $month);
            $serviceSalesCriteria->addCondition("serviceType.id = " . $serviceType->id);
            $monthServiceSales = RegistrationServiceEmployee::model()->findAll($serviceSalesCriteria);


            $lastname = $lastDiv = $lastId = "";
            foreach ($monthServiceSales as $key => $monthServiceSale) {
                $employees = Employee::model()->findAllByAttributes(array('id' => $monthServiceSale->employee_id));
                foreach ($employees as $key => $employee) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $employee->id);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $employee->name);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row,
                        $monthServiceSale->registrationService->total_price);

                    $row++;
                }

                // echo $yearServiceSale->employee->name;
                // echo '<br>';


            }
            $row++;

        }
        // $regServiceEmpCriteria = new CDbCriteria;
        // $regServiceEmpCriteria->with = array('registrationTransaction','service'=>array('with'=>array('serviceType')),'registrationServiceEmployees'=>array('with'=>array('employee')));
        // $regServiceEmps = RegistrationService::model()->findAll($regServiceEmpCriteria);
        // foreach ($regServiceEmps as $key => $regServiceEmp) {
        // 	echo $regServiceEmp->registrationServiceEmployees->employee->name;
        // }


        $objPHPExcel->getActiveSheet()->setTitle($bulan);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);


        // Save a xls file
        $filename = 'monthly_yearly_report_data_' . $month . '-' . $year;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function actionAjaxGetBranch()
    {


        $data = Branch::model()->findAllByAttributes(array('company_id' => $_POST['company']));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '-- All Branch --', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            $data = Branch::model()->findAll();
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            echo CHtml::tag('option', array('value' => ''), '-- All Branch --', true);
        }
    }
    // public function showYearReport($branch, $year){
    // 	$month = "";
    // 	$criteria = new CDbCriteria;
    // 	$criteria->addCondition("YEAR(transaction_date) = ".$year);
    // 	if ($branch!="") {
    // 		$criteria->addCondition("branch_id = ".$branch);
    // 	}
    // 	$transactions = RegistrationTransaction::model()->findAll($criteria);
    // 	$this->render('monthlyYearlyReport',array(

    // 		'transactions'=>$transactions,
    // 		'branch'=>$branch,
    // 		'month'=>$month,
    // 		'year'=>$year,

    // 	));


    // }
    // public function showMonthReport($branch, $year,$month){
    // 	$criteria = new CDbCriteria;
    // 	$criteria->addCondition("YEAR(transaction_date) = ".$year);
    // 	$criteria->addCondition("MONTH(transaciton_date) = ".$month);
    // 	if ($branch!="") {
    // 		$criteria->addCondition("branch_id = ".$branch);
    // 	}

    // 	$transactions = RegistrationTransaction::model()->findAll($criteria);
    // 	$this->render('monthlyYearlyReport',array(

    // 		'transactions'=>$transactions,
    // 		'branch'=>$branch,
    // 		'year'=>$year,
    // 		'month'=>$month
    // 	));
    // }
}
