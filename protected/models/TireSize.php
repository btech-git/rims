<?php

/**
 * This is the model class for table "{{tire_size}}".
 *
 * The followings are the available columns in table '{{tire_size}}':
 * @property integer $id
 * @property string $section_width
 * @property string $aspect_ratio
 * @property string $construction_type
 * @property string $rim_diameter
 * @property string $load_rating
 * @property string $speed_rating
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
 * @property Product[] $products
 * @property UserIdCreated $userIdCreated
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdApproved $userIdApproved
 * @property UserIdRejected $userIdRejected
 * @property UserIdDeleted $userIdDeleted
 */
class TireSize extends CActiveRecord {

    public function tableName() {
        return '{{tire_size}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('section_width, aspect_ratio, construction_type, rim_diameter', 'required'),
            array('user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved', 'numerical', 'integerOnly' => true),
            array('section_width, aspect_ratio, construction_type, rim_diameter, load_rating, speed_rating', 'length', 'max' => 20),
            array('approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, section_width, aspect_ratio, construction_type, rim_diameter, load_rating, speed_rating, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products' => array(self::HAS_MANY, 'Product', 'tire_size_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdApproved' => array(self::BELONGS_TO, 'Users', 'user_id_approved'),
            'userIdRejected' => array(self::BELONGS_TO, 'Users', 'user_id_rejected'),
            'userIdDeleted' => array(self::BELONGS_TO, 'Users', 'user_id_deleted'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'section_width' => 'Section Width',
            'aspect_ratio' => 'Aspect Ratio',
            'construction_type' => 'Construction Type',
            'rim_diameter' => 'Rim Diameter',
            'load_rating' => 'Load Rating',
            'speed_rating' => 'Speed Rating',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('section_width', $this->section_width, true);
        $criteria->compare('aspect_ratio', $this->aspect_ratio, true);
        $criteria->compare('construction_type', $this->construction_type, true);
        $criteria->compare('rim_diameter', $this->rim_diameter, true);
        $criteria->compare('load_rating', $this->load_rating, true);
        $criteria->compare('speed_rating', $this->speed_rating, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTireName() {
        
        return $this->section_width . ' ' . $this->aspect_ratio . ' ' . $this->construction_type . ' ' . $this->rim_diameter . ' ' . $this->load_rating . ' ' . $this->speed_rating;
    }
}
