<?php

class TransactionSentRequestLogData  {
    
    public static function make($rootData) {
        $newData = array();
        foreach ($rootData as $headerFieldName => $headerFieldValue) {
            switch ($headerFieldName) {
                case 'id':
                    break;
                case 'requester_branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['branch_request'] = $branch === null ? '' : $branch->name;
                    break;
                case 'destination_branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['destination_branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'requester_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_requested'] = $user === null ? '' : $user->username;
                    break;
                case 'approved_by':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_approved'] = $user === null ? '' : $user->username;
                    break;
                case 'destination_approved_by':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_destination_approved'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_updated':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_updated'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['user_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'transactionSentRequestDetails':
                    $newData['transactionSentRequestDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'id':
                                case 'sent_request_id':
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
                        $newData['transactionSentRequestDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
