<?php

class ServiceGroupVehicleModel extends CComponent {

    public $header;
    public $vehicleDetails;
    public $pricelistDetails;

    public function __construct($header, array $vehicleDetails, array $pricelistDetails) {
        $this->header = $header;
        $this->vehicleDetails = $vehicleDetails;
        $this->pricelistDetails = $pricelistDetails;
    }

    public function addVehicleModel($vehicleCarModelId) {

        $exist = FALSE;
        $vehicleCarModel = VehicleCarModel::model()->findByPk($vehicleCarModelId);

        if ($vehicleCarModel != null) {
            foreach ($this->vehicleDetails as $detail) {
                if ($detail->vehicle_car_model_id == $vehicleCarModel->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new ServiceVehicle;
                $detail->vehicle_car_model_id = $vehicleCarModelId;
                $this->vehicleDetails[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Car Model tidak ada di dalam detail');
    }

    public function removeVehicleDetailAt($index) {
        array_splice($this->vehicleDetails, $index, 1);
    }

    public function addService($serviceId) {

        $exist = FALSE;
        $service = Service::model()->findByPk($serviceId);

        if ($service != null) {
            foreach ($this->pricelistDetails as $detail) {
                if ($detail->service_id == $service->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new ServicePricelist;
                $detail->service_id = $serviceId;
                $detail->flat_rate_hour = 0;
                $this->pricelistDetails[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Service tidak ada di dalam detail');
    }

    public function removeServiceDetailAt($index) {
        array_splice($this->pricelistDetails, $index, 1);
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

        if (count($this->vehicleDetails) > 0) {
            foreach ($this->vehicleDetails as $vehicleDetail) {
                $fields = array('vehicle_car_model_id');
                $valid = $vehicleDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->pricelistDetails) > 0) {
            foreach ($this->pricelistDetails as $pricelistDetail) {
                $fields = array('service_id');
                $valid = $pricelistDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save();

        foreach ($this->vehicleDetails as $vehicleDetail) {
            $vehicleDetail->service_group_id = $this->header->id;
            $valid = $valid && $vehicleDetail->save(false);
            
            $vehicleModel = VehicleCarModel::model()->findByAttributes(array('id' => $vehicleDetail->vehicle_car_model_id));
            $vehicleModel->service_group_id = $this->header->id;
            $valid = $valid && $vehicleModel->update(array('service_group_id'));
        }

        foreach ($this->pricelistDetails as $pricelistDetail) {
            $pricelistDetail->service_group_id = $this->header->id;
            $pricelistDetail->standard_flat_rate_per_hour = $this->header->standard_flat_rate;
            $pricelistDetail->price = $this->header->standard_flat_rate * $pricelistDetail->flat_rate_hour;
            $valid = $valid && $pricelistDetail->save(false);
        }

        return $valid;
    }
}