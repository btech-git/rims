<?php

/**
 * This is the model class for table "{{unit}}".
 *
 * The followings are the available columns in table '{{unit}}':
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $is_approved
 * @property integer $is_deleted
 * @property integer $user_id_created
 * @property integer $user_id_updated
 * @property integer $user_id_approved
 * @property integer $user_id_rejected
 * @property integer $user_id_deleted
 * @property string $created_datetime
 * @property string $updated_datetime
 * @property string $approved_datetime
 * @property string $rejected_datetime
 * @property string $deleted_datetime
 *
 * The followings are the available model relations:
 * @property ProductUnit[] $productUnits
 * @property UnitConversion[] $unitConversions
 * @property UnitConversion[] $unitConversions1
 * @property UserIdCreated $userIdCreated
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdApproved $userIdApproved
 * @property UserIdRejected $userIdRejected
 * @property UserIdDeleted $userIdDeleted
 */
class Unit extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{unit}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, status', 'required'),
            array('user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 30),
            array('status', 'length', 'max' => 10),
            array('approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, status, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productUnits' => array(self::HAS_MANY, 'ProductUnit', 'unit_id'),
            'unitConversions' => array(self::HAS_MANY, 'UnitConversion', 'unit_from_id'),
            'unitConversions1' => array(self::HAS_MANY, 'UnitConversion', 'unit_to_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdApproved' => array(self::BELONGS_TO, 'Users', 'user_id_approved'),
            'userIdRejected' => array(self::BELONGS_TO, 'Users', 'user_id_rejected'),
            'userIdDeleted' => array(self::BELONGS_TO, 'Users', 'user_id_deleted'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Unit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getUnitConversionName() {
        $unitConversion = UnitConversion::model()->findByAttributes(array('unit_from_id' => $this->id));
        
        return $unitConversion->unitTo->name;
    }

    public function getUnitConversionMultiplier() {
        $unitConversion = UnitConversion::model()->findByAttributes(array('unit_from_id' => $this->id));
        
        return $unitConversion->multiplier;
    }
}
