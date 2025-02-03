<?php

class TransactionPurchaseOrderLogData  {
    
    public static function make($rootData) {
        $newData = array();
        foreach ($rootData as $headerFieldName => $headerFieldValue) {
            switch ($headerFieldName) {
                case 'id':
                    break;
                case 'main_branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'supplier_id':
                    $supplier = Supplier::model()->findByPk($headerFieldValue);
                    $newData['supplier'] = $supplier === null ? '' : $supplier->name;
                    break;
                case 'registration_transaction_id':
                    $registrationTransaction = RegistrationTransaction::model()->findByPk($headerFieldValue);
                    $newData['registration_transaction'] = $registrationTransaction === null ? '' : $registrationTransaction->transaction_number;
                    break;
                case 'company_bank_id':
                    $companyBank = CompanyBank::model()->findByPk($headerFieldValue);
                    $newData['company_bank'] = $companyBank === null ? '' : $companyBank->bank->name;
                    break;
                case 'coa_id':
                    $coa = Coa::model()->findByPk($headerFieldValue);
                    $newData['coa'] = $coa === null ? '' : $coa->name;
                    break;
                case 'coa_bank_id_estimate':
                    $coa = Coa::model()->findByPk($headerFieldValue);
                    $newData['coa_bank_estimate'] = $coa === null ? '' : $coa->name;
                    break;
                case 'requester_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_requested'] = $user === null ? '' : $user->username;
                    break;
                case 'approved_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_approved'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_updated':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_updated'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'transactionPurchaseOrderDetails':
                    $newData['transactionPurchaseOrderDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'id':
                                case 'purchase_order_id':
                                    break;
                                case 'product_id':
                                    $detailNewData['product_name'] = Product::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'unit_id':
                                    $detailNewData['unit_name'] = Unit::model()->findByPk($detailFieldValue)->name;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['transactionPurchaseOrderDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
