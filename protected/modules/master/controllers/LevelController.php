<?php

class LevelController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'restore' || 
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'dialogUpdate'
        ) {
            if (!(Yii::app()->user->checkAccess('generalManager')))
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
        $model = new Level;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'level-form') {
            echo 'here';
            echo CActiveForm::validate($model);
            exit;
            Yii::app()->end();
        }

        if (isset($_POST['Level'])) {
            $model->attributes = $_POST['Level'];
            $model->status = 'Active';
            if ($model->save())
                $this->redirect(array('admin'));
            //$this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['Level'])) {
            $model->attributes = $_POST['Level'];
            if ($model->save())
            //$this->redirect(array('view','id'=>$model->id));
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
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
        $fs = $this->loadModel($id)->restore();
        // $fs=Level::model()->findByPk((int)$id);
        // var_dump($fs); 
        // die("show");
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Level');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Level('search');
        //$model->disableBehavior('SoftDelete');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Level']))
            $model->attributes = $_GET['Level'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Level the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Level::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Level $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'level-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxHtmlCreate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Level;

            $this->renderPartial('_create-dialog', array(
                'model' => $model,
                    ), false, true);
        }
    }

    public function actionAjaxHtmlSave() {
        if (Yii::app()->request->isAjaxRequest) {
            // var_dump($id); die("S");
            // if ($id == 0) {
            // 	$model = new Level;
            // }else{
            // 	$model = $this->loadModel($id);
            // }


            if (isset($_POST['Level'])) {
                // var_dump($_POST['Level']); die("S");
                $isiID = $_POST['Level']['id'];
                if (!empty($isiID)) {
                    $model = $this->loadModel($isiID);
                } else {
                    $model = new Level;
                }
                $model->attributes = $_POST['Level'];
                if ($model->save()) {
                    echo CHtml::script('window.location.href = "' . Yii::app()->user->getReturnUrl(array('admin')) . '";');
                    Yii::app()->end();
                }
            }
        }
    }

    public function actionAjaxHtmlUpdate($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);

            // if (isset($_POST['Level']))
            // {
            // 	$model->attributes = $_POST['Level'];
            // 	if ($model->save())
            // 	{
            // 		echo CHtml::script('window.location.href = "' . Yii::app()->user->getReturnUrl(array('admin')) . '";');
            // 		Yii::app()->end();
            // 	}
            // }

            $this->renderPartial('_update-dialog', array(
                'model' => $model,
                    ), false, true);
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionDialogUpdate($id) {

        $model = Level::model()->findByPk($id);
        print_r($model);
        return json_encode($model);
        exit;
        /* $layout='//layouts/backend';


          // Uncomment the following line if AJAX validation is needed
          // $this->performAjaxValidation($model);

          if(isset($_POST['Level']))
          {
          $model->attributes=$_POST['Level'];
          if($model->save())
          //$this->redirect(array('view','id'=>$model->id));
          $this->redirect(array('admin'));
          }

          $this->renderPartial('dialog',array(
          'model'=>$model,
          )); */
    }

}
