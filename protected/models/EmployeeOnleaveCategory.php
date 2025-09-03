<?php

/**
 * This is the model class for table "{{employee_onleave_category}}".
 *
 * The followings are the available columns in table '{{employee_onleave_category}}':
 * @property integer $id
 * @property string $name
 * @property integer $number_of_days
 * @property integer $is_using_quota
 * @property integer $is_inactive
 * @property integer $is_onsite
 *
 * The followings are the available model relations:
 * @property EmployeeDayoff[] $employeeDayoffs
 */
class EmployeeOnleaveCategory extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmployeeOnleaveCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee_onleave_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('number_of_days, is_using_quota, is_inactive, is_onsite', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 60),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, number_of_days, is_using_quota, is_inactive, is_onsite', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'employeeDayoffs' => array(self::HAS_MANY, 'EmployeeDayoff', 'employee_onleave_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'number_of_days' => 'Number Of Days',
            'is_using_quota' => 'Is Using Quota',
            'is_inactive' => 'Inactive',
            'is_onsite' => 'On Site',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('number_of_days', $this->number_of_days);
        $criteria->compare('is_using_quota', $this->is_using_quota);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getNameAndDays() {
        return $this->name . ' - ' . $this->number_of_days . ' hari';
    }
}
