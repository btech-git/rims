<?php

class FindProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function actionIndex() {

		/* // search for fulltexrsearch
		$criteria = new CDbCriteria;
		$criteria->condition = 'MATCH (code, manufacturer_code, name, description) AGAINST(:keyword IN BOOLEAN MODE)';
		$criteria->params = array(
		    ':keyword' => '"'.$keyword.'"',
		);
		$findProduct = Findproduct::model()->findAll($criteria);
		*/

		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product'])) {
			// var_dump($_GET['Product']['product_master_category_id']); die("s");
			$model->attributes=$_GET['Product'];
			// var_dump($_GET['Product']); die("s");
		}

		$findProduct=new Findproduct('search');
		$findProduct->unsetAttributes();  // clear any default values
		//var_dump($findProduct); die('s');
		if(isset($_GET['Findproduct'])) {
			$findProduct->attributes=$_GET['Findproduct'];
			$keywordbold = $_GET['Findproduct']['findkeyword'];
			// $findProduct->extension=$_GET['Findproduct']['findkeyword'];
			// var_dump($findProduct); die("findKeyword");
		}
		// $keywordbold = 'F100';
		$this->render('find',array(
			'modelFilter'=>$model,
			'modelKeyword'=>$findProduct,
			// 'keywordbold'=>$keywordbold,
		));


		// $criteria->condition = "MATCH (code, manufacturer_code, name, description, production_year, brand_id, extension) AGAINST ('$keyword' IN BOOLEAN MODE)";
		// $criteria->select = array( "MATCH (code, manufacturer_code, name, description, production_year, brand_id, extension) AGAINST ('*{$keyword}*'  IN BOOLEAN MODE) as relevance");

		/*
		ALTER TABLE rims_product ADD FULLTEXT index_name(code)
		ALTER TABLE rims_product ADD FULLTEXT index_name(manufacturer_code)
		ALTER TABLE rims_product ADD FULLTEXT index_name(name)
		ALTER TABLE rims_product ADD FULLTEXT index_name(description)
		ALTER TABLE rims_product ADD FULLTEXT find_product(code, manufacturer_code, name, description)
		*/
	}

	public function actionAjaxGetProductSubMasterCategory()
	{
		$data = ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id'=>$_POST['Product']['product_master_category_id']), array('order' => 'name'));
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
		$data = SubBrand::model()->findAllByAttributes(array('brand_id'=>$_POST['Product']['brand_id']), array('order' => 'name'));
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
		if(isset($_POST['ProductSpecificationBattery'])){
			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['ProductSpecificationBattery']['sub_brand_id']), array('order' => 'name'));
		}
		if(isset($_POST['ProductSpecificationOil'])){
			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['ProductSpecificationOil']['sub_brand_id']), array('order' => 'name'));
		}
		if(isset($_POST['ProductSpecificationTire'])){
			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['ProductSpecificationTire']['sub_brand_id']), array('order' => 'name'));
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
		$data = ProductSubCategory::model()->findAllByAttributes(array('product_master_category_id'=>$_POST['Product']['product_master_category_id'], 'product_sub_master_category_id'=>$_POST['Product']['product_sub_master_category_id']), array('order' => 'name'));
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
		/*$code = ProductMasterCategory::model()->findByPk($_POST['Product']['product_master_category_id'])->code . ProductSubMasterCategory::model()->findByPk($_POST['Product']['product_sub_master_category_id'])->code . ProductSubCategory::model()->findByPk($_POST['Product']['product_sub_category_id'])->code;

		echo $code;*/
		echo ProductSubCategory::model()->findByPk($_POST['Product']['product_sub_category_id'])->id;
	}
}
