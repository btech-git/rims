<?php

class InvoiceHeaderLogData  {
    
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
                case 'coa_bank_id_estimate':
                    $coa = Coa::model()->findByPk($headerFieldValue);
                    $newData['coa_estimate'] = $coa === null ? '' : $coa->name;
                    break;
                case 'sales_order_id':
                    $transactionSalesOrder = TransactionSalesOrder::model()->findByPk($headerFieldValue);
                    $newData['sale_order'] = $transactionSalesOrder === null ? '' : $transactionSalesOrder->sale_order_no;
                    break;
                case 'registration_transaction_id':
                    $registrationTransaction = RegistrationTransaction::model()->findByPk($headerFieldValue);
                    $newData['registration_transaction'] = $registrationTransaction === null ? '' : $registrationTransaction->transaction_number;
                    break;
                case 'customer_id':
                    $customer = Customer::model()->findByPk($headerFieldValue);
                    $newData['customer'] = $customer === null ? '' : $customer->name;
                    break;
                case 'vehicle_id':
                    $vehicle = Vehicle::model()->findByPk($headerFieldValue);
                    $newData['vehicle'] = $vehicle === null ? '' : $vehicle->plate_number;
                    break;
                case 'supervisor_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['supervisor_name'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_created'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_edited':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_updated'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_printed':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_printed'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'insurance_company_id':
                    $insuranceCompany = InsuranceCompany::model()->findByPk($headerFieldValue);
                    $newData['insurance_company'] = $insuranceCompany === null ? '' : $insuranceCompany->name;
                    break;
                case 'invoiceDetails':
                    $newData['invoiceDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'id':
                                case 'invoice_id':
                                    break;
                                case 'service_id':
                                    $service = Service::model()->findByPk($detailFieldValue);
                                    $detailNewData['service_name'] = $service === null ? '' : $service->name;
                                    break;
                                case 'product_id':
                                    $product = Product::model()->findByPk($detailFieldValue);
                                    $detailNewData['product_name'] = $product === null ? '' : $product->name;
                                    break;
                                case 'quick_service_id':
                                    $quickService = QuickService::model()->findByPk($detailFieldValue);
                                    $detailNewData['quick_service_name'] = $quickService === null ? '' : $quickService->name;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['invoiceDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
