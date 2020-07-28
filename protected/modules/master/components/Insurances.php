<?php

class Insurances extends CComponent
{
	public $header;
	public $priceDetails;
	
	// public $picPhoneDetails;
	// public $picMobileDetails;

	public function __construct($header, array $priceDetails)
	{
		$this->header = $header;
		$this->priceDetails = $priceDetails;
	}

	
	public function addPriceDetail($serviceId)
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$priceDetail = new InsuranceCompanyPricelist();
		$priceDetail->service_id = $serviceId;
		$serviceData = Service::model()->findByPk($priceDetail->service_id);
		$priceDetail->service_name = $serviceData->name;
		$this->priceDetails[] = $priceDetail;

		//echo "5";
	}
	

	public function removePriceDetailAt($index)
	{
		array_splice($this->priceDetails, $index, 1);
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
//				print_r('1');
			} else {
				$dbTransaction->rollback();
//				print_r('2');
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

		
		if (count($this->priceDetails) > 0)
		{
			foreach ($this->priceDetails as $priceDetail)
			{

				$fields = array('price');
				$valid = $priceDetail->validate($fields) && $valid;
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
		if (count($this->priceDetails	) === 0)
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

		$service_pricelists = InsuranceCompanyPricelist::model()->findAllByAttributes(array('insurance_company_id'=>$this->header->id));
		$price_id = array();
		foreach($service_pricelists as $service_pricelist)
		{
			$price_id[]=$service_pricelist->id;
		}
		$new_detail_price = array();

		//save pricelist
		foreach ($this->priceDetails as $priceDetail)
		{
			$priceDetail->insurance_company_id = $this->header->id;
			
			$valid = $priceDetail->save(false) && $valid;
			$new_detail_price[] = $priceDetail->id;
			//echo 'test';
		}


		//delete pricelist
		$delete_array_price = array_diff($price_id, $new_detail_price);
		if($delete_array_price != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array_price);
			InsuranceCompanyPricelist::model()->deleteAll($criteria);
		}
		return $valid;

	}
}
