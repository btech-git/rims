<?php

/**
 * This is the model class for table "{{vehicle_position_timer}}".
 *
 * The followings are the available columns in table '{{vehicle_position_timer}}':
 * @property integer $id
 * @property integer $vehicle_id
 * @property string $entry_date
 * @property string $entry_time
 * @property string $process_date
 * @property string $process_time
 * @property string $exit_date
 * @property string $exit_time
 * @property string $entry_note
 * @property string $process_note
 * @property string $exit_note
 *
 * The followings are the available model relations:
 * @property Vehicle $vehicle
 */
class VehiclePositionTimer extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{vehicle_position_timer}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('vehicle_id, entry_date, entry_time', 'required'),
            array('vehicle_id', 'numerical', 'integerOnly' => true),
            array('process_date, process_time, exit_date, exit_time, entry_note, process_note, exit_note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, vehicle_id, entry_date, entry_time, process_date, process_time, exit_date, exit_time, entry_note, process_note, exit_note', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'vehicle_id' => 'Vehicle',
            'entry_date' => 'Entry Date',
            'entry_time' => 'Entry Time',
            'process_date' => 'Process Date',
            'process_time' => 'Process Time',
            'exit_date' => 'Exit Date',
            'exit_time' => 'Exit Time',
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
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('entry_date', $this->entry_date, true);
        $criteria->compare('entry_time', $this->entry_time, true);
        $criteria->compare('process_date', $this->process_date, true);
        $criteria->compare('process_time', $this->process_time, true);
        $criteria->compare('exit_date', $this->exit_date, true);
        $criteria->compare('exit_time', $this->exit_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VehiclePositionTimer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
