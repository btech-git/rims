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
            $coaGroupHutang = Coa::model()->findByAttributes(array('coa_sub_category_id' => 15));
            $coaHutang = new Coa;
            $coaHutang->getCodeNumber($coaGroupHutang->coa_sub_category_id);
            $coaHutang->name = 'Hutang ' . $this->header->company;
            $coaHutang->coa_category_id = 3;
            $coaHutang->coa_sub_category_id = 15;
            $coaHutang->coa_id = null;
            $coaHutang->normal_balance = 'KREDIT';
            $coaHutang->cash_transaction = 'NO';
            $coaHutang->opening_balance = 0;
            $coaHutang->closing_balance = 0;
            $coaHutang->debit = 0;
            $coaHutang->credit = 0;
            $coaHutang->status = 'Approved';
            $coaHutang->date = date('Y-m-d');
            $coaHutang->date_approval = date('Y-m-d');
            $coaHutang->time_created = date('H:i:s');
            $coaHutang->time_approval = date('H:i:s');
            $coaHutang->is_approved = 1;
            $coaHutang->user_id = Yii::app()->user->id;
            $coaHutang->user_id_approval = Yii::app()->user->id;
            $coaHutang->save(false);
            
            $coaGroupOutstandingOrder = Coa::model()->findByAttributes(array('coa_sub_category_id' => 16));
            $coaOutstandingOrder = new Coa;
            $coaOutstandingOrder->getCodeNumber($coaGroupOutstandingOrder->coa_sub_category_id);
            $coaOutstandingOrder->name = 'Outstanding Order - ' . $this->header->company;
            $coaOutstandingOrder->coa_category_id = 3;
            $coaOutstandingOrder->coa_sub_category_id = 16;
            $coaOutstandingOrder->coa_id = null;
            $coaOutstandingOrder->normal_balance = 'KREDIT';
            $coaOutstandingOrder->cash_transaction = 'NO';
            $coaOutstandingOrder->opening_balance = 0;
            $coaOutstandingOrder->closing_balance = 0;
            $coaOutstandingOrder->debit = 0;
            $coaOutstandingOrder->credit = 0;
            $coaOutstandingOrder->status = 'Approved';
            $coaOutstandingOrder->date = date('Y-m-d');
            $coaOutstandingOrder->date_approval = date('Y-m-d');
            $coaOutstandingOrder->time_created = date('H:i:s');
            $coaOutstandingOrder->time_approval = date('H:i:s');
            $coaOutstandingOrder->is_approved = 1;
            $coaOutstandingOrder->user_id = Yii::app()->user->id;
            $coaOutstandingOrder->user_id_approval = Yii::app()->user->id;
            $coaOutstandingOrder->save(false);

            $this->header->date_approval = date('Y-m-d');
            $this->header->is_approved = 1;
            $this->header->coa_id = $coaHutang->id;
            $this->header->coa_outstanding_order = $coaOutstandingOrder->id;
        }
        
        $valid = $this->header->save();
        
        $this->header->code = 'S' . $this->header->id;
        $this->header->update(array('code'));

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

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new MasterLog();
        $transactionLog->name = $this->header->name;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $this->header->tableName();
        $transactionLog->table_id = $this->header->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $this->header->attributes;
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
}