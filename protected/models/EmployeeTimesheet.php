<?php

/**
 * This is the model class for table "{{employee_timesheet}}".
 *
 * The followings are the available columns in table '{{employee_timesheet}}':
 * @property integer $id
 * @property string $date
 * @property string $clock_in
 * @property string $clock_out
 * @property integer $employee_id
 * @property string $duration_late
 * @property string $duration_work
 * @property string $remarks
 * @property integer $employee_onleave_category_id
 * @property string $duration_overtime
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property EmployeeOnleaveCategory $employeeOnleaveCategory
 * @property EmployeeTimesheetImages[] $employeeTimesheetImages
 */
class EmployeeTimesheet extends CActiveRecord {
    public $images;

    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

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
            array('date, clock_in, employee_id, employee_onleave_category_id', 'required'),
            array('employee_id, employee_onleave_category_id', 'numerical', 'integerOnly' => true),
            array('duration_late, duration_work, duration_overtime', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 50),
            array('clock_out', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, date, clock_in, clock_out, employee_id, duration_late, duration_work, remarks, employee_onleave_category_id, duration_overtime, images', 'safe', 'on' => 'search'),
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
            'employeeTimesheetImages' => array(self::HAS_MANY, 'EmployeeTimesheetImages', 'employee_timesheet_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date' => 'Date',
            'clock_in' => 'Clock In',
            'clock_out' => 'Clock Out',
            'employee_id' => 'Employee',
            'duration_late' => 'Duration Late',
            'duration_work' => 'Duration Work',
            'remarks' => 'Remarks',
            'employee_onleave_category_id' => 'Employee Onleave Category',
            'duration_overtime' => 'Duration Overtime',
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('clock_in', $this->clock_in, true);
        $criteria->compare('clock_out', $this->clock_out, true);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('duration_late', $this->duration_late, true);
        $criteria->compare('duration_work', $this->duration_work, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('employee_onleave_category_id', $this->employee_onleave_category_id);
        $criteria->compare('duration_overtime', $this->duration_overtime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EmployeeTimesheet the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByReport() {
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
        $criteria->compare('duration_overtime', $this->clock_out, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.date ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
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
    
    public static function getEmployeeYearlyAttendance($employeeId, $year) {
        
        $sql = "SELECT t.employee_onleave_category_id, MONTH(t.date) as month, MAX(c.name) AS category_name, COUNT(*) AS days, COUNT(CASE WHEN t.duration_late > 300 THEN 0 ELSE NULL END) as late_days
                FROM " . EmployeeTimesheet::model()->tableName() . " t 
                INNER JOIN " . EmployeeOnleaveCategory::model()->tableName() . " c ON c.id = t.employee_onleave_category_id
                WHERE t.employee_id = :employee_id AND YEAR(t.date) = :year
                GROUP BY t.employee_onleave_category_id, MONTH(t.date)
                ORDER BY t.employee_onleave_category_id ASC, month ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':employee_id' => $employeeId,
            ':year' => $year,
        ));

        return $resultSet;
    }
}
