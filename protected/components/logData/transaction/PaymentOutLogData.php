<?php

class PaymentOutLogData  {
    
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
                case 'purchase_order_id':
                    $transactionPurchaseOrder = TransactionPurchaseOrder::model()->findByPk($headerFieldValue);
                    $newData['purchase_order'] = $transactionPurchaseOrder === null ? '' : $transactionPurchaseOrder->purchase_order_no;
                    break;
                case 'supplier_id':
                    $supplier = Supplier::model()->findByPk($headerFieldValue);
                    $newData['supplier'] = $supplier === null ? '' : $supplier->name;
                    break;
                case 'company_bank_id':
                    $companyBank = CompanyBank::model()->findByPk($headerFieldValue);
                    $newData['company_bank'] = $companyBank === null ? '' : $companyBank->bank->name;
                    break;
                case 'bank_id':
                    $bank = Bank::model()->findByPk($headerFieldValue);
                    $newData['bank'] = $bank === null ? '' : $bank->name;
                    break;
                case 'payment_type_id':
                    $paymentType = PaymentType::model()->findByPk($headerFieldValue);
                    $newData['payment_type'] = $paymentType === null ? '' : $paymentType->name;
                    break;
                case 'coa_id_deposit':
                    $coa = Coa::model()->findByPk($headerFieldValue);
                    $newData['coa_deposit'] = $coa === null ? '' : $coa->name;
                    break;
                case 'user_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_created'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_edited':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_updated'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'payOutDetails':
                    $newData['payOutDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'id':
                                case 'payment_out_id':
                                    break;
                                case 'receive_item_id':
                                    $transactionReceiveItem = TransactionReceiveItem::model()->findByPk($detailFieldValue);
                                    $detailNewData['receive_item'] = $transactionReceiveItem === null ? '' : $transactionReceiveItem->receive_item_no;
                                    break;
                                case 'work_order_expense_header_id':
                                    $workOrderExpenseHeader = WorkOrderExpenseHeader::model()->findByPk($detailFieldValue);
                                    $detailNewData['work_order_expense'] = $workOrderExpenseHeader === null ? '' : $workOrderExpenseHeader->transaction_number;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['payOutDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
