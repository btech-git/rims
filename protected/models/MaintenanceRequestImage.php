<?php

/**
 * This is the model class for table "{{maintenance_request_image}}".
 *
 * The followings are the available columns in table '{{maintenance_request_image}}':
 * @property integer $id
 * @property string $extensions
 * @property integer $is_inactive
 * @property integer $maintenance_request_header_id
 *
 * The followings are the available model relations:
 * @property MaintenanceRequestHeader $maintenanceRequestHeader
 */
class MaintenanceRequestImage extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{maintenance_request_image}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('extensions, maintenance_request_header_id', 'required'),
            array('is_inactive, maintenance_request_header_id', 'numerical', 'integerOnly' => true),
            array('extensions', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, extensions, is_inactive, maintenance_request_header_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'maintenanceRequestHeader' => array(self::BELONGS_TO, 'MaintenanceRequestHeader', 'maintenance_request_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'extensions' => 'Extensions',
            'is_inactive' => 'Is Inactive',
            'maintenance_request_header_id' => 'Maintenance Request Header',
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
        $criteria->compare('extensions', $this->extensions, true);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('maintenance_request_header_id', $this->maintenance_request_header_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MaintenanceRequestImage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
