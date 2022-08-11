<?php

class PaymentOutComponent extends CComponent {

    public $header;
    public $details;
    public $image;

    public function __construct($header, array $details, $image) {
        $this->header = $header;
        $this->details = $details;
        $this->image = $image;
    }

    public function addInvoice($transactionId, $movementType) {

        $exist = FALSE;
        
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
            } else
                $this->header->addError('error', 'Invoice tidak ada di dalam detail');
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
            } else
                $this->header->addError('error', 'Invoice tidak ada di dalam detail');
        } else {
            $exist;
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
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

        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;
        $valid = $this->validatePaymentAmount() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('memo', 'total_invoice');
                $valid = $detail->validate($fields) && $valid;
            }
        } else
            $valid = false;

        return $valid;
    }

    public function validatePaymentAmount() {
        $valid = true;
        if ($this->header->payment_amount > round($this->totalInvoice)) {
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
                if ($i === $j)
                    continue;

                if ($this->details[$i]->receive_item_id === $this->details[$j]->receive_item_id) {
                    $valid = false;
                    $this->header->addError('error', 'Invoice tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);

        //save Invoice
        $invoices = PayOutDetail::model()->findAllByAttributes(array('payment_out_id' => $this->header->id));
        $invoice_id = array();
        
        foreach ($invoices as $invoice) {
            $invoice_id[] = $invoice->id;
        }
        $new_invoice = array();

        foreach ($this->details as $detail) {
            if ($detail->total_invoice <= 0.00)
                continue;

            if ($detail->isNewRecord) {
                $detail->payment_out_id = $this->header->id;
            } else {
                $detail->total_invoice = $detail->receiveItem->grandTotal;
            }

            $valid = $detail->save(false) && $valid;
            $new_invoice[] = $detail->id;

            $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($detail->receiveItem->purchase_order_id);
            $purchaseOrder->payment_amount = $purchaseOrder->getTotalPayment();
            $purchaseOrder->payment_left = $purchaseOrder->getTotalRemaining();
            $valid = $purchaseOrder->update(array('payment_amount', 'payment_left')) && $valid;
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

//            $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentOut/' . $this->header->id;
//
//            if (!file_exists($dir)) {
//                mkdir($dir, 0777, true);
//            }
//            $path = $dir . '/' . $contentImage->filename;
//            $file->saveAs($path);
//            $picture = Yii::app()->image->load($path);
//            $picture->save();

//            $thumb = Yii::app()->image->load($path);
//            $thumb_path = $dir . '/' . $contentImage->thumbname;
//            $thumb->save($thumb_path);
//
//            $square = Yii::app()->image->load($path);
//            $square_path = $dir . '/' . $contentImage->squarename;
//            $square->save($square_path);
        }

        return $valid;
    }
    
    public function getTotalInvoice() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->receiveItem->grandTotal;
        }
        
        return $total;
    }
}
