<?php

class SupplierComponent extends CComponent {

    public $header;
    public $bankDetails;
    public $productDetails;

    public function __construct($header, array $bankDetails, array $productDetails) {
        $this->header = $header;
        $this->bankDetails = $bankDetails;
        $this->productDetails = $productDetails;
    }

    public function addBankDetail($bankId) {
        $bankDetail = new SupplierBank();
        $bankDetail->bank_id = $bankId;
        $bank = Bank::model()->findByPk($bankDetail->bank_id);
        $bankDetail->bank_name = $bank->name;
        $this->bankDetails[] = $bankDetail;
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
                $detail = new SupplierProduct;
                $detail->product_id = $productId;
                $this->productDetails[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Invoice tidak ada di dalam detail');
    }

    public function removeBankDetailAt($index) {
        array_splice($this->bankDetails, $index, 1);
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

        if (count($this->bankDetails) > 0) {
            foreach ($this->bankDetails as $bankDetail) {
                $fields = array('account_no', 'account_name');
                $valid = $bankDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function flush() {
        
        if ($this->header->isNewRecord) {
            $coaGroupHutang = Coa::model()->findByAttributes(array('code' => '201.00.000'));
            $coaHutang = new Coa;
            $coaHutang->getCodeNumber($coaGroupHutang->coa_sub_category_id);
            $coaHutang->name = 'Hutang ' . $this->header->company;
            $coaHutang->coa_category_id = $coaGroupHutang->coa_category_id;
            $coaHutang->coa_sub_category_id = $coaGroupHutang->coa_sub_category_id;
            $coaHutang->coa_id = $coaGroupHutang->id;
            $coaHutang->normal_balance = 'KREDIT';
            $coaHutang->cash_transaction = 'NO';
            $coaHutang->opening_balance = 0;
            $coaHutang->closing_balance = 0;
            $coaHutang->debit = 0;
            $coaHutang->credit = 0;
            $coaHutang->status = 'Approved';
            $coaHutang->date = date('Y-m-d');
            $coaHutang->save();
            
            $coaGroupOutstandingOrder = Coa::model()->findByAttributes(array('code' => '202.00.000'));
            $coaOutstandingOrder = new Coa;
            $coaOutstandingOrder->getCodeNumber($coaGroupOutstandingOrder->coa_sub_category_id);
            $coaOutstandingOrder->name = 'Outstanding Order - ' . $this->header->company;
            $coaOutstandingOrder->coa_category_id = $coaGroupOutstandingOrder->coa_category_id;
            $coaOutstandingOrder->coa_sub_category_id = $coaGroupOutstandingOrder->coa_sub_category_id;
            $coaOutstandingOrder->coa_id = $coaGroupOutstandingOrder->id;
            $coaOutstandingOrder->normal_balance = 'KREDIT';
            $coaOutstandingOrder->cash_transaction = 'NO';
            $coaOutstandingOrder->opening_balance = 0;
            $coaOutstandingOrder->closing_balance = 0;
            $coaOutstandingOrder->debit = 0;
            $coaOutstandingOrder->credit = 0;
            $coaOutstandingOrder->status = 'Approved';
            $coaOutstandingOrder->date = date('Y-m-d');
            $coaOutstandingOrder->save();

            $this->header->coa_id = $coaHutang->id;
            $this->header->coa_outstanding_order = $coaOutstandingOrder->id;
        }
        
        $valid = $this->header->save();

        $supplier_banks = SupplierBank::model()->findAllByAttributes(array('supplier_id' => $this->header->id));
        $bankId = array();
        foreach ($supplier_banks as $supplier_bank) {
            $bankId[] = $supplier_bank->id;
        }
        $new_bank = array();

        //Bank
        foreach ($this->bankDetails as $bankDetail) {
            $bankDetail->supplier_id = $this->header->id;
            $valid = $bankDetail->save(false) && $valid;
            $new_bank[] = $bankDetail->id;
        }

        foreach ($this->productDetails as $productDetail) {
            $productDetail->supplier_id = $this->header->id;
                
            $valid = $valid && $productDetail->save(false);
        }

        //delete Bank
        $delete_bank = array_diff($bankId, $new_bank);
        if ($delete_bank != NULL) {
            $bank_criteria = new CDbCriteria;
            $bank_criteria->addInCondition('id', $delete_bank);
            SupplierBank::model()->deleteAll($bank_criteria);
        }

        //delete Product
//        $delete_product = array_diff($productId, $new_product);
//        if ($delete_product != NULL) {
//            $product_criteria = new CDbCriteria;
//            $product_criteria->addInCondition('id', $delete_product);
//            SupplierProduct::model()->deleteAll($product_criteria);
//        }

        return $valid;
    }
}