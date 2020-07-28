<?php

class TransactionSalesOrderController extends Controller
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
				'actions'=>array('admin','delete','ajaxCustomer','ajaxHtmlAddDetail','ajaxHtmlRemoveDetail','ajaxCountAmount','ajaxCountAmountStep','ajaxCountTotal','updateApproval','ajaxGetTotal','showProduct'),
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
			$salesOrderDetails = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id'=>$id));

			$this->render('view',array(
			'model'=>$this->loadModel($id),
			'salesOrderDetails'=>$salesOrderDetails,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		// $model=new TransactionSalesOrder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// if(isset($_POST['TransactionSalesOrder']))
		// {
		// 	$model->attributes=$_POST['TransactionSalesOrder'];
		// 	if($model->save())
		// 		$this->redirect(array('view','id'=>$model->id));
		// }

		// $this->render('create',array(
		// 	'model'=>$model,
		// ));

		$salesOrder = $this->instantiate(null);
		$this->performAjaxValidation($salesOrder->header);

		$customer = new Customer('search');
			$customer->unsetAttributes();  // clear any default values
	      	if (isset($_GET['Customer']))
	        	$customer->attributes = $_GET['Customer'];
	  $customerCriteria = new CDbCriteria;
			$customerCriteria->compare('name',$customer->name,true);      
		$customerDataProvider = new CActiveDataProvider('Customer', array(
    		'criteria'=>$customerCriteria,
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
			//$productCriteria->addCondition('rims_supplier_product.supplier_id'=$supplier->id);
			$productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,true);
			$productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,true);
			$productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name,true);
			$productCriteria->compare('rims_supplier.name', $product->product_supplier,true);
			$productCriteria->compare('rims_brand.name', $product->product_brand_name,true);
			$productDataProvider = new CActiveDataProvider('Product', array(
	    	'criteria'=>$productCriteria,));

		if(isset($_POST['TransactionSalesOrder']))
		{
			
			$this->loadState($salesOrder);
			if ($salesOrder->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $salesOrder->header->id));
			}
		}

		$this->render('create',array(
			//'model'=>$model,
			'salesOrder'=>$salesOrder,
			'customer'=>$customer,
			'customerDataProvider'=>$customerDataProvider,
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
		// $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// if(isset($_POST['TransactionSalesOrder']))
		// {
		// 	$model->attributes=$_POST['TransactionSalesOrder'];
		// 	if($model->save())
		// 		$this->redirect(array('view','id'=>$model->id));
		// }

		// $this->render('update',array(
		// 	'model'=>$model,
		// ));

		$salesOrder = $this->instantiate($id);

		$this->performAjaxValidation($salesOrder->header);

		$customer = new Customer('search');
			$customer->unsetAttributes();  // clear any default values
	      	if (isset($_GET['Customer']))
	        	$customer->attributes = $_GET['Customer'];
	  $customerCriteria = new CDbCriteria;
			$customerCriteria->compare('name',$customer->name,true);      
		$customerDataProvider = new CActiveDataProvider('Customer', array(
    		'criteria'=>$customerCriteria,
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

			if(isset($_POST['TransactionSalesOrder']))
			{
				
				$this->loadState($salesOrder);
				if ($salesOrder->save(Yii::app()->db)){
					$this->redirect(array('view', 'id' => $salesOrder->header->id));
				}
			}

			$this->render('update',array(
				'salesOrder'=>$salesOrder,
				'customer'=>$customer,
				'customerDataProvider'=>$customerDataProvider,
				// 'request'=>$request,
				// 'requestDataProvider'=>$requestDataProvider,
				'product'=>$product,
				'productDataProvider'=>$productDataProvider,
			));

	}

	//Add Detail
	public function actionAjaxHtmlAddDetail($id,$productId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$salesOrder = $this->instantiate($id); 	
			$this->loadState($salesOrder);
			
			$salesOrder->addDetail($productId);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
   			Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      
      $this->renderPartial('_detailSalesOrder', array('salesOrder'=>$salesOrder
      	), false, true);
		}
	}

	public function actionAjaxHtmlRemoveDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

			$salesOrder = $this->instantiate($id); 	
			$this->loadState($salesOrder);
			
			//print_r(CJSON::encode($salesOrder->details));
			$salesOrder->removeDetailAt($index);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailSalesOrder', array('salesOrder'=>$salesOrder,
			), false, true);
		}
	}

	public function actionAjaxCustomer($id){
		if (Yii::app()->request->isAjaxRequest)
		{
			
			$customer = Customer::model()->findByPk($id);
			$tanggal = empty($_POST['TransactionSalesOrder']['sale_order_date'])?date('Y-m-d'): $_POST['TransactionSalesOrder']['sale_order_date'] ;
			$tanggal_jatuh_tempo = date('Y-m-d', strtotime( $tanggal .'+'.$customer->tenor . ' days'));
			$paymentEstimation= $tanggal_jatuh_tempo;
			//$supplier = Supplier::model()->findByPk($productPrice->supplier_id);

			$object = array(
				//'id'=>$supplier->id,
				'name' => $customer->name,
				'paymentEstimation'=>$paymentEstimation,
				'coa'=>$customer->coa_id == "" ? "" : $customer->coa_id,
				'type'=>$customer->customer_type,
			);

			echo CJSON::encode($object);
		}
	}

	public function actionAjaxGetTotal($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$salesOrder = $this->instantiate($id);
			$this->loadState($salesOrder);
			//$requestType =$requestOrder->header->request_type;
			$total = 0;
			$totalItems = 0;
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
			foreach ($salesOrder->details as $key => $detail) {
				$totalItems += $detail->total_quantity;
				$total += $detail->total_price;
			}				
			$object = array('total'=>$total,'totalItems'=>$totalItems);
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

	public function actionUpdateApproval($headerId)
	{
		$salesOrder = TransactionSalesOrder::model()->findByPk($headerId);
		//$salesOrderDetail = TransactionSalesOrderDetail::model()->findByPk($detailId);
		$historis = TransactionSalesOrderApproval::model()->findAllByAttributes(array('sales_order_id'=>$headerId));
		$model = new TransactionSalesOrderApproval;
		//$model = $this->loadModelDetail($detailId);
		if(isset($_POST['TransactionSalesOrderApproval']))
		{
			$model->attributes=$_POST['TransactionSalesOrderApproval'];
			if ($model->save()){
				$salesOrder->status_document = $model->approval_type;
				if($model->approval_type == 'Approved'){
					$salesOrder->approved_id = $model->supervisor_id;

					foreach($salesOrder->transactionSalesOrderDetails as $key =>$soDetail )
					{
						//$coa = $soDetail->product->productSubMasterCategory->coa->id;
						//save product master coa penjualan
						$cMasterPenjualan = CoaDetail::model()->findByAttributes(array('coa_id'=>$soDetail->product->productMasterCategory->coaPenjualanBarangDagang->id,'branch_id'=>$soDetail->salesOrder->requester_branch_id));
						if(count($cMasterPenjualan)!= 0){
							if($soDetail->product->productMasterCategory->coaPenjualanBarangDagang->normal_balance == "D"){
								$cMasterPenjualan->debit += $soDetail->subtotal;
							}
							else{
								$cMasterPenjualan->credit += $soDetail->subtotal;
							}
							//$cPersediaan->save(false);
						}
						else{
							$cMasterPenjualan = new CoaDetail;
							$cMasterPenjualan->coa_id = $soDetail->product->productMasterCategory->coaPenjualanBarangDagang->id;
							$cMasterPenjualan->branch_id = $salesOrder->requester_branch_id;
							if($soDetail->product->productMasterCategory->coaPenjualanBarangDagang->normal_balance == "D"){
								$cMasterPenjualan->debit += $soDetail->subtotal;
							}
							else{
								$cMasterPenjualan->credit += $soDetail->subtotal;
							}
							
						}
						$cMasterPenjualan->save(false);

						//save product sub master coa penjualan
						$cPenjualan = CoaDetail::model()->findByAttributes(array('coa_id'=>$soDetail->product->productSubMasterCategory->coaPenjualanBarangDagang->id,'branch_id'=>$soDetail->salesOrder->requester_branch_id));
						if(count($cPenjualan)!= 0){
							if($soDetail->product->productSubMasterCategory->coaPenjualanBarangDagang->normal_balance == "D"){
								$cPenjualan->debit += $soDetail->subtotal;
							}
							else{
								$cPenjualan->credit += $soDetail->subtotal;
							}
							//$cPersediaan->save(false);
						}
						else{
							$cPenjualan = new CoaDetail;
							$cPenjualan->coa_id = $soDetail->product->productSubMasterCategory->coaPenjualanBarangDagang->id;
							$cPenjualan->branch_id = $salesOrder->requester_branch_id;
							if($soDetail->product->productSubMasterCategory->coaPenjualanBarangDagang->normal_balance == "D"){
								$cPenjualan->debit += $soDetail->subtotal;
							}
							else{
								$cPenjualan->credit += $soDetail->subtotal;
							}
							
						}
						$cPenjualan->save(false);

						//save penjualan master category coa diskon
						$cMasterDiskon = CoaDetail::model()->findByAttributes(array('coa_id'=>$soDetail->product->productMasterCategory->coaDiskonPenjualan->id,'branch_id'=>$salesOrder->requester_branch_id));
						if(count($cMasterDiskon)!=0){
							if($soDetail->product->productMasterCategory->coaDiskonPenjualan->normal_balance == "D"){
								$cMasterDiskon->debit += $soDetail->discount;
							}
							else{
								$cMasterDiskon->credit += $soDetail->discount;
							}

						}
						else{
							$cMasterDiskon = new CoaDetail;
							$cMasterDiskon->coa_id = $soDetail->product->productMasterCategory->coaDiskonPenjualan->id;
							$cMasterDiskon->branch_id = $salesOrder->requester_branch_id;
							if($soDetail->product->productMasterCategory->coaDiskonPenjualan->normal_balance == "D"){
								$cMasterDiskon->debit += $soDetail->discount;
							}
							else{
								$cMasterDiskon->credit += $soDetail->discount;
							}

						}
						$cMasterDiskon->save(false);

						//save penjualan sub master category coa diskon
						$cDiskon = CoaDetail::model()->findByAttributes(array('coa_id'=>$soDetail->product->productSubMasterCategory->coaDiskonPenjualan->id,'branch_id'=>$salesOrder->requester_branch_id));
						if(count($cDiskon)!=0){
							if($soDetail->product->productSubMasterCategory->coaDiskonPenjualan->normal_balance == "D"){
								$cDiskon->debit += $soDetail->discount;
							}
							else{
								$cDiskon->credit += $soDetail->discount;
							}

						}
						else{
							$cDiskon = new CoaDetail;
							$cDiskon->coa_id = $soDetail->product->productSubMasterCategory->coaDiskonPenjualan->id;
							$cDiskon->branch_id = $salesOrder->requester_branch_id;
							if($soDetail->product->productSubMasterCategory->coaDiskonPenjualan->normal_balance == "D"){
								$cDiskon->debit += $soDetail->discount;
							}
							else{
								$cDiskon->credit += $soDetail->discount;
							}

						}
						$cDiskon->save(false);
						$coaPpn = Coa::model()->findByPk(283);
						$cPpnKeluaran = CoaDetail::model()->findByAttributes(array('coa_id'=>$coaPpn->id,'branch_id'=>$salesOrder->requester_branch_id));
						if(count($cPpnKeluaran)!=0){
							if($coaPpn->normal_balance == "D"){
								$cPpnKeluaran->debit += ($soDetail->subtotal - $soDetail->discount)*0.10;
							}
							else{
								$cPpnKeluaran->credit += ($soDetail->subtotal - $soDetail->discount)*0.10;
							}
						}
						else{
							$cPpnKeluaran = new CoaDetail;
							$cPpnKeluaran->coa_id = 283;
							$cPpnKeluaran->branch_id = $salesOrder->requester_branch_id;
							if($coaPpn->normal_balance == "D"){
								$cPpnKeluaran->debit += ($soDetail->subtotal - $soDetail->discount)*0.10;
							}
							else{
								$cPpnKeluaran->credit += ($soDetail->subtotal - $soDetail->discount)*0.10;
							}
						}
						$cPpnKeluaran->save(false);

						//save product master jurnal persediaan
						$jurnalUmumMasterPersediaan = new JurnalUmum;
						$jurnalUmumMasterPersediaan->kode_transaksi = $salesOrder->sale_order_no;
						$jurnalUmumMasterPersediaan->tanggal_transaksi = $salesOrder->sale_order_date;
						$jurnalUmumMasterPersediaan->coa_id = $soDetail->product->productMasterCategory->coaPenjualanBarangDagang->id;
						$jurnalUmumMasterPersediaan->total = $soDetail->subtotal;
						$jurnalUmumMasterPersediaan->debet_kredit = 'K';
						$jurnalUmumMasterPersediaan->tanggal_posting = date('Y-m-d');
						$jurnalUmumMasterPersediaan->save();

						//save product sub master jurnal persediaan
						$jurnalUmumPersediaan = new JurnalUmum;
						$jurnalUmumPersediaan->kode_transaksi = $salesOrder->sale_order_no;
						$jurnalUmumPersediaan->tanggal_transaksi = $salesOrder->sale_order_date;
						$jurnalUmumPersediaan->coa_id = $soDetail->product->productSubMasterCategory->coaPenjualanBarangDagang->id;
						$jurnalUmumPersediaan->total = $soDetail->subtotal;
						$jurnalUmumPersediaan->debet_kredit = 'K';
						$jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
						$jurnalUmumPersediaan->save();

						//save product master jurnal umum diskon
						$jurnalUmumMasterDiskon = new JurnalUmum;
						$jurnalUmumMasterDiskon->kode_transaksi = $salesOrder->sale_order_no;
						$jurnalUmumMasterDiskon->tanggal_transaksi = $salesOrder->sale_order_date;
						$jurnalUmumMasterDiskon->coa_id = $soDetail->product->productMasterCategory->coaDiskonPenjualan->id;
						$jurnalUmumMasterDiskon->total = $soDetail->discount;
						$jurnalUmumMasterDiskon->debet_kredit = 'K';
						$jurnalUmumMasterDiskon->tanggal_posting = date('Y-m-d');
						$jurnalUmumMasterDiskon->save();

						//save product sub master jurnal umum diskon
						$jurnalUmumDiskon = new JurnalUmum;
						$jurnalUmumDiskon->kode_transaksi = $salesOrder->sale_order_no;
						$jurnalUmumDiskon->tanggal_transaksi = $salesOrder->sale_order_date;
						$jurnalUmumDiskon->coa_id = $soDetail->product->productSubMasterCategory->coaDiskonPenjualan->id;
						$jurnalUmumDiskon->total = $soDetail->discount;
						$jurnalUmumDiskon->debet_kredit = 'K';
						$jurnalUmumDiskon->tanggal_posting = date('Y-m-d');
						$jurnalUmumDiskon->save();

						
						
						$jurnalUmumPpn = new JurnalUmum;
						$jurnalUmumPpn->kode_transaksi = $salesOrder->sale_order_no;
						$jurnalUmumPpn->tanggal_transaksi = $salesOrder->sale_order_date;
						$jurnalUmumPpn->coa_id = 283;
						$jurnalUmumPpn->total = ($soDetail->subtotal - $soDetail->discount)*0.10;
						$jurnalUmumPpn->debet_kredit = 'K';
						$jurnalUmumPpn->tanggal_posting = date('Y-m-d');
						$jurnalUmumPpn->save();


					}
					if($salesOrder->payment_type == 'Cash'){
						$coaCash = CoaDetail::model()->findByAttributes(array('coa_id'=>1,'branch_id'=>$salesOrder->requester_branch_id));
						if(count($coaCash)!=0){
							$coaCash->debit += $salesOrder->total_price;
						}
						else{
							$coaCash = new CoaDetail;
							$coaCash->coa_id = 1;
							$coaCash->branch_id = $salesOrder->requester_branch_id;
							$coaCash->debit += $salesOrder->total_price;
						}
						$coaCash->save(false);
						$jurnalUmum = new JurnalUmum;
						$jurnalUmum->kode_transaksi = $salesOrder->sale_order_no;
						$jurnalUmum->tanggal_transaksi = $salesOrder->sale_order_date;
						$jurnalUmum->coa_id = 1;
						$jurnalUmum->total = $salesOrder->total_price;
						$jurnalUmum->debet_kredit = 'D';
						$jurnalUmum->tanggal_posting = date('Y-m-d');
						$jurnalUmum->save();
					}
					elseif($salesOrder->payment_type == 'Credit'){
						if($salesOrder->supplier->coa != "")
						{	
							$coaCredit = CoaDetail::model()->findByAttributes(array('coa_id'=>$salesOrder->supplier->coa->id,'branch_id'=>$salesOrder->requester_branch_id));
							if(count($coaCredit)!=0){
								$coaCredit->debit += $salesOrder->total_price;
							}
							else{
								$coaCredit = new CoaDetail;
								$coaCredit->coa_id = 1;
								$coaCredit->branch_id = $salesOrder->requester_branch_id;
								$coaCredit->debit += $salesOrder->total_price;
							}
							$coaCredit->save(false);
							$jurnalUmum = new JurnalUmum;
							$jurnalUmum->kode_transaksi = $salesOrder->sale_order_no;
							$jurnalUmum->tanggal_transaksi = $salesOrder->sale_order_date;
							$jurnalUmum->coa_id = $salesOrder->supplier->coa->id;
							$jurnalUmum->total = $salesOrder->total_price;
							$jurnalUmum->debet_kredit = 'D';
							$jurnalUmum->tanggal_posting = date('Y-m-d');
							$jurnalUmum->save();
						}
					}
					// if($salesOrder->coa_id != ""){
					// 	$coaDetail = CoaDetail::model()->findByAttributes(array('coa_id'=>$salesOrder->coa_id,'branch_id'=>$salesOrder->requester_branch_id));
					// 	if(count($coaDetail)> 0)
					// 	{
					// 		$coaDetail->credit += $salesOrder->total_price;
					// 		//$coaDetail->save(false); 
					// 	}
					// 	else{
					// 		$coaDetail = new CoaDetail;
					// 		$coaDetail->coa_id = $salesOrder->coa_id;
					// 		$coaDetail->branch_id = $salesOrder->requester_branch_id;
					// 		$coaDetail->credit = $salesOrder->total_price;
					// 		//$coaDetail->save(false);

					// 	}
					// 	if($coaDetail->save(false)){
					// 		$coa = Coa::model()->findByPK($coaDetail->coa_id);
					// 		$coa->credit += $coaDetail->credit;
					// 		$coa->save(false);
					// 	}
					// }
				}
				$salesOrder->save(false);
				$this->redirect(array('view', 'id' => $headerId));
			}
		}
		
		$this->render('updateApproval',array(
			'model'=>$model,
			'salesOrder'=>$salesOrder,
			//'salesOrderDetail'=>$salesOrderDetail,
			'historis'=>$historis,
			//'jenisPersediaan'=>$jenisPersediaan,
			//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
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
		$dataProvider=new CActiveDataProvider('TransactionSalesOrder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TransactionSalesOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TransactionSalesOrder']))
			$model->attributes=$_GET['TransactionSalesOrder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TransactionSalesOrder the loaded model
	 * @throws CHttpException
	 */

	public function instantiate($id)
	{
		if (empty($id)){
			$salesOrder = new SalesOrders(new TransactionSalesOrder(), array());
			//print_r("test");
		}
		else
		{
			$salesOrderModel = $this->loadModel($id);
			$salesOrder = new SalesOrders($salesOrderModel, $salesOrderModel->transactionSalesOrderDetails);
			//print_r("test");
		}
		return $salesOrder;
	}



	public function loadState($salesOrder)
	{
		if (isset($_POST['TransactionSalesOrder']))
		{
			$salesOrder->header->attributes = $_POST['TransactionSalesOrder'];
		}


		if (isset($_POST['TransactionSalesOrderDetail']))
		{
			foreach ($_POST['TransactionSalesOrderDetail'] as $i => $item)
			{
				if (isset($salesOrder->details[$i])){
					$salesOrder->details[$i]->attributes = $item;
				
				}

				else
				{
					$detail = new TransactionSalesOrderDetail();
					$detail->attributes = $item;
					$salesOrder->details[] = $detail;
					
				}
			}
			if (count($_POST['TransactionSalesOrderDetail']) < count($salesOrder->details))
				array_splice($salesOrder->details, $i + 1);
		}
		else
			{
				$salesOrder->details = array();
				
			}

	}

	public function loadModel($id)
	{
		$model=TransactionSalesOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TransactionSalesOrder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transaction-sales-order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionGenerateInvoice($id)
	{
		$salesOrder = TransactionSalesOrder::model()->findByPK($id);
		$customer = Customer::model()->findByPk($salesOrder->customer_id);
		$duedate = $customer->tenor != "" ? date('Y-m-d',strtotime("+".$customer->tenor." days")) : date('Y-m-d', strtotime("+1 months"));
		$invoiceHeader = InvoiceHeader::model()->findAll();
		$count = count($invoiceHeader) + 1;
		$model = new InvoiceHeader();
		$model->invoice_number = 'INV_'.$count;
		$model->invoice_date = date('Y-m-d');
		$model->due_date = $duedate;
		$model->reference_type = 1;
		$model->sales_order_id = $id;
		$model->customer_id = $salesOrder->customer_id;
		$model->branch_id = $salesOrder->requester_branch_id;
		$model->user_id = Yii::app()->user->getId();
		$model->status = "NOT PAID";
		$model->product_price = $salesOrder->total_price;
		$model->total_price = $salesOrder->total_price;
		//$model->save(false);
		if($model->save(false)){
			$salesDetails = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id'=>$id));
			if(count($salesDetails) != 0){
				foreach($salesDetails as $salesDetail){
					$modelDetail = new InvoiceDetail();
					$modelDetail->invoice_id = $model->id;
					$modelDetail->product_id = $salesDetail->product_id;
					$modelDetail->quantity = $salesDetail->quantity;
					$modelDetail->unit_price = $salesDetail->unit_price;
					$modelDetail->total_price = $salesDetail->total_price;
					$modelDetail->save(false);
				}//end foreach
			} // end if count
			
		}// end if model save
		
	}
	public function actionShowProduct($productId, $branchId){
		$warehouses = Warehouse::model()->findAllByAttributes(array('branch_id'=>$branchId));
		$this->render('showProduct',array(
			'warehouses'=>$warehouses,
			'productId'=>$productId,
		));
	}

	public function actionAjaxGetCompanyBank()
	{
		$company = Company::model()->findByAttributes(array('branch_id'=>$_POST['TransactionSalesOrder']['requester_branch_id']));
		// var_dump($company->id); die("S");

		if ($company == NULL) {
			echo CHtml::tag('option',array('value'=>''),'[--Select Company Bank--]',true);
		}else{
			$data = CompanyBank::model()->findAllByAttributes(array('company_id'=>$company->id), array('order' => 'account_name'));
			// var_dump($data->); die("S");
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
		$companyBank = CompanyBank::model()->findByPk($_POST['TransactionSalesOrder']['company_bank_id']);
		$coa = $companyBank->coa_id !="" ?$companyBank->coa_id : '';
		$coa_name = $companyBank->coa != "" ? $companyBank->coa->name : '';
		$object = array('coa'=>$coa,'coa_name'=>$coa_name);
		echo CJSON::encode($object);
	}	

}
