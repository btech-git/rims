<?php

class RegistrationTransactions extends CComponent {

    public $header;
    public $quickServiceDetails;
    public $serviceDetails;
    public $productDetails;
    public $damageDetails;
    public $insuranceDetails;

    public function __construct($header, array $quickServiceDetails, array $serviceDetails, array $productDetails, array $damageDetails, array $insuranceDetails) {
        $this->header = $header;
        $this->quickServiceDetails = $quickServiceDetails;
        $this->serviceDetails = $serviceDetails;
        $this->productDetails = $productDetails;
        $this->damageDetails = $damageDetails;
        $this->insuranceDetails = $insuranceDetails;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $registrationTransaction = RegistrationTransaction::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(
                ':cn_year' => $currentYear, 
                ':cn_month' => $arr[$currentMonth], 
                ':branch_id' => $branchId
            ),
        ));

        if ($registrationTransaction == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $registrationTransaction->branch->code;
            $this->header->transaction_number = $registrationTransaction->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, RegistrationTransaction::CONSTANT, $currentMonth, $currentYear);
    }

    public function addQuickServiceDetail($quickServiceId) {
        $count = count($this->quickServiceDetails);
        if ($count < 3) {
            $quickServiceDetail = new RegistrationQuickService();
            $quickServiceDetail->quick_service_id = $quickServiceId;
            $quickService = QuickService::model()->findByPk($quickServiceId);
            $quickServiceDetail->quick_service_code = $quickService->code;
            $quickServiceDetail->price = $quickService->rate;
            $quickServiceDetail->hour = $quickService->hour;
            $this->quickServiceDetails[] = $quickServiceDetail;
        }
    }

    public function removeQuickServiceAll() {
        $this->quickServiceDetails = array();
    }

    public function removeQuickServiceDetailAt($index) {
        array_splice($this->quickServiceDetails, $index, 1);
    }

    public function addServiceDetail($serviceId, $customerId, $custType, $vehicleId, $repair) {

        $serviceArrays = array();
        $serviceArrays = $this->serviceDetails;
        $checkService = array();
        /* $brServiceCriteria = new CDbCriteria;
          $brServiceCriteria->condition .= " code LIKE 'BR-BW-%'";
          //$brServiceCriteria->limit = 10;
          $services = Service::model()->findAll($brServiceCriteria);
         */

        foreach ($serviceArrays as $serviceArray) {
            $checkService[] = $serviceArray->service_id;
        }
        
        if (in_array($serviceId, $checkService)) {
            echo "Please select other Service, this is already added";
        } else {
            $this->getService($serviceId, $customerId, $custType, $vehicleId, $repair);
        }
    }

    public function getService($serviceId, $customerId, $custType, $vehicleId) {
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $serviceDetail = new RegistrationService();
        $serviceDetail->service_id = $serviceId;
        $service = Service::model()->findByPk($serviceId);
        
        if ($custType == "Individual") {
            $serviceCarSubDetail = ServicePricelist::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id, 'car_model_id' => $vehicle->car_model_id, 'car_sub_detail_id' => $vehicle->car_sub_model_id));
            if (count($serviceCarSubDetail) > 0) {
                $serviceDetail->price = $serviceCarSubDetail->price;
                $serviceDetail->total_price = $serviceCarSubDetail->price;
            } else {
                $serviceCarModel = ServicePricelist::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id, 'car_model_id' => $vehicle->car_model_id));
                if (count($serviceCarModel) > 0) {
                    $serviceDetail->price = $serviceCarModel->price;
                    $serviceDetail->total_price = $serviceCarModel->price;
                } else {
                    $serviceCarMake = ServicePricelist::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id));
                    if (count($serviceCarMake) > 0) {
                        $serviceDetail->price = $serviceCarMake->price;
                        $serviceDetail->total_price = $serviceCarMake->price;
                    } else {
                        if ($service->common_price != 0.00) {
                            $serviceDetail->price = $service->common_price;
                            $serviceDetail->total_price = $service->common_price;
                        } else {
                            if ($service->difficulty_value == "" && $service->luxury_value == "" && $service->flat_rate_hour == "" && $service->standard_rate_per_hour == "") {
                                $generalVal = GeneralStandardValue::model()->findByPk(1);
                                $generalFR = GeneralStandardFr::model()->findByPk(1);
                                $diff = $generalVal->difficulty_value;
                                $lux = $generalVal->luxury_value;
                                $hour = $generalVal->flat_rate_hour;
                                $rate = $generalFR->flat_rate;
                            } else {
                                $diff = $service->difficulty_value;
                                $lux = $service->luxury_value;
                                $hour = $service->flat_rate_hour;
                                $rate = $service->standard_rate_per_hour;
                            }

                            $priceTotal = $diff * $lux * $hour * $rate;
                            $serviceDetail->price = $priceTotal;
                            $serviceDetail->total_price = $priceTotal;
                        }
                    }//else servicecarMake
                }//else count servicecarmodel
            }//else count servicecarSubDetail
        } else {
            $custServiceSubDetail = CustomerServiceRate::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id, 'car_model_id' => $vehicle->car_model_id, 'car_sub_model_id' => $vehicle->car_sub_model_id, 'customer_id' => $customerId));
            if (count($custServiceSubDetail) > 0) {
                $serviceDetail->price = $custServiceSubDetail->rate;
                $serviceDetail->total_price = $custServiceSubDetail->rate;
            } else {
                $custServiceCarModel = CustomerServiceRate::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id, 'car_model_id' => $vehicle->car_model_id, 'customer_id' => $customerId));
                if (count($custServiceCarModel) > 0) {
                    $serviceDetail->price = $custServiceCarModel->rate;
                    $serviceDetail->total_price = $custServiceCarModel->rate;
                } else {
                    $custServiceCarMake = CustomerServiceRate::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id, 'customer_id' => $customerId));
                    if (count($custServiceCarMake) > 0) {
                        $serviceDetail->price = $custServiceCarMake->rate;
                        $serviceDetail->total_price = $custServiceCarMake->rate;
                    } else {
                        $customerData = Customer::model()->findByPk($customerId);
                        if ($service->difficulty_value == "" && $service->luxury_value == "" && $service->flat_rate_hour == "") {
                            $generalVal = GeneralStandardValue::model()->findByPk(1);
                            $diff = $generalVal->difficulty_value;
                            $lux = $generalVal->luxury_value;
                            $hour = $generalVal->flat_rate_hour;
                        } else {
                            $diff = $service->difficulty_value;
                            $lux = $service->luxury_value;
                            $hour = $service->flat_rate_hour;
                        }
                        
                        if ($customerData->flat_rate != null) {
                            $priceTotal = $diff * $lux * $hour * $customerData->flat_rate;
                        } else {
                            $generalFR = GeneralStandardFr::model()->findByPk(1);
                            $priceTotal = $diff * $lux * $hour * $generalFR->flat_rate;
                        }
                        
                        $serviceDetail->price = $priceTotal;
                        $serviceDetail->total_price = $priceTotal;
                    }//else servicecarMake
                }//else count servicecarmodel
            }//else count servicecarSubDetail
        }//end else

        $serviceDetail->hour = $service->flat_rate_hour;
        $serviceDetail->claim = "NO";

        $this->serviceDetails[] = $serviceDetail;
    }

    public function addServiceInsuranceDetail($serviceId, $insuranceId, $damageType, $repair) {

        $serviceArrays = array();
        $serviceArrays = $this->serviceDetails;
        $checkService = array();
        $serviceDetail = new RegistrationService();
        
        foreach ($serviceArrays as $serviceArray) {
            $checkService[] = $serviceArray->service_id;
        }
        
        if (in_array($serviceId, $checkService)) {
            echo "Please select other Service, this is already added";
        } else {
            $serviceDetail->service_id = $serviceId;
            $service = Service::model()->findByPk($serviceId);
            $insuranceCompany = InsuranceCompany::model()->findByPk($insuranceId);
            $insurancePrice = InsuranceCompanyPricelist::model()->findByAttributes(array('service_id' => $service->id, 'insurance_company_id' => $insuranceId, 'damage_type' => $damageType));
            if (count($insurancePrice) > 0) {
                $serviceDetail->price = $insurancePrice->price;
                $serviceDetail->total_price = $serviceDetail->price;
            } else {
                if ($service->difficulty_value == "" && $service->luxury_value == "" && $service->flat_rate_hour == "") {
                    $generalVal = GeneralStandardValue::model()->findByPk(1);
                    $diff = $generalVal->difficulty_value;
                    $lux = $generalVal->luxury_value;
                    $hour = $generalVal->flat_rate_hour;
                } else {
                    $diff = $service->difficulty_value;
                    $lux = $service->luxury_value;
                    $hour = $service->flat_rate_hour;
                }
                $generalFR = GeneralStandardFr::model()->findByPk(1);
                $serviceDetail->price = $diff * $lux * $hour * $generalFR->flat_rate;
                $serviceDetail->total_price = $serviceDetail->price;
            }

            $serviceDetail->hour = $service->flat_rate_hour;
            if ($this->header->insurance_company_id == "") {
                $serviceDetail->claim = "NO";
            } else {
                $serviceDetail->claim = "YES";
            }

            $this->serviceDetails[] = $serviceDetail;
        }
    }

    //public function loadServiceDetail()
    public function removeServiceDetailAt($index) {
        array_splice($this->serviceDetails, $index, 1);
    }

    public function removeServiceDetailAll() {
        $this->serviceDetails = array();
    }

    public function addProductDetail($productId) {
        $productArrays = array();
        $productArrays = $this->productDetails;
        $checkProduct = array();
        
        foreach ($productArrays as $productArray) {
            $checkProduct[] = $productArray->product_id;
        }
        
        if (in_array($productId, $checkProduct)) {
            echo "Please select other Product, this is already added";
        } else {
            $productDetail = new RegistrationProduct();
            $productDetail->product_id = $productId;
            $product = Product::model()->findByPk($productId);
            $productDetail->product_name = $product->name;
            $productDetail->retail_price = $product->retail_price;
            $productDetail->recommended_selling_price = $product->recommended_selling_price;
            $productDetail->sale_price = $product->retail_price;
            $this->productDetails[] = $productDetail;
        }
    }

    public function loadProductDetail($productId) {
        $productArrays = array();
        $productArrays = $this->productDetails;
        $checkProduct = array();
        
        foreach ($productArrays as $productArray) {
            $checkProduct[] = $productArray->product_id;
        }
        
        if (in_array($productId, $checkProduct)) {
            echo "Please select other Product, this is already added";
        } else {
            $productDetail = new RegistrationProduct();
            $productDetail->product_id = $productId;
            $product = Product::model()->findByPk($productId);
            $productDetail->product_name = $product->name;
            $productDetail->retail_price = $product->retail_price;
            $productDetail->hpp = $product->hpp;
            $productDetail->sale_price = $product->recommended_selling_price;
            $this->productDetails[] = $productDetail;
        }
    }

    public function removeProductDetailAt($index) {
        array_splice($this->productDetails, $index, 1);
    }

    public function addDamageDetail($serviceId) {
        $damageDetail = new RegistrationDamage();
        $service = Service::model()->findByPk($serviceId);
        $serviceArrays = array();
        $serviceArrays = $this->damageDetails;
        $checkService = array();
        $brServices = array();

        $serviceType = ServiceType::model()->findByAttributes(array('code' => 'BR'));
        $serviceCategory = ServiceCategory::model()->findByAttributes(array('code' => 'BW', 'service_type_id' => $serviceType->id));
        $services = Service::model()->findAllByAttributes(array('service_category_id' => $serviceCategory->id));
        foreach ($services as $i => $bodyRepairService) {
            if ($i == 10)
                break;
            $brServices[] = $bodyRepairService->id;
        }

        foreach ($serviceArrays as $serviceArray) {
            $checkService[] = $serviceArray->service_id;
        }
        if (in_array($serviceId, $checkService)) {
            echo "Please select other Service, this is already added";
        } else {

            if (in_array($serviceId, $brServices)) {
                echo "Repair Type : Body Repair; this services will be added automatically when choosing BR as repair type.";
            } else {
                $damageDetail->service_id = $service->id;
                $damageDetail->service_name = $service->name;
                $damageDetail->hour = $service->flat_rate_hour;
                $this->damageDetails[] = $damageDetail;
            }//else if in_array
        }
    }

    public function removeDamageDetailAt($index) {
        array_splice($this->damageDetails, $index, 1);
    }

    public function removeDamageDetailAll() {
        $this->damageDetails = array();
    }

    public function addQsServiceDetail($qsId) {

        $qsData = QuickService::model()->findByPk($qsId);
        $qsDetails = QuickServiceDetail::model()->findAllByAttributes(array('quick_service_id' => $qsId));
        foreach ($qsDetails as $key => $qsDetail) {
            $serviceDetail = new RegistrationService();
            $serviceDetail->service_id = $qsDetail->service_id;
            $serviceDetail->is_quick_service = 1;
            $serviceDetail->hour = $qsDetail->hour;
            $serviceDetail->claim = 'NO';
            $serviceDetail->price = $qsDetail->final_price;
            $this->serviceDetails[] = $serviceDetail;
        }
    }

    public function addInsuranceDetail($insuranceCompany) {

        $this->insuranceDetails = array();
        $insuranceDetail = new RegistrationInsuranceData();
        $insuranceDetail->insurance_company_id = $insuranceCompany;
        $this->insuranceDetails[] = $insuranceDetail;
    }

    public function removeInsuranceAll() {
        $this->insuranceDetails = array();
    }

    public function removeInsuranceDetailAt($index) {
        array_splice($this->insuranceDetails, $index, 1);
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

        if (count($this->quickServiceDetails) > 0) {
            foreach ($this->quickServiceDetails as $detail) {

                $fields = array('price');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }
        if (count($this->productDetails) > 0) {
            foreach ($this->productDetails as $productDetail) {

                $fields = array('quantity');
                $valid = $productDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }
        if (count($this->serviceDetails) > 0) {
            foreach ($this->productDetails as $productDetail) {

                $fields = array('quantity');
                $valid = $productDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

//    public function validateDetailsCount() {
//        $valid = true;
//        if (count($this->serviceDetails) === 0) {
//            $valid = false;
//            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
//        }
//
//        return $valid;
//    }

    public function flush() {
        $isNewRecord = $this->header->isNewRecord;
        if ($isNewRecord)
            $this->header->status = 'Registration';
        else
            $this->header->status = 'Update Registration';

        $this->header->total_quickservice = $this->totalQuickServiceQuantity;
        $this->header->total_quickservice_price = $this->subTotalQuickService;
        $this->header->total_service = $this->totalQuantityService;
        $this->header->subtotal_service = $this->subTotalService;
        $this->header->discount_service = $this->totalDiscountService;
        $this->header->total_service_price = $this->grandTotalService;
        $this->header->total_product = $this->totalQuantityProduct;
        $this->header->subtotal_product = $this->subTotalProduct;
        $this->header->discount_product = $this->totalDiscountProduct;
        $this->header->total_product_price = $this->grandTotalProduct;
        $this->header->grand_total = $this->grandTotalTransaction;
        $this->header->subtotal = $this->subTotalTransaction;
        $this->header->ppn_price = $this->taxItemAmount;
        $this->header->pph_price = $this->taxServiceAmount;

        $valid = $this->header->save();

        $bongkar = $sparepart = $ketok_las = $dempul = $epoxy = $cat = $pasang = $poles = $cuci = $finishing = 0;

        $quickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
        $detail_id = array();
        foreach ($quickServices as $quickService) {
            $detail_id[] = $quickService->id;
        }
        $new_detail = array();

        //save request detail quick service
        foreach ($this->quickServiceDetails as $quickServiceDetail) {
            $quickServiceDetail->registration_transaction_id = $this->header->id;

            $valid = $quickServiceDetail->save(false) && $valid;
            $new_detail[] = $quickServiceDetail->id;
        }

        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            RegistrationQuickService::model()->deleteAll($criteria);
        }

        //save Service
        $criteria = new CDbCriteria;
        $criteria->condition = "registration_transaction_id =" . $this->header->id . " AND is_body_repair = 0";
        $services = RegistrationService::model()->findAll($criteria);
        $service_id = array();
        foreach ($services as $service) {
            $service_id[] = $service->id;
        }
        $new_service = array();

        //save request detail
        foreach ($this->serviceDetails as $serviceDetail) {
            $serviceDetail->registration_transaction_id = $this->header->id;
            $serviceDetail->total_price = $serviceDetail->totalAmount;
            $valid = $serviceDetail->save(false) && $valid;

            $new_service[] = $serviceDetail->id;
            if ($isNewRecord) {
                if ($this->header->repair_type == 'BR') {
                    $serviceDetail->status = 'Finished';
                } else {
                    $registrationRealization = new RegistrationRealizationProcess();
                    $registrationRealization->registration_transaction_id = $this->header->id;
                    $registrationRealization->name = $serviceDetail->service->name;
                    $registrationRealization->service_id = $serviceDetail->service_id;

                    $registrationRealization->detail = 'Pending';
                    $registrationRealization->save();
                }
            }
        }
        
        $damages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
        $damage_id = array();
        foreach ($damages as $damage) {
            $damage_id[] = $damage->id;
        }
        $new_damage = array();

        foreach ($this->damageDetails as $damageDetail) {
            $damageDetail->registration_transaction_id = $this->header->id;

            $valid = $damageDetail->save(false) && $valid;
            $this->saveMaterial($damageDetail->registration_transaction_id, $damageDetail->service_id, $damageDetail->damage_type);
            $bongkar += $damageDetail->service->bongkar;
            $sparepart += $damageDetail->service->sparepart;
            $ketok_las += $damageDetail->service->ketok_las;
            $dempul += $damageDetail->service->dempul;
            $epoxy += $damageDetail->service->epoxy;
            $cat += $damageDetail->service->cat;
            $pasang += $damageDetail->service->pasang;
            $poles += $damageDetail->service->poles;
            $cuci += $damageDetail->service->cuci;
            $finishing += $damageDetail->service->finishing;

            $new_damage[] = $damageDetail->id;
        }
        
        //delete 
        $delete_damage_array = array_diff($damage_id, $new_damage);
        if ($delete_damage_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_damage_array);
            RegistrationDamage::model()->deleteAll($criteria);
        }
        if ($this->header->repair_type == 'BR') {
            $real = RegistrationRealizationProcess::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
            if (count($real) == 0)
                $this->bodyRepair($bongkar, $sparepart, $ketok_las, $dempul, $epoxy, $cat, $pasang, $poles, $cuci, $finishing);
            //print_r($real);
        }
        else {
            $realData = RegistrationRealizationProcess::model()->findByAttributes(array('registration_transaction_id' => $this->header->id, 'name' => 'Registration'));
            if (count($realData) == 0) {
                //print_r("testGR");
                $real = new RegistrationRealizationProcess();
                $real->registration_transaction_id = $this->header->id;
                $real->name = 'Registration';
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Registration';
                $real->save();
            }
        }
        if ($isNewRecord) {
            $registrationRealization = new RegistrationRealizationProcess();
            $registrationRealization->registration_transaction_id = $this->header->id;
            $registrationRealization->name = 'Vehicle Inspection';

            $registrationRealization->detail = 'No';
            $registrationRealization->save();
        }

        //delete 
        $delete_service_array = array_diff($service_id, $new_service);
        if ($delete_service_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_service_array);
            RegistrationService::model()->deleteAll($criteria);
        }
        
        //save Product
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
        $product_id = array();
        foreach ($products as $product) {
            $product_id[] = $product->id;
        }
        $new_product = array();

        //save request detail
        foreach ($this->productDetails as $productDetail) {
            if ($productDetail->quantity === 0)
                continue;
            
            $productDetail->registration_transaction_id = $this->header->id;
            $productDetail->total_price = $productDetail->totalAmountProduct;

            $valid = $productDetail->save(false) && $valid;
            $new_product[] = $productDetail->id;
            //echo 'test';
        }


        //delete 
        $delete_product_array = array_diff($product_id, $new_product);
        if ($delete_product_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_product_array);
            RegistrationProduct::model()->deleteAll($criteria);
        }

        //save Damage
        //save Insurance
        $insurances = RegistrationInsuranceData::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
        $insurance_id = array();
        foreach ($insurances as $insurance) {
            $insurance_id[] = $insurance->id;
        }
        $new_insurance = array();

        foreach ($this->insuranceDetails as $insuranceDetail) {

            $insuranceDetail->registration_transaction_id = $this->header->id;
            $valid = $insuranceDetail->save(false) && $valid;
            $new_insurance[] = $insuranceDetail->id;
        }


        //delete 
        $delete_insurance_array = array_diff($insurance_id, $new_insurance);
        if ($delete_insurance_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_insurance_array);
            RegistrationInsuranceData::model()->deleteAll($criteria);
        }

        return $valid;
    }

    public function saveMaterial($headerId, $serviceId, $damage) {
        $materials = ServiceMaterial::model()->findAllByAttributes(array('service_id' => $serviceId));
        foreach ($materials as $key => $material) {
            $regProduct = new RegistrationProduct();
            $regProduct->registration_transaction_id = $headerId;
            $regProduct->product_id = $material->product_id;
            $regProduct->is_material = 1;
            if ($damage == 'Easy')
                $regProduct->quantity = $material->easy;
            elseif ($damage == 'Medium') {
                $regProduct->quantity = $material->medium;
            } else {
                $regProduct->quantity = $material->hard;
            }
            $regProduct->save(false);
        }
    }

    public function bodyRepair($bongkar, $sparepart, $ketok_las, $dempul, $epoxy, $cat, $pasang, $poles, $cuci, $finishing) {
        $img = new RegistrationRealizationProcess();
        $img->name = 'Image';
        $img->registration_transaction_id = $this->header->id;
        $img->save(false);

        $doc = new RegistrationRealizationProcess();
        $doc->name = 'Document';
        $doc->registration_transaction_id = $this->header->id;
        $doc->save(false);

        $spk = new RegistrationRealizationProcess();
        $spk->name = 'SPK';
        $spk->registration_transaction_id = $this->header->id;
        $spk->save(false);

        $wo = new RegistrationRealizationProcess();
        $wo->name = 'Work Order';
        $wo->registration_transaction_id = $this->header->id;
        $wo->save(false);

        /* $bkr = new RegistrationRealizationProcess();
          $bkr->name = 'Bongkar';
          $bkr->registration_transaction_id = $this->header->id;
          $bkr->detail= 'Pending';
          $bkr->save(false);

          $sp = new RegistrationRealizationProcess();
          $sp->name = 'Sparepart';
          $sp->registration_transaction_id = $this->header->id;
          $sp->detail= 'Pending';
          $sp->save(false);

          $ketok = new RegistrationRealizationProcess();
          $ketok->name = 'Ketok/Las';
          $ketok->registration_transaction_id = $this->header->id;
          $ketok->detail= 'Pending';
          $ketok->save(false);

          $dempul = new RegistrationRealizationProcess();
          $dempul->name = 'Dempul';
          $dempul->registration_transaction_id = $this->header->id;
          $dempul->detail= 'Pending';
          $dempul->save(false);

          $epoxy = new RegistrationRealizationProcess();
          $epoxy->name = 'Epoxy';
          $epoxy->registration_transaction_id = $this->header->id;
          $epoxy->detail= 'Pending';
          $epoxy->save(false);

          $cat = new RegistrationRealizationProcess();
          $cat->name = 'Cat';
          $cat->registration_transaction_id = $this->header->id;
          $cat->detail= 'Pending';
          $cat->save(false);

          $pasang = new RegistrationRealizationProcess();
          $pasang->name = 'Pasang';
          $pasang->registration_transaction_id = $this->header->id;
          $pasang->detail= 'Pending';
          $pasang->save(false);

          $poles = new RegistrationRealizationProcess();
          $poles->name = 'Poles';
          $poles->registration_transaction_id = $this->header->id;
          $poles->detail= 'Pending';
          $poles->save(false); */

        $qc = new RegistrationRealizationProcess();
        $qc->name = 'Quality Control';
        $qc->registration_transaction_id = $this->header->id;
        $qc->save(false);

        /* $cuci = new RegistrationRealizationProcess();
          $cuci->name = 'Cuci';
          $cuci->registration_transaction_id = $this->header->id;
          $cuci->detail= 'Pending';
          $cuci->save(false);

          $finishing = new RegistrationRealizationProcess();
          $finishing->name = 'Finishing';
          $finishing->registration_transaction_id = $this->header->id;
          $finishing->detail= 'Pending';
          $finishing->save(false); */



        //Add Additional 
        $serviceType = ServiceType::model()->findByAttributes(array('code' => 'BR'));
        $serviceCategory = ServiceCategory::model()->findByAttributes(array('code' => 'P', 'service_type_id' => $serviceType->id));
        $services = Service::model()->findAllByAttributes(array('service_category_id' => $serviceCategory->id));
        foreach ($services as $key => $service) {
            if ($key == 10)
                break;
            $newRegService = new RegistrationService();
            $newRegService->registration_transaction_id = $this->header->id;
            $newRegService->service_id = $service->id;
            $newRegService->claim = 'NO';
            $newRegService->is_body_repair = 1;
            if ($service->code == 'BR-P-1') {
                $newRegService->hour = $bongkar;
            } else if ($service->code == 'BR-P-2') {
                $newRegService->hour = $sparepart;
            } else if ($service->code == 'BR-P-3') {
                $newRegService->hour = $ketok_las;
            } else if ($service->code == 'BR-P-4') {
                $newRegService->hour = $dempul;
            } else if ($service->code == 'BR-P-5') {
                $newRegService->hour = $epoxy;
            } else if ($service->code == 'BR-P-6') {
                $newRegService->hour = $cat;
            } else if ($service->code == 'BR-P-7') {
                $newRegService->hour = $pasang;
            } elseif ($service->code == 'BR-P-8') {
                $newRegService->hour = $poles;
            } else if ($service->code == 'BR-P-9') {
                $newRegService->hour = $cuci;
            } else {
                $newRegService->hour = $finishing;
            }
            $newRegService->save(false);


            $real = new RegistrationRealizationProcess();
            $real->name = $service->name;
            $real->service_id = $service->id;
            $real->registration_transaction_id = $this->header->id;
            $real->detail = 'Pending';
            $real->save(false);
        }
        $deliver = new RegistrationRealizationProcess();
        $deliver->name = 'Car Delivered/token';
        $deliver->registration_transaction_id = $this->header->id;
        $deliver->save(false);

        $invoice = new RegistrationRealizationProcess();
        $invoice->name = 'Tagihan (invoice)';
        $invoice->registration_transaction_id = $this->header->id;
        $invoice->save(false);

        $salvage = new RegistrationRealizationProcess();
        $salvage->name = 'Salvage';
        $salvage->registration_transaction_id = $this->header->id;
        $salvage->save(false);

        $siap = new RegistrationRealizationProcess();
        $siap->name = 'Siap Kirim';
        $siap->registration_transaction_id = $this->header->id;
        $siap->save(false);

        $fu = new RegistrationRealizationProcess();
        $fu->name = 'Follow up Tagihan';
        $fu->registration_transaction_id = $this->header->id;
        $fu->save(false);

        $lunas = new RegistrationRealizationProcess();
        $lunas->name = 'Lunas';
        $lunas->registration_transaction_id = $this->header->id;
        $lunas->save(false);

        $lain = new RegistrationRealizationProcess();
        $lain->name = 'Lain-lain(STNK,Polisi,etc)';
        $lain->registration_transaction_id = $this->header->id;
        $lain->save(false);
    }

    public function getTotalQuickServiceQuantity() {
        $quantity = 0;

        foreach ($this->quickServiceDetails as $detail)
            $quantity = $quantity + 1;

        return $quantity;
    }

    public function getSubTotalQuickService() {
        $total = 0.00;

        foreach ($this->quickServiceDetails as $detail)
            $total += $detail->price;

        return $total;
    }

    public function getTotalQuantityService() {
        $quantity = 0;

        foreach ($this->serviceDetails as $detail)
            $quantity = $quantity + 1;

        return $quantity;
    }

    public function getSubTotalService() {
        $total = 0.00;

        foreach ($this->serviceDetails as $detail)
            $total += $detail->totalAmount;

        return $total;
    }

    public function getTotalDiscountService() {
        $total = 0.00;

        foreach ($this->serviceDetails as $detail)
            $total += $detail->discountAmount;

        return $total;
    }

    public function getGrandTotalService() {
        return $this->subTotalService; // - $this->totalDiscountService;
    }

    public function getTotalQuantityProduct() {
        $quantity = 0;

        foreach ($this->productDetails as $detail)
            $quantity += $detail->quantity;

        return $quantity;
    }

    public function getSubTotalProduct() {
        $total = 0.00;

        foreach ($this->productDetails as $detail)
            $total += $detail->totalAmountProduct;

        return $total;
    }

    public function getTotalDiscountProduct() {
        $total = 0.00;

        foreach ($this->productDetails as $detail)
            $total += $detail->discountAmount;

        return $total;
    }

    public function getGrandTotalProduct() {
        return $this->subTotalProduct; // - $this->totalDiscountProduct;
    }

    public function getSubTotalTransaction() {
        return $this->subTotalQuickService + $this->grandTotalService + $this->grandTotalProduct;
    }

    public function getTaxItemAmount() {
        return ($this->header->ppn == 1) ? $this->subTotalTransaction * .1 : 0;
    }

    public function getTaxServiceAmount() {
        return ($this->header->pph == 1) ? ($this->subTotalQuickService + $this->grandTotalService) * .025 : 0;
    }

    public function getGrandTotalTransaction() {
        return $this->subTotalTransaction + $this->taxItemAmount - $this->taxServiceAmount;
    }
}