<?php

class PaymentOutComponent extends CComponent {

    public $actionType;
    public $header;
    public $details;
    public $image;

    public function __construct($actionType, $header, array $details, $image) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->details = $details;
        $this->image = $image;
    }

    public function addInvoice($transactionId, $movementType) {

        $exist = FALSE;
        $this->header->movement_type = $movementType;
        
        if ($movementType == 1) {
            $receiveItem = TransactionReceiveItem::model()->findByPk($transactionId);
            
            if ($receiveItem != null) {
                foreach ($this->details as $detail) {
                    if ($detail->receive_item_id == $receiveItem->id) {
                        $exist = TRUE;
                        break;
                    }
                }

                if (!$exist) {
                    $detail = new PayOutDetail;
                    $detail->receive_item_id = $transactionId;
                    $detail->work_order_expense_header_id = null;
                    $detail->total_invoice = $receiveItem->grandTotal;
                    $this->details[] = $detail;
                }
            } else {
                $this->header->addError('error', 'Invoice tidak ada di dalam detail');
            }
        } elseif ($movementType == 2) {
            $workOrderExpense = WorkOrderExpenseHeader::model()->findByPk($transactionId);
            
            if ($workOrderExpense != null) {
                foreach ($this->details as $detail) {
                    if ($detail->work_order_expense_header_id == $workOrderExpense->id) {
                        $exist = TRUE;
                        break;
                    }
                }

                if (!$exist) {
                    $detail = new PayOutDetail;
                    $detail->receive_item_id = null;
                    $detail->work_order_expense_header_id = $transactionId;
                    $detail->total_invoice = $workOrderExpense->grand_total;
                    $this->details[] = $detail;
                }
            } else {
                $this->header->addError('error', 'Invoice tidak ada di dalam detail');
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
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

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;

            foreach ($this->details as $detail)
                $valid = $valid && $detail->delete();

            $valid = $valid && $this->header->delete();

            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validatePaymentType() && $valid;
        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;
        $valid = $this->validatePaymentAmount() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('memo', 'total_invoice');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
        }

        return $valid;
    }

    public function validatePaymentType() {
        $valid = true;
        if ($this->header->payment_type_id == 12 && empty($this->header->coa_id_deposit)) {
            $valid = false;
            $this->header->addError('error', 'COA Deposit harus diisi dulu.');
        } elseif ($this->header->payment_type_id != 12 && empty($this->header->paymentType->coa_id) && empty($this->header->company_bank_id)) {
            $valid = false;
            $this->header->addError('error', 'Company Bank harus diisi dulu.');
        }

        return $valid;
    }

    public function validatePaymentAmount() {
        $valid = true;
        if ($this->totalPayment > $this->totalInvoice) {
            $valid = false;
            $this->header->addError('error', 'Pelunasan tidak dapat melebihi total invoice.');
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

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j) {
                    continue;
                }

                if ($this->header->movement_type == 1 && $this->details[$i]->receive_item_id === $this->details[$j]->receive_item_id) {
                    $valid = false;
                    $this->header->addError('error', 'Invoice tidak boleh sama.');
                    break;
                } elseif ($this->header->movement_type == 2 && $this->details[$i]->work_order_expense_header_id === $this->details[$j]->work_order_expense_header_id) {
                    $valid = false;
                    $this->header->addError('error', 'Invoice tidak boleh sama.');
                    break;
                } else {
                    $valid = true;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        $this->header->payment_type = $this->header->paymentType->name;
        $valid = $this->header->save(false);

        //save Invoice
        $invoices = PayOutDetail::model()->findAllByAttributes(array('payment_out_id' => $this->header->id));
        $invoice_id = array();
        
        foreach ($invoices as $invoice) {
            $invoice_id[] = $invoice->id;
        }
        $new_invoice = array();

        foreach ($this->details as $detail) {
            if ($detail->amount <= 0.00)
                continue;

            if ($detail->isNewRecord) {
                $detail->payment_out_id = $this->header->id;
            }
                
            $detail->total_invoice = empty($detail->receive_item_id) ? $detail->workOrderExpenseHeader->grand_total : $detail->receiveItem->grandTotal;

            $valid = $detail->save(false) && $valid;
            $new_invoice[] = $detail->id;

            if (empty($detail->work_order_expense_header_id)) {
                $receiveItem = TransactionReceiveItem::model()->findByPk($detail->receive_item_id);
                $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($receiveItem->purchase_order_id);
                $purchaseOrder->payment_amount = $purchaseOrder->getTotalPayment();
                $purchaseOrder->payment_left = $purchaseOrder->getTotalRemaining();
                $purchaseOrder->payment_status = $purchaseOrder->payment_left > 0 ? 'Partial Payment' : 'PAID';
                $valid = $purchaseOrder->update(array('payment_amount', 'payment_left', 'payment_status')) && $valid;
            } else {
                $workOrderExpenseHeader = WorkOrderExpenseHeader::model()->findByPk($detail->work_order_expense_header_id);
                $workOrderExpenseHeader->total_payment = $workOrderExpenseHeader->getTotalPayment();
                $workOrderExpenseHeader->payment_remaining = $workOrderExpenseHeader->getRemainingPayment();
                $valid = $workOrderExpenseHeader->update(array('total_payment', 'payment_remaining')) && $valid;
            }
        }

        //delete 
        $delete_invoice_array = array_diff($invoice_id, $new_invoice);
        if ($delete_invoice_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_invoice_array);
            PayOutDetail::model()->deleteAll($criteria);
        }

        foreach ($this->header->images as $file) {
            $contentImage = new PaymentOutImages();
            $contentImage->payment_out_id = $this->header->id;
            $contentImage->is_inactive = PaymentOut::STATUS_ACTIVE;
            $contentImage->extension = $file->extensionName;
            $valid = $contentImage->save(false) && $valid;

            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentOut/' . $contentImage->filename;
            $file->saveAs($originalPath);
        }

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->payment_number;
        $transactionLog->transaction_date = $this->header->payment_date;
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
        
        $newData['payOutDetails'] = array();
        foreach($this->details as $detail) {
            $newData['payOutDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
    
    public function getTotalInvoice() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->total_invoice;
        }
        
        return $total;
    }
    
    public function getTotalPayment() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
}
