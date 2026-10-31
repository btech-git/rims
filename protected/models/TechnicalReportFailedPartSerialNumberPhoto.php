<?php
class TechnicalReportFailedPartSerialNumberPhoto extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{technical_report_failed_part_serial_number_photo}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('extension, filename, technical_report_header_id', 'required'),
            array('technical_report_header_id', 'numerical', 'integerOnly' => true),
            array('extension', 'length', 'max' => 5),
            array('filename', 'length', 'max' => 60),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, extension, filename, technical_report_header_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'technicalReportHeader' => array(self::BELONGS_TO, 'TechnicalReportHeader', 'technical_report_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'extension' => 'Extension',
            'filename' => 'Filename',
            'technical_report_header_id' => 'Technical Report Header',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('extension', $this->extension, true);
        $criteria->compare('filename', $this->filename, true);
        $criteria->compare('technical_report_header_id', $this->technical_report_header_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getFullFilename() {
        return $this->id . '-' . $this->filename;
    }
}