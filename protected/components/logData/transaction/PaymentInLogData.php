<?php

class PaymentInLogData  {
    
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
                case 'invoice_id':
                    $invoice = InvoiceHeader::model()->findByPk($headerFieldValue);
                    $newData['invoice'] = $invoice === null ? '' : $invoice->invoice_number;
                    break;
                case 'customer_id':
                    $customer = Customer::model()->findByPk($headerFieldValue);
                    $newData['customer'] = $customer === null ? '' : $customer->name;
                    break;
                case 'vehicle_id':
                    $vehicle = Vehicle::model()->findByPk($headerFieldValue);
                    $newData['vehicle'] = $vehicle === null ? '' : $vehicle->plate_number;
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
                case 'company_bank_id':
                    $companyBank = CompanyBank::model()->findByPk($headerFieldValue);
                    $newData['company_bank'] = $companyBank === null ? '' : $companyBank->bank->name;
                    break;
                case 'payment_type_id':
                    $paymentType = PaymentType::model()->findByPk($headerFieldValue);
                    $newData['payment_type'] = $paymentType === null ? '' : $paymentType->name;
                    break;
                case 'insurance_company_id':
                    $insuranceCompany = InsuranceCompany::model()->findByPk($headerFieldValue);
                    $newData['insurance_company'] = $insuranceCompany === null ? '' : $insuranceCompany->name;
                    break;
                case 'paymentInDetails':
                    $newData['paymentInDetails'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'id':
                                case 'payment_in_id':
                                    break;
                                case 'invoice_header_id':
                                    $detailNewData['invoice'] = InvoiceHeader::model()->findByPk($detailFieldValue)->invoice_number;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['paymentInDetails'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
