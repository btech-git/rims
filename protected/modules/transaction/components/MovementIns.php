<?php

class MovementIns extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(movement_in_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(movement_in_number, '/', 2), '/', -1), '.', -1)";
        $movementInHeader = MovementInHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($movementInHeader == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $movementInHeader->branch->code;
            $this->header->movement_in_number = $movementInHeader->movement_in_number;
        }

        $this->header->setCodeNumberByNext('movement_in_number', $branchCode, MovementInHeader::CONSTANT, $currentMonth, $currentYear);
    }

//    public function addDetail($detailId, $type) {
//
//        // $detail = new MovementInDetail();
//        // $this->details[] = $detail;
//        if ($type == 1) {
//            $receiveItemDetail = TransactionReceiveItemDetail::model()->findByPk($detailId);
//            
//            $exist = false;
//            foreach ($this->details as $i => $detail) {
//                if ($receiveItemDetail->id === $detail->receive_item_detail_id) {
//                    $exist = true;
//                    break;
//                }
//            }
//
//            if (!$exist) {
//                $detail = new MovementInDetail();
//                $detail->receive_item_detail_id = $receiveItemDetail->id;
//                $detail->product_id = $receiveItemDetail->product_id;
//                $detail->quantity_transaction = $receiveItemDetail->quantity_movement_left;
//                $this->details[] = $detail;
//            }
//        } else {
//            $returnItemDetail = TransactionReturnItemDetail::model()->findByPk($detailId);
//            
//            $exist = false;
//            foreach ($this->details as $i => $detail) {
//                if ($returnItemDetail->id === $detail->return_item_detail_id) {
//                    $exist = true;
//                    break;
//                }
//            }
//
//            if (!$exist) {
//                $detail = new MovementInDetail();
//                $detail->return_item_detail_id = $returnItemDetail->id;
//                $detail->product_id = $returnItemDetail->product_id;
//                $detail->quantity_transaction = $returnItemDetail->quantity_delivery;
//                $this->details[] = $detail;
//            }
//        }
//    }

    public function addDetails($transactionId, $movementType) {

        if ($movementType == 1) {
            $receiveItem = TransactionReceiveItem::model()->findByPk($transactionId);

            if ($receiveItem !== null) {
                foreach ($receiveItem->transactionReceiveItemDetails as $receiveItemDetail) {
                    if ($receiveItemDetail->quantity_movement_left > 0) {

                        $detail = new MovementInDetail();
                        $detail->receive_item_detail_id = $receiveItemDetail->id;
                        $detail->return_item_detail_id = null;
                        $detail->product_id = $receiveItemDetail->product_id;
                        $detail->quantity_transaction = $receiveItemDetail->quantity_movement_left;
                        $this->details[] = $detail;
                    }
                }
            }
        } else if ($movementType == 2) {
            $returnItem = TransactionReturnItem::model()->findByPk($transactionId);

            if ($returnItem !== null) {
                foreach ($returnItem->transactionReturnItemDetails as $returnDetail) {
                    if ($receiveItemDetail->quantity_movement_left > 0) {

                        $detail = new MovementInDetail();
                        $detail->receive_item_detail_id = null;
                        $detail->return_item_detail_id = $returnDetail->id;
                        $detail->product_id = $returnDetail->product_id;
                        $detail->quantity_transaction = $returnDetail->quantity_movement_left;
                        $this->details[] = $detail;
                    }
                }
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

    public function flush() {

        $valid = $this->header->save();

        $movementInDetails = MovementInDetail::model()->findAllByAttributes(array('movement_in_header_id' => $this->header->id));
        $detail_id = array();
        foreach ($movementInDetails as $movementInDetail) {
            $detail_id[] = $movementInDetail->id;
        }
        
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {

            if ($detail->id == "") {
                $moveDetail = MovementInDetail::model()->findByAttributes(array('movement_in_header_id' => $this->header->id, 'product_id' => $detail->product_id, 'warehouse_id' => $detail->warehouse_id));
                if (!empty($moveDetail)) {
                    $moveDetail->quantity += $detail->quantity;
                    $moveDetail->save() && $valid;
                } else {
                    if ($detail->quantity > 0) {
                        $detail->movement_in_header_id = $this->header->id;
                        $valid = $detail->save(false) && $valid;
                    }
                }
            } else {
                $detail->movement_in_header_id = $this->header->id;
                $valid = $detail->save(false) && $valid;
            }

            if ($this->header->movement_type == 1) {
                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('movementInHeader');
                $criteria->condition = "movementInHeader.receive_item_id =" . $this->header->receive_item_id . " AND movement_in_header_id != " . $this->header->id;
                $mvmntDetails = MovementInDetail::model()->findAll($criteria);
                $quantity = 0;
                
                foreach ($mvmntDetails as $mvmntDetail) {
                    $quantity += $mvmntDetail->quantity;
                }
                
                $receiveDetail = TransactionReceiveItemDetail::model()->findByAttributes(array('id' => $detail->receive_item_detail_id, 'receive_item_id' => $this->header->receive_item_id));
                $receiveDetail->quantity_movement_left = $detail->quantity_transaction - ($detail->quantity + $quantity);
                $receiveDetail->quantity_movement = $quantity + $detail->quantity;
                $receiveDetail->save(false);
            } else {
                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('movementInHeader');
                $criteria->condition = "movementInHeader.return_item_id =" . $this->header->return_item_id . " AND movement_in_header_id != " . $this->header->id;
                $mvmntDetails = MovementInDetail::model()->findAll($criteria);
                $quantity = 0;
                
                foreach ($mvmntDetails as $mvmntDetail) {
                    $quantity += $mvmntDetail->quantity;
                }
                
                $receiveDetail = TransactionReturnItemDetail::model()->findByAttributes(array('id' => $detail->return_item_detail_id, 'return_item_id' => $this->header->return_item_id));
                $receiveDetail->quantity_movement_left = $detail->quantity_transaction - ($detail->quantity + $quantity);
                $receiveDetail->quantity_movement = $quantity + $detail->quantity;
                $receiveDetail->save(false);
            }

            $new_detail[] = $detail->id;
        }

        //delete details
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            MovementInDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }
}