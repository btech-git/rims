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

        $valid = $this->validateDetailsUnique() && $valid;

        foreach ($this->carModelDetails as $detail) {
            $fields = array('vehicle_car_model_id');
            $valid = $detail->validate($fields) && $valid;
        }

        foreach ($this->premiumOptionDetails as $detail) {
            $fields = array('sub_brand_series_id');
            $valid = $detail->validate($fields) && $valid;
        }

        foreach ($this->standardOptionDetails as $detail) {
            $fields = array('sub_brand_series_id');
            $valid = $detail->validate($fields) && $valid;
        }

        foreach ($this->economicOptionDetails as $detail) {
            $fields = array('sub_brand_series_id');
            $valid = $detail->validate($fields) && $valid;
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

        $standardOptionDetails = TireSizeStandardOption::model()->findAllByAttributes(array('tire_size_id' => $this->header->id));
        $standard_option_detail_id = array();
        foreach ($standardOptionDetails as $standardOptionDetail) {
            $standard_option_detail_id[] = $standardOptionDetail->id;
        }
        $new_standard_option_detail = array();

        $economicOptionDetails = TireSizeEconomicOption::model()->findAllByAttributes(array('tire_size_id' => $this->header->id));
        $economic_option_detail_id = array();
        foreach ($economicOptionDetails as $economicOptionDetail) {
            $economic_option_detail_id[] = $economicOptionDetail->id;
        }
        $new_economic_option_detail = array();

        $premiumOptionDetails = TireSizePremiumOption::model()->findAllByAttributes(array('tire_size_id' => $this->header->id));
        $premium_option_detail_id = array();
        foreach ($premiumOptionDetails as $premiumOptionDetail) {
            $premium_option_detail_id[] = $premiumOptionDetail->id;
        }
        $new_premium_option_detail = array();

        $carModelRecommendationDetails = TireSizeCarModelRecommendation::model()->findAllByAttributes(array('tire_size_id' => $this->header->id));
        $car_model_recommendation_detail_id = array();
        foreach ($carModelRecommendationDetails as $carModelRecommendationDetail) {
            $car_model_recommendation_detail_id[] = $carModelRecommendationDetail->id;
        }
        $new_car_model_recommendation_detail = array();

        foreach ($this->carModelDetails as $i => $detail) {
            if ($detail->isNewRecord) {
                $detail->tire_size_id = $this->header->id;
            }
            $valid = $detail->save(false) && $valid;
            $new_car_model_recommendation_detail[] = $detail->id;
        }
        
        foreach ($this->premiumOptionDetails as $i => $detail) {
            if ($detail->isNewRecord) {
                $detail->tire_size_id = $this->header->id;
            }
            $valid = $detail->save(false) && $valid;
            $new_premium_option_detail[] = $detail->id;
        }
        
        foreach ($this->standardOptionDetails as $i => $detail) {
            if ($detail->isNewRecord) {
                $detail->tire_size_id = $this->header->id;
            }
            $valid = $detail->save(false) && $valid;
            $new_standard_option_detail[] = $detail->id;
        }
        
        foreach ($this->economicOptionDetails as $i => $detail) {
            if ($detail->isNewRecord) {
                $detail->tire_size_id = $this->header->id;
            }
            $valid = $detail->save(false) && $valid;
            $new_economic_option_detail[] = $detail->id;
        }
        
        //delete details
        $delete_array_standard_option = array_diff($standard_option_detail_id, $new_standard_option_detail);
        if ($delete_array_standard_option != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array_standard_option);
            TireSizeStandardOption::model()->deleteAll($criteria);
        }

        $delete_array_economic_option = array_diff($economic_option_detail_id, $new_economic_option_detail);
        if ($delete_array_economic_option != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array_economic_option);
            TireSizeEconomicOption::model()->deleteAll($criteria);
        }

        $delete_array_premium_option = array_diff($premium_option_detail_id, $new_premium_option_detail);
        if ($delete_array_premium_option != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array_premium_option);
            TireSizePremiumOption::model()->deleteAll($criteria);
        }

        $delete_array_car_model_recommendation = array_diff($car_model_recommendation_detail_id, $new_car_model_recommendation_detail);
        if ($delete_array_car_model_recommendation != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array_car_model_recommendation);
            TireSizeCarModelRecommendation::model()->deleteAll($criteria);
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