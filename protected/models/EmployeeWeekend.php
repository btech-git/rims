<?php

/**
 * This is the model class for table "{{employee_weekend}}".
 *
 * The followings are the available columns in table '{{employee_weekend}}':
 * @property integer $id
 * @property string $off_day
 * @property integer $employee_id
 *
 * The followings are the available model relations:
 * @property Employee $employee
 */
class EmployeeWeekend extends CActiveRecord {

    const WEEKEND_MONDAY = 1;
    const WEEKEND_TUESDAY = 2;
    const WEEKEND_WEDNESDAY = 3;
    const WEEKEND_THURSDAY = 4;
    const WEEKEND_FRIDAY = 5;
    const WEEKEND_SATURDAY = 6;
    const WEEKEND_SUNDAY = 7;
    const WEEKEND_MONDAY_LITERAL = 'Monday';
    const WEEKEND_TUESDAY_LITERAL = 'Tuesday';
    const WEEKEND_WEDNESDAY_LITERAL = 'Wednesday';
    const WEEKEND_THURSDAY_LITERAL = 'Thursday';
    const WEEKEND_FRIDAY_LITERAL = 'Friday';
    const WEEKEND_SATURDAY_LITERAL = 'Saturday';
    const WEEKEND_SUNDAY_LITERAL = 'Sunday';
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmployeeWeekend the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee_weekend}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('off_day, employee_id', 'required'),
            array('employee_id', 'numerical', 'integerOnly' => true),
            array('off_day', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, off_day, employee_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'off_day' => 'Off Day',
            'employee_id' => 'Employee',
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
        $criteria->compare('off_day', $this->off_day, true);
        $criteria->compare('employee_id', $this->employee_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'off_day ASC',
            ),
        ));
    }

    public function getWeekendOffday($type) {
        switch ($type) {
            case self::WEEKEND_MONDAY: return self::WEEKEND_MONDAY_LITERAL;
            case self::WEEKEND_TUESDAY: return self::WEEKEND_TUESDAY_LITERAL;
            case self::WEEKEND_WEDNESDAY: return self::WEEKEND_WEDNESDAY_LITERAL;
            case self::WEEKEND_THURSDAY: return self::WEEKEND_THURSDAY_LITERAL;
            case self::WEEKEND_FRIDAY: return self::WEEKEND_FRIDAY_LITERAL;
            case self::WEEKEND_SATURDAY: return self::WEEKEND_SATURDAY_LITERAL;
            case self::WEEKEND_SUNDAY: return self::WEEKEND_SUNDAY_LITERAL;
            default: return '';
        }
    }

}
