<?php

class CustomerWaitlistController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'cashier') {
            if (!(Yii::app()->user->checkAccess('cashierApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'customerWaitlist') {
            if (!(Yii::app()->user->checkAccess('customerQueueApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionAdmin() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $modelDataProvider = $model->search();
        $modelDataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $modelDataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        $modelDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.status != 'Finished'");

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
            $modelEpoxyCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelEpoxyCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelEpoxyCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
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
            $modelpaintCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelpaintCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelpaintCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelpaintCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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
            $modelfinishingCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelfinishingCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelfinishingCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            // $modelfinishingCriteria->compare('registrationTransaction.transaction_date',$_GET['RegistrationTransaction']['date_repair'],TRUE);
            $modelfinishingCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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
            $modeldempulCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modeldempulCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modeldempulCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modeldempulCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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
            $modelwashingCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelwashingCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelwashingCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelwashingCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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
            $modelopeningCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelopeningCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelopeningCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelopeningCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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
            $modeltbaCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modeltbaCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modeltbaCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modeltbaCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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
            $modelgrCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelgrCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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
            $modelgrOilCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelgrOilCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrOilCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrOilCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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
            $modelgrWashCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelgrWashCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrWashCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrWashCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
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

        $this->render('admin', array(
            'model' => $model,
//            'models' => $models,
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

    public function getDataProviderTimecounter($modelCriteria) {
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

    public function actionAjaxCustomer($id) {

        if (Yii::app()->request->isAjaxRequest) {
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

}
