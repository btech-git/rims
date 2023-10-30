<?php

/**
 * This is the model class for table "{{employee_timesheet}}".
 *
 * The followings are the available columns in table '{{employee_timesheet}}':
 * @property integer $id
 * @property string $date
 * @property string $clock_in
 * @property string $clock_out
 * @property string $duration_late
 * @property string $duration_work
 * @property integer $employee_id
 * @property integer $employee_onleave_category_id
 *
 * The followings are the available model relations:
 * @property Employee $employee
 */
class EmployeeTimesheet extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmployeeTimesheet the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee_timesheet}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, clock_in, employee_id, duration_late, duration_work,employee_onleave_category_id', 'required'),
            array('employee_id, employee_onleave_category_id', 'numerical', 'integerOnly' => true),
            array('duration_late, duration_work', 'length', 'max' => 18),
            array('clock_out', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, clock_in, clock_out, employee_id, duration_late, duration_work, employee_onleave_category_id', 'safe', 'on' => 'search'),
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
            'employeeOnleaveCategory' => array(self::BELONGS_TO, 'EmployeeOnleaveCategory', 'employee_onleave_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date' => 'Tanggal',
            'clock_in' => 'Jam Masuk',
            'clock_out' => 'Jam Keluar',
            'employee_id' => 'Employee',
            'duration_late' => 'Durasi Telat',
            'duration_work' => 'Durasi Kerja',
            'employee_onleave_category_id' => 'Status',
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('clock_in', $this->clock_in, true);
        $criteria->compare('clock_out', $this->clock_out, true);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('duration_late', $this->clock_in, true);
        $criteria->compare('duration_work', $this->clock_out, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getLateTimeDiff() {
        $durationLate = $this->duration_late;
        $hours = $durationLate > 0 ? floor($durationLate / 3600) : 00;
        $minutes = $durationLate > 0 ? floor(($durationLate % 3600) / 60) : 00;
        $seconds = $durationLate > 0 ? $durationLate % 60 : 00;

        return str_pad($hours, 2, '0', STR_PAD_LEFT). ":" . str_pad($minutes, 2, '0', STR_PAD_LEFT). ":" . str_pad($seconds, 2, '0', STR_PAD_LEFT);
    }
    
    public function getWorkTimeDiff() {
        $durationWork = $this->duration_work;
        $hours = $durationWork > 0 ? floor($durationWork / 3600) : 00;
        $minutes = $durationWork > 0 ? floor(($durationWork % 3600) / 60) : 00;
        $seconds = $durationWork > 0 ? $durationWork % 60 : 00;

        return str_pad($hours, 2, '0', STR_PAD_LEFT). ":" . str_pad($minutes, 2, '0', STR_PAD_LEFT). ":" . str_pad($seconds, 2, '0', STR_PAD_LEFT);
    }
}
