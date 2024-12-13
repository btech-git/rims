<?php

class Products extends CComponent {

    public $header;
    public $vehicleDetails;
    public $priceDetails;
    public $unitDetails;
    public $productComplementDetails;
    public $productSubstituteDetails;

    /* public $phoneDetails;
      public $mobileDetails;
      public $picDetails; */

    public function __construct($header, array $vehicleDetails, array $priceDetails, array $unitDetails, array $productComplementDetails, array $productSubstituteDetails) {
        $this->header = $header;
        /* $this->phoneDetails = $phoneDetails;
          $this->mobileDetails = $mobileDetails;
          $this->picDetails= $picDetails; */
        $this->vehicleDetails = $vehicleDetails;
        $this->priceDetails = $priceDetails;
        $this->unitDetails = $unitDetails;
        $this->productComplementDetails = $productComplementDetails;
        $this->productSubstituteDetails = $productSubstituteDetails;
    }

    public function addDetail() {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
        $phoneDetail = new CustomerPhone();
        //$detail->mata_uang_id = 1;
        //$detail->unit_price = $price;
        //$detail->transaction_type = $transactionType;
        $this->phoneDetails[] = $phoneDetail;
        //print_r($this->details);
    }

    public function addMobileDetail() {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
        $mobileDetail = new CustomerMobile();
        //$detail->mata_uang_id = 1;
        //$detail->unit_price = $price;
        //$detail->transaction_type = $transactionType;
        $this->mobileDetails[] = $mobileDetail;
        //print_r($this->details);
    }

    public function addPicDetail() {
        $picDetail = new CustomerPic();
        $this->picDetails[] = $picDetail;
    }

    public function addVehicleDetail() {
        $vehicleDetail = new ProductVehicle();
        $this->vehicleDetails[] = $vehicleDetail;
    }

    public function addPriceDetail() {
        $priceDetail = new ProductPrice();
        $this->priceDetails[] = $priceDetail;
    }

    public function addUnitDetail() {
        $unitDetail = new ProductUnit();
        $this->unitDetails[] = $unitDetail;
    }

    public function addProductComplementDetail($productComplementId) {
        $productComplementDetail = new ProductComplement();
        $productComplementDetail->product_complement_id = $productComplementId;
        $productComplementData = Product::model()->findByPk($productComplementDetail->product_complement_id);
        //$complementDetail->complement_name = $productComplementData->name;
        $this->productComplementDetails[] = $productComplementDetail;
    }

    public function addProductSubstituteDetail($productSubstituteId) {
        $productSubstituteDetail = new ProductSubstitute();
        $productSubstituteDetail->product_substitute_id = $productSubstituteId;
        $productSubstituteData = Product::model()->findByPk($productSubstituteDetail->product_substitute_id);
        //$complementDetail->complement_name = $productComplementData->name;
        $this->productSubstituteDetails[] = $productSubstituteDetail;
    }

    /* public function removeDetailAt($index)
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
      } */

    public function removeVehicleDetailAt($index) {
        array_splice($this->vehicleDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function removePriceDetailAt($index) {
        array_splice($this->priceDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function removeUnitDetailAt($index) {
        array_splice($this->unitDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function removeProductComplementDetailAt($index) {
        array_splice($this->productComplementDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function removeProductSubstituteDetailAt($index) {
        array_splice($this->productComplementDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
                //print_r('1');
            } else {
                $dbTransaction->rollback();
                //print_r('2');
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            //print_r($e);
        }

        return $valid;
        //print_r('success');
    }

    public function validate() {
        $valid = $this->header->validate();

        //$valid = $this->validateDetailsCount() && $valid;

        /* if (count($this->phoneDetails) > 0)
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
         */
        if (count($this->vehicleDetails) > 0) {
            foreach ($this->vehicleDetails as $vehicleDetail) {
                $fields = array('plate_number', 'machine_number');
                $valid = $vehicleDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        //print_r($valid);
        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->phoneDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {

        $this->header->minimum_selling_price = $this->minimumSellingPrice;
        $this->header->recommended_selling_price = $this->recommendedSellingPrice;
        $valid = $this->header->save();
        //echo $valid;
        //save battery specification
        if ($this->header->product_sub_category_id == 1) {
            if (isset($_POST['ProductSpecificationBattery'])) {
                $productSpecificationBattery = ProductSpecificationBattery::model()->findByAttributes(array('product_id' => $this->header->id));
                if ($productSpecificationBattery == NULL) {
                    $productSpecificationBattery = new ProductSpecificationBattery;
                }
                $productSpecificationBattery->attributes = $_POST['ProductSpecificationBattery'];
                $productSpecificationBattery->product_id = $this->header->id;
                $valid = $productSpecificationBattery->save(false) && $valid;

                ProductSpecificationOil::model()->deleteAll("`product_id` = :product_id", array(':product_id' => $this->header->id));
                ProductSpecificationTire::model()->deleteAll("`product_id` = :product_id", array(':product_id' => $this->header->id));
            }
        }


        //save oil specification
        if ($this->header->product_sub_category_id == 2) {
            if (isset($_POST['ProductSpecificationOil'])) {
                $productSpecificationOil = ProductSpecificationOil::model()->findByAttributes(array('product_id' => $this->header->id));
                if ($productSpecificationOil == NULL) {
                    $productSpecificationOil = new ProductSpecificationOil;
                }
                $productSpecificationOil->attributes = $_POST['ProductSpecificationOil'];
                $productSpecificationOil->product_id = $this->header->id;
                $valid = $productSpecificationOil->save(false) && $valid;

                ProductSpecificationBattery::model()->deleteAll("`product_id` = :product_id", array(':product_id' => $this->header->id));
                ProductSpecificationTire::model()->deleteAll("`product_id` = :product_id", array(':product_id' => $this->header->id));
            }
        }

        //save tire specification
        if ($this->header->product_sub_category_id == 3) {
            if (isset($_POST['ProductSpecificationTire'])) {
                $productSpecificationTire = ProductSpecificationTire::model()->findByAttributes(array('product_id' => $this->header->id));
                if ($productSpecificationTire == NULL) {
                    $productSpecificationTire = new ProductSpecificationTire;
                }
                $productSpecificationTire->attributes = $_POST['ProductSpecificationTire'];
                $productSpecificationTire->product_id = $this->header->id;
                $valid = $productSpecificationTire->save(false) && $valid;

                ProductSpecificationBattery::model()->deleteAll("`product_id` = :product_id", array(':product_id' => $this->header->id));
                ProductSpecificationOil::model()->deleteAll("`product_id` = :product_id", array(':product_id' => $this->header->id));
            }
        }

        $product_vehicles = ProductVehicle::model()->findAllByAttributes(array('product_id' => $this->header->id));
        $vehicleId = array();
        foreach ($product_vehicles as $product_vehicle) {
            $vehicleId[] = $product_vehicle->id;
        }
        $new_vehicle = array();

        //vehicle
        foreach ($this->vehicleDetails as $vehicleDetail) {
            $vehicleDetail->product_id = $this->header->id;
            $valid = $vehicleDetail->save(false) && $valid;
            $new_vehicle[] = $vehicleDetail->id;
        }

        //delete vehicle
        $delete_vehicle = array_diff($vehicleId, $new_vehicle);
        if ($delete_vehicle != NULL) {
            $vehicle_criteria = new CDbCriteria;
            $vehicle_criteria->addInCondition('id', $delete_vehicle);
            ProductVehicle::model()->deleteAll($vehicle_criteria);
        }

        //Product Prices
        $product_prices = ProductPrice::model()->findAllByAttributes(array('product_id' => $this->header->id));
        $priceId = array();
        foreach ($product_prices as $product_price) {
            $priceId[] = $product_price->id;
        }
        $new_price = array();

        foreach ($this->priceDetails as $priceDetail) {
            $priceDetail->product_id = $this->header->id;
            $valid = $priceDetail->save(false) && $valid;
            $new_price[] = $priceDetail->id;
        }

        //Product Units
        $product_units = ProductUnit::model()->findAllByAttributes(array('product_id' => $this->header->id));
        $priceId = array();
        foreach ($product_units as $product_unit) {
            $priceId[] = $product_unit->id;
        }
        $new_unit = array();

        foreach ($this->unitDetails as $unitDetail) {
            $unitDetail->product_id = $this->header->id;
            $valid = $unitDetail->save(false) && $valid;
            $new_unit[] = $unitDetail->id;
        }

        //delete vehicle
        $delete_price = array_diff($priceId, $new_price);
        if ($delete_price != NULL) {
            $price_criteria = new CDbCriteria;
            $price_criteria->addInCondition('id', $delete_price);
            ProductPrice::model()->deleteAll($price_criteria);
        }

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new MasterLog();
        $transactionLog->name = $this->header->name;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $this->header->tableName();
        $transactionLog->table_id = $this->header->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $this->header->attributes;
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function getRetailPriceTax() {
        return $this->header->retail_price * 10 / 100;
    }

    public function getRetailPriceAfterTax() {
        return $this->header->retail_price + $this->retailPriceTax;
    }

    public function getRecommendedSellingPrice() {
        $marginAmount = ($this->header->margin_type == 1) ? $this->retailPriceAfterTax * $this->header->margin_amount / 100 : $this->header->margin_amount;

        return $this->retailPriceAfterTax + $marginAmount;
    }

    public function getMinimumSellingPrice() {
        $marginAmount = ($this->header->margin_type == 1) ? $this->header->retail_price * $this->header->margin_amount / 100 : $this->header->margin_amount;

        return $this->header->retail_price + $marginAmount;
    }

}
