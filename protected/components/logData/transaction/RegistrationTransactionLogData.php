<?php

class RegistrationTransactionLogData  {
    
    public static function make($rootData) {
        $newData = array();
        foreach ($rootData as $headerFieldName => $headerFieldValue) {
            switch ($headerFieldName) {
                case 'id':
                    break;
                case 'subtotal_service':
                    $newData['subtotal_service'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'discount_service':
                    $newData['discount_service'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'total_service_price':
                    $newData['total_service_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'subtotal_product':
                    $newData['subtotal_product'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'discount_product':
                    $newData['discount_product'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'total_product_price':
                    $newData['total_product_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'grand_total':
                    $newData['grand_total'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'subtotal':
                    $newData['subtotal'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'ppn_price':
                    $newData['ppn_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'total_price_package':
                    $newData['total_price_package'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'downpayment_amount':
                    $newData['downpayment_amount'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                    break;
                case 'branch_id':
                    $branch = Branch::model()->findByPk($headerFieldValue);
                    $newData['branch'] = $branch === null ? '' : $branch->name;
                    break;
                case 'customer_id':
                    $customer = Customer::model()->findByPk($headerFieldValue);
                    $newData['customer'] = $customer === null ? '' : $customer->name;
                    break;
                case 'vehicle_id':
                    $vehicle = Vehicle::model()->findByPk($headerFieldValue);
                    $newData['vehicle'] = $vehicle === null ? '' : $vehicle->plate_number;
                    break;
                case 'insurance_company_id':
                    $insuranceCompany = InsuranceCompany::model()->findByPk($headerFieldValue);
                    $newData['insurance_company'] = $insuranceCompany === null ? '' : $insuranceCompany->name;
                    break;
                case 'sale_estimation_header_id':
                    $saleEstimationHeader = SaleEstimationHeader::model()->findByPk($headerFieldValue);
                    $newData['sale_estimation'] = $saleEstimationHeader === null ? '' : $saleEstimationHeader->transaction_number;
                    break;
                case 'user_id':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_created'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_edited':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_created'] = $user === null ? '' : $user->username;
                    break;
                case 'user_id_cancelled':
                    $user = Users::model()->findByPk($headerFieldValue);
                    $newData['username_cancelled'] = $user === null ? '' : $user->username;
                    break;
                case 'employee_id_assign_mechanic':
                    $employee = Employee::model()->findByPk($headerFieldValue);
                    $newData['assigned_mechanic'] = $employee === null ? '' : $employee->name;
                    break;
                case 'employee_id_sales_person':
                    $employee = Employee::model()->findByPk($headerFieldValue);
                    $newData['sales_person'] = $employee === null ? '' : $employee->name;
                    break;
                case 'registrationProducts':
                    $newData['registrationProducts'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'registration_transaction_id':
                                    break;
                                case 'retail_price':
                                    $detailNewData['retail_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'hpp':
                                    $detailNewData['hpp'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'recommended_selling_price':
                                    $detailNewData['recommended_selling_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'sale_price':
                                    $detailNewData['sale_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'total_price':
                                    $detailNewData['total_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'product_id':
                                    $detailNewData['product_name'] = Product::model()->findByPk($detailFieldValue)->name;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['registrationProducts'][] = $detailNewData;
                    }
                    break;
                case 'registrationServices':
                    $newData['registrationServices'] = array();
                    foreach ($headerFieldValue as $i => $detailItems) {
                        $detailNewData = array();
                        foreach ($detailItems as $detailFieldName => $detailFieldValue) {
                            switch ($detailFieldName) {
                                case 'registration_transaction_id':
                                    break;
                                case 'price':
                                    $detailNewData['price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'total_price':
                                    $detailNewData['total_price'] = Yii::app()->numberFormatter->format('#,##0.00', $headerFieldValue);
                                    break;
                                case 'service_id':
                                    $detailNewData['service_name'] = Service::model()->findByPk($detailFieldValue)->name;
                                    break;
                                case 'assign_mechanic_id':
                                    $assignedMechanic = Employee::model()->findByPk($detailFieldValue);
                                    $detailNewData['assigned_mechanic'] = $assignedMechanic === null ? '' : $assignedMechanic->name;
                                    break;
                                case 'start_mechanic_id':
                                    $startMechanic = Employee::model()->findByPk($detailFieldValue);
                                    $detailNewData['start_mechanic'] = $startMechanic === null ? '' : $startMechanic->name;
                                    break;
                                case 'finish_mechanic_id':
                                    $finishMechanic = Employee::model()->findByPk($detailFieldValue);
                                    $detailNewData['finish_mechanic'] = $finishMechanic === null ? '' : $finishMechanic->name;
                                    break;
                                case 'pause_mechanic_id':
                                    $pauseMechanic = Employee::model()->findByPk($detailFieldValue);
                                    $detailNewData['pause_mechanic'] = $pauseMechanic === null ? '' : $pauseMechanic->name;
                                    break;
                                case 'resume_mechanic_id':
                                    $resumeMechanic = Employee::model()->findByPk($detailFieldValue);
                                    $detailNewData['resume_mechanic'] = $resumeMechanic === null ? '' : $resumeMechanic->name;
                                    break;
                                case 'supervisor_id':
                                    $supervisor = Employee::model()->findByPk($detailFieldValue);
                                    $detailNewData['supervisor'] = $supervisor === null ? '' : $supervisor->name;
                                    break;
                                case 'service_type_id':
                                    $detailNewData['service_type'] = ServiceType::model()->findByPk($detailFieldValue)->name;
                                    break;
                                default:
                                    $detailNewData[$detailFieldName] = $detailFieldValue;
                            }
                        }
                        $newData['registrationServices'][] = $detailNewData;
                    }
                    break;
                default:
                    $newData[$headerFieldName] = $headerFieldValue;
            }
        }
        return $newData;
    }
}
