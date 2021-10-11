<?php

class PositionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterPositionCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'restore' || 
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterPositionEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('masterPositionCreate')) || !(Yii::app()->user->checkAccess('masterPositionEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $positionLevels = PositionLevel::model()->findAllByAttributes(array('position_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'positionLevels' => $positionLevels,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        // $model=new Position;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['Position']))
        // {
        // 	$model->attributes=$_POST['Position'];
        // 	$model->status='Active';
        // 	if($model->save())
        // 		$this->redirect(array('admin'));
        // 		//$this->redirect(array('view','id'=>$model->id));
        // }

        $position = $this->instantiate(null);

        $level = new Level('search');
        $level->unsetAttributes();  // clear any default values
        if (isset($_GET['Level']))
            $level->attributes = $_GET['Level'];

        $levelCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $levelCriteria->compare('name', $level->name, true);

        $levelDataProvider = new CActiveDataProvider('Level', array(
            'criteria' => $levelCriteria,
        ));


        $this->performAjaxValidation($position->header);
        $levelArray = array();
        if (isset($_POST['Position'])) {

            // echo "a";
            $this->loadState($position);
            if ($position->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $position->header->id));
            }/*  else {
              foreach ($position->levelDetails as $key => $levelDetail) {
              print_r(CJSON::encode($levelDetail->id));
              }
              } */
        }

        $this->render('create', array(
            //'model'=>$model,
            'position' => $position,
            'level' => $level,
            'levelDataProvider' => $levelDataProvider,
            'levelArray' => $levelArray,
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
        // if(isset($_POST['Position']))
        // {
        // 	$model->attributes=$_POST['Position'];
        // 	if($model->save())
        // 		$this->redirect(array('admin'));
        // 		//$this->redirect(array('view','id'=>$model->id));
        // }
        $level = new Level('search');
        $level->unsetAttributes();  // clear any default values
        if (isset($_GET['Level']))
            $level->attributes = $_GET['Level'];

        $levelCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $levelCriteria->compare('name', $level->name, true);

        $levelDataProvider = new CActiveDataProvider('Level', array(
            'criteria' => $levelCriteria,
        ));

        $position = $this->instantiate($id);

        $this->performAjaxValidation($position->header);
        $levelChecks = PositionLevel::model()->findAllByAttributes(array('position_id' => $id));
        $levelArray = array();
        foreach ($levelChecks as $key => $levelCheck) {
            array_push($levelArray, $levelCheck->level_id);
        }
        //print_r($levelArray);

        if (isset($_POST['Position'])) {


            $this->loadState($position);
            if ($position->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $position->header->id));
            }/* else {
              foreach ($position->levelDetails as $key => $levelDetail) {
              print_r(CJSON::encode($levelDetail->id));
              }
              } */
        }

        $this->render('update', array(
            //'model'=>$model,
            'position' => $position,
            'level' => $level,
            'levelDataProvider' => $levelDataProvider,
            'levelArray' => $levelArray,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->remove();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionRestore($id) {
        // var_dump($id); die("S");
        $this->loadModel($id)->restore();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Position');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Position('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Position']))
            $model->attributes = $_GET['Position'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    //Add Level Detail
    public function actionAjaxHtmlAddLevelDetail($id, $positionId) {
        if (Yii::app()->request->isAjaxRequest) {
            $position = $this->instantiate($id);
            $this->loadState($position);

            $position->addLevelDetail($positionId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailLevel', array('position' => $position), false, true);
        }
    }

    //Delete Level Detail
    public function actionAjaxHtmlRemoveLevelDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $position = $this->instantiate($id);
            $this->loadState($position);
            //print_r(CJSON::encode($salesOrder->details));
            $position->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailLevel', array('position' => $position), false, true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $position = new Positions(new Position(), array());
            //print_r("test");
        } else {
            $positionModel = $this->loadModel($id);
            $position = new Positions($positionModel, $positionModel->positionLevels);
        }
        return $position;
    }

    public function loadState($position) {
        if (isset($_POST['Position'])) {
            $position->header->attributes = $_POST['Position'];
        }
        if (isset($_POST['PositionLevel'])) {
            foreach ($_POST['PositionLevel'] as $i => $item) {
                if (isset($position->levelDetails[$i]))
                    $position->levelDetails[$i]->attributes = $item;
                else {
                    $detail = new PositionLevel();
                    $detail->attributes = $item;
                    $position->levelDetails[] = $detail;
                    //echo "test";
                }
            }
            if (count($_POST['PositionLevel']) < count($position->levelDetails))
                array_splice($position->levelDetails, $i + 1);
        } else
            $position->levelDetails = array();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Position the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Position::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Position $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'position-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxHtmlCreate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Position;

            if (isset($_POST['Position'])) {
                $model->attributes = $_POST['Position'];
                if ($model->save()) {
                    echo CHtml::script('window.location.href = "' . Yii::app()->user->getReturnUrl(array('admin')) . '";');
                    Yii::app()->end();
                }
            }

            $this->renderPartial('_create-dialog', array(
                'model' => $model,
                    ), false, true);
        }
    }

    public function actionAjaxHtmlUpdate($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);

            if (isset($_POST['Position'])) {
                $model->attributes = $_POST['Position'];
                if ($model->save()) {
                    echo CHtml::script('window.location.href = "' . Yii::app()->user->getReturnUrl(array('admin')) . '";');
                    Yii::app()->end();
                }
            }

            $this->renderPartial('_update-dialog', array(
                'model' => $model,
                    ), false, true);
        }
    }

}
