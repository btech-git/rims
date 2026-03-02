<?php

class WorkOrderExpenseHeaderLogData  {
    
    public static function make($rootData) {
        $newData = array();
        foreach ($rootData as $headerFieldName => $headerFieldValue) {
            switch ($headerFieldName) {
                case 'id':
                    break;
                case 'grand_total':
                    $newData['grand_total'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'total_payment':
                    $newData['total_payment'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'payment_remaining':
                    $newData['payment_remaining'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'registration_transaction_id':
                    $registrationTransaction = RegistrationTransaction::model()->findByPk($headerFieldValue);
                    $newData['registration_transaction'] = $registrationTransaction === null ? '' : $registrationTransaction->transaction_number;
                    break;
                case 'supplier_id':
                    $supplier = Supplier::model()->findByPk($headerFieldValue);
                    $newData['supplier'] = $supplier === null ? '' : $supplier->name;
                    break;
                case 'branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'user_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_created'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'workOrderExpenseDetails':
                    $newData['workOrderExpenseDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'work_order_expense_header_id':
                                    break;
                                case 'amount':
                                    $detailNewData['amount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['workOrderExpenseDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
