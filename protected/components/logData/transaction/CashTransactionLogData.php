<?php

class CashTransactionLogData  {
    
    public static function make($rootData) {
        $newData = array();
        foreach ($rootData as $headerFieldName => $headerFieldValue) {
            switch ($headerFieldName) {
                case 'id':
                    break;
                case 'debit_amount':
                    $newData['debit_amount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'credit_amount':
                    $newData['credit_amount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'coa_id':
                    $coa = Coa::model()->findByPk($headerFieldValue);
                    $newData['coa'] = $coa === null ? '' : $coa->name;
                    break;
                case 'payment_type_id':
                    $paymentType = PaymentType::model()->findByPk($headerFieldValue);
                    $newData['payment_type'] = $paymentType === null ? '' : $paymentType->name;
                    break;
                case 'user_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_created'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_updated':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_updated'] = $user === null ? '' : $user->username;
                    break;
                case 'cashTransactionDetails':
                    $newData['cashTransactionDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'cash_transaction_id':
                                    break;
                                case 'coa_id':
                                    $detailNewData['coa_name'] = Coa::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'amount':
                                    $detailNewData['amount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['cashTransactionDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
