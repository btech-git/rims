<?php

class SaleRegistration extends CComponent {

    public $actionType;
    public $header;
    public $serviceDetails;
    public $productDetails;
    public $packageDetails;

    public function __construct($actionType, $header, array $serviceDetails, array $productDetails, array $packageDetails) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->serviceDetails = $serviceDetails;
        $this->productDetails = $productDetails;
        $this->packageDetails = $packageDetails;
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
            'order' => ' work_order_number DESC',
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
            'order' => ' sales_order_number DESC',
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
    
    public function generateCodeNumberDownpayment($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(downpayment_transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(downpayment_transaction_number, '/', 2), '/', -1), '.', -1)";
        $registrationTransaction = RegistrationTransaction::model()->find(array(
            'order' => ' downpayment_transaction_number DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($registrationTransaction == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $registrationTransaction->branch->code;
            $this->header->downpayment_transaction_number = $registrationTransaction->downpayment_transaction_number;
        }

        $this->header->setCodeNumberByNext('downpayment_transaction_number', $branchCode, RegistrationTransaction::CONSTANT_DOWNPAYMENT, $currentMonth, $currentYear);
    }
    
    public function generateCodeNumberReworkTransaction($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(rework_transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(rework_transaction_number, '/', 2), '/', -1), '.', -1)";
        $registrationTransaction = RegistrationTransaction::model()->find(array(
            'order' => ' rework_transaction_number DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($registrationTransaction == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $registrationTransaction->branch->code;
            $this->header->rework_transaction_number = $registrationTransaction->rework_transaction_number;
        }

        $this->header->setCodeNumberByNext('rework_transaction_number', $branchCode, RegistrationTransaction::CONSTANT_REWORK, $currentMonth, $currentYear);
    }
    
    public function setCodeNumberWorkOrderByRevision($codeNumberColumnName) {
        list($leftCode, $middleCode, $rightCode) = explode('/', $this->header->$codeNumberColumnName);
        list($branchCode, $constant) = explode('.', $leftCode);
        list($year, $month) = explode('.', $middleCode);
        list($ordinal, $revisionCode) = explode('.', $rightCode);
        $month = $this->header->normalizeCnMonthBy($month);
        
        $arr = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $month = $month ? $month - 1 : 0;
        $revisionOrdinal = ord($revisionCode) + 1;
        $this->header->$codeNumberColumnName = sprintf('%s.%s/%04d.%s/%04d.%c', $branchCode, $constant, $year, $arr[$month], $ordinal, $revisionOrdinal);
    }

    public function setCodeNumberSaleOrderByRevision($codeNumberColumnName) {
        list($leftCode, $middleCode, $rightCode) = explode('/', $this->header->$codeNumberColumnName);
        list($branchCode, $constant) = explode('.', $leftCode);
        list($year, $month) = explode('.', $middleCode);
        list($ordinal, $revisionCode) = explode('.', $rightCode);
        $month = $this->header->normalizeCnMonthBy($month);
        
        $arr = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $month = $month ? $month - 1 : 0;
        $revisionOrdinal = ord($revisionCode) + 1;
        $this->header->$codeNumberColumnName = sprintf('%s.%s/%04d.%s/%04d.%c', $branchCode, $constant, $year, $arr[$month], $ordinal, $revisionOrdinal);
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
            $registrationProduct->unit_id = $product->unit_id;
            $registrationProduct->hpp = $product->hpp;
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

    public function addPackageDetail($packageId) {
        
        $salePackageHeader = SalePackageHeader::model()->findByPk($packageId);

        if ($salePackageHeader !== null) {
            $registrationPackage = new RegistrationPackage();
            $registrationPackage->sale_package_header_id = $packageId;
            $registrationPackage->price = $salePackageHeader->price;
            $this->packageDetails[] = $registrationPackage;
        }
    }

    public function removePackageDetailAt($index) {
        array_splice($this->packageDetails, $index, 1);
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
            $serviceDetail->status = 'Finished';
            $valid = $serviceDetail->save(false) && $valid;

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
            $productDetail->unit_id = $productDetail->product->unit_id;
            $productDetail->quantity_movement = $productDetail->totalMovementOutQuantity;
            $productDetail->quantity_movement_left = $productDetail->quantityMovementLeft;

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
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->transaction_number;
        $transactionLog->transaction_date = $this->header->transaction_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $this->header->tableName();
        $transactionLog->table_id = $this->header->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $this->actionType;
        
        $newData = $this->header->attributes;
        
        $newData['registrationProducts'] = array();
        foreach($this->productDetails as $detail) {
            $newData['registrationProducts'][] = $detail->attributes;
        }
        
        $newData['registrationServices'] = array();
        foreach($this->serviceDetails as $detail) {
            $newData['registrationServices'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
}