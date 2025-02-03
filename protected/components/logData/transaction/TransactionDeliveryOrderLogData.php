<?php

class TransactionDeliveryOrderLogData  {
    
    public static function make($rootData) {
        $newData = array();
        foreach ($rootData as $headerFieldName => $headerFieldValue) {
            switch ($headerFieldName) {
                case 'id':
                    break;
                case 'sender_branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['sender_branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'destination_branch':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['destination_branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'sales_order_id':
                    $transactionSalesOrder = TransactionSalesOrder::model()->findByPk($headerFieldValue);
                    $newData['sale_order'] = $transactionSalesOrder === null ? '' : $transactionSalesOrder->sales_order_no;
                    break;
                case 'sent_request_id':
                    $transactionSentRequest = TransactionSentRequest::model()->findByPk($headerFieldValue);
                    $newData['sent_request'] = $transactionSentRequest === null ? '' : $transactionSentRequest->sent_request_no;
                    break;
                case 'transfer_request_id':
                    $transactionTransferRequest = TransactionTransferRequest::model()->findByPk($headerFieldValue);
                    $newData['transfer_request'] = $transactionTransferRequest === null ? '' : $transactionTransferRequest->transfer_request_no;
                    break;
                case 'consignment_out_id':
                    $consignmentOutHeader = ConsignmentOutHeader::model()->findByPk($headerFieldValue);
                    $newData['consignment_out'] = $consignmentOutHeader === null ? '' : $consignmentOutHeader->consignment_out_no;
                    break;
                case 'customer_id':
                    $customer = Customer::model()->findByPk($headerFieldValue);
                    $newData['customer'] = $customer === null ? '' : $customer->name;
                    break;
                case 'sender_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['send_person'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_updated':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_updated'] = $user === null ? '' : $user->username;
                    break;
                case 'transactionDeliveryOrderDetails':
                    $newData['transactionDeliveryOrderDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'id':
                                case 'delivery_order_id':
                                    break;
                                case 'product_id':
                                    $detailNewData['product_name'] = Product::model()->findByPk($detailFieldValue)->name;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['transactionDeliveryOrderDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
