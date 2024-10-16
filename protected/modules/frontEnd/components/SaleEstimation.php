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

        $service = Service::model()->findByPk($serviceId);
        
        if ($service !== null) {
            $serviceDetail = new SaleEstimationServiceDetail();
            $serviceDetail->service_id = $serviceId;
            $serviceDetail->price = '0.00';
            $serviceDetail->service_type_id = $service->service_type_id;

            $this->serviceDetails[] = $serviceDetail;
        }
    }

    public function removeServiceDetailAt($index) {
        array_splice($this->serviceDetails, $index, 1);
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
        $this->header->sub_total_service = $this->subTotalService;
        $this->header->sub_total_product = $this->subTotalProduct;
        $this->header->total_quantity_product = $this->totalQuantityProduct;
        $this->header->grand_total = $this->grandTotal;
        $valid = $this->header->save();

        //save request detail
        if (count($this->serviceDetails) > 0) {
            foreach ($this->serviceDetails as $serviceDetail) {
                $serviceDetail->sale_estimation_header_id = $this->header->id;
                $valid = $serviceDetail->save(false) && $valid;
            }
        }

        //save request detail
        if (count($this->productDetails) > 0) {
            foreach ($this->productDetails as $productDetail) {
                $productDetail->sale_estimation_header_id = $this->header->id;
                $productDetail->total_price = $productDetail->totalPrice;

                $valid = $productDetail->save(false) && $valid;
            }
        }

        return $valid;
    }

    public function getSubTotalService() {
        $total = 0.00;

        foreach ($this->serviceDetails as $detail) {
            $total += $detail->price;
        }

        return $total;
    }

    public function getSubTotalProduct() {
        $total = 0.00;

        foreach ($this->productDetails as $detail) {
            $total += $detail->total_price;
        }

        return $total;
    }

    public function getTotalQuantityProduct() {
        $quantity = 0;

        foreach ($this->productDetails as $detail) {
            $quantity += $detail->quantity;
        }

        return $quantity;
    }
    
    public function getSubTotalProductService() {
        return $this->subTotalProduct + $this->subTotalService; 
    }
    
    public function getGrandTotal() {
        return $this->subTotalProductService + $this->header->tax_product_amount - $this->header->tax_service_amount;
    }
}