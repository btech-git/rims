<?php

/**
 * This is the model class for table "{{inspection_sections}}".
 *
 * The followings are the available columns in table '{{inspection_sections}}':
 * @property integer $id
 * @property integer $inspection_id
 * @property integer $section_id
 *
 * The followings are the available model relations:
 * @property Inspection $inspection
 * @property InspectionSection $section
 */
class InspectionSections extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{inspection_sections}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('inspection_id, section_id', 'required'),
            array('inspection_id, section_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, inspection_id, section_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'inspection' => array(self::BELONGS_TO, 'Inspection', 'inspection_id'),
            'section' => array(self::BELONGS_TO, 'InspectionSection', 'section_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'inspection_id' => 'Inspection',
            'section_id' => 'Section',
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
        $criteria->compare('inspection_id', $this->inspection_id);
        $criteria->compare('section_id', $this->section_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InspectionSections the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
