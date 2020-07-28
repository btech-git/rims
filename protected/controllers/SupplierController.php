<?php

class SupplierController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/backend';

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
				'actions'=>array('admin','delete','ajaxGetCity','ajaxHtmlAddPhoneDetail','ajaxHtmlRemovePhoneDetail','ajaxHtmlAddMobileDetail','ajaxHtmlRemoveMobileDetail','ajaxHtmlAddBankDetail','ajaxHtmlRemoveBankDetail','ajaxBank','ajaxHtmlAddPicDetail','ajaxHtmlRemovePicDetail','ajaxHtmlAddProductDetail','ajaxHtmlAddSingleProductDetail','ajaxHtmlRemoveProductDetail','ajaxGetProductSubMasterCategory','ajaxGetProductSubCategory','updateBank','updatePic','ajaxGetCityPic','ajaxGetCityPicIndex'),
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
		$picDetails = SupplierPic::model()->findAllByAttributes(array('supplier_id'=>$id));
		$supplierBanks = SupplierBank::model()->findAllByAttributes(array('supplier_id'=>$id));
		//$supplierProducts = SupplierProduct::model()->findAllByAttributes(array('supplier_id'=>$id));
		$supplierProduct = new SupplierProduct('search');
      	$supplierProduct->unsetAttributes();  // clear any default values
      	if (isset($_GET['SupplierProduct']))
        	$supplierProduct->attributes = $_GET['SupplierProduct'];

		$supplierProductCriteria = new CDbCriteria;
		//$coaCriteria->addCondition("coa_sub_category_id = 2");
		$supplierProductCriteria->addCondition("supplier_id = ".$id);
		$supplierProductCriteria->with = array('product'=>array('with'=>array('productMasterCategory','productSubMasterCategory','productSubCategory','brand')));
		$supplierProductCriteria->compare('product.name',$supplierProduct->product_name,true);
		$supplierProductCriteria->compare('productMasterCategory.name',$supplierProduct->product_master_category_name,true);
		$supplierProductCriteria->compare('productSubMasterCategory.name',$supplierProduct->product_sub_master_category_name,true);
		$supplierProductCriteria->compare('productSubCategory.name',$supplierProduct->product_sub_category_name,true);
		$supplierProductCriteria->compare('brand.name',$supplierProduct->product_brand_name,true);
		


	  	$supplierProductDataProvider = new CActiveDataProvider('SupplierProduct', array(
	    	'criteria'=>$supplierProductCriteria,
	  	));	
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'picDetails'=>$picDetails,
			'supplierBanks'=>$supplierBanks,
			//'supplierProducts'=>$supplierProducts,
			'supplierProduct'=>$supplierProduct,
			'supplierProductDataProvider'=>$supplierProductDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		// $model=new Supplier;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// if(isset($_POST['Supplier']))
		// {
		// 	$model->attributes=$_POST['Supplier'];
		// 	if($model->save())
		// 		$this->redirect(array('view','id'=>$model->id));
		// }

		// }

		//Data Provider Bank

		$bank = new Bank('search');
      	$bank->unsetAttributes();  // clear any default values
      	if (isset($_GET['Bank']))
        	$bank->attributes = $_GET['Bank'];

		$bankCriteria = new CDbCriteria;
		$bankCriteria->compare('code',$bank->code.'%',true,'AND', false);
		$bankCriteria->compare('name',$bank->name,true);

  		$bankDataProvider = new CActiveDataProvider('Bank', array(
    		'criteria'=>$bankCriteria,
  		));

  		$coa = new Coa('search');
      	$coa->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaCriteria = new CDbCriteria;
		$coaCriteria->addCondition("coa_sub_category_id = 11 AND coa_id = 0");
		$coaCriteria->compare('code',$coa->code.'%',true,'AND', false);
		$coaCriteria->compare('name',$coa->name,true);


	  	$coaDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaCriteria,
	  	));	

	  	$coaOutstanding = new Coa('search');
      	$coaOutstanding->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaOutstandingCriteria = new CDbCriteria;
		$coaOutstandingCriteria->addCondition("coa_sub_category_id = 11 AND coa_id = 0");
		$coaOutstandingCriteria->compare('code',$coaOutstanding->code.'%',true,'AND', false);
		$coaOutstandingCriteria->compare('name',$coaOutstanding->name,true);


	  	$coaOutstandingDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaOutstandingCriteria,
	  	));	

		$product = new Product('search');
      	$product->unsetAttributes();  // clear any default values
      	if (isset($_GET['Product'])) {
      		// var_dump(isset($_GET['Product'])); die("S");
        	$product->attributes = $_GET['Product'];
      	}
		$productCriteria = new CDbCriteria;
		$productCriteria->together = true;
		$productCriteria->with = array('productMasterCategory','productSubMasterCategory','productSubCategory','brand');
		$productCriteria->compare('t.name',$product->name,true);
		$productCriteria->compare('productMasterCategory.name',$product->product_master_category_name,true);
		$productCriteria->compare('productSubMasterCategory.name',$product->product_sub_master_category_name,true);
		$productCriteria->compare('productSubCategory.name',$product->product_sub_category_name,true);
		$productCriteria->compare('production_year',$product->production_year,true);
		$productCriteria->compare('brand.name',$product->product_brand_name,true);
  		$productDataProvider = new CActiveDataProvider('Product', array(
    		'criteria'=>$productCriteria,
  		));


  		
	  	$productArray= array();
		$supplier = $this->instantiate(null);

		//$this->performAjaxValidation($customer->header);

		if(isset($_POST['Supplier']))
		{
			$this->loadState($supplier);
			if ($supplier->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $supplier->header->id));
			} else {
				foreach ($supplier->phoneDetails as $key => $phoneDetail) {
					//print_r(CJSON::encode($detail->jenis_persediaan_id));
				}
			}
		}

		$this->render('create',array(
			'supplier'=>$supplier,
			'bank'=>$bank,
			'bankDataProvider'=>$bankDataProvider,
			'product'=>$product,
			'productDataProvider'=>$productDataProvider,
			'productArray'=>$productArray,
			'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,
			'coaOutstanding'=>$coaOutstanding,
			'coaOutstandingDataProvider'=>$coaOutstandingDataProvider,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		//$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// if(isset($_POST['Supplier']))
		// {
		// 	$model->attributes=$_POST['Supplier'];
		// 	if($model->save())
		// 		$this->redirect(array('view','id'=>$model->id));
		// }
		//Data Provider Pelanggan

		$bank = new Bank('search');
      	$bank->unsetAttributes();  // clear any default values
      	if (isset($_GET['Bank']))
        	$bank->attributes = $_GET['Bank'];

		$bankCriteria = new CDbCriteria;
		$bankCriteria->compare('code',$bank->code.'%',true,'AND', false);
		$bankCriteria->compare('name',$bank->name,true);

  		$bankDataProvider = new CActiveDataProvider('Bank', array(
	    	'criteria'=>$bankCriteria,
	  	));
	  	$coa = new Coa('search');
      	$coa->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaCriteria = new CDbCriteria;
		$coaCriteria->addCondition("coa_sub_category_id = 11 AND coa_id = 0");
		$coaCriteria->compare('code',$coa->code.'%',true,'AND', false);
		$coaCriteria->compare('name',$coa->name,true);


	  	$coaDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaCriteria,
	  	));	

	  	$coaOutstanding = new Coa('search');
      	$coaOutstanding->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaOutstandingCriteria = new CDbCriteria;
		$coaOutstandingCriteria->addCondition("coa_sub_category_id = 11 AND coa_id = 0");
		$coaOutstandingCriteria->compare('code',$coaOutstanding->code.'%',true,'AND', false);
		$coaOutstandingCriteria->compare('name',$coaOutstanding->name,true);


	  	$coaOutstandingDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaOutstandingCriteria,
	  	));	

  		$product = new Product('search');
      	$product->unsetAttributes();  // clear any default values
      	if (isset($_GET['Product']))
        	$product->attributes = $_GET['Product'];
		$productCriteria = new CDbCriteria;
		$productCriteria->together = true;
		$productCriteria->with = array('productMasterCategory','productSubMasterCategory','productSubCategory','brand');
		$productCriteria->compare('t.name',$product->name,true);
		$productCriteria->compare('productMasterCategory.name',$product->product_master_category_name,true);
		$productCriteria->compare('productSubMasterCategory.name',$product->product_sub_master_category_name,true);
		$productCriteria->compare('productSubCategory.name',$product->product_sub_category_name,true);
		$productCriteria->compare('production_year',$product->production_year,true);
		$productCriteria->compare('brand.name',$product->product_brand_name,true);
  		$productDataProvider = new CActiveDataProvider('Product', array(
    		'criteria'=>$productCriteria,
  		));

  	$productChecks = SupplierProduct::model()->findAllByAttributes(array('supplier_id'=>$id));
		$productArray = array();
		foreach ($productChecks as $key => $productCheck) {
			array_push($productArray,$productCheck->product_id);
		}

		$supplier = $this->instantiate($id);

		$this->performAjaxValidation($supplier->header);

		if(isset($_POST['Supplier']))
		{


			$this->loadState($supplier);
			if ($supplier->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $supplier->header->id));
			} else {
				foreach ($supplier->phoneDetails as $key => $detail) {
					//print_r(CJSON::encode($detail->jenis_persediaan_id));
				}
			}
		}
		$this->render('update',array(
			'supplier'=>$supplier,
			'bank'=>$bank,
			'bankDataProvider'=>$bankDataProvider,
			'product'=>$product,
			'productDataProvider'=>$productDataProvider,
			'productArray'=>$productArray,
			'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,
			'coaOutstanding'=>$coaOutstanding,
			'coaOutstandingDataProvider'=>$coaOutstandingDataProvider,
		));
	}

	public function actionUpdateBank($supId,$bankId)
	{
		
		$bank = new Bank('search');
      	$bank->unsetAttributes();  // clear any default values
      	if (isset($_GET['Bank']))
        	$bank->attributes = $_GET['Bank'];

		$bankCriteria = new CDbCriteria;
		$bankCriteria->compare('code',$bank->code.'%',true,'AND', false);
		$bankCriteria->compare('name',$bank->name,true);

		$bankDataProvider = new CActiveDataProvider('Bank', array(
			'criteria'=>$bankCriteria,
		));

		$coa = new Coa('search');
      	$coa->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaCriteria = new CDbCriteria;
		//$coaCriteria->addCondition("coa_sub_category_id = 2");
		$coaCriteria->compare('code',$coa->code.'%',true,'AND', false);
		$coaCriteria->compare('name',$coa->name,true);


	  	$coaDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaCriteria,
	  	));	
		
		 $supplier = $this->instantiate($supId);

		// $this->performAjaxValidation($customer->header);
		$model = SupplierBank::model()->findByPk($bankId);
		if(isset($_POST['SupplierBank']))
		{
			$model->attributes=$_POST['SupplierBank'];
			if($model->save())
				$this->redirect(array('view', 'id' => $supId));
		}
		
		$this->render('update',array(
			'supplier'=>$supplier,
			'model'=>$model,
			'bank'=>$bank,
			'bankDataProvider'=>$bankDataProvider,
			'productArray'=>$productArray,
		));
	}

	public function actionUpdatePic($supId,$picId)
	{
		

		 $supplier = $this->instantiate($supId);

		// $this->performAjaxValidation($customer->header);
		$model = SupplierPic::model()->findByPk($picId);
		if(isset($_POST['SupplierPic']))
		{
			$model->attributes=$_POST['SupplierPic'];
			if($model->save())
				$this->redirect(array('view', 'id' => $supId));
		}
		
		$this->render('update',array(
			'supplier'=>$supplier,
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
		$dataProvider=new CActiveDataProvider('Supplier');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Supplier('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Supplier']))
			$model->attributes=$_GET['Supplier'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	//Add PhoneDetail
	public function actionAjaxHtmlAddPhoneDetail($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$supplier = $this->instantiate($id); 	
			$this->loadState($supplier);

			$supplier->addDetail();
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      $this->renderPartial('_detailPhone', array('supplier'=>$supplier), false, true);
		}
	}

	//Delete Phone Detail
	public function actionAjaxHtmlRemovePhoneDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

			$supplier = $this->instantiate($id);
			$this->loadState($supplier);
			//print_r(CJSON::encode($salesOrder->details));
			$supplier->removeDetailAt($index);
			$this->renderPartial('_detailPhone', array('supplier'=>$supplier), false, true);
		}
	}

	//Add Mobile Detail
	public function actionAjaxHtmlAddMobileDetail($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$supplier = $this->instantiate($id); 	
			$this->loadState($supplier);

			$supplier->addMobileDetail();
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      $this->renderPartial('_detailMobile', array('supplier'=>$supplier), false, true);
		}
	}

	//Delete Mobile Detail
	public function actionAjaxHtmlRemoveMobileDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

			$supplier = $this->instantiate($id);
			$this->loadState($supplier);
			//print_r(CJSON::encode($salesOrder->details));
			$supplier->removeMobileDetailAt($index);
			$this->renderPartial('_detailMobile', array('supplier'=>$supplier), false, true);
		}
	}

	//Add PIC Detail
	public function actionAjaxHtmlAddPicDetail($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$supplier = $this->instantiate($id); 	
			$this->loadState($supplier);

			$supplier->addPicDetail();
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      		$this->renderPartial('_detailPic', array('supplier'=>$supplier), false, true);
		}
	}

	//Delete PIC Detail
	public function actionAjaxHtmlRemovePicDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

			$supplier = $this->instantiate($id);
			$this->loadState($supplier);
			//print_r(CJSON::encode($salesOrder->details));
			$supplier->removePicDetailAt($index);
			$this->renderPartial('_detailPic', array('supplier'=>$supplier), false, true);
		}
	}

	//Add Product Detail
	public function actionAjaxHtmlAddProductDetail($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$supplier = $this->instantiate($id); 	
			$this->loadState($supplier);

			$supplier->addProductDetail();
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      		$this->renderPartial('_detailProduct', array('supplier'=>$supplier), false, true);
		}
	}

	//Add Product Detail alternantive
	public function actionAjaxHtmlAddProductDetailAlt($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$supplier = $this->instantiate($id); 	
			$this->loadState($supplier);

			$supplier->addProductDetailAlt();
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      		$this->renderPartial('_detailProduct', array('supplier'=>$supplier), false, true);
		}
	}

	//Add Product Detail
	public function actionAjaxHtmlAddSingleProductDetail($id, $productId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$supplier = $this->instantiate($id); 	
			$this->loadState($supplier);

			$supplier->addSingleProductDetail($productId);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      		$this->renderPartial('_detailProduct', array('supplier'=>$supplier), false, true);
		}
	}

	public function actionAjaxGetProductSubMasterCategory()
	{
		$data = ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id'=>$_POST['Supplier']['product_master_category_id']), array('order' => 'name'));
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

	public function actionAjaxGetProductSubCategory()
	{
		$data = ProductSubCategory::model()->findAllByAttributes(array('product_master_category_id'=>$_POST['productMasterCategoryId'], 'product_sub_master_category_id'=>$_POST['productSubMasterCategoryId']), array('order' => 'name'));

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

	public function actionAjaxGetSubBrand()
	{
		$data = SubBrand::model()->findAllByAttributes(array('brand_id'=>$_POST['brand_id']), array('order' => 'name'));
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

	//Delete Product Detail
	public function actionAjaxHtmlRemoveProductDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$supplier = $this->instantiate($id);
			$this->loadState($supplier);
			//print_r(CJSON::encode($salesOrder->details));
			$supplier->removeProductDetailAt($index);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailProduct', array('supplier'=>$supplier), false, true);
		}
	}

	//Add PIC Phone Detail
	// public function actionAjaxHtmlAddPicPhoneDetail($id)
	// {
	// 	if (Yii::app()->request->isAjaxRequest)
	// 	{
	// 		$supplier = $this->instantiate($id); 	
	// 		$this->loadState($supplier);

	// 		$supplier->addDetail();
	// 		Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
 //      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
 //      $this->renderPartial('_detailPicPhone', array('supplier'=>$supplier), false, true);
	// 	}
	// }

	//Delete PIC Phone Detail
	// public function actionAjaxHtmlRemovePhoneDetail($id, $index)
	// {
	// 	if (Yii::app()->request->isAjaxRequest)
	// 	{

	// 		$supplier = $this->instantiate($id);
	// 		$this->loadState($supplier);
	// 		//print_r(CJSON::encode($salesOrder->details));
	// 		$supplier->removeDetailAt($index);
	// 		$this->renderPartial('_detailPicPhone', array('supplier'=>$supplier), false, true);
	// 	}
	// }

	//Add PIC Mobile Detail
	// public function actionAjaxHtmlAddMobileDetail($id)
	// {
	// 	if (Yii::app()->request->isAjaxRequest)
	// 	{
	// 		$supplier = $this->instantiate($id); 	
	// 		$this->loadState($supplier);

	// 		$supplier->addMobileDetail();
	// 		Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
 //      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
 //      $this->renderPartial('_detailPicMobile', array('supplier'=>$supplier), false, true);
	// 	}
	// }

	//Delete PIC Mobile Detail
	// public function actionAjaxHtmlRemoveMobileDetail($id, $index)
	// {
	// 	if (Yii::app()->request->isAjaxRequest)
	// 	{

	// 		$supplier = $this->instantiate($id);
	// 		$this->loadState($supplier);
	// 		//print_r(CJSON::encode($salesOrder->details));
	// 		$supplier->removeMobileDetailAt($index);
	// 		$this->renderPartial('_detailPicMobile', array('supplier'=>$supplier), false, true);
	// 	}
	// }


	//Add Bank Detail
	public function actionAjaxHtmlAddBankDetail($id,$bankId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$supplier = $this->instantiate($id); 	
			$this->loadState($supplier);

			$supplier->addBankDetail($bankId);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      $this->renderPartial('_detailBank', array('supplier'=>$supplier), false, true);
		}
	}

	//Delete Bank Detail
	public function actionAjaxHtmlRemoveBankDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

			$supplier = $this->instantiate($id);
			$this->loadState($supplier);
			//print_r(CJSON::encode($salesOrder->details));
			$supplier->removeBankDetailAt($index);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailBank', array('supplier'=>$supplier), false, true);
		}
	}

	// Ajax Get Bank
	public function actionAjaxBank($id){
        if (Yii::app()->request->isAjaxRequest)
        {
            $bank = Bank::model()->findByPk($id);

            $object = array(
            	'id' => $bank->id,
                'code' => $bank->code,
                'name' => $bank->name,
            );

            echo CJSON::encode($object);
        }
    }

	// Ajax Get City
	public function actionAjaxGetCity()
	{
		$data = City::model()->findAllByAttributes(array('province_id'=>$_POST['Supplier']['province_id']),array('order'=>'name ASC'));

		if(count($data) > 0)
		{

			$data=CHtml::listData($data,'id','name');
			echo CHTML::tag('option',array('value'=>''),'[--Select City--]',true);
			foreach($data as $value=>$name)
			{
				
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			
			}
		}
		else
		{
			echo CHTML::tag('option',array('value'=>''),'[--Select City--]',true);
		}

	}

	public function actionAjaxGetCityPic()
	{
		$data = City::model()->findAllByAttributes(array('province_id'=>$_POST['SupplierPic']['province_id']),array('order'=>'name ASC'));
					
		if(count($data) > 0)
		{
			$data=CHtml::listData($data,'id','name');
			echo CHTML::tag('option',array('value'=>''),'[--Select City--]',true);
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			}
		}
		else
		{
			echo CHTML::tag('option',array('value'=>''),'[--Select City--]',true);
		}
	}

	public function actionAjaxGetCityPicIndex($index)
	{
		$data = City::model()->findAllByAttributes(array('province_id'=>$_POST['SupplierPic'][$index]['province_id']),array('order'=>'name ASC'));
					
		if(count($data) > 0)
		{
			$data=CHtml::listData($data,'id','name');
			echo CHTML::tag('option',array('value'=>''),'[--Select City--]',true);
			foreach($data as $value=>$name)
			{	
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			}
		}
		else
		{
			echo CHTML::tag('option',array('value'=>''),'[--Select City--]',true);
		}
	}

	public function instantiate($id)
	{
		if (empty($id)){
			$supplier = new Suppliers(new Supplier(), array(),array(),array(),array(),array());
		}
		else
		{
			$supplierModel = $this->loadModel($id);
			$supplier = new Suppliers($supplierModel, $supplierModel->supplierPhones, $supplierModel->supplierMobiles, $supplierModel->supplierBanks, $supplierModel->supplierPics, $supplierModel->supplierProducts);
		}
		return $supplier;
	}

	public function loadState($supplier)
	{
		if (isset($_POST['Supplier']))
		{
			$supplier->header->attributes = $_POST['Supplier'];
		}
		if (isset($_POST['SupplierPhone']))
		{
			foreach ($_POST['SupplierPhone'] as $i => $item)
			{
				if (isset($supplier->phoneDetails[$i]))
					$supplier->phoneDetails[$i]->attributes = $item;
				else
				{
					$detail = new SupplierPhone();
					$detail->attributes = $item;
					$supplier->phoneDetails[] = $detail;
				}
			}
			if (count($_POST['SupplierPhone']) < count($supplier->phoneDetails))
				array_splice($supplier->phoneDetails, $i + 1);
		}
		else
			$supplier->phoneDetails = array();


		if (isset($_POST['SupplierMobile']))
		{
			foreach ($_POST['SupplierMobile'] as $i => $item)
			{
				if (isset($supplier->mobileDetails[$i]))
					$supplier->mobileDetails[$i]->attributes = $item;
				else
				{
					$detail = new SupplierMobile();
					$detail->attributes = $item;
					$supplier->mobileDetails[] = $detail;
				}
			}
			if (count($_POST['SupplierMobile']) < count($supplier->mobileDetails))
				array_splice($supplier->mobileDetails, $i + 1);
		}
		else
			$supplier->mobileDetails = array();


		if (isset($_POST['SupplierBank']))
		{
			foreach ($_POST['SupplierBank'] as $i => $item)
			{
				if (isset($supplier->bankDetails[$i]))
					$supplier->bankDetails[$i]->attributes = $item;
				else
				{
					$detail = new SupplierBank();
					$detail->attributes = $item;
					$supplier->bankDetails[] = $detail;
				}
			}
			if (count($_POST['SupplierBank']) < count($supplier->bankDetails))
				array_splice($supplier->bankDetails, $i + 1);
		}
		else
			$supplier->bankDetails = array();

		if (isset($_POST['SupplierPic']))
		{
			foreach ($_POST['SupplierPic'] as $i => $item)
			{
				if (isset($supplier->picDetails[$i]))
					$supplier->picDetails[$i]->attributes = $item;
				else
				{
					$detail = new SupplierPic();
					$detail->attributes = $item;
					$supplier->picDetails[] = $detail;
				}
			}
			if (count($_POST['SupplierPic']) < count($supplier->picDetails))
				array_splice($supplier->picDetails, $i + 1);
		}
		else
			$supplier->picDetails = array();

		if (isset($_POST['SupplierProduct']))
		{
			foreach ($_POST['SupplierProduct'] as $i => $item)
			{
				if (isset($supplier->productDetails[$i]))
					$supplier->productDetails[$i]->attributes = $item;
				else
				{
					$detail = new SupplierProduct();
					$detail->attributes = $item;
					$supplier->productDetails[] = $detail;
				}
			}
			if (count($_POST['SupplierProduct']) < count($supplier->productDetails))
				array_splice($supplier->productDetails, $i + 1);
		}
		else
			$supplier->productDetails = array();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Supplier the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Supplier::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Supplier $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='supplier-form')
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
