<?php

/**
 * This is the model class for table "{{component_inspection}}".
 *
 * The followings are the available columns in table '{{component_inspection}}':
 * @property integer $id
 * @property string $name
 * @property integer $component_inspection_group_id
 * @property integer $user_id_created
 * @property string $created_datetime
 * @property integer $user_id_edited
 * @property string $edited_datetime
 * @property integer $user_id_cancelled
 * @property string $cancelled_datetime
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Users $userIdCreated
 * @property Users $userIdEdited
 * @property Users $userIdCancelled
 * @property ComponentInspectionGroup $componentInspectionGroup
 * @property VehicleSystemCheckComponentDetail[] $vehicleSystemCheckComponentDetails
 */
class ComponentInspection extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{component_inspection}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, name, component_inspection_group_id, user_id_created, created_datetime, status', 'required'),
            array('id, component_inspection_group_id, user_id_created, user_id_edited, user_id_cancelled', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('status', 'length', 'max' => 20),
            array('edited_datetime, cancelled_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, component_inspection_group_id, user_id_created, created_datetime, user_id_edited, edited_datetime, user_id_cancelled, cancelled_datetime, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdEdited' => array(self::BELONGS_TO, 'Users', 'user_id_edited'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
            'componentInspectionGroup' => array(self::BELONGS_TO, 'ComponentInspectionGroup', 'component_inspection_group_id'),
            'vehicleSystemCheckComponentDetails' => array(self::HAS_MANY, 'VehicleSystemCheckComponentDetail', 'component_inspection_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'component_inspection_group_id' => 'Component Inspection Group',
            'user_id_created' => 'User Id Created',
            'created_datetime' => 'Created Datetime',
            'user_id_edited' => 'User Id Edited',
            'edited_datetime' => 'Edited Datetime',
            'user_id_cancelled' => 'User Id Cancelled',
            'cancelled_datetime' => 'Cancelled Datetime',
            'status' => 'Status',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('component_inspection_group_id', $this->component_inspection_group_id);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('user_id_edited', $this->user_id_edited);
        $criteria->compare('edited_datetime', $this->edited_datetime, true);
        $criteria->compare('user_id_cancelled', $this->user_id_cancelled);
        $criteria->compare('cancelled_datetime', $this->cancelled_datetime, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ComponentInspection the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
