<?php

class MovementOuts extends CComponent {

    public $actionType;
    public $header;
    public $details;

    public function __construct($actionType, $header, array $details) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(movement_out_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(movement_out_no, '/', 2), '/', -1), '.', -1)";
        
        $movementOutHeader = MovementOutHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($movementOutHeader == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $movementOutHeader->branch->code;
            $this->header->movement_out_no = $movementOutHeader->movement_out_no;
        }

        $this->header->setCodeNumberByNext('movement_out_no', $branchCode, MovementOutHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetails($transactionId, $movementType) {

        if ($movementType == 1) {
            $deliveryOrder = TransactionDeliveryOrder::model()->findByPk($transactionId);

            if ($deliveryOrder !== null) {
                foreach ($deliveryOrder->transactionDeliveryOrderDetails as $deliveryDetail) {
                    if ($deliveryDetail->quantity_movement_left > 0) {
                        $warehouseBranchProductCategory = WarehouseBranchProductCategory::model()->findByAttributes(array(
                            'branch_id' => $this->header->branch_id, 
                            'product_master_category_id' => $deliveryDetail->product->product_master_category_id
                        ));
                        $inventory = Inventory::model()->findByAttributes(array(
                            'product_id' => $deliveryDetail->product_id, 
                            'warehouse_id' => $warehouseBranchProductCategory->warehouse_id
                        ));
                        $stock = !empty($inventory) ? $inventory->total_stock : 0;
                        $detail = new MovementOutDetail();
                        $detail->material_request_detail_id = null;
                        $detail->registration_service_id = null;
                        $detail->quantity_receive = 0;
                        $detail->quantity_receive_left = 0;
                        $detail->delivery_order_detail_id = $deliveryDetail->id;
                        $detail->return_order_detail_id = null;
                        $detail->registration_product_id = null;
                        $detail->product_id = $deliveryDetail->product_id;
                        $detail->unit_id = $deliveryDetail->product->unit_id;
                        $detail->warehouse_id = $warehouseBranchProductCategory === null ? null : $warehouseBranchProductCategory->warehouse_id;
                        $detail->quantity_transaction = $deliveryDetail->quantity_movement_left;
                        $detail->quantity_stock = $stock;
                        $this->details[] = $detail;
                    }
                }
            }
        } else if ($movementType == 2) {
            $returnOrder = TransactionReturnOrder::model()->findByPk($transactionId);

            if ($returnOrder !== null) {
                foreach ($returnOrder->transactionReturnOrderDetails as $returnDetail) {
                    if ($returnDetail->quantity_movement_left > 0) {
                        $warehouseBranchProductCategory = WarehouseBranchProductCategory::model()->findByAttributes(array(
                            'branch_id' => $this->header->branch_id, 
                            'product_master_category_id' => $returnDetail->product->product_master_category_id
                        ));
                        $inventory = Inventory::model()->findByAttributes(array(
                            'product_id' => $returnDetail->product_id, 
                            'warehouse_id' => $warehouseBranchProductCategory->warehouse_id
                        ));
                        $stock = !empty($inventory) ? $inventory->total_stock : 0;
                        $detail = new MovementOutDetail();
                        $detail->material_request_detail_id = null;
                        $detail->registration_service_id = null;
                        $detail->quantity_receive = 0;
                        $detail->quantity_receive_left = 0;
                        $detail->delivery_order_detail_id = null;
                        $detail->return_order_detail_id = $returnDetail->id;
                        $detail->registration_product_id = null;
                        $detail->product_id = $returnDetail->product_id;
                        $detail->unit_id = $returnDetail->product->unit_id;
                        $detail->warehouse_id = $warehouseBranchProductCategory === null ? null : $warehouseBranchProductCategory->warehouse_id;
                        $detail->quantity_transaction = $returnDetail->quantity_movement_left;
                        $detail->quantity_stock = $stock;
                        $this->details[] = $detail;
                    }
                }
            }
        } else if ($movementType == 3) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($transactionId);

            if ($registrationTransaction !== null) {
                foreach ($registrationTransaction->registrationProducts as $registrationDetail) {
                    if ($registrationDetail->quantity_movement_left > 0) {
                        $warehouseBranchProductCategory = WarehouseBranchProductCategory::model()->findByAttributes(array(
                            'branch_id' => $this->header->branch_id, 
                            'product_master_category_id' => $registrationDetail->product->product_master_category_id
                        ));
                        $inventory = Inventory::model()->findByAttributes(array(
                            'product_id' => $registrationDetail->product_id, 
                            'warehouse_id' => $warehouseBranchProductCategory->warehouse_id
                        ));
                        $stock = !empty($inventory) ? $inventory->total_stock : 0;
                        $detail = new MovementOutDetail();
                        $detail->material_request_detail_id = null;
                        $detail->registration_service_id = null;
                        $detail->quantity_receive = 0;
                        $detail->quantity_receive_left = 0;
                        $detail->delivery_order_detail_id = null;
                        $detail->return_order_detail_id = null;
                        $detail->registration_product_id = $registrationDetail->id;
                        $detail->product_id = $registrationDetail->product_id;
                        $detail->unit_id = $registrationDetail->product->unit_id;
                        $detail->warehouse_id = $warehouseBranchProductCategory === null ? null : $warehouseBranchProductCategory->warehouse_id;
                        $detail->quantity_transaction = $registrationDetail->quantity_movement_left;
                        $detail->quantity_stock = $stock;
                        $this->details[] = $detail;
                    }
                }
            }
        } else if ($movementType == 4) {
            $materialRequest = MaterialRequestHeader::model()->findByPk($transactionId);

            if ($materialRequest !== null) {
                foreach ($materialRequest->materialRequestDetails as $materialRequestDetail) {
                    if ($materialRequestDetail->quantity_remaining > 0) {
                        $warehouseBranchProductCategory = WarehouseBranchProductCategory::model()->findByAttributes(array(
                            'branch_id' => $this->header->branch_id, 
                            'product_master_category_id' => $materialRequestDetail->product->product_master_category_id
                        ));
                        $inventory = Inventory::model()->findByAttributes(array(
                            'product_id' => $materialRequestDetail->product_id, 
                            'warehouse_id' => $warehouseBranchProductCategory->warehouse_id
                        ));
                        $stock = !empty($inventory) ? $inventory->total_stock : 0;
                        $detail = new MovementOutDetail();
                        $detail->material_request_detail_id = null;
                        $detail->registration_service_id = null;
                        $detail->quantity_receive = 0;
                        $detail->quantity_receive_left = 0;
                        $detail->delivery_order_detail_id = null;
                        $detail->return_order_detail_id = null;
                        $detail->material_request_detail_id = $materialRequestDetail->id;
                        $detail->product_id = $materialRequestDetail->product_id;
                        $detail->unit_id = $materialRequestDetail->unit_id;
                        $detail->warehouse_id = $warehouseBranchProductCategory === null ? null : $warehouseBranchProductCategory->warehouse_id;
                        $detail->quantity_transaction = $materialRequestDetail->quantity_remaining;
                        $detail->quantity = $materialRequestDetail->quantity_remaining;
                        $detail->quantity_stock = $stock;
                        $this->details[] = $detail;
                    }
                }
            }
        } else {
            $this->details[] = array();
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function removeDetailAll() {
        $this->details = array();
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

        if ($this->header->isNewRecord && $this->header->movement_type !== 4) {
            $valid = $this->validateDetailsQuantityStock() && $valid;
        }

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsQuantityStock() {
        $valid = true;
        
        foreach ($this->details as $detail) {
            if ($detail->quantity_stock <= 0) {
                $valid = false;
                $this->header->addError('error', 'Quantity stok tidak mencukupi!');
            } else if ($detail->unit_id !== $detail->product->unit_id) {
                $unitConversion = UnitConversion::model()->findByAttributes(array('unit_from_id' => $detail->product->unit_id, 'unit_to_id' => $detail->unit_id));
                if ($unitConversion === null) {
                    $unitConversionFlipped = UnitConversion::model()->findByAttributes(array('unit_from_id' => $detail->unit_id, 'unit_to_id' => $detail->product->unit_id));
                    if ($unitConversionFlipped === null) {
                        $valid = false;
                        $this->header->addError('error', 'Satuan konversi belum ada di database!');
                    } else {
                        if ($detail->quantity_stock < $unitConversionFlipped->multiplier * $detail->quantity) {
                            $valid = false;
                            $this->header->addError('error', 'Quantity movement melebihi stok yang ada!');
                        }
                    }
                } else {
                    if ($unitConversion->multiplier * $detail->quantity_stock < $detail->quantity) {
                        $valid = false;
                        $this->header->addError('error', 'Quantity movement melebihi stok yang ada!');
                    }
                }
            } else {
                if ($detail->quantity_stock < $detail->quantity) {
                    $valid = false;
                    $this->header->addError('error', 'Quantity movement melebihi stok yang ada!');
                }
            }
        }

        return $valid;
    }

    public function flush() {
        
        $valid = $this->header->save();

        $movementOutDetails = MovementOutDetail::model()->findAllByAttributes(array('movement_out_header_id' => $this->header->id));
        $detail_id = array();
        
        foreach ($movementOutDetails as $movementOutDetail) {
            $detail_id[] = $movementOutDetail->id;
        }
        
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            if ($detail->quantity_transaction > 0) {
                if ($detail->id == "") {
                    $moveDetail = MovementOutDetail::model()->findByAttributes(array(
                        'movement_out_header_id' => $this->header->id, 
                        'product_id' => $detail->product_id, 
                        'warehouse_id' => $detail->warehouse_id
                    ));
                    if (!empty($moveDetail)) {
                        $moveDetail->quantity += $detail->quantity;
                        $moveDetail->save() && $valid;
                    } else {
                        $detail->movement_out_header_id = $this->header->id;
                        $valid = $detail->save() && $valid;
                    }
                } else {
                    $detail->movement_out_header_id = $this->header->id;
                    $valid = $detail->save() && $valid;
                }

                $new_detail[] = $detail->id;
            }
        }

        //delete details
        $delete_array = array_diff($detail_id, $new_detail);
        
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            MovementOutDetail::model()->deleteAll($criteria);
        }

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->movement_out_no;
        $transactionLog->transaction_date = $this->header->date_posting;
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
        
        $newData['movementOutDetails'] = array();
        foreach($this->details as $detail) {
            $newData['movementOutDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
}