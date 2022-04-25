<?php

class Customers extends CComponent {

    public $header;
    public $phoneDetails;
    public $mobileDetails;
    public $picDetails;
    public $vehicleDetails;
    public $serviceDetails;

    public function __construct($header, array $phoneDetails, array $mobileDetails, array $picDetails, array $vehicleDetails, array $serviceDetails) {
        $this->header = $header;
        $this->phoneDetails = $phoneDetails;
        $this->mobileDetails = $mobileDetails;
        $this->picDetails = $picDetails;
        $this->vehicleDetails = $vehicleDetails;
        $this->serviceDetails = $serviceDetails;
    }

    public function addDetail() {
        $phoneDetail = new CustomerPhone();
        $this->phoneDetails[] = $phoneDetail;
    }

    public function addMobileDetail() {
        $mobileDetail = new CustomerMobile();
        $this->mobileDetails[] = $mobileDetail;
    }

    public function addPicDetail() {
        $picDetail = new CustomerPic();
        $this->picDetails[] = $picDetail;
    }

    public function addVehicleDetail() {
        $vehicleDetail = new Vehicle();
        $this->vehicleDetails[] = $vehicleDetail;
    }

    public function addServiceDetail($serviceId) {
        $service = Service::model()->findByPk($serviceId);
        $serviceDetail = new CustomerServiceRate();
        $serviceDetail->service_type_id = $service->service_type_id;
        $serviceDetail->service_category_id = $service->service_category_id;
        $serviceDetail->service_id = $service->id;
        $this->serviceDetails[] = $serviceDetail;
    }

    public function removeDetailAt($index) {
        array_splice($this->phoneDetails, $index, 1);
    }

    public function removeMobileDetailAt($index) {
        array_splice($this->mobileDetails, $index, 1);
    }

    public function removePicDetailAt($index) {
        array_splice($this->picDetails, $index, 1);
    }

    public function removeVehicleDetailAt($index) {
        array_splice($this->vehicleDetails, $index, 1);
    }

    public function removeServiceDetailAt($index) {
        array_splice($this->serviceDetails, $index, 1);
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        
        if ($this->header->customer_type == 'Company') {
            $customerName = Customer::model()->findByAttributes(array('name' => $this->header->name));
            if (empty($customerName)) {
                $valid = true;
            } else {
                $valid = false;
            }
        }

        if (count($this->phoneDetails) > 0) {
            foreach ($this->phoneDetails as $phoneDetail) {
                $fields = array('phone_no');
                $valid = $phoneDetail->validate($fields) && $valid;
            }
        }

        if (count($this->mobileDetails) > 0) {
            foreach ($this->mobileDetails as $mobileDetail) {
                $fields = array('mobile_no');
                $valid = $mobileDetail->validate($fields) && $valid;
            }
        }

        if (count($this->picDetails) > 0) {
            foreach ($this->picDetails as $picDetail) {
                $fields = array('name', 'address');
                $valid = $picDetail->validate($fields) && $valid;
            }
        }

        if (count($this->vehicleDetails) > 0) {
            foreach ($this->vehicleDetails as $vehicleDetail) {
                $fields = array('plate_number', 'machine_number');
                $valid = $vehicleDetail->validate($fields) && $valid;
            }
        }

        return $valid;
    }

    public function flush() {

        if ($this->header->customer_type == 'Individual') {
            $this->header->coa_id = 1449;
        } else {
            $existingCoa = Coa::model()->findByAttributes(array('coa_sub_category_id' => 8, 'coa_id' => null), array('order' => 'id DESC'));
            $ordinal = substr($existingCoa->code, -3);
            $newOrdinal = $ordinal + 1;
            
            $coa = new Coa;
            $coa->name = $this->header->name;
            $coa->code = '108.00.' . sprintf('%03d', $newOrdinal);
            $coa->coa_category_id = 1;
            $coa->coa_sub_category_id = 8;
            $coa->coa_id = null;
            $coa->normal_balance = 'DEBIT';
            $coa->cash_transaction = 'NO';
            $coa->opening_balance = 0.00;
            $coa->closing_balance = 0.00;
            $coa->debit = 0.00;
            $coa->credit = 0.00;
            $coa->status = null;
            $coa->date = date('Y-m-d');
            $coa->date_approval = date('Y-m-d');
            $coa->is_approved = 1;
            $coa->user_id = Yii::app()->user->id;
            $coa->save();
            
            $this->header->coa_id = $coa->id;
        }

        $valid = $this->header->save();

        $customer_phones = CustomerPhone::model()->findAllByAttributes(array('customer_id' => $this->header->id));
        $phoneId = array();
        foreach ($customer_phones as $customer_phone) {
            $phoneId[] = $customer_phone->id;
        }
        $new_detail = array();

        $customer_mobiles = CustomerMobile::model()->findAllByAttributes(array('customer_id' => $this->header->id));
        $mobileId = array();
        foreach ($customer_mobiles as $customer_mobile) {
            $mobileId[] = $customer_mobile->id;
        }
        $new_mobile = array();

        $customer_pics = CustomerPic::model()->findAllByAttributes(array('customer_id' => $this->header->id));
        $picId = array();
        foreach ($customer_pics as $customer_pic) {
            $picId[] = $customer_pic->id;
        }
        $new_pic = array();

        $customer_vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $this->header->id));
        $vehicleId = array();
        foreach ($customer_vehicles as $customer_vehicle) {
            $vehicleId[] = $customer_vehicle->id;
        }
        $new_vehicle = array();

        $customer_services = CustomerServiceRate::model()->findAllByAttributes(array('customer_id' => $this->header->id));
        $serviceId = array();
        foreach ($customer_services as $customer_service) {
            $serviceId[] = $customer_service->id;
        }
        $new_service = array();

        //phone
        foreach ($this->phoneDetails as $phoneDetail) {
            $phoneDetail->customer_id = $this->header->id;

            $valid = $phoneDetail->save(false) && $valid;
            $new_detail[] = $phoneDetail->id;
        }

        //mobile
        foreach ($this->mobileDetails as $mobileDetail) {
            $mobileDetail->customer_id = $this->header->id;
            $valid = $mobileDetail->save(false) && $valid;
            $new_mobile[] = $mobileDetail->id;
        }

        //pic
        foreach ($this->picDetails as $picDetail) {
            $picDetail->customer_id = $this->header->id;
            $valid = $picDetail->save(false) && $valid;
            $new_pic[] = $picDetail->id;
        }

        //vehicle
        foreach ($this->vehicleDetails as $vehicleDetail) {
            $vehicleDetail->customer_id = $this->header->id;
            $pics = CustomerPic::model()->findByAttributes(array('customer_id' => $this->header->id));
            if (isset($vehicleDetail->customer_pic_id)) {
                $vehicleDetail->customer_pic_id = $pics->id;
            }

            $valid = $vehicleDetail->save(false) && $valid;
            $new_vehicle[] = $vehicleDetail->id;
        }

        //service Price
        foreach ($this->serviceDetails as $serviceDetail) {
            $serviceDetail->customer_id = $this->header->id;

            $valid = $serviceDetail->save(false) && $valid;
            $new_service[] = $serviceDetail->id;
        }

        return $valid;
    }
}