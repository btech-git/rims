<?php

/**
 * This is the model class for table "{{tire_size}}".
 *
 * The followings are the available columns in table '{{tire_size}}':
 * @property integer $id
 * @property string $section_width
 * @property string $aspect_ratio
 * @property string $construction_type
 * @property string $rim_diameter
 * @property string $load_rating
 * @property string $speed_rating
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class TireSize extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{tire_size}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('section_width, aspect_ratio, construction_type, rim_diameter', 'required'),
            array('section_width, aspect_ratio, construction_type, rim_diameter, load_rating, speed_rating', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, section_width, aspect_ratio, construction_type, rim_diameter, load_rating, speed_rating', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products' => array(self::HAS_MANY, 'Product', 'tire_size_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'section_width' => 'Section Width',
            'aspect_ratio' => 'Aspect Ratio',
            'construction_type' => 'Construction Type',
            'rim_diameter' => 'Rim Diameter',
            'load_rating' => 'Load Rating',
            'speed_rating' => 'Speed Rating',
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
        $criteria->compare('section_width', $this->section_width, true);
        $criteria->compare('aspect_ratio', $this->aspect_ratio, true);
        $criteria->compare('construction_type', $this->construction_type, true);
        $criteria->compare('rim_diameter', $this->rim_diameter, true);
        $criteria->compare('load_rating', $this->load_rating, true);
        $criteria->compare('speed_rating', $this->speed_rating, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TireSize the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
