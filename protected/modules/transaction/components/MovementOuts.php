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

    public function addDetail($detailId, $type) {

        if ($type == 1) {
            $deliveryOrderDetail = TransactionDeliveryOrderDetail::model()->findByPk($detailId);
            
            $exist = false;
            foreach ($this->details as $i => $detail) {
                if ($deliveryOrderDetail->id === $detail->delivery_order_detail_id) {
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $detail = new MovementOutDetail();
                $detail->delivery_order_detail_id = $deliveryOrderDetail->id;
                $detail->product_id = $deliveryOrderDetail->product_id;
                $detail->quantity_transaction = $deliveryOrderDetail->quantity_delivery;
                $this->details[] = $detail;
            }
        } elseif ($type == 2) {
            $returnOrderDetail = TransactionReturnOrderDetail::model()->findByPk($detailId);
            
            $exist = false;
            foreach ($this->details as $i => $detail) {
                if ($returnOrderDetail->id === $detail->return_order_detail_id) {
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $detail = new MovementOutDetail();
                $detail->return_order_detail_id = $returnOrderDetail->id;
                $detail->product_id = $returnOrderDetail->product_id;
                $detail->quantity_transaction = $returnOrderDetail->qty_reject;
                $this->details[] = $detail;
            }
        } elseif ($type == 3) {
            $registrationProduct = RegistrationProduct::model()->findByPk($detailId);
            
            $exist = false;
            foreach ($this->details as $i => $detail) {
                if ($registrationProduct->id === $detail->registration_product_id) {
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $detail = new MovementOutDetail();
                $detail->registration_product_id = $registrationProduct->id;
                $detail->product_id = $registrationProduct->product_id;
                $detail->quantity_transaction = $registrationProduct->quantity;
                $this->details[] = $detail;
            }
        } elseif ($type == 4) {
            $materialRequestDetail = MaterialRequestDetail::model()->findByPk($detailId);
            
            $exist = false;
            foreach ($this->details as $i => $detail) {
                if ($materialRequestDetail->id === $detail->material_request_detail_id) {
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $detail = new MovementOutDetail();
                $detail->material_request_detail_id = $detailId;
                $detail->product_id = $materialRequestDetail->product_id;
                $detail->quantity_transaction = $materialRequestDetail->quantity;
                $this->details[] = $detail;
            }
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

//    public function validateDetailsCount() {
//        $valid = true;
//        
//        if (count($this->details) === 0) {
//            $valid = false;
//            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
//        }
//
//        return $valid;
//    }

    public function flush() {
//        $isNewRecord = $this->header->isNewRecord;
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
                // $moveCriteria = new CDbCriteria();
                // $moveCriteria->condition = "product_id =".$detail->product_id ." AND warehouse_id = ".$detail->warehouse_id . " AND movement_out_header_id = ". $this->header->id ." AND id != ''";
                // $moveDetail = MovementOutDetail::model()->find($moveCriteria);
                $moveDetail = MovementOutDetail::model()->findByAttributes(array('movement_out_header_id' => $this->header->id, 'product_id' => $detail->product_id, 'warehouse_id' => $detail->warehouse_id));
                if (count($moveDetail) != 0) {
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
//				$criteria->together = 'true';
//				$criteria->with = array('movementOutHeader');
                $criteria->condition = "delivery_order_detail_id =" . $detail->delivery_order_detail_id . " AND product_id = " . $detail->product_id;
                $mvmntDetails = MovementOutDetail::model()->findAll($criteria);

                $quantity = 0;
                
                foreach ($mvmntDetails as $mvmntDetail)
                    $quantity += $mvmntDetail->quantity;

                $deliveryDetail = TransactionDeliveryOrderDetail::model()->findByAttributes(array('id' => $detail->delivery_order_detail_id, 'delivery_order_id' => $this->header->delivery_order_id));
                $deliveryDetail->quantity_movement_left = $detail->quantity_transaction - $quantity;
                $deliveryDetail->quantity_movement = $quantity;
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
                
                $deliveryDetail = RegistrationProduct::model()->findByAttributes(array('id' => $detail->registration_product_id, 'registration_transaction_id' => $this->header->registration_transaction_id));
                $deliveryDetail->quantity_movement_left = $detail->quantity_transaction - ($detail->quantity + $quantity);
                $deliveryDetail->quantity_movement = $quantity + $detail->quantity;
                $deliveryDetail->save(false);
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