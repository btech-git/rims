<?php

class TransactionDeliveryOrderController extends Controller
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
				'actions'=>array('admin','delete','ajaxSent','ajaxHtmlAddDetail','ajaxSales','ajaxHtmlRemoveDetail','ajaxCustomer','ajaxHtmlRemoveDetailRequest','ajaxConsignment','ajaxTransfer'),
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
		$deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id'=>$id));
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'deliveryDetails'=>$deliveryDetails,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		// $model=new TransactionDeliveryOrder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// if(isset($_POST['TransactionDeliveryOrder']))
		// {
		// 	$model->attributes=$_POST['TransactionDeliveryOrder'];
		// 	if($model->save())
		// 		$this->redirect(array('view','id'=>$model->id));
		// }

		// $this->render('create',array(
		// 	'model'=>$model,
		// ));
		$transfer = new TransactionTransferRequest('search');
      	$transfer->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionTransferRequest']))
        	$transfer->attributes = $_GET['TransactionTransferRequest'];

		$transferCriteria = new CDbCriteria;
		$transferCriteria->compare('transfer_request_no',$transfer->transfer_request_no.'%',true,'AND', false);
		$transferCriteria->addCondition("status_document = 'Approved'");
		$transferDataProvider = new CActiveDataProvider('TransactionTransferRequest', array(
			'criteria'=>$transferCriteria,
		));

		$sent = new TransactionSentRequest('search');
      	$sent->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionSentRequest']))
        	$sent->attributes = $_GET['TransactionSentRequest'];

		$sentCriteria = new CDbCriteria;
		$sentCriteria->compare('sent_request_no',$sent->sent_request_no.'%',true,'AND', false);
		$sentCriteria->addCondition("status_document = 'Approved'");
		$sentDataProvider = new CActiveDataProvider('TransactionSentRequest', array(
			'criteria'=>$sentCriteria,
		));

		$sales = new TransactionSalesOrder('search');
      	$sales->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionSalesOrder']))
        	$sales->attributes = $_GET['TransactionSalesOrder'];

		$salesCriteria = new CDbCriteria;
		$salesCriteria->compare('sale_order_no',$sales->sale_order_no.'%',true,'AND', false);
		$salesCriteria->addCondition("status_document = 'Approved'");
		$salesDataProvider = new CActiveDataProvider('TransactionSalesOrder', array(
			'criteria'=>$salesCriteria,
		));

		$consignment = new ConsignmentOutHeader('search');
      	$consignment->unsetAttributes();  // clear any default values
      	if (isset($_GET['ConsignmentOutHeader']))
        	$consignment->attributes = $_GET['ConsignmentOutHeader'];

		$consignmentCriteria = new CDbCriteria;
		$consignmentCriteria->compare('consignment_out_no',$consignment->consignment_out_no.'%',true,'AND', false);
		$consignmentCriteria->addCondition("status = 'Approved'");
		$consignmentDataProvider = new CActiveDataProvider('ConsignmentOutHeader', array(
			'criteria'=>$consignmentCriteria,
		));

		$deliveryOrder = $this->instantiate(null);
		$this->performAjaxValidation($deliveryOrder->header);
		if(isset($_POST['TransactionDeliveryOrder']))
		{
			
			$this->loadState($deliveryOrder);
			
			if ($deliveryOrder->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $deliveryOrder->header->id));
			}
		}

		$this->render('create',array(
			'deliveryOrder'=>$deliveryOrder,
			'sent'=>$sent,
			'sentDataProvider'=>$sentDataProvider,
			'sales'=>$sales,
			'salesDataProvider'=>$salesDataProvider,
			'consignment'=>$consignment,
			'consignmentDataProvider'=>$consignmentDataProvider,
			'transfer'=>$transfer,
			'transferDataProvider'=>$transferDataProvider,
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

		// if(isset($_POST['TransactionDeliveryOrder']))
		// {
		// 	$model->attributes=$_POST['TransactionDeliveryOrder'];
		// 	if($model->save())
		// 		$this->redirect(array('view','id'=>$model->id));
		// }

		// $this->render('update',array(
		// 	'model'=>$model,
		// ));
		$transfer = new TransactionTransferRequest('search');
      	$transfer->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionTransferRequest']))
        	$transfer->attributes = $_GET['TransactionTransferRequest'];

		$transferCriteria = new CDbCriteria;
		$transferCriteria->compare('transfer_request_no',$transfer->transfer_request_no.'%',true,'AND', false);
		$transferCriteria->addCondition("status_document = 'Approved'");
		$transferDataProvider = new CActiveDataProvider('TransactionTransferRequest', array(
			'criteria'=>$transferCriteria,
		));

		$sent = new TransactionSentRequest('search');
      	$sent->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionSentRequest']))
        	$sent->attributes = $_GET['TransactionSentRequest'];

		$sentCriteria = new CDbCriteria;
		$sentCriteria->compare('sent_request_no',$sent->sent_request_no.'%',true,'AND', false);
		$sentCriteria->addCondition("status_document = 'Approved'");
		$sentDataProvider = new CActiveDataProvider('TransactionSentRequest', array(
			'criteria'=>$sentCriteria,
		));
		$sales = new TransactionSalesOrder('search');
      	$sales->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionSalesOrder']))
        	$sales->attributes = $_GET['TransactionSalesOrder'];

		$salesCriteria = new CDbCriteria;
		$salesCriteria->compare('sale_order_no',$sales->sale_order_no.'%',true,'AND', false);
		$salesCriteria->addCondition("status_document = 'Approved'");
		$salesDataProvider = new CActiveDataProvider('TransactionSalesOrder', array(
			'criteria'=>$salesCriteria,
		));

		$consignment = new ConsignmentOutHeader('search');
      	$consignment->unsetAttributes();  // clear any default values
      	if (isset($_GET['ConsignmentOutHeader']))
        	$consignment->attributes = $_GET['ConsignmentOutHeader'];

		$consignmentCriteria = new CDbCriteria;
		$consignmentCriteria->compare('consignment_out_no',$consignment->consignment_out_no.'%',true,'AND', false);
		$consignmentCriteria->addCondition("status = 'Approved'");
		$consignmentDataProvider = new CActiveDataProvider('ConsignmentOutHeader', array(
			'criteria'=>$consignmentCriteria,
		));

		$deliveryOrder = $this->instantiate($id);

		$this->performAjaxValidation($deliveryOrder->header);

		if(isset($_POST['TransactionDeliveryOrder']))
		{
			

			$this->loadState($deliveryOrder);
			if ($deliveryOrder->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $deliveryOrder->header->id));
			}else{
				foreach($deliveryOrder->details as $detail){
					//echo $detail->quantity_request;
				}
			} 

		}

		$this->render('update',array(
			'deliveryOrder'=>$deliveryOrder,
			'sent'=>$sent,
			'sentDataProvider'=>$sentDataProvider,
			'sales'=>$sales,
			'salesDataProvider'=>$salesDataProvider,
			'consignment'=>$consignment,
			'consignmentDataProvider'=>$consignmentDataProvider,
			'transfer'=>$transfer,
			'transferDataProvider'=>$transferDataProvider,
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
		$dataProvider=new CActiveDataProvider('TransactionDeliveryOrder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TransactionDeliveryOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TransactionDeliveryOrder']))
			$model->attributes=$_GET['TransactionDeliveryOrder'];

		$transfer = new TransactionTransferRequest('search');
      	$transfer->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionTransferRequest']))
        	$transfer->attributes = $_GET['TransactionTransferRequest'];

		$transferCriteria = new CDbCriteria;
		$transferCriteria->compare('transfer_request_no',$transfer->transfer_request_no.'%',true,'AND', false);
		$transferCriteria->addCondition("status_document = 'Approved'");
		$transferDataProvider = new CActiveDataProvider('TransactionTransferRequest', array(
			'criteria'=>$transferCriteria,
		));

		$sent = new TransactionSentRequest('search');
      	$sent->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionSentRequest']))
        	$sent->attributes = $_GET['TransactionSentRequest'];

		$sentCriteria = new CDbCriteria;
		$sentCriteria->compare('sent_request_no',$sent->sent_request_no.'%',true,'AND', false);
		$sentCriteria->addCondition("status_document = 'Approved'");
		$sentDataProvider = new CActiveDataProvider('TransactionSentRequest', array(
			'criteria'=>$sentCriteria,
		));

		$sales = new TransactionSalesOrder('search');
      	$sales->unsetAttributes();  // clear any default values
      	if (isset($_GET['TransactionSalesOrder']))
        	$sales->attributes = $_GET['TransactionSalesOrder'];

		$salesCriteria = new CDbCriteria;
		$salesCriteria->compare('sale_order_no',$sales->sale_order_no.'%',true,'AND', false);
		$salesCriteria->addCondition("status_document = 'Approved'");
		$salesDataProvider = new CActiveDataProvider('TransactionSalesOrder', array(
			'criteria'=>$salesCriteria,
		));

		$consignment = new ConsignmentOutHeader('search');
      	$consignment->unsetAttributes();  // clear any default values
      	if (isset($_GET['ConsignmentOutHeader']))
        	$consignment->attributes = $_GET['ConsignmentOutHeader'];

		$consignmentCriteria = new CDbCriteria;
		$consignmentCriteria->compare('consignment_out_no',$consignment->consignment_out_no.'%',true,'AND', false);
		$consignmentCriteria->addCondition("status = 'Approved'");
		$consignmentDataProvider = new CActiveDataProvider('ConsignmentOutHeader', array(
			'criteria'=>$consignmentCriteria,
		));

		$this->render('admin',array(
			'model'=>$model,
			'sent'=>$sent,
			'sentDataProvider'=>$sentDataProvider,
			'sales'=>$sales,
			'salesDataProvider'=>$salesDataProvider,
			'consignment'=>$consignment,
			'consignmentDataProvider'=>$consignmentDataProvider,
			'transfer'=>$transfer,
			'transferDataProvider'=>$transferDataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TransactionDeliveryOrder the loaded model
	 * @throws CHttpException
	 */

	//Add Detail
	public function actionAjaxHtmlAddDetail($id,$requestType,$requestId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			
			$deliveryOrder = $this->instantiate($id); 	
			$this->loadState($deliveryOrder);
			
			$deliveryOrder->addDetail($requestType,$requestId);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
   		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      $this->renderPartial('_detail', array('deliveryOrder'=>$deliveryOrder
      	
      	), false, true);
		}
	}
	public function actionAjaxHtmlRemoveDetailRequest($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

				

			$deliveryOrder = $this->instantiate($id);
			$this->loadState($deliveryOrder);

			$deliveryOrder->removeDetailAt(); 
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			 $this->renderPartial('_detail', array('deliveryOrder'=>$deliveryOrder
      	
      	), false, true);
		}
	}
	public function actionAjaxHtmlRemoveDetail($id,$index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

				

			$deliveryOrder = $this->instantiate($id);
			$this->loadState($deliveryOrder);

			$deliveryOrder->removeDetail($index); 
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			 $this->renderPartial('_detail', array('deliveryOrder'=>$deliveryOrder
      	
      	), false, true);
		}
	}

	public function actionAjaxSales($id){
		if (Yii::app()->request->isAjaxRequest)
		{
			$customer_name = "";
			$sales = TransactionSalesOrder::model()->findByPk($id);
			if($sales->customer_id != "")
			{
				$customer = Customer::model()->findByPk($sales->customer_id);
				$customer_name = $customer->name;
			}

			
			$object = array(
				'id'=>$sales->id,
				'no' => $sales->sale_order_no,
				'date'=> $sales->sale_order_date,
				'eta'=>$sales->estimate_arrival_date,
				'customer'=>$sales->customer_id,
				'customer_name'=>$customer->name,
				
			);

			echo CJSON::encode($object);
		}
	}

	public function actionAjaxSent($id){
		if (Yii::app()->request->isAjaxRequest)
		{
			$sent = TransactionSentRequest::model()->findByPk($id);

			$object = array(
				'id'=>$sent->id,
				'no' => $sent->sent_request_no,
				'date'=> $sent->sent_request_date,
				'eta'=>$sent->estimate_arrival_date,
				'branch'=>$sent->requester_branch_id,	
				
			);

			echo CJSON::encode($object);
		}
	}

	public function actionAjaxCustomer($id){
		if (Yii::app()->request->isAjaxRequest)
		{
			$customer = Customer::model()->findByPk($id);

			$object = array(
				'id'=>$customer->id,
				'name' => $customer->name,
				//'email'=> $supplier->email,
				
				
			);

			echo CJSON::encode($object);
		}
	}
	public function instantiate($id)
	{
		if (empty($id)){
			$deliveryOrder = new DeliveryOrders(new TransactionDeliveryOrder(), array());
			//print_r("test");
		}
		else
		{
			$deliveryOrderModel = $this->loadModel($id);
			$deliveryOrder = new DeliveryOrders($deliveryOrderModel, $deliveryOrderModel->transactionDeliveryOrderDetails);
			//print_r("test");
		}
		return $deliveryOrder;
	}
	public function loadState($deliveryOrder)
	{
		if (isset($_POST['TransactionDeliveryOrder']))
		{
			$deliveryOrder->header->attributes = $_POST['TransactionDeliveryOrder'];
		}


		if (isset($_POST['TransactionDeliveryOrderDetail']))
		{
			foreach ($_POST['TransactionDeliveryOrderDetail'] as $i => $item)
			{
				if (isset($deliveryOrder->details[$i])){
					$deliveryOrder->details[$i]->attributes = $item;
				}

				else
				{
					$detail = new TransactionDeliveryOrderDetail();	
					$detail->attributes = $item;
					$deliveryOrder->details[] = $detail;
					
				} 
			}
			if (count($_POST['TransactionDeliveryOrderDetail']) < count($deliveryOrder->details))
				array_splice($deliveryOrder->details, $i + 1);
		}
		else
			{
				$deliveryOrder->details = array();
				
			}



	}


	public function actionPdf($id){
		// var_dump(Yii::getPathOfAlias('webroot') ); die();
		$do = $this->loadModel($id);
		// var_dump($do); die();
		$supplier = '0';//Supplier::model()->find('id=:id', array(':id'=>$po->supplier_id));
		$branch = '0';//Branch::model()->find('id=:id', array(':id'=>$po->main_branch_id));
		$deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id'=>$id));
		$mPDF1 = Yii::app()->ePdf->mpdf();
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');
		//$stylesheet = file_get_contents(Yii::getPathOfAlias('pdfcss') . '/pdf.css');
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/css/pdf.css');
		$mPDF1->WriteHTML($stylesheet, 1);
		$mPDF1->WriteHTML($this->renderPartial('pdf', array('model'=>$do,'deliveryDetails'=>$deliveryDetails), true));
		$mPDF1->Output();
	}


	public function loadModel($id)
	{
		$model=TransactionDeliveryOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TransactionDeliveryOrder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transaction-delivery-order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAjaxConsignment($id){
		if (Yii::app()->request->isAjaxRequest)
		{
			$customer_name = "";
			$consigment = ConsignmentOutHeader::model()->findByPk($id);
			if($consigment->customer_id != "")
			{
				$customer = Customer::model()->findByPk($consigment->customer_id);
				$customer_name = $customer->name;
			}

			
			$object = array(
				'id'=>$consigment->id,
				'no' => $consigment->consignment_out_no,
				'date'=> $consigment->date_posting,
				'eta'=>$consigment->delivery_date,
				'customer'=>$consigment->customer_id,
				'customer_name'=>$customer_name,
				
			);

			echo CJSON::encode($object);
		}
	}

	public function actionAjaxTransfer($id){
		if (Yii::app()->request->isAjaxRequest)
		{
			$branch_name = "";
			$transfer = TransactionTransferRequest::model()->findByPk($id);
			if($transfer->destination_branch_id != "" )
			{
				$branch = Branch::model()->findByPk($transfer->destination_branch_id);
				$branch_name = $branch->name;
			}

			$object = array(
				'id'=>$transfer->id,
				'no' => $transfer->transfer_request_no,
				'date'=> $transfer->transfer_request_date,
				'eta'=>$transfer->estimate_arrival_date,
				'branch'=>$transfer->destination_branch_id,
				'branch_name'=>$branch_name,
				
			);

			echo CJSON::encode($object);
		}
	}
}
