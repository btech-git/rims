<?php

class QuickServices extends CComponent
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

	
	public function addDetail($serviceId)
	{
		$detail = new QuickServiceDetail();
		
		$detail->service_id = $serviceId;
		$service = Service::model()->findByPk($serviceId);
		$detail->price = $service->price;
		$detail->final_price = $service->price;
		$detail->hour = $service->flat_rate_hour;
		// $detail->service_standard_pricelist_id = $servicePriceId;
		// $serviceStandardPrice = ServiceStandardPricelist::model()->findByPk($servicePriceId);
		// $detail->price = $serviceStandardPrice->price;
		// /$service = Service::model()->findByPk($detail->service_id);
		//$detail->service_name = $service->name;
		
		$this->details[] = $detail;
		
	}
	



	public function removeDetailAt($index)
	{	
		array_splice($this->details, $index, 1);
		//var_dump(CJSON::encode($this->details));
		//$this->details = array();
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
		$valid = $this->header->save();
		//echo "valid";

		$service_pricelists = QuickServiceDetail::model()->findAllByAttributes(array('quick_service_id'=>$this->header->id));
		$price_id = array();
		foreach($service_pricelists as $service_pricelist)
		{
			$price_id[]=$service_pricelist->id;
		}
		$new_detail_price = array();

		//save pricelist
		foreach ($this->details as $detail)
		{
			$detail->quick_service_id = $this->header->id;
			
			$valid = $detail->save(false) && $valid;
			$new_detail_price[] = $detail->id;
			//echo 'test';
		}


		//delete pricelist
		$delete_array_price = array_diff($price_id, $new_detail_price);
		if($delete_array_price != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array_price);
			QuickServiceDetail::model()->deleteAll($criteria);
		}
		return $valid;

	
	}
}