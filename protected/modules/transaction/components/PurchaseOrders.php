<?php

class PurchaseOrders extends CComponent
{
	public $header;
	public $details;
	public $detailRequests;
	
	// public $picPhoneDetails;
	// public $picMobileDetails;

	public function __construct($header, array $details)
	{
		$this->header = $header;
		$this->details = $details;
		$this->detailRequests = array();
	}

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(purchase_order_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(purchase_order_no, '/', 2), '/', -1), '.', -1)";
        $transactionPurchaseOrder = TransactionPurchaseOrder::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND main_branch_id = :main_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':main_branch_id' => $requesterBranchId),
        ));
        
        if ($transactionPurchaseOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionPurchaseOrder->mainBranch->code;
            $this->header->purchase_order_no = $transactionPurchaseOrder->purchase_order_no;
        }

        $this->header->setCodeNumberByNext('purchase_order_no', $branchCode, TransactionPurchaseOrder::CONSTANT, $currentMonth, $currentYear);
    }
	
	// public function addDetail($requestId,$supplierId)
	// {
	// 	$requestOrder = TransactionRequestOrder::model()->findByPK($requestId);
	// 	$requestOrderDetails = TransactionRequestOrderDetail::model()->findAllByAttributes(array('request_order_id'=>$requestOrder->id,'supplier_id'=>$supplierId));
	// 	foreach ($requestOrderDetails as $key => $requestOrderDetail) {
	// 		$detail = new TransactionPurchaseOrderDetail();
	// 		$detail->request_order_detail_id = $requestOrderDetail->id;
	// 		$detail->product_id = $requestOrderDetail->product_id;
	// 		$detail->branch_addressed_to = $requestOrder->main_branch;
	// 		$detail->unit_id = $requestOrderDetail->unit_id;
	// 		$detail->request_order_id = $requestOrder->id;
	// 		$detail->retail_price = $requestOrderDetail->retail_price;
	// 		$detail->last_buying_price = $requestOrderDetail->last_buying_price;
	// 		$detail->request_price = $requestOrderDetail->price;
	// 		$detail->discount_step = $requestOrderDetail->discount_step;
	// 		$detail->discount1_type = $requestOrderDetail->discount1_type;
	// 		$detail->discount1_nominal = $requestOrderDetail->discount1_nominal;
	// 		$detail->discount1_type = $requestOrderDetail->discount1_type;
	// 		$detail->discount1_nominal = $requestOrderDetail->discount1_nominal;
	// 		$detail->discount2_type = $requestOrderDetail->discount2_type;
	// 		$detail->discount2_nominal = $requestOrderDetail->discount2_nominal;
	// 		$detail->discount3_type = $requestOrderDetail->discount3_type;
	// 		$detail->discount3_nominal = $requestOrderDetail->discount3_nominal;
	// 		$detail->discount4_type = $requestOrderDetail->discount4_type;
	// 		$detail->discount4_nominal = $requestOrderDetail->discount4_nominal;
	// 		$detail->discount5_type = $requestOrderDetail->discount5_type;
	// 		$detail->discount5_nominal = $requestOrderDetail->discount5_nominal;
	// 		$detail->request_quantity = $requestOrderDetail->quantity;
	// 		$detail->request_order_quantity_rest = $requestOrderDetail->request_order_quantity_rest;
			
	// 		$this->details[] = $detail;
	// 	}
		
	
		

	// 	//echo "5";
	// }
	

	public function addDetail($productId)
	{
			$detail = new TransactionPurchaseOrderDetail();
			$detail->product_id = $productId;
			$product = Product::model()->findByPK($productId);
			$detail->unit_id = $product->unit_id;
            $detail->retail_price = $product->retail_price;
            $detail->hpp = $product->hpp;
//			$productUnit = ProductUnit::model()->findByAttributes(array('product_id'=>$product->id,'unit_type'=>'Main'));
//			if(count($productUnit) != 0)
//				$detail->unit_id = $productUnit->id;
//			if ($product->ppn == 1)
//				$detail->retail_price = $product->retail_price / 1.1;
//			else
			
			$this->details[] = $detail;
	
	}

	

	public function removeDetailAt($index)
	{
		array_splice($this->details, $index, 1);
		//var_dump(CJSON::encode($this->details));
		
	}
	public function removeDetailSupplier()
	{
		$this->details = array();
	}
	
    public function updateTaxes() {
        foreach ($this->details as $detail)
            $detail->tax_amount = $detail->getTaxAmount($this->header->ppn);
    }

	public function save($dbConnection)
	{
		$dbTransaction = $dbConnection->beginTransaction();
		try
		{
			$valid = $this->validate() && $this->flush();
			if ($valid){
				$dbTransaction->commit();
				//print_r('1');
			} else {
				$dbTransaction->rollback();
				//print_r('2');
			}

		}
		catch (Exception $e)
		{
			$dbTransaction->rollback();
			$valid = false;
			//print_r($e);
		}

		return $valid;
		//print_r('success');
	}

	public function validate()
	{
		$valid = $this->header->validate();

		
		if (count($this->details) > 0)
		{
			foreach ($this->details as $detail)
			{

				$fields = array('price');
				$valid = $detail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}
		

		//print_r($valid);
		return $valid;
	}

	public function validateDetailsCount()
	{
		$valid = true;
		if (count($this->details	) === 0)
		{
			$valid = false;
			$this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
		}

		return $valid;
	}


	public function flush()
	{
		$isNewRecord = $this->header->isNewRecord;
        $this->header->total_quantity = $this->totalQuantity;
        $this->header->price_before_discount = $this->subTotalBeforeDiscount;
        $this->header->discount = $this->subTotalDiscount;
        $this->header->ppn_price = $this->taxAmount;
        $this->header->subtotal = $this->subTotal;
        $this->header->total_price = $this->grandTotal;
        $this->header->payment_amount = 0;
        $this->header->payment_left = $this->grandTotal;
		$valid = $this->header->save();
		//if($valid){echo "Test";}
		//print_r($this->header);
		$purchaseDetails  = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id'=>$this->header->id));
		
		$detail_id = array();
		foreach($purchaseDetails as $purchaseDetail)
		{
			$detail_id[]=$purchaseDetail->id;
		}
		$new_detail= array();

		//save request detail
		foreach ($this->details as $detail)
		{
			$detail->purchase_order_id = $this->header->id;
            $detail->unit_price = $detail->unitPrice;
            $detail->total_price = $detail->grandTotal;
            $detail->total_quantity = $detail->quantityAfterBonus;
            
			if ($isNewRecord)
				$detail->purchase_order_quantity_left = $detail->total_quantity;
            
			//echo $detail->purchase_order_id;
			$valid = $detail->save(false) && $valid;
			
			// $requestOrderDetail = TransactionRequestOrderDetail::model()->findByPK($detail->request_order_detail_id);

			// $requestOrderDetail->purchase_order_quantity = $detail->quantity;
			// $requestOrderDetail->request_order_quantity_rest = $requestOrderDetail->quantity - $detail->quantity;
			// $requestOrderDetail->save(false);
			// $detail->request_order_quantity_rest = $requestOrderDetail->quantity - $detail->quantity;
			// $detail->purchase_order_quantity_rest = $detail->quantity;
			// $valid = $detail->save(false) && $valid;
			if (isset($_POST['TransactionPurchaseOrderDetailRequest'][$detail->product_id]))
			{
				$allRequest = TransactionPurchaseOrderDetailRequest::model()->deleteAll('`purchase_order_detail_id` = :purchase_order_detail_id',array(':purchase_order_detail_id'=>$detail->id,));
				$allOrdered = TransactionDetailOrder::model()->deleteAll('`purchase_order_detail_id` = :purchase_order_detail_id',array(':purchase_order_detail_id'=>$detail->id,));
				foreach ($_POST['TransactionPurchaseOrderDetailRequest'][$detail->product_id] as $key => $detailOrder) {
					//echo($detailRequest['purchase_request_id']);
					$detailRequest = new TransactionPurchaseOrderDetailRequest();
					$detailRequest->purchase_order_detail_id = $detail->id;
					$detailRequest->purchase_request_id = $detailOrder['purchase_request_id'];
					$detailRequest->purchase_request_detail_id = $detailOrder['purchase_request_detail_id'];
					$detailRequest->purchase_request_quantity = $detailOrder['purchase_request_quantity'];
					$detailRequest->estimate_date_arrival = $detailOrder['estimate_date_arrival'];
					$detailRequest->purchase_request_branch_id = $detailOrder['purchase_request_branch_id'];
					$detailRequest->purchase_order_quantity = $detailOrder['purchase_order_quantity'];
					$detailRequest->notes = $detailOrder['notes'];
					$detailRequest->save();
					
					$criteria = new CDbCriteria;
					$criteria->condition = "id =".$detailRequest->id ." AND purchase_request_detail_id = ".$detailRequest->purchase_request_detail_id;
					$detailOrders = TransactionPurchaseOrderDetailRequest::model()->findAll($criteria);
					$quantity = 0;
					foreach($detailOrders as $detailOrder)
					{
						$quantity += $detailOrder->purchase_order_quantity;
					}
					$purchaseRequestDetail = TransactionRequestOrderDetail::model()->findByPk($detailRequest->purchase_request_detail_id);
					$purchaseRequestDetail->purchase_order_quantity = $quantity + $detailRequest->purchase_order_quantity;
					$purchaseRequestDetail->request_order_quantity_rest = $purchaseRequestDetail->quantity - ($quantity + $detailRequest->purchase_order_quantity);
					$purchaseRequestDetail->save(false);
					// $detailOrdered = TransactionRequestOrderDetail::model()->findByPK($detailRequest->purchase_request_detail_id);
					// $detailOrdered->purchase_order_id = $this->header->id;
					// $detailOrdered->purchase_order_detail_id = $detail->id;
					// $detailOrdered->purchase_request_id = $detailRequest->purchase_request_id;
					// $detailOrdered->purchase_request_detail_id = $detailRequest->purchase_request_detail_id;
					// $detailOrdered->purchase_order_quantity = $detailRequest->purchase_order_quantity;
					// $detailOrdered->purchase_order_quantity_left = $detailRequest->purchase_request_quantity - $detailRequest->purchase_order_quantity;
					// $detailOrdered->purchase_order_estimate_arrival_date = $this->header->estimate_date_arrival;
					// $detailOrdered->unit_price = $detail->unit_price;
					// $detailOrdered->supplier_id = $this->header->supplier_id;
					// $detailOrdered->product_id = $detail->product_id;
					// $detailOrdered->save();
					
					
					
				// 		$detailRequest->purchase_order_detail_id = $detail->id;
				// 		$detailRequest->purchase_request = 

				}
				//foreach ($_POST['TransactionPurchaseOrderDetail'][$detail->product_id] as $i => $item)
				//{
				// 		$detailRequest = new TransactionPurchaseOrderDetailRequest();
				// 		$detailRequest->purchase_order_detail_id = $detail->id;
				// 		$detailRequest->purchase_request = 
				//	echo $item[$i]['purchase_request_id'];
				//}
			}
			
			$new_detail[] = $detail->id;
			//echo 'test';
		}

		//delete pricelist
		$delete_array= array_diff($detail_id, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			TransactionPurchaseOrderDetail::model()->deleteAll($criteria);
		}
		
		 return $valid;
	}
    
    public function getTotalQuantity() {
        $total = 0.00;
        
        foreach ($this->details as $detail) 
            $total += $detail->quantityAfterBonus;

        return $total;
    }
    
    public function getSubTotalDiscount() {
        $total = 0.00;
        
        foreach ($this->details as $detail)
            $total += $detail->totalDiscount;

        return $total;                
    }
    
    public function getSubTotalBeforeDiscount() {
        $total = 0.00;
        
        foreach ($this->details as $detail)
            $total += $detail->totalBeforeDiscount;

        return $total;        
    }
    
    public function getSubTotal() {
        $total = 0.00;
        
        foreach ($this->details as $detail)
            $total += $detail->subTotal;

        return $total;
    }
    
    public function getTaxAmount() {
        return ($this->header->ppn == 1) ? $this->subTotal * 10 /100 : 0.00;
    }
    
    public function getGrandTotal() {
        return $this->subTotal + $this->taxAmount;
    }
}
