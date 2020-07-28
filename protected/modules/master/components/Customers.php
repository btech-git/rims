<?php

class Customers extends CComponent
{
	public $header;
	public $phoneDetails;
	public $mobileDetails;
	public $picDetails;
	public $vehicleDetails;
	public $serviceDetails;
	
	public function __construct($header, array $phoneDetails, array $mobileDetails, array $picDetails, array $vehicleDetails, array $serviceDetails)
	{
		$this->header = $header;
		$this->phoneDetails = $phoneDetails;
		$this->mobileDetails = $mobileDetails;
		$this->picDetails= $picDetails;
		$this->vehicleDetails = $vehicleDetails;
		$this->serviceDetails = $serviceDetails;
	}

	public function addDetail()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$phoneDetail = new CustomerPhone();
		//$detail->mata_uang_id = 1;
		//$detail->unit_price = $price;
		//$detail->transaction_type = $transactionType;
		$this->phoneDetails[] = $phoneDetail;
		//print_r($this->details);
	}
	public function addMobileDetail()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$mobileDetail = new CustomerMobile();
		//$detail->mata_uang_id = 1;
		//$detail->unit_price = $price;
		//$detail->transaction_type = $transactionType;
		$this->mobileDetails[] = $mobileDetail;
		//print_r($this->details);
	}

	public function addPicDetail()
	{
		$picDetail = new CustomerPic();
		
		$this->picDetails[] = $picDetail;
		
	}
	public function addVehicleDetail()
	{
		$vehicleDetail = new Vehicle();
		
		$this->vehicleDetails[] = $vehicleDetail;
		
	}
	public function addServiceDetail($serviceId)
	{
		$service = Service::model()->findByPk($serviceId);
		$serviceDetail = new CustomerServiceRate();
		$serviceDetail->service_type_id = $service->service_type_id;
		$serviceDetail->service_category_id = $service->service_category_id;
		$serviceDetail->service_id = $service->id;
		$this->serviceDetails[] = $serviceDetail;
		
	}

	public function removeDetailAt($index)
	{
		array_splice($this->phoneDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}
	public function removeMobileDetailAt($index)
	{
		array_splice($this->mobileDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}

	public function removePicDetailAt($index)
	{
		array_splice($this->picDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}

	public function removeVehicleDetailAt($index)
	{
		array_splice($this->vehicleDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}
	public function removeServiceDetailAt($index)
	{
		array_splice($this->serviceDetails, $index, 1);
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

		//$valid = $this->validateDetailsCount() && $valid;

		if (count($this->phoneDetails) > 0)
		{
			foreach ($this->phoneDetails as $phoneDetail)
			{
				$fields = array('phone_no');
				$valid = $phoneDetail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}

		if (count($this->mobileDetails) > 0)
		{
			foreach ($this->mobileDetails as $mobileDetail)
			{
				$fields = array('mobile_no');
				$valid = $mobileDetail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}

		if (count($this->picDetails) > 0)
		{
			foreach ($this->picDetails as $picDetail)
			{
				$fields = array('name','address');
				$valid = $picDetail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}

		if (count($this->vehicleDetails) > 0)
		{
			foreach ($this->vehicleDetails as $vehicleDetail)
			{
				$fields = array('plate_number','machine_number');
				$valid = $vehicleDetail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}

		//print_r($valid);
		return $valid;
	}

//	public function validateDetailsCount()
//	{
//		$valid = true;
//		if (count($this->phoneDetails) === 0)
//		{
//			$valid = false;
//			$this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
//		}
//
//		return $valid;
//	}


	public function flush()
	{
//		$isNewRecord = $this->header->isNewRecord;
        
		if ($this->header->customer_type == 'Individual')
			$this->header->coa_id = 1;
        
		$valid = $this->header->save();
		//echo $valid;
		
		$customer_phones = CustomerPhone::model()->findAllByAttributes(array('customer_id'=>$this->header->id));
		$phoneId = array();
		foreach($customer_phones as $customer_phone)
		{
			$phoneId[]=$customer_phone->id;
		}
		$new_detail = array();

		$customer_mobiles = CustomerMobile::model()->findAllByAttributes(array('customer_id'=>$this->header->id));
		$mobileId = array();
		foreach($customer_mobiles as $customer_mobile)
		{
			$mobileId[]= $customer_mobile->id;
		}
		$new_mobile = array();

		$customer_pics = CustomerPic::model()->findAllByAttributes(array('customer_id'=>$this->header->id));
		$picId = array();
		foreach($customer_pics as $customer_pic)
		{
			$picId[]= $customer_pic->id;
		}
		$new_pic = array();

		$customer_vehicles = Vehicle::model()->findAllByAttributes(array('customer_id'=>$this->header->id));
		$vehicleId = array();
		foreach($customer_vehicles as $customer_vehicle)
		{
			$vehicleId[]= $customer_vehicle->id;
		}
		$new_vehicle = array();

		$customer_services = CustomerServiceRate::model()->findAllByAttributes(array('customer_id'=>$this->header->id));
		$serviceId = array();
		foreach($customer_services as $customer_service)
		{
			$serviceId[]= $customer_service->id;
		}
		$new_service = array();

		//phone
		foreach ($this->phoneDetails as $phoneDetail)
		{
			$phoneDetail->customer_id = $this->header->id;
			
			$valid = $phoneDetail->save(false) && $valid;
			$new_detail[] = $phoneDetail->id;
			//echo 'test';
		}

		//mobile
		foreach ($this->mobileDetails as $mobileDetail)
		{
			$mobileDetail->customer_id = $this->header->id;
			$valid = $mobileDetail->save(false) && $valid;
			$new_mobile[] = $mobileDetail->id;	
		}

		//pic
		foreach ($this->picDetails as $picDetail)
		{
			$picDetail->customer_id = $this->header->id;
			$valid = $picDetail->save(false) && $valid;
			$new_pic[] = $picDetail->id;	

		}

		//vehicle
		foreach ($this->vehicleDetails as $vehicleDetail)
		{
			$vehicleDetail->customer_id = $this->header->id;
			$pics = CustomerPic::model()->findByAttributes(array('customer_id'=>$this->header->id));
			if(isset($vehicleDetail->customer_pic_id)) {
				$vehicleDetail->customer_pic_id = $pics->id;
			}
			
			$valid = $vehicleDetail->save(false) && $valid;
			$new_vehicle[] = $vehicleDetail->id;	
		}

			//service Price
		foreach ($this->serviceDetails as $serviceDetail)
		{
			$serviceDetail->customer_id = $this->header->id;
			
			$valid = $serviceDetail->save(false) && $valid;
			$new_service[] = $serviceDetail->id;	
		}


		//var_dump(CJSON::encode($this->phoneDetails));

		//delete phone
//		$delete_array = array_diff($phoneId, $new_detail);
//		if($delete_array != NULL)
//		{
//			$criteria = new CDbCriteria;
//			$criteria->addInCondition('id',$delete_array);
//			CustomerPhone::model()->deleteAll($criteria);
//		}

		//delete mobile
//		$delete_mobile = array_diff($mobileId, $new_mobile);
//		if($delete_mobile != NULL)
//		{
//			$mobile_criteria = new CDbCriteria;
//			$mobile_criteria->addInCondition('id',$delete_mobile);
//			CustomerMobile::model()->deleteAll($mobile_criteria);
//		}

		//delete pic
//		$delete_pic = array_diff($picId, $new_pic);
//		if($delete_pic != NULL)
//		{
//			$pic_criteria = new CDbCriteria;
//			$pic_criteria->addInCondition('id',$delete_pic);
//			CustomerPic::model()->deleteAll($pic_criteria);
//		}

		//delete vehicle
//		$delete_vehicle = array_diff($vehicleId, $new_vehicle);
//		if($delete_vehicle != NULL)
//		{
//			$vehicle_criteria = new CDbCriteria;
//			$vehicle_criteria->addInCondition('id',$delete_vehicle);
//			Vehicle::model()->deleteAll($vehicle_criteria);
//		}

		//delete service
//		$delete_service = array_diff($serviceId, $new_service);
//		if($delete_service != NULL)
//		{
//			$service_criteria = new CDbCriteria;
//			$service_criteria->addInCondition('id',$delete_service);
//			CustomerServiceRate::model()->deleteAll($service_criteria);
//		}

		return $valid;

	}
}
