<?php

class TransferRequests extends CComponent
{
	public $header;
	public $details;
	
	// /public $detailApprovals;
	
	// public $picPhoneDetails;
	// public $picMobileDetails;

	public function __construct($header, array $details)
	{
		$this->header = $header;
		$this->details = $details;
		
		//$this->detailApprovals = $detailApprovals;
	}

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transfer_request_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transfer_request_no, '/', 2), '/', -1), '.', -1)";
        $transactionTransferOrder = TransactionTransferRequest::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND requester_branch_id = :requester_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':requester_branch_id' => $requesterBranchId),
        ));
        
        if ($transactionTransferOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionTransferOrder->requesterBranch->code;
            $this->header->transfer_request_no = $transactionTransferOrder->transfer_request_no;
        }

        $this->header->setCodeNumberByNext('transfer_request_no', $branchCode, TransactionTransferRequest::CONSTANT, $currentMonth, $currentYear);
    }
	
	public function addDetail()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$detail = new TransactionTransferRequestDetail();
	
		$this->details[] = $detail;

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

				$fields = array('unit_price');
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
		$valid = $this->header->save();
		//echo "valid";

		$requestDetails  = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id'=>$this->header->id));
		$detail_id = array();
		foreach($requestDetails as $requestDetail)
		{
			$detail_id[]=$requestDetail->id;
		}
		$new_detail= array();

		//save request detail
		foreach ($this->details as $detail)
		{
			$detail->transfer_request_id = $this->header->id;
			if($isNewRecord)
				$detail->quantity_delivery_left = $detail->quantity;
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
			TransactionTransferRequestDetail::model()->deleteAll($criteria);
		}

		
		return $valid;

	
}
}