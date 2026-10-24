<?php

class TireSizeRecommendation extends CComponent {

    public $actionType;
    public $header;
    public $carModelDetails;
    public $premiumOptionDetails;
    public $standardOptionDetails;
    public $economicOptionDetails;

    public function __construct($actionType, $header, array $carModelDetails, array $premiumOptionDetails, array $standardOptionDetails, array $economicOptionDetails) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->carModelDetails = $carModelDetails;
        $this->premiumOptionDetails = $premiumOptionDetails;
        $this->standardOptionDetails = $standardOptionDetails;
        $this->economicOptionDetails = $economicOptionDetails;
    }

    public function addCarModel($carModelId) {

        $vehicleCarModel = VehicleCarModel::model()->findByPk($carModelId);

        $exist = false;
        foreach ($this->carModelDetails as $i => $detail) {
            if ($vehicleCarModel->id === $detail->vehicle_car_model_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $detail = new TireSizeCarModelRecommendation();
            $detail->vehicle_car_model_id = $carModelId;
            $this->carModelDetails[] = $detail;
        }
    }

    public function removeCarModelDetailAt($index) {
        array_splice($this->carModelDetails, $index, 1);
    }

    public function addPremiumOption($subBrandSeriesId) {

        $subBrandSeries = SubBrandSeries::model()->findByPk($subBrandSeriesId);

        $exist = false;
        foreach ($this->premiumOptionDetails as $i => $detail) {
            if ($subBrandSeries->id === $detail->sub_brand_series_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $detail = new TireSizePremiumOption();
            $detail->sub_brand_series_id = $subBrandSeriesId;
            $this->premiumOptionDetails[] = $detail;
        }
    }

    public function removePremiumOptionDetailAt($index) {
        array_splice($this->premiumOptionDetails, $index, 1);
    }

    public function addStandardOption($subBrandSeriesId) {

        $subBrandSeries = SubBrandSeries::model()->findByPk($subBrandSeriesId);

        $exist = false;
        foreach ($this->standardOptionDetails as $i => $detail) {
            if ($subBrandSeries->id === $detail->sub_brand_series_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $detail = new TireSizeStandardOption();
            $detail->sub_brand_series_id = $subBrandSeriesId;
            $this->standardOptionDetails[] = $detail;
        }
    }

    public function removeStandardOptionDetailAt($index) {
        array_splice($this->standardOptionDetails, $index, 1);
    }

    public function addEconomicOption($subBrandSeriesId) {

        $subBrandSeries = SubBrandSeries::model()->findByPk($subBrandSeriesId);

        $exist = false;
        foreach ($this->economicOptionDetails as $i => $detail) {
            if ($subBrandSeries->id === $detail->sub_brand_series_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $detail = new TireSizeEconomicOption();
            $detail->sub_brand_series_id = $subBrandSeriesId;
            $this->economicOptionDetails[] = $detail;
        }
    }

    public function removeEconomicOptionDetailAt($index) {
        array_splice($this->economicOptionDetails, $index, 1);
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->carModelDetails) > 0) {
            foreach ($this->carModelDetails as $detail) {
                $fields = array('vehicle_car_model_id');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
        }

        if (count($this->premiumOptionDetails) > 0) {
            foreach ($this->premiumOptionDetails as $detail) {
                $fields = array('sub_brand_series_id');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
        }

        if (count($this->standardOptionDetails) > 0) {
            foreach ($this->standardOptionDetails as $detail) {
                $fields = array('sub_brand_series_id');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
        }

        if (count($this->economicOptionDetails) > 0) {
            foreach ($this->economicOptionDetails as $detail) {
                $fields = array('sub_brand_series_id');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->carModelDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->carModelDetails);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j) {
                    continue;
                }

                if ($this->carModelDetails[$i]->vehicle_car_model_id === $this->carModelDetails[$j]->vehicle_car_model_id) {
                    $valid = false;
                    $this->header->addError('error', 'Kendaraan tidak boleh sama.');
                    break;
                } else {
                    $valid = true;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);

        foreach ($this->carModelDetails as $i => $detail) {
            if ($detail->isNewRecord) {
                $detail->tire_size_id = $this->header->id;
            }
                
            $valid = $detail->save(false) && $valid;
        }
        
        foreach ($this->premiumOptionDetails as $i => $detail) {
            if ($detail->isNewRecord) {
                $detail->tire_size_id = $this->header->id;
            }
                
            $valid = $detail->save(false) && $valid;
        }
        
        foreach ($this->standardOptionDetails as $i => $detail) {
            if ($detail->isNewRecord) {
                $detail->tire_size_id = $this->header->id;
            }
                
            $valid = $detail->save(false) && $valid;
        }
        
        foreach ($this->economicOptionDetails as $i => $detail) {
            if ($detail->isNewRecord) {
                $detail->tire_size_id = $this->header->id;
            }
                
            $valid = $detail->save(false) && $valid;
        }
        
        $this->saveMasterLog();
        return $valid;
    }
    
    public function saveMasterLog() {
        $masterLog = new MasterLog();
        $masterLog->name = $this->header->tireName;
        $masterLog->log_date = date('Y-m-d');
        $masterLog->log_time = date('H:i:s');
        $masterLog->table_name = $this->header->tableName();
        $masterLog->table_id = $this->header->id;
        $masterLog->user_id = Yii::app()->user->id;
        $masterLog->username = Yii::app()->user->username;
        $masterLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $masterLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $this->header->attributes;
        
        $newData['tireSizeCarModelRecommendations'] = array();
        foreach($this->carModelDetails as $detail) {
            $newData['tireSizeCarModelRecommendations'][] = $detail->attributes;
        }
        
        $masterLog->new_data = json_encode($newData);

        $masterLog->save();
    }
}