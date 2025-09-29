<?php

class InspectionController extends Controller {

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
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('frontOfficeHead')) || !(Yii::app()->user->checkAccess('operationHead'))) {
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
        $model = $this->loadModel($id);
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($model);
        }

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Inspection;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        /* if(isset($_POST['Inspection']))
          {
          $model->attributes=$_POST['Inspection'];
          if($model->save())
          $this->redirect(array('view','id'=>$model->id));
          }

          $this->render('create',array(
          'model'=>$model,
          )); */

        $inspection = $this->instantiate(null);

        $section = new InspectionSection('search');
        $section->unsetAttributes();  // clear any default values
        if (isset($_GET['InspectionSection']))
            $section->attributes = $_GET['InspectionSection'];

        $sectionCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $sectionCriteria->compare('name', $section->name, true);

        $sectionDataProvider = new CActiveDataProvider('InspectionSection', array(
            'criteria' => $sectionCriteria,
        ));


        $this->performAjaxValidation($inspection->header);
        $sectionArray = array();
        if (isset($_POST['Inspection'])) {
            $this->loadState($inspection);
            if ($inspection->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $inspection->header->id));
            } else {
                foreach ($inspection->sectionDetails as $key => $sectionDetail) {
                    print_r(CJSON::encode($sectionDetail->id));
                }
            }
        }

        $this->render('create', array(
            //'model'=>$model,
            'inspection' => $inspection,
            'section' => $section,
            'sectionDataProvider' => $sectionDataProvider,
            'sectionArray' => $sectionArray,
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

        $inspection = $this->instantiate(null);

        $section = new InspectionSection('search');
        $section->unsetAttributes();  // clear any default values
        if (isset($_GET['InspectionSection']))
            $section->attributes = $_GET['InspectionSection'];

        $sectionCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $sectionCriteria->compare('name', $section->name, true);

        $sectionDataProvider = new CActiveDataProvider('InspectionSection', array(
            'criteria' => $sectionCriteria,
        ));

        $sectionChecks = InspectionSections::model()->findAllByAttributes(array('inspection_id' => $id));
        $sectionArray = array();
        foreach ($sectionChecks as $key => $sectionCheck) {
            array_push($sectionArray, $sectionCheck->section_id);
        }

        $inspection = $this->instantiate($id);
        $this->performAjaxValidation($inspection->header);

        if (isset($_POST['Inspection'])) {
            /* $model->attributes=$_POST['InspectionSection'];
              if($model->save())
              $this->redirect(array('view','id'=>$model->id)); */

            $this->loadState($inspection);
            if ($inspection->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $inspection->header->id));
        }

        $this->render('update', array(
            //'model'=>$model,
            'inspection' => $inspection,
            'section' => $section,
            'sectionDataProvider' => $sectionDataProvider,
            'sectionArray' => $sectionArray,
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
        $dataProvider = new CActiveDataProvider('Inspection');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Inspection('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Inspection']))
            $model->attributes = $_GET['Inspection'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Inspection the loaded model
     * @throws CHttpException
     */
    //Add Checklist Module Detail
    public function actionAjaxHtmlAddSectionDetail($id, $sectionId) {
        if (Yii::app()->request->isAjaxRequest) {
            $inspection = $this->instantiate($id);
            $this->loadState($inspection);

            $inspection->addSectionDetail($sectionId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailSection', array('inspection' => $inspection), false, true);
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
            $inspection = new Inspections(new Inspection(), array());
            //print_r("test");
        } else {
            $inspectionModel = $this->loadModel($id);
            $inspection = new Inspections($inspectionModel, $inspectionModel->inspectionSections);
        }
        return $inspection;
    }

    public function loadState($inspection) {
        if (isset($_POST['Inspection'])) {
            $inspection->header->attributes = $_POST['Inspection'];
        }

        if (isset($_POST['InspectionSections'])) {
            foreach ($_POST['InspectionSections'] as $i => $item) {
                if (isset($inspection->sectionDetails[$i]))
                    $inspection->sectionDetails[$i]->attributes = $item;
                else {
                    $detail = new InspectionSections();
                    $detail->attributes = $item;
                    $inspection->sectionDetails[] = $detail;
                    //echo "test";
                }
            }
            if (count($_POST['InspectionSections']) < count($inspection->sectionDetails))
                array_splice($inspection->sectionDetails, $i + 1);
        } else
            $inspection->sectionDetails = array();
    }

    public function loadModel($id) {
        $model = Inspection::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Inspection $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'inspection-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function saveToExcel($model) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Master Inspection');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Master Inspection');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');

        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Master Inspection');

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Inspection');
        $worksheet->setCellValue('D5', 'Section Code');
        $worksheet->setCellValue('E5', 'Section Name');
        $worksheet->setCellValue('F5', 'Module Code');
        $worksheet->setCellValue('G5', 'Module Name');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $inspectionSections = InspectionSections::model()->findAllByAttributes(array('inspection_id' => $model->id));
        foreach ($inspectionSections as $inspectionSection) {
            $sectionModules = InspectionSectionModule::model()->findAllByAttributes(array('section_id' => $inspectionSection->section_id));
            foreach ($sectionModules as $sectionModule) {
                $worksheet->setCellValue("A{$counter}", CHtml::value($model, 'id'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($model, 'code'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($model, 'name'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($inspectionSection, 'section.code'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($inspectionSection, 'section.name'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($sectionModule, 'module.code'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($sectionModule, 'module.name'));

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="master_inspection.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
