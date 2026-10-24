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
 * @property Users $userIdApproved
 * @property Users $userIdCreated
 * @property Users $userIdDeleted
 * @property Users $userIdRejected
 * @property Users $userIdUpdated
 * @property TireSizeCarModelRecommendation[] $tireSizeCarModelRecommendations
 * @property TireSizeEconomicOption[] $tireSizeEconomicOptions
 * @property TireSizePremiumOption[] $tireSizePremiumOptions
 * @property TireSizeStandardOption[] $tireSizeStandardOptions
 */
class TireSize extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{tire_size}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('section_width, construction_type, rim_diameter', 'required'),
            array('is_approved, is_deleted, user_id_created, user_id_updated, user_id_approved, user_id_rejected, user_id_deleted', 'numerical', 'integerOnly' => true),
            array('section_width, aspect_ratio, construction_type, rim_diameter, load_rating, speed_rating', 'length', 'max' => 20),
            array('created_datetime, updated_datetime, approved_datetime, rejected_datetime, deleted_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, section_width, aspect_ratio, construction_type, rim_diameter, load_rating, speed_rating, is_approved, is_deleted, user_id_created, user_id_updated, user_id_approved, user_id_rejected, user_id_deleted, created_datetime, updated_datetime, approved_datetime, rejected_datetime, deleted_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products' => array(self::HAS_MANY, 'Product', 'tire_size_id'),
            'userIdApproved' => array(self::BELONGS_TO, 'Users', 'user_id_approved'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdDeleted' => array(self::BELONGS_TO, 'Users', 'user_id_deleted'),
            'userIdRejected' => array(self::BELONGS_TO, 'Users', 'user_id_rejected'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'tireSizeCarModelRecommendations' => array(self::HAS_MANY, 'TireSizeCarModelRecommendation', 'tire_size_id'),
            'tireSizeEconomicOptions' => array(self::HAS_MANY, 'TireSizeEconomicOption', 'tire_size_id'),
            'tireSizePremiumOptions' => array(self::HAS_MANY, 'TireSizePremiumOption', 'tire_size_id'),
            'tireSizeStandardOptions' => array(self::HAS_MANY, 'TireSizeStandardOption', 'tire_size_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'section_width' => 'Section Width',
            'aspect_ratio' => 'Aspect Ratio',
            'construction_type' => 'Construction Type',
            'rim_diameter' => 'Rim Diameter',
            'load_rating' => 'Load Rating',
            'speed_rating' => 'Speed Rating',
            'is_approved' => 'Is Approved',
            'is_deleted' => 'Is Deleted',
            'user_id_created' => 'User Id Created',
            'user_id_updated' => 'User Id Updated',
            'user_id_approved' => 'User Id Approved',
            'user_id_rejected' => 'User Id Rejected',
            'user_id_deleted' => 'User Id Deleted',
            'created_datetime' => 'Created Datetime',
            'updated_datetime' => 'Updated Datetime',
            'approved_datetime' => 'Approved Datetime',
            'rejected_datetime' => 'Rejected Datetime',
            'deleted_datetime' => 'Deleted Datetime',
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
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('user_id_updated', $this->user_id_updated);
        $criteria->compare('user_id_approved', $this->user_id_approved);
        $criteria->compare('user_id_rejected', $this->user_id_rejected);
        $criteria->compare('user_id_deleted', $this->user_id_deleted);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('approved_datetime', $this->approved_datetime, true);
        $criteria->compare('rejected_datetime', $this->rejected_datetime, true);
        $criteria->compare('deleted_datetime', $this->deleted_datetime, true);

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
