<?php

class Insurances extends CComponent {

    public $header;
    public $priceDetails;

    public function __construct($header, array $priceDetails) {
        $this->header = $header;
        $this->priceDetails = $priceDetails;
    }

    public function addPriceDetail($serviceId) {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
        $priceDetail = new InsuranceCompanyPricelist();
        $priceDetail->service_id = $serviceId;
        $serviceData = Service::model()->findByPk($priceDetail->service_id);
        $priceDetail->service_name = $serviceData->name;
        $this->priceDetails[] = $priceDetail;

    }

    public function removePriceDetailAt($index) {
        array_splice($this->priceDetails, $index, 1);
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

        if (count($this->priceDetails) > 0) {
            foreach ($this->priceDetails as $priceDetail) {

                $fields = array('price');
                $valid = $priceDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->priceDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {

        if ($this->header->isNewRecord) {
            $existingCoa = Coa::model()->findByAttributes(array('coa_sub_category_id' => 8, 'coa_id' => null), array('order' => 'id DESC'));
            $ordinal = substr($existingCoa->code, -3);
            $newOrdinal = $ordinal + 1;

            $coa = new Coa;
            $coa->name = 'Piutang ' . $this->header->name;
            $coa->code = '121.00.' . sprintf('%03d', $newOrdinal);
            $coa->coa_category_id = 1;
            $coa->coa_sub_category_id = 8;
            $coa->coa_id = null;
            $coa->normal_balance = 'DEBIT';
            $coa->cash_transaction = 'NO';
            $coa->opening_balance = 0.00;
            $coa->closing_balance = 0.00;
            $coa->debit = 0.00;
            $coa->credit = 0.00;
            $coa->status = 'Approved';
            $coa->date = date('Y-m-d');
            $coa->date_approval = date('Y-m-d');
            $coa->time_created = date('H:i:s');
            $coa->time_approval = date('H:i:s');
            $coa->is_approved = 1;
            $coa->user_id = Yii::app()->user->id;
            $coa->user_id_approval = Yii::app()->user->id;
            $coa->save();
            $this->saveMasterCoaLog($coa);

            $this->header->coa_id = $coa->id;
        }
        
        $valid = $this->header->save();
        $this->saveMasterLog();

        $service_pricelists = InsuranceCompanyPricelist::model()->findAllByAttributes(array('insurance_company_id' => $this->header->id));
        $price_id = array();
        foreach ($service_pricelists as $service_pricelist) {
            $price_id[] = $service_pricelist->id;
        }
        $new_detail_price = array();

        //save pricelist
        foreach ($this->priceDetails as $priceDetail) {
            $priceDetail->insurance_company_id = $this->header->id;

            $valid = $priceDetail->save(false) && $valid;
            $new_detail_price[] = $priceDetail->id;
        }
        
        //delete pricelist
        $delete_array_price = array_diff($price_id, $new_detail_price);
        if ($delete_array_price != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array_price);
            InsuranceCompanyPricelist::model()->deleteAll($criteria);
        }
        return $valid;
    }
    
    public function saveMasterLog() {
        $masterLog = new MasterLog();
        $masterLog->name = $this->header->name;
        $masterLog->log_date = date('Y-m-d');
        $masterLog->log_time = date('H:i:s');
        $masterLog->table_name = $this->header->tableName();
        $masterLog->table_id = $this->header->id;
        $masterLog->user_id = Yii::app()->user->id;
        $masterLog->username = Yii::app()->user->username;
        $masterLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $masterLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $this->header->attributes;
        $masterLog->new_data = json_encode($newData);

        $masterLog->save();
    }
    
    public function saveMasterCoaLog($model) {
        $masterLog = new MasterLog();
        $masterLog->name = $model->name;
        $masterLog->log_date = date('Y-m-d');
        $masterLog->log_time = date('H:i:s');
        $masterLog->table_name = $model->tableName();
        $masterLog->table_id = $model->id;
        $masterLog->user_id = Yii::app()->user->id;
        $masterLog->username = Yii::app()->user->username;
        $masterLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $masterLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $model->attributes;
        $masterLog->new_data = json_encode($newData);

        $masterLog->save();
    }
}
