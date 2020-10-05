<?php

class BodyRepairRegistration extends CComponent {

    public $header;
    public $damageDetails;
    public $serviceDetails;
    public $productDetails;

    public function __construct($header, array $damageDetails, array $serviceDetails, array $productDetails) {
        $this->header = $header;
        $this->damageDetails = $damageDetails;
        $this->serviceDetails = $serviceDetails;
        $this->productDetails = $productDetails;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $registrationTransaction = RegistrationTransaction::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
                ));

        if ($registrationTransaction == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $registrationTransaction->branch->code;
            $this->header->transaction_number = $registrationTransaction->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, RegistrationTransaction::CONSTANT, $currentMonth, $currentYear);
    }

    public function generateCodeNumberWorkOrder($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(work_order_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(work_order_number, '/', 2), '/', -1), '.', -1)";
        $registrationTransaction = RegistrationTransaction::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($registrationTransaction == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $registrationTransaction->branch->code;
            $this->header->work_order_number = $registrationTransaction->work_order_number;
        }

        $this->header->setCodeNumberByNext('work_order_number', $branchCode, RegistrationTransaction::CONSTANT_WORK_ORDER, $currentMonth, $currentYear);
    }

    public function generateCodeNumberSaleOrder($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(sales_order_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(sales_order_number, '/', 2), '/', -1), '.', -1)";
        $registrationTransaction = RegistrationTransaction::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($registrationTransaction == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $registrationTransaction->branch->code;
            $this->header->sales_order_number = $registrationTransaction->sales_order_number;
        }

        $this->header->setCodeNumberByNext('sales_order_number', $branchCode, RegistrationTransaction::CONSTANT_SALE_ORDER, $currentMonth, $currentYear);
    }
    
    public function addDamageDetail($serviceId) {
        $damageDetail = new RegistrationDamage();
        $service = Service::model()->findByPk($serviceId);
        $serviceArrays = array();
        $serviceArrays = $this->damageDetails;
        $checkService = array();
        $brServices = array();

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
            }
        }
    }

    public function removeDamageDetailAt($index) {
        array_splice($this->damageDetails, $index, 1);
    }

    public function removeDamageDetailAll() {
        $this->damageDetails = array();
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

    public function addServiceDetail($serviceId, $customerId, $custType, $vehicleId, $repair) {

        $serviceArrays = array();
        $serviceArrays = $this->serviceDetails;
        $checkService = array();

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
                                $bodyVal = BodyStandardValue::model()->findByPk(1);
                                $bodyFR = BodyStandardFr::model()->findByPk(1);
                                $diff = $bodyVal->difficulty_value;
                                $lux = $bodyVal->luxury_value;
                                $hour = $bodyVal->flat_rate_hour;
                                $rate = $bodyFR->flat_rate;
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
        }//endif Individual
        else {
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
                            $bodyVal = BodyStandardValue::model()->findByPk(1);
                            $diff = $bodyVal->difficulty_value;
                            $lux = $bodyVal->luxury_value;
                            $hour = $bodyVal->flat_rate_hour;
                        } else {
                            $diff = $service->difficulty_value;
                            $lux = $service->luxury_value;
                            $hour = $service->flat_rate_hour;
                        }
                        if ($customerData->flat_rate != null) {
                            $priceTotal = $diff * $lux * $hour * $customerData->flat_rate;
                        } else {
                            $bodyFR = BodyStandardFr::model()->findByPk(1);
                            $priceTotal = $diff * $lux * $hour * $bodyFR->flat_rate;
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

    public function removeServiceDetailAt($index) {
        array_splice($this->serviceDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function removeServiceDetailAll() {
        $this->serviceDetails = array();
    }

    public function addProductDetail($productId) {
        $productArrays = array();
        $productArrays = $this->productDetails;
        $checkProduct = array();
        foreach ($productArrays as $productArray)
            $checkProduct[] = $productArray->product_id;

        if (in_array($productId, $checkProduct))
            echo "Please select other Product, this is already added";
        else {
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

    public function removeProductDetailAt($index) {
        array_splice($this->productDetails, $index, 1);
    }

    public function validate() {
        
        $valid = $this->header->validate(array('car_mileage', 'problem', 'insurance_company_id'));

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function flush() {
        $isNewRecord = $this->header->isNewRecord;
        if ($isNewRecord) {
            $this->header->status = 'Registration';
        }
        else
            $this->header->status = 'Update Registration';

        $this->header->total_quickservice = 0;
        $this->header->total_quickservice_price = 0;
        $this->header->repair_type = 'BR';
        $this->header->service_status = 'Bongkar - Pending';
        $this->header->priority_level = 2;
        
        $valid = $this->header->save();
        
        if ($isNewRecord && $valid) {
            $serviceNames = array('Bongkar Pasang', 'Las Ketok', 'Dempul', 'Epoxy', 'Cat', 'Finishing', 'Cuci', 'Poles');
            foreach ($serviceNames as $serviceName) {
                $registrationBodyRepairDetail = new RegistrationBodyRepairDetail();
                $registrationBodyRepairDetail->service_name = $serviceName;
                $registrationBodyRepairDetail->registration_transaction_id = $this->header->id;
                
                $valid = $valid && $registrationBodyRepairDetail->save();
                if (!$valid) {
                    break;
                }
            }
            
            $registrationRealization = new RegistrationRealizationProcess();
            $registrationRealization->registration_transaction_id = $this->header->id;
            $registrationRealization->name = 'Vehicle Inspection';
            $registrationRealization->detail = 'No';
            $registrationRealization->save();
        }
        
        return $valid;
    }

    public function saveDetails($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validateDetails() && $this->flushDetails();
            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function validateDetails() {
        $valid = true;

        if (count($this->damageDetails) > 0) {
            foreach ($this->damageDetails as $detail) {

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

    public function flushDetails() {
        $valid = true;

        $this->header->is_insurance = empty($this->header->insurance_company_id) ? 0 : 1;
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

        //save request detail quick service
        foreach ($this->damageDetails as $damageDetail) {
            $damageDetail->registration_transaction_id = $this->header->id;

            $valid = $damageDetail->save(false) && $valid;
            $new_detail[] = $damageDetail->id;
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
//            if ($isNewRecord) {
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
//            }
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
            $productDetail->registration_transaction_id = $this->header->id;
            $productDetail->total_price = $productDetail->totalAmountProduct;

            $valid = $productDetail->save(false) && $valid;
            $new_product[] = $productDetail->id;
        }

        //delete 
        $delete_product_array = array_diff($product_id, $new_product);
        if ($delete_product_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_product_array);
            RegistrationProduct::model()->deleteAll($criteria);
        }

        return $valid;
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
        return $this->grandTotalService + $this->grandTotalProduct;
    }

    public function getTaxItemAmount() {
        return ($this->header->ppn == 1) ? $this->subTotalTransaction * .1 : 0;
    }

    public function getTaxServiceAmount() {
        return ($this->header->pph == 1) ? ($this->grandTotalService) * .025 : 0;
    }

    public function getGrandTotalTransaction() {
        return $this->subTotalTransaction + $this->taxItemAmount - $this->taxServiceAmount;
    }

}
