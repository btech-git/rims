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
                case 'destination_branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['destination_branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'supplier_id':
                    $supplier = Supplier::model()->findByPk($headerFieldValue);
                    $newData['supplier'] = $supplier === null ? '' : $supplier->name;
                    break;
                case 'purchase_type':
                    $purchaseType = '';
                    if ($headerFieldValue == 1) {
                        $purchaseType = 'Spare Part';
                    } else if ($headerFieldValue == 2) {
                        $purchaseType = 'Ban';
                    } else if ($headerFieldValue == 3) {
                        $purchaseType = 'Umum';
                    } else {
                        $purchaseType = 'N/A';
                    }
                    $newData['purchase_type'] = $purchaseType;
                    break;
                case 'price_before_discount':
                    $newData['price_before_discount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'discount':
                    $newData['discount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'subtotal':
                    $newData['subtotal'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'ppn_price':
                    $newData['ppn_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'total_price':
                    $newData['total_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'payment_amount':
                    $newData['payment_amount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'payment_left':
                    $newData['payment_left'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
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
                                case 'purchase_order_id':
                                    break;
                                case 'product_id':
                                    $detailNewData['product_name'] = Product::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'unit_id':
                                    $detailNewData['unit_name'] = Unit::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'retail_price':
                                    $detailNewData['retail_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'unit_price':
                                    $detailNewData['unit_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'tax_amount':
                                    $detailNewData['tax_amount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'price_before_tax':
                                    $detailNewData['price_before_tax'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'total_price':
                                    $detailNewData['total_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'average_sale_amount':
                                    $detailNewData['average_sale_amount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'discount1_type':
                                    $discountType = '';
                                    if ($detailFieldValue == 1) {
                                        $discountType = 'Percentage';
                                    } else if ($detailFieldValue == 2) {
                                        $discountType = 'Nominal';
                                    } else {
                                        $discountType = 'N/A';
                                    }
                                    $detailNewData['discount1_type'] = $discountType;
                                    break;
                                case 'discount2_type':
                                    $discountType = '';
                                    if ($detailFieldValue == 1) {
                                        $discountType = 'Percentage';
                                    } else if ($detailFieldValue == 2) {
                                        $discountType = 'Nominal';
                                    } else {
                                        $discountType = 'N/A';
                                    }
                                    $detailNewData['discount2_type'] = $discountType;
                                    break;
                                case 'discount3_type':
                                    $discountType = '';
                                    if ($detailFieldValue == 1) {
                                        $discountType = 'Percentage';
                                    } else if ($detailFieldValue == 2) {
                                        $discountType = 'Nominal';
                                    } else {
                                        $discountType = 'N/A';
                                    }
                                    $detailNewData['discount3_type'] = $discountType;
                                    break;
                                case 'discount4_type':
                                    $discountType = '';
                                    if ($detailFieldValue == 1) {
                                        $discountType = 'Percentage';
                                    } else if ($detailFieldValue == 2) {
                                        $discountType = 'Nominal';
                                    } else {
                                        $discountType = 'N/A';
                                    }
                                    $detailNewData['discount4_type'] = $discountType;
                                    break;
                                case 'discount5_type':
                                    $discountType = '';
                                    if ($detailFieldValue == 1) {
                                        $discountType = 'Percentage';
                                    } else if ($detailFieldValue == 2) {
                                        $discountType = 'Nominal';
                                    } else {
                                        $discountType = 'N/A';
                                    }
                                    $detailNewData['discount5_type'] = $discountType;
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
