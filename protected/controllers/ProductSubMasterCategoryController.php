<?php

class ProductSubMasterCategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	/* public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','ajaxCoa'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ProductSubMasterCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$coaPersediaan = new Coa('search');
      	$coaPersediaan->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaPersediaan->attributes = $_GET['Coa'];
		$coaPersediaanCriteria = new CDbCriteria;
		$coaPersediaanCriteria->addCondition("coa_sub_category_id = 4 and coa_id = 0");
		$coaPersediaanCriteria->compare('code',$coaPersediaan->code.'%',true,'AND', false);
		$coaPersediaanCriteria->compare('name',$coaPersediaan->name,true);
	  	$coaPersediaanDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaPersediaanCriteria,
	  	));	

	  	$coaHpp = new Coa('search');
      	$coaHpp->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaHpp->attributes = $_GET['Coa'];
		$coaHppCriteria = new CDbCriteria;
		$coaHppCriteria->addCondition("coa_sub_category_id = 41 and coa_id = 0");
		$coaHppCriteria->compare('code',$coaHpp->code.'%',true,'AND', false);
		$coaHppCriteria->compare('name',$coaHpp->name,true);
	  	$coaHppDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaHppCriteria,
	  	));	

	  	$coaPenjualan = new Coa('search');
      	$coaPenjualan->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaPenjualan->attributes = $_GET['Coa'];
		$coaPenjualanCriteria = new CDbCriteria;
		$coaPenjualanCriteria->addCondition("coa_sub_category_id = 23 and coa_id = 0");
		$coaPenjualanCriteria->compare('code',$coaPenjualan->code.'%',true,'AND', false);
		$coaPenjualanCriteria->compare('name',$coaPenjualan->name,true);
	  	$coaPenjualanDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaPenjualanCriteria,
	  	));	

	  	$coaRetur = new Coa('search');
      	$coaRetur->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaRetur->attributes = $_GET['Coa'];
		$coaReturCriteria = new CDbCriteria;
		$coaReturCriteria->addCondition("coa_sub_category_id = 25 and coa_id = 0");
		$coaReturCriteria->compare('code',$coaRetur->code.'%',true,'AND', false);
		$coaReturCriteria->compare('name',$coaRetur->name,true);
	  	$coaReturDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaReturCriteria,
	  	));	

	  	$coaDiskon = new Coa('search');
      	$coaDiskon->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaDiskon->attributes = $_GET['Coa'];
		$coaDiskonCriteria = new CDbCriteria;
		$coaDiskonCriteria->addCondition("coa_sub_category_id = 24 and coa_id = 0");
		$coaDiskonCriteria->compare('code',$coaDiskon->code.'%',true,'AND', false);
		$coaDiskonCriteria->compare('name',$coaDiskon->name,true);
	  	$coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaDiskonCriteria,
	  	));	

	  	$coaReturPembelian = new Coa('search');
      	$coaReturPembelian->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaReturPembelian->attributes = $_GET['Coa'];
		$coaReturPembelianCriteria = new CDbCriteria;
		$coaReturPembelianCriteria->addCondition("coa_sub_category_id = 45 and coa_id = 0");
		$coaReturPembelianCriteria->compare('code',$coaReturPembelian->code.'%',true,'AND', false);
		$coaReturPembelianCriteria->compare('name',$coaReturPembelian->name,true);
	  	$coaReturPembelianDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaReturPembelianCriteria,
	  	));	

	  	$coaDiskonPembelian = new Coa('search');
      	$coaDiskonPembelian->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaDiskonPembelian->attributes = $_GET['Coa'];
		$coaDiskonPembelianCriteria = new CDbCriteria;
		$coaDiskonPembelianCriteria->addCondition("coa_sub_category_id = 44 and coa_id = 0");
		$coaDiskonPembelianCriteria->compare('code',$coaDiskonPembelian->code.'%',true,'AND', false);
		$coaDiskonPembelianCriteria->compare('name',$coaDiskonPembelian->name,true);
	  	$coaDiskonPembelianDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaDiskonPembelianCriteria,
	  	));	

	  	$coaInventory = new Coa('search');
      	$coaInventory->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaInventory->attributes = $_GET['Coa'];
		$coaInventoryCriteria = new CDbCriteria;
		$coaInventoryCriteria->addCondition("coa_sub_category_id = 44 and coa_id = 0");
		$coaInventoryCriteria->compare('code',$coaInventory->code.'%',true,'AND', false);
		$coaInventoryCriteria->compare('name',$coaInventory->name,true);
	  	$coaInventoryDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaInventoryCriteria,
	  	));	


		if(isset($_POST['ProductSubMasterCategory']))
		{
			$model->attributes=$_POST['ProductSubMasterCategory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'coaPersediaan'=>$coaPersediaan,
			'coaPersediaanDataProvider'=>$coaPersediaanDataProvider,
			'coaHpp'=>$coaHpp,
			'coaHppDataProvider'=>$coaHppDataProvider,
			'coaPenjualan'=>$coaPenjualan,
			'coaPenjualanDataProvider'=>$coaPenjualanDataProvider,
			'coaRetur'=>$coaRetur,
			'coaReturDataProvider'=>$coaReturDataProvider,
			'coaDiskon'=>$coaDiskon,
			'coaDiskonDataProvider'=>$coaDiskonDataProvider,
			'coaReturPembelian'=>$coaReturPembelian,
			'coaReturPembelianDataProvider'=>$coaReturPembelianDataProvider,
			'coaDiskonPembelian'=>$coaDiskonPembelian,
			'coaDiskonPembelianDataProvider'=>$coaDiskonPembelianDataProvider,
			'coaInventory'=>$coaInventory,
			'coaInventoryDataProvider'=>$coaInventoryDataProvider
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$coaPersediaan = new Coa('search');
      	$coaPersediaan->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaPersediaan->attributes = $_GET['Coa'];
		$coaPersediaanCriteria = new CDbCriteria;
		$coaPersediaanCriteria->addCondition("coa_sub_category_id = 4 and coa_id = 0");
		$coaPersediaanCriteria->compare('code',$coaPersediaan->code.'%',true,'AND', false);
		$coaPersediaanCriteria->compare('name',$coaPersediaan->name,true);
	  	$coaPersediaanDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaPersediaanCriteria,
	  	));	

	  	$coaHpp = new Coa('search');
      	$coaHpp->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaHpp->attributes = $_GET['Coa'];
		$coaHppCriteria = new CDbCriteria;
		$coaHppCriteria->addCondition("coa_sub_category_id = 41 and coa_id = 0");
		$coaHppCriteria->compare('code',$coaHpp->code.'%',true,'AND', false);
		$coaHppCriteria->compare('name',$coaHpp->name,true);
	  	$coaHppDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaHppCriteria,
	  	));	

	  	$coaPenjualan = new Coa('search');
      	$coaPenjualan->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaPenjualan->attributes = $_GET['Coa'];
		$coaPenjualanCriteria = new CDbCriteria;
		$coaPenjualanCriteria->addCondition("coa_sub_category_id = 23 and coa_id = 0");
		$coaPenjualanCriteria->compare('code',$coaPenjualan->code.'%',true,'AND', false);
		$coaPenjualanCriteria->compare('name',$coaPenjualan->name,true);
	  	$coaPenjualanDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaPenjualanCriteria,
	  	));	

	  	$coaRetur = new Coa('search');
      	$coaRetur->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaRetur->attributes = $_GET['Coa'];
		$coaReturCriteria = new CDbCriteria;
		$coaReturCriteria->addCondition("coa_sub_category_id = 25 and coa_id = 0");
		$coaReturCriteria->compare('code',$coaRetur->code.'%',true,'AND', false);
		$coaReturCriteria->compare('name',$coaRetur->name,true);
	  	$coaReturDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaReturCriteria,
	  	));	

	  	$coaDiskon = new Coa('search');
      	$coaDiskon->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaDiskon->attributes = $_GET['Coa'];
		$coaDiskonCriteria = new CDbCriteria;
		$coaDiskonCriteria->addCondition("coa_sub_category_id = 24 and coa_id = 0");
		$coaDiskonCriteria->compare('code',$coaDiskon->code.'%',true,'AND', false);
		$coaDiskonCriteria->compare('name',$coaDiskon->name,true);
	  	$coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaDiskonCriteria,
	  	));	

	  	$coaReturPembelian = new Coa('search');
      	$coaReturPembelian->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaReturPembelian->attributes = $_GET['Coa'];
		$coaReturPembelianCriteria = new CDbCriteria;
		$coaReturPembelianCriteria->addCondition("coa_sub_category_id = 45 and coa_id = 0");
		$coaReturPembelianCriteria->compare('code',$coaReturPembelian->code.'%',true,'AND', false);
		$coaReturPembelianCriteria->compare('name',$coaReturPembelian->name,true);
	  	$coaReturPembelianDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaReturPembelianCriteria,
	  	));	

	  	$coaDiskonPembelian = new Coa('search');
      	$coaDiskonPembelian->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaDiskonPembelian->attributes = $_GET['Coa'];
		$coaDiskonPembelianCriteria = new CDbCriteria;
		$coaDiskonPembelianCriteria->addCondition("coa_sub_category_id = 44 and coa_id = 0");
		$coaDiskonPembelianCriteria->compare('code',$coaDiskonPembelian->code.'%',true,'AND', false);
		$coaDiskonPembelianCriteria->compare('name',$coaDiskonPembelian->name,true);
	  	$coaDiskonPembelianDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaDiskonPembelianCriteria,
	  	));	

	  	$coaInventory = new Coa('search');
      	$coaInventory->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaInventory->attributes = $_GET['Coa'];
		$coaInventoryCriteria = new CDbCriteria;
		$coaInventoryCriteria->addCondition("coa_sub_category_id = 44 and coa_id = 0");
		$coaInventoryCriteria->compare('code',$coaInventory->code.'%',true,'AND', false);
		$coaInventoryCriteria->compare('name',$coaInventory->name,true);
	  	$coaInventoryDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaInventoryCriteria,
	  	));	
	  	
		if(isset($_POST['ProductSubMasterCategory']))
		{
			$model->attributes=$_POST['ProductSubMasterCategory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'coaPersediaan'=>$coaPersediaan,
			'coaPersediaanDataProvider'=>$coaPersediaanDataProvider,
			'coaHpp'=>$coaHpp,
			'coaHppDataProvider'=>$coaHppDataProvider,
			'coaPenjualan'=>$coaPenjualan,
			'coaPenjualanDataProvider'=>$coaPenjualanDataProvider,
			'coaRetur'=>$coaRetur,
			'coaReturDataProvider'=>$coaReturDataProvider,
			'coaDiskon'=>$coaDiskon,
			'coaDiskonDataProvider'=>$coaDiskonDataProvider,
			'coaReturPembelian'=>$coaReturPembelian,
			'coaReturPembelianDataProvider'=>$coaReturPembelianDataProvider,
			'coaDiskonPembelian'=>$coaDiskonPembelian,
			'coaDiskonPembelianDataProvider'=>$coaDiskonPembelianDataProvider,
			'coaInventory'=>$coaInventory,
			'coaInventoryDataProvider'=>$coaInventoryDataProvider
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ProductSubMasterCategory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ProductSubMasterCategory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProductSubMasterCategory']))
			$model->attributes=$_GET['ProductSubMasterCategory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ProductSubMasterCategory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProductSubMasterCategory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProductSubMasterCategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-sub-master-category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionAjaxCoa($id){
        if (Yii::app()->request->isAjaxRequest)
        {
            $coa = Coa::model()->findByPk($id);

            $object = array(
        		'id' => $coa->id,
                'code' => $coa->code,
                'name' => $coa->name,
            );

            echo CJSON::encode($object);
        }
  	}
}
