<?php

class RegistrationTransactionComponent extends CComponent {

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

    public function addDetails($estimationId) {

        $saleEstimationHeader = SaleEstimationHeader::model()->findByPk($estimationId);

        if (!empty($saleEstimationHeader)) {
            foreach ($saleEstimationHeader->saleEstimationProductDetails as $productDetail) {
                $detailProduct = new RegistrationProduct();
                $detailProduct->product_id = $productDetail->product_id;
                $detailProduct->quantity = $productDetail->quantity;
                $detailProduct->discount = $productDetail->discount_value;
                $detailProduct->discount_type = $productDetail->discount_type;
                $detailProduct->sale_price = $productDetail->sale_price;
                $detailProduct->total_price = $productDetail->total_price;
                $detailProduct->sale_estimation_product_detail_id = $productDetail->id;
                $this->productDetails[] = $detailProduct;
            }
            foreach ($saleEstimationHeader->saleEstimationServiceDetails as $serviceDetail) {
                $detailService = new RegistrationService();
                $detailService->service_id = $serviceDetail->service_id;
                $detailService->price = $serviceDetail->price;
                $detailService->discount_price = $serviceDetail->discount_value;
                $detailService->discount_type = $serviceDetail->discount_type;
                $detailService->total_price = $serviceDetail->total_price;
                $detailService->service_type_id = $serviceDetail->service_type_id;
                $detailService->sale_estimation_service_detail_id = $serviceDetail->id;
                $this->serviceDetails[] = $detailService;
            }
            $this->header->total_product = $saleEstimationHeader->total_quantity_product; 
            $this->header->subtotal_product = $saleEstimationHeader->sub_total_product; 
            $this->header->subtotal_service = $saleEstimationHeader->sub_total_service; 
            $this->header->subtotal = $saleEstimationHeader->sub_total; 
            $this->header->tax_percentage = $saleEstimationHeader->tax_product_percentage; 
            $this->header->ppn_price = $saleEstimationHeader->tax_product_amount; 
            $this->header->grand_total = $saleEstimationHeader->grand_total; 
        }
    }

    public function addServiceDetail($serviceId) {

        $service = Service::model()->findByPk($serviceId);

        $exist = false;
        foreach ($this->serviceDetails as $i => $detail) {
            if ($service->id === $detail->service_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $registrationService = new RegistrationService();
            $registrationService->service_id = $serviceId;
            $registrationService->price = $service->price;
            $registrationService->hour = $service->flat_rate_hour;
            $registrationService->claim = "NO";
            $this->serviceDetails[] = $registrationService;
        }
    }

    public function removeServiceDetailAt($index) {
        array_splice($this->serviceDetails, $index, 1);
    }

    public function addProductDetail($productId) {
        $product = Product::model()->findByPk($productId);

        $exist = false;
        foreach ($this->productDetails as $i => $detail) {
            if ($product->id === $detail->product_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $registrationProduct = new RegistrationProduct();
            $registrationProduct->product_id = $productId;
            $registrationProduct->retail_price = $product->retail_price;
            $registrationProduct->recommended_selling_price = $product->recommended_selling_price;
            $registrationProduct->sale_price = $product->retail_price;
            $registrationProduct->sale_package_detail_id = null;
            $registrationProduct->sale_package_header_id = null;
            $this->productDetails[] = $registrationProduct;
        }
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

        if (count($this->productDetails) > 0) {
            foreach ($this->productDetails as $productDetail) {

                $fields = array('quantity', 'product_id', 'sale_price', 'total_price');
                $valid = $productDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }
        
        if (count($this->serviceDetails) > 0) {
            foreach ($this->serviceDetails as $serviceDetail) {

                $fields = array('price', 'service_id');
                $valid = $serviceDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->serviceDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
        $isNewRecord = $this->header->isNewRecord;
        $this->header->status = 'Registration';
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

        $valid = $this->header->save();
        $bongkar = $sparepart = $ketok_las = $dempul = $epoxy = $cat = $pasang = $poles = $cuci = $finishing = 0;

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
            $serviceDetail->start_mechanic_id = null;
            $serviceDetail->finish_mechanic_id = null;
            $serviceDetail->pause_mechanic_id = null;
            $serviceDetail->resume_mechanic_id = null;
            $serviceDetail->supervisor_id = null;
            $serviceDetail->assign_mechanic_id = null;
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
        
        if ($this->header->repair_type == 'BR') {
            $real = RegistrationRealizationProcess::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
            if (count($real) == 0) {
                $this->bodyRepair($bongkar, $sparepart, $ketok_las, $dempul, $epoxy, $cat, $pasang, $poles, $cuci, $finishing);
            }
        }
        else {
            $realData = RegistrationRealizationProcess::model()->findByAttributes(array('registration_transaction_id' => $this->header->id, 'name' => 'Registration'));
            if (count($realData) == 0) {
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

        //save Product
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $this->header->id));
        $product_id = array();
        foreach ($products as $product) {
            $product_id[] = $product->id;
        }
        $new_product = array();

        //save request detail
        foreach ($this->productDetails as $productDetail) {
            if ($productDetail->quantity === 0) {
                continue;
            }
            
            $productDetail->registration_transaction_id = $this->header->id;
            $productDetail->total_price = $productDetail->totalAmountProduct;

            $valid = $productDetail->save(false) && $valid;
            $new_product[] = $productDetail->id;
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

    public function getTotalDiscountService() {
        $total = 0.00;

        foreach ($this->serviceDetails as $detail) {
            $total += $detail->discountAmount;
        }

        return $total;
    }

    public function getGrandTotalService() {
        return $this->subTotalService - $this->totalDiscountService;
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
            $total += $detail->totalBeforeDiscount;
        }
        
//        switch($this->header->ppn) {
//            case 3: return $total / (1 + $this->header->tax_percentage / 100);
//            default: return $total;
//        }

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
        return $this->subTotalProduct - $this->totalDiscountProduct;
    }

    public function getSubTotalTransaction() {
        return $this->grandTotalService + $this->grandTotalProduct;
    }

    public function getTaxItemAmount() {
        return ((int)$this->header->ppn == 2) ? 0 : $this->subTotalTransaction * $this->header->tax_percentage / 100;
    }

    public function getGrandTotalTransaction() {
        return $this->subTotalTransaction + $this->taxItemAmount;
    }
}