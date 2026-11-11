<?php

/**
 * This is the model class for table "{{technical_report_header}}".
 *
 * The followings are the available columns in table '{{technical_report_header}}':
 * @property integer $id
 * @property string $document_number
 * @property string $report_version
 * @property string $date_effective
 * @property string $dealer_name
 * @property string $dealer_code
 * @property integer $province_id
 * @property string $warranty_claim_number
 * @property string $warranty_start_date
 * @property string $repair_date
 * @property string $main_part_name
 * @property string $main_part_number
 * @property string $report_issue
 * @property string $failure_phenomenon
 * @property string $failure_symptom_video
 * @property string $after_repair_video
 * @property integer $user_id_created
 * @property string $created_datetime
 * @property integer $user_id_updated
 * @property string $updated_datetime
 * @property integer $registration_product_id
 *
 * The followings are the available model relations:
 * @property TechnicalReportFailedPartPhoto[] $technicalReportFailedPartPhotos
 * @property TechnicalReportFailedPartSerialNumberPhoto[] $technicalReportFailedPartSerialNumberPhotos
 * @property RegistrationProduct $registrationProduct
 * @property Province $province
 * @property Users $userIdCreated
 * @property Users $userIdUpdated
 * @property TechnicalReportNewPartPhoto[] $technicalReportNewPartPhotos
 * @property TechnicalReportOdometerPhoto[] $technicalReportOdometerPhotos
 */
class TechnicalReportHeader extends CActiveRecord {

    public $failedPartImages;
    public $failedPartSerialNumberImages;
    public $newPartImages;
    public $odometerImages;
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{technical_report_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('document_number, report_version, date_effective, dealer_name, dealer_code, province_id, warranty_claim_number, warranty_start_date, repair_date, main_part_name, main_part_number, user_id_created, created_datetime, registration_product_id', 'required'),
            array('province_id, user_id_created, user_id_updated, registration_product_id', 'numerical', 'integerOnly' => true),
            array('document_number, warranty_claim_number', 'length', 'max' => 60),
            array('report_version, dealer_code, main_part_number', 'length', 'max' => 20),
            array('dealer_name, main_part_name, failure_symptom_video, after_repair_video', 'length', 'max' => 100),
            array('failedPartImages, failedPartSerialNumberImages, newPartImages, odometerImages', 'file', 'types'=>'jpg, jpeg, png, pdf', 'allowEmpty'=>true, 'maxSize'=>1024*1024*11, 'tooLarge'=>'File must be less than 10MB', 'safe' => false),
            array('report_issue, failure_phenomenon, updated_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, document_number, report_version, date_effective, dealer_name, dealer_code, province_id, warranty_claim_number, warranty_start_date, repair_date, main_part_name, main_part_number, report_issue, failure_phenomenon, failure_symptom_video, after_repair_video, user_id_created, created_datetime, user_id_updated, updated_datetime, registration_product_id, failedPartImages, failedPartSerialNumberImages, newPartImages, odometerImages', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'technicalReportFailedPartPhotos' => array(self::HAS_MANY, 'TechnicalReportFailedPartPhoto', 'technical_report_header_id'),
            'technicalReportFailedPartSerialNumberPhotos' => array(self::HAS_MANY, 'TechnicalReportFailedPartSerialNumberPhoto', 'technical_report_header_id'),
            'registrationProduct' => array(self::BELONGS_TO, 'RegistrationProduct', 'registration_product_id'),
            'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'technicalReportNewPartPhotos' => array(self::HAS_MANY, 'TechnicalReportNewPartPhoto', 'technical_report_header_id'),
            'technicalReportOdometerPhotos' => array(self::HAS_MANY, 'TechnicalReportOdometerPhoto', 'technical_report_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'document_number' => 'Document Number',
            'report_version' => 'Report Version',
            'date_effective' => 'Date Effective',
            'dealer_name' => 'Dealer Name',
            'dealer_code' => 'Dealer Code',
            'province_id' => 'Province',
            'warranty_claim_number' => 'Warranty Claim Number',
            'warranty_start_date' => 'Warranty Start Date',
            'repair_date' => 'Repair Date',
            'main_part_name' => 'Main Part Name',
            'main_part_number' => 'Main Part Number',
            'report_issue' => 'Report Issue',
            'failure_phenomenon' => 'Failure Phenomenon',
            'failure_symptom_video' => 'Failure Symptom Video',
            'after_repair_video' => 'After Repair Video',
            'user_id_created' => 'User Id Created',
            'created_datetime' => 'Created Datetime',
            'user_id_updated' => 'User Id Updated',
            'updated_datetime' => 'Updated Datetime',
            'registration_product_id' => 'Registration Product',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('document_number', $this->document_number, true);
        $criteria->compare('report_version', $this->report_version, true);
        $criteria->compare('date_effective', $this->date_effective, true);
        $criteria->compare('dealer_name', $this->dealer_name, true);
        $criteria->compare('dealer_code', $this->dealer_code, true);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('warranty_claim_number', $this->warranty_claim_number, true);
        $criteria->compare('warranty_start_date', $this->warranty_start_date, true);
        $criteria->compare('repair_date', $this->repair_date, true);
        $criteria->compare('main_part_name', $this->main_part_name, true);
        $criteria->compare('main_part_number', $this->main_part_number, true);
        $criteria->compare('report_issue', $this->report_issue, true);
        $criteria->compare('failure_phenomenon', $this->failure_phenomenon, true);
        $criteria->compare('failure_symptom_video', $this->failure_symptom_video, true);
        $criteria->compare('after_repair_video', $this->after_repair_video, true);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('user_id_updated', $this->user_id_updated);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('registration_product_id', $this->registration_product_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}