<?php

/**
 * This is the model class for table "{{vehicle_plate_number_prefix}}".
 *
 * The followings are the available columns in table '{{vehicle_plate_number_prefix}}':
 * @property integer $id
 * @property string $code
 * @property string $area
 */
class VehiclePlateNumberPrefix extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return VehiclePlateNumberPrefix the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{vehicle_plate_number_prefix}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code', 'required'),
            array('code', 'length', 'max' => 10),
            array('area', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, code, area', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'vehicles' => array(self::HAS_MANY, 'Vehicle', 'plate_number_prefix_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'area' => 'Area',
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('area', $this->area, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
