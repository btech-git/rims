<?php

class CompareController extends Controller
{
	public $layout='//layouts/column1';
	public $defaultAction = 'step1';

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TransactionRequestOrder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionPrTemp() {
		if(Yii::app()->request->isAjaxRequest) {
			// var_dump($_GET['productChecked']);die("s");
			if ($_GET['checked'] == 'clear') {
				Yii::app()->session->remove('pr');
				Yii::app()->session->remove('pd');
			}else{
				Yii::app()->session['pr'] = $_GET['checked'];
			}
		}
	}
	public function actionPdTemp() {

		if(Yii::app()->request->isAjaxRequest) {
			if ($_GET['checked'] == 'clear') {
				Yii::app()->session->remove('pd');
			}else{
				Yii::app()->session['pd'] = $_GET['checked'];
			}
		}
	}

	public function actionStep1()
	{
		$model=new TransactionRequestOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TransactionRequestOrder'])){
			$model->attributes=$_GET['TransactionRequestOrder'];
		}
		$statusid = (!empty($_GET['status'])) ? 'yes' : 'no';
		$brancid = (!empty($_GET['branchid'])) ? $_GET['branchid'] : 'no';
        
        $dataProvider = $model->search();
        $dataProvider->criteria->compare('status_document', 'Approved');
        $dataProvider->criteria->addCondition("t.id NOT IN (
				SELECT purchase_request_id
				FROM " . TransactionPurchaseOrderDetailRequest::model()->tableName() . "
			)"
        );
	    // $criteriam=new CDbCriteria();
	    // $criteriam->compare('has_compare',$statusid,true);
	    // $criteriam->compare('requester_branch_id',$brancid,true);
	    // $criteria->compare('request_order_date',$dateid,true);

   //      $model = new CActiveDataProvider('TransactionRequestOrder', array(
			// 'criteria' => $criteriam,
   //          'pagination' => array(
   //          	'pagesize' => 10,
   //          ),
   //      )); 

		(!empty(Yii::app()->session['pr'])) ? $pr = Yii::app()->session['pr'] : $pr = array();
		(!empty(Yii::app()->session['pd'])) ? $pd = Yii::app()->session['pd'] : $pd = array();
	    $criteria=new CDbCriteria();
	    $criteria->addInCondition('request_order_id',$pr);
//		$criteria->compare('status_document', 'Approved');
//	    $criteria->addInCondition('status_document', 'Approved');

        $dp = new CActiveDataProvider('TransactionRequestOrderDetail', array(
			'criteria' => $criteria,
            'sort'=>array(
                'attributes'=>array(
                    'product_id',
                ),
                'defaultOrder' => 'product_id',  
            ),
            'pagination' => array(
            	'pagesize' => 30,
            ),
        )); 


		$this->render('step1',array(
			'model'=>$model,
			'modelDetail'=>$dp,
            'dataProvider' => $dataProvider,
			'prChecked'=>$pr, 
			'pdChecked'=>$pd, 
		));
	}

	public function actionStep2() {

		// list product supplier
		(!empty(Yii::app()->session['pd'])) ? $pd = Yii::app()->session['pd'] : $pd = array();
	    $criteria=new CDbCriteria();
	    $criteria->addInCondition('id',$pd);
        $dp = new CActiveDataProvider('TransactionRequestOrderDetail', array(
			'criteria' => $criteria,
            'sort'=>array(
                'attributes'=>array(
                    'supplier_id',
                ),
                'defaultOrder' => 'supplier_id',  
            ),
            'pagination' => array(
            	'pagesize' => 30,
            ),
        )); 


        $result = array(); $totalPrice = array(); $totalQty = array(); $original_price = array(); 
		foreach ($dp->getData() as $key => $entry) {
		    // $result[$entry['supplier_id']][$key] = $entry;
		    $result[$entry['supplier_id']][] = $entry;
		    $totalPrice[$entry['supplier_id']][] = $entry->total_price;
		    $totalQty[$entry['supplier_id']][] = $entry->quantity;
		    $original_price[$entry['supplier_id']][] = $entry->quantity * $entry->retail_price;
		}

		// var_dump($result[1]);
		// echo "<hr />"; 
		// die("S");
		/*$result = array();
			foreach ($dp->getData() as $data) {
				$id = $data['supplier_id'];
				if (isset($result[$id])) {
					$result[$id][]= $data;
					// $result[$id]['request_order_id'] = $data->request_order_id;
				} else {
					$result[$id][]= $data;
					// $result[$id]['request_order_id'][] = $data->request_order_id;
				}
			}
		*/

        // for save po
		$model=new TransactionPurchaseOrder;
		if(isset($_POST['TransactionPurchaseOrder']))
		{
			// var_dump(array_unique($_POST['TransactionPurchaseOrder']['supplier_id'])); die("S");
			// array unique for supplier.
			// looping for supplier [create po by supplier]
			foreach (array_unique($_POST['TransactionPurchaseOrder']['supplier_id']) as $key =>$value) {
				// echo "supplier" . $value ."<br />";
				$model=new TransactionPurchaseOrder;
				$model->attributes=$_POST['TransactionPurchaseOrder'];
				$model->purchase_order_date = date("Y-m-d");
				$model->estimate_date_arrival = date('Y-m-d', strtotime("+".$this->getTenor($value)." days"));;
				$model->status_document = 'Draft';
				$model->supplier_id=$value;
				$model->payment_type = 'Cash';
				$model->purchase_order_no = "PO".date("YmdHisu"); // next step change to afterSave()
				$model->main_branch_id = 1; // next step change to afterSave() with app()->user->id
				// $model->main_branch_id = $_POST['TransactionPurchaseOrder']['main_branch_id'];//1; // next step change to afterSave() with app()->user->id
				// $model->requester_branch_id = $_POST['TransactionPurchaseOrder']['requester_branch_id'];
				$model->ppn = 0;
				$model->ppn_price = 0;
				$model->total_price = array_sum($totalPrice[$value]);
				$model->discount = array_sum($totalPrice[$value]);;
				$model->price_before_discount = array_sum($original_price[$value]);
				$model->subtotal = array_sum($totalPrice[$value]);
				$model->total_quantity = array_sum($totalQty[$value]);
				// $model->validate();
				// var_dump($model->errors);
				// die("S");
				if($model->save()) {

					// $model->purchase_order_no = "PO".$model->id;
					// save detail po
					$this->prosesPO($value,$result[$value],$model);
					$this->prosesPD();
					$this->prosesPR();
					// die("Saved");
				}
				// die("Saved");
			}
			$this->redirect(array('transactionPurchaseOrder/admin'));
		}

		$this->render('step2',array(
			'model'=>$model,
			'modelDetail'=>$dp,
			'pdChecked'=>$pd, 
		));
	}


	public function prosesPO($supplierid,$productDetail=array(),$poId=array()) {
		// looping save to detail po.
		$arr_length = count($productDetail);
		for ($i=0;$i<$arr_length;$i++)
		{
			$modelDetail = new TransactionPurchaseOrderDetail; 
			$modelDetail->setAttributes($productDetail[$i]->getAttributes());
			$modelDetail->purchase_order_id=$poId->id;

			//haursnya ini di Purchase Request sudah di hitung tinggal get/set attributes
			$modelDetail->discount=0;
			$modelDetail->subtotal=0;

				// $modelDetail->validate();
				// var_dump($modelDetail->errors);
				// die("S");

			// $modelDetail->save();
			if($modelDetail->save()) {
				$modelDetailRequest = new TransactionPurchaseOrderDetailRequest; 
				$modelDetailRequest->purchase_order_detail_id = $modelDetail->id;
				$modelDetailRequest->purchase_request_id = $productDetail[$i]->request_order_id;
				$modelDetailRequest->purchase_request_detail_id = $productDetail[$i]->id;
				$modelDetailRequest->purchase_request_quantity = $productDetail[$i]->quantity;
				$modelDetailRequest->purchase_order_quantity = $productDetail[$i]->purchase_order_quantity;
				// $modelDetailRequest->purchase_request_branch_id = $poId->main_branch_id;
				$modelDetailRequest->purchase_request_branch_id = $productDetail[$i]->requestOrder->requester_branch_id;
				$modelDetailRequest->estimate_date_arrival = $poId->estimate_date_arrival;
				$modelDetailRequest->save();
			}

		}
		$i=0;
	}

	public function prosesPR() {
		(!empty(Yii::app()->session['pr'])) ? $pr = Yii::app()->session['pr'] : $pr = array();

		foreach ($pr as $key) {
			$model=TransactionRequestOrderDetail::model()->findAllByAttributes(array('request_order_id'=>$key));
			$hascompare = array();
			foreach ($model as $ids => $value) {
				$hascompare[] = $value->has_compare; 
			}
			
			if (in_array("no", $hascompare)) {
			    // echo "Got mac";
			}else{
				$models=TransactionRequestOrder::model()->findByPk($key);
				$models->has_compare = 'yes';
				if ($models->save()) {
					Yii::app()->session->remove('pr');
					Yii::app()->session->remove('pd');
				}
			}

		}
	}
	
	
	public function prosesPD() {
		(!empty(Yii::app()->session['pd'])) ? $pd = Yii::app()->session['pd'] : $pd = array();

		foreach ($pd as $key) {
			$model=TransactionRequestOrderDetail::model()->findByPk($key);
			$model->has_compare = 'yes';
			
			// return var_dump($model->save()); die("S");
			if ($model->save()) {
				// Yii::app()->session->remove('pd');
				// Yii::app()->session->remove('pr');
			}

		}
	}

	public function getTenor($id) {
		$tenor = Supplier::model()->findByPk($id);
		return (empty($tenor->tenor))?0:$tenor->tenor;
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}