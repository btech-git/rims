<?php

class ServiceGroupController extends Controller {

    public $layout = '//layouts/backend';

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
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'addVehicle' || 
            $filterChain->action->id === 'addService'
        ) {
            if (!(Yii::app()->user->checkAccess('frontOfficeHead')) || !(Yii::app()->user->checkAccess('operationHead')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $serviceGroup = $this->instantiate(null);
        $this->performAjaxValidation($serviceGroup->header);

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $serviceGroup->header->id));

        if (isset($_POST['ServiceGroup'])) {
            $this->loadState($serviceGroup);

            if ($serviceGroup->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $serviceGroup->header->id));
            }
        }

        $this->render('create', array(
            'serviceGroup' => $serviceGroup,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $serviceGroup = $this->instantiate($id);
        $this->performAjaxValidation($serviceGroup->header);

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $serviceGroup->header->id));

        if (isset($_POST['ServiceGroup'])) {
            $this->loadState($serviceGroup);

            if ($serviceGroup->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $serviceGroup->header->id));
            }
        }

        $this->render('update', array(
            'serviceGroup' => $serviceGroup,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ServiceGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ServiceGroup']))
            $model->attributes = $_GET['ServiceGroup'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAddVehicle($id) {
        $serviceGroup = $this->instantiateVehicle($id);

        $vehicleCarModel = Search::bind(new VehicleCarModel('search'), isset($_GET['VehicleCarModel']) ? $_GET['VehicleCarModel'] : array());
        $vehicleCarModelDataProvider = $vehicleCarModel->search();

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $serviceGroup->header->id));

        if (isset($_POST['Submit'])) {
            $this->loadState($serviceGroup);

            if ($serviceGroup->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $serviceGroup->header->id));
        }

        $this->render('addVehicle', array(
            'serviceGroup' => $serviceGroup,
            'vehicleCarModel' => $vehicleCarModel,
            'vehicleCarModelDataProvider' => $vehicleCarModelDataProvider,
        ));
    }

    public function actionAddService($id) {
        $serviceGroup = $this->instantiateService($id);

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : array());
        $serviceDataProvider = $service->search();

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $serviceGroup->header->id));

        if (isset($_POST['Submit'])) {
            $this->loadState($serviceGroup);

            if ($serviceGroup->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $serviceGroup->header->id));
        }

        $this->render('addService', array(
            'serviceGroup' => $serviceGroup,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
        ));
    }

    public function actionAjaxHtmlAddVehicleModels($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $serviceGroup = $this->instantiate($id);
            $this->loadState($serviceGroup);

            if (isset($_POST['selectedIds'])) {
                $vehicleModelDetails = array();
                $vehicleModelDetails = $_POST['selectedIds'];

                foreach ($vehicleModelDetails as $vehicleModelDetail) {
                    $serviceGroup->addVehicleModel($vehicleModelDetail);
                }
            }

            $this->renderPartial('_detailVehicle', array(
                'serviceGroup' => $serviceGroup,
            ));
        }
    }

    public function actionAjaxHtmlRemoveVehicle($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $serviceGroup = $this->instantiate($id);
            $this->loadState($serviceGroup);
            $serviceGroup->removeVehicleDetailAt($index);

            $this->renderPartial('_detailVehicle', array(
                'serviceGroup' => $serviceGroup,
            ));
        }
    }

    public function actionAjaxHtmlAddServices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $serviceGroup = $this->instantiate($id);
            $this->loadState($serviceGroup);

            if (isset($_POST['selectedIds'])) {
                $serviceDetails = array();
                $serviceDetails = $_POST['selectedIds'];

                foreach ($serviceDetails as $serviceDetail)
                    $serviceGroup->addService($serviceDetail);
            }

            $this->renderPartial('_detailService', array(
                'serviceGroup' => $serviceGroup,
            ));
        }
    }

    public function actionAjaxHtmlRemoveService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $serviceGroup = $this->instantiate($id);
            $this->loadState($serviceGroup);
            $serviceGroup->removeServiceDetailAt($index);

            $this->renderPartial('_detailService', array(
                'serviceGroup' => $serviceGroup,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ServiceGroup the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ServiceGroup::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ServiceGroup $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $serviceGroupVehicleModel = new ServiceGroupVehicleModel(new ServiceGroup(), array(), array());
        } else {
            $serviceGroup = $this->loadModel($id);
            $serviceGroupVehicleModel = new ServiceGroupVehicleModel($serviceGroup, array(), array());
        }

        return $serviceGroupVehicleModel;
    }

    public function instantiateVehicle($id) {
        if (empty($id)) {
            $serviceGroupVehicleModel = new ServiceGroupVehicleModel(new ServiceGroup(), array(), array());
        } else {
            $serviceGroup = $this->loadModel($id);
            $serviceGroupVehicleModel = new ServiceGroupVehicleModel($serviceGroup, $serviceGroup->serviceVehicles, array());
        }

        return $serviceGroupVehicleModel;
    }

    public function instantiateService($id) {
        if (empty($id)) {
            $serviceGroupVehicleModel = new ServiceGroupVehicleModel(new ServiceGroup(), array(), array());
        } else {
            $serviceGroup = $this->loadModel($id);
            $serviceGroupVehicleModel = new ServiceGroupVehicleModel($serviceGroup, array(), $serviceGroup->servicePricelists);
        }

        return $serviceGroupVehicleModel;
    }

    public function loadState($serviceGroup) {
        if (isset($_POST['ServiceGroup'])) {
            $serviceGroup->header->attributes = $_POST['ServiceGroup'];
        }

        if (isset($_POST['ServiceVehicle'])) {
            foreach ($_POST['ServiceVehicle'] as $i => $item) {
                if (isset($serviceGroup->vehicleDetails[$i]))
                    $serviceGroup->vehicleDetails[$i]->attributes = $item;
                else {
                    $detail = new ServiceVehicle();
                    $detail->attributes = $item;
                    $serviceGroup->vehicleDetails[] = $detail;
                }
            }
            if (count($_POST['ServiceVehicle']) < count($serviceGroup->vehicleDetails))
                array_splice($serviceGroup->vehicleDetails, $i + 1);
        } else
            $serviceGroup->vehicleDetails = array();

        if (isset($_POST['ServicePricelist'])) {
            foreach ($_POST['ServicePricelist'] as $i => $item) {
                if (isset($serviceGroup->pricelistDetails[$i]))
                    $serviceGroup->pricelistDetails[$i]->attributes = $item;
                else {
                    $detail = new ServicePricelist();
                    $detail->attributes = $item;
                    $serviceGroup->pricelistDetails[] = $detail;
                }
            }
            if (count($_POST['ServicePricelist']) < count($serviceGroup->pricelistDetails))
                array_splice($serviceGroup->pricelistDetails, $i + 1);
        } else
            $serviceGroup->pricelistDetails = array();
    }

}
