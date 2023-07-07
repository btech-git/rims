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

//        $serviceArrays = array();
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
            if (!empty($serviceCarSubDetail)) {
                $serviceDetail->price = $serviceCarSubDetail->price;
                $serviceDetail->total_price = $serviceCarSubDetail->price;
            } else {
                $serviceCarModel = ServicePricelist::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id, 'car_model_id' => $vehicle->car_model_id));
                if (!empty($serviceCarModel)) {
                    $serviceDetail->price = $serviceCarModel->price;
                    $serviceDetail->total_price = $serviceCarModel->price;
                } else {
                    $serviceCarMake = ServicePricelist::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id));
                    if (!empty($serviceCarMake)) {
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
            if (!empty($custServiceSubDetail)) {
                $serviceDetail->price = $custServiceSubDetail->rate;
                $serviceDetail->total_price = $custServiceSubDetail->rate;
            } else {
                $custServiceCarModel = CustomerServiceRate::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id, 'car_model_id' => $vehicle->car_model_id, 'customer_id' => $customerId));
                if (!empty($custServiceCarModel)) {
                    $serviceDetail->price = $custServiceCarModel->rate;
                    $serviceDetail->total_price = $custServiceCarModel->rate;
                } else {
                    $custServiceCarMake = CustomerServiceRate::model()->findByAttributes(array('service_id' => $serviceId, 'car_make_id' => $vehicle->car_make_id, 'customer_id' => $customerId));
                    if (!empty($custServiceCarMake)) {
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
//        $productArrays = array();
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

    public function removeProductDetailAt($index) {
        array_splice($this->productDetails, $index, 1);
    }

    public function validate() {

        $valid = $this->header->validate(array('car_mileage', 'problem', 'insurance_company_id'));
        $valid = $valid && $this->validateExistingCustomer();

        return $valid;
    }

    public function validateExistingCustomer() {
        $valid = true;

        $registrationTransaction = RegistrationTransaction::model()->findByAttributes(array('transaction_date' => $this->header->transaction_date, 'vehicle_id' => $this->header->vehicle_id));

        if (!empty($registrationTransaction)) {
            $valid = false;
            $this->header->addError('error', 'Kendaraan customer sudah ada di database hari ini.');
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
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
            $this->header->vehicle_status = 'DI BENGKEL';
            $this->header->service_status = 'Bongkar - Pending';
        } /*else {
            $this->header->status = 'Update Registration';
        }*/

        $this->header->total_quickservice = 0;
        $this->header->total_quickservice_price = 0;
        $this->header->repair_type = 'BR';
        $this->header->priority_level = 2;

        $valid = $this->header->save();

        if ($isNewRecord && $valid) {
            $serviceNames = array('Bongkar', 'Sparepart', 'KetokLas', 'Dempul', 'Epoxy', 'Cat', 'Pasang', 'Cuci', 'Poles');
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
            $valid = $this->validateDetails() && IdempotentManager::build()->save() && $this->flushDetails();
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

        $this->header->setCodeNumberByRevision('transaction_number');
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
//        $this->header->pph_price = $this->taxServiceAmount;
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
            $serviceDetail->start = null;
            $serviceDetail->end = null;
            $serviceDetail->pause = null;
            $serviceDetail->resume = null;
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
        if (count($this->productDetails) > 0) {
            foreach ($this->productDetails as $productDetail) {
                $productDetail->registration_transaction_id = $this->header->id;
                $productDetail->total_price = $productDetail->totalAmountProduct;
                $productDetail->quantity_movement = 0;
                $productDetail->quantity_movement_left = $productDetail->quantity;

                $valid = $productDetail->save(false) && $valid;
                $new_product[] = $productDetail->id;
            }
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

    public function validateInvoice() {

        $valid = $this->header->validate(array('sale_order_number'));

        return $valid;
    }

//    public function saveInvoice($dbConnection, $id) {
//        $dbTransaction = $dbConnection->beginTransaction();
//        try {
//            $valid = $this->validateInvoice() && IdempotentManager::build()->save() && $this->flushInvoice($id);
//
//            if ($valid) {
//                $dbTransaction->commit();
//            } else {
//                $dbTransaction->rollback();
//            }
//        } catch (Exception $e) {
//            $dbTransaction->rollback();
//            $valid = false;
//            $this->header->addError('error', $e->getMessage());
//        }
//
//        return $valid;
//    }

//    public function flushInvoice($id) {
//
//        $this->header->payment_status = 'INVOICING';
//        $valid = $this->header->update(array('payment_status'));
//
//        $model = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $id));
//        
//        if (empty($model)) {
//            $model = new InvoiceHeader();
//            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($this->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($this->header->transaction_date)), $this->header->branch_id);
//        } else {
//            JurnalUmum::model()->deleteAllByAttributes(array(
//                'kode_transaksi' => $model->invoice_number,
//            ));
//
//            $model->setCodeNumberByRevision('invoice_number');
//        }
//        
//        $model->invoice_date = date('Y-m-d');
//        $model->due_date = date('Y-m-d');
//        $model->reference_type = 2;
//        $model->registration_transaction_id = $this->header->id;
//        $model->customer_id = $this->header->customer_id;
//        $model->vehicle_id = $this->header->vehicle_id;
//        $model->branch_id = $this->header->branch_id == "" ? 1 : $this->header->branch_id;
//        $model->user_id = Yii::app()->user->getId();
//        $model->status = "INVOICING";
//        $model->total_product = $this->header->total_product;
//        $model->total_service = $this->header->total_service;
//        $model->total_quick_service = $this->header->total_quickservice;
//        $model->service_price = $this->header->total_service_price;
//        $model->product_price = $this->header->total_product_price;
//        $model->quick_service_price = $this->header->total_quickservice_price;
//        $model->total_price = $this->header->grand_total;
//        $model->payment_left = $this->header->grand_total;
//        $model->payment_amount = 0;
//        $model->ppn_total = $this->header->ppn_price;
//        $model->pph_total = $this->header->pph_price;
//        $model->ppn = $this->header->ppn;
//        $model->pph = $this->header->pph;
//        $model->payment_date_estimate = date('Y-m-d');
//        $model->coa_bank_id_estimate = 7;
//        $model->created_datetime = date('Y-m-d H:i:s');
//        $valid = $model->save(false) && $valid;
//
//        $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
//        if (count($registrationProducts) != 0) {
//            foreach ($registrationProducts as $registrationProduct) {
//                $modelDetail = new InvoiceDetail();
//                $modelDetail->invoice_id = $model->id;
//                $modelDetail->product_id = $registrationProduct->product_id;
//                $modelDetail->quantity = $registrationProduct->quantity;
//                $modelDetail->unit_price = $registrationProduct->sale_price;
//                $modelDetail->total_price = $registrationProduct->total_price;
//                $modelDetail->save(false);
//            }//end foreach
//        } // end if count
//
//        $registrationServices = RegistrationService::model()->findAllByAttributes(array(
//            'registration_transaction_id' => $this->header->id,
//            'is_quick_service' => 0
//        ));
//        if (count($registrationServices) != 0) {
//            foreach ($registrationServices as $registrationService) {
//                $modelDetail = new InvoiceDetail();
//                $modelDetail->invoice_id = $model->id;
//                $modelDetail->service_id = $registrationService->service_id;
//                $modelDetail->unit_price = $registrationService->price;
//                $modelDetail->total_price = $registrationService->total_price;
//                $modelDetail->save(false);
//            }
//        }
//
//        $registrationQuickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
//        if (count($registrationQuickServices) != 0) {
//            foreach ($registrationQuickServices as $registrationQuickService) {
//                $modelDetail = new InvoiceDetail();
//                $modelDetail->invoice_id = $model->id;
//                $modelDetail->quick_service_id = $registrationQuickService->quick_service_id;
//                $modelDetail->unit_price = $registrationQuickService->price;
//                $modelDetail->total_price = $registrationQuickService->price;
//                $modelDetail->save(false);
//            }
//        }
//
//        $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
//        if (count($invoices) > 0) {
//
//            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
//                'registration_transaction_id' => $this->header->id,
//                'name' => 'Invoice'
//            ));
//            if (!empty($real)) {
//                $real->checked_date = date('Y-m-d');
//                $real->detail = 'ReGenerate Invoice with number #' . $model->invoice_number;
//                $real->save(false);
//            } else {
//                $real = new RegistrationRealizationProcess();
//                $real->registration_transaction_id = $this->header->id;
//                $real->name = 'Invoice';
//                $real->checked = 1;
//                $real->checked_date = date('Y-m-d');
//                $real->checked_by = Yii::app()->user->getId();
//                $real->detail = 'Generate Invoice with number #' . $model->invoice_number;
//                $real->save();
//            }
//        } else {
//            $real = new RegistrationRealizationProcess();
//            $real->registration_transaction_id = $this->header->id;
//            $real->name = 'Invoice';
//            $real->checked = 1;
//            $real->checked_date = date('Y-m-d');
//            $real->checked_by = Yii::app()->user->getId();
//            $real->detail = 'Generate Invoice with number #' . $model->invoice_number;
//            $real->save();
//        }
//
//        $transactionType = 'Invoice BR';
//        $postingDate = date('Y-m-d');
//        $transactionCode = $model->invoice_number;
//        $transactionDate = $model->invoice_date;
//        $branchId = $this->header->branch_id;
//        $transactionSubject = $this->header->customer->name;
//
//        $journalReferences = array();
//
//        $jurnalUmumReceivable = new JurnalUmum;
//        $jurnalUmumReceivable->kode_transaksi = $transactionCode;
//        $jurnalUmumReceivable->tanggal_transaksi = $transactionDate;
//        $jurnalUmumReceivable->coa_id = (empty($this->header->insurance_company_id)) ? $this->header->customer->coa_id : $this->header->insuranceCompany->coa_id;
//        $jurnalUmumReceivable->branch_id = $this->header->branch_id;
//        $jurnalUmumReceivable->total = $this->header->subtotal_product + $this->header->subtotal_service + $this->header->ppn_price;
//        $jurnalUmumReceivable->debet_kredit = 'D';
//        $jurnalUmumReceivable->tanggal_posting = date('Y-m-d');
//        $jurnalUmumReceivable->transaction_subject = $this->header->customer->name;
//        $jurnalUmumReceivable->is_coa_category = 0;
//        $jurnalUmumReceivable->transaction_type = $transactionType;
//        $valid = $jurnalUmumReceivable->save() && $valid;
//
//        if ($this->header->ppn_price > 0.00) {
//            $coaPpn = Coa::model()->findByAttributes(array('code' => '224.00.001'));
//            $jurnalUmumPpn = new JurnalUmum;
//            $jurnalUmumPpn->kode_transaksi = $transactionCode;
//            $jurnalUmumPpn->tanggal_transaksi = $transactionDate;
//            $jurnalUmumPpn->coa_id = $coaPpn->id;
//            $jurnalUmumPpn->branch_id = $this->header->branch_id;
//            $jurnalUmumPpn->total = $this->header->ppn_price;
//            $jurnalUmumPpn->debet_kredit = 'K';
//            $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
//            $jurnalUmumPpn->transaction_subject = $this->header->customer->name;
//            $jurnalUmumPpn->is_coa_category = 0;
//            $jurnalUmumPpn->transaction_type = $transactionType;
//            $valid = $jurnalUmumPpn->save() && $valid;
//        }
//
//        if (count($this->productDetails) > 0) {
//            foreach ($this->productDetails as $key => $rProduct) {
//                $jurnalUmumHpp = $rProduct->product->productSubMasterCategory->coa_hpp;
//                $journalReferences[$jurnalUmumHpp]['debet_kredit'] = 'D';
//                $journalReferences[$jurnalUmumHpp]['is_coa_category'] = 0;
//                $journalReferences[$jurnalUmumHpp]['values'][] = $rProduct->quantity * $rProduct->hpp;
//
//                $jurnalUmumPenjualan = $rProduct->product->productSubMasterCategory->coa_penjualan_barang_dagang;
//                $journalReferences[$jurnalUmumPenjualan]['debet_kredit'] = 'K';
//                $journalReferences[$jurnalUmumPenjualan]['is_coa_category'] = 0;
//                $journalReferences[$jurnalUmumPenjualan]['values'][] = $rProduct->sale_price * $rProduct->quantity;
//
//                $jurnalUmumOutstandingPart = $rProduct->product->productSubMasterCategory->coa_outstanding_part_id;
//                $journalReferences[$jurnalUmumOutstandingPart]['debet_kredit'] = 'K';
//                $journalReferences[$jurnalUmumOutstandingPart]['is_coa_category'] = 0;
//                $journalReferences[$jurnalUmumOutstandingPart]['values'][] = $rProduct->quantity * $rProduct->hpp;
//
//                if ($rProduct->discount > 0) {
//                    $jurnalUmumDiskon = $rProduct->product->productSubMasterCategory->coa_diskon_penjualan;
//                    $journalReferences[$jurnalUmumDiskon]['debet_kredit'] = 'D';
//                    $journalReferences[$jurnalUmumDiskon]['is_coa_category'] = 0;
//                    $journalReferences[$jurnalUmumDiskon]['values'][] = $rProduct->discountAmount;
//                }
//            }
//        }
//
//        if (count($this->serviceDetails) > 0) {
//            foreach ($this->serviceDetails as $key => $rService) {
//                $price = $rService->is_quick_service == 1 ? $rService->price : $rService->price;
//
//                $jurnalUmumPendapatanJasa = $rService->service->serviceCategory->coa_id;
//                $journalReferences[$jurnalUmumPendapatanJasa]['debet_kredit'] = 'K';
//                $journalReferences[$jurnalUmumPendapatanJasa]['is_coa_category'] = 0;
//                $journalReferences[$jurnalUmumPendapatanJasa]['values'][] = $price;
//
//                if ($rService->discount_price > 0.00) {
//                    $jurnalUmumDiscountPendapatanJasa = $rService->service->serviceCategory->coa_diskon_service;
//                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['debet_kredit'] = 'D';
//                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['is_coa_category'] = 0;
//                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['values'][] = $rService->discountAmount;
//                }
//            }
//        }
//
//        foreach ($journalReferences as $coaId => $journalReference) {
//            $jurnalUmumPersediaan = new JurnalUmum();
//            $jurnalUmumPersediaan->kode_transaksi = $transactionCode;
//            $jurnalUmumPersediaan->tanggal_transaksi = $transactionDate;
//            $jurnalUmumPersediaan->coa_id = $coaId;
//            $jurnalUmumPersediaan->branch_id = $branchId;
//            $jurnalUmumPersediaan->total = array_sum($journalReference['values']);
//            $jurnalUmumPersediaan->debet_kredit = $journalReference['debet_kredit'];
//            $jurnalUmumPersediaan->tanggal_posting = $postingDate;
//            $jurnalUmumPersediaan->transaction_subject = $transactionSubject;
//            $jurnalUmumPersediaan->is_coa_category = $journalReference['is_coa_category'];
//            $jurnalUmumPersediaan->transaction_type = $transactionType;
//            $jurnalUmumPersediaan->save();
//        }
//
//        return $valid;
//    }

    public function getTotalQuantityService() {
        $quantity = 0;

        foreach ($this->serviceDetails as $detail) {
            $quantity = $quantity + 1;
        }

        return $quantity;
    }

    public function getSubTotalService() {
        $total = 0.00;

        foreach ($this->serviceDetails as $detail) {
            $total += $detail->totalAmount;
        }

        return $total;
    }

    public function getTotalDiscountService() {
        $total = 0.00;

        foreach ($this->serviceDetails as $detail) {
            $total += $detail->discountAmount;
        }

        return $total;
    }

    public function getGrandTotalService() {
        return $this->subTotalService; // - $this->totalDiscountService;
    }

    public function getTotalQuantityProduct() {
        $quantity = 0;

        foreach ($this->productDetails as $detail) {
            $quantity += $detail->quantity;
        }

        return $quantity;
    }

    public function getSubTotalProduct() {
        $total = 0.00;

        foreach ($this->productDetails as $detail) {
            $total += $detail->totalAmountProduct;
        }

        switch ($this->header->ppn) {
            case 3: return $total / (1 + $this->header->tax_percentage / 100);
            default: return $total;
        }

        return $total;
    }

    public function getTotalDiscountProduct() {
        $total = 0.00;

        foreach ($this->productDetails as $detail) {
            $total += $detail->discountAmount;
        }

        return $total;
    }

    public function getGrandTotalProduct() {
        return $this->subTotalProduct; // - $this->totalDiscountProduct;
    }

    public function getSubTotalTransaction() {
        return $this->grandTotalService + $this->grandTotalProduct;
    }

    public function getTaxItemAmount() {
        return ($this->header->ppn == 2) ? 0 : $this->subTotalTransaction * $this->header->tax_percentage / 100;
    }

//    public function getTaxServiceAmount() {
//        return ($this->header->pph == 1) ? ($this->grandTotalService) * .02 : 0;
//    }

    public function getGrandTotalTransaction() {
        return $this->subTotalTransaction + $this->taxItemAmount; // - $this->taxServiceAmount;
    }

}
