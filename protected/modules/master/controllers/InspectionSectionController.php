<?php

class InspectionSectionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index'
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
        $model = new InspectionSection;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        /* if(isset($_POST['InspectionSection']))
          {
          $model->attributes=$_POST['InspectionSection'];
          if($model->save())
          $this->redirect(array('view','id'=>$model->id));
          }

          $this->render('create',array(
          'model'=>$model,
          )); */

        $section = $this->instantiate(null);

        $module = new InspectionModule('search');
        $module->unsetAttributes();  // clear any default values
        if (isset($_GET['InspectionModule']))
            $module->attributes = $_GET['InspectionModule'];

        $moduleCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $moduleCriteria->compare('name', $module->name, true);

        $moduleDataProvider = new CActiveDataProvider('InspectionModule', array(
            'criteria' => $moduleCriteria,
        ));


        $this->performAjaxValidation($section->header);
        $moduleArray = array();
        if (isset($_POST['InspectionSection'])) {
            $this->loadState($section);
            if ($section->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $section->header->id));
            } else {
                foreach ($section->moduleDetails as $key => $moduleDetail) {
                    print_r(CJSON::encode($moduleDetail->id));
                }
            }
        }

        $this->render('create', array(
            //'model'=>$model,
            'section' => $section,
            'module' => $module,
            'moduleDataProvider' => $moduleDataProvider,
            'moduleArray' => $moduleArray,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $section = $this->instantiate(null);

        $module = new InspectionModule('search');
        $module->unsetAttributes();  // clear any default values
        if (isset($_GET['InspectionModule']))
            $module->attributes = $_GET['InspectionModule'];

        $moduleCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $moduleCriteria->compare('name', $module->name, true);

        $moduleDataProvider = new CActiveDataProvider('InspectionModule', array(
            'criteria' => $moduleCriteria,
        ));

        $moduleChecks = InspectionSectionModule::model()->findAllByAttributes(array('section_id' => $id));
        $moduleArray = array();
        foreach ($moduleChecks as $key => $moduleCheck) {
            array_push($moduleArray, $moduleCheck->module_id);
        }

        $section = $this->instantiate($id);
        $this->performAjaxValidation($section->header);

        if (isset($_POST['InspectionSection'])) {
            /* $model->attributes=$_POST['InspectionSection'];
              if($model->save())
              $this->redirect(array('view','id'=>$model->id)); */

            $this->loadState($section);
            if ($section->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $section->header->id));
        }

        $this->render('update', array(
            //'model'=>$model,
            'section' => $section,
            'module' => $module,
            'moduleDataProvider' => $moduleDataProvider,
            'moduleArray' => $moduleArray
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
        $dataProvider = new CActiveDataProvider('InspectionSection');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new InspectionSection('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InspectionSection']))
            $model->attributes = $_GET['InspectionSection'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return InspectionSection the loaded model
     * @throws CHttpException
     */
    //Add Checklist Module Detail
    public function actionAjaxHtmlAddModuleDetail($id, $moduleId) {
        if (Yii::app()->request->isAjaxRequest) {
            $section = $this->instantiate($id);
            $this->loadState($section);

            $section->addModuleDetail($moduleId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailModule', array('section' => $section), false, true);
        }
    }

    //Delete Checklist Module Detail
    public function actionAjaxHtmlRemoveModuleDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $section = $this->instantiate($id);
            $this->loadState($section);
            //print_r(CJSON::encode($salesOrder->details));
            $section->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailModule', array('section' => $section), false, true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $section = new Sections(new InspectionSection(), array());
            //print_r("test");
        } else {
            $sectionModel = $this->loadModel($id);
            $section = new Sections($sectionModel, $sectionModel->inspectionSectionModules);
        }
        return $section;
    }

    public function loadState($section) {
        if (isset($_POST['InspectionSection'])) {
            $section->header->attributes = $_POST['InspectionSection'];
        }

        if (isset($_POST['InspectionSectionModule'])) {
            foreach ($_POST['InspectionSectionModule'] as $i => $item) {
                if (isset($section->moduleDetails[$i]))
                    $section->moduleDetails[$i]->attributes = $item;
                else {
                    $detail = new InspectionSectionModule();
                    $detail->attributes = $item;
                    $section->moduleDetails[] = $detail;
                    //echo "test";
                }
            }
            if (count($_POST['InspectionSectionModule']) < count($section->moduleDetails))
                array_splice($section->moduleDetails, $i + 1);
        } else
            $section->moduleDetails = array();
    }

    public function loadModel($id) {
        $model = InspectionSection::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InspectionSection $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'inspection-section-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
