<?php

/**
 * This is the model class for table "{{employee_exchange_dayoff}}".
 *
 * The followings are the available columns in table '{{employee_exchange_dayoff}}':
 * @property integer $id
 * @property string $date_dayoff_old
 * @property string $date_dayoff_new
 * @property integer $employee_id
 *
 * The followings are the available model relations:
 * @property Employee $employee
 */
class EmployeeExchangeDayoff extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee_exchange_dayoff}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_dayoff_old, date_dayoff_new, employee_id', 'required'),
            array('employee_id', 'numerical', 'integerOnly' => true),
            array('date_dayoff_new', 'differentDayOff'),
            array('date_dayoff_old', 'compositeUniqueDayoffOld'),
            array('date_dayoff_new', 'compositeUniqueDayoffNew'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, date_dayoff_old, date_dayoff_new, employee_id', 'safe', 'on' => 'search'),
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
            'date_dayoff_old' => 'Date Dayoff Old',
            'date_dayoff_new' => 'Date Dayoff New',
            'employee_id' => 'Employee',
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
        $criteria->compare('date_dayoff_old', $this->date_dayoff_old, true);
        $criteria->compare('date_dayoff_new', $this->date_dayoff_new, true);
        $criteria->compare('employee_id', $this->employee_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EmployeeExchangeDayoff the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function differentDayOff($attribute, $params) {
        $employee = Employee::model()->findByPk($this->employee_id);
        if ($employee !== null) {
            $dayNames = array(
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu',
            );
            
            $dayName = date('l', strtotime($this->date_dayoff_new));
            
            if ($employee->off_day == $dayNames[$dayName]) {
                $this->addError($attribute, 'Hari libur yang dipilih sama dengan hari libur mingguan.');
            }
        }
    }

    public function compositeUniqueDayoffOld($attribute, $params) {
        $exists = self::model()->exists(array(
            'condition' => 'date_dayoff_old = :date_dayoff_old AND employee_id = :employee_id',
            'params' => array(
                ':date_dayoff_old' => $this->date_dayoff_old, 
                ':employee_id' => $this->employee_id,
            ),
        ));
        if ($exists) {
            $this->addError($attribute, 'Hari libur mingguan sudah terdaftar.');
        }
    }

    public function compositeUniqueDayoffNew($attribute, $params) {
        $exists = self::model()->exists(array(
            'condition' => 'date_dayoff_new = :date_dayoff_new AND employee_id = :employee_id',
            'params' => array(
                ':date_dayoff_new' => $this->date_dayoff_new, 
                ':employee_id' => $this->employee_id,
            ),
        ));
        if ($exists) {
            $this->addError($attribute, 'Hari libur yang dipilih sudah terdaftar.');
        }
    }
}
