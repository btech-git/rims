<?php

class MovementOuts extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
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

        if ($this->header->isNewRecord) {
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
            if ($detail->quantity_stock > 0 && $detail->quantity_stock < $detail->quantity) {
                $valid = false;
                $this->header->addError('error', 'Quantity movement melebihi stok yang ada!');
            }
        }

        return $valid;
    }

    public function flush() {
        
        $this->header->created_datetime = Yii::app()->dateFormatter->format('yyyy-M-dd', strtotime($this->header->created_datetime)) . ' ' . date('H:i:s');
        $this->header->date_posting = Yii::app()->dateFormatter->format('yyyy-M-dd', strtotime($this->header->date_posting)) . ' ' . date('H:i:s');
        $valid = $this->header->save();

        $movementOutDetails = MovementOutDetail::model()->findAllByAttributes(array('movement_out_header_id' => $this->header->id));
        $detail_id = array();
        
        foreach ($movementOutDetails as $movementOutDetail) {
            $detail_id[] = $movementOutDetail->id;
        }
        
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            if ($detail->id == "") {
                $moveDetail = MovementOutDetail::model()->findByAttributes(array('movement_out_header_id' => $this->header->id, 'product_id' => $detail->product_id, 'warehouse_id' => $detail->warehouse_id));
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

            $movementType = $this->header->movement_type;
            if ($movementType == 1) {
                $criteria = new CDbCriteria;
                $criteria->condition = "delivery_order_detail_id =" . $detail->delivery_order_detail_id . " AND product_id = " . $detail->product_id;
                $mvmntDetails = MovementOutDetail::model()->findAll($criteria);

                $quantity = 0;
                
                foreach ($mvmntDetails as $mvmntDetail) {
                    $quantity += $mvmntDetail->quantity;
                }

                $deliveryDetail = TransactionDeliveryOrderDetail::model()->findByAttributes(array('id' => $detail->delivery_order_detail_id, 'delivery_order_id' => $this->header->delivery_order_id));
                $deliveryDetail->quantity_movement_left = $deliveryDetail->quantity_delivery - $quantity;
                $deliveryDetail->quantity_movement = $quantity;
                $deliveryDetail->quantity_receive = 0;
                $deliveryDetail->quantity_receive_left = $quantity;
                $deliveryDetail->save(false);
            } elseif ($movementType == 2) {
                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('movementOutHeader');
                $criteria->condition = "movementOutHeader.return_order_id =" . $this->header->return_order_id . " AND movement_out_header_id != " . $this->header->id;
                $mvmntDetails = MovementOutDetail::model()->findAll($criteria);
                $quantity = 0;
                
                foreach ($mvmntDetails as $mvmntDetail) {
                    $quantity += $mvmntDetail->quantity;
                }
                
                $deliveryDetail = TransactionReturnOrderDetail::model()->findByAttributes(array('id' => $detail->return_order_detail_id, 'return_order_id' => $this->header->return_order_id));
                $deliveryDetail->quantity_movement_left = $detail->quantity_transaction - ($detail->quantity + $quantity);
                $deliveryDetail->quantity_movement = $quantity + $detail->quantity;
                $deliveryDetail->save(false);
            } elseif ($movementType == 3) {
                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('movementOutHeader');
                $criteria->condition = "movementOutHeader.registration_transaction_id =" . $this->header->registration_transaction_id . " AND movement_out_header_id != " . $this->header->id;
                $mvmntDetails = MovementOutDetail::model()->findAll($criteria);
                $quantity = 0;
                
                foreach ($mvmntDetails as $mvmntDetail) {
                    $quantity += $mvmntDetail->quantity;
                }
                
                $registrationProduct = RegistrationProduct::model()->findByAttributes(array('id' => $detail->registration_product_id, 'registration_transaction_id' => $this->header->registration_transaction_id));
                $registrationProduct->quantity_movement = $registrationProduct->getTotalMovementOutQuantity();
                $registrationProduct->quantity_movement_left = $registrationProduct->quantity - $registrationProduct->quantity_movement;
                $registrationProduct->save(false);
            } elseif ($movementType == 4) {
                
                $materialRequestDetail = MaterialRequestDetail::model()->findByPk($detail->material_request_detail_id);
                $materialRequestDetail->quantity_movement_out = $materialRequestDetail->getTotalQuantityMovementOut();
                $materialRequestDetail->quantity_remaining = $materialRequestDetail->quantity - $materialRequestDetail->quantity_movement_out;
                $materialRequestDetail->update(array('quantity_movement_out', 'quantity_remaining'));
                
                $materialRequestHeader = MaterialRequestHeader::model()->findByPk($materialRequestDetail->material_request_header_id);
                $materialRequestHeader->total_quantity_movement_out = $materialRequestHeader->getTotalQuantityMovementOut();
                $materialRequestHeader->total_quantity_remaining = $materialRequestHeader->total_quantity - $materialRequestHeader->total_quantity_movement_out;
                $materialRequestHeader->status_progress = ($materialRequestHeader->total_quantity_remaining > 0) ? 'PARTIAL MOVEMENT' : 'COMPLETED';
                $materialRequestHeader->update(array('total_quantity_movement_out', 'total_quantity_remaining', 'status_progress'));
            }

            $new_detail[] = $detail->id;
            
            if ($detail->id == "") {
                echo $detail->quantity;
            }
        }

        //delete details
        $delete_array = array_diff($detail_id, $new_detail);
        
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            MovementOutDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }
}