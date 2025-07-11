<?php

class PurchaseOrders extends CComponent {

    public $actionType;
    public $header;
    public $details;
    public $detailRequests;
    public $detailBranches;

    public function __construct($actionType, $header, array $details, array $detailBranches) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->details = $details;
        $this->detailRequests = array();
        $this->detailBranches = $detailBranches;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(purchase_order_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(purchase_order_no, '/', 2), '/', -1), '.', -1)";
        $transactionPurchaseOrder = TransactionPurchaseOrder::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND main_branch_id = :main_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':main_branch_id' => $requesterBranchId),
        ));

        if ($transactionPurchaseOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionPurchaseOrder->mainBranch->code;
            $this->header->purchase_order_no = $transactionPurchaseOrder->purchase_order_no;
        }

        $this->header->setCodeNumberByNext('purchase_order_no', $branchCode, TransactionPurchaseOrder::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($productId) {
        
        $product = Product::model()->findByPK($productId);
        
        $exist = false;
        foreach ($this->details as $i => $detail) {
            if ($product->id === $detail->product_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $detail = new TransactionPurchaseOrderDetail();
            $detail->product_id = $productId;
            $detail->unit_id = $product->unit_id;
            $detail->retail_price = $product->retail_price;
            $detail->hpp = $product->hpp;

            $this->details[] = $detail;
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function removeDetailSupplier() {
        $this->details = array();
    }

    public function addBranch($branchId) {

        $exist = FALSE;
        
        $branch = Branch::model()->findByPk($branchId);

        if ($branch != null) {
            foreach ($this->detailBranches as $detail) {
                if ($detail->branch_id == $branch->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new TransactionPurchaseOrderDestinationBranch;
                $detail->branch_id = $branchId;
                $this->detailBranches[] = $detail;
            }
        } else {
            $this->header->addError('error', 'Branch tidak ada di dalam detail');
        }
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
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('price');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
        $this->setSummaryValues();
        $isNewRecord = $this->header->isNewRecord;
        
        if ($isNewRecord) {
            $this->header->payment_amount = 0;
            $this->header->payment_left = $this->grandTotal;
        }
        $valid = $this->header->save();
        
        $purchaseDetails = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $this->header->id));

        $detail_id = array();
        foreach ($purchaseDetails as $purchaseDetail) {
            $detail_id[] = $purchaseDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->purchase_order_id = $this->header->id;

            if ($isNewRecord) {
                $detail->receive_quantity = 0;
                $detail->purchase_order_quantity_left = $detail->total_quantity;
            } else {
                $detail->receive_quantity = $detail->getQuantityReceiveTotal();
                $detail->purchase_order_quantity_left = $detail->getQuantityReceiveRemaining();
            }

            $valid = $detail->save(false) && $valid;

            if (isset($_POST['TransactionPurchaseOrderDetailRequest'][$detail->product_id])) {
                $allRequest = TransactionPurchaseOrderDetailRequest::model()->deleteAll('`purchase_order_detail_id` = :purchase_order_detail_id', array(':purchase_order_detail_id' => $detail->id,));
                $allOrdered = TransactionDetailOrder::model()->deleteAll('`purchase_order_detail_id` = :purchase_order_detail_id', array(':purchase_order_detail_id' => $detail->id,));
                foreach ($_POST['TransactionPurchaseOrderDetailRequest'][$detail->product_id] as $key => $detailOrder) {
                    $detailRequest = new TransactionPurchaseOrderDetailRequest();
                    $detailRequest->purchase_order_detail_id = $detail->id;
                    $detailRequest->purchase_request_id = $detailOrder['purchase_request_id'];
                    $detailRequest->purchase_request_detail_id = $detailOrder['purchase_request_detail_id'];
                    $detailRequest->purchase_request_quantity = $detailOrder['purchase_request_quantity'];
                    $detailRequest->estimate_date_arrival = $detailOrder['estimate_date_arrival'];
                    $detailRequest->purchase_request_branch_id = $detailOrder['purchase_request_branch_id'];
                    $detailRequest->purchase_order_quantity = $detailOrder['purchase_order_quantity'];
                    $detailRequest->notes = $detailOrder['notes'];
                    $detailRequest->save();

                    $criteria = new CDbCriteria;
                    $criteria->condition = "id =" . $detailRequest->id . " AND purchase_request_detail_id = " . $detailRequest->purchase_request_detail_id;
                    $detailOrders = TransactionPurchaseOrderDetailRequest::model()->findAll($criteria);
                    $quantity = 0;
                    
                    foreach ($detailOrders as $detailOrder) {
                        $quantity += $detailOrder->purchase_order_quantity;
                    }
                    
                    $purchaseRequestDetail = TransactionRequestOrderDetail::model()->findByPk($detailRequest->purchase_request_detail_id);
                    $purchaseRequestDetail->purchase_order_quantity = $quantity + $detailRequest->purchase_order_quantity;
                    $purchaseRequestDetail->request_order_quantity_rest = $purchaseRequestDetail->quantity - ($quantity + $detailRequest->purchase_order_quantity);
                    $purchaseRequestDetail->save(false);
                }
            }

            $new_detail[] = $detail->id;
        }

        foreach ($this->detailBranches as $detailBranch) {
            $detailBranch->purchase_order_id = $this->header->id;
            $valid = $detailBranch->save(false) && $valid;
        }
        
        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionPurchaseOrderDetail::model()->deleteAll($criteria);
        }
        
        $this->saveTransactionLog();
        
        return $valid;
    }

    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->purchase_order_no;
        $transactionLog->transaction_date = $this->header->purchase_order_date;
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
        
        $newData['transactionPurchaseOrderDetails'] = array();
        foreach($this->details as $detail) {
            $newData['transactionPurchaseOrderDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
    
    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->quantityAfterBonus;
        }

        return $total;
    }

    public function getSubTotalDiscount() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->totalDiscount;
        }

        return $total;
    }

    public function getSubTotalBeforeDiscount() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->totalBeforeDiscount;
        }

        return $total;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->total_before_tax; //$detail->getTotalPriceBeforeTax($this->header->ppn, $this->header->tax_percentage);
        }

        return $total;
    }

    public function getTaxAmount() {

        return round($this->subTotal * $this->header->tax_percentage / 100, 2);
    }

    public function getGrandTotal() {
//        $total = 0.00;

//        foreach ($this->details as $detail) {
//            $total += $detail->getSubTotal($this->header->ppn, $this->header->tax_percentage);
//        }

        return $this->subTotal + $this->taxAmount;
    }
    
    public function setSummaryValues() {
        $tax = $this->header->ppn;
        $taxPercentage = $this->header->tax_percentage;
        
        foreach ($this->details as $detail) {
            $detail->unit_price = $detail->getUnitPrice($tax, $taxPercentage);
            $detail->total_price = $detail->getSubTotal($tax, $taxPercentage);
            $detail->tax_amount = $detail->getTaxAmount($tax, $taxPercentage);
            $detail->price_before_tax = $detail->getPriceBeforeTax($tax, $taxPercentage);
            $detail->total_before_tax = $detail->getTotalPriceBeforeTax();
            $detail->total_quantity = $detail->quantityAfterBonus;
            $detail->discount = $detail->totalDiscount;
        }
        
        $this->header->total_quantity = $this->totalQuantity;
        $this->header->price_before_discount = $this->subTotalBeforeDiscount;
        $this->header->discount = $this->subTotalDiscount;
        $this->header->subtotal = $this->subTotal;
        $this->header->ppn_price = $this->taxAmount;
        $this->header->total_price = $this->grandTotal;
    }
}
