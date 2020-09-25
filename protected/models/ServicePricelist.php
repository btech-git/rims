<?php

/**
 * This is the model class for table "{{service_pricelist}}".
 *
 * The followings are the available columns in table '{{service_pricelist}}':
 * @property integer $id
 * @property integer $service_id
 * @property integer $service_group_id
 * @property string $standard_flat_rate_per_hour
 * @property string $flat_rate_hour
 * @property string $price
 *
 * The followings are the available model relations:
 * @property Service $service
 * @property ServiceGroup $serviceGroup
 */
class ServicePricelist extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ServicePricelist the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{service_pricelist}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('service_id, service_group_id', 'required'),
            array('service_id, service_group_id', 'numerical', 'integerOnly' => true),
            array('standard_flat_rate_per_hour, price, flat_rate_hour', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, service_id, service_group_id, standard_flat_rate_per_hour, flat_rate_hour, price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
            'serviceGroup' => array(self::BELONGS_TO, 'ServiceGroup', 'service_group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'service_id' => 'Service',
            'service_group_id' => 'Service Group',
            'standard_flat_rate_per_hour' => 'Standard Flat Rate Per Hour',
            'flat_rate_hour' => 'Flat Rate Hour',
            'price' => 'Price',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('service_group_id', $this->service_group_id);
        $criteria->compare('t.standard_flat_rate_per_hour', $this->standard_flat_rate_per_hour, true);
        $criteria->compare('t.flat_rate_hour', $this->flat_rate_hour);
        $criteria->compare('t.price', $this->price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
//            'sort' => array(
//                'defaultOrder' => 'service.name',
//                'attributes' => array(
//                    'car_make_code' => array(
//                        'asc' => 'carMake.name ASC',
//                        'desc' => 'carMake.name DESC',
//                    ),
//                    'service_category_code' => array(
//                        'asc' => 'serviceCategory.name ASC',
//                        'desc' => 'serviceCategory.name DESC',
//                    ),
//                    'service_type_code' => array(
//                        'asc' => 'serviceType.name ASC',
//                        'desc' => 'serviceType.name DESC',
//                    ),
//                    'car_model_code' => array(
//                        'asc' => 'carModel.name ASC',
//                        'desc' => 'carModel.name DESC',
//                    ),
//                    'car_sub_detail_code' => array(
//                        'asc' => 'carSubDetail.name ASC',
//                        'desc' => 'carSubDetail.name DESC',
//                    ),
//                    'service_name' => array(
//                        'asc' => 'service.name ASC',
//                        'desc' => 'service.name DESC',
//                    ),
//                    'service_code' => array(
//                        'asc' => 'service.code ASC',
//                        'desc' => 'service.code DESC',
//                    ),
//                    '*',
//                ),
//            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
}
