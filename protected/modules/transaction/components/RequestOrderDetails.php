<?php

class RequestOrderDetails extends CComponent
{
	public $requestDetail;
	public $detailApprovals;
	

	public function __construct($requestDetail, array $detailApprovals)
	{
		$this->requestDetail = $requestDetail;
		$this->requestDetails = $requestDetails;
		
	}

	
	public function addDetailApproval()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$requestDetail = new TransactionRequestOrderApproval();
	
		$this->requestDetails[] = $requestDetail;

		//echo "5";
	}
	

	public function removeDetailAt($index)
	{
		array_splice($this->details, $index, 1);
		//var_dump(CJSON::encode($this->details));
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
		if (count($this->transferDetails) > 0)
		{
			foreach ($this->transferDetails as $transferDetail)
			{

				$fields = array('quantity');
				$valid = $transferDetail->validate($fields) && $valid;
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
		$valid = $this->header->save();
		//echo "valid";

		$requestDetails  = TransactionRequestOrderDetail::model()->findAllByAttributes(array('request_order_id'=>$this->header->id));
		$detail_id = array();
		foreach($requestDetails as $requestDetail)
		{
			$detail_id[]=$requestDetail->id;
		}
		$new_detail= array();

		//save request detail
		foreach ($this->details as $detail)
		{
			$detail->request_order_id = $this->header->id;
			$detail->request_order_quantity_rest = $detail->quantity;
			$valid = $detail->save(false) && $valid;
			$new_detail[] = $detail->id;
			//echo 'test';
		}


		//delete pricelist
		$delete_array= array_diff($detail_id, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			TransactionRequestOrderDetail::model()->deleteAll($criteria);
		}

		//save transfer
		$requestTransfers  = TransactionRequestTransfer::model()->findAllByAttributes(array('request_order_id'=>$this->header->id));
		$transfer_id = array();
		foreach($requestTransfers as $requestTransfer)
		{
			$transfer_id[]=$requestTransfer->id;
		}
		$new_transfer= array();

		//save request detail
		foreach ($this->transferDetails as $transferDetail)
		{
			$transferDetail->request_order_id = $this->header->id;
			
			$valid = $transferDetail->save(false) && $valid;
			$new_transfer[] = $transferDetail->id;
			//echo 'test';
		}


		//delete 
		$delete_transfer_array= array_diff($transfer_id, $new_transfer);
		if($delete_transfer_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_transfer_array);
			TransactionRequestTransfer::model()->deleteAll($criteria);
		}
		return $valid;

	}
}
