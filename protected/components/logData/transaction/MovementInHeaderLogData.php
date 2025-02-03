<?php

class MovementInHeaderLogData  {
    
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
                case 'receive_item_id':
                    $transactionReceiveItem = TransactionReceiveItem::model()->findByPk($headerFieldValue);
                    $newData['receive_item'] = $transactionReceiveItem === null ? '' : $transactionReceiveItem->receive_item_no;
                    break;
                case 'return_item_id':
                    $transactionReturnItem = TransactionReturnItem::model()->findByPk($headerFieldValue);
                    $newData['return_item'] = $transactionReturnItem === null ? '' : $transactionReturnItem->return_item_no;
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
                case 'movementInDetails':
                    $newData['movementInDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'id':
                                case 'movement_in_header_id':
                                    break;
                                case 'product_id':
                                    $detailNewData['product_name'] = Product::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'warehouse_id':
                                    $detailNewData['warehouse_name'] = Warehouse::model()->findByPk($detailFieldValue)->name;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['movementInDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
