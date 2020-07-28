<?php

class TransactionPurchaseOrderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	/*public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}*/

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
				'actions'=>array('admin','delete','ajaxSupplier','ajaxHtmlAddDetail','ajaxHtmlRemoveDetail','ajaxGetSubtotal','ajaxGetTotal','updateStatus','ajaxProduct','ajaxAddRequestDetail','ajaxCountAmount','ajaxCountAmountStep','ajaxCountTotal','ajaxCountTotalNonDiscount','ajaxHtmlAddFormDetail','updateApproval','ajaxHtmlRemoveDetailSupplier','pdf'),
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
		$purchaseOrderDetails = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id'=>$id));
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'purchaseOrderDetails'=>$purchaseOrderDetails,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//$model=new TransactionPurchaseOrder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$purchaseOrder = $this->instantiate(null);
		$this->performAjaxValidation($purchaseOrder->header);

		$supplier = new Supplier('search');
			$supplier->unsetAttributes();  // clear any default values
	      	if (isset($_GET['Supplier']))
	        	$supplier->attributes = $_GET['Supplier'];
	  $supplierCriteria = new CDbCriteria;
			$supplierCriteria->compare('name',$supplier->name,true);
		$supplierDataProvider = new CActiveDataProvider('Supplier', array(
    		'criteria'=>$supplierCriteria,
  		));


		// $request = new TransactionRequestOrder('search');
		// 	$request->unsetAttributes();  // clear any default values
	 //      	if (isset($_GET['TransactionRequestOrder']))
	 //        	$request->attributes = $_GET['TransactionRequestOrder'];
		// $requestCriteria = new CDbCriteria;
		// 	$requestCriteria->compare('t.id',$request->id);
		// 	//$requestCriteria->compare('t.request_type',$request->request_type,true);
		// 	$requestCriteria->together = true;
		// 	$requestCriteria->select = 't.id,t.request_order_no, t.request_order_date, rims_transaction_request_order_detail.supplier_id, rims_transaction_request_order_detail.product_id, rims_supplier.name as supplier_name';
		// 	$requestCriteria->join = 'join rims_transaction_request_order_detail on t.id = rims_transaction_request_order_detail.request_order_id join rims_supplier on rims_transaction_request_order_detail.supplier_id = rims_supplier.id';
		// 	$requestCriteria->group = 'rims_transaction_request_order_detail.supplier_id';

		// 	$requestCriteria->compare('rims_supplier.name', $request->supplier_name,true);
		// $requestDataProvider = new CActiveDataProvider('TransactionRequestOrder', array(
		// 	'criteria'=>$requestCriteria,
		// 	));

		$product = new Product('search');
	      	$product->unsetAttributes();  // clear any default values
	      	if (isset($_GET['Product']))
	        	$product->attributes = $_GET['Product'];

			$productCriteria = new CDbCriteria;
			$productCriteria->compare('name',$product->name,true);
			$productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
			$productCriteria->together=true;
			$productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
			$productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
			//$productCriteria->addCondition('rims_supplier_product.supplier_id'=$supplier->id);
			$productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
			$productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
			$productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
			$productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
			$productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
			$productDataProvider = new CActiveDataProvider('Product', array(
	    	'criteria'=>$productCriteria,));

		if(isset($_POST['TransactionPurchaseOrder']))
		{
			// $model->attributes=$_POST['TransactionPurchaseOrder'];
			$this->loadState($purchaseOrder);
			if ($purchaseOrder->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $purchaseOrder->header->id));
			}
		}

		$this->render('create',array(
			//'model'=>$model,
			'purchaseOrder'=>$purchaseOrder,
			'supplier'=>$supplier,
			'supplierDataProvider'=>$supplierDataProvider,
			// 'request'=>$request,
			// 'requestDataProvider'=>$requestDataProvider,
			'product'=>$product,
			'productDataProvider'=>$productDataProvider,
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
		$purchaseOrder = $this->instantiate($id);

		$this->performAjaxValidation($purchaseOrder->header);

		$supplier = new Supplier('search');
			$supplier->unsetAttributes();  // clear any default values
	      	if (isset($_GET['Supplier']))
	        	$supplier->attributes = $_GET['Supplier'];
	  $supplierCriteria = new CDbCriteria;
			$supplierCriteria->compare('name',$supplier->name,true);
		$supplierDataProvider = new CActiveDataProvider('Supplier', array(
    		'criteria'=>$supplierCriteria,
  		));

		$product = new Product('search');
	      	$product->unsetAttributes();  // clear any default values
	      	if (isset($_GET['Product']))
	        	$product->attributes = $_GET['Product'];

			$productCriteria = new CDbCriteria;
			$productCriteria->compare('name',$product->name,true);
			$productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
			$productCriteria->together=true;
			$productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
			$productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
			$productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
			$productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
			$productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
			$productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
			$productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
			$productDataProvider = new CActiveDataProvider('Product', array(
	    	'criteria'=>$productCriteria,));
		// $request = new TransactionRequestOrder('search');
		// 	$request->unsetAttributes();  // clear any default values
	 //      	if (isset($_GET['TransactionRequestOrder']))
	 //        	$request->attributes = $_GET['TransactionRequestOrder'];
		// $requestCriteria = new CDbCriteria;
		// 	$requestCriteria->compare('t.id',$request->id);
		// 	$requestCriteria->compare('t.request_type',$request->request_type,true);
		// 	$requestCriteria->together = true;
		// 	$requestCriteria->select = 't.id,t.request_order_no, t.request_order_date, t.request_type, rims_transaction_request_order_detail.supplier_id, rims_transaction_request_order_detail.product_id, rims_supplier.name as supplier_name';
		// 	$requestCriteria->join = 'join rims_transaction_request_order_detail on t.id = rims_transaction_request_order_detail.request_order_id join rims_supplier on rims_transaction_request_order_detail.supplier_id = rims_supplier.id';
		// 	$requestCriteria->group = 'rims_transaction_request_order_detail.supplier_id';

		// 	$requestCriteria->compare('rims_supplier.name', $request->supplier_name,true);
		// $requestDataProvider = new CActiveDataProvider('TransactionRequestOrder', array(
		// 	'criteria'=>$requestCriteria,
		// 	));

		if(isset($_POST['TransactionPurchaseOrder']))
		{
			// $model->attributes=$_POST['TransactionPurchaseOrder'];
			$this->loadState($purchaseOrder);
			if ($purchaseOrder->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $purchaseOrder->header->id));
			}
		}

		$this->render('update',array(
			'purchaseOrder'=>$purchaseOrder,
			'supplier'=>$supplier,
			'supplierDataProvider'=>$supplierDataProvider,
			// 'request'=>$request,
			// 'requestDataProvider'=>$requestDataProvider,
			'product'=>$product,
			'productDataProvider'=>$productDataProvider,
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
		$dataProvider=new CActiveDataProvider('TransactionPurchaseOrder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionPdf($id){
		// var_dump(Yii::getPathOfAlias('webroot') ); die();
		$po = TransactionPurchaseOrder::model()->find('id=:id', array(':id'=>$id));
		$supplier = Supplier::model()->find('id=:id', array(':id'=>$po->supplier_id));
		$branch = Branch::model()->find('id=:id', array(':id'=>$po->main_branch_id));
		$po_detail = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id'=>$id));
		$mPDF1 = Yii::app()->ePdf->mpdf();
	    $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
			//$stylesheet = file_get_contents(Yii::getPathOfAlias('pdfcss') . '/pdf.css');
	    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/css/pdf.css');
	  	$mPDF1->WriteHTML($stylesheet, 1);
	    $mPDF1->WriteHTML($this->renderPartial('pdf', array('po'=>$po,'supplier'=>$supplier,'branch'=>$branch,'po_detail'=>$po_detail), true));
	    $mPDF1->Output();
	}

	/**
	 * Manages all models
	 */
	public function actionAdmin()
	{
		$model=new TransactionPurchaseOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TransactionPurchaseOrder']))
			$model->attributes=$_GET['TransactionPurchaseOrder'];

		$request = new TransactionRequestOrder('search');
      	$request->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionRequestOrder']))
        	$request->attributes = $_GET['TransactionRequestOrder'];

		$requestCriteria = new CDbCriteria;
		$requestCriteria->compare('request_order_no',$request->request_order_no.'%',true,'AND', false);
		$requestCriteria->compare('request_order_date',$request->request_order_date.'%',true,'AND', false);
		$requestCriteria->addCondition("status_document = 'Approved'");
		$requestDataProvider = new CActiveDataProvider('TransactionRequestOrder', array(
			'criteria'=>$requestCriteria,
		));


		$this->render('admin',array(
			'model'=>$model,
			'request'=>$request,
			'requestDataProvider'=>$requestDataProvider,
		));
	}

	public function actionAjaxGetSubtotal($step,$disc1type,$disc1nom,$disc2type,$disc2nom,$disc3type,$disc3nom,$disc4type,$disc4nom,$disc5type,$disc5nom,$quantity,$retail)
	{
		$price = $quantity * $retail;
		$discount = 0;
		$subtotal1 = 0;
		$subtotal2 = 0;
		$subtotal3 = 0;
		$subtotal4 = 0;
		$subtotal5 = 0;
		$subtotal = 0;
		$newquantity = 0;
		$totalquantity = 0;
		$newPrice = 0;


		switch ($step) {
			case 1:
				if ($disc1type == 1)
				{
					$discount = ($price * $disc1nom / 100);
					$subtotal1 = $price - $discount;
					$totalquantity = $quantity;

				}
				else if($disc1type == 2)
				{
					$subtotal1 = $price - $disc1nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc1nom;
					//$retail = $price / $newquantity;
					$subtotal1 = $retail * $quantity;
					$totalquantity = $newquantity;
				}
				$newPrice = $subtotal1 / $quantity;
				$subtotal = $subtotal1;
				break;

			case 2:
				if ($disc1type == 1)
				{
					$discount = ($price * $disc1nom / 100);
					$subtotal1 = $price - $discount;
					$totalquantity = $quantity;
				}
				else if($disc1type == 2)
				{
					$subtotal1 = $price - $disc1nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc1nom;
					//$retail = $price / $newquantity;
					$subtotal1 = $retail * $quantity;
					$totalquantity = $newquantity;
				}

				if ($disc2type == 1)
				{
					$discount = ($subtotal1 * $disc2nom / 100);
					$subtotal2 = $subtotal1 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc2type == 2)
				{
					$subtotal2 = $subtotal1 - $disc2nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc2nom;
					//$retail = $subtotal1 / $newquantity;
					$subtotal2 = $retail * $quantity;
					$totalquantity = $newquantity;
				}
				$newPrice = $subtotal2 / $quantity;
				$subtotal = $subtotal2;
				break;
				case 3:
				if ($disc1type == 1)
				{
					$discount = ($price * $disc1nom / 100);
					$subtotal1 = $price - $discount;
					$totalquantity = $quantity;
				}
				else if($disc1type == 2)
				{
					$subtotal1 = $price - $disc1nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc1nom;
					//$retail = $price / $newquantity;
					$subtotal1 = $retail * $quantity;
					$totalquantity = $newquantity;
				}

				if ($disc2type == 1)
				{
					$discount = ($subtotal1 * $disc2nom / 100);
					$subtotal2 = $subtotal1 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc2type == 2)
				{
					$subtotal2 = $subtotal1 - $disc2nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc2nom;
					//$retail = $subtotal1 / $newquantity;
					$subtotal2 = $retail * $quantity;
					$totalquantity = $newquantity;
				}

				if ($disc3type == 1)
				{
					$discount = ($subtotal2 * $disc3nom / 100);
					$subtotal3 = $subtotal2 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc3type == 2)
				{
					$subtotal3 = $subtotal2 - $disc3nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc3nom;
					//$retail = $subtotal2 / $newquantity;
					$subtotal3 = $retail * $quantity;
					$totalquantity = $newquantity;
				}
				$newPrice = $subtotal3 / $quantity;
				$subtotal = $subtotal3;
				break;
				case 4:
				if ($disc1type == 1)
				{
					$discount = ($price * $disc1nom / 100);
					$subtotal1 = $price - $discount;
					$totalquantity = $quantity;
				}
				else if($disc1type == 2)
				{
					$subtotal1 = $price - $disc1nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc1nom;
					//$retail = $price / $newquantity;
					$subtotal1 = $retail * $quantity;
					$totalquantity = $newquantity;
				}

				if ($disc2type == 1)
				{
					$discount = ($subtotal1 * $disc2nom / 100);
					$subtotal2 = $subtotal1 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc2type == 2)
				{
					$subtotal2 = $subtotal1 - $disc2nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc2nom;
					//$retail = $subtotal1 / $newquantity;
					$subtotal2 = $retail * $quantity;
					$totalquantity = $newquantity;
				}

				if ($disc3type == 1)
				{
					$discount = ($subtotal2 * $disc3nom / 100);
					$subtotal3 = $subtotal2 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc3type == 2)
				{
					$subtotal3 = $subtotal2 - $disc3nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc3nom;
					//$retail = $subtotal2 / $newquantity;
					$subtotal3 = $retail * $quantity;
					$totalquantity = $newquantity;
				}
				if ($disc4type == 1)
				{
					$discount = ($subtotal3 * $disc4nom / 100);
					$subtotal4 = $subtotal3 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc4type == 2)
				{
					$subtotal4 = $subtotal3 - $disc4nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc4nom;
					//$retail = $subtotal3 / $newquantity;
					$subtotal4 = $retail * $quantity;
					$totalquantity = $newquantity;
				}
				$newPrice = $subtotal4 / $quantity;
				$subtotal = $subtotal4;
				break;
				case 5 :
				if ($disc1type == 1)
				{
					$discount = ($price * $disc1nom / 100);
					$subtotal1 = $price - $discount;
					$totalquantity = $quantity;
				}
				else if($disc1type == 2)
				{
					$subtotal1 = $price - $disc1nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc1nom;
					//$retail = $price / $newquantity;
					$subtotal1 = $retail * $quantity;
					$totalquantity = $newquantity;
				}

				if ($disc2type == 1)
				{
					$discount = ($subtotal1 * $disc2nom / 100);
					$subtotal2 = $subtotal1 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc2type == 2)
				{
					$subtotal2 = $subtotal1 - $disc2nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc2nom;
					//$retail = $subtotal1 / $newquantity;
					$subtotal2 = $retail * $quantity;
					$totalquantity = $newquantity;
				}

				if ($disc3type == 1)
				{
					$discount = ($subtotal2 * $disc3nom / 100);
					$subtotal3 = $subtotal2 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc3type == 2)
				{
					$subtotal3 = $subtotal2 - $disc3nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc3nom;
					//$retail = $subtotal2 / $newquantity;
					$subtotal3 = $retail * $quantity;
					$totalquantity = $newquantity;
				}
				if ($disc4type == 1)
				{
					$discount = ($subtotal3 * $disc4nom / 100);
					$subtotal4 = $subtotal3 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc4type == 2)
				{
					$subtotal4 = $subtotal3 - $disc4nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc4nom;
					//$retail = $subtotal3 / $newquantity;
					$subtotal4 = $retail * $quantity;
					$totalquantity = $newquantity;
				}
				if ($disc5type == 1)
				{
					$discount = ($subtotal4 * $disc5nom / 100);
					$subtotal5 = $subtotal4 - $discount;
					$totalquantity = $quantity;
				}
				else if($disc5type == 2)
				{
					$subtotal5 = $subtotal4 - $disc5nom;
					$totalquantity = $quantity;
				}
				else
				{
					$newquantity = $quantity + $disc5nom;
					//$retail = $subtotal4 / $newquantity;
					$subtotal5 = $retail * $quantity;
					$totalquantity = $newquantity;
				}
				$newPrice = $subtotal5 / $quantity;
				$subtotal = $subtotal5;
				break;

				default:
					$subtotal = $quantity * $price;
					$newPrice = $subtotal / $quantity;
					$totalquantity = $quantity;
				break;


		}
		$object = array(
				'step' =>$step,
				'disc1type' =>$disc1type,
				'disc1nom' =>$disc1nom,
				'disc2type' => $disc2type,
				'disc2nom' =>$disc2nom,
				'subtotal' => $subtotal,
				'subtotal1'=>$subtotal1,
				'subtotal2'=>$subtotal2,
				'subtotal3'=>$subtotal3,
				'subtotal4'=>$subtotal4,
				'subtotal5'=>$subtotal5,
				'retail'=>$retail,
				'newPrice'=>$newPrice,
				'totalquantity'=>$totalquantity,
			);

			echo CJSON::encode($object);

	}

	// public function actionAjaxGetTotal($id)
	// {
	// 	if (Yii::app()->request->isAjaxRequest)
	// 	{
	// 		$purchaseOrder = $this->instantiate($id);
	// 		$this->loadState($purchaseOrder);
	// 		$ppnValue = $purchaseOrder->header->ppn;
	// 		$ppn = 0;
	// 		$subtotal = 0;
	// 		$total = 0;
	// 		$totalItems = 0;
	// 		if(empty($ppnValue)){
	// 			foreach ($purchaseOrder->details as $key => $detail) {
	// 				$subtotal += $detail->subtotal;
	// 				$totalItems += $detail->total_quantity;
	// 			}
	// 			$total = $subtotal;
	// 		}
	// 		else
	// 		{
	// 			foreach ($purchaseOrder->details as $key => $detail) {
	// 				$subtotal += $detail->subtotal;
	// 				$totalItems += $detail->total_quantity;
	// 			}
	// 				$ppn = ($subtotal * $ppnValue / 100);
	// 				$total = $subtotal + $ppn;

	// 		}



	// 		$object = array('total'=>$total,'totalItems'=>$totalItems,'subtotal'=>$subtotal);
	// 		echo CJSON::encode($object);

	// 	}

	// }
	public function actionAjaxGetTotal($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$purchaseOrder = $this->instantiate($id);
			$this->loadState($purchaseOrder);
			//$requestType =$requestOrder->header->request_type;
			$total = 0;
			$totalItems = 0;
			$priceBeforeDisc = $discount = $subtotal = $ppn = 0;
			// if($requestType == 'Request for Purchase'){
			// 	foreach ($requestOrder->details as $key => $detail) {
			// 		$totalItems += $detail->total;
			// 		$total += $detail->subtotal;_quantity;
			// 	}
			// } else if($requestType == 'Request for Transfer'){
			// 	foreach ($requestOrder->transferDetails as $key => $transferDetail) {
			// 		$totalItems += $transferDetail->quantity;
			// 	}
			// }
			$getPpn = $_POST['TransactionPurchaseOrder']['ppn'];
			foreach ($purchaseOrder->details as $key => $detail) {
				$totalItems += $detail->total_quantity;
				$priceBeforeDisc = $detail->subtotal;
				$discount = $detail->discount;
				$subtotal = $detail->total_price;
				if($getPpn == 1)
					$ppn = $subtotal * 0.1;

				$total += $subtotal + $ppn;
			}
			$object = array(
				'priceBeforeDisc'=>$priceBeforeDisc,
				'discount'=>$discount,
				'subtotal'=>$subtotal,
				'total'=>$total,
				'ppn'=>$ppn,
				'totalItems'=>$totalItems);
			echo CJSON::encode($object);

		}

	}
	public function actionAjaxCountAmount($discountType,$discountAmount,$retail,$quantity)
	{
		$price = $quantity * $retail;
		$discount = 0;

		$subtotal = 0;
		$newquantity = 0;
		$totalquantity = 0;
		$newPrice = 0;
		switch ($discountType) {
			case 1:
				$discount = ($price * $discountAmount / 100);
				$subtotal = $price - $discount;
				$totalquantity = $quantity;
				break;
			case 2:
				$subtotal = $price - $discountAmount;
				$totalquantity = $quantity;
				break;
			case 3:
				$newquantity = $quantity + $discountAmount;
				// $retail = $price / $newquantity;
				// $subtotal= $retail * $quantity;
				$subtotal = $price;
				$totalquantity = $newquantity;
				break;

		}
		$newPrice = $subtotal / $quantity;
		$discountAmount = $price - $subtotal;
		$object = array(
			'subtotal'=>$subtotal,
			'totalquantity' =>$totalquantity,
			'newPrice'=>$newPrice,
			'discountAmount'=>$discountAmount,
			'price'=>$price,
			);
		echo CJSON::encode($object);



	}
	public function actionAjaxCountAmountStep($discountType,$discountAmount,$retail,$quantity,$price)
	{

		$discount = 0;
		$oriPrice = $retail * $quantity;
		$subtotal = 0;
		$newquantity = 0;
		$totalquantity = 0;
		$newPrice = 0;
		switch ($discountType) {
			case 1:
				$discount = ($price * $discountAmount / 100);
				$subtotal = $price - $discount;
				$totalquantity = $quantity;
				break;
			case 2:
				$subtotal = $price - $discountAmount;
				$totalquantity = $quantity;
				break;
			case 3:
				$newquantity = $quantity + $discountAmount;
				// $retail = $price / $newquantity;
				// $subtotal= $retail * $quantity;
				$subtotal = $price;
				$totalquantity = $newquantity;
				break;

		}
		$newPrice = $subtotal / $quantity;
		$discountAmount = $oriPrice - $subtotal;
		$object = array(
			'subtotal'=>$subtotal,
			'totalquantity' =>$totalquantity,
			'newPrice'=>$newPrice,
			'discountAmount'=>$discountAmount,
			'oriPrice'=>$oriPrice,
			);
		echo CJSON::encode($object);



	}
	public function actionAjaxCountTotal($totalquantity,$totalprice)
	{
		$unitprice = $totalprice/$totalquantity;
		//$unitprice = 20/5;
		$object = array('unitprice'=>$unitprice);
		echo CJSON::encode($object);
	}
	public function actionAjaxCountTotalNonDiscount($totalquantity,$totalprice)
	{
		$price = $totalprice*$totalquantity;
		$unitprice = $totalprice;
		$object = array('unitprice'=>$unitprice,'price'=>$price);
		echo CJSON::encode($object);
	}
	public function actionUpdateStatus($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['TransactionPurchaseOrder']))
		{
			$model->approved_status =$_POST['TransactionPurchaseOrder']['approved_status'];
			$model->approved_by =$_POST['TransactionPurchaseOrder']['approved_by'];
			$model->decline_memo =$_POST['TransactionPurchaseOrder']['decline_memo'];



			if($model->update(array('approved_status','approved_by','decline_memo')))
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('updateStatus',array(
			'model'=>$model,
			//'jenisPersediaan'=>$jenisPersediaan,
			//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
		));

	}

	public function actionUpdateApproval($headerId)
	{
		$purchaseOrder = TransactionPurchaseOrder::model()->findByPk($headerId);
		//$purchaseOrderDetail = TransactionPurchaseOrderDetail::model()->findByPk($detailId);
		$historis = TransactionPurchaseOrderApproval::model()->findAllByAttributes(array('purchase_order_id'=>$headerId));
		$model = new TransactionPurchaseOrderApproval;
		//$model = $this->loadModelDetail($detailId);
		if(isset($_POST['TransactionPurchaseOrderApproval']))
		{
			$model->attributes=$_POST['TransactionPurchaseOrderApproval'];
			if ($model->save()){
				$purchaseOrder->status_document = $model->approval_type;
				if($model->approval_type == 'Approved'){
					$purchaseOrder->approved_id = $model->supervisor_id;

					foreach($purchaseOrder->transactionPurchaseOrderDetails as $poDetail)
					{
						$productPrice = new ProductPrice;
						$productPrice->supplier_id = $purchaseOrder->supplier_id;
						$productPrice->product_id = $poDetail->product_id;
						$productPrice->purchase_price = $poDetail->unit_price;
						$productPrice->purchase_date = $purchaseOrder->purchase_order_date;
						$productPrice->save();
					}
					
					// if($purchaseOrder->payment_type == ''){

					// }
					/*if($purchaseOrder->coa_id != ""){
						$coaDetail = CoaDetail::model()->findByAttributes(array('coa_id'=>$purchaseOrder->coa_id,'branch_id'=>$purchaseOrder->main_branch_id));
						if(count($coaDetail)> 0)
						{
							$coaDetail->debit += $purchaseOrder->total_price;
							//$coaDetail->save(false);
						}
						else{
							$coaDetail = new CoaDetail;
							$coaDetail->coa_id = $purchaseOrder->coa_id;
							$coaDetail->branch_id = $purchaseOrder->main_branch_id;
							$coaDetail->debit = $purchaseOrder->total_price;
							//$coaDetail->save(false);

						}
						if($coaDetail->save(false)){
							$coa = Coa::model()->findByPK($coaDetail->coa_id);
							$coa->debit += $coaDetail->debit;
							$coa->save(false);
						}
					}*/


				}
				$purchaseOrder->save(false);
				$this->redirect(array('view', 'id' => $headerId));
			}
		}

		$this->render('updateApproval',array(
			'model'=>$model,
			'purchaseOrder'=>$purchaseOrder,
			//'purchaseOrderDetail'=>$purchaseOrderDetail,
			'historis'=>$historis,
			//'jenisPersediaan'=>$jenisPersediaan,
			//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
		));
	}
	public function instantiate($id)
	{
		if (empty($id)){
			$purchaseOrder = new PurchaseOrders(new TransactionPurchaseOrder(), array());
			//print_r("test");
		}
		else
		{
			$purchaseOrderModel = $this->loadModel($id);
			$purchaseOrder = new PurchaseOrders($purchaseOrderModel, $purchaseOrderModel->transactionPurchaseOrderDetails);
			//print_r("test");
		}
		return $purchaseOrder;
	}



	public function loadState($purchaseOrder)
	{
		if (isset($_POST['TransactionPurchaseOrder']))
		{
			$purchaseOrder->header->attributes = $_POST['TransactionPurchaseOrder'];
		}


		if (isset($_POST['TransactionPurchaseOrderDetail']))
		{
			foreach ($_POST['TransactionPurchaseOrderDetail'] as $i => $item)
			{
				if (isset($purchaseOrder->details[$i])){
					$purchaseOrder->details[$i]->attributes = $item;

				}

				else
				{
					$detail = new TransactionPurchaseOrderDetail();
					$detail->attributes = $item;
					$purchaseOrder->details[] = $detail;

				}
			}
			if (count($_POST['TransactionPurchaseOrderDetail']) < count($purchaseOrder->details))
				array_splice($purchaseOrder->details, $i + 1);
		}
		else
			{
				$purchaseOrder->details = array();

			}





	}
	//Add Detail
	public function actionAjaxHtmlAddDetail($id,$productId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$purchaseOrder = $this->instantiate($id);
			$this->loadState($purchaseOrder);
			$product = new Product('search');
	      	$product->unsetAttributes();  // clear any default values
	      	if (isset($_GET['Product']))
	        	$product->attributes = $_GET['Product'];

			$productCriteria = new CDbCriteria;
			$productCriteria->compare('name',$product->name,true);
			$productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
			$productCriteria->together=true;
			$productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
			$productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
			$productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
			$productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
			$productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
			$productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
			$productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
			$productDataProvider = new CActiveDataProvider('Product', array(
	    	'criteria'=>$productCriteria,));
			//$supplierId = $purchaseOrder->header->supplier_id;
			$purchaseOrder->addDetail($productId);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
   			Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      //$this->renderPartial('_detailPurchaseOrder', array('purchaseOrder'=>$purchaseOrder,'product'=>$product,'productDataProvider'=>$productDataProvider,
      $this->renderPartial('_detailPurchaseOrder', array('purchaseOrder'=>$purchaseOrder,'product'=>$product,'productDataProvider'=>$productDataProvider,

      	), false, true);
		}
	}

	public function actionAjaxHtmlRemoveDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

			$purchaseOrder = $this->instantiate($id);
			$this->loadState($purchaseOrder);

			//print_r(CJSON::encode($salesOrder->details));
			$purchaseOrder->removeDetailAt($index);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailPurchaseOrder', array('purchaseOrder'=>$purchaseOrder,
			), false, true);
		}
	}

	public function actionAjaxHtmlRemoveDetailSupplier($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

			$purchaseOrder = $this->instantiate($id);
			$this->loadState($purchaseOrder);

			//print_r(CJSON::encode($salesOrder->details));
			$purchaseOrder->removeDetailSupplier();
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailPurchaseOrder', array('purchaseOrder'=>$purchaseOrder,
			), false, true);
		}
	}

	public function actionAjaxAddRequestDetail($productId){
		$requestOrderDetails = TransactionRequestOrderDetail::model()->findAllByAttributes(array('product_id'=>$productId));
		$this->renderPartial('_detailRequest', array('requestOrderDetails'=>$requestOrderDetails),false, true);

	}

	public function actionAjaxHtmlAddFormDetail($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			// $purchaseOrder = $this->instantiate($id);
			// $this->loadState($purchaseOrder);
			$form = new PurchaseOrderForm;

			// $product = new Product('search');
	  //     	$product->unsetAttributes();  // clear any default values
	  //     	if (isset($_GET['Product']))
	  //       	$product->attributes = $_GET['Product'];

			// $productCriteria = new CDbCriteria;
			// $productCriteria->compare('name',$product->name,true);
			// $productCriteria->compare('manufacturer_code',$product->manufacturer_code,true);
			// $productCriteria->together=true;
			// $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name, rims_supplier_product.product_id as product, rims_supplier.name as product_supplier';
			// $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id Left outer join rims_supplier_product on t.id = rims_supplier_product.product_id left outer join rims_supplier on rims_supplier_product.supplier_id = rims_supplier.id';
			// $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
			// $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
			// $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
			// $productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
			// $productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
			// $productDataProvider = new CActiveDataProvider('Product', array(
	  //   	'criteria'=>$productCriteria,));
			//$supplierId = $purchaseOrder->header->supplier_id;
			// $purchaseOrder->addDetail();
			// Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
   // 			Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      //$this->renderPartial('_detailPurchaseOrder', array('purchaseOrder'=>$purchaseOrder,'product'=>$product,'productDataProvider'=>$productDataProvider,
      $this->renderPartial('_formDetail', array('form'=>$form,'details'=>$form->details,
      	// ,'product'=>$product,'productDataProvider'=>$productDataProvider,

      	), false, true);
		}
	}
	public function actionAjaxSupplier($id){
		if (Yii::app()->request->isAjaxRequest)
		{

			$supplier = Supplier::model()->findByPk($id);
			$tanggal = empty($_POST['TransactionPurchaseOrder']['purchase_order_date'])?date('Y-m-d'): $_POST['TransactionPurchaseOrder']['purchase_order_date'] ;
			$tanggal_jatuh_tempo = date('Y-m-d', strtotime( $tanggal .'+'.$supplier->tenor . ' days'));
			$paymentEstimation= $tanggal_jatuh_tempo;
			//$supplier = Supplier::model()->findByPk($productPrice->supplier_id);

			$object = array(
				//'id'=>$supplier->id,
				'name' => $supplier->name,
				'paymentEstimation'=>$paymentEstimation,
				'coa'=>$supplier->coa_id !="" ?$supplier->coa_id:'',
			);

			echo CJSON::encode($object);
		}
	}
	public function actionAjaxProduct($id){
		if (Yii::app()->request->isAjaxRequest)
		{
			$product = Product::model()->findByPk($id);
			$productUnit = ProductUnit::model()->findByAttributes(array('product_id'=>$product->id,'unit_type'=>'Main'));

			$object = array(
				//'id' => $product->id,
				'name' => $product->name,
				'retail_price'=>$product->retail_price,
				'unit'=>$productUnit->id,
			);

			echo CJSON::encode($object);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TransactionPurchaseOrder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TransactionPurchaseOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TransactionPurchaseOrder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transaction-purchase-order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAjaxGetCompanyBank()
	{
		$company = CompanyBranch::model()->findAllByAttributes(array('branch_id'=>$_POST['TransactionPurchaseOrder']['main_branch_id']));
		if ($company == NULL) {
			echo CHtml::tag('option',array('value'=>''),'[--Select Company Bank--]',true);
		}else{
			$companyarray = array();
			foreach ($company as $key => $value) {
				$companyarray[] = (int) $value->company_id;
			}
			// $data = CompanyBank::model()->findAllByAttributes(array('company_id'=>$companyarray), array('order' => 'account_name'));
			$criteria = new CDbCriteria;
			$criteria->addInCondition('company_id', $companyarray);
			$data = CompanyBank::model()->findAll($criteria);
			// var_dump($data); die("S");
			if(count($data) > 0)
			{
				// $bank = $data->bank->name;
				// $data=CHtml::listData($data,'bank_id',$data);
				echo CHtml::tag('option',array('value'=>''),'[--Select Company Bank--]',true);
				foreach($data as $value=>$name)
				{
					echo CHtml::tag('option', array('value'=>$name->id), CHtml::encode($name->bank->name ." ". $name->account_no." a/n ".$name->account_name), true);
				}
			}
			else
			{
				echo CHtml::tag('option',array('value'=>''),'[--Select Company Bank--]',true);
			}
		}

	}
	public function actionAjaxGetCoa()
	{
		$companyBank = CompanyBank::model()->findByPk($_POST['TransactionPurchaseOrder']['company_bank_id']);
		$coa = $companyBank->coa_id !="" ?$companyBank->coa_id : '';
		$coa_name = $companyBank->coa != "" ? $companyBank->coa->name : '';
		$object = array('coa'=>$coa,'coa_name'=>$coa_name);
		echo CJSON::encode($object);
	}
}
