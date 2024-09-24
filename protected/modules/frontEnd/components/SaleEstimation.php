<?php

class SaleEstimation extends CComponent {

    public $header;
    public $serviceDetails;
    public $productDetails;

    public function __construct($header, array $serviceDetails, array $productDetails) {
        $this->header = $header;
        $this->serviceDetails = $serviceDetails;
        $this->productDetails = $productDetails;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $saleEstimation = SaleEstimationHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($saleEstimation == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $saleEstimation->branch->code;
            $this->header->transaction_number = $saleEstimation->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, SaleEstimationHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addServiceDetail($serviceId) {

        $serviceArrays = $this->serviceDetails;
        $checkService = array();
        
//        $service = Service::model()->findByPk($serviceId);
//        $vehicle = Vehicle::model()->findByPk($vehicleId);
//        $vehicleCarModel = VehicleCarModel::model()->findByPk($vehicle->car_model_id);
//        $servicePricelist = ServicePricelist::model()->findByAttributes(array('service_id' => $serviceId, 'service_group_id' => $vehicleCarModel->service_group_id));
//        $servicePriceRate = empty($servicePricelist) ? 0.00 : $servicePricelist->price;

//        foreach ($serviceArrays as $serviceArray) {
//            $checkService[] = $serviceArray->service_id;
//        }
        if (in_array($serviceId, $checkService)) {
            echo "Please select other Service, this is already added";
        } else {
            $serviceDetail = new SaleEstimationServiceDetail();
            $serviceDetail->service_id = $serviceId;
            $serviceDetail->price = '0.00';

            $this->serviceDetails[] = $serviceDetail;
        }
    }

    public function getService($serviceId, $customerId, $custType, $vehicleId) {
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $serviceDetail = new SaleEstimationServiceDetail();
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

    public function removeServiceDetailAt($index) {
        array_splice($this->serviceDetails, $index, 1);
    }

    public function removeServiceDetailAll() {
        $this->serviceDetails = array();
    }

    public function addProductDetail($productId) {
        
        $product = Product::model()->findByPk($productId);

        if ($product !== null) {
            $productDetail = new SaleEstimationProductDetail();
            $productDetail->product_id = $productId;
            $productDetail->retail_price = $product->retail_price;
            $productDetail->sale_price = $product->retail_price;
            $this->productDetails[] = $productDetail;
        }
    }

    public function removeProductDetailAt($index) {
        array_splice($this->productDetails, $index, 1);
    }

    public function validate() {
        $valid = $this->header->validate();

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

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
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
            $this->header->status = 'Draft';
            $this->header->repair_type = 'GR';
        }

        $valid = $this->header->save();

        //save request detail
        if (count($this->serviceDetails) > 0) {
            $serviceTypeIds = array();
            foreach ($this->serviceDetails as $serviceDetail) {
                $serviceDetail->sale_estimation_header_id = $this->header->id;
                $serviceDetail->service_type_id = $serviceDetail->service->service_type_id;
                $valid = $serviceDetail->save(false) && $valid;
            }
        }

        //save request detail
        if (count($this->productDetails) > 0) {
            foreach ($this->productDetails as $productDetail) {
                $productDetail->sale_estimation_header_id = $this->header->id;
//                $productDetail->total_price = $productDetail->totalAmountProduct;

                $valid = $productDetail->save(false) && $valid;
            }
        }

        return $valid;
    }

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
            $total += $detail->price;
        }

        return $total;
    }

//    public function getTotalDiscountService() {
//        $total = 0.00;
//
//        foreach ($this->serviceDetails as $detail) {
//            $total += $detail->discountAmount;
//        }
//
//        return $total;
//    }

//    public function getGrandTotalService() {
//        return $this->subTotalService;
//    }

    public function getTotalQuantityProduct() {
        $quantity = 0;

        foreach ($this->productDetails as $detail) {
            $quantity += $detail->quantity;
        }

        return $quantity;
    }

//    public function getSubTotalProduct() {
//        $total = 0.00;
//
//        foreach ($this->productDetails as $detail) {
//            $total += $detail->totalAmountProduct;
//        }
//        
//        switch($this->header->ppn) {
//            case 3: return $total / (1 + $this->header->tax_percentage / 100);
//            default: return $total;
//        }
//
//        return $total;
//    }
//
//    public function getTotalDiscountProduct() {
//        $total = 0.00;
//
//        foreach ($this->productDetails as $detail) {
//            $total += $detail->discountAmount;
//        }
//
//        return $total;
//    }
//
//    public function getGrandTotalProduct() {
//        return $this->subTotalProduct;
//    }
//
//    public function getSubTotalTransaction() {
//        return $this->subTotalQuickService + $this->grandTotalService + $this->grandTotalProduct;
//    }
//
//    public function getTaxItemAmount() {
//        return ((int)$this->header->ppn == 2) ? 0 : $this->subTotalTransaction * $this->header->tax_percentage / 100;
//    }
//
//
//    public function getGrandTotalTransaction() {
//        return $this->subTotalTransaction + $this->taxItemAmount;
//    }
}