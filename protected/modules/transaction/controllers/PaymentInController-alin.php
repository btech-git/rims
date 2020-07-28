<?php

class PaymentInController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';

	/**
	 * @return array action filters
	 */
	// public function filters()
	// {
	// 	return array(
	// 		'accessControl', // perform access control for CRUD operations
	// 		'postOnly + delete', // we only allow deletion via POST request
	// 	);
	// }

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
		$model = $this->loadModel($id);
		$revisionHistories = PaymentInApproval::model()->findAllByAttributes(array('payment_in_id'=> $model->id));
		$postImages = PaymentInImages::model()->findAllByAttributes(array('payment_in_id' => $model->id, 'is_inactive'=> $model::STATUS_ACTIVE));
		$this->render('view',array(
			'model'=>$model,
			'postImages'=>$postImages,
			'revisionHistories'=>$revisionHistories,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PaymentIn;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
  		$invoice = new InvoiceHeader('search');
  		$invoice->unsetAttributes();
  		if (isset($_GET['InvoiceHeader'])) 
  			$invoice->attributes = $_GET['InvoiceHeader'];
  		$invoiceCriteria = new CDbCriteria;
  		$invoiceCriteria->addCondition('t.status != "CANCELLED" && t.status != "PAID"');
  		$invoiceCriteria->compare('invoice_number',$invoice->invoice_number,true);
  		$invoiceCriteria->compare('invoice_date',$invoice->invoice_date,true);
  		$invoiceCriteria->compare('due_date',$invoice->due_date,true);
  		$invoiceCriteria->compare('total_price',$invoice->total_price,true);
  		$invoiceCriteria->together = true;
  		$invoiceCriteria->with = array('customer');
  		$invoiceCriteria->compare('customer.name',$invoice->customer_name,true);
  		$invoiceDataProvider = new CActiveDataProvider('InvoiceHeader',array('criteria'=>$invoiceCriteria));

  		$images = $model->images = CUploadedFile::getInstances($model, 'images');

		if(isset($_POST['PaymentIn']))
		{
			$model->attributes=$_POST['PaymentIn'];

			if($model->save()){
				//update Invoice
				$criteria = new CDbCriteria;
				
				$criteria->condition="invoice_id =".$model->invoice_id ." AND id != ".$model->id;
				$payment = PaymentIn::model()->findAll($criteria);
				// $payment = PaymentIn::model()->findAllByAttributes(array('invoice_id'=>$model->invoice_id));
				$invoiceData = InvoiceHeader::model()->findByPk($model->invoice_id);
			
				if(count($payment) == 0){
					$countTotal = $invoiceData->total_price - $model->payment_amount;
				}
				else{
					$countTotal = $invoiceData->payment_left - $model->payment_amount;
				}
			
				if($countTotal != 0)
					$invoiceData->status = 'PARTIALLY PAID';
				elseif ($countTotal == 0) 
					$invoiceData->status = 'PAID';
				else
					$invoiceData->status = 'NOT PAID';

				$invoiceData->payment_amount = $model->payment_amount;
				$invoiceData->payment_left = $countTotal;
				$invoiceData->save(false);
				

				if(isset($images) && !empty($images)) {
            		foreach($model->images as $i=>$image)
            		{
            			$postImage = new PaymentInImages;
            			$postImage->payment_in_id = $model->id;
        				$postImage->is_inactive = $model::STATUS_ACTIVE;
            			$postImage->extension = $image->extensionName;

            			if($postImage->save()){
            				$dir = dirname(Yii::app()->request->scriptFile). '/images/uploads/paymentIn/' . $model->id;

            				if(!file_exists($dir)){
            					mkdir($dir,0777,true);
            				}
            				$path = $dir . '/' . $postImage->filename;
            				$image->saveAs($path);
            				$picture = Yii::app()->image->load($path);
            				$picture->save();

            				$thumb = Yii::app()->image->load($path);
            				$thumb_path = $dir . '/' . $postImage->thumbname;
            				$thumb->save($thumb_path);

            				$square = Yii::app()->image->load($path);
            				$square_path = $dir . '/' . $postImage->squarename;
            				$square->save($square_path);
            			}

            		}
            	}
     
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'invoice'=>$invoice,
			'invoiceDataProvider'=>$invoiceDataProvider,
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

		$invoice = new InvoiceHeader('search');
  		$invoice->unsetAttributes();
  		if (isset($_GET['InvoiceHeader'])) 
  			$invoice->attributes = $_GET['InvoiceHeader'];
  		$invoiceCriteria = new CDbCriteria;
  		$invoiceCriteria->addCondition('t.status != "CANCELLED"');
  		$invoiceCriteria->compare('invoice_number',$invoice->invoice_number,true);
  		$invoiceCriteria->compare('invoice_date',$invoice->invoice_date,true);
  		$invoiceCriteria->compare('due_date',$invoice->due_date,true);
  		$invoiceCriteria->compare('total_price',$invoice->total_price,true);
  		$invoiceCriteria->together = true;
  		$invoiceCriteria->with = array('customer');
  		$invoiceCriteria->compare('customer.name',$invoice->customer_name,true);
  		$invoiceDataProvider = new CActiveDataProvider('InvoiceHeader',array('criteria'=>$invoiceCriteria));

  		$model=$this->loadModel($id);
		$postImages = PaymentInImages::model()->findAllByAttributes(array('payment_in_id' => $model->id, 'is_inactive'=> $model::STATUS_ACTIVE));
		$countPostImage = count($postImages);
		$maxImage = 10;
		$allowedImages = $maxImage - $countPostImage;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PaymentIn']))
		{
			$model->attributes=$_POST['PaymentIn'];
			if($model->save()){

				//update Invoice
				$criteria = new CDbCriteria;
				
				$criteria->condition="invoice_id =".$model->invoice_id ." AND id != ".$model->id;
				$payment = PaymentIn::model()->findAll($criteria);
				// $payment = PaymentIn::model()->findAllByAttributes(array('invoice_id'=>$model->invoice_id));
				$invoiceData = InvoiceHeader::model()->findByPk($model->invoice_id);
			
				if(count($payment) == 0){
					$countTotal = $invoiceData->total_price - $model->payment_amount;
				}
				else{
					$countTotal = $invoiceData->payment_left - $model->payment_amount;
				}
			
				if($countTotal != 0)
					$invoiceData->status = 'PARTIALLY PAID';
				elseif ($countTotal == 0) 
					$invoiceData->status = 'PAID';
				else
					$invoiceData->status = 'NOT PAID';
				
				$invoiceData->payment_amount = $model->payment_amount;
				$invoiceData->payment_left = $countTotal;
				$invoiceData->save(false);

				$images = $model->images = CUploadedFile::getInstances($model, 'images');
				//print_r($images);
				if(isset($images) && !empty($images)){

					foreach($model->images as $image)
					{

						$postImage = new PaymentInImages;
	            			$postImage->payment_in_id = $model->id;
	            			$postImage->is_inactive = $model::STATUS_ACTIVE;
	            			$postImage->extension = $image->extensionName;

	            			if($postImage->save()){
	            				$dir = dirname(Yii::app()->request->scriptFile). '/images/uploads/paymentIn/' . $model->id;

	            				if(!file_exists($dir)){
	            					mkdir($dir,0777,true);
	            				}
	            				$path = $dir . '/' . $postImage->filename;
	            				$image->saveAs($path);
	            				$picture = Yii::app()->image->load($path);
	            				$picture->save();

	            				$thumb = Yii::app()->image->load($path);
	            				$thumb_path = $dir . '/' . $postImage->thumbname;
	            				$thumb->save($thumb_path);

	            				$square = Yii::app()->image->load($path);
	            				$square_path = $dir . '/' . $postImage->squarename;
	            				$square->save($square_path);
	            				
	            				echo $postImage->extension;
	            			}
        			}

				}
				if($model->invoice->reference_type == 1){
					if($model->invoice->salesOrder->payment_type == "Cash"){
		            	$coaKas = CoaDetail::model()->findByAttributes(array('coa_id'=>3,'branch_id'=>$model->branch_id));
		            	if(count($coaKas)!=0){
		            		$coaKas->debit += $model->payment_amount;
		            	}
		            	else{
		            		$coaKas = new CoaDetail;
		            		$coaKas->coa_id = 3;
		            		$coaKas->branch_id = $model->branch_id;
		            		$coaKas->debit = $model->payment_amount;
		            	}
		            	$coaKas->save(false);
		            	$jurnalUmum = new JurnalUmum;
						$jurnalUmum->kode_transaksi = $model->invoice->salesOrder->sale_order_no;
						$jurnalUmum->tanggal_transaksi = $model->invoice->salesOrder->sale_order_date;
						$jurnalUmum->coa_id = 3;
						$jurnalUmum->total = $model->payment_amount;
						$jurnalUmum->debet_kredit = 'D';
						$jurnalUmum->tanggal_posting = date('Y-m-d');
						$jurnalUmum->save(false);
		            }
		            else{
		            	$coaKasBank = CoaDetail::model()->findByAttributes(array('coa_id'=>$model->invoice->salesOrder->companyBank->coa->id,'branch_id'=>$model->branch_id));
		            	if(count($coaKasBank)!= 0){
		            		$coaKasBank->debit += $model->payment_amount;
		            	}
		            	else{
		            		$coaKasBank = new CoaDetail;
		            		$coaKasBank->coa_id = $model->invoice->salesOrder->companyBank->coa->id;
		            		$coaKasBank->branch_id = $model->branch_id;
		            		$coaKasBank->debit = $model->payment_amount;
		            	}
		            	$coaKasBank->save(false);
		            	$jurnalUmum = new JurnalUmum;
						$jurnalUmum->kode_transaksi = $model->invoice->salesOrder->sale_order_no;
						$jurnalUmum->tanggal_transaksi = $model->invoice->salesOrder->sale_order_date;
						$jurnalUmum->coa_id = $model->invoice->salesOrder->companyBank->coa->id;
						$jurnalUmum->total = $model->payment_amount;
						$jurnalUmum->debet_kredit = 'D';
						$jurnalUmum->tanggal_posting = date('Y-m-d');
						$jurnalUmum->save(false);
		            }
		            $coaPiutang = CoaDetail::model()->findByAttributes(array('coa_id'=>$model->invoice->salesOrder->customer->coa->id,'branch_id'=>$model->branch_id));
		            if(count($coaPiutang)!=0){
		            	$coaPiutang->credit += $model->payment_amount;
		            }
		            else{
		            	$coaPiutang = new CoaDetail;
		            	$coaPiutang->coa_id = $model->invoice->salesOrder->customer->coa->id;
	            		$coaPiutang->branch_id = $model->branch_id;
	            		$coaPiutang->credit = $model->payment_amount;
		            }
		            $coaPiutang->save(false);
		            $jurnalUmum = new JurnalUmum;
					$jurnalUmum->kode_transaksi = $model->invoice->salesOrder->sale_order_no;
					$jurnalUmum->tanggal_transaksi = $model->invoice->salesOrder->sale_order_date;
					$jurnalUmum->coa_id = $model->invoice->salesOrder->customer->coa->id;
					$jurnalUmum->total = $model->payment_amount;
					$jurnalUmum->debet_kredit = 'K';
					$jurnalUmum->tanggal_posting = date('Y-m-d');
					$jurnalUmum->save(false);

				}//end if reference type 

				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'invoice'=>$invoice,
			'invoiceDataProvider'=>$invoiceDataProvider,
			'postImages' => $postImages,
			'allowedImages' => $allowedImages,
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
		$invoice = new InvoiceHeader('search');
  		$invoice->unsetAttributes();
  		if (isset($_GET['InvoiceHeader'])) 
  			$invoice->attributes = $_GET['InvoiceHeader'];
  		$invoiceCriteria = new CDbCriteria;
  		$invoiceCriteria->addCondition('t.status != "CANCELLED" && t.status != "PAID"');
  		$invoiceCriteria->compare('invoice_number',$invoice->invoice_number,true);
  		$invoiceCriteria->compare('invoice_date',$invoice->invoice_date,true);
  		$invoiceCriteria->compare('due_date',$invoice->due_date,true);
  		$invoiceCriteria->compare('total_price',$invoice->total_price,true);
  		$invoiceCriteria->together = true;
  		$invoiceCriteria->with = array('customer');
  		$invoiceCriteria->compare('customer.name',$invoice->customer_name,true);
  		$invoiceDataProvider = new CActiveDataProvider('InvoiceHeader',array('criteria'=>$invoiceCriteria));
		$dataProvider=new CActiveDataProvider('PaymentIn');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'invoice'=>$invoice,
			'invoiceDataProvider'=>$invoiceDataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{	
		$invoice = new InvoiceHeader('search');
  		$invoice->unsetAttributes();
  		if (isset($_GET['InvoiceHeader'])) 
  			$invoice->attributes = $_GET['InvoiceHeader'];
  		$invoiceCriteria = new CDbCriteria;
  		$invoiceCriteria->addCondition('t.status != "CANCELLED" && t.status != "PAID"');
  		$invoiceCriteria->compare('invoice_number',$invoice->invoice_number,true);
  		$invoiceCriteria->compare('invoice_date',$invoice->invoice_date,true);
  		$invoiceCriteria->compare('due_date',$invoice->due_date,true);
  		$invoiceCriteria->compare('total_price',$invoice->total_price,true);
  		$invoiceCriteria->together = true;
  		$invoiceCriteria->with = array('customer');
  		$invoiceCriteria->compare('customer.name',$invoice->customer_name,true);
  		$invoiceDataProvider = new CActiveDataProvider('InvoiceHeader',array('criteria'=>$invoiceCriteria));
		$model=new PaymentIn('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PaymentIn']))
			$model->attributes=$_GET['PaymentIn'];

		$this->render('admin',array(
			'model'=>$model,
			'invoice'=>$invoice,
			'invoiceDataProvider'=>$invoiceDataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PaymentIn the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PaymentIn::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PaymentIn $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payment-in-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionAjaxInvoice($invoiceId){
		$refNum = "";
		$vehicleId = $plate = $machine = $frame = $chasis = $power =$carMake = $carModel = $carSubModel = $carColor = "";
		$payment = PaymentIn::model()->findAllByAttributes(array('invoice_id'=>$invoiceId));
		if(count($payment) ==  0)
			$count = 1;
		else
			$count = 2;
		$invoice = InvoiceHeader::model()->findByPk($invoiceId);
		if ($invoice->reference_type == 1) {
			$refNum = $invoice->salesOrder->sale_order_no;
		}
		else{
			$refNum = $invoice->registrationTransaction->transaction_number;
		}
		//$customer = Customer::model()->findByPk($invoice->customer_id);
		if($invoice->vehicle_id != ""){
			$vehicle = Vehicle::model()->findByPk($invoice->vehicle_id);
			if (count($vehicle) != 0) {
				$vehicleId = $vehicle->id;
				$plate = $vehicle->plate_number != ""? $vehicle->plate_number : '';
				$machine = $vehicle->machine_number != "" ? $vehicle->machine_number :  '';
				$frame = $vehicle->frame_number != "" ? $vehicle->frame_number : '';
				$chasis = $vehicle->chasis_code != "" ? $vehicle->chasis_code : '';
				$power = $vehicle->power != "" ? $vehicle->power : '';
				$carMake = $vehicle->car_make_id != "" ? $vehicle->carMake->name : '';
				$carModel = $vehicle->car_model_id != "" ? $vehicle->carModel->name : '';
				$carSubModel = $vehicle->car_sub_model_detail_id != "" ?$vehicle->carSubModel->name : '';
				$carColor = $vehicle->color_id != "" ? Colors:: model()->findByPk($vehicle->color_id)->name : '';

			}
		}

		$object = array(
			'invoice_number'=> $invoice->invoice_number,
			'invoice_date'=>$invoice->invoice_date,
			'due_date'=>$invoice->due_date,
			'reference_type'=>$invoice->reference_type,
			'reference_num'=>$refNum,
			'status'=>$invoice->status,
			'total_price'=>$invoice->total_price,
			'payment_amount'=>$invoice->payment_amount != "" ?$invoice->payment_amount : "0" ,
			'payment_left'=>$invoice->payment_left != "" ?$invoice->payment_left : "0",
			'customer_id'=>$invoice->customer->id,
			'customer_name'=>$invoice->customer->name,
			'type'=>$invoice->customer->customer_type,
			'address'=>$invoice->customer->address,
			'province'=>$invoice->customer->province != "" ? $invoice->customer->province->name : '',
			'city'=>$invoice->customer->city != "" ? $invoice->customer->city->name : '',
			'email'=>$invoice->customer->email,
			'phones'=>$invoice->customer->customerPhones != ""? $invoice->customer->customerPhones : array(),
			'mobiles'=>$invoice->customer->customerMobiles != ""? $invoice->customer->customerMobiles : array(),
			'vehicle_id'=> $vehicleId,
			'plate'=>$plate,
			'machine'=>$machine,
			'frame'=>$frame,
			'chasis'=>$chasis,
			'power'=>$power,
			'carMake'=>$carMake,
			'carModel'=>$carModel,
			'carSubModel'=>$carSubModel,
			'carColor'=>$carColor,
			'count'=>$count,
		);
		echo CJSON::encode($object);
	}
	public function actionDeleteImage($id)
	{
		$model = PaymentInImages::model()->findByPk($id);
		$model->scenario = 'delete';

		$dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->filename;
		$dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->thumbname;
		$dir_square = dirname(Yii::app()->request->scriptFile) .'/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->squarename;

		if(file_exists($dir))
		{
			unlink($dir);
		}
		if(file_exists($dir_thumb))
		{
			unlink($dir_thumb);
		}
		if(file_exists($dir_square))
		{
			unlink($dir_square);
		}

		$model->is_inactive = 1;
		$model->update(array('is_inactive'));

		$this->redirect(Yii::app()->request->urlReferrer);
	}
	public function actionUpdateApproval($headerId)
	{
		$paymentIn = PaymentIn::model()->findByPK($headerId);
		$historis = PaymentInApproval::model()->findAllByAttributes(array('payment_in_id'=>$headerId));
		$model = new PaymentInApproval;
		$branch = Branch::model()->findByPk($paymentIn->branch_id);
		$getCoa ="";
		$getCoaDetail="";
		//$model = $this->loadModelDetail($detailId);
		if(isset($_POST['PaymentInApproval']))
		{
			$model->attributes=$_POST['PaymentInApproval'];
			if ($model->save()){
				$paymentIn->status = $model->approval_type;
				$paymentIn->save(false);
				
				if($paymentIn->payment_type == "Cash"){

					$getCoaKas = $branch->coa_prefix.'.101.000';
					$coaKasWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaKas));
					$jurnalUmumKas = new JurnalUmum;
					$jurnalUmumKas->kode_transaksi = $paymentIn->payment_number;
					$jurnalUmumKas->tanggal_transaksi = $paymentIn->payment_date;
					$jurnalUmumKas->coa_id = $coaKasWithCode->id;
					$jurnalUmumKas->branch_id = $paymentIn->branch_id;
					$jurnalUmumKas->total = $paymentIn->payment_amount;
					$jurnalUmumKas->debet_kredit = 'K';
					$jurnalUmumKas->tanggal_posting = date('Y-m-d');
					$jurnalUmumKas->save();

					if ($paymentIn->invoice->reference_type == 1) {
						$amount = $paymentIn->invoice->salesOrder->subtotal;
					}
					else{
						$amount = $paymentIn->invoice->registrationTransaction->grand_total;
					}
					$getCoaPiutang = $branch->coa_prefix.'.105.000';
					//$getCoaPiutang = '00.105.000';
					$coaPiutangWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaPiutang));
					$jurnalPiutang = new JurnalUmum;
					$jurnalPiutang->kode_transaksi = $paymentIn->payment_number;
					$jurnalPiutang->tanggal_transaksi = $paymentIn->payment_date;
					//$jurnalUmumOutstanding->coa_id = $purchaseOrder->supplier->coaOutstandingOrder->id == ""?1:2;
					$jurnalPiutang->coa_id = $coaPiutangWithCode->id;
					$jurnalPiutang->branch_id = $paymentIn->branch_id;
					$jurnalPiutang->total = $amount;
					$jurnalPiutang->debet_kredit = 'D';
					$jurnalPiutang->tanggal_posting = date('Y-m-d');
					$jurnalPiutang->save();


					$getCoaPpn = $branch->coa_prefix.'.205.000';
					$coaPpnWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaPpn));
					$jurnalPpn = new JurnalUmum;
					$jurnalPpn->kode_transaksi = $paymentIn->payment_number;
					$jurnalPpn->tanggal_transaksi = $paymentIn->payment_date;
					//$jurnalUmumOutstanding->coa_id = $purchaseOrder->supplier->coaOutstandingOrder->id == ""?1:2;
					$jurnalPpn->coa_id = $coaPpnWithCode->id;
					$jurnalPpn->branch_id = $paymentIn->branch_id;
					$jurnalPpn->total = $amount *0.1;
					$jurnalPpn->debet_kredit = 'D';
					$jurnalPpn->tanggal_posting = date('Y-m-d');
					$jurnalPpn->save();

					
				}
				else{

					//$CoaKasBank = Coa::model()->findByPk($paymentOut->companyBank->coa->id);
					$getCoaKasBank = $branch->coa_prefix.'.102.000';
					$coaKasBankWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaKasBank));
					$jurnalUmumKasBank = new JurnalUmum;
					$jurnalUmumKasBank->kode_transaksi = $paymentIn->payment_number;
					$jurnalUmumKasBank->tanggal_transaksi = $paymentIn->payment_date;
					$jurnalUmumKasBank->coa_id = $coaKasBankWithCode->id;
					$jurnalUmumKasBank->branch_id = $paymentIn->branch_id;
					$jurnalUmumKasBank->total = $paymentIn->payment_amount;
					$jurnalUmumKasBank->debet_kredit = 'K';
					$jurnalUmumKasBank->tanggal_posting = date('Y-m-d');
					$jurnalUmumKasBank->save();

					if ($paymentIn->invoice->reference_type == 1) {
						$amount = $paymentIn->invoice->salesOrder->subtotal;
					}
					else{
						$amount = $paymentIn->invoice->registrationTransaction->grand_total;
					}
					$getCoaPiutang = $branch->coa_prefix.'.105.000';
					$coaPiutangWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaPiutang));
					$jurnalPiutang = new JurnalUmum;
					$jurnalPiutang->kode_transaksi = $paymentIn->payment_number;
					$jurnalPiutang->tanggal_transaksi = $paymentIn->payment_date;
					//$jurnalUmumOutstanding->coa_id = $purchaseOrder->supplier->coaOutstandingOrder->id == ""?1:2;
					$jurnalPiutang->coa_id = $coaPiutangWithCode->id;
					$jurnalPiutang->branch_id = $paymentIn->branch_id;
					$jurnalPiutang->total = $amount;
					$jurnalPiutang->debet_kredit = 'D';
					$jurnalPiutang->tanggal_posting = date('Y-m-d');
					$jurnalPiutang->save();


					$getCoaPpn = $branch->coa_prefix.'.205.000';
					$coaPpnWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaPpn));
					$jurnalPpn = new JurnalUmum;
					$jurnalPpn->kode_transaksi = $paymentIn->payment_number;
					$jurnalPpn->tanggal_transaksi = $paymentIn->payment_date;
					//$jurnalUmumOutstanding->coa_id = $purchaseOrder->supplier->coaOutstandingOrder->id == ""?1:2;
					$jurnalPpn->coa_id = $coaPpnWithCode->id;
					$jurnalPpn->branch_id = $paymentIn->branch_id;
					$jurnalPpn->total = $amount * 0.1;
					$jurnalPpn->debet_kredit = 'D';
					$jurnalPpn->tanggal_posting = date('Y-m-d');
					$jurnalPpn->save();

					

					
				}

				$this->redirect(array('view', 'id' => $headerId));
			}
		}
		
		$this->render('updateApproval',array(
			'model'=>$model,
			'paymentIn'=>$paymentIn,
			'historis'=>$historis,
			//'jenisPersediaan'=>$jenisPersediaan,
			//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
		));
	}

	public function actionAjaxGetCompanyBank()
	{
		$branch = Branch::model()->findByPk($_POST['PaymentIn']['branch_id']);
		$company = Company::model()->findByPk($branch->company_id);
		if ($company == NULL) {
			echo CHtml::tag('option',array('value'=>''),'[--Select Company Bank--]',true);
		}else{
			// $companyarray = [];
			// foreach ($company as $key => $value) {
			// 	$companyarray[] = (int) $value->company_id;
			// }
			$data = CompanyBank::model()->findAllByAttributes(array('company_id'=>$company->id), array('order' => 'account_name'));
			// $criteria = new CDbCriteria;
			// $criteria->addInCondition('company_id', $companyarray); 
			// $data = CompanyBank::model()->findAll($criteria);
			// var_dump($data); die("S");			// var_dump($data->); die("S");
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
}
