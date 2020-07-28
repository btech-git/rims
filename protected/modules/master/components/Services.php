<?php

class Services extends CComponent {

    public $header;
    public $equipmentDetails;
    public $priceDetails;
    public $complementDetails;
    public $productDetails;

    public function __construct($header, array $equipmentDetails, array $priceDetails, array $complementDetails, array $productDetails) {
        $this->header = $header;
        $this->equipmentDetails = $equipmentDetails;
        $this->priceDetails = $priceDetails;
        $this->complementDetails = $complementDetails;
        $this->productDetails = $productDetails;
    }

    public function addDetail($equipmentId) {
        $equipmentDetail = new ServiceEquipment();
        $equipmentDetail->equipment_id = $equipmentId;
        $equipment = Equipments::model()->findByPk($equipmentId);
        $equipmentDetail->equipment_name = $equipment->name;
        $this->equipmentDetails[] = $equipmentDetail;
    }

    public function removeDetailAt($index) {
        array_splice($this->equipmentDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function addPriceDetail() {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
        $priceDetail = new ServicePricelist();
        $defaultvalue = GeneralStandardValue::model()->find();
        $standardRate = GeneralStandardFr::model()->find();
        $priceDetail->difficulty = $defaultvalue->difficulty;
        $priceDetail->difficulty_value = $defaultvalue->difficulty_value;
        $priceDetail->regular = $defaultvalue->regular;
        $priceDetail->luxury = $defaultvalue->luxury;
        $priceDetail->luxury_value = $defaultvalue->luxury_value;
        $priceDetail->luxury_calc = $defaultvalue->luxury_calc;
        $priceDetail->flat_rate_hour = $defaultvalue->flat_rate_hour;
        $priceDetail->standard_flat_rate_per_hour = $standardRate->flat_rate;
        $count = $priceDetail->difficulty_value * $priceDetail->luxury_calc * $priceDetail->flat_rate_hour * $priceDetail->standard_flat_rate_per_hour;
        $priceDetail->price = $count;

        $this->priceDetails[] = $priceDetail;
        //print_r($this->details);
    }

    public function removePriceDetailAt($index) {
        array_splice($this->priceDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function addComplementDetail($complementId) {

        $complementDetail = new ServiceComplement();

        $complementDetail->complement_id = $complementId;
        $complementData = Service::model()->findByPk($complementDetail->complement_id);
        $complementDetail->complement_name = $complementData->name;
        $this->complementDetails[] = $complementDetail;
        //print_r($this->details);
    }

    public function removeComplementDetailAt($index) {
        array_splice($this->complementDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function addProduct($productId) {

        $exist = FALSE;
        $product = Product::model()->findByPk($productId);

        if ($product != null) {
            foreach ($this->productDetails as $detail) {
                if ($detail->product_id == $product->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new ServiceProduct;
                $detail->product_id = $productId;
                $detail->unit_id = $product->unit_id;
                $this->productDetails[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Invoice tidak ada di dalam detail');
    }

    public function removeProductDetailAt($index) {
        array_splice($this->productDetails, $index, 1);
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->equipmentDetails) > 0) {
            foreach ($this->equipmentDetails as $equipmentDetail) {
                $fields = array('equipment_id');
                $valid = $equipmentDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }
        
        if (count($this->priceDetails) > 0) {
            foreach ($this->priceDetails as $priceDetail) {

                $fields = array('car_make_id', 'car_model_id');
                $valid = $priceDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->complementDetails) > 0) {
            foreach ($this->complementDetails as $complementDetail) {

                $fields = array('complement_id');
                $valid = $complementDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->productDetails) > 0) {
            foreach ($this->productDetails as $productDetail) {

                $fields = array('product_id', 'quantity', 'unit_id');
                $valid = $productDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        
        if (count($this->equipmentDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
        $isNewRecord = $this->header->isNewRecord;
        $valid = $this->header->save();

        $service_equipments = ServiceEquipment::model()->findAllByAttributes(array('service_id' => $this->header->id));
        $equipment_id = array();
        
        foreach ($service_equipments as $service_equipment) {
            $equipment_id[] = $service_equipment->id;
        }
        
        $new_detail = array();

        //equipment
        foreach ($this->equipmentDetails as $equipmentDetail) {
            $equipmentDetail->service_id = $this->header->id;
            $valid = $equipmentDetail->save(false) && $valid;
            $new_detail[] = $equipmentDetail->id;
        }

        //delete equipment
        $delete_array = array_diff($equipment_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            ServiceEquipment::model()->deleteAll($criteria);
        }

        //Service Pricelist
        $service_pricelists = ServicePricelist::model()->findAllByAttributes(array('service_id' => $this->header->id));
        $price_id = array();
        
        foreach ($service_pricelists as $service_pricelist) {
            $price_id[] = $service_pricelist->id;
        }
        
        $new_detail_price = array();

        //pricelist
        foreach ($this->priceDetails as $priceDetail) {
            $priceDetail->service_id = $this->header->id;

            $valid = $priceDetail->save(false) && $valid;
            $new_detail_price[] = $priceDetail->id;
        }

        //delete pricelist
        $delete_array_price = array_diff($price_id, $new_detail_price);
        if ($delete_array_price != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array_price);
            ServicePricelist::model()->deleteAll($criteria);
        }

        //Service complement
        $service_complements = ServiceComplement::model()->findAllByAttributes(array('service_id' => $this->header->id));
        $complement_id = array();
        
        foreach ($service_complements as $service_complement) {
            $complement_id[] = $service_complement->id;
        }
        
        $new_detail_complement = array();

        //complement
        foreach ($this->complementDetails as $complementDetail) {
            $complementDetail->service_id = $this->header->id;

            $valid = $complementDetail->save(false) && $valid;
            $new_detail_complement[] = $complementDetail->id;
        }

        //delete complement
        $delete_array_complement = array_diff($complement_id, $new_detail_complement);
        if ($delete_array_complement != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array_complement);
            ServiceComplement::model()->deleteAll($criteria);
        }

//        $service_materials = ServiceMaterial::model()->findAllByAttributes(array('service_id' => $this->header->id));
//        $product_id = array();
//        foreach ($service_materials as $service_material) {
//            $product_id[] = $service_material->id;
//        }
//        $new_detail_material = array();
//
//        //equipment
//        foreach ($this->materialDetails as $materialDetail) {
//            $materialDetail->service_id = $this->header->id;
//            $valid = $materialDetail->save(false) && $valid;
//            $new_detail_material[] = $materialDetail->id;
//        }
//
//        //delete equipment
//        $delete_array = array_diff($product_id, $new_detail_material);
//        if ($delete_array != NULL) {
//            $criteria = new CDbCriteria;
//            $criteria->addInCondition('id', $delete_array);
//            ServiceMaterial::model()->deleteAll($criteria);
//        }

        foreach ($this->productDetails as $productDetail) {
            $productDetail->service_id = $this->header->id;
                
            $valid = $valid && $productDetail->save(false);
        }

        return $valid;
    }
}