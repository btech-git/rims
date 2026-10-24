<?php

class TireSizeController extends Controller {

    public $layout = '//layouts/backend';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' ) {
            if (!(Yii::app()->user->checkAccess('masterTireSizeCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('masterTireSizeEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'delete') {
            if (!(Yii::app()->user->checkAccess('masterTireSizeApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'admin') {
            if (!(
                Yii::app()->user->checkAccess('masterTireSizeCreate') || 
                Yii::app()->user->checkAccess('masterTireSizeEdit') ||
                Yii::app()->user->checkAccess('masterTireSizeView') || 
                Yii::app()->user->checkAccess('masterTireSizeApproval')
            )) {
                $this->redirect(array('/site/login'));
            }
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
        $tireSize = $this->instantiate(null, 'create');
        $tireSize->header->user_id_created = Yii::app()->user->id;
        $tireSize->header->created_datetime = date('Y-m-d H:i:s');

        $carModel = new VehicleCarModel('search');
        $carModel->unsetAttributes();  // clear any default values
        if (isset($_GET['VehicleCarModel'])) {
            $carModel->attributes = $_GET['VehicleCarModel'];
        }
        $carModelDataProvider = $carModel->search();

        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandSeries = new SubBrandSeries('search');
        $subBrandSeries->unsetAttributes();  // clear any default values
        if (isset($_GET['SubBrandSeries'])) {
            $subBrandSeries->attributes = $_GET['SubBrandSeries'];
        }
        
        $premiumOptionDataProvider = $subBrandSeries->search();
        $premiumOptionDataProvider->pagination->pageVar = 'premium_page_dialog';
        if (!empty($brandId)) {
            $premiumOptionDataProvider->criteria->compare('subBrand.brand_id', $brandId);
        }

        $standardOptionDataProvider = $subBrandSeries->search();
        $standardOptionDataProvider->pagination->pageVar = 'standard_page_dialog';
        if (!empty($brandId)) {
            $standardOptionDataProvider->criteria->compare('subBrand.brand_id', $brandId);
        }

        $economicOptionDataProvider = $subBrandSeries->search();
        $economicOptionDataProvider->pagination->pageVar = 'economic_page_dialog';
        if (!empty($brandId)) {
            $economicOptionDataProvider->criteria->compare('subBrand.brand_id', $brandId);
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($tireSize);
            
            if ($tireSize->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $tireSize->header->id));
            }
        }

        $this->render('create', array(
            'tireSize' => $tireSize,
            'carModel' => $carModel,
            'carModelDataProvider' => $carModelDataProvider,
            'subBrandSeries' => $subBrandSeries,
            'premiumOptionDataProvider' => $premiumOptionDataProvider,
            'standardOptionDataProvider' => $standardOptionDataProvider,
            'economicOptionDataProvider' => $economicOptionDataProvider,
            'brandId' => $brandId,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $tireSize = $this->instantiate($id, 'create');
        $tireSize->header->user_id_updated = Yii::app()->user->id;
        $tireSize->header->updated_datetime = date('Y-m-d H:i:s');

        $carModel = new VehicleCarModel('search');
        $carModel->unsetAttributes();  // clear any default values
        if (isset($_GET['VehicleCarModel'])) {
            $carModel->attributes = $_GET['VehicleCarModel'];
        }
        $carModelDataProvider = $carModel->search();

        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandSeries = new SubBrandSeries('search');
        $subBrandSeries->unsetAttributes();  // clear any default values
        if (isset($_GET['SubBrandSeries'])) {
            $subBrandSeries->attributes = $_GET['SubBrandSeries'];
        }
        
        $premiumOptionDataProvider = $subBrandSeries->search();
        $premiumOptionDataProvider->pagination->pageVar = 'premium_page_dialog';
        if (!empty($brandId)) {
            $premiumOptionDataProvider->criteria->compare('subBrand.brand_id', $brandId);
        }

        $standardOptionDataProvider = $subBrandSeries->search();
        $standardOptionDataProvider->pagination->pageVar = 'standard_page_dialog';
        if (!empty($brandId)) {
            $standardOptionDataProvider->criteria->compare('subBrand.brand_id', $brandId);
        }

        $economicOptionDataProvider = $subBrandSeries->search();
        $economicOptionDataProvider->pagination->pageVar = 'economic_page_dialog';
        if (!empty($brandId)) {
            $economicOptionDataProvider->criteria->compare('subBrand.brand_id', $brandId);
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($tireSize);
            
            if ($tireSize->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $tireSize->header->id));
            }
        }

        $this->render('update', array(
            'tireSize' => $tireSize,
            'carModel' => $carModel,
            'carModelDataProvider' => $carModelDataProvider,
            'subBrandSeries' => $subBrandSeries,
            'premiumOptionDataProvider' => $premiumOptionDataProvider,
            'standardOptionDataProvider' => $standardOptionDataProvider,
            'economicOptionDataProvider' => $economicOptionDataProvider,
            'brandId' => $brandId,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->is_deleted = 1;
        $model->user_id_deleted = Yii::app()->user->id;
        $model->deleted_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_deleted', 'user_id_deleted', 'deleted_datetime'));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->saveMasterLog($model);
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function saveMasterLog($model) {
        $transactionLog = new MasterLog();
        $transactionLog->name = $model->name;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $model->tableName();
        $transactionLog->table_id = $model->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $model->attributes;
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('TireSize');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TireSize('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TireSize'])) {
            $model->attributes = $_GET['TireSize'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxHtmlAddCarModels($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $tireSize = $this->instantiate($id, '');
            $this->loadState($tireSize);

            if (isset($_POST['CarModelIds'])) {
                foreach ($_POST['CarModelIds'] as $carModelId) {
                    $tireSize->addCarModel($carModelId);
                }
            }

            $this->renderPartial('_detailCarModel', array(
                'tireSize' => $tireSize,
            ));
        }
    }
 
    public function actionAjaxHtmlRemoveCarModelDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $tireSize = $this->instantiate($id, '');
            $this->loadState($tireSize);

            $tireSize->removeCarModelDetailAt($index);

            $this->renderPartial('_detailCarModel', array(
                'tireSize' => $tireSize,
            ));
        }
    }
    
    public function actionAjaxHtmlAddPremiumOptions($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $tireSize = $this->instantiate($id, '');
            $this->loadState($tireSize);

            if (isset($_POST['SubBrandSeriesPremiumIds'])) {
                foreach ($_POST['SubBrandSeriesPremiumIds'] as $subBrandSeriesId) {
                    $tireSize->addPremiumOption($subBrandSeriesId);
                }
            }

            $this->renderPartial('_detailPremiumOption', array(
                'tireSize' => $tireSize,
            ));
        }
    }
 
    public function actionAjaxHtmlRemovePremiumOptionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $tireSize = $this->instantiate($id, '');
            $this->loadState($tireSize);

            $tireSize->removePremiumOptionDetailAt($index);

            $this->renderPartial('_detailPremiumOption', array(
                'tireSize' => $tireSize,
            ));
        }
    }
    
    public function actionAjaxHtmlAddStandardOptions($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $tireSize = $this->instantiate($id, '');
            $this->loadState($tireSize);

            if (isset($_POST['SubBrandSeriesStandardIds'])) {
                foreach ($_POST['SubBrandSeriesStandardIds'] as $subBrandSeriesId) {
                    $tireSize->addStandardOption($subBrandSeriesId);
                }
            }

            $this->renderPartial('_detailStandardOption', array(
                'tireSize' => $tireSize,
            ));
        }
    }
 
    public function actionAjaxHtmlRemoveStandardOptionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $tireSize = $this->instantiate($id, '');
            $this->loadState($tireSize);

            $tireSize->removeStandardOptionDetailAt($index);

            $this->renderPartial('_detailStandardOption', array(
                'tireSize' => $tireSize,
            ));
        }
    }
    
    public function actionAjaxHtmlAddEconomicOptions($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $tireSize = $this->instantiate($id, '');
            $this->loadState($tireSize);

            if (isset($_POST['SubBrandSeriesEconomicIds'])) {
                foreach ($_POST['SubBrandSeriesEconomicIds'] as $subBrandSeriesId) {
                    $tireSize->addEconomicOption($subBrandSeriesId);
                }
            }

            $this->renderPartial('_detailEconomicOption', array(
                'tireSize' => $tireSize,
            ));
        }
    }
 
    public function actionAjaxHtmlRemoveEconomicOptionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $tireSize = $this->instantiate($id, '');
            $this->loadState($tireSize);

            $tireSize->removeEconomicOptionDetailAt($index);

            $this->renderPartial('_detailEconomicOption', array(
                'tireSize' => $tireSize,
            ));
        }
    }
    
    public function loadModel($id) {
        $model = TireSize::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    public function instantiate($id, $actionType) {
        
        if (empty($id)) {
            $tireSizeRecommendation = new TireSizeRecommendation($actionType, new TireSize(), array(), array(), array(), array());
        } else {
            $tireSize = $this->loadModel($id);
            $tireSizeRecommendation = new TireSizeRecommendation($actionType, $tireSize, $tireSize->tireSizeCarModelRecommendations, $tireSize->tireSizePremiumOptions, $tireSize->tireSizeStandardOptions, $tireSize->tireSizeEconomicOptions);
        }
        
        return $tireSizeRecommendation;
    }

    public function loadState($tireSize) {
        if (isset($_POST['TireSize'])) {
            $tireSize->header->attributes = $_POST['TireSize'];
        }
        
        if (isset($_POST['TireSizeCarModelRecommendation'])) {
            foreach ($_POST['TireSizeCarModelRecommendation'] as $i => $item) {
                if (isset($tireSize->carModelDetails[$i])) {
                    $tireSize->carModelDetails[$i]->attributes = $item;
                } else {
                    $detail = new TireSizeCarModelRecommendation();
                    $detail->attributes = $item;
                    $tireSize->carModelDetails[] = $detail;
                }
            }
            if (count($_POST['TireSizeCarModelRecommendation']) < count($tireSize->carModelDetails)) {
                array_splice($tireSize->carModelDetails, $i + 1);
            }
        } else {
            $tireSize->carModelDetails = array();
        }
        
        if (isset($_POST['TireSizePremiumOption'])) {
            foreach ($_POST['TireSizePremiumOption'] as $i => $item) {
                if (isset($tireSize->premiumOptionDetails[$i])) {
                    $tireSize->premiumOptionDetails[$i]->attributes = $item;
                } else {
                    $detail = new TireSizePremiumOption();
                    $detail->attributes = $item;
                    $tireSize->premiumOptionDetails[] = $detail;
                }
            }
            if (count($_POST['TireSizePremiumOption']) < count($tireSize->premiumOptionDetails)) {
                array_splice($tireSize->premiumOptionDetails, $i + 1);
            }
        } else {
            $tireSize->premiumOptionDetails = array();
        }
        
        if (isset($_POST['TireSizeStandardOption'])) {
            foreach ($_POST['TireSizeStandardOption'] as $i => $item) {
                if (isset($tireSize->standardOptionDetails[$i])) {
                    $tireSize->standardOptionDetails[$i]->attributes = $item;
                } else {
                    $detail = new TireSizeStandardOption();
                    $detail->attributes = $item;
                    $tireSize->standardOptionDetails[] = $detail;
                }
            }
            if (count($_POST['TireSizeStandardOption']) < count($tireSize->standardOptionDetails)) {
                array_splice($tireSize->standardOptionDetails, $i + 1);
            }
        } else {
            $tireSize->standardOptionDetails = array();
        }
        
        if (isset($_POST['TireSizeEconomicOption'])) {
            foreach ($_POST['TireSizeEconomicOption'] as $i => $item) {
                if (isset($tireSize->economicOptionDetails[$i])) {
                    $tireSize->economicOptionDetails[$i]->attributes = $item;
                } else {
                    $detail = new TireSizeEconomicOption();
                    $detail->attributes = $item;
                    $tireSize->economicOptionDetails[] = $detail;
                }
            }
            if (count($_POST['TireSizeEconomicOption']) < count($tireSize->economicOptionDetails)) {
                array_splice($tireSize->economicOptionDetails, $i + 1);
            }
        } else {
            $tireSize->economicOptionDetails = array();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param TireSize $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tire-size-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}