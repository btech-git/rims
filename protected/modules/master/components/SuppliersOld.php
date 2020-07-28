<?php

class Suppliers extends CComponent
{
	public $header;
	public $phoneDetails;
	public $mobileDetails;
	public $bankDetails;
	public $picDetails;
	public $productDetails;
	// public $picPhoneDetails;
	// public $picMobileDetails;

	public function __construct($header, array $phoneDetails, array $mobileDetails,array $bankDetails, array $picDetails, array $productDetails)
	{
		$this->header = $header;
		$this->phoneDetails = $phoneDetails;
		$this->mobileDetails = $mobileDetails;
		$this->bankDetails = $bankDetails;
		$this->picDetails = $picDetails;
		$this->productDetails = $productDetails;
		// $this->picPhoneDetails = $picPhoneDetails;
		// $this->picMobileDetails = $picMobileDetails;
	}

	public function addDetail()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$phoneDetail = new SupplierPhone();
		//$detail->mata_uang_id = 1;
		//$detail->unit_price = $price;
		//$detail->transaction_type = $transactionType;
		$this->phoneDetails[] = $phoneDetail;
		//print_r($this->details);
	}

	public function addMobileDetail()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$mobileDetail = new SupplierMobile();
		
		//$detail->mata_uang_id = 1;
		//$detail->unit_price = $price;
		//$detail->transaction_type = $transactionType;
		$this->mobileDetails[] = $mobileDetail;
		//print_r($this->details);
	}

	public function addPicDetail()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$picDetail = new SupplierPic();
		//$detail->mata_uang_id = 1;
		//$detail->unit_price = $price;
		//$detail->transaction_type = $transactionType;
		$this->picDetails[] = $picDetail;
		//print_r($this->details);
	}

	public function addPicPhoneDetail()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$picPhoneDetail = new SupplierPicPhone();
		//$detail->mata_uang_id = 1;
		//$detail->unit_price = $price;
		//$detail->transaction_type = $transactionType;
		$this->picPhoneDetails[] = $picPhoneDetail;
		//print_r($this->details);
	}

	public function addPicMobileDetail()
	{
		//$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
		$picMobileDetail = new SupplierPicMobile();
		
		//$detail->mata_uang_id = 1;
		//$detail->unit_price = $price;
		//$detail->transaction_type = $transactionType;
		$this->picMobileDetails[] = $picMobileDetails;
		//print_r($this->details);
	}

	public function addBankDetail($bankId)
	{
		$bankDetail = new SupplierBank();
		$bankDetail->bank_id = $bankId;
		$bank = Bank::model()->findByPk($bankDetail->bank_id);
		$bankDetail->bank_name = $bank->name;
		$this->bankDetails[] = $bankDetail;
	}

	public function addSingleProductDetail($productId)
	{	
		$existing = array();
		foreach ($this->productDetails as $key => $existingProduct) {
			$existing[] = $existingProduct->product_id;
		}

		if(!in_array($productId, $existing)){
			$productDetail = new SupplierProduct();
			$productDetail->product_id = $productId;
			$product = Product::model()->findByPk($productDetail->product_id);
			//$productDetail->product_name = $product->name;
			//var_dump($this->productDetails);
			$this->productDetails[] = $productDetail;
		}
		
	}

	public function addProductDetail()
	{
		$filtered = array();
		$existing = array();
		foreach ($this->productDetails as $key => $existingProduct) {
			$existing[] = $existingProduct->product_id;
		}

		$productCriteria = new CDbCriteria;

		$productCriteria->addSearchCondition('product_master_category_id',$_POST['Supplier']['product_master_category_id'],'and');
		$productCriteria->addSearchCondition('product_sub_master_category_id',$_POST['Supplier']['product_sub_master_category_id']);
		$productCriteria->addSearchCondition('product_sub_category_id',$_POST['Supplier']['product_sub_category_id']);
		$productCriteria->addSearchCondition('production_year',$_POST['Supplier']['production_year']);
		$productCriteria->addSearchCondition('brand_id',$_POST['Supplier']['brand_id']);
		// $productCriteria->addInCondition('id',array(1,2,3,4,5,6,7,8,9,10));

		$filteredProducts = Product::model()->findAll($productCriteria);
		$products = Product::model()->findAll($productCriteria);

		foreach ($filteredProducts as $key => $filteredProduct) {
			$filtered[] = $filteredProduct->id;
		}

		$newProducts = array_diff($filtered, $existing);

		//var_dump($this->productDetails);
		//var_dump($newProducts);

		foreach ($newProducts as $key => $product) {
			$productDetail = new SupplierProduct();
			$productDetail->product_id = $product;
			$this->productDetails[] = $productDetail;
		}
	}

	public function addProductDetailAlt()
	{
		$filtered = array();
		$existing = array();
		foreach ($this->productDetails as $key => $existingProduct) {
			$existing[] = $existingProduct->product_id;
		}

		$productCriteria = new CDbCriteria;
		$productCriteria->addInCondition('id',$_POST['checked_product']);

		$filteredProducts = Product::model()->findAll($productCriteria);
		$products = Product::model()->findAll($productCriteria);

		foreach ($filteredProducts as $key => $filteredProduct) {
			$filtered[] = $filteredProduct->id;
		}

		$newProducts = array_diff($filtered, $existing);

		//var_dump($this->productDetails);
		//var_dump($newProducts);

		foreach ($newProducts as $key => $product) {
			$productDetail = new SupplierProduct();
			$productDetail->product_id = $product;
			$this->productDetails[] = $productDetail;
		}
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

	public function removeBankDetailAt($index)
	{
		array_splice($this->bankDetails, $index, 1);
	}

	public function removePicDetailAt($index)
	{
		array_splice($this->picDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}

	public function removePicPhoneDetailAt($index)
	{
		array_splice($this->picPhoneDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}

	public function removePicMobileDetailAt($index)
	{
		array_splice($this->picMobileDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}

	public function removeProductDetailAt($index)
	{
		array_splice($this->productDetails, $index, 1);
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

		//commmented on 13 Oct 
		if (count($this->bankDetails) > 0)
		{
			foreach ($this->bankDetails as $bankDetail)
			{
				$fields = array('account_no','account_name');
				$valid = $bankDetail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}

		if (count($this->picDetails) > 0)
		{
			foreach ($this->picDetails as $picDetail)
			{
				$fields = array('name','code');
				$valid = $picDetail->validate($fields) && $valid;
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
		if (count($this->phoneDetails) === 0)
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
		//echo $valid;

		$supplier_phones = SupplierPhone::model()->findAllByAttributes(array('supplier_id'=>$this->header->id));
		$phoneId = array();
		foreach($supplier_phones as $supplier_phone)
		{
			$phoneId[]=$supplier_phone->id;
		}
		$new_detail = array();

		$supplier_mobiles = SupplierMobile::model()->findAllByAttributes(array('supplier_id'=>$this->header->id));
		$mobileId = array();
		foreach($supplier_mobiles as $supplier_mobile)
		{
			$mobileId[]= $supplier_mobile->id;
		}
		$new_mobile = array();

		//Commented on 13 Oct
		$supplier_banks = SupplierBank::model()->findAllByAttributes(array('supplier_id'=>$this->header->id));
		$bankId = array();
		foreach($supplier_banks as $supplier_bank)
		{
			$bankId[] = $supplier_bank->id;
		}
		$new_bank = array();

		$supplier_pics = SupplierPic::model()->findAllByAttributes(array('supplier_id'=>$this->header->id));
		$picId = array();
		foreach($supplier_pics as $supplier_pic)
		{
			$picId[] = $supplier_pic->id;
		}
		$new_pic = array();

		$supplier_products = SupplierProduct::model()->findAllByAttributes(array('supplier_id'=>$this->header->id));
		$productId = array();
		foreach($supplier_products as $supplier_product)
		{
			$productId[] = $supplier_product->id;
		}
		$new_product = array();

		//phone
		foreach ($this->phoneDetails as $phoneDetail)
		{
			$phoneDetail->supplier_id = $this->header->id;
			$valid = $phoneDetail->save(false) && $valid;
			$new_detail[] = $phoneDetail->id;
			//echo 'test';
		}

		//mobile
		foreach ($this->mobileDetails as $mobileDetail)
		{
			$mobileDetail->supplier_id = $this->header->id;
			$valid = $mobileDetail->save(false) && $valid;
			$new_mobile[] = $mobileDetail->id;	
		}

		//Bank
		foreach($this->bankDetails as $bankDetail)
		{
			$bankDetail->supplier_id = $this->header->id;
			$valid = $bankDetail->save(false) && $valid;
			$new_bank[] = $bankDetail->id;
		}

		//PIC
		foreach($this->picDetails as $picDetail)
		{
			$picDetail->supplier_id = $this->header->id;
			$picDetail->date = date('Y-m-d');
			$valid = $picDetail->save(false) && $valid;
			$new_pic[] = $picDetail->id;
		}
		//var_dump(CJSON::encode($this->phoneDetails));

		//Product
		foreach($this->productDetails as $productDetail)
		{
			$productDetail->supplier_id = $this->header->id;
			$valid = $productDetail->save(false) && $valid;
			$new_product[] = $productDetail->id;
		}

		//delete phone
		$delete_array = array_diff($phoneId, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			SupplierPhone::model()->deleteAll($criteria);
		}

		//delete mobile
		$delete_mobile = array_diff($mobileId, $new_mobile);
		if($delete_mobile != NULL)
		{
			$mobile_criteria = new CDbCriteria;
			$mobile_criteria->addInCondition('id',$delete_mobile);
			SupplierMobile::model()->deleteAll($mobile_criteria);
		}

		//delete Bank
		$delete_bank = array_diff($bankId,$new_bank);
		if($delete_bank != NULL)
		{
			$bank_criteria = new CDbCriteria;
			$bank_criteria->addInCondition('id',$delete_bank);
			SupplierBank::model()->deleteAll($bank_criteria);
		}

		//Delete PIC
		$delete_pic = array_diff($picId,$new_pic);
		if($delete_pic != NULL)
		{
			$pic_criteria = new CDbCriteria;
			$pic_criteria->addInCondition('id',$delete_pic);
			SupplierPic::model()->deleteAll($pic_criteria);
		}

		//delete Product
		$delete_product = array_diff($productId,$new_product);
		if($delete_product != NULL)
		{
			$product_criteria = new CDbCriteria;
			$product_criteria->addInCondition('id',$delete_product);
			SupplierProduct::model()->deleteAll($product_criteria);
		}

		return $valid;

	}
}
