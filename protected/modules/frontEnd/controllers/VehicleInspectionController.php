<?php

class VehicleInspectionController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'inspection' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('inspectionCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'inspection' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('inspectionEdit'))) {
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
            'vehicleInspection' => $this->instantiate($id),
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $vehicleInspection = $this->instantiate(null);
        $vehicleInspection->header->inspection_date = date('Y-m-d');

        $vehicleInspectionDetail = new VehicleInspectionDetail('search');
        $vehicleInspectionDetail->unsetAttributes();  // clear any default values
        
        if (isset($_GET['VehicleInspectionDetail']))
            $vehicleInspection->attributes = $_GET['VehicleInspectionDetail'];

        $vehicleInspectionDetailCriteria = new CDbCriteria;
        $vehicleInspectionDetailDataProvider = new CActiveDataProvider('VehicleInspectionDetail', array(
            'criteria' => $vehicleInspectionDetailCriteria,
        ));

        $this->performAjaxValidation($vehicleInspection->header);

        if (isset($_POST['VehicleInspection'])) {
            $this->loadState($vehicleInspection);
            
            if ($vehicleInspection->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $vehicleInspection->header->id));
            }
        }

        $this->render('create', array(
            'vehicleInspection' => $vehicleInspection,
            'vehicleInspectionDetail' => $vehicleInspectionDetail,
            'vehicleInspectionDetailDataProvider' => $vehicleInspectionDetailDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //$model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $vehicleInspectionDetail = new VehicleInspectionDetail('search');
        $vehicleInspectionDetail->unsetAttributes();  // clear any default values
        if (isset($_GET['VehicleInspectionDetail']))
            $vehicleInspection->attributes = $_GET['VehicleInspectionDetail'];

        $vehicleInspectionDetailCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        //$vehicleInspectionDetailCriteria->compare('name',$vehicleInspectionDetail->name,true);

        $vehicleInspectionDetailDataProvider = new CActiveDataProvider('VehicleInspectionDetail', array(
            'criteria' => $vehicleInspectionDetailCriteria,
        ));

        $vehicleInspection = $this->instantiate($id);
        $this->performAjaxValidation($vehicleInspection->header);

        if (isset($_POST['VehicleInspection'])) {
            $this->loadState($vehicleInspection);
            if ($vehicleInspection->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $vehicleInspection->header->id));
            } else {
                foreach ($vehicleInspection->vehicleInspectionDetails as $key => $vehicleInspectionDetail) {
                    //print_r(CJSON::encode($vehicleInspectionDetail->id));
                }
            }
        }

        $this->render('update', array(
            //'model'=>$model,
            'vehicleInspection' => $vehicleInspection,
            'vehicleInspectionDetail' => $vehicleInspectionDetail,
            'vehicleInspectionDetailDataProvider' => $vehicleInspectionDetailDataProvider,
                //'sectionArray'=>$sectionArray,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('VehicleInspection');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $vehicle = new RegistrationTransaction('search');
        $vehicle->unsetAttributes();  // clear any default values
        
        if (isset($_GET['RegistrationTransaction'])) {
            $vehicle->attributes = $_GET['RegistrationTransaction'];
        }
        $vehicleDataProvider = $vehicle->searchAdmin();
        $vehicleDataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $vehicleDataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;

        $this->render('admin', array(
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider
        ));
    }

    /**
     * Vehicles with inspections.
     */
    public function actionInspection($vehicleId, $wonumber) {
        $vehicleInspection = new VehicleInspection('search');
        $vehicleInspection->unsetAttributes();  // clear any default values
        
        if (isset($_GET['vehicleInspection']))
            $vehicleInspection->attributes = $_GET['VehicleInspection'];

        $vehicleInspectionCriteria = new CDbCriteria;
        $vehicleInspectionCriteria->condition = 't.work_order_number = ' . $wonumber;

        $vehicleInspectionDataProvider = new CActiveDataProvider('VehicleInspection', array(
            'criteria' => $vehicleInspectionCriteria,
        ));

        $vehicle = Vehicle::model()->findByPk($vehicleId);

        $this->render('inspection', array(
            'vehicle' => $vehicle,
            'vehicleInspection' => $vehicleInspection,
            'vehicleInspectionDataProvider' => $vehicleInspectionDataProvider
        ));
    }

    public function actionPrintPdf($id) {
        $vehicleInspection = $this->loadModel($id);

        $vehicle = Vehicle::model()->findByPk($vehicleInspection->vehicle_id);
        $registrationTransaction = RegistrationTransaction::model()->findByAttributes(array('work_order_number' => $vehicleInspection->work_order_number));
        $modules = InspectionChecklistModule::model()->findAllByAttributes(array('id' => array(1, 2, 3, 4)));
        
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('printPdf', array(
            'vehicleInspection' => $vehicleInspection, 
            'vehicle' => $vehicle, 
            'modules' => $modules,
            'registrationTransaction' => $registrationTransaction,
        ), true));
        $mPDF1->Output();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return VehicleInspection the loaded model
     * @throws CHttpException
     */
    //Add Checklist Module Detail
    public function actionAjaxHtmlAddVehicleInspectionDetail($id, $inspectionId) {
        if (Yii::app()->request->isAjaxRequest) {
            $vehicleInspection = $this->instantiate($id);
            //$this->loadState($vehicleInspection);

            $vehicleInspection->addVehicleInspectionDetail($inspectionId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailVehicleInspectionDetail', array('vehicleInspection' => $vehicleInspection), false, true);
        }
    }

    //Delete Checklist Module Detail
    public function actionAjaxHtmlRemoveSectionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $inspection = $this->instantiate($id);
            $this->loadState($inspection);
            //print_r(CJSON::encode($salesOrder->details));
            $inspection->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailSection', array('inspection' => $inspection), false, true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $vehicleInspection = new VehicleInspections(new VehicleInspection(), array());
            //print_r("test");
        } else {
            $vehicleInspectionModel = $this->loadModel($id);
            $vehicleInspection = new VehicleInspections($vehicleInspectionModel, $vehicleInspectionModel->vehicleInspectionDetails);
        }
        return $vehicleInspection;
    }

    public function loadState($vehicleInspection) {
        if (isset($_POST['VehicleInspection'])) {
            $vehicleInspection->header->attributes = $_POST['VehicleInspection'];
        }

        if (isset($_POST['VehicleInspectionDetail'])) {
            foreach ($_POST['VehicleInspectionDetail'] as $i => $item) {
                if (isset($vehicleInspection->vehicleInspectionDetails[$i]))
                    $vehicleInspection->vehicleInspectionDetails[$i]->attributes = $item;
                else {
                    $detail = new VehicleInspectionDetail();
                    $detail->attributes = $item;
                    $vehicleInspection->vehicleInspectionDetails[] = $detail;
                    //echo "test";
                }
            }
            if (count($_POST['VehicleInspectionDetail']) < count($vehicleInspection->vehicleInspectionDetails))
                array_splice($vehicleInspection->vehicleInspectionDetails, $i + 1);
        } else
            $vehicleInspection->vehicleInspectionDetails = array();
    }

    public function loadModel($id) {
        $model = VehicleInspection::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param VehicleInspection $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vehicle-inspection-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
