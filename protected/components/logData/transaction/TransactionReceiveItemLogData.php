<?php

class TransactionReceiveItemLogData  {
    
    public static function make($rootData) {
        $newData = array();
        foreach ($rootData as $headerFieldName => $headerFieldValue) {
            switch ($headerFieldName) {
                case 'id':
                    break;
                case 'invoice_sub_total':
                    $newData['invoice_sub_total'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'invoice_tax_nominal':
                    $newData['invoice_tax_nominal'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'invoice_grand_total':
                    $newData['invoice_grand_total'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'invoice_rounding_nominal':
                    $newData['invoice_rounding_nominal'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'invoice_grand_total_rounded':
                    $newData['invoice_grand_total_rounded'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'destination_branch':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['destination_branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'coa_id':
                    $coa = Coa::model()->findByPk($headerFieldValue);
                    $newData['coa'] = $coa === null ? '' : $coa->name;
                    break;
                case 'payment_type_id':
                    $paymentType = PaymentType::model()->findByPk($headerFieldValue);
                    $newData['payment_type'] = $paymentType === null ? '' : $paymentType->name;
                    break;
                case 'supplier_id':
                    $supplier = Supplier::model()->findByPk($headerFieldValue);
                    $newData['supplier'] = $supplier === null ? '' : $supplier->name;
                    break;
                case 'purchase_order_id':
                    $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($headerFieldValue);
                    $newData['purchase_order'] = $purchaseOrder === null ? '' : $purchaseOrder->purchase_order_no;
                    break;
                case 'transfer_request_id':
                    $transferRequest = TransactionTransferRequest::model()->findByPk($headerFieldValue);
                    $newData['transfer_request'] = $transferRequest === null ? '' : $transferRequest->transafer_request_no;
                    break;
                case 'consignment_in_id':
                    $consignmentIn = ConsignmentInHeader::model()->findByPk($headerFieldValue);
                    $newData['consignment_in'] = $consignmentIn === null ? '' : $consignmentIn->consignment_in_number;
                    break;
                case 'delivery_order_id':
                    $deliveryOrder = TransactionDeliveryOrder::model()->findByPk($headerFieldValue);
                    $newData['delivery_order'] = $deliveryOrder === null ? '' : $deliveryOrder->delivery_order_no;
                    break;
                case 'movement_out_id':
                    $movementOut = MovementOutHeader::model()->findByPk($headerFieldValue);
                    $newData['movement_out'] = $movementOut === null ? '' : $movementOut->movement_out_no;
                    break;
                case 'user_id_receive':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_receive'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_invoice':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_invoice'] = $user === null ? '' : $user->username;
                    break;
                case 'recipient_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['recipient'] = $user === null ? '' : $user->username;
                    break;
                case 'recipient_branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['recipient_branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'user_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_created'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_updated':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_updated'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_approval_invoice':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_approval_invoice'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'is_approved_invoice':
                    $invoiceApproval = '';
                    if ($headerFieldValue == 1) {
                        $invoiceApproval = 'Approved';
                    } else {
                        $invoiceApproval = 'Draft';
                    }
                    $newData['approved_invoice'] = $invoiceApproval;
                    break;
                case 'transactionReceiveItemDetails':
                    $newData['transactionReceiveItemDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'receive_item_id':
                                    break;
                                case 'product_id':
                                    $detailNewData['product_name'] = Product::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'total_price':
                                    $detailNewData['total_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['transactionReceiveItemDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
