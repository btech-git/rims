<?php

class Invoices extends CComponent {

    public $header;
    public $details;

    // /public $detailApprovals;
    // public $picPhoneDetails;
    // public $picMobileDetails;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;

        //$this->detailApprovals = $detailApprovals;
    }

    public function addDetail($requestType, $requestId) {

        if ($requestType == 1) {
            //$purchaseOrder = TransactionPurchaseOrder::model()->findByPk($requestId);
            $saleOrders = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $requestId));
            foreach ($saleOrders as $key => $saleOrder) {
                $detail = new InvoiceDetail();
                $detail->product_id = $saleOrder->product_id;
                $detail->quantity = $salesOrder->quantity;
                $detail->unit_price = $salesOrder->unit_price;
                $detai->total_price = $salesOrder->total_price;
                $this->details[] = $detail;
            } //endforeach
        }//end if
        elseif ($requestType == 2) {

            $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $requestId));
            if (count($registrationProducts) != 0) {
                foreach ($registrationProducts as $key => $registrationProduct) {
                    $detail = new InvoiceDetail();
                    $detail->product_id = $delivery->product_id;
                    $detail->quantity = $registrationProduct->quantity;
                    $detail->unit_price = $registrationProduct->sale_price;
                    $detail->total_price = $registrationProduct->total_price;
                    $this->details[] = $detail;
                }
            }
            $registrationServices = registrationService::model()->findAllByAttributes(array('registration_transaction_id' => $requestId));
            if (count($registrationServices) != 0) {
                foreach ($registrationServices as $key => $registrationService) {
                    $detail = new InvoiceDetail();
                    $detail->invoice_id = $model->id;
                    $detail->service_id = $registrationService->service_id;
                    $detail->unit_price = $registrationService->price;
                    $detail->total_price = $registrationService->total_price;
                    $this->details[] = $detail;
                }
            }
            $registrationQuickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $id));
            if (count($registrationQuickServices) != 0) {
                foreach ($registrationQuickServices as $registrationQuickService) {
                    $detail = new InvoiceDetail();
                    $detail->invoice_id = $model->id;
                    $detail->quick_service_id = $registrationQuickService->quick_service_id;
                    $detail->unit_price = $registrationQuickService->price;
                    $detail->total_price = $registrationQuickService->price;
                    $this->details[] = $detail;
                }
            }
        }



        //echo "5";
    }

    public function removeDetailAt() {
        //array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
        $this->details = array();
    }

    public function removeDetail($index) {
        array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
        //$this->details = array();
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
                //print_r('1');
            } else {
                $dbTransaction->rollback();
                //print_r('2');
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            //print_r($e);
        }

        return $valid;
        //print_r('success');
    }

    public function validate() {
        $valid = $this->header->validate();


        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {

                $fields = array('unit_price');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }




        //print_r($valid);
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
//        $isNewRecord = $this->header->isNewRecord;
        $this->header->payment_date_estimate = $this->header->due_date;
        $valid = $this->header->save();

        $invoiceDetails = InvoiceDetail::model()->findAllByAttributes(array('invoice_id' => $this->header->id));
        $detail_id = array();
        foreach ($invoiceDetails as $invoiceDetail) {
            $detail_id[] = $invoiceDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->invoice_id = $this->header->id;
            $valid = $detail->save() && $valid;
            $new_detail[] = $detail->id;
        }

        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            InvoiceDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }

}