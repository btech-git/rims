<?php

class ForecastingProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';

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
				'actions'=>array('admin','delete'),
				'users'=>array('Admin'),
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
		$model=new Inventory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventory']))
		{
			$model->attributes=$_POST['Inventory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Inventory']))
		{
			$model->attributes=$_POST['Inventory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('Inventory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Inventory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inventory']))
			$model->attributes=$_GET['Inventory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionCalculate() 
	{
		// die("asd");
		if(Yii::app()->request->isAjaxRequest) {
			// echo "asd";
			$inventory_id=$_POST['inventory_id'];
			$product_average=$_POST['product_average'];
			$product_stock=$_POST['product_stock'];
			$product_category=$_POST['
			'];

			$calculate_result = $product_category * $product_average + $product_stock;//calculate result

			$updateInventory = $this->loadModel($inventory_id);
			$updateInventory->category = $product_category;
			$updateInventory->inventory_result = $calculate_result;
			$updateInventory->save();

			var_dump($updateInventory);


		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inventory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inventory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inventory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inventory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}



	public function actionAjaxGetProductSubMasterCategory()
	{
		$data = ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id'=>$_POST['Inventory']['product_master_category_id']), array('order' => 'name'));
		if(count($data) > 0)
		{
			$data=CHtml::listData($data,'id','name');
			echo CHtml::tag('option',array('value'=>''),'[--Select Product Sub Master Category--]',true);
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			}
		}
		else
		{
			echo CHtml::tag('option',array('value'=>''),'[--Select Product Sub Master Category--]',true);
		}
	}

	public function actionAjaxGetSubBrand()
	{
		$data = SubBrand::model()->findAllByAttributes(array('brand_id'=>$_POST['Inventory']['brand_id']), array('order' => 'name'));
		if(count($data) > 0)
		{
			$data=CHtml::listData($data,'id','name');
			echo CHtml::tag('option',array('value'=>''),'[--Select Sub Brand--]',true);
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			}
		}
		else
		{
			echo CHtml::tag('option',array('value'=>''),'[--Select Sub Brand--]',true);
		}
	}

	public function actionAjaxGetSubBrandSeries()
	{
		if(isset($_POST['Inventory'])){
			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['Inventory']['sub_brand_id']), array('order' => 'name'));
		}
		if(isset($_POST['Inventory'])){
			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['Inventory']['sub_brand_id']), array('order' => 'name'));
		}
		if(isset($_POST['Inventory'])){
			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['Inventory']['sub_brand_id']), array('order' => 'name'));
		}
		
		if(count($data) > 0)
		{
			$data=CHtml::listData($data,'id','name');
			echo CHtml::tag('option',array('value'=>''),'[--Select Sub Brand Series--]',true);
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			}
		}
		else
		{
			echo CHtml::tag('option',array('value'=>''),'[--Select Sub Brand Series--]',true);
		}
	}

	public function actionAjaxGetProductSubCategory()
	{
		$data = ProductSubCategory::model()->findAllByAttributes(array('product_master_category_id'=>$_POST['Inventory']['product_master_category_id'], 'product_sub_master_category_id'=>$_POST['Inventory']['product_sub_master_category_id']), array('order' => 'name'));
		if(count($data) > 0)
		{
			$data=CHtml::listData($data,'id','name');
			echo CHtml::tag('option',array('value'=>''),'[--Select Product Sub Category--]',true);
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			}
		}
		else
		{
			echo CHtml::tag('option',array('value'=>''),'[--Select Product Sub Category--]',true);
		}
	}

	public function actionAjaxGetCode()
	{
		$code = ProductMasterCategory::model()->findByPk($_POST['Inventory']['product_master_category_id'])->code . ProductSubMasterCategory::model()->findByPk($_POST['Inventory']['product_sub_master_category_id'])->code . ProductSubCategory::model()->findByPk($_POST['Inventory']['product_sub_category_id'])->code;

		echo $code;
	}

}
