<?php

class MovementOutHeaderLogData  {
    
    public static function make($rootData) {
        $newData = array();
        foreach ($rootData as $headerFieldName => $headerFieldValue) {
            switch ($headerFieldName) {
                case 'id':
                    break;
                case 'branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'delivery_order_id':
                    $transactionDeliveryOrder = TransactionDeliveryOrder::model()->findByPk($headerFieldValue);
                    $newData['delivery_order'] = $transactionDeliveryOrder === null ? '' : $transactionDeliveryOrder->delivery_order_no;
                    break;
                case 'return_order_id':
                    $transactionReturnOrder = TransactionReturnOrder::model()->findByPk($headerFieldValue);
                    $newData['return_order'] = $transactionReturnOrder === null ? '' : $transactionReturnOrder->return_order_no;
                    break;
                case 'registration_transaction_id':
                    $registrationTransaction = RegistrationTransaction::model()->findByPk($headerFieldValue);
                    $newData['registration_transaction'] = $registrationTransaction === null ? '' : $registrationTransaction->transaction_number;
                    break;
                case 'material_request_header_id':
                    $materialRequestHeader = MaterialRequestHeader::model()->findByPk($headerFieldValue);
                    $newData['material_request_header'] = $materialRequestHeader === null ? '' : $materialRequestHeader->transaction_number;
                    break;
                case 'user_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_name'] = $user === null ? '' : $user->username;
                    break;
                case 'supervisor_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['supervisor_name'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_updated':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_updated'] = $user === null ? '' : $user->username;
                    break;
                case 'movementOutDetails':
                    $newData['movementOutDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'id':
                                case 'movement_out_header_id':
                                    break;
                                case 'product_id':
                                    $detailNewData['product_name'] = Product::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'warehouse_id':
                                    $detailNewData['warehouse_name'] = Warehouse::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'unit_id':
                                    $detailNewData['unit_name'] = Unit::model()->findByPk($detailFieldValue)->name;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['movementOutDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
