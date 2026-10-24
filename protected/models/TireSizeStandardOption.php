<?php

/**
 * This is the model class for table "{{tire_size_standard_option}}".
 *
 * The followings are the available columns in table '{{tire_size_standard_option}}':
 * @property integer $id
 * @property integer $tire_size_id
 * @property integer $sub_brand_series_id
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property TireSize $tireSize
 * @property SubBrandSeries $subBrandSeries
 */
class TireSizeStandardOption extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{tire_size_standard_option}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tire_size_id, sub_brand_series_id', 'required'),
            array('tire_size_id, sub_brand_series_id, is_inactive', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, tire_size_id, sub_brand_series_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tireSize' => array(self::BELONGS_TO, 'TireSize', 'tire_size_id'),
            'subBrandSeries' => array(self::BELONGS_TO, 'SubBrandSeries', 'sub_brand_series_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'tire_size_id' => 'Tire Size',
            'sub_brand_series_id' => 'Sub Brand Series',
            'is_inactive' => 'Is Inactive',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('tire_size_id', $this->tire_size_id);
        $criteria->compare('sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TireSizeStandardOption the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
